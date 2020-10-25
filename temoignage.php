<?php

include 'header.php';
require XOOPS_ROOT_PATH . '/header.php';
require_once __DIR__ . '/include/functions.php';
require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';
$GLOBALS['xoopsOption']['template_main'] = 'carriere_temoignageview.html';
$myts = MyTextSanitizer::getInstance();
$eh = new ErrorHandler();

foreach ($_REQUEST as $a => $b) {
    $$a = $b;
}

function EVQuote($quote_id)
{
    global $xoopsDB, $xoopsTpl, $xoopsConfig, $xoopsModule, $xoopsModuleConfig;

    $result = $xoopsDB->query('SELECT id, quote_nom, quote_pict, quote_titreposte, quote_typeposte, quote_location, quote_experience, quote_quotetitle, citation FROM ' . $xoopsDB->prefix('ev_quote') . " WHERE id=$quote_id");

    [$id, $quote_nom, $quote_pict, $quote_titreposte, $quote_typeposte, $quote_location, $quote_experience, $quote_quotetitle, $citation] = $xoopsDB->fetchRow($result);

    $myts = MyTextSanitizer::getInstance();

    $titreposteid = $quote_titreposte;

    $quote_titreposte = reference('ev_titres', 'titres', 'id_titres', $quote_titreposte);

    $quote_typeposte = reference('ev_typeposte', 'typeposte', 'id_typeposte', $quote_typeposte);

    $quote_location = reference('ev_locations', 'locations', 'id_locations', $quote_location);

    $citation = $myts->displayTarea($citation);

    $quote_experience = $myts->displayTarea($quote_experience);

    $quote_quotetitle = $myts->displayTarea($quote_quotetitle);

    $upldir = $xoopsModuleConfig['sbuploaddir_quote'];

    $pict = XOOPS_URL . "$upldir/$quote_pict";

    $xoopsTpl->assign('id', $id);

    $xoopsTpl->assign('quote_nom', $quote_nom);

    $xoopsTpl->assign('quote_pict', $pict);

    $xoopsTpl->assign('quote_titreposte', $quote_titreposte);

    $xoopsTpl->assign('quote_typeposte', $quote_typeposte);

    $xoopsTpl->assign('quote_location', $quote_location);

    $xoopsTpl->assign('quote_experience', $quote_experience);

    $xoopsTpl->assign('quote_quotetitle', $quote_quotetitle);

    $xoopsTpl->assign('citation', $citation);

    $xoopsTpl->assign('LANG_typeposte', _MI_EV_TYPEPOSTE);

    $xoopsTpl->assign('LANG_nom', _MI_EV_NOM);

    $xoopsTpl->assign('LANG_titreposte', _MI_EV_POSTEOCCUPE);

    $xoopsTpl->assign('LANG_location', _MI_EV_LOCATIONS);

    $xoopsTpl->assign('LANG_experience', _MI_EV_EXPERIENCE);

    $xoopsTpl->assign('LANG_viewotherquote', _MI_EV_VIEWOTHERQUOTE);

    $xoopsTpl->assign('titreposte_id', $titreposteid);
}

$op = $_POST['op'] ?? $_GET['op'] ?? 'main';
switch ($op) {
    case 'EVQuote':
        EVQuote($quote_id);
        break;
    default:
        redirect_header('emplois.php', 1, _MI_EV_RETURNTOINDEX);
        exit;
        break;
}

include 'footer.php';
