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

function PGSAAdmin($funct)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule;

    xoops_cp_header();

    OpenTable();

    echo "<br><a href='options.php?op=evadmin&funct=1'>" . _AM_EV_TITRE . "</a>
        <br><a href='options.php?op=evadmin&funct=2'>" . _AM_EV_LOCATIONS . "</a>
        <br><a href='options.php?op=evadmin&funct=3'>" . _AM_EV_STATUS . "</a>
        <br><a href='options.php?op=evadmin&funct=4'>" . _AM_EV_TYPEPOSTE . '</a><br>';

    echo '<big><b>' . _AM_EV_TITLE . '</big></b>';

    echo "<h4 style='text-align:left;'>" . _AM_EV_ADDMENUITEM . "</h4>
        <form action='addserver.php' method='post'>
        <table border='0' cellpadding='0' cellspacing='0' valign='top' width='100%'>
        <tr>
        <td class='bg2'>
                <table width='100%' border='0' cellpadding='4' cellspacing='1'>
                <tr>
                <td class='bg3'><b>" . _AM_EV_NAME . "</b></td>
                <td class='bg1'><input type='text' name='server_name' size='50' maxlength='60'></td>
                </tr>
                <tr>
                <td class='bg3'>&nbsp;</td>
                <td class='bg1'><input type='hidden' name='fct' value='pgsa'><input type='hidden' name='op' value='PGSAAdd'><input type='submit' value='" . _AM_PGSA_ADD . "'></td>
                </tr>
                </table>
        </td>
        </tr>
        </table>
        </form>
        <br>";

    //*********** List server ******************************************************

    echo "<h4 style='text-align:left;'>" . _AM_PGSA_CHANGEMENUITEM . "</h4>
        <form action='addserver.php' method='post'>
        <table border='0' cellpadding='0' cellspacing='0' valign='top' width='100%'>
        <tr>
        <td class='bg2'>
                <table width='100%' border='0' cellpadding='4' cellspacing='1'>
                <tr class='bg3'>
                <td><b>" . _AM_PGSA_ID . '</b></td>
                <td><b>' . _AM_PGSA_NAME . '</b></td>
                <td><b>' . _AM_PGSA_IP . '</b></td>
                <td><b>' . _AM_PGSA_PORT . '</b></td>
                <td><b>' . _AM_PGSA_RCONPASSWORD . '</b></td>
                <td><b>' . _AM_PGSA_FUNCTION . '</b></td>';

    $result = $xoopsDB->query('SELECT id_server, name_server, ip_server, port_server, password FROM ' . $xoopsDB->prefix('pgsa_server') . ' ORDER BY id_server');

    $myts = MyTextSanitizer::getInstance();

    while (list($server_id, $server_name, $server_ip, $server_port, $server_rconpassword) = $xoopsDB->fetchRow($result)) {
        $server_name = htmlspecialchars($server_name, ENT_QUOTES | ENT_HTML5);

        $server_ip = htmlspecialchars($server_ip, ENT_QUOTES | ENT_HTML5);

        $server_rconpassword = htmlspecialchars($server_rconpassword, ENT_QUOTES | ENT_HTML5);

        echo "<tr class='bg1'><td align='right'>$server_id</td>";

        echo "<td>$server_name</td>";

        echo "<td>$server_ip</td>";

        echo "<td>$server_port</td>";

        echo "<td>$server_rconpassword</td>";

        echo "<td><a href='addserver.php?op=PGSAEdit&server_id=$server_id'>" . _AM_PGSA_EDIT . "</a> | <a href='addserver.php?op=PGSADel&amp;server_id=$server_id&amp;ok=0'>" . _AM_PGSA_DELETE . '</a></td>
                </tr>';
    }

    echo '</table>
        </td>
        </tr>
        </table>
        </form>';

    CloseTable();
}

function PGSAEdit($server_id)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule;

    xoops_cp_header();

    $result = $xoopsDB->query('SELECT id_server, name_server, ip_server, port_server, password FROM ' . $xoopsDB->prefix('pgsa_server') . " WHERE id_server=$server_id");

    [$server_id, $server_name, $server_ip, $server_port, $server_rconpassword] = $xoopsDB->fetchRow($result);

    $myts = MyTextSanitizer::getInstance();

    $server_name = htmlspecialchars($server_name, ENT_QUOTES | ENT_HTML5);

    $server_ip = htmlspecialchars($server_ip, ENT_QUOTES | ENT_HTML5);

    $server_rconpassword = htmlspecialchars($server_rconpassword, ENT_QUOTES | ENT_HTML5);

    OpenTable();

    echo '<big><b>' . _AM_PGSA_TITLE . "</big></b>
        <h4 style='text-align:left;'>" . _AM_PGSA_EDITMENUITEM . "</h4>
        <form action='addserver.php' method='post'>
        <input type='hidden' name='server_id' value='$server_id'>
        <table border='0' cellpadding='0' cellspacing='0' valign='top' width='100%'>
        <tr>
        <td class='bg2'>
                <table width='100%' border='0' cellpadding='4' cellspacing='1'>
                <tr>
                <td class='bg3'><b>" . _AM_PGSA_NAME . "</b></td>
                <td class='bg1'><input type='text' name='server_name' size='50' maxlength='60' value='$server_name'></td>
                </tr>
                <tr>
                <td class='bg3'><b>" . _AM_PGSA_IP . "</b></td>
                <td class='bg1'><input type='text' name='server_ip' size='50' maxlength='60' value='$server_ip'></td>
                </tr>
                <tr>
                <td class='bg3'><b>" . _AM_PGSA_PORT . "</b></td>
                <td class='bg1'><input type='text' name='server_port' size='5' maxlength='5' value='$server_port'>(0:65535)</td>
                </tr>
                <tr>
                <td class='bg3'><b>" . _AM_PGSA_RCONPASSWORD . "</b></td>
                <td class='bg1'><input type='password' name='server_rconpassword' size='50' maxlength='60' value='$server_rconpassword'></td>
                </tr>


                <tr>
                <td class='bg3'>&nbsp;</td>
                <td class='bg1'><input type='hidden' name='fct' value='pgsa'><input type='hidden' name='op' value='PGSASave'><input type='submit' value='" . _AM_PGSA_SAVECHANG . "'></td>
                </tr>
                </table>
        </td>
        </tr>
        </table>

        </form>";

    CloseTable();
}

function PGSASave($server_id, $server_name, $server_ip, $server_port, $server_rconpassword)
{
    global $xoopsDB;

    $myts = MyTextSanitizer::getInstance();

    $server_name = $myts->addSlashes(trim($server_name));

    $server_ip = $myts->addSlashes(trim($server_ip));

    $server_rconpassword = $myts->addSlashes(trim($server_rconpassword));

    $xoopsDB->query('UPDATE ' . $xoopsDB->prefix('pgsa_server') . " SET name_server='$server_name', ip_server='$server_ip', port_server='$server_port',password='$server_rconpassword' WHERE id_server=$server_id");

    redirect_header('addserver.php?op=PGSAAdmin', 1, _AM_PGSA_DBUPDATED);

    exit();
}

function PGSAAdd($server_name, $server_ip, $server_port, $server_rconpassword)
{
    global $xoopsDB, $eh, $myts;

    $server_name = $myts->addSlashes($server_name);

    $server_ip = $myts->addSlashes($server_ip);

    $server_rconpassword = $myts->addSlashes($server_rconpassword);

    $newid = $xoopsDB->genId($xoopsDB->prefix('pgsa_server') . '_id_server_seq');

    $sql = sprintf("INSERT INTO %s (id_server, name_server, ip_server, port_server, password) VALUES (%u, '%s', '%s', %u, '%s')", $xoopsDB->prefix('pgsa_server'), $newid, $server_name, $server_ip, $server_port, $server_rconpassword);

    $xoopsDB->query($sql) or $eh::show('0013');

    // Si y'a pas d'erreurs ds la requete ci dessus, on redirige vers la page d'accueil ADMIN

    redirect_header('addserver.php?op=PGSAAdmin', 1, _AM_PGSA_DBUPDATED);

    exit();
}

function PGSADel($server_id, $ok = 0)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule;

    if (1 == $ok) {
        $xoopsDB->queryF('DELETE FROM ' . $xoopsDB->prefix('pgsa_server') . " WHERE id_server=$server_id");

        redirect_header('addserver.php?op=PGSAAdmin', 1, _AM_PGSA_DBUPDATED);

        exit();
    }

    xoops_cp_header();

    OpenTable();

    $result = $xoopsDB->query('SELECT name_server, ip_server, port_server, password FROM ' . $xoopsDB->prefix('pgsa_server') . " WHERE id_server=$server_id");

    [$server_name, $server_ip, $server_port, $server_rconpassword] = $xoopsDB->fetchRow($result);

    echo '<big><b>' . _AM_PGSA_TITLE . '</big></b>';

    echo "<h4 style='text-align:left;'>" . _AM_PGSA_DELETEMENUITEM . "</h4>
                <form action='addserver.php' method='post'>
                <input type='hidden' name='server_id' value='$server_id'>
                <table border='0' cellpadding='0' cellspacing='0' valign='top' width='100%'>
                        <tr>
                        <td class='bg2'>
                        <table width='100%' valign='top' border='0' cellpadding='4' cellspacing='1'>
                                <tr>
                                <td class='bg3' width='30%'><b>" . _AM_PGSA_NAME . "</b></td>
                                <td class='bg1'>" . $server_name . "</td>
                                </tr>
                                <tr>
                                <td class='bg3'><b>" . _AM_PGSA_IP . "</b></td>
                                <td class='bg1'>" . $server_ip . "</td>
                                </tr>
                                <tr>
                                <td class='bg3'><b>" . _AM_PGSA_PORT . "</b></td>
                                <td class='bg1'>" . $server_port . "</td>
                                </tr>
                                <tr>
                                <td class='bg3'><b>" . _AM_PGSA_RCONPASSWORD . "</b></td>
                                <td class='bg1'>" . $server_rconpassword . '</td>
                                </tr>
                        </table>
                        </td>
                        </tr>
                </table>
                </form>';

    echo "<table valign='top'><tr>";

    echo "<td width='30%'valign='top'><span style='color:#ff0000;'><b>" . _AM_PGSA_WANTDEL . '</b></span></td>';

    echo "<td width='3%'>\n";

    echo myTextForm("addserver.php?op=PGSADel&server_id=$server_id&ok=1", _AM_PGSA_YES);

    echo "</td><td>\n";

    echo myTextForm('addserver.php?op=PGSAAdmin', _AM_PGSA_NO);

    echo "</td></tr></table>\n";

    CloseTable();
}

$op = $_POST['op'] ?? $_GET['op'] ?? 'main';
switch ($op) {
    case 'evdel':
        evdel($server_id, $ok);
        break;
    case 'add':
        evadd($server_name, $server_ip, $server_port, $server_rconpassword);
        break;
    case 'evsave':
        evsave($server_id, $server_name, $server_ip, $server_port, $server_rconpassword);
        break;
    case 'evadmin':
        evadmin($funct);
        break;
    case 'evedit':
        evedit($server_id);
        break;
    default:
        evadmin();
        break;
}
xoops_cp_footer();
