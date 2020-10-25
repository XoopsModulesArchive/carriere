<?php

include '../../mainfile.php';
//include "include/common.php";
//require XOOPS_ROOT_PATH.'/modules/mymodule/functions.php';
$versioninfo = $moduleHandler->get($xoopsModule->getVar('mid'));
$module_tables = $versioninfo->getInfo('tables');
