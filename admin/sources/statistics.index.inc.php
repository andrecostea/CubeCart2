<?php
if (!defined('CC_INI_SET')) die('Access Denied');
Admin::getInstance()->permissions('statistics', CC_PERM_READ, true);

global $lang;

if (isset($_POST['select'])) {
	httpredir(currentPage(null, $_POST['select']));
}

// PHPlot
$graph	= new PHPlot;
$graph->SetIsInline(true);
$graph->SetPlotType('bars');
$graph->SetNumXTicks(1);
$graph->SetSkipRightTick(true);
$graph->SetSkipLeftTick(true);

$select['year']		= (isset($_GET['year']) && is_numeric($_GET['year'])) ? (int)$_GET['year'] : date('Y');
$select['month']	= (isset($_GET['month']) && in_array($_GET['month'], range(1, 12))) ? str_pad((int)$_GET['month'], 2, '0', STR_PAD_LEFT) : date('m');
$select['day']		= (isset($_GET['day']) && in_array($_GET['day'], range(1, 31))) ? str_pad((int)$_GET['day'], 2, '0', STR_PAD_LEFT) : date('d');

$select['status']	= (isset($_GET['status']) && in_array($_GET['status'], range(1,6))) ? (int)$_GET['status'] : 3;

// Sales
$GLOBALS['main']->addTabControl($lang['statistics']['title_sales'], 'stats_sales');
$earliest_order	= $GLOBALS['db']->select('CubeCart_order_summary', array('MIN' => 'order_date'), array('status' => $select['status']), array('order_date' => 'ASC'));
// $earliest_order will always return true but MIN_order_date may not have a value

$yearly = $monthly = $daily = $hourly = array();

if (!empty($earliest_order[0]['MIN_order_date'])) {
	$earliest	= array(
		'year'	=> date('Y', $earliest_order[0]['MIN_order_date']),
		'month'	=> date('m', $earliest_order[0]['MIN_order_date']),
		'day'	=> date('d', $earliest_order[0]['MIN_order_date']),
	);

	$orders_all	= $GLOBALS['db']->select('CubeCart_order_summary', array('total', 'cart_order_id', 'order_date'), array('status' => (int)$select['status']));
	if ($orders_all) {
		foreach ($orders_all as $key => $data) {
			$orderdate	= array(
				'year'	=> date('Y', $data['order_date']),
				'month'	=> date('m', $data['order_date']),
				'day'	=> date('d', $data['order_date']),
				'hour'	=> date('H', $data['order_date']),
			);
			if (!isset($yearly[$orderdate['year']])) {
				$yearly[$orderdate['year']] = 0;
			}
			$yearly[$orderdate['year']] += $data['total'];
			if ($orderdate['year'] == $select['year']) {
				// Fetch Months
				if (!isset($monthly[$orderdate['month']])) {
					$monthly[$orderdate['month']] = 0;
				}
				$monthly[$orderdate['month']] += $data['total'];
				if ($orderdate['month'] == $select['month']) {
					// Fetch Days
					if (!isset($daily[$orderdate['day']])) {
						$daily[$orderdate['day']] = 0;
					}
					$daily[$orderdate['day']] += $data['total'];
					if ($orderdate['day'] == $select['day']) {
						// Fetch Hours
						if (!isset($hourly[$orderdate['hour']])) {
							$hourly[$orderdate['hour']] = 0;
						}
						$hourly[$orderdate['hour']]	+= $data['total'];
					}
				}
			}
		}
	}

	$now['year'] = date('Y');
	for ($i = $earliest['year'];$i <= $now['year']; ++$i) {
		$selected	= ($select['year'] == $i) ? ' selected="selected"' : '';
		$smarty_data['years'][]	= array('value' => $i, 'selected' => $selected);
	}
	$GLOBALS['smarty']->assign('YEARS', $smarty_data['years']);

	if (count($yearly) >= 1) {
		$max = 0;
		for ($i = $earliest['year']; $i <= $now['year']; ++$i) {
			$value = isset($yearly[$i]) ? $yearly[$i] : 0;
			if ($value > $max) {
				$max = $value;
			}
			$graph_data[] = array($i, $value);
		}
		$max = sigfig($max, 1);
		// PHPlot
		$filename	= 'cache.image.'.md5('yearly'.implode(',', $yearly)).'.png';
		$graph->PHPlot(480, 360, 'cache'.CC_DS.$filename);

		$graph->SetPlotAreaWorld(null, 0, null, null);
		$graph->SetDataValues($graph_data);
		$title = ($earliest['year'] == $now['year']) ? sprintf($lang['statistics']['sales_in'], $now['year']) : sprintf($lang['statistics']['sales_from_to'], $earliest['year'], $now['year']);
		$graph->SetYTitle(sprintf($lang['statistics']['sales_volume'], $GLOBALS['config']->get('config', 'default_currency')));
		$graph->setTitle($title);
		$graph->DrawGraph();
		unset($graph_data);
		$files['yearly'] = $filename;

	}

	for ($i = 1; $i <= 12; ++$i) {
		$i				= str_pad($i, 2, '0', STR_PAD_LEFT);
		$value			= isset($monthly[$i]) ? $monthly[$i] : 0;
		$month_text		= date('F', mktime(0, 0, 0, $i, 1));
		$graph_data[]	= array(date('M', mktime(0, 0, 0, $i, 1)), $value);
		$monthList[$i]	= $month_text;
		$selected		= ((int)$select['month'] == (int)$i) ? ' selected="selected"' : '';
		$smarty_data['months'][]	= array('value' => $i, 'title' => $month_text, 'selected' => $selected);
	}
	$GLOBALS['smarty']->assign('MONTHS', $smarty_data['months']);
	// OFC

	// PHPlot
	$filename	= 'cache.image.'.md5('monthly'.implode(',', $monthly)).'.png';
	$graph->PHPlot(480, 360, 'cache'.CC_DS.$filename);
	$graph->SetPlotAreaWorld(null, 0, null, null);
	$graph->SetDataValues($graph_data);
	$graph->SetYTitle(sprintf($lang['statistics']['sales_volume'], $GLOBALS['config']->get('config', 'default_currency')));
	$graph->SetTitle(sprintf($lang['statistics']['sales_in_year'], $select['year']));
	$graph->DrawGraph();
	unset($graph_data);
	$files['monthly'] = $filename;
	$monthLength	= date('t', mktime(0,0,0,$select['month'],1,$select['year']));
	for ($day = 1; $day <= $monthLength; ++$day) {
		$dayList[$day] = $day;
		$selected = ((int)$select['day'] == (int)$day) ? ' selected="selected"' : '';
		$smarty_data['days'][] = array('value' => $day, 'selected' => $selected);
	}
	$GLOBALS['smarty']->assign('DAYS', $smarty_data['days']);

	for ($i = 1;$i <= $monthLength; ++$i) {
		$i				= str_pad($i, 2, '0', STR_PAD_LEFT);
		$value			= isset($daily[$i]) ? $daily[$i] : 0;
		$graph_data[]	= array((int)$i, $value);
	}
	// OFC

	// PHPlot
	$filename	= 'cache.image.'.md5('daily'.implode(',', $daily)).'.png';
	$graph->PHPlot(480, 360, 'cache'.CC_DS.$filename);
	$graph->SetTitle(sprintf($lang['statistics']['sales_in_month_year'], $monthList[$select['month']], $select['year']));
	$graph->SetPlotAreaWorld(null, 0, null, null);
	$graph->SetDataValues($graph_data);
	$graph->SetYTitle(sprintf($lang['statistics']['sales_volume'], $GLOBALS['config']->get('config', 'default_currency')));
	$graph->DrawGraph();
	unset($graph_data);
	$files['daily'] = $filename;

	for ($i = 0; $i <= 23; ++$i) {
		$i				= str_pad($i, 2, '0', STR_PAD_LEFT);
		$value			= isset($hourly[$i]) ? $hourly[$i] : 0;
		$graph_data[]	= array($i, $value);
	}
	// OFC

	// PHPlot
	if (isset($hourly) && is_array($hourly)) {
		$filename = 'cache.image.'.md5('hourly'.implode(',', $hourly)).'.png';
	} else {
		$filename = 'cache.image.'.md5('hourly').'.png';
	}
	$graph->PHPlot(480, 360, 'cache'.CC_DS.$filename);
	$graph->SetPlotAreaWorld(null, 0, null, null);
	$graph->SetDataValues($graph_data);
	$graph->SetTitle(sprintf($lang['statistics']['sales_on_dmy'], $select['day'], $monthList[$select['month']], $select['year']));
	$graph->SetYTitle(sprintf($lang['statistics']['sales_volume'], $GLOBALS['config']->get('config', 'default_currency')));
	$graph->DrawGraph();
	unset($graph_data);
	$files['hourly'] = $filename;

	if (isset($files)) {
		$GLOBALS['smarty']->assign('GRAPH', $files);
	}
	// Populate dropdowns
	$select_options	= array('month'	=> $monthList);
	$GLOBALS['smarty']->assign('DISPLAY_SALES',true);

}

#############################################
// Percentages

// Product Sales
$per_page	= 15;
$page	= (isset($_GET['page_sales']) && is_numeric($_GET['page_sales'])) ? $_GET['page_sales'] : 1;
$query	= "SELECT sum(O.quantity) AS quan, O.product_id, I.name FROM `".$glob['dbprefix']."CubeCart_order_inventory` AS O INNER JOIN `".$glob['dbprefix']."CubeCart_order_summary` AS S ON S.cart_order_id = O.cart_order_id INNER JOIN `".$glob['dbprefix']."CubeCart_inventory` AS I ON O.product_id = I.product_id WHERE (S.`status` = 2 OR S.`status` = 3) GROUP BY I.product_id DESC ORDER BY `quan` DESC";

if (($results = $GLOBALS['db']->query($query, $per_page, $page)) !== false) {
	$GLOBALS['main']->addTabControl($lang['statistics']['title_popular'], 'stats_prod_sales');
	$numrows = $GLOBALS['db']->numrows($query);
	$divider = $GLOBALS['db']->query("SELECT SUM(quantity) as totalProducts FROM  `".$glob['dbprefix']."CubeCart_order_inventory`");
	$max_percent = 0;
	foreach ($results as $key => $result) {
		$result['key']		= (($page-1)*$per_page)+($key+1);
		$result['percent']	= 100*($result['quan']/$divider[0]['totalProducts']);
		$max_percent = ($result['percent']>$max_percent) ? $result['percent'] : $max_percent;
		$result['percent']	= number_format($result['percent'], 2);
		$graph_data[]		= array($result['key'], $result['percent']);
		// Create a product legend
		$smarty_data['product_sales'][]	= $result;
	}
	$GLOBALS['smarty']->assign('PRODUCT_SALES',$smarty_data['product_sales']);
	$filename	= 'cache.image.'.md5($query).'_'.$page.'.png';
	$graph->SetPlotAreaWorld(null, 0, null, number_format($max_percent,2));
	$graph->PHPlot(480, 360, 'cache'.CC_DS.$filename);
	$graph->SetDataValues($graph_data);
	$graph->SetYTitle($lang['statistics']['percentage_of_sales']);
	$graph->SetTitle('');
	$graph->DrawGraph();

	$GLOBALS['smarty']->assign('GRAPH_IMAGE_SALES', $filename);
	$GLOBALS['smarty']->assign('PAGINATION_SALES', $GLOBALS['db']->pagination($numrows, $per_page, $page, 5, 'page_sales', 'stats_prod_sales', ' ', false));
	unset($results,$result,$graph_data,$divider);
}

## Product Views
$per_page	= 15;
$page	= (isset($_GET['page_views']) && is_numeric($_GET['page_views'])) ? $_GET['page_views'] : 1;
$query		= "SELECT `popularity`, `name` FROM `".$glob['dbprefix']."CubeCart_inventory` WHERE `popularity` > 0 ORDER BY `popularity` DESC ";
$results	= $GLOBALS['db']->query($query, $per_page, $page);
if ($results) {
	$GLOBALS['main']->addTabControl($lang['statistics']['title_viewed'], 'stats_prod_views');
	$numrows	= $GLOBALS['db']->numrows($query);
	$divider	= $GLOBALS['db']->query('SELECT SUM(popularity) as `totalHits` FROM  `'.$glob['dbprefix'].'CubeCart_inventory`');
	$max_percent = 0;
	foreach ($results as $key => $result) {
		$result['key']		= (($page-1)*$per_page)+($key+1);
		$result['percent']	= (100*($result['popularity']/$divider[0]['totalHits']));
		$max_percent = ($result['percent']>$max_percent) ? $result['percent'] : $max_percent;
		$result['percent']	= number_format($result['percent'], 2);
		$graph_data[]		= array($result['key'], $result['percent']);
		// Create a product legend
		$smarty_data['product_views'][]	= $result;
	}
	$GLOBALS['smarty']->assign('PRODUCT_VIEWS', $smarty_data['product_views']);

	$filename = 'cache.image.'.md5($query).'_'.$page.'.png';
	$graph->SetPlotAreaWorld(null, 0, null, number_format($max_percent,2));
	$graph->PHPlot(480, 360, 'cache'.CC_DS.$filename);
	$graph->SetDataValues($graph_data);
	$graph->SetYTitle($lang['statistics']['percentage_of_views']);
	$graph->SetTitle('');
	$graph->DrawGraph();

	$GLOBALS['smarty']->assign('GRAPH_IMAGE_VIEWS', $filename);
	$GLOBALS['smarty']->assign('PAGINATION_VIEWS', $GLOBALS['db']->pagination($numrows, $per_page, $page, 5, 'page_views', 'stats_prod_views', ' ', false));
	unset($results,$result,$graph_data,$divider);
}

// Search Popularity
$per_page	= 15;
$page		= (isset($_GET['page_search']) && is_numeric($_GET['page_search'])) ? $_GET['page_search'] : 1;
$query		= 'SELECT * FROM `'.$glob['dbprefix'].'CubeCart_search` ORDER BY hits DESC';
if (($results = $GLOBALS['db']->query($query, $per_page, $page)) !== false) {
	$GLOBALS['main']->addTabControl($lang['statistics']['title_search'], 'stats_search');
	$numrows	= $GLOBALS['db']->numrows($query);
	$divider	= $GLOBALS['db']->query("SELECT SUM(hits) as `totalHits` FROM  `".$glob['dbprefix']."CubeCart_search`");
	$max_percent = 0;
	foreach ($results as $key => $result) {
		$result['percent']		= 100*($result['hits']/$divider[0]['totalHits']);
		$max_percent = ($result['percent']>$max_percent) ? $result['percent'] : $max_percent;
		$result['percent']	= number_format($result['percent'], 2);
		$result['key']			= (($page-1)*$per_page)+($key+1);
		$result['searchstr'] 	= ucfirst(strtolower($result['searchstr']));
		$graph_data[]			= array($result['key'], $result['percent']);
		$smarty_data['search_terms'][]	= $result;
	}
	$GLOBALS['smarty']->assign('SEARCH_TERMS', $smarty_data['search_terms']);
	$filename = 'cache.image.'.md5($query).'_'.$page.'.png';
	$graph->SetPlotAreaWorld(null, 0, null, number_format($max_percent,2));
	$graph->PHPlot(480, 360, 'cache'.CC_DS.$filename);
	$graph->SetDataValues($graph_data);
	$graph->SetXTitle($lang['statistics']['search_term']);
	$graph->SetYTitle($lang['statistics']['percentage_of_search']);
	$graph->SetTitle('');
	$graph->DrawGraph();

	$GLOBALS['smarty']->assign('GRAPH_IMAGE_SEARCH', $filename);
	$GLOBALS['smarty']->assign('PAGINATION_SEARCH', $GLOBALS['db']->pagination($numrows, $per_page, $page, 5, 'page_search', 'stats_search', ' ', false));
	unset($results,$result,$graph_data,$divider);
}
// Best Customers
$per_page = 15;
$page = (isset($_GET['page_customers']) && is_numeric($_GET['page_customers'])) ? $_GET['page_customers'] : 1;
$query = "SELECT sum(`total`) as `customer_expenditure`, C.first_name, C.last_name, C.title FROM `".$glob['dbprefix']."CubeCart_order_summary` as O INNER JOIN  `".$glob['dbprefix']."CubeCart_customer` as C on O.customer_id = C.customer_id WHERE O.status = 3 GROUP BY O.customer_id ORDER BY `customer_expenditure` DESC";
if (($results = $GLOBALS['db']->query($query, $per_page, $page)) !== false) {
	$GLOBALS['main']->addTabControl($lang['statistics']['title_customers_best'], 'stats_best_customers');
	$numrows	= $GLOBALS['db']->numrows($query);
	$divider	= $GLOBALS['db']->query("SELECT sum(`total`) as `total_sales` FROM `".$glob['dbprefix']."CubeCart_order_summary` WHERE `status` = 3");
	foreach ($results as $key => $result) {
		$result['key']		= (($page-1)*$per_page)+($key+1);
		$result['expenditure'] = Tax::getInstance()->priceFormat($result['customer_expenditure']);
		$result['percent']	= number_format(100*($result['customer_expenditure']/$divider[0]['total_sales']), 2);
		$graph_data[]		= array($result['key'], $result['customer_expenditure']);
		// Create a customer legend
		$smarty_data['best_customers'][] = $result;
	}
	$GLOBALS['smarty']->assign('BEST_CUSTOMERS', $smarty_data['best_customers']);

	$filename = 'cache.image.'.md5($query).'_'.$page.'.png';
	$graph->SetPlotAreaWorld(null, 0, null, null);
	$graph->PHPlot(480, 360, 'cache'.CC_DS.$filename);
	$graph->SetDataValues($graph_data);
	$graph->SetYTitle($lang['statistics']['total_expenditure']);
	$graph->SetTitle('');
	$graph->DrawGraph();

	$GLOBALS['smarty']->assign('GRAPH_IMAGE_BEST', $filename);
	$GLOBALS['smarty']->assign('PAGINATION_BEST', $GLOBALS['db']->pagination($numrows, $per_page, $page, 5, 'page_customers', 'stats_best_customers', ' ', false));
	unset($results,$result,$graph_data,$divider);
}

// Customers Online
$timeLimit	= time()-1800;  // 30 minutes
$query		= sprintf("SELECT * FROM %1\$sCubeCart_sessions AS S LEFT JOIN %1\$sCubeCart_customer AS C ON S.customer_id = C.customer_id WHERE S.session_last>".$timeLimit." ORDER BY S.session_last DESC", $glob['dbprefix']);
if (($results = $GLOBALS['db']->query($query)) !== false) {
	$GLOBALS['main']->addTabControl($lang['statistics']['title_customers_active'], 'stats_online', false, false, count($results));
	foreach ($results as $user) {
		$user['is_admin']		= ((int)$user['admin_id'] > 0) ? 1 : 0;
		$user['name']			= ((int)$user['customer_id'] != 0) ? sprintf('%s %s', $user['first_name'], $user['last_name']) : $lang['common']['guest'];
		$user['session_length']	= sprintf('%.2f', ($user['session_last']-$user['session_start'])/60);
		$user['session_start']	= formatTime($user['session_start']);
		$user['session_last']	= formatTime($user['session_last']);
		$smarty_data['users_online'][]	= $user;
	}
	$GLOBALS['smarty']->assign('USERS_ONLINE',$smarty_data['users_online']);
}
$page_content = $GLOBALS['smarty']->fetch('templates/statistics.index.php');