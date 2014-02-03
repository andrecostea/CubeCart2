<?php
/**
 * Header
 */

/**
 * Database controller
 *
 * @author Technocrat
 * @version 1.1.0
 * @since 5.0.0
 */
class Database_Contoller {

	/**
	 * Allowed exceptions
	 *
	 * @var array
	 */
	protected $_allowed_exceptions	= array('CURRENT_TIMESTAMP', 'NOW()', 'offline_capture', 'NULL');
	/**
	 * Was it a cached query
	 *
	 * @var bool
	 */
	protected $_cached			= false;

	/**
	 * DB connection
	 *
	 * @var id
	 */
	protected $_db_connect_id	= null;
	/**
	 * Number of rows found
	 *
	 * @var $_found_rows int
	 */
	protected $_found_rows		= null;
	/**
	 * Store prefix
	 *
	 * @var string
	 */
	protected $_prefix			= '';
	/**
	 * Query to execute
	 *
	 * @var $_query string
	 */
	protected $_query			= false;
	/**
	 * Query run time
	 *
	 * @var $_query_time float
	 */
	protected $_query_time		= null;
	/**
	 * Query result
	 *
	 * @var $_result
	 */
	protected $_result			= null;
	/**
	 * Query allowed columns memory cache
	 *
	 * @var array
	 */
	protected $_allowedColumns = array();


	/**
	 * Class instance
	 *
	 * @var instance
	 */
	protected static $_instance;

	protected function __construct() { }

	public function __destruct() { }

	/**
	 * Display column sort
	 *
	 * @param string $column_name
	 * @param string $display_text
	 * @param string $order_by
	 * @param string $current_page
	 * @param array_type $current_sort
	 * @param string $anchor
	 * @return string
	 */
	public function column_sort($column_name, $display_text, $order_by = 'sort', $current_page, $current_sort = false, $anchor = false) {
		$link 		= "$current_page&amp;{$order_by}[$column_name]=";
		$image_path = $GLOBALS['config']->get('config', 'adminFolder').'/skins/default/images/';
		if ($anchor) {
			$anchor = '#'.$anchor;
		}

		$link_asc 	= (isset($current_sort[$column_name]) && $current_sort[$column_name] == 'ASC') ? "<img src=\"{$image_path}sort_asc_on.png\" title=\"Sort by $display_text ascending\" />" : "<a href=\"{$link}ASC{$anchor}\"><img src=\"{$image_path}sort_asc_off.png\" title=\"Sort by $display_text ascending\" /></a>";
		$link_desc 	= (isset($current_sort[$column_name]) && $current_sort[$column_name] == 'DESC') ? "<img src=\"{$image_path}sort_desc_on.png\" title=\"Sort by $display_text descending\" />" : "<a href=\"{$link}DESC{$anchor}\"><img src=\"{$image_path}sort_desc_off.png\" title=\"Sort by $display_text descending\" /></a>";
		$html_out 	= "<span>$link_desc $link_asc</span>$display_text";

		return 	$html_out;
	}

	/**
	 * Query count a field
	 *
	 * @param string $table
	 * @param string $field
	 * @param string $where
	 *
	 * @return bool
	 */
	public function count($table = false, $field = false, $where = false) {
		if (!empty($table)) {
			$allowed = $this->getFields($table);
			if (in_array($field, $allowed) && !is_numeric($field)) {
				$this->_query	= "SELECT COUNT($field) AS Count FROM `{$this->_prefix}$table` ".$this->where($table, $where).';';
				$this->_execute();
				if ($this->_result && isset($this->_result[0]['Count'])) {
					return ((int)$this->_result[0]['Count'] > 0) ? (int)$this->_result[0]['Count'] : false;
				}
			}
		}

		return false;
	}

	public function debug() {
		$ret = '[QUERY] - '.$this->_query."\n";
		return $ret;
	}

	/**
	 * Delete from a table
	 *
	 * @param string $table
	 * @param string $where
	 * @param string $limit
	 * @param bool $purge
	 * @return bool
	 */
	public function delete($table, $where, $limit = '', $purge = true) {
		if (!empty($limit)) {
			$limit = "LIMIT $limit";
		}
		$this->_query = "DELETE FROM `{$this->_prefix}$table` ".$this->where($table, $where)." $limit;";
		$this->_execute(false);
		$affected = ($this->affected() > 0);

		if ($purge && $affected) {
			Cache::getInstance()->clear('SQL');
		}

		return ($affected) ? true : false;
	}

	/**
	 * Backup SQL
	 *
	 * @param bool $dropTables
	 * @param bool $incStructure
	 * @param bool $incRows
	 *
	 * @return string
	 */
	public function doSQLBackup($dropTables = false, $incStructure = true, $incRows = true) {
		$data = "-- --------------------------------------------------------\n-- CubeCart SQL Dump\n-- version ".CC_VERSION."\n-- http://www.cubecart.com\n-- \n-- Host: ".$GLOBALS['config']->get('config', 'dbhost')."\n-- Generation Time: ".strftime($GLOBALS['config']->get('config', 'time_format'), time())."\n-- Server version: ".$this->serverVersion()."\n-- PHP Version: ".phpversion()."\n-- \n-- Database: `".$GLOBALS['config']->get('config', 'dbdatabase')."`\n";
		$tables = $this->getRows();
		foreach($tables as $table){
			$data .= $this->sqldumptable($table, $dropTables, $incStructure, $incRows);
		}
		$data .= "-- --------------------------------------------------------\n-- CubeCart SQL Dump Complete\n-- --------------------------------------------------------";
		return $data;
	}

	/**
	 * Get DB debug info
	 *
	 * @return array
	 */
	public function getDebug() {
		return array('error' => $this->_debugError, 'query' => $this->_debugQuery);
	}

	/**
	 * Get all full text fields from a table
	 *
	 * @param string $table
	 * @param string $prefix
	 * @return array
	 */
	public function getFulltextIndex($table = 'CubeCart_inventory', $prefix = false) {
		if(is_array($table)) {
			return false;
		}
		$fieldlist = array();
		$sql	= "SHOW INDEX FROM `{$this->_prefix}$table`;";
		$result	= $this->query($sql);
		if ($result) {
			foreach ($result as $index) {
				if ($index['Index_type'] == 'FULLTEXT' && $index['Key_name'] == 'fulltext') {
					if ($prefix) {
						$fieldlist[] = $prefix.'.'.$index['Column_name'];
					} else {
						$fieldlist[] = $index['Column_name'];
					}
				}
			}
		}
		return $fieldlist;
	}

	/**
	 * Get the number of rows found
	 *
	 * @return int
	 */
	public function getFoundRows() {
		return $this->_found_rows;
	}

	/**
	 * Gets the size of the ft_min_word_len
	 *
	 * @return int
	 */
	public function getSearchWordLen() {
		if (($query = $this->query("SHOW VARIABLES LIKE 'ft_min_word_len'")) !== false) {
			if (isset($query[0]['Value']) && is_numeric($query[0]['Value'])) {
				return (int)$query[0]['Value'];
			}
		}

		//Guess at 4
		return 4;
	}

	/**
	 * Get all rows from a table
	 *
	 * @param string $query
	 * @return array
	 */
	public function getRows($query = false) {
		// Used in maintenance/backup and database, also in upgrade
		if(!$query) {
			$this->_query = 'SHOW tables';
		} else {
			$this->_query = $query;
		}
		$this->_query .= (empty($this->_prefix)) ?  '' : " LIKE '".$this->_prefix."%'";
		$this->_execute(false);
		$tableNames = $this->_result;
		foreach($tableNames as $tableName){
			sort($tableName);
			$this->_query = "SHOW TABLE STATUS LIKE '".$tableName[0]."'";
			$this->_execute(false);
			$tables[] = $this->_result[0];

		}

		return ($tables) ? $tables : false;
	}

	/**
	 * Returns the query that was run.
	 * Good for debug
	 *
	 * @return string Query
	 */
	public function getQuery() {
		return $this->_query;
	}

	/**
	 * Insert data into a table
	 *
	 * @param string $table
	 * @param array $record
	 * @param bool $quote
	 * @param bool $purge
	 * @return record id/false
	 */
	public function insert($table, $record, $purge = true) {
		if (is_array($record)) {
			$allowed = $this->getFields($table);
			foreach ($record as $field => $value) {
				if (in_array($field, $allowed) && !is_numeric($field)) {
					$fields[] = "`$field`";
					$values[] = ($value==='NULL') ? 'NULL' : $this->sqlSafe($value, true);
				}
			}
			if (!empty($fields) && !empty($values)) {
				$this->_query = "INSERT INTO `{$this->_prefix}$table` (".implode(',', $fields).') VALUES ('.implode(',', $values).');';
				$this->_execute(false);
				$affected = ($this->affected() > 0);
				if ($purge && $affected) {
					Cache::getInstance()->clear('SQL');
				}
				$insert_id = ($this->insertid()) ? $this->insertid() : true;
				return ($affected) ? $insert_id : false;
			}
		}

		return false;
	}

	/**
	 * Execute a misc query
	 *
	 * @param string $query
	 * @return bool
	 */
	public function misc($query, $cache = true) {
		$this->_query = $query;
		$this->_execute($cache);
		return $this->_result;
	}

	/**
	 * GEt the number of rows
	 *
	 * @param string $query
	 * @param bool $cache
	 *
	 * @return int/false
	 */
	public function numrows($query = false, $cache = true) {
		/* commented out as it just doesn't work :( Boooooo
		if ($query && empty($this->_found_rows)) {
			$this->_query = $query;
			$this->_execute($cache);
		} else if (!empty($this->_found_rows)) {
			return $this->_found_rows;
		}
		return (!empty($this->_result)) ? count($this->_result) : false;
		*/
		$this->_query = $query;
		$this->_execute($cache);
		return (!empty($this->_result)) ? count($this->_result) : false;
	}

	/**
	 * Create a pagination
	 *
	 * @param int $total_results
	 * @param int $per_page
	 * @param int $page
	 * @param int $show
	 * @param string $var_name
	 * @param string $anchor
	 * @param string $glue
	 * @param bool $view_all
	 * @return string/false
	 */
	public function pagination($total_results = false, $per_page = 10, $page = 1, $show = 5, $var_name = 'page', $anchor = false, $glue = ' ', $view_all = true) {
		if (!$total_results && !is_null($this->_found_rows) && is_numeric($this->_found_rows)) {
			$total_results	= $this->_found_rows;
		}

		$glue = (!$glue) ? ' ' : $glue;
		// Lets do some maths...
		$total_pages	= ceil($total_results/$per_page);

		if ($total_pages > 1) {
			// Get the current query string variables
			$url_elements = parse_url(html_entity_decode($_SERVER['REQUEST_URI']));
			$params = false;
			if (isset($url_elements['query']) && !empty($url_elements['query'])) {
				parse_str($url_elements['query'], $params);
				unset($params[$var_name], $params['print_hash']);
			}
			$anchor = ($anchor) ? "#$anchor" : '';

			if ($page >= $show - 1) {
				$params[$var_name] = 1;
			}
			if ($page > 1) {
				$params[$var_name] = $page - 1;
			}
			if ($page < (int)$total_pages) {
				$params[$var_name] = $page + 1;
			}

			$data = array(
				'anchor'		=> $anchor,
				'current'		=> "{$url_elements['path']}?",
				'page'			=> $page,
				'params'		=> $params,
				'http_params'	=> http_build_query($params),
				'show'			=> (int)$show,
				'total'			=> (int)$total_pages,
				'var_name'		=> $var_name,
				'view_all'		=> (bool)$view_all,
			);
			$GLOBALS['smarty']->assign($data);
			return $GLOBALS['smarty']->fetch('templates/element.paginate.php');
		}

		return false;
	}

	/**
	 * Parse sql schema
	 *
	 * @param string $schema
	 * @return bool
	 */
	public function parseSchema($schema = false) {
		if (!empty($schema)) {
			$log = null;
			$queries = preg_split("/;\s?(#EOQ|[\n\r])/i", $schema, -1, PREG_SPLIT_NO_EMPTY);
			if (is_array($queries)) {
				
				$default_lang = (isset($_SESSION['setup']['long_lang_identifier']) && !empty($_SESSION['setup']['long_lang_identifier'])) ? $_SESSION['setup']['long_lang_identifier'] : 'en-US';
				
				foreach ($queries as $i => $query) {
					if (!empty($this->_prefix)) {
						$query	= str_replace(array('CubeCart_','{%DEFAULT_EN-XX%}'), array($this->_prefix.'CubeCart_',$default_lang), $query);
					}
					$query	= trim($query);
					if (!empty($query)) {
						$this->query($query, false, 0, false);
					}
				}
				return true;
			}
		}

		return false;
	}

	/**
	 * Query DB
	 *
	 * @param string $query
	 * @param int $maxRows
	 * @param int $page
	 * @param bool $cache
	 * @return result/false
	 */
	public function query($query, $maxRows = false, $page = 0, $cache = true) {
		// For old fashioned 'hand written' queries
		$limit = '';
		if (is_numeric($maxRows)) {
			
			$page 	 = intval($page);
			$maxRows = intval($maxRows);
		
			if ($page > 0) {
				$limit = "LIMIT $maxRows OFFSET ".($page - 1) * $maxRows;
			} else {
				if (strtolower($page) == 'all') {
					// Limit to 100 to prevent servers snapping in half
					$maxRows = 100;
					$limit = "LIMIT $maxRows";
				} else {
					$limit = "LIMIT $maxRows";
				}
			}
		}
		$this->_query = $query.' '.$limit;
		$this->_execute($cache);

		return (!$this->error()) ? $this->_result : false;
	}

	/**
	 * SELECT query
	 *
	 * @param string $table
	 * @param array $columns
	 * @param string $where
	 * @param string $order
	 * @param int $maxRows
	 * @param int $page
	 * @param bool $cache
	 * @return bool
	 */
	public function select($table, $columns = false, $where = false, $order = false, $maxRows = false, $page = false, $cache = true) {
		
		$table_where = $table;
		
		if(!stristr($table,'JOIN')) {
			// Build an SQL SELECT query the (almost) easy way
			$allowed = $this->getFields($table);
			$wrapper = '`';
			$prefix = $this->_prefix;	
		} else {
		    // Find the original table in JOIN set
		    if (preg_match('#^`(.+)`[a-z ]+JOIN#i',$table, $match)) {
		    	$table_where = str_replace($this->_prefix,'',$match[1]);
		    }
			$wrapper = '';
			$prefix = '';
		}
		
		if ($columns) {
			if (is_array($allowed) && is_array($columns)) {
				foreach ($columns as $key => $field) {
					if (in_array($field, $allowed) && !is_numeric($field)) {
						if (!is_numeric($key) && in_array(strtoupper($key), array('DISTINCT'))) {
							$group_by[]	= $field;
							$cols[]		= "$key `$field`";
						} else if (!is_numeric($key) && in_array(strtoupper($key), array('MIN','MAX','SUM'))) {
							$cols[]		= "$key($field) AS {$key}_$field";
						} else {
							$cols[]		= "`$field`";
						}
					}
				}
			} else {
				$cols[] = $columns;
			}
		}

		$orderString = null;
		if ($order) {
			if (is_array($order)) {
				foreach ($order as $field => $sort) {
					if (in_array($field, $allowed)) {
						$orderArray[] = "`$field` ".$this->sqlSafe($sort);
					}
				}
				if (isset($orderArray) && is_array($orderArray)) {
					$orderString = 'ORDER BY '.implode(', ', $orderArray);
				}
			} else {
				$orderString = 'ORDER BY '.str_ireplace('ORDER BY', '', $this->sqlSafe($order));
			}
		}

		if (!$columns || !isset($cols)) $cols[] = '*';

		$limit		= null;
		$calc_rows	= null;
		$sql_cache	= null;

		if (is_numeric($maxRows)) {
			if (is_numeric($page)) {
				$limit = "LIMIT $maxRows OFFSET ".($page - 1) * $maxRows;
				// Auto Cleverness for pagination
				// This way makes the initial query marginally slower, but is faster than running a second query
				$calc_rows	= 'SQL_CALC_FOUND_ROWS';
			} else {
				if (strtolower($page) == 'all') {
					// Don't set a limit - show EVERYTHING
				} else {
					$limit = "LIMIT $maxRows";
				}
			}
		}
		$group = (isset($group_by) && is_array($group_by)) ? 'GROUP BY '.implode(',', $group_by) : '';

		$this->_query = "SELECT $sql_cache $calc_rows ".implode(', ', $cols)." FROM $wrapper{$prefix}$table$wrapper ".$this->where($table_where, $where)." $group $orderString $limit;";

		$this->_execute($cache);

		if (count($this->_result) >= 1 && is_array($this->_result)) {
			foreach ($this->_result as $row) {
				$output[] = $row;
			}
			// Added cleverness for auto pagination, without pissing around running a second query
			if (!is_null($calc_rows)) {
				$count	= $this->query('SELECT FOUND_ROWS() as Count;');
				if ($count) $this->_found_rows = $count[0]['Count'];
			}
			return ($output) ? $output : false;
		}
		return false;
	}

	/**
	 * Dump SQL data
	 *
	 * @param string $tableData
	 * @param bool $dropTables
	 * @param bool $incStructure
	 * @param bool $incRows
	 * @return string
	 */
	public function sqldumptable($tableData, $dropTables = false, $incStructure = true, $incRows = true) {
		$tabledump = '';
		if ($dropTables) {
			$tabledump .= "-- --------------------------------------------------------\n\nDROP TABLE IF EXISTS `".$tableData['Name']."`; #EOQ\n\n";
		}
		if ($incStructure) {
			$schema		= $this->query('SHOW CREATE TABLE `'.$tableData['Name'].'`');
			$tabledump .= "-- --------------------------------------------------------\n\n-- \n-- Table structure for table `".$tableData['Name']."`\n--\n\n";
			$tabledump .= $schema[0]['Create Table']; 
			$tabledump .= "; #EOQ\n\n";
		}
		if ($incRows) {
			## get data
			$this->_query = "SELECT * FROM ".$tableData['Name'];
			$this->_execute(false);
			$rows = $this->_result;
			if($rows) {
				$tabledump .="--\n-- Dumping data for table `".$tableData['Name']."`\n--\n\n";
				foreach($rows as $row) {
				$tabledump .= "INSERT INTO `".$tableData['Name']."` VALUES(";
				## get each field's data
				$comma = false;
					foreach($row as $key => $value) {
						$tabledump .= $comma ? ', ' : '';
						$tabledump .= $this->sqlSafe($value,true);
						$comma = true;
					}
				$tabledump .= "); #EOQ\n";
				}
			} else {
				$tabledump .="-- Table `".$tableData['Name']."` has no data\n\n";
			}
		}
		return $tabledump;
	}

	/**
	 * Strip slashes
	 *
	 * @param string $input
	 * @return string
	 */
	public function strip_slashes($input) {
		// Strip slashes, unless it's serialized data
		if (!preg_match('#^\w:\d+:\{(.+)\}$#su', $input)) {
			$input	= stripslashes($input);
		}

		return $input;
	}

	/**
	 * TRUNCATE table
	 *
	 * @param string/array $input
	 *
	 * @return bool
	 */
	public function truncate($input) {
		if(is_array($input)) {
			$this->_query = '';
			$result = true;
			foreach ($input as $table) {
				$this->_query .= 'TRUNCATE `'.$this->_prefix.$table.'`; ';
				if (!$this->_execute(false))	{
					$result = false;
				}
			}
		} else {
			$this->_query = 'TRUNCATE `'.$this->_prefix.$input.'`; ';
			$result = $this->_execute(false);
		}

		return $result;
	}

	/**
	 * Update table
	 *
	 * @param string $table
	 * @param array $record
	 * @param string $where
	 * @param bool $purge
	 * @return bool
	 */
	public function update($table, $record, $where = '', $purge = true, $skip_math_fields = array()) {
		if (is_array($record)) {
			$allowed = $this->getFields($table);
			foreach ($record as $field => $value) {
				if (in_array($field, $allowed) && !is_numeric($field)) {
					$number = substr($value,1);
					if (!in_array($field,$skip_math_fields) && isset($value[0]) && is_numeric($number) && ($value[0] == '+' || $value[0] == '-')) {
						$set[]	= "`$field` = `$field` {$value[0]} ".$number;
					} else {
						$value	= (in_array($value, $this->_allowed_exceptions, true)) ? $value : $this->sqlSafe($value, true);
						$set[]	= "`$field` = $value";
					}
				}
			}
			if (!empty($set)) {
				$this->_query = "UPDATE `{$this->_prefix}$table` SET ".implode(',', $set).'  '.$this->where($table, $where).';';
				$result = $this->_execute(false);
				$affected = ($this->affected() > 0);
				if ($purge && $affected) {
					//Use the instance just in case the globals have already closed up
					Cache::getInstance()->clear('SQL');
				}
				return (bool)$result;
			}
		}
		return false;
	}

	/**
	 * Builds a WHERE string
	 *
	 * @param string $table
	 * @param array $whereArray
	 * @return string
	 */
	public function where($table, $whereArray = null) {
		if (!empty($whereArray)) {
			if (is_array($whereArray)) {
				$allowed = $this->getFields($table);
				foreach ($whereArray as $key => $value) {
					unset($symbol);
					if (is_array($value)) {
						foreach ($value as $val) {
							if (in_array($val, $allowed) && !is_numeric($val)) {
								if(isset($key[0]) && !ctype_alnum($key[0]) || $key[0]=='NULL' || is_null($key[0]) || $key[0]=='NOT NULL') {
									if (preg_match('#^([<>!~\+\-]=?)(.+)#', $key, $match)) {
										switch ($match[1]) {
											case '~':
												// Fuzzy searching
												$symbol	= 'LIKE';
												$key	= "%{$match[2]}%";
												break;
											default:
												$symbol	= $match[1];
												$key	= trim($match[2]);
										}
									}
								}
								
								if (strtoupper($key[0]) == 'NULL' || is_null($key[0])) { 
									$symbol = 'IS NULL';
									$where[] = "`$val` $symbol";
								} elseif (strtoupper($key[0])=='NOT NULL') { 
									$symbol = 'IS NOT NULL';
									$where[] = "`$val` $symbol";
								} else {
									$symbol = (isset($symbol)) ? $symbol : '=';
									$or[] = "`$val` $symbol ".$this->sqlSafe($key,true);
								}
								
							} else {
								foreach ($value as $i => $val) {
									if (empty($val)) unset($value[$i]);
								}
								if(count($value)>0) {
									if ($key[0] == '!') {
										$modifier	= 'NOT';
										$key		= substr($key, 1);
									} else {
										$modifier = '';
									}
									$or[] = "`$key` $modifier IN (".implode(',', $value).')';
								}
								break;
							}
						}
						if (isset($or) && is_array($or)) {
							$where[]	= implode(' OR ', $or);
							unset($or);
						}
					} else {
						if (is_array($allowed) && in_array($key, $allowed) && !is_numeric($key)) {
							if (isset($value) && !ctype_alnum($value) || $value=='NULL' || is_null($value) || $value=='NOT NULL') {
								if (preg_match('#^([<>!~\+\-]=?)(.+)#', $value, $match)) {
									switch ($match[1]) {
										case '~':
											// Fuzzy searching
											$symbol	= 'LIKE';
											$value	= "%{$match[2]}%";
											break;
										default:
											$symbol	= $match[1];
											$value	= trim($match[2]);
									}
								}
							}

							$full_key = $this->_prefix.$table.".".$key;

							if (strtoupper($value) == 'NULL' || is_null($value)) {
								$symbol = 'IS NULL';
								//$where[] = "`$key` $symbol";
								$where[] = "$full_key $symbol";
							} elseif (strtoupper($value)=='NOT NULL') { 
								$symbol = 'IS NOT NULL';
								//$where[] = "`$key` $symbol";
								$where[] = "$full_key $symbol";
							} else {
								$symbol = (isset($symbol)) ? $symbol : '=';
								//$where[] = "`$key` $symbol ".$this->sqlSafe($value,true);
								$where[] = "$full_key $symbol ".$this->sqlSafe($value,true);
							}
						} else {
							trigger_error("`$key` is not allowed as a key in '$table' table!");
						}
					}
				}
				return (!empty($where)) ? 'WHERE '.implode(' AND ', $where) : false;
			} else {
				return 'WHERE '.trim($whereArray);
			}
		}

		return false;
	}

	/**
	 * Get cached query
	 *
	 * @param string $query
	 * @return data/false
	 */
	protected function _getCached($query) {
		$query_hash = md5($query);
		$this->_cached = false;

		if (isset($GLOBALS['cache']) && is_object($GLOBALS['cache'])) {
			$this->_cached = true;
			return $GLOBALS['cache']->read("sql.$query_hash");
		}

		return false;
	}

	/**
	 * Log SQL errors
	 */
	protected function _logError() {
		$trace = debug_backtrace();
		Database::getInstance()->insert('CubeCart_system_error_log', array('message' => 'File: ['.basename($trace[2]['file']).'] Line: ['.$trace[2]['line'].'] "'.$this->_query.'" - '.$this->errorInfo(), 'time' => time()));
	}

	/**
	 * Sql debug
	 *
	 * @return bool
	 */
	protected function _sqlDebug($cache) {
		if (isset($GLOBALS['debug']) && $GLOBALS['debug'] instanceof Debug) {
			$message = "{$this->_query} -- ({$this->_query_time} sec)";
			if ($cache) {
				$message .= ' [CACHED]';
			}
			$GLOBALS['debug']->debugSQL('query', $message);
			$this->_error = ($this->error()) ? $this->error().': '.$this->errorInfo() : false;
			$this->_query = null;
			$GLOBALS['debug']->debugSQL('error', $this->_error);
		}

		return $this->error();
	}

	/**
	 * Starts a timer for a query
	 */
	protected function _startTimer() {
    	$this->_query_time	= microtime(true);
	}

	/**
	 * Stops a timer
	 */
	protected function _stopTimer() {
		$this->_query_time	= microtime(true) - $this->_query_time;
	}

	/**
	 * Write data to cached query
	 *
	 * @param mixed $data
	 * @param string $query
	 * @return bool
	 */
	protected function _writeCache($data, $query) {
		$query_hash = md5($query);
		if (isset($GLOBALS['cache']) && is_object($GLOBALS['cache'])) {
			return $GLOBALS['cache']->write($data, 'sql.'.$query_hash);
		}

		return false;
	}
}