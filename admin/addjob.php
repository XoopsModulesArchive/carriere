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

function EVAdmin()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule;

    OpenTable();

    //$log_time = date("Y-m-d");

    //$log_time = formatTimestamp(time(), 'Y-m-d');

    //echo $log_time;

    $sform = new XoopsThemeForm(_AM_EV_FORMNAME, 'addjob', xoops_getenv('PHP_SELF'));

    $sform->setExtra('enctype="multipart/form-data"');

    $thearray = GetTopic('ev_titres', 'titres', 'id_titres');

    $formtitre = new XoopsFormSelect(_MI_EV_TITRES, 'titres_id');

    $formtitre->addOptionArray($thearray);

    $sform->addElement($formtitre);

    $thearray = GetTopic('ev_typeposte', 'typeposte', 'id_typeposte');

    $formtypeposte = new XoopsFormSelect(_MI_EV_TYPEPOSTE, 'typeposte_id');

    $formtypeposte->addOptionArray($thearray);

    $sform->addElement($formtypeposte);

    $thearray = GetTopic('ev_locations', 'locations', 'id_locations');

    $formlocations = new XoopsFormSelect(_MI_EV_LOCATIONS, 'locations_id');

    $formlocations->addOptionArray($thearray);

    $sform->addElement($formlocations);

    $sform->addElement(new XoopsFormTextDateSelect(_MI_EV_JOBSTARTDATE, 'jobstartdate', $size = 15, $value = ''));

    $sform->addElement(new XoopsFormTextDateSelect(_MI_EV_JOBENDDATE, 'jobenddate', $size = 15, $value = ''));

    $thearray = GetTopic('ev_status', 'status', 'id_status');

    $formstatus = new XoopsFormSelect(_MI_EV_STATUS, 'status_id');

    $formstatus->addOptionArray($thearray);

    $sform->addElement($formstatus);

    $sform->addElement(new XoopsFormTextArea(_MI_EV_JOBDESC, 'description', '', $rows = 5, $cols = 50, $hiddentext = 'xoopsHiddenText'));

    $button_tray = new XoopsFormElementTray('', '');

    //$button_tray->addElement(new XoopsFormButton('', 'preview', _MI_PREVIEW, 'submit'));

    $button_tray->addElement(new XoopsFormButton('', 'add', _MI_EV_ADD, 'submit'));

    $sform->addElement($button_tray);

    $sform->addElement(new XoopsFormHidden('op', 'EVAddjob'));

    $sform->display();

    CloseTable();

    // echo '</form>';
}

function EVEdit($job_id)
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

    //$jobstartdate = formatTimeStamp($jobstartdate, 'Y-m-d');

    //$jobenddate = formatTimeStamp($jobenddate, 'Y-m-d');

    //$description = htmlspecialchars($description, 1, 1, 1);

    //$description = $myts->displayTarea($description);

    OpenTable();

    //$log_time = date("Y-m-d");

    //$log_time = formatTimestamp(time(), 'Y-m-d');

    //echo $log_time;

    $sform = new XoopsThemeForm(_AM_EV_FORMNAME, 'editjob', xoops_getenv('PHP_SELF'));

    $sform->setExtra('enctype="multipart/form-data"');

    $sform->addElement(new XoopsFormHidden('job_id', $job_id));

    $thearray = GetTopic('ev_titres', 'titres', 'id_titres');

    $formtitre = new XoopsFormSelect(_MI_EV_TITRES, 'titres_id', $titres_id);

    $formtitre->addOptionArray($thearray);

    $sform->addElement($formtitre);

    $thearray = GetTopic('ev_typeposte', 'typeposte', 'id_typeposte');

    $formtypeposte = new XoopsFormSelect(_MI_EV_TYPEPOSTE, 'typeposte_id', $typeposte_id);

    $formtypeposte->addOptionArray($thearray);

    $sform->addElement($formtypeposte);

    $thearray = GetTopic('ev_locations', 'locations', 'id_locations');

    $formlocations = new XoopsFormSelect(_MI_EV_LOCATIONS, 'locations_id', $locations_id);

    $formlocations->addOptionArray($thearray);

    $sform->addElement($formlocations);

    $sform->addElement(new XoopsFormTextDateSelect(_MI_EV_JOBSTARTDATE, 'jobstartdate', $size = 15, $jobstartdate));

    $sform->addElement(new XoopsFormTextDateSelect(_MI_EV_JOBENDDATE, 'jobenddate', $size = 15, $jobenddate));

    $thearray = GetTopic('ev_status', 'status', 'id_status');

    $formstatus = new XoopsFormSelect(_MI_EV_STATUS, 'status_id', $status_id);

    $formstatus->addOptionArray($thearray);

    $sform->addElement($formstatus);

    $sform->addElement(new XoopsFormDHTMLTextArea(_MI_EV_JOBDESC, 'description', $description, $rows = 5, $cols = 50, $hiddentext = 'xoopsHiddenText'), true);

    $button_tray = new XoopsFormElementTray('', '');

    //$button_tray->addElement(new XoopsFormButton('', 'preview', _MI_PREVIEW, 'submit'));

    $button_tray->addElement(new XoopsFormButton('', 'add', _MI_EV_ADD, 'submit'));

    $sform->addElement($button_tray);

    $sform->addElement(new XoopsFormHidden('op', 'EVSave'));

    $sform->display();

    CloseTable();
}

/*function reference($fct1, $fct2, $fct3, $id){
global $xoopsDB;
$myts = MyTextSanitizer::getInstance();
//$sql = "SELECT ".$fct3.", ".$fct2." FROM " . $xoopsDB -> prefix( $fct1 ) . " ";
//$result = $xoopsDB -> query( $sql );
//$thearray = array();


$result = $xoopsDB->query("SELECT ".$fct3.", ".$fct2." FROM ".$xoopsDB->prefix($fct1)." WHERE ".$fct3."=$id");
        list($id, $champs) = $xoopsDB->fetchRow($result);
$titres = $champs;
return $titres;

}*/

function EVSave($job_id, $titres_id, $typeposte_id, $locations_id, $jobstartdate, $jobenddate, $status_id, $description)
{
    global $xoopsDB;

    $myts = MyTextSanitizer::getInstance();

    //$date = date("Y-m-d");

    //$jobposteddate = strtotime($date);

    $jobstartdate = strtotime($jobstartdate);

    $jobenddate = strtotime($jobenddate);

    //Recuperer la date:

    //$date2 = formatTimeStamp($jobposteddate, 'Y-m-d');

    //echo $date2;

    $description = $myts->addSlashes($description);

    $xoopsDB->query('UPDATE ' . $xoopsDB->prefix('ev_job') . " SET id_titre='$titres_id', id_typeposte='$typeposte_id', id_locations='$locations_id', start_date='$jobstartdate', end_date='$jobenddate', id_status='$status_id', description='$description' WHERE id_job=$job_id");

    redirect_header('index.php', 1, _AM_EV_DBUPDATED);

    exit();
}

function EVDel($job_id, $ok = 0)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule;

    if (1 == $ok) {
        $xoopsDB->queryF('DELETE FROM ' . $xoopsDB->prefix('ev_job') . " WHERE id_job=$job_id");

        redirect_header('index.php', 1, _AM_PGSA_DBUPDATED);

        exit();
    }

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

    echo "<table valign='top'><tr>";

    echo "<td width='30%'valign='top'><span style='color:#ff0000;'><b>" . _AM_PGSA_WANTDEL . '</b></span></td>';

    echo "<td width='3%'>\n";

    echo myTextForm("addjob.php?op=EVDel&job_id=$job_id&ok=1", _AM_EV_YES);

    echo "</td><td>\n";

    echo myTextForm('addjob.php?op=EVAdmin', _AM_EV_NO);

    echo "</td></tr></table>\n";

    CloseTable();
}

function EVAddjob($titres_id, $typeposte_id, $locations_id, $jobstartdate, $jobenddate, $status_id, $description)
{
    global $xoopsDB, $eh, $myts;

    OpenTable();

    $myts = MyTextSanitizer::getInstance();

    $date = date('Y-m-d');

    $jobposteddate = strtotime($date);

    $jobstartdate = strtotime($jobstartdate);

    $jobenddate = strtotime($jobenddate);

    //Recuperer la date:

    //$date2 = formatTimeStamp($jobposteddate, 'Y-m-d');

    //echo $date2;

    $description = $myts->addSlashes($description);

    //echo $titres_id."<br>".$typeposte_id."<br>".$locations_id."<br>".$jobstartdate."<br>".$jobenddate."<br>".$status_id."<br>".$description."<br>".$jobposteddate."<br>".$log_time;

    $newid = 0;

    $sql = sprintf(
        "INSERT INTO %s (id_job, id_titre, id_typeposte, id_locations, posted_date, start_date, end_date, id_status, description) VALUES (%u, '%u', '%u', %u, '%u', '%u', '%u', '%u', '%s')",
        $xoopsDB->prefix('ev_job'),
        $newid,
        $titres_id,
        $typeposte_id,
        $locations_id,
        $jobposteddate,
        $jobstartdate,
        $jobenddate,
        $status_id,
        $description
    );

    $xoopsDB->query($sql) or $eh::show('0013');

    // Si y'a pas d'erreurs ds la requete ci dessus, on redirige vers la page d'accueil ADMIN

    redirect_header('index.php', 1, _AM_EV_DBUPDATED);

    exit();

    CloseTable();
}

$op = $_POST['op'] ?? $_GET['op'] ?? 'main';
switch ($op) {
    case 'EVDel':
        EVDel($job_id, $ok);
        break;
    case 'EVAddjob':
        EVAddjob($titres_id, $typeposte_id, $locations_id, $jobstartdate, $jobenddate, $status_id, $description);
        break;
    case 'EVSave':
        EVSave($job_id, $titres_id, $typeposte_id, $locations_id, $jobstartdate, $jobenddate, $status_id, $description);
        break;
    case 'EVAdmin':
        EVAdmin();
        break;
    case 'EVEdit':
        EVEdit($job_id);
        break;
    default:
        EVAdmin();
        break;
}
xoops_cp_footer();

//BOUT DE CODE EN BACKUP

/*$sql = "SELECT id_titres, titres FROM " . $xoopsDB -> prefix( "ev_titres" ) . " "; $result = $xoopsDB -> query( $sql2 );
$thearray = aray();
while ( $topic = $xoopsDB -> fetcharray( $result ) ) {
$theid = $topic['id_titres'];
$thename = $topic['titres'];
$thearray[$theid] =$thename;
 }



  //CHECK LES ERREUR LORS D'UNE REQUETE!
           $sql = "UPDATE ".$xoopsDB->prefix("ev_job")." SET id_titres='$titres_id', id_typeposte='$typeposte_id', id_locations='$locations_id', posted_date='$jobposteddate', start_date='$jobstartdate', end_date='$jobenddate', id_status='$status_id', description='$description' WHERE id_job=$job_id";
        If ($xoopsDB->query($sql))
                {
                  redirect_header( "index.php", 1, "Ca Marche !" );
                } else
                {
                 redirect_header( "index.php", 1, "ERROR : " . $sql );
                }

        exit();







 */
