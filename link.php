<?php

include 'header.php';
require XOOPS_ROOT_PATH . '/header.php';
require_once __DIR__ . '/include/functions.php';
require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';
$myts = MyTextSanitizer::getInstance();
$eh = new ErrorHandler();

global $xoopsModuleConfig;
$GLOBALS['xoopsOption']['template_main'] = 'carriere_index.html';
$xoopsTpl->assign('lang_EVTITLE', _MI_EV_TITLE);
$xoopsTpl->assign('EV_INTRO', $xoopsModuleConfig['evintro']);

include 'footer.php';
