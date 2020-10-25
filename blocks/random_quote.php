<?php

require_once XOOPS_ROOT_PATH . '/modules/carriere/include/functions.php';

function random_quote_show()
{
    global $xoopsDB, $xoopsModuleConfig, $xoopsConfig, $xoopsModule;

    $myts = MyTextSanitizer::getInstance();

    $block = [];

    $result = $xoopsDB->query('SELECT id, quote_nom, quote_pict, quote_quotetitle, quote_titreposte, citation FROM ' . $xoopsDB->prefix('ev_quote') . ' ORDER BY RAND() LIMIT 1');

    [$id, $quote_nom, $quote_pict, $quote_quotetitle, $quote_titreposte, $citation] = $xoopsDB->fetchRow($result);

    $titreposteid = $quote_titreposte;

    $quote_titreposte = reference('ev_titres', 'titres', 'id_titres', $quote_titreposte);

    $hModule = xoops_getHandler('module');

    $hModConfig = xoops_getHandler('config');

    $smartModule = $hModule->getByDirname('carriere');

    $smartConfig = &$hModConfig->getConfigsByCat(0, $smartModule->getVar('mid'));

    $upldir = $smartConfig['sbuploaddir_quote'];

    $pict = XOOPS_URL . "$upldir/$quote_pict";

    $quote_quotetitle = htmlspecialchars($quote_quotetitle, ENT_QUOTES | ENT_HTML5);

    $block['quote_id'] = $id;

    $block['quote_nom'] = $quote_nom;

    $block['quote_titreposte'] = $quote_titreposte;

    $block['quote_pict'] = $pict;

    $block['quote_quotetitle'] = $quote_quotetitle;

    $block['quote_titreposte'] = $quote_titreposte;

    $block['titreposte_id'] = $titreposteid; //adfads

    return $block;
}
