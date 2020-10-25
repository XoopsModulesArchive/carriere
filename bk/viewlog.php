<?php

require dirname(__DIR__, 3) . '/include/cp_header.php';
if (file_exists('../language/' . $xoopsConfig['language'] . '/main.php')) {
    include '../language/' . $xoopsConfig['language'] . '/main.php';
} else {
    include '../language/french/main.php';
}

require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';
$myts = MyTextSanitizer::getInstance();
$eh = new ErrorHandler();

function PGSAViewLog()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule;

    xoops_cp_header();

    OpenTable();

    //*********** List server ******************************************************

    echo "<h4 style='text-align:left;'>" . _AM_PGSA_LOGVIEW . "</h4>

        <form action='viewlog.php' method='post'><a href='viewlog.php?op=PGSAVideLog&amp;ok=1'>" . _AM_PGSA_VIDE . "</a>
        <table border='0' cellpadding='0' cellspacing='0' valign='top' width='100%'>
        <tr>
        <td class='bg2'>
                <table width='100%' border='0' cellpadding='4' cellspacing='1'>
                <tr class='bg3'>
                <td><b>" . _AM_PGSA_LOGID . '</b></td>
                <td><b>' . _AM_PGSA_LOGDATE . '</b></td>
                <td><b>' . _AM_PGSA_LOGUNAME . '</b></td>
                <td><b>' . _AM_PGSA_LOGIP . '</b></td>
                <td><b>' . _AM_PGSA_LOGSERVER . '</b></td>
                <td><b>' . _AM_PGSA_LOGCOMMAND . '</b></td>
                <td><b>' . _AM_PGSA_LOGACTION . '</b></td>';

    $result = $xoopsDB->query('SELECT id_log, time_log, uname_log, ip_log, server_log, command_log FROM ' . $xoopsDB->prefix('pgsa_log') . ' ORDER BY id_log');

    $myts = MyTextSanitizer::getInstance();

    while (list($log_id, $log_time, $log_uname, $log_ip, $log_server_name, $command) = $xoopsDB->fetchRow($result)) {
        $log_server_name = htmlspecialchars($log_server_name, ENT_QUOTES | ENT_HTML5);

        $server_rconpassword = htmlspecialchars($server_rconpassword, ENT_QUOTES | ENT_HTML5);

        echo "<tr class='bg1'><td align='right'>$log_id</td>";

        echo "<td>$log_time</td>";

        echo "<td>$log_uname</td>";

        echo "<td>$log_ip</td>";

        echo "<td>$log_server_name</td>";

        echo "<td>$command</td>";

        echo "<td><a href='viewlog.php?op=PGSAFullLog&amp;log_id=$log_id'>" . _AM_PGSA_AFFICHERCOMPLET . "</a> | <a href='viewlog.php?op=PGSALogDel&amp;log_id=$log_id&amp;ok=1'>" . _AM_PGSA_DELETE . '</a></td>
                </tr>';
    }

    echo "</table>
        </td>
        </tr>
        </table><a href='viewlog.php?op=PGSAVideLog&amp;ok=1'>" . _AM_PGSA_VIDE . '</a>
        </form>';

    CloseTable();
}

function PGSALogDel($log_id, $ok = 0)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule;

    if (1 == $ok) {
        $xoopsDB->queryF('DELETE FROM ' . $xoopsDB->prefix('pgsa_server') . " WHERE id_log=$log_id");

        redirect_header('viewlog.php?op=PGSAViewLog', 1, _AM_PGSA_DBUPDATED);

        exit();
    }
}

function PGSAVideLog($ok = 0)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule;

    xoops_cp_header();

    if (1 == $ok) {
        $xoopsDB->queryF('TRUNCATE ' . $xoopsDB->prefix('pgsa_log') . '');

        redirect_header('viewlog.php?op=PGSAViewLog', 1, _AM_PGSA_DBUPDATED);
    }
}

function PGSAFullLog($log_id)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule;

    xoops_cp_header();

    $result = $xoopsDB->query('SELECT id_log, time_log, uname_log, ip_log, server_log, command_log, result_log FROM ' . $xoopsDB->prefix('pgsa_log') . " WHERE id_log=$log_id");

    [$log_id, $log_time, $log_uname, $log_ip, $log_server_name, $log_command, $log_result] = $xoopsDB->fetchRow($result);

    $myts = MyTextSanitizer::getInstance();

    $log_server_name = htmlspecialchars($log_server_name, ENT_QUOTES | ENT_HTML5);

    $log_result = htmlspecialchars($log_result, ENT_QUOTES | ENT_HTML5);

    OpenTable();

    echo '<big><b>' . _AM_PGSA_ADMINLOG . "</big></b>
        <h4 style='text-align:left;'>" . _AM_PGSA_ADMINLOGFULL . "</h4>
        <form action='addserver.php' method='post'>
        <input type='hidden' name='log_id' value='$log_id'>
        <table border='0' cellpadding='0' cellspacing='0' valign='top' width='100%'>
        <tr>
        <td class='bg2'>
                <table border='0' cellpadding='4' cellspacing='1'>
                <tr>
                <td class='bg3'></td>
                <td class='bg3'></td>
                </tr>
                <tr>
                <td class='bg3'><b>" . _AM_PGSA_LOGID . "</b></td>
                <td class='bg1'>" . $log_id . "</td>
                </tr>
                <tr>
                <td class='bg3'><b>" . _AM_PGSA_LOGDATE . "</b></td>
                <td class='bg1'>" . $log_time . "</td>
                </tr>
                <tr>
                <td class='bg3'><b>" . _AM_PGSA_LOGUNAME . "</b></td>
                <td class='bg1'>" . $log_uname . "</td>
                </tr>
                <tr>
                <td class='bg3'><b>" . _AM_PGSA_LOGIP . "</b></td>
                <td class='bg1'>" . $log_ip . "</td>
                </tr>
                <tr>
                <td class='bg3'><b>" . _AM_PGSA_LOGSERVER . "</b></td>
                <td class='bg1'>" . $log_server_name . "</td>
                </tr>
                <tr>
                <td class='bg3'><b>" . _AM_PGSA_LOGCOMMAND . "</b></td>
                <td class='bg1'>" . $log_command . "</td>
                </tr>
                <tr>
                <td class='bg3'><b>" . _AM_PGSA_LOGRESULT . "</b></td>
                <td class='bg1'><pre>" . $log_result . "</pre></td>
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
    case 'PGSADel':
        PGSALogDel($log_id, $ok);
        break;
    case 'PGSAViewLog':
        PGSAViewLog();
        break;
    case 'PGSAVideLog':
        PGSAVideLog($ok);
        break;
    case 'PGSAFullLog':
        PGSAFullLog($log_id);
        break;
    default:
        PGSAViewLog();
        break;
}
xoops_cp_footer();
