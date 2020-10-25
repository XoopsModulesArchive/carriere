<?php

include 'header.php';
require XOOPS_ROOT_PATH . '/header.php';
require_once __DIR__ . '/include/functions.php';
require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';
$myts = MyTextSanitizer::getInstance();
$eh = new ErrorHandler();

global $xoopsDB, $xoopsTpl, $xoopsConfig, $xoopsModule, $xoopsModuleConfig;
$GLOBALS['xoopsOption']['template_main'] = 'carriere_index.html';
$intro = $myts->displayTarea($xoopsModuleConfig['evintro'], 1, 0, 1, 0);

//Liste 5 témoignage alléatoire
$result = $xoopsDB->query('SELECT id, quote_nom, quote_pict, quote_titreposte, quote_quotetitle FROM ' . $xoopsDB->prefix($module_tables[5]) . ' ORDER BY RAND() LIMIT 3');
$myts = MyTextSanitizer::getInstance();
while (false !== ($cat_data = $xoopsDB->fetchArray($result))) {
    $cat_data['quote_titreposte'] = reference('ev_titres', 'titres', 'id_titres', $cat_data['quote_titreposte']);

    $cat_data['quote_quotetitle'] = $myts->displayTarea($cat_data['quote_quotetitle']);

    $lien = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/temoignage.php?op=EVQuote&quote_id=';

    $temoignage['lien'] = $lien;

    $temoignage['id'] = $cat_data['id'];

    $temoignage['quote_nom'] = $cat_data['quote_nom'];

    $upldir = $xoopsModuleConfig['sbuploaddir_quote'];

    $picture = $cat_data['quote_pict'];

    $pict = XOOPS_URL . "$upldir/$picture";

    $temoignage['quote_pict'] = $pict;

    $temoignage['quote_titreposte'] = $cat_data['quote_titreposte'];

    $temoignage['quote_quotetitle'] = $cat_data['quote_quotetitle'];

    $temoignage['count'] = $i;

    $temoignage['fadeImage'] = 'style="filter:alpha(opacity=20);" onmouseover="nereidFade(this,100,30,5)" onmouseout="nereidFade(this,50,30,5)"';

    $xoopsTpl->append('temoignageliste', $temoignage);
}

$xoopsTpl->assign('lang_MENUTEMOIGNAGE', _MI_EV_MENUTEMOIGNAGE);
$xoopsTpl->assign('lang_MENUJOB', _MI_EV_MENUJOB);
$xoopsTpl->assign('lang_MENUDESCTITRE', _MI_EV_MENUDESCTITRE);

$xoopsTpl->assign('lang_TEMOIGNAGETITLE', _MI_EV_TEMOIGNAGEINDEXLIST);
$xoopsTpl->assign('LANG_viewotherquote', _MI_EV_VIEWOTHERQUOTE);

//Fin de la liste des 5 témoignage alléatoire

$modulelink = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname');

$xoopsTpl->assign('lang_EVTITLE', _MI_EV_TITLE);
$xoopsTpl->assign('EV_INTRO', $intro);
$xoopsTpl->assign('EV_LIENEMPLOIS', _MI_EV_LIENEMPLOIS);
$xoopsTpl->assign('EV_LIENTEMOIGNAGE', _MI_EV_LIENTEMOIGNAGE);

$xoopsTpl->assign('EV_LIENVALEUR', _MI_EV_LIENVALEUR);

$xoopsTpl->assign('EV_TEST', '<PRE>' . $module_tables[0] . 'TEST</PRE>');

include 'footer.php';
