<?php
if (!defined('CC_INI_SET'))	die('Access Denied');
Admin::getInstance()->permissions('settings', CC_PERM_READ, true);

global $lang;

if (isset($_GET['delete']) && Admin::getInstance()->permissions('settings', CC_PERM_DELETE)) {
	## Purge database
	if ($GLOBALS['language']->deleteLanguage($_GET['delete'])) {
		$GLOBALS['main']->setACPNotify($lang['translate']['notify_language_delete']);
	} else {
		$GLOBALS['main']->setACPWarning($lang['translate']['error_language_delete']);
	}
	httpredir(currentPage(array('delete')));
}

if (isset($_GET['download']) && Admin::getInstance()->permissions('settings', CC_PERM_READ)) {
	deliverFile(CC_ROOT_DIR.CC_DS.'language'.CC_DS.$_GET['download'].'.xml');
	exit;
}

if (isset($_POST['save']) && isset($_POST['string']) && Admin::getInstance()->permissions('settings', CC_PERM_EDIT)) {
	## Load all existing language strings
	$GLOBALS['language']->loadDefinitions($_GET['language']);
	$base_strings	= $GLOBALS['language']->loadLanguageXML($_GET['language']);

	# Save strings to Database
	$clear = false;
	foreach ($_POST['string'] as $type => $data) {
		foreach ($data as $name => $value) {
			$record	= array(
				'language'	=> $_GET['language'],
				'type'		=> $type,
				'name'		=> $name,
			);
			$basic = htmlspecialchars($base_strings[$type][$name], ENT_COMPAT, 'UTF-8', false);
			if ($basic != $value) {
				$GLOBALS['db']->delete('CubeCart_lang_strings', $record);
				$record['value'] = htmlspecialchars_decode($value, ENT_COMPAT);
				$GLOBALS['db']->insert('CubeCart_lang_strings', $record);
				$clear = true;
			}
		}
	}
	if ($clear) {
		$GLOBALS['cache']->clear('lang');
	}
	$GLOBALS['main']->setACPNotify($lang['translate']['notify_strings_update']);
	httpredir(currentPage());
}

if (isset($_POST['export']) && Admin::getInstance()->permissions('settings', CC_PERM_EDIT)) {
	$compress	= (isset($_POST['export_opt']['compress'])) ? (bool)$_POST['export_opt']['compress'] : false;
	$replace	= (isset($_POST['export_opt']['replace'])) ? (bool)$_POST['export_opt']['replace'] : false;

	if ($GLOBALS['language']->saveLanguageXML($_GET['export'], $compress, $replace)) {
		## Success!
		$GLOBALS['main']->setACPNotify($lang['email']['notify_export_language']);
	} else {
		## Epic Fail :(
		$GLOBALS['main']->setACPWarning($lang['email']['error_export']);
	}
	httpredir(currentPage(array('export'), array('language' => $_GET['export'])));
}

if (isset($_POST['type'])) {
	httpredir(currentPage(null, array('type' => $_POST['type'])));
}

$GLOBALS['gui']->addBreadcrumb('Languages');

if (isset($_GET['export'])) {
	## display the export options

	$GLOBALS['language']->loadLanguageXML($_GET['export']);
	$lang_info = $GLOBALS['language']->getLanguageInfo($_GET['export']);

	$GLOBALS['gui']->addBreadcrumb($lang_info['title'], currentPage(array('export'), array('language' => $_GET['export'])));
	$GLOBALS['gui']->addBreadcrumb($lang['translate']['merge_db_file'], currentPage());

	$GLOBALS['main']->addTabControl($lang['translate']['merge_db_file'], 'merge');
	if (function_exists('gzencode')) $GLOBALS['smarty']->assign('COMPRESSION', true);
	$GLOBALS['smarty']->assign('DISPLAY_EXPORT', true);


} elseif (isset($_GET['language'])) {
	
	//Security against ../ or ./
	if (isset($_REQUEST['type']) && $_REQUEST['type']{0} == '.') {
		die();
	}

	$GLOBALS['smarty']->assign('DISPLAY_EDITOR', true);
	
	$GLOBALS['language']->loadDefinitions($_GET['language']);
	
	$GLOBALS['language']->loadLanguageXML($_GET['language'], $_GET['language'],CC_LANGUAGE_DIR,true,false);
	$lang_info	= $GLOBALS['language']->getLanguageInfo($_GET['language']);
	$GLOBALS['gui']->addBreadcrumb($lang_info['title'], currentPage(array('type'), array('language' => $_GET['language'])));

	if (($groups = $GLOBALS['language']->getGroups()) !== false) {
		foreach ($groups as $group => $data) {
			$smarty_data['sections'][]	= array(
				'name'			=> $group,
				'description'	=> $lang['translate']['phrase_group_'.$group],
				'selected'		=> (isset($_REQUEST['type']) && $group == $_REQUEST['type']) ? 'selected="selected"' : '',
			);
		}
		$GLOBALS['smarty']->assign('SECTIONS', $smarty_data['sections']);
		## Assign module paths eeep!
		foreach (glob('modules'.CC_DS.'*'.CC_DS.'*'.CC_DS.'language'.CC_DS.'module.definitions.xml') as $path) {
		  	$modules[] = array(
		  		'path' => urlencode($path),
		  		'name' => $GLOBALS['language']->getFriendlyModulePath($path),
		  		'selected' => (isset($_REQUEST['type']) && $path == $_REQUEST['type']) ? 'selected="selected"' : '',
		  	);
		}
		$GLOBALS['smarty']->assign('MODULES', $modules);
	}

	if (isset($_REQUEST['type'])) {
		if (file_exists($_REQUEST['type']) && stripos($_REQUEST['type'],"modules")!==FALSE) {
			$breadcrumb 	= $GLOBALS['language']->getFriendlyModulePath($_REQUEST['type']);
			$basename 		= basename($_REQUEST['type']);
			$module_name 	= $GLOBALS['language']->getFriendlyModulePath($_REQUEST['type'], true);
			$GLOBALS['language']->loadDefinitions($module_name, str_replace($basename, '', $_REQUEST['type']), $basename);

			$definitions = $GLOBALS['language']->getDefinitions($module_name);
			$type		= $module_name;
			$strings	= $GLOBALS['language']->getStrings($module_name);
			$custom		= $GLOBALS['language']->getCustom($module_name, $_GET['language']);
		} else {
			$breadcrumb = $_REQUEST['type'];
			$definitions = $GLOBALS['language']->getDefinitions($_REQUEST['type']);
			$type		= $_REQUEST['type'];
			$strings	= $GLOBALS['language']->getStrings($type);
			$custom		= $GLOBALS['language']->getCustom($type, $_GET['language']);
		}

		$GLOBALS['gui']->addBreadcrumb($breadcrumb, currentPage());

		$GLOBALS['smarty']->assign('STRING_TYPE', ucfirst($breadcrumb));
		## Load all strings for this section
		if (($definitions = $GLOBALS['language']->getDefinitions($_REQUEST['type'])) !== false) {
			if (!empty($definitions)) {
		        foreach ($definitions as $name => $data) {
		            $default = (isset($strings[$name])) ? $strings[$name] : $data['value'];
		            $defined = (isset($strings[$name]) || isset($custom[$name])) ? true : false;
		            $value = (isset($custom[$name])) ? $custom[$name] : $default;
		            $assign = array(
		                'name'		=> $name,
		                'type'		=> $type,
		                'default'	=> htmlspecialchars($default, ENT_COMPAT, 'UTF-8', false),
		                'value'		=> htmlspecialchars($value, ENT_COMPAT, 'UTF-8', false),
		                'defined'	=> (int)$defined,
		            );
		       		$smarty_data['strings'][] = $assign;
		        }
		    } else {
		    	// add-on language files
		        foreach ($strings as $name => $data) {
		            $default = (isset($strings[$name])) ? $strings[$name] : $data['value'];
		            $defined = (isset($strings[$name]) || isset($custom[$name])) ? true : false;
		            $value = (isset($custom[$name])) ? $custom[$name] : $default;
		            $assign = array(
		                'name'		=> $name,
		                'type'		=> $type,
		                'default'	=> htmlspecialchars($default, ENT_COMPAT, 'UTF-8', false),
		                'value'		=> htmlspecialchars($value, ENT_COMPAT, 'UTF-8', false),
		                'defined'	=> (int)$defined,
	                );
		            $smarty_data['strings'][] = $assign;
		        }
		    }
			if (!empty($custom)) {
				## For custom strings that aren't listed in the definitions file
				foreach ($custom as $name => $value) {
					continue;
				}
			}
			$GLOBALS['smarty']->assign('STRINGS', $smarty_data['strings']);
		}
	}
	$GLOBALS['main']->addTabControl($lang['translate']['tab_string_edit'], 'general');
	$GLOBALS['main']->addTabControl($lang['translate']['merge_db_file'], false, currentPage(array('language'), array('export' => $_GET['language'])));
} else {
	$GLOBALS['cache']->clear();
	if (!empty($_FILES['import']['tmp_name']['file'])) {
		if($GLOBALS['language']->importLanguage($_FILES['import'],$_POST['import']['overwrite'])) {
			$GLOBALS['main']->setACPNotify($lang['translate']['notify_language_import_success']);
		} else {
			$GLOBALS['main']->setACPWarning($lang['translate']['error_language_import_failed']);
		}
	} elseif (isset($_POST['create']) && !empty($_POST['create']['code'])) {
		if ($GLOBALS['language']->create($_POST['create'])) {
			$GLOBALS['main']->setACPNotify($lang['translate']['notify_language_create']);
			## Set status to disabled to begin with
			$GLOBALS['config']->set('languages', false, array($_POST['create']['code'] => false));
			httpredir(currentPage(null, array('language' => $_POST['create']['code'])));
		} else {
			$GLOBALS['main']->setACPWarning($lang['translate']['error_language_create']);
		}
	} elseif (isset($_POST['status']) && Admin::getInstance()->permissions('settings', CC_PERM_EDIT)) {
		if ($GLOBALS['config']->set('languages', false, $_POST['status'])) {
			$GLOBALS['main']->setACPNotify($lang['translate']['notify_language_status']);
		} else {
			$GLOBALS['main']->setACPWarning($lang['translate']['error_language_status']);
		}
		httpredir(currentPage());
	}
	$enabled	= $GLOBALS['config']->get('languages');

	$GLOBALS['main']->addTabControl($lang['translate']['title_languages'], 'lang_list');
	$GLOBALS['main']->addTabControl($lang['translate']['title_language_create'], 'lang_create');
	$GLOBALS['main']->addTabControl($lang['translate']['title_language_import'], 'lang_import');
	## List available language files
	if (($languageList = $GLOBALS['language']->listLanguages()) !== false) {
		foreach ($languageList as $code => $info) {
			$info['status'] = (isset($enabled[$code])) ? (int)$enabled[$code] : 1;
			if (file_exists('language'.CC_DS.'flags'.CC_DS.$info['code'].'.png')) {
				$info['flag']	= 'language/flags/'.$info['code'].'.png';
			} else {
				$info['flag']	= 'language/flags/unknown.png';
			}
			$info['edit']	= currentPage(null, array('language' => $info['code']));
			$info['delete']	= currentPage(null, array('delete' => $info['code']));
			$info['download']	= currentPage(null, array('download' => $info['code']));
			$smarty_data['languages'][]	= $info;
		}
		$GLOBALS['smarty']->assign('LANGUAGES', $smarty_data['languages']);
	}
}

$page_content = $GLOBALS['smarty']->fetch('templates/settings.language.php');