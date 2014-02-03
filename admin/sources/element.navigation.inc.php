<?php
if(!defined('CC_DS')) die('Access Denied');
$nav_sections	= array(
	'customers'		=> $lang['navigation']['nav_customers'],
	'inventory'		=> $lang['navigation']['nav_inventory'],
	'filemanager'	=> $lang['navigation']['nav_file_manager'],
	'settings'		=> $lang['navigation']['nav_settings'],
	'modules'		=> $lang['navigation']['nav_modules'],
	'advanced'		=> $lang['navigation']['nav_advanced'],
);

$nav_items['customers']		= array(
	$lang['navigation']['nav_customer_list']	=> '?_g=customers',
	$lang['navigation']['nav_orders']			=> '?_g=orders',
	$lang['navigation']['nav_transaction_logs']	=> '?_g=orders&amp;node=transactions',
	$lang['navigation']['nav_newsletters']		=> '?_g=customers&amp;node=email',
);

$nav_items['inventory']		= array(
	$lang['navigation']['nav_categories']		=> '?_g=categories',
	$lang['navigation']['nav_products']			=> '?_g=products',
	$lang['navigation']['nav_prod_reviews']		=> '?_g=products&amp;node=reviews',
	$lang['navigation']['nav_product_options']	=> '?_g=products&amp;node=options',
	$lang['navigation']['nav_coupons']			=> '?_g=products&amp;node=coupons',
	$lang['navigation']['nav_manufacturers']	=> '?_g=products&amp;node=manufacturers',
	$lang['navigation']['nav_cat_import']		=> '?_g=products&amp;node=import',
	$lang['navigation']['nav_cat_export']		=> '?_g=products&amp;node=export',
);

$nav_items['filemanager']	= array(
	$lang['navigation']['nav_documents']		=> '?_g=documents',
	$lang['navigation']['nav_downloads']		=> '?_g=filemanager&amp;mode=digital',
	$lang['navigation']['nav_images']			=> '?_g=filemanager',
	$lang['navigation']['nav_email_templates']	=> '?_g=documents&amp;node=email',
	$lang['navigation']['nav_contact_form']		=> '?_g=documents&amp;node=contact',
);

$nav_items['settings']		= array(
	$lang['navigation']['nav_administrators']	=> '?_g=settings&amp;node=admins',
	$lang['navigation']['nav_settings_store']	=> '?_g=settings',
	$lang['navigation']['nav_manage_hooks']		=> '?_g=settings&amp;node=hooks',
	$lang['navigation']['nav_certificates']		=> '?_g=settings&amp;node=giftCertificates',
	$lang['navigation']['nav_currencies']		=> '?_g=settings&amp;node=currency',
	$lang['navigation']['nav_taxes']			=> '?_g=settings&amp;node=tax',
	$lang['navigation']['nav_regions']			=> '?_g=settings&amp;node=geo',
	$lang['navigation']['nav_languages']		=> '?_g=settings&amp;node=language',
);

$nav_items['modules']		= array(
	$lang['navigation']['nav_plugins']			=> '?_g=modules&amp;type=plugins',
	$lang['navigation']['nav_affiliate']		=> '?_g=modules&amp;type=affiliate',
	$lang['navigation']['nav_gateway']			=> '?_g=modules&amp;type=gateway',
	$lang['navigation']['nav_shipping']			=> '?_g=modules&amp;type=shipping',
	$lang['navigation']['nav_social']			=> '?_g=modules&amp;type=social',
	$lang['navigation']['nav_external']			=> '?_g=modules&amp;type=external',
	$lang['navigation']['nav_livehelp']			=> '?_g=modules&amp;type=livehelp',
#	$lang['navigation']['nav_installer']		=> '?_g=modules&amp;type=installer',
);

$nav_items['advanced']		= array(
	$lang['navigation']['nav_statistics']		=> '?_g=statistics',
	$lang['navigation']['nav_sales_reports']	=> '?_g=reports',
	$lang['navigation']['nav_access_log']		=> '?_g=settings&amp;node=logs',
	$lang['navigation']['nav_error_log']		=> '?_g=settings&amp;node=errorlog',
	$lang['navigation']['nav_request_log']		=> '?_g=settings&amp;node=requestlog',
	$lang['navigation']['nav_maintenance']		=> '?_g=maintenance',
	$lang['navigation']['nav_server_info']		=> '?_g=misc&amp;node=server-info',
);

// Include menu item hooks
foreach ($GLOBALS['hooks']->load('admin.navigation') as $hook) include $hook;