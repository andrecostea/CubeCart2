<?php
/**
 * CubeCart v5
 * ========================================
 * CubeCart is a registered trade mark of Devellion Limited
 * Copyright Devellion Limited 2010. All rights reserved.
 * UK Private Limited Company No. 5323904
 * ========================================
 * Web:			http://www.cubecart.com
 * Email:		sales@devellion.com
 * License:		http://www.cubecart.com/v5-software-license
 * ========================================
 * CubeCart is NOT Open Source.
 * Unauthorized reproduction is not allowed.
 */

class FileManager {
	private $_directories;
	private $_mode;

	private $_manage_cache;
	private $_manage_dir;
	private $_manage_root;
	private $_sub_dir;

	private $_sendfile	= false;

	const FM_FILETYPE_IMG	= 1;
	const FM_FILETYPE_DL	= 2;

	public function __construct($mode = false, $sub_dir = false) {
		// Define some constants
		if (!defined('FM_DL_ERROR_EXPIRED'))	define('FM_DL_ERROR_EXPIRED', 1);
		if (!defined('FM_DL_ERROR_MAXDL'))		define('FM_DL_ERROR_MAXDL', 2);
		if (!defined('FM_DL_ERROR_NOFILE'))		define('FM_DL_ERROR_NOFILE', 3);
		if (!defined('FM_DL_ERROR_NOPRODUCT'))	define('FM_DL_ERROR_NOPRODUCT', 4);
		if (!defined('FM_DL_ERROR_NORECORD'))	define('FM_DL_ERROR_NORECORD', 5);
		if (!defined('FM_DL_ERROR_PAYMENT'))	define('FM_DL_ERROR_PAYMENT', 6);

		switch ($mode) {
			case self::FM_FILETYPE_DL:
				$this->_manage_root = ($GLOBALS['config']->has('config', 'download_custom_path') && file_exists($GLOBALS['config']->get('config', 'download_custom_path'))) ? $GLOBALS['config']->get('config', 'download_custom_path') : CC_ROOT_DIR.CC_DS.'files';
			break;
			case self::FM_FILETYPE_IMG:
			default:
				$mode = 1;
				$this->_manage_root	= CC_ROOT_DIR.CC_DS.'images'.CC_DS.'source';
				$this->_manage_cache = CC_ROOT_DIR.CC_DS.'images'.CC_DS.'cache';
		}
		$this->_mode		= (int)$mode;
		$this->_manage_dir	= str_replace(CC_ROOT_DIR.CC_DS, '', $this->_manage_root);
		$this->_sub_dir		= ($sub_dir) ? $this->formatPath($sub_dir) : null;

		//Auto-handler: Create Directory
		if (isset($_POST['fm']['create-dir']) && !empty($_POST['fm']['create-dir'])) {
			$create	= $this->createDirectory($_POST['fm']['create-dir']);
		}
		// Auto-handler: image details & cropping
		if (isset($_POST['file_id']) && is_numeric($_POST['file_id'])) {
			if (($file = $GLOBALS['db']->select('CubeCart_filemanager', false, array('file_id' => (int)$_POST['file_id']))) !== false) {
				if (isset($_POST['details'])) {
					
					if(!$this->filename_is_illegal($_POST['details']['filename'])) {
					
						// Update details
						$new_location	= $current_location = $this->_manage_root.CC_DS.urldecode($this->_sub_dir);
						$new_filename	= $current_filename = $file[0]['filename'];
						$new_subdir		= $this->_sub_dir;
	
						if ($file[0]['filename'] != $_POST['details']['filename']) {
							$new_filename = $this->formatName($_POST['details']['filename']);
						}
						if (isset($_POST['details']['move']) && !empty($_POST['details']['move'])) {
							$move_to = $this->_manage_root.CC_DS.$this->formatPath($_POST['details']['move']);
							if (is_dir($move_to)) {
								$new_location	= $move_to;
								$new_subdir		= $this->formatPath(str_replace($this->_manage_root, '', $new_location), false);
							}
						}
						// Does it need moving?
						if ($new_location != $current_location || $new_filename != $current_filename) {
							if (file_exists($current_location.$current_filename) && rename($current_location.$current_filename, $new_location.$new_filename)) {
								$this->_sub_dir		= $new_subdir;
								$current_location	= $new_location;
								$current_filename	= $new_filename;
								// Database record
								$record['filename']	= $new_filename;
								$record['filepath']	= $this->formatPath($this->_sub_dir);
								$record['filepath']	= ($this->_sub_dir == null) ? 'NULL' : $this->formatPath($this->_sub_dir);
							} else {
								$GLOBALS['gui']->setError($GLOBALS['language']->filemanager['error_file_moved']);
							}
						}
						$record['description']	= strip_tags($_POST['details']['description']);
	
						$update = false;
						foreach ($record as $k => $v) {
							if (!isset($file[0][$k]) || $file[0][$k] != $v) {
								$update = true;
							}
						}
						if ($update) {
							if (!$GLOBALS['db']->update('CubeCart_filemanager', $record, array('file_id' => (int)$_POST['file_id']))) {
								$GLOBALS['gui']->setError($GLOBALS['language']->filemanager['error_file_update']);
							}
						}
					} else {
						$GLOBALS['gui']->setError($GLOBALS['language']->filemanager['error_file_update']);
					}
				}
				if (isset($_POST['resize']) && !empty($_POST['resize']['w']) && !empty($_POST['resize']['h'])) {
					$resize	= $_POST['resize'];
					if (file_exists($this->_manage_root.CC_DS.$this->_sub_dir.$current_filename)) {
						// Use Hi-res image
						$source	= $this->_manage_root.CC_DS.$this->_sub_dir.$current_filename;
						$size	= getimagesize($source);
						$gd		= new GD(dirname($source), false, 100);
						$gd->gdLoadFile($source);
						#	TO DO: ROTATION
						$gd->gdCrop((int)$resize['x'], (int)$resize['y'], (int)$resize['w'], (int)$resize['h']);
						if ($gd->gdSave(basename($source))) {
							// Delete previously generated images
							preg_match('#(\w+)(\.\w+)$#', $current_filename, $match);
							if (($files = glob($current_location.$match[1].'*', GLOB_NOSORT)) !== false) {
								foreach ($files as $file) {
									if ($file != $source) {
										unlink ($file);
									}
								}
							}
							$GLOBALS['gui']->setNotify($GLOBALS['language']->filemanager['notify_image_update']);
						} else {
							$GLOBALS['gui']->setError($GLOBALS['language']->filemanager['error_image_update']);
						}
					}
				}
				httpredir(currentPage(null, array('subdir' => $this->formatPath($this->_sub_dir, false))));
			}
		}
		// Create a directory list
		$this->findDirectories($this->_manage_root);
	}

	/**
	 * Setup admin screen
	 *
	 * @param bool $select_button
	 * @return bool
	 */
	public function admin($select_button = false) {
		$this->listFiles(false, $select_button);
		if (isset($_GET['CKEditorFuncNum'])) {
			$GLOBALS['smarty']->assign('CK_FUNC_NUM', (int)$_GET['CKEditorFuncNum']);
		}

		$GLOBALS['smarty']->assign('mode_list', true);

		return $GLOBALS['smarty']->fetch('templates/filemanager.index.php');
	}

	/**
	 * Build image DB
	 *
	 * @param bool $purge
	 * @param bool $tidy
	 * @param string $dir
	 *
	 * @return bool
	 */
	public function buildDatabase($purge = false, $tidy = false, $dir = '') {
		$dir = (!empty($dir)) ? $dir : $this->_manage_root.CC_DS.$this->_sub_dir;
		findFiles($file_array, $dir);
		if (($existing = $GLOBALS['db']->select('CubeCart_filemanager', array('filename', 'filepath'), false, array('filename' => 'ASC'))) !== false) {
			foreach ($existing as $file) {
				$exists[] = $file['filepath'].$file['filename'];
			}
		}
		if ($file_array) {

			foreach ($file_array as $key => $file) {
				if (!is_dir($file)) {
					// Skip existing entries, and sources/thumbs
					if (isset($exists) && in_array(str_replace(array($this->_manage_root.CC_DS, 'source/'), '', $file), $exists)) continue;

					$newfilename = $this->makeFilename($file);
					$oldfilename = basename($file);
					if($newfilename !== $oldfilename) {
						// rename file so we match up
						$new_path = str_replace($oldfilename, $newfilename, $file);
						if(!rename($file, $new_path)) {
							trigger_error("Failed to rename file from '$oldfilename' to '$newfilename'.", E_USER_WARNING);
						}
					}
					
					$filepath_record = $this->formatPath(str_replace($this->_manage_root, '', dirname($file)));
					$filepath_record = empty($filepath_record) ? 'NULL' : $filepath_record;
					$filepath_record = str_replace(chr(92),"/",$filepath_record);

					$record = array(
						'type'		=> (int)$this->_mode,
						'filepath'	=> $filepath_record,
						'filename'	=> $newfilename,
						'filesize'	=> filesize($file),
						'mimetype'	=> $this->getMimeType($file),
						'md5hash'	=> md5_file($file),
					);

					// Hash comparison check
					$checkhash	= $GLOBALS['db']->select('CubeCart_filemanager', array('file_id'), array('type' => $this->_mode, 'md5hash' => $record['md5hash'], 'filepath' => $record['filepath']), false, 1);
					if (!$checkhash) {
						$GLOBALS['db']->insert('CubeCart_filemanager', $record);
						$updated	= true;
					} else {
						if ($tidy) {
							unlink($file);
						}
					}
				}
			}
		}
		// Remove orphaned records
		if (($existing = $GLOBALS['db']->select('CubeCart_filemanager', false, array('type' => $this->_mode))) !== false) {
			foreach ($existing as $file) {
				if (!file_exists($this->_manage_root.CC_DS.$file['filepath'].$file['filename'])) {
					$GLOBALS['db']->delete('CubeCart_filemanager', array('file_id' => (int)$file['file_id']));
					$updated = true;
				}
			}
		}
		
		if (isset($updated) && $updated === true) {
		#	$GLOBALS['gui']->setNotify($GLOBALS['language']->filemanager['notify_db_update']);
			return true;
		}
	}

	/**
	 * Deliver download file
	 *
	 * @param string $access_key
	 * @param string $error
	 * @return bool
	 */
	public function deliverDownload($access_key = false, &$error = null) {
		if ($this->_mode == self::FM_FILETYPE_DL && $access_key) {
			if (($downloads = $GLOBALS['db']->select('CubeCart_downloads', false, array('accesskey' => $access_key))) !== false) {
				$download	= $downloads[0];
				if (($summary = $GLOBALS['db']->select('CubeCart_order_summary', false, array('cart_order_id' => $download['cart_order_id']))) !== false) {
					// Order/Download Validation
					// Download has expired
					if ($download['expire']>0 && $download['expire'] < time())		$error = FM_DL_ERROR_EXPIRED;
					// Order hasn't been paid for
					if (!in_array((int)$summary[0]['status'], array(2,3)))					$error = FM_DL_ERROR_PAYMENT;
					// Maximum download limit has been reached
					if ($GLOBALS['config']->get('config','download_count') > 0 && (int)$download['downloads'] >= $GLOBALS['config']->get('config','download_count'))	$error = FM_DL_ERROR_MAXDL;
					if (!empty($error)) return false;
					if (($product = $GLOBALS['db']->select('CubeCart_inventory', array('digital', 'digital_path'), array('product_id' => $download['product_id']), false, 1)) !== false) {
						$is_url		= false;
						if (empty($product[0]['digital_path'])) {

							if (($files = $GLOBALS['db']->select('CubeCart_filemanager', false, array('file_id' => $product[0]['digital']))) !== false) {
								$data	= $files[0];
								$file	= $this->_manage_root.CC_DS.$data['filepath'].CC_DS.$data['filename'];
							}
						} else {
							if (filter_var($product[0]['digital_path'], FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED)) {
								// Parse URL elements
								$is_url	= true;
								$url	= parse_url($product[0]['digital_path']);
								$file	= $product[0]['digital_path'];

								$options = array($url['scheme']	=> array('method'	=> 'GET'));
								$context = stream_context_create($options);
								$data	= array(
									'mimetype'	=> 'application/octet-stream',
									'filename'	=> basename($product[0]['digital_path']),
									'filesize'	=> null,
									'md5hash'	=> md5($product[0]['digital_path']),
								);
							} else if (file_exists($product[0]['digital_path'])) {

								$data	= array(
									'mimetype'	=> 'application/octet-stream',
									'filename'	=> basename($product[0]['digital_path']),
									'filepath'	=> dirname($product[0]['digital_path']),
									'filesize'	=> filesize($product[0]['digital_path']),
									'md5hash'	=> md5_file($product[0]['digital_path']),
								);
								$file	= $product[0]['digital_path'];
							}
						}
						// Deliver file contents
						if (isset($file) && ($is_url || file_exists($file))) { 
							if($is_url) {
								$GLOBALS['db']->update('CubeCart_downloads', array('downloads'	=> $download['downloads']+1), array('digital_id' => $download['digital_id']));
								httpredir($file);
								return true;
							} else {
								ob_end_clean();
								if (!is_file($file) or connection_status()!=0) return false;
							
								header("Expires: ".gmdate("D, d M Y H:i:s", mktime(date("H")+2, date("i"), date("s"), date("m"), date("d"), date("Y")))." GMT");
								header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
								header('Content-Disposition: attachment; filename="'.basename($file).'"');
								header("Content-Type: application/octet-stream");
								header("Content-Transfer-Encoding: binary");
								## IE 7 Fix
								header('Vary: User-Agent');
							
								if (($openfile = fopen($file, 'rb')) !== false) {
									while (!feof($openfile)) { // && !connection_status()) {
										echo fread($openfile, 8192);
							  			flush();
									}
									fclose($openfile);
								}
								if(!connection_status() && !connection_aborted()) {
									$GLOBALS['db']->update('CubeCart_downloads', array('downloads'	=> $download['downloads']+1), array('digital_id' => $download['digital_id']));
									return true;
								}
							}
						}
						## File doesn't exist
						$error	= FM_DL_ERROR_NOFILE;
						return false;
					}
					## Product record doesn't exist
					$error = FM_DL_ERROR_NOPRODUCT;
					return false;
				}
			}
			// Download record doesn't exist
			$error	= FM_DL_ERROR_NORECORD;
		}
		return false;
	}

	/**
	 * Delete file
	 *
	 * @param string $target
	 * @param string $del_folder
	 * @return bool
	 */
	public function delete($target = null, $del_folder = false) {
		if (!is_null($target)) {
			if (is_numeric($target)) {
				$status = $this->deleteFile($target, $del_folder);
			} else {
				$status = $this->deleteRecursive($target);
			}
			return $status;
		}
		return false;
	}

	/**
	 * Edit file
	 *
	 * @param int $file_id
	 * @return bool
	 */
	public function editor($file_id = null) {
		if (!is_null($file_id)) {
			if (!empty($this->_sub_dir)) {
				// Breadcrumbs
				if (($elements = explode(CC_DS, $this->_sub_dir)) !== false) {
					foreach ($elements as $sub_dir) {
						$path[] = $sub_dir;
						$GLOBALS['gui']->addBreadcrumb($sub_dir, currentPage(array('fm-edit'), array('subdir' => $this->formatPath(implode(CC_DS, $path), false))));
					}
				}
			}
			if (($file = $GLOBALS['db']->select('CubeCart_filemanager', false, array('file_id' => $file_id))) !== false) {
				$source = $this->_manage_dir.CC_DS.$this->_sub_dir;
				$sub_dir = (substr($this->_sub_dir, 0, 1) == CC_DS) ? $this->_sub_dir : CC_DS.$this->_sub_dir;
				if (file_exists($source.$file[0]['filename'])) {
					$GLOBALS['gui']->addBreadcrumb($file[0]['filename'], currentPage());
					$GLOBALS['main']->addTabControl('Details', 'fm-details');
					if ($this->_directories) {
						$list[] = CC_DS;
						foreach ($this->_directories as $root => $folders) {
							if ($this->_mode == self::FM_FILETYPE_IMG && in_array(basename($root), array('thumbs', 'source'))) continue;
							foreach ($folders as $folder) {
								if ($this->_mode == self::FM_FILETYPE_IMG && in_array(basename($folder), array('thumbs', 'source'))) continue;
								$list[] = CC_DS.str_replace($this->_manage_dir, '', $root).$folder.CC_DS;
							}
						}
						natsort($list);
						foreach ($list as $dir) {
							$vars['dirs'][]	= array(
								'path'		=> $dir,
								'selected'	=> ($sub_dir == $dir) ? ' selected="selected"' : '',
							);
						}
						$GLOBALS['smarty']->assign('DIRS', $vars['dirs']);
					}
					$file[0]['filepath']	= $source;
					$file[0]['random']		= mt_rand();
					$GLOBALS['smarty']->assign('FILE', $file[0]);

					if ($file[0]['type'] == self::FM_FILETYPE_IMG) {
						$GLOBALS['main']->addTabControl($GLOBALS['language']->filemanager['tab_crop'], 'fm-cropper');
						$GLOBALS['smarty']->assign('SHOW_CROP', true);
					}
					$GLOBALS['smarty']->assign('mode_form', true);
					return $GLOBALS['smarty']->fetch('templates/filemanager.index.php');
				} else {
					// File doesn't exist - Delete record, and all associations legacy names and id
					$GLOBALS['db']->update('CubeCart_category', array('cat_image' => ''), array('cat_image' => $file[0]['file_id']));
					$GLOBALS['db']->update('CubeCart_category', array('cat_image' => ''), array('cat_image' => $file[0]['filename']));
					
					$GLOBALS['db']->delete('CubeCart_image_index', array('file_id' => $file[0]['file_id']));
					$GLOBALS['db']->delete('CubeCart_filemanager', array('file_id' => $file[0]['file_id']));
					// Set error message
					$GLOBALS['gui']->setError($GLOBALS['language']->filemanager['error_image_missing']);
				}
			}
			// Redirect back to file list
			httpredir(currentPage(array('fm-edit')));
		}
	}

	/**
	 * Find directories
	 *
	 * @param string $search_dir
	 * @param int $i
	 *
	 * @return string/false
	 */
	public function findDirectories($search_dir = false, $i = 0) {
		$search_dir	= (!$search_dir) ? $this->_manage_dir : $search_dir;
		if ($search_dir && file_exists($search_dir)) {
			$list = glob($search_dir.CC_DS.'*', GLOB_ONLYDIR);
			if ($list) {
				foreach ($list as $dir) {
					if ($this->_mode == self::FM_FILETYPE_IMG && in_array(basename($dir), array('thumbs', 'source', '_vti_cnf'))) continue;
					$this->_directories[$this->makeFilepath($dir)][] = basename($dir);
					if (is_dir($dir)) {
						$this->findDirectories($dir, $i++);
					}
				}
				return $this->_directories;
			}
		}
		return false;
	}

	/**
	 * Format path string
	 *
	 * @param string $path
	 * @param bool $slash
	 * @return string
	 */
	public function formatPath($path, $slash = true) {
		$path = preg_replace('#[\\\/]{2,}#', CC_DS, urldecode($path));
		if ($path == '.' || $path == '..') {
			return null;
		}
		$path = str_replace('..', '', $path);
		// Remove preceeding slash
		if (substr($path, 0, 1) == CC_DS) {
			$path = substr($path, 1);
		}
		// Append a trailing slash, if there isn't one
		if ($slash && substr($path, -1) != CC_DS) {
			$path .= CC_DS;
		}

		return ($path != CC_DS) ? $path : null;
	}

	/**
	 * Get current mode
	 *
	 * @return string
	 */
	public function getMode() {
		return $this->_mode;
	}

	/**
	 * Get file mime type
	 *
	 * @return string
	 */
	public function getMimeType($file) {
		$finfo = (extension_loaded('fileinfo')) ? new finfo(FILEINFO_MIME_TYPE) : false;
		if ($finfo && $finfo instanceof finfo) {
			$mime	= $finfo->file($file);
		} else if (function_exists('mime_content_type')) {
			$mime	= mime_content_type($file);
		} else {
			$data	= getimagesize($file);
			$mime	= $data['mime'];
		}
		return (empty($mime)) ? 'application/octet-stream' : $mime;
	}
	
	/**
	 * Check filename is allowed (true on illegal!)
	 *
	 * @param string $type
	 * @return bool
	 */

	public function filename_is_illegal($file_name) {
		if(preg_match('/(\.sh\.inc\.ini|\.htaccess|\.php|\.phtml|\.php[3-6])$/i', $file_name)) {
			return true;
		} else if(preg_match('/\.php\./i', $file_name)) {
			return true;
		}
		return false;
	} 

	/**
	 * List file type
	 *
	 * @param string $type
	 * @param bool $select_button
	 * @return array/false
	 */
	public function listFiles($type = false, $select_button = false) {
		// Display Breadcrumbs
		if (!empty($this->_sub_dir)) {
			$elements = explode(CC_DS, $this->_sub_dir);
			if ($elements) {
				foreach ($elements as $sub_dir) {
					$path[] = $sub_dir;
					$GLOBALS['gui']->addBreadcrumb($sub_dir, currentPage(null, array('subdir' => $this->formatPath(implode(CC_DS, $path), false))));
				}
			}
		}
		$type_desc = ($this->_mode == self::FM_FILETYPE_IMG) ? $GLOBALS['language']->filemanager['file_type_image'] : $GLOBALS['language']->filemanager['file_type_dl'];
		$GLOBALS['smarty']->assign('FILMANAGER_TITLE', $type_desc." Filemanager");

		// Create a backlink to the parent directory, if is exists
		if ($this->_directories && isset($this->_directories[$this->formatPath($this->_sub_dir)])) {
			// List subdirectories
			foreach ($this->_directories[$this->formatPath($this->_sub_dir)] as $dir) {
				if ($this->_mode == self::FM_FILETYPE_IMG && in_array($this->makeFilename($dir), array('thumbs', 'source'))) continue;
				$name	= $this->makeFilename($dir);
				$folder	= array(
					'name'		=> $name,
					'link'		=> currentPage(null, array('subdir' => $this->formatPath($this->_sub_dir.$dir, false))),
					'delete'	=> (substr($name, 0, 1) !== '.') ? currentPage(null, array('delete' => $this->formatPath($this->_sub_dir.$dir, false))) : null,
				);
				$list_folders[]	= $folder;
			}
			$GLOBALS['smarty']->assign('FOLDERS', $list_folders);
		}

		$filepath_where		= empty($this->_sub_dir) ? 'IS NULL' : '= \''.str_replace('\\','/',$this->_sub_dir).'\'';		
		$where = '`disabled` = 0 AND `type` = '.(int)$this->_mode.' AND `filepath` '.$filepath_where;

		if (($files = $GLOBALS['db']->select('CubeCart_filemanager', false, $where, array('filename' => 'ASC'))) !== false) {
			$catalogue	= new Catalogue();
			$GLOBALS['smarty']->assign('ROOT_REL', $GLOBALS['rootRel']);
			foreach ($files as $key => $file) {
				$file['icon']			= $this->getFileIcon($file['mimetype']);
				$file['class']			= (preg_match('#^image#', $file['mimetype'])) ? 'class="colorbox"' : '';
				$file['edit']			= currentPage(null, array('fm-edit' => $file['file_id']));
				$file['delete']			= currentPage(null, array('delete' => $file['file_id']));
				$file['random']			= mt_rand();
				$file['description']	= (!empty($file['description'])) ? $file['description'] : $file['filename'];
				$file['master_filepath']= str_replace(chr(92),"/",$this->_manage_dir.CC_DS.$file['filepath'].$file['filename']);
				$file['filepath']	 	= ($this->_mode == self::FM_FILETYPE_IMG) ? $catalogue->imagePath($file['file_id'], 'medium') : $this->_manage_dir.CC_DS.$file['filepath'].$file['filename'];
				$file['select_button']	= (bool)$select_button;
				$list_files[$key]	= $file;
			}
			$GLOBALS['smarty']->assign('FILES', $list_files);
			return $list_files;
		}
		return false;
	}

	/**
	 * Upload file
	 *
	 * @param string $type
	 * @param bool $thumbnail
	 *
	 * @return int/false
	 */
	public function upload($type = false, $thumbnail = false) {
		if (!empty($_FILES)) {
			$finfo	= (extension_loaded('fileinfo')) ? new finfo(FILEINFO_SYMLINK | FILEINFO_MIME) : false;
			foreach ($_FILES as $file) {
				  
				if($this->filename_is_illegal($file['name'])) continue;
				
				if (is_array($file['tmp_name'])) {
					foreach ($file['tmp_name'] as $offset => $tmp_name) {
						$gd = new GD($this->_manage_root.CC_DS.$this->_sub_dir);
						if (!empty($tmp_name) && is_uploaded_file($tmp_name)) {
							if ($file['error'][$offset] !== UPLOAD_ERR_OK) {
								$this->uploadError($file['error'][$offset]);
								continue;
							}
							switch ($this->_mode) {
								case self::FM_FILETYPE_IMG:
									$gd->gdUpload($tmp_name, $file['name'][$offset]);
									$gd->gdSave($file['name'][$offset]);
									break;
							}
							$target	= $this->_manage_root.CC_DS.$this->_sub_dir.$file['name'][$offset];
							if ($finfo && $finfo instanceof finfo) {
								preg_match('#([\w\-\.]+)/([\w\-\.]+)$#iU', $finfo->file($tmp_name), $match);
								$mime	= $match[0];
							} else if (function_exists('mime_content_type')) {
								$mime	= mime_content_type($tmp_name);
							} else {
								$mime	= $file['type'][$offset];
							}
			
							$record = array(
								'type'		=> (int)$this->_mode,
								'filepath'	=> (isset($this->_sub_dir) && !empty($this->_sub_dir)) ? str_replace('\\','/',$this->_sub_dir) : 'NULL',
								'filename'	=> $this->makeFilename($file['name'][$offset]),
								'filesize'	=> $file['size'][$offset],
								'mimetype'	=> (!empty($mime)) ? $mime : 'application/octet-stream',
								'md5hash'	=> md5_file($tmp_name),
							);

							if ($GLOBALS['db']->insert('CubeCart_filemanager', $record)) {
								$file_id[] = $GLOBALS['db']->insertid();
								move_uploaded_file($tmp_name, $target);
								chmod($target, 0755);
							}
							
						}
					}
				} else {
					$gd = new GD($this->_manage_root.CC_DS.$this->_sub_dir);
					if (!empty($file['tmp_name']) && is_uploaded_file($file['tmp_name'])) {
						if ($file['error'] !== UPLOAD_ERR_OK) {
							$this->uploadError($file['error']);
							continue;
						}
						switch ($this->_mode) {
							case self::FM_FILETYPE_IMG:
								$gd->gdUpload($file['tmp_name'], $file['name']);
								$gd->gdSave($file['name']);
								break;
						}
						$target	= $this->_manage_root.CC_DS.$this->_sub_dir.$file['name'];
						if (($finfo && $finfo instanceof finfo) && preg_match('#([\w\-\.]+)/([\w\-\.]+)#i', $finfo->file($file['tmp_name']), $match)) {
							$mime = $match[0];
						} else if (function_exists('mime_content_type')) {
							$mime = mime_content_type($file['tmp_name']);
						} else {
							$mime = $file['type'];
						}
						$record = array(
							'type'		=> (int)$this->_mode,
							'filepath'	=> (isset($this->_sub_dir) && !empty($this->_sub_dir)) ? str_replace('\\','/',$this->_sub_dir) : 'NULL',
							'filename'	=> $this->makeFilename($file['name']),
							'filesize'	=> $file['size'],
							'mimetype'	=> (!empty($mime)) ? $mime : 'application/octet-stream',
							'md5hash'	=> md5_file($file['tmp_name']),
						);
						if ($GLOBALS['db']->insert('CubeCart_filemanager', $record)) {
							$file_id[] = $GLOBALS['db']->insertid();
							move_uploaded_file($file['tmp_name'], $target);
							chmod($target, 0755);
						}
					}
				}
			}
			return (isset($file_id)) ? $file_id : true;
		}
		return false;
	}

	/**
	 * Upgrade file
	 *
	 * @param unknown_type $start
	 * @param unknown_type $dir
	 *
	 * @return
	 */
	public function upgrade($start = null, $dir = null) {
		if (is_array($start)) {
			foreach ($start as $seek) {
				$this->upgrade($seek, $dir);
			}
		} else {
			$scan_root	= CC_ROOT_DIR.CC_DS.'images'.CC_DS.'uploads'.CC_DS.$start;
			if (substr($scan_root, -1, 1) != CC_DS) $scan_root .= CC_DS;

			$scan_dir	= $scan_root;
			if (!is_null($dir)) {
				$scan_dir .= (substr($dir, 0, 1) == CC_DS) ? substr($dir, 1) : $dir;
			}

			if (file_exists($scan_dir) && is_dir($scan_dir)) {
				if (($files = glob($scan_dir.'*', GLOB_MARK)) !== false) {
					foreach ($files as $file) {
						$target	= str_replace($scan_root, '', $file);
						if (is_dir($file)) {
							if (in_array($target, array('source', 'thumbs', '_vti_cnf'))) continue;
							$this->upgrade($start, $target);
							rmdir($file);
						} else {
							// Copy to new sources
							$to	= $this->_manage_root.CC_DS.$target;
							if (!file_exists(dirname($to))) mkdir(dirname($to), chmod_writable(), true);
							rename($file, $to);
						}
						continue;
					}
					return true;
				}
			}
		}
		return false;
	}


	private function createDirectory($new_dir = false, $in_sub_dir = true) {
		if (!empty($new_dir)) {
			$create	= $this->formatName($new_dir);
			$path = $this->_manage_root.CC_DS.$this->_sub_dir.$create;
			if (!file_exists($path)) {
				$result = (bool)mkdir($path);
				if(!is_writable($path)) {
					chmod($path, chmod_writable());
				}
				return $result;
			}
		}
		return false;
	}

	private function deleteFile($file_id = null, $folder = false) {
		if (!is_null($file_id) && is_numeric($file_id)) {
			if (($result = $GLOBALS['db']->select('CubeCart_filemanager', false, array('file_id' => (int)$file_id))) !== false) {
				if ($this->_mode == self::FM_FILETYPE_IMG && preg_match('#^image#', $result[0]['mimetype'])) {
					// Clean the image cache
					if (preg_match('#(.*)(\.\w+)$#iu', $result[0]['filename'], $match)) {
						$filename = sprintf('%s.*%s', $match[1], $match[2]);
						if (($caches = glob($this->_manage_cache.CC_DS.$this->_sub_dir.$filename, GLOB_BRACE)) !== false) {
							foreach ($caches as $cached) {
								unlink($cached);
							}
						}
					}
				}
				$file	= $this->_manage_root.CC_DS.$this->_sub_dir.$result[0]['filename'];
				if (file_exists($file) && unlink($file) || !file_exists($file)) {
					if ($GLOBALS['db']->delete('CubeCart_filemanager', array('file_id' => (int)$file_id))) {
						return true;
					}
				}
			}
		}
		return false;
	}

	private function deleteRecursive($directory = null) {
		$directory	= urldecode($directory);
		$scan	= glob($this->_manage_root.CC_DS.$directory.CC_DS.'*');
		if (is_array($scan)) {
			foreach ($scan as $entry) {
				$this->_sub_dir	= str_replace(array($this->_manage_root.CC_DS, basename($entry)), '', $entry);
				if (is_dir($entry)) {
					$this->deleteRecursive(str_replace($this->_manage_root.CC_DS, '', $entry));
				} else {
					if (!in_array(basename(dirname($entry)), array('source', 'thumbs', '_vti_cnf'))) {
						$files	= $GLOBALS['db']->select('CubeCart_filemanager', array('file_id'), array('filename' => basename($entry), 'filepath' => $this->_sub_dir));
						if ($files) {
							foreach ($files as $file) {
								$this->deleteFile($file['file_id'], true);
							}
						}
					}
				}
			}
			return (bool)rmdir($this->_manage_root.CC_DS.$directory);
		}
		return false;
	}

	private function formatName($name) {
		return preg_replace('#[^\w\.\-\_]#i', '_', $name);
	}

	private function getFileIcon($mimetype = false) {
		if (preg_match('#^image#i', $mimetype)) {
			return 'image';
		} else {
			switch ($mimetype) {
				case 'application/x-gzip':
				case 'application/x-gtar':
				case 'application/x-tar':
				case 'application/x-zip':
				case 'application/zip':
					$icon	= 'page_archive';
				break;
				case 'video/mpeg':
				case 'video/quicktime':
				case 'video/x-msvideo':
					$icon	= 'video';
				break;
				case 'application/msword':
					$icon	= 'page_word';
				break;
				case 'application/vnd.ms-excel':
					$icon	= 'page_excel';
				break;
				default:
					$icon	= 'page_generic';
			}
			return $icon;
		}
	}

	private function makeFilename($file, $hash = false) {
		// Standardize the filename
		return $this->formatName(basename($file));
	}

	private function makeFilepath($file) {
		$path	=  str_replace($this->_manage_root, '', dirname($file));
		return $this->formatPath($path);
	}

	private function parentDir($block) {
		$array	= explode('/', $this->formatPath($this->_sub_dir, false));
		foreach ($array as $key => $dir) {
			if (empty($dir)) unset($array[$key]);
		}
		$count	= count($array);
		if ($count > 0) {
			if ($count > 1) {
				unset($array[$count-1]);
				$subdir	= implode('/', $array);
			} else if ($count == 1) {
				// Parent is root directory
				$subdir	= '';
			}
			$folder	= array(
				'name'	=> $this->makeFilename('..'),
				'link'	=> currentPage(null, array('subdir' => $this->formatPath($subdir, false))),
			);
			#$GLOBALS['smarty']->assign('FOLDER', $folder);
		}
	}

	private function uploadError($error_no) {
		switch ($error_no) {
			case UPLOAD_ERR_INI_SIZE:
				$message	= 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
			break;
			case UPLOAD_ERR_FORM_SIZE:
				$message	= 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
			break;
			case UPLOAD_ERR_PARTIAL:
				$message	= 'The uploaded file was only partially uploaded';
			break;
			case UPLOAD_ERR_NO_FILE:
				$message	= 'No file was uploaded';
			break;
			case UPLOAD_ERR_NO_TMP_DIR:
				$message	= 'Missing a temporary folder';
			break;
			case UPLOAD_ERR_CANT_WRITE:
				$message	= 'Failed to write file to disk';
			break;
			case UPLOAD_ERR_EXTENSION:
				$message	= 'File upload stopped by extension';
			break;
			default:
				$message	= 'Unknown upload error';
		}
		trigger_error($message, E_USER_WARNING);
		return false;
	}

}