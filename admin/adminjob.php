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
menujob();

function AdminJob($ordre)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule;

    OpenTable();

    echo "<h4 style='text-align:left;'>" . _AM_EV_CHANGEMENUITEM . "</h4>
        <form action='addserver.php' method='post'>
        <table border='0' cellpadding='0' cellspacing='0' valign='top' width='100%'>
        <tr>
        <td class='bg2'>
                <table width='100%' border='0' cellpadding='4' cellspacing='1'>
                <tr class='bg3'>
                <td><b><a href='adminjob.php?op=AdminJob&ordre=id_job'>" . _AM_EV_VIEWID . "</a></b></td>
                <td><b><a href='adminjob.php?op=AdminJob&ordre=id_titre'>" . _AM_EV_VIEWTITRE . "</a></b></td>
                <td><b><a href='adminjob.php?op=AdminJob&ordre=id_typeposte'>" . _AM_EV_VIEWTYPEPOSTE . "</a></b></td>
                <td><b><a href='adminjob.php?op=AdminJob&ordre=id_locations'>" . _AM_EV_VIEWLOCATION . "</a></b></td>
                <td><b><a href='adminjob.php?op=AdminJob&ordre=posted_date'>" . _AM_EV_VIEWPOSTEDDATE . "</a></b></td>
                <td><b><a href='adminjob.php?op=AdminJob&ordre=start_date'>" . _AM_EV_VIEWSTARTDDATE . "</a></b></td>
                <td><b><a href='adminjob.php?op=AdminJob&ordre=end_date'>" . _AM_EV_VIEWENDDATE . "</a></b></td>
                <td><b><a href='adminjob.php?op=AdminJob&ordre=id_status'>" . _AM_EV_VIEWSTATUS . '</a></b></td>
                <td><b>' . _AM_EV_VIEWFUNCTION . '</b></td>';

    $result = $xoopsDB->query('SELECT id_job, id_titre, id_typeposte, id_locations, posted_date, start_date, end_date, id_status FROM ' . $xoopsDB->prefix('ev_job') . " ORDER BY $ordre");

    $myts = MyTextSanitizer::getInstance();

    $i = 0;

    while (list($job_id, $titres_id, $typeposte_id, $locations_id, $jobposteddate, $jobstartdate, $jobenddate, $status_id) = $xoopsDB->fetchRow($result)) {
        //$description = htmlspecialchars($description);

        $titres = reference('ev_titres', 'titres', 'id_titres', $titres_id);

        $typeposte = reference('ev_typeposte', 'typeposte', 'id_typeposte', $typeposte_id);

        $locations = reference('ev_locations', 'locations', 'id_locations', $locations_id);

        $status = reference('ev_status', 'status', 'id_status', $status_id);

        $jobposteddate = formatTimestamp($jobposteddate, 'Y-m-d');

        $jobstartdate = formatTimestamp($jobstartdate, 'Y-m-d');

        $jobenddate = formatTimestamp($jobenddate, 'Y-m-d');

        echo "<tr class='bg1'><td align='right'>$job_id</td>";

        echo "<td>$titres</td>";

        echo "<td>$typeposte</td>";

        echo "<td>$locations</td>";

        echo "<td>$jobposteddate</td>";

        echo "<td>$jobstartdate</td>";

        echo "<td>$jobenddate</td>";

        echo "<td>$status</td>";

        echo "<td><a href='../adminjob.php?op=EVFullview&row_pos=$i&ordre=$ordre'>" . _AM_EV_VIEW . "</a>&nbsp;&nbsp;<a href='addjob.php?op=EVEdit&job_id=$job_id'>" . _AM_EV_EDIT . "</a><a href='addjob.php?op=EVDel&amp;job_id=$job_id&amp;ok=0'>" . _AM_EV_DELETE . '</a></td>
                </tr>';

        $i += 1;
    }

    echo '</table>
        </td>
        </tr>
        </table>
        </form>';

    CloseTable();
}

function EVFullview($job_id)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule;

    $myts = MyTextSanitizer::getInstance();

    $result = $xoopsDB->query('SELECT id_job, id_titre, id_typeposte, id_locations, posted_date, start_date, end_date, id_status, description FROM ' . $xoopsDB->prefix('ev_job') . " WHERE id_job=$job_id");

    [$job_id, $titres_id, $typeposte_id, $locations_id, $jobposteddate, $jobstartdate, $jobenddate, $status_id, $description] = $xoopsDB->fetchRow($result);

    //$result = $xoopsDB->query("SELECT id_log, time_log, uname_log, ip_log, server_log, command_log, result_log FROM ".$xoopsDB->prefix("ev_job")." WHERE id_log=$log_id");

    //list($log_id, $log_time, $log_uname, $log_ip, $log_server_name, $log_command, $log_result) = $xoopsDB->fetchRow($result);

    $myts = MyTextSanitizer::getInstance();

    $titres = reference('ev_titres', 'titres', 'id_titres', $titres_id);

    $typeposte = reference('ev_typeposte', 'typeposte', 'id_typeposte', $typeposte_id);

    $locations = reference('ev_locations', 'locations', 'id_locations', $locations_id);

    $status = reference('ev_status', 'status', 'id_status', $status_id);

    $jobposteddate = formatTimestamp($jobposteddate, 'Y-m-d');

    $jobstartdate = formatTimestamp($jobstartdate, 'Y-m-d');

    $jobenddate = formatTimestamp($jobenddate, 'Y-m-d');

    //$description = htmlspecialchars($description, 1, 1, 1);

    $description = $myts->displayTarea($description);

    OpenTable();

    echo '<big><b>' . _AM_EV_VIEWJOB . "</big></b>
        <h4 style='text-align:left;'>" . _AM_EV_ADMINLOGFULL . "</h4>
        <form action='addserver.php' method='post'>
        <input type='hidden' name='job_id' value='$job_id'>
        <table border='0' cellpadding='0' cellspacing='0' valign='top' width='100%'>
        <tr>
        <td class='bg2'>
                <table border='0' cellpadding='4' cellspacing='1' width='100%'>
                <tr>
                <td class='bg3' width='200'></td>
                <td class='bg3'></td>
                </tr>
                <tr>
                <td class='bg3'><b>" . _AM_EV_VIEWID . "</b></td>
                <td class='bg1'>" . $job_id . "</td>
                </tr>
                <tr>
                <td class='bg3'><b>" . _AM_EV_VIEWTITRE . "</b></td>
                <td class='bg1'>" . $titres . "</td>
                </tr>
                <tr>
                <td class='bg3'><b>" . _AM_EV_VIEWTYPEPOSTE . "</b></td>
                <td class='bg1'>" . $typeposte . "</td>
                </tr>
                <tr>
                <td class='bg3'><b>" . _AM_EV_VIEWLOCATION . "</b></td>
                <td class='bg1'>" . $locations . "</td>
                </tr>
                <tr>
                <td class='bg3'><b>" . _AM_EV_VIEWPOSTEDDATE . "</b></td>
                <td class='bg1'>" . $jobposteddate . "</td>
                </tr>
                <tr>
                <td class='bg3'><b>" . _AM_EV_VIEWSTARTDDATE . "</b></td>
                <td class='bg1'>" . $jobstartdate . "</td>
                </tr>
                <tr>
                <td class='bg3'><b>" . _AM_EV_VIEWENDDATE . "</b></td>
                <td class='bg1'>" . $jobenddate . "</td>
                </tr>
                <tr>
                <td class='bg3'><b>" . _AM_EV_VIEWSTATUS . "</b></td>
                <td class='bg1'>" . $status . "</td>
                </tr>
                <tr>
                <td class='bg3'><b>" . _AM_EV_VIEWSTATUS . "</b></td>
                <td class='bg1'>" . $description . "</td>
                </tr>
                <tr>
                <td class='bg3'></td>
                <td class='bg3'></td>
                </tr>
                </table>
        </td>
        </tr>
        </table>

        </form>";

    CloseTable();
}

$op = $_POST['op'] ?? $_GET['op'] ?? 'main';
switch ($op) {
    case 'AdminJob':
        AdminJob($ordre);
        break;
    case 'EVFullview':
        EVFullview($job_id);
        break;
    default:
        $ordre = 'id_job';
        AdminJob($ordre);
        break;
}
xoops_cp_footer();
