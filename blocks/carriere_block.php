<?php

require_once XOOPS_ROOT_PATH . '/modules/carriere/include/functions.php';

// fonction pour l’affichage
function carriere_show()
{
    global $xoopsDB, $xoopsTpl;

    $url = XOOPS_URL . '/modules/carriere/';

    $xoopsTpl->assign('xoops_module_header', '<link rel="stylesheet" type="text/css" media="all" href=' . $url . 'include/carriere.css>');

    $block = [];

    $myts = MyTextSanitizer::getInstance();

    // requête sql

    //$sql = "SELECT id, title from ".$xoopsDB->prefix("ev_job")." ORDER BY posted_date LIMIT 4";

    //$result=$xoopsDB->queryF($sql);

    $result = $xoopsDB->query('SELECT id_job, id_titre, id_status FROM ' . $xoopsDB->prefix('ev_job') . ' ORDER BY  start_date', 5, 0);

    $i = 0;

    // construction du tableau pour le passage des données au template

    while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
        $message = [];

        //$message['id_job'] = $myrow['id_job'];

        if (1 == $myrow['id_status']) {
            $message['id_job'] = $i;

            $title = htmlspecialchars($myrow['id_titre'], ENT_QUOTES | ENT_HTML5);

            $title = reference('ev_titres', 'titres', 'id_titres', $title);

            $message['title'] = $title;

            //$message['date'] = formatTimestamp($myrow['post_time'],"s");

            $block['carriere'][] = $message;
        }

        $i += 1;
    }

    $block['bindex'] = _MB_EV_BINDEX;

    $block['blockdescription'] = _MB_EV_BLOCKDESCR;

    $block['viewall'] = _MB_EV_VIEWALL;

    return $block;
}
