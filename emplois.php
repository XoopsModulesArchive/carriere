<?php

include 'header.php';
require XOOPS_ROOT_PATH . '/header.php';
require_once __DIR__ . '/include/functions.php';

$GLOBALS['xoopsOption']['template_main'] = 'carriere_joblist.html';

require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';
$myts = MyTextSanitizer::getInstance();
$eh = new ErrorHandler();

foreach ($_REQUEST as $a => $b) {
    $$a = $b;
}

function EVAdmin($ordre, $ordtype)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsTpl;

    if (1 == $ordtype) {
        $result = $xoopsDB->query('SELECT id_job, id_titre, id_typeposte, id_locations, posted_date, start_date, end_date, id_status FROM ' . $xoopsDB->prefix('ev_job') . " ORDER BY $ordre DESC");

        $newordtype = 1;

        $ordtype = 0;
    } elseif (0 == $ordtype) {
        $result = $xoopsDB->query('SELECT id_job, id_titre, id_typeposte, id_locations, posted_date, start_date, end_date, id_status FROM ' . $xoopsDB->prefix('ev_job') . " ORDER BY $ordre ASC");

        $newordtype = 0;

        $ordtype = 1;
    }

    //    WHERE id_status=1

    $myts = MyTextSanitizer::getInstance();

    $count = 0;

    $i = 0;

    while (false !== ($cat_data = $xoopsDB->fetchArray($result))) {
        $count += 1;

        if (1 == $cat_data['id_status']) {
            $cat_data['id_titre'] = reference('ev_titres', 'titres', 'id_titres', $cat_data['id_titre']);

            $cat_data['id_typeposte'] = reference('ev_typeposte', 'typeposte', 'id_typeposte', $cat_data['id_typeposte']);

            $cat_data['id_locations'] = reference('ev_locations', 'locations', 'id_locations', $cat_data['id_locations']);

            $cat_data['posted_date'] = formatTimestamp($cat_data['posted_date'], 'Y-m-d');

            $emplois['id'] = $cat_data['id_job'];

            $emplois['viewtitre'] = $cat_data['id_titre'];

            $emplois['typeposte'] = $cat_data['id_typeposte'];

            $emplois['locations'] = $cat_data['id_locations'];

            $emplois['jobposteddate'] = $cat_data['posted_date'];

            $emplois['count'] = $i;

            $xoopsTpl->append('emploisliste', $emplois);
        }

        $i += 1;
    }

    $xoopsTpl->assign('lang_JOBTITLE', _MI_EV_CHANGEMENUITEM);

    $xoopsTpl->assign('lang_VIEWID', _MI_EV_VIEWID);

    $xoopsTpl->assign('lang_VIEWTITRE', _MI_EV_VIEWTITRE);

    $xoopsTpl->assign('lang_VIEWTYPEPOSTE', _MI_EV_VIEWTYPEPOSTE);

    $xoopsTpl->assign('lang_VIEWLOCATION', _MI_EV_VIEWLOCATION);

    $xoopsTpl->assign('lang_VIEWPOSTEDDATE', _MI_EV_VIEWPOSTEDDATE);

    $xoopsTpl->assign('ordre', $ordre);

    $xoopsTpl->assign('ordtype', $ordtype);

    $xoopsTpl->assign('ordtypelink', $newordtype);
}

$op = $_POST['op'] ?? $_GET['op'] ?? 'main';
switch ($op) {
    case 'EVAdmin':
        EVAdmin($ordre, $ordtype);
        break;
    /*case "EVFullview":
    EVFullview($row_pos, $ordre);
    break;*/
    default:
        $ordre = 'posted_date';
        $ordtype = 1;
        EVAdmin($ordre, $ordtype);
        break;
}

include 'footer.php';
