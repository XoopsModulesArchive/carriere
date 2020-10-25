<?php

include 'header.php';
require XOOPS_ROOT_PATH . '/header.php';
require_once __DIR__ . '/include/functions.php';
require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';

$GLOBALS['xoopsOption']['template_main'] = 'carriere_temoignagelist.html';
$myts = MyTextSanitizer::getInstance();
$eh = new ErrorHandler();

foreach ($_REQUEST as $a => $b) {
    $$a = $b;
}

function liste()
{
    global $xoopsDB, $xoopsTpl, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $result = $xoopsDB->query('SELECT id, quote_nom, quote_titreposte, quote_quotetitle FROM ' . $xoopsDB->prefix($module_tables[5]));

    $myts = MyTextSanitizer::getInstance();

    $i = 0;

    while (false !== ($cat_data = $xoopsDB->fetchArray($result))) {
        $i++;

        $cat_data['quote_titreposte'] = reference('ev_titres', 'titres', 'id_titres', $cat_data['quote_titreposte']);

        $cat_data['quote_quotetitle'] = $myts->displayTarea($cat_data['quote_quotetitle']);

        $lien = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/temoignage.php?op=EVQuote&quote_id=';

        $temoignage['lien'] = $lien;

        $temoignage['id'] = $cat_data['id'];

        $temoignage['quote_nom'] = $cat_data['quote_nom'];

        $temoignage['quote_titreposte'] = $cat_data['quote_titreposte'];

        $temoignage['quote_quotetitle'] = $cat_data['quote_quotetitle'];

        $temoignage['count'] = $i;

        $xoopsTpl->append('temoignageliste', $temoignage);
    }

    $xoopsTpl->assign('lang_TEMOIGNAGETITLE', _MI_EV_TEMOIGNAGELIST);
}

$op = $_POST['op'] ?? $_GET['op'] ?? 'main';
switch ($op) {
    case 'liste':
        liste($ordre);
        break;
    /*case "EVFullview":
    EVFullview($row_pos, $ordre);
    break;*/
    default:
        //$ordre = "id_job";
        liste();
        break;
}

include 'footer.php';
