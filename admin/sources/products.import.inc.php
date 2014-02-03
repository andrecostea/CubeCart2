<?php
if (!defined('CC_INI_SET')) die('Access Denied');
Admin::getInstance()->permissions('products', CC_PERM_EDIT, true);

global $lang;

$source		= CC_ROOT_DIR.CC_DS.'includes'.CC_DS.'extra'.CC_DS.'importdata.tmp';
$importers	= CC_ROOT_DIR.CC_DS.'includes'.CC_DS.'importers';

$delimiter	= (isset($_POST['delimiter']) && !empty($_POST['delimiter'])) ? $_POST['delimiter'] : ',';

$GLOBALS['main']->addTabControl($lang['common']['import'], 'general');
if (isset($_POST['process'])) {
	## This will (theoretically) prevent a partial import
	ignore_user_abort(true);
	set_time_limit(0);
	ini_set('max_execution_time', '0');
	$updated	= array('updated' => 'false');
	## Truncate?
	if (isset($_POST['option']['truncate'])) {
		$tables = array(
			'CubeCart_inventory',
			'CubeCart_image_index',
			'CubeCart_option_assign',
			'CubeCart_reviews',
			'CubeCart_category_index',
			'CubeCart_image_index',
			'CubeCart_inventory_language',
			'CubeCart_options_set_product',
			'CubeCart_pricing_quantity',
			'CubeCart_pricing_group',
		);
		$GLOBALS['db']->truncate($tables);
		$GLOBALS['db']->misc("DELETE FROM `".$glob['dbprefix']."CubeCart_seo_urls` WHERE `type` = 'prod'");
	}

	$schema		= $importers.CC_DS.basename($_POST['process']);
	$column		= 0;
	$required	= array();
	if (!empty($_POST['process']) && file_exists($schema)) {
		## Use the schema file

		$polymorph	= false;
		$xml		= new SimpleXMLElement(file_get_contents($schema));
		if ($xml) {
			foreach ($xml->structure->field as $field) {
				/*
				## TO DO... data transformation
				if (isset($field->attributes()->type)) {
					switch strtolower((string)$field->attributes()->type) {
						case 'bool':
						case 'boolean':
							break;
					}
				}
				*/
				$value	= ($field->attributes()->ignored) ? null :(string)$field->attributes()->column;
				if (isset($field->attributes()->required) && strtolower((string)$field->attributes()->required) == 'true') $required[] = (string)$field->attributes()->column;
				if (isset($field->attributes()->source) && !empty($field->attributes()->source)) {
					## Polymorphic column mapping
					$polymorph	= true;
					$map[(string)$field->attributes()->source] = $value;
				} else {
					$offset			= (isset($field->attributes()->offset) && is_numeric($field->attributes()->offset)) ? (int)$field->attributes()->offset : $column;
					$map[$offset]	= $value;
				}
				$column++;
			}
			$delimiter	= (isset($xml->info->delimiter)) ? (string)$xml->info->delimiter : $delimiter;
			$has_header	= (isset($xml->info->headers)) ? true : false;
		}
	} else if (isset($_POST['map']) && is_array($_POST['map'])) {
		## Use the user defined mapping
		foreach ($_POST['map'] as $col => $value) {
			$map[$column++]	= (string)$value;
		}
		if (isset($_POST['required']) && is_array($_POST['required'])) {
			foreach ($_POST['required'] as $offset => $value) {
				if (!empty($value)) $required[] = $map[$offset];
			}
		}
		$delimiter	= (isset($_POST['delimiter']) && !empty($delimiter)) ? $_POST['delimiter'] : ',';
		$has_header	= (isset($_POST['option']['headers'])) ? true : false;
	}
	if (isset($map) && file_exists($source)) {
		## Load source data
		$fp	= fopen($source, 'rb');
		if ($fp) {
			$row	= 0;
			$insert	= 0;
			$now	= date('Y-m-d H:i:s', time());
			while (($data = fgetcsv($fp, false, str_replace('tab', "\t", $delimiter))) !== false) {
				$row++;
				if ($has_header && $row == 1) {
					$headers	= $data;
					continue;
				}
				foreach ($data as $offset => $value) {
					$field_name	= ($polymorph) ? $map[$headers[$offset]] : $map[$offset];
					## Handle manufacturers
					if ($field_name == 'manufacturer' && !empty($value) && !is_numeric($value)) {
						if (($manufacturer = $GLOBALS['db']->select('CubeCart_manufacturers', false, array('name' => $value), false, 1)) !== false) {
							$value	= $manufacturer[0]['id'];
						} else {
							## Insert new manufacturer?
							if ($GLOBALS['db']->insert('CubeCart_manufacturers', array('name' => $value))) {
								$value	= (int)$GLOBALS['db']->insertid();
							}
						}
					} elseif($field_name == 'image' && !empty($value) && !is_numeric($value)) {
						foreach ($GLOBALS['hooks']->load('admin.product.import.image.pre_process') as $hook) include $hook;
						$image_name = basename($value);
						$image_path = preg_replace('/^[.\/]/', '', dirname($value)); // lose first slash to match DB storage but add end slash
						if(!empty($image_path)) {
							$image_path .= '/';
						}
						$image = $GLOBALS['db']->select('CubeCart_filemanager', array('file_id'), array('filename' => $image_name, 'type' => 1, 'filepath' => empty($image_path) ? 'NULL' : $image_path), false, 1);
						if(!$image) {
							$root_image_path = CC_ROOT_DIR.'/images/source/'.$image_path.$image_name;
							if(file_exists($root_image_path)) {
								$finfo = (extension_loaded('fileinfo')) ? new finfo(FILEINFO_SYMLINK | FILEINFO_MIME) : false;
								if ($finfo && $finfo instanceof finfo) {
									preg_match('#([\w\-\.]+)/([\w\-\.]+)$#iU', $finfo->file($root_image_path), $match);
									$mime	= $match[0];
								} else if (function_exists('mime_content_type')) {
									$mime	= mime_content_type($root_image_path);
								} else {
									$data	= getimagesize($root_image_path);
									$mime	= $data['mime'];
								}
								$filesize = filesize($root_image_path);
								$filesize = ($filesize > 0)? $filesize : 0;
							}

							if ($GLOBALS['db']->insert('CubeCart_filemanager', array('type' => 1, 'filepath' => empty($image_path) ? 'NULL' : $image_path, 'filename' => $image_name, 'filesize' => $filesize, 'mimetype' => $mime, 'md5hash' => md5($root_image_path)))) {
								$image[0]['file_id']	= (int)$GLOBALS['db']->insertid();
							}
						}
						$image[0]['img'] = $image_path.$image_name; // Value for `img` in CubeCart_image_index
					}
					if ($polymorph) {
						if (isset($map[$headers[$offset]])) {
							$product_record[$map[$headers[$offset]]] = $value;
						}
					} else {
						if (empty($map[$offset]) || (in_array($map[$offset], $required) && empty($value))) continue;
						$product_record[$map[$offset]] = $value;
					}
				}
				// Insert if we have a product record with at minimum a value for the product name
				if (isset($product_record) && !empty($product_record) && !empty($product_record['name'])) {
					$product_record['date_added']	= $now;
					// Insert product
					if ($GLOBALS['db']->insert('CubeCart_inventory', $product_record)) $insert++;
					// Insert primary category
					$product_id = $GLOBALS['db']->insertid();
					if($product_record['cat_id']>0) {
						$category_record = array (
							'product_id'	=> $product_id,
							'cat_id'		=> $product_record['cat_id'],
							'primary'		=> 1
						);
						$GLOBALS['db']->insert('CubeCart_category_index', $category_record);
					}
					// Insert primary image
					if($image[0]['file_id']>0) {
						$image_record = array (
							'product_id'	=> $product_id,
							'file_id'		=> $image[0]['file_id'],
							'main_img'		=> 1,
							'img'			=> $image[0]['img']
						);
						$GLOBALS['db']->insert('CubeCart_image_index', $image_record);
					}
					// Insert SEO custom URL
					if (empty($product_record['seo_path'])) $product_record['seo_path'] = $GLOBALS['seo']->generatePath($product_id, 'prod');
					$db->insert('CubeCart_seo_urls', array('path'=> sanitizeSEOPath($product_record['seo_path']), 'item_id' => $product_id, 'type' => 'prod'));
				}
				unset($product_record, $category_record, $image_record, $image);
			}
			fclose($fp);
		}
		unlink($source);
	}
	$GLOBALS['main']->setACPNotify($lang['catalogue']['notify_import_complete']);
	httpredir(currentPage());
} else if (isset($_POST['upload'])) {
	## Remove previous import data
	if (isset($_POST['revert']) && is_array($_POST['revert'])) {
		foreach ($_POST['revert'] as $revert) {
			$products = $GLOBALS['db']->select('CubeCart_inventory', array('product_id'), array('date_added' => (string)$revert));
			if($products) {
				foreach($products as $product) {
					$GLOBALS['db']->delete('CubeCart_category_index', array('product_id' => $product['product_id']));
					$GLOBALS['db']->delete('CubeCart_image_index', array('product_id' => $product['product_id']));
				}
				$GLOBALS['db']->delete('CubeCart_inventory', array('date_added' => (string)$revert));
				$GLOBALS['main']->setACPNotify($lang['catalogue']['notify_import_removed']);
			} else {
				$GLOBALS['main']->setACPWarning($lang['catalogue']['notify_import_removed_fail']);
			}

		}
		httpredir(currentPage());
	} else if (is_uploaded_file($_FILES['source']['tmp_name']) && move_uploaded_file($_FILES['source']['tmp_name'], $source)) {
		## Display interstitial page before actually importing, either displaying example data from source, or a means to map the CSV to the database columns
	#	if ($_FILES['source']['type']=="text/plain") {
			$schema		= $importers.CC_DS.basename($_POST['format']);
			if (isset($_POST['format']) && !empty($_POST['format']) && file_exists($schema)) {

				$xml	= new SimpleXMLElement(file_get_contents($schema));
				$i		= 0;
				## Create index -> column map
				foreach ($xml->structure->field as $field) {
					$value	= ($field->attributes()->ignored) ? null : (string)$field->attributes()->column;
					if (isset($field->attributes()->source) && !empty($field->attributes()->source)) {
						## Polymorphic column mapping (Yes, I'm looking at you, Magento)
						$map[(string)$field->attributes()->source] = $value;
					} else {
						$map[$i++]	= $value;
					}
				}
				##
				$delimiter	= (isset($xml->info->delimiter)) ? (string)$xml->info->delimiter : $delimiter;
				$has_header	= (isset($xml->info->headers)) ? true : false;
				## Load some rows from import data
				$fp	= fopen($source, 'rb');
				if ($fp) {
					$row = 0;
					while (($data = fgetcsv($fp, null, str_replace('tab', "\t", $delimiter))) !== false) {
						$row++;
						if ($has_header && $row == 1) {
							$headers	= $data;
							continue;
						}
						if (empty($data)) continue;

						foreach ($data as $offset => $string) {
							if (empty($string)) continue;
							if (isset($xml->info->polymorphic)) {
								if (isset($map[$headers[$offset]])) {
									$product_record[$map[$headers[$offset]]]	= $string;
								}
							} else {
								if (empty($map[$offset])) continue;
								$product_record[$map[$offset]]	= $string;
							}
						}
						break;
					}
					## Close file handle
					fclose($fp);
					## Display the example data
					if (is_array($product_record)) {
						foreach ($product_record as $column => $value) {
							$smarty_data['examples'][]	= array('column' => $column, 'value' => htmlentities($value, ENT_COMPAT, 'UTF-8'));
						}
						$GLOBALS['smarty']->assign('EXAMPLES', $smarty_data['examples']);
					}
					$GLOBALS['smarty']->assign('IMPORT', array('format' => basename($schema)));
				}
			} else {
				$delimiter	= (isset($_POST['delimiter']) && !empty($_POST['delimiter'])) ? $_POST['delimiter'] : ',';
				## No format map available, so give them a manual assignment form
				$fields	= array(	# Update for language strings
					'status'			=> $lang['common']['status'],
					'name'				=> $lang['catalogue']['product_name'],
					'image'				=> $lang['catalogue']['image_main'],
					'product_code'		=> $lang['catalogue']['product_code'],
					'cat_id'			=> $lang['catalogue']['master_caregory_id'],
					'description'		=> $lang['common']['description'],
					'manufacturer'		=> $lang['catalogue']['manufacturer'],
					'price'				=> $lang['common']['price'],
					'sale_price'		=> $lang['common']['price_sale'],
					'cost_price'		=> $lang['common']['price_cost'],
					'product_weight'	=> $lang['common']['weight'],
					'use_stock_level'	=> $lang['catalogue']['stock_level_use'],
					'stock_level'		=> $lang['catalogue']['stock_level'],
					'stock_warning'		=> $lang['catalogue']['stock_level_warn'],
					'digital'			=> $lang['catalogue']['is_digital'],
					'digital_path'		=> $lang['catalogue']['file_path'],
					'tax_type'			=> $lang['catalogue']['tax_class'],
					'tax_inclusive'		=> $lang['catalogue']['tax_inclusive'],
					'featured'			=> $lang['catalogue']['product_latest'],
					'seo_path'			=> $lang['settings']['seo_path'],
					'seo_meta_title'		=> $lang['settings']['seo_meta_title'],
					'seo_meta_keywords'		=> $lang['settings']['seo_meta_keywords'],
					'seo_meta_description'	=> $lang['settings']['seo_meta_description'],
					'condition'			=> $lang['catalogue']['condition'],
					'upc'				=> $lang['catalogue']['product_upc'],
					'ean'				=> $lang['catalogue']['product_ean'],
					'jan'				=> $lang['catalogue']['product_jan'],
					'isbn'				=> $lang['catalogue']['product_isbn'],
					'brand'				=> $lang['catalogue']['product_brand'],
					'grin'				=> $lang['catalogue']['product_grin'],
					'man'				=> $lang['catalogue']['product_mpn']
				);
				$fp		= fopen($source, 'r');
				$data	= fgetcsv($fp, null, str_replace('tab', "\t", $delimiter));
				fclose($fp);
				if (is_array($data)) {
					foreach ($data as $offset => $value) {
						$smarty_data['maps'][]	= array('offset' => (int)$offset, 'example' => $value);
					}
					foreach ($fields as $column => $title) {
						$smarty_data['columns'][] = array('column' => $column, 'title' => $title);
					}
					$GLOBALS['smarty']->assign('COLUMNS', $smarty_data['columns']);
					$GLOBALS['smarty']->assign('MAPS', $smarty_data['maps']);
					$GLOBALS['smarty']->assign('IMPORT', array('delimiter' => $_POST['delimiter']));

					$smarty_data['map']	= '';

				} else {
					$GLOBALS['main']->setACPWarning($lang['catalogue']['error_import_empty']);
					httpredir(currentPage());
				}
			}
			$GLOBALS['smarty']->assign('DISPLAY_CONFIRMATION',true);
	#	} else {
	#		$GLOBALS['main']->setACPWarning($lang['catalogue']['error_import_invalid']);
	#		httpredir(currentPage());
	#	}
	} else {
		$GLOBALS['main']->setACPWarning($lang['catalogue']['error_import_upload']);
		httpredir(currentPage());
	}
} else {
	## Find previous imports, and list
	if (($reverts = $GLOBALS['db']->query(sprintf("SELECT COUNT(product_id) AS Count, date_added FROM %sCubeCart_inventory WHERE 1 GROUP BY date_added ORDER BY date_added ASC", $GLOBALS['config']->get('config', 'dbprefix')))) !== false) {
		foreach ($reverts as $revert) {
			if ($revert['date_added'] == 0 || $revert['Count'] == 1) continue;
			$revert['date_added_fuzzy'] = formatTime(strtotime($revert['date_added']));
			$smarty_data['reverts'][]	= $revert;
			$block	= true;
		}
		if (isset($smarty_data['reverts'])) {
			$GLOBALS['smarty']->assign('REVERTS',$smarty_data['reverts']);
		}
		if (isset($block)) {
			$GLOBALS['main']->addTabControl($lang['catalogue']['tab_import_revert'], 'revert');
		}
	}
	## Provide upload box, and format selector
	$formats	= glob(CC_ROOT_DIR.CC_DS.'includes'.CC_DS.'importers'.CC_DS.'*.xml');
	if (isset($formats) && is_array($formats)) {
		foreach ($formats as $format) {
			$xml	= new SimpleXMLElement(file_get_contents($format));
			$smarty_data['formats'][] = array('title' => (string)$xml->info->title, 'file' => basename($format));
			unset($xml);
		}
		$GLOBALS['smarty']->assign('FORMATS',$smarty_data['formats']);
	}
	$GLOBALS['smarty']->assign('DISPLAY_FORM',true);

}
$page_content = $GLOBALS['smarty']->fetch('templates/products.import.php');