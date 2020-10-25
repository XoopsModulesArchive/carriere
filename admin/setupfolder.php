<?php

require dirname(__DIR__, 3) . '/include/cp_header.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require_once dirname(__DIR__) . '/include/functions.php';

if (file_exists('../language/' . $xoopsConfig['language'] . '/main.php')) {
    include '../language/' . $xoopsConfig['language'] . '/main.php';
} else {
    include '../language/french/main.php';
}
foreach ($_REQUEST as $a => $b) {
    $$a = $b;
}

require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';
$myts = MyTextSanitizer::getInstance();
$eh = new ErrorHandler();
xoops_cp_header();
menuprinc();

echo '<br> <br>';
foldertest(XOOPS_ROOT_PATH . $xoopsModuleConfig['sbuploaddir_cv']);
echo '<br> <br>';
foldertest(XOOPS_ROOT_PATH . $xoopsModuleConfig['sbuploaddir_quote']);
echo '<br> <br>';
echo _AM_EV_SETUPFOLDERTEST;
xoops_cp_footer();
