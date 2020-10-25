<?php

require dirname(__DIR__, 3) . '/include/cp_header.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require_once XOOPS_ROOT_PATH . '/class/uploader.php';
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
menuquote();

function AddNewQuote()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig;

    $colimage = 'blank.png';

    OpenTable();

    //$log_time = date("Y-m-d");

    //$log_time = formatTimestamp(time(), 'Y-m-d');

    //echo $log_time;

    $sform = new XoopsThemeForm(_AM_EV_FORMNAME, 'addquote', xoops_getenv('PHP_SELF'));

    $sform->setExtra('enctype="multipart/form-data"');

    $sform->addElement(new XoopsFormText(_MI_EV_NOM, 'name', '35', '255', $value = ''), true);

    if (!$colimage) {
        $colimage = 'blank.png';
    }

    $graph_array = XoopsLists:: getImgListAsArray(XOOPS_ROOT_PATH . '/' . $xoopsModuleConfig['sbuploaddir_quote']);

    $colimage_select = new XoopsFormSelect('', 'colimage', $colimage);

    $colimage_select->addOptionArray($graph_array);

    $colimage_select->setExtra("onchange='showImgSelected(\"image3\", \"colimage\", \"" . $xoopsModuleConfig['sbuploaddir_quote'] . '", "", "' . XOOPS_URL . "\")'");

    $colimage_tray = new XoopsFormElementTray(_AM_SB_COLIMAGE, '&nbsp;');

    $colimage_tray->addElement($colimage_select);

    $colimage_tray->addElement(new XoopsFormLabel('', "<br><br><img src='" . XOOPS_URL . '/' . $xoopsModuleConfig['sbuploaddir_quote'] . '/' . $colimage . "' name='image3' id='image3' alt=''>"));

    $sform->addElement($colimage_tray);

    // Code to call the file browser to select an image to upload

    $sform->addElement(new XoopsFormFile(_AM_SB_COLIMAGEUPLOAD, 'cimage', $xoopsModuleConfig['maxfilesize']), false);

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

    $sform->addElement(new XoopsFormText(_MI_EV_EXPERIENCE, 'experience', '35', '255', $value = '[fr]Francais[/fr][en]Anglais[/en]'));

    $sform->addElement(new XoopsFormText(_MI_EV_QUOTETITLE, 'quotetitle', '35', '255', $value = '[fr]Francais[/fr][en]Anglais[/en]'));

    $sform->addElement(new XoopsFormTextArea(_MI_EV_CITATION, 'citation', '[fr]Francais[/fr][en]Anglais[/en]', $rows = 5, $cols = 50, $hiddentext = 'xoopsHiddenText'), true);

    $button_tray = new XoopsFormElementTray('', '');

    //$button_tray->addElement(new XoopsFormButton('', 'preview', _MI_PREVIEW, 'submit'));

    $button_tray->addElement(new XoopsFormButton('', 'add', _MI_EV_ADD, 'submit'));

    $sform->addElement($button_tray);

    $sform->addElement(new XoopsFormHidden('op', 'AddQuote'));

    $sform->display();

    CloseTable();

    // echo '</form>';
}

/*function GetTopic($fct1, $fct2, $fct3) {
global $xoopsDB;
$myts = MyTextSanitizer::getInstance();
$sql = "SELECT ".$fct3.", ".$fct2." FROM " . $xoopsDB -> prefix( $fct1 ) . " ";
$result = $xoopsDB -> query( $sql );
$thearray = array();

while ( $topic = $xoopsDB -> fetcharray( $result ) ) {
$theid = htmlspecialchars($topic[$fct3]);
$thename = htmlspecialchars($topic[$fct2]);
$thearray[$theid] = $thename;

}
//$locations = htmlspecialchars($topic[$fct3]);
return $thearray;

}

// ca c une fonction qui te bati un array
function getTypeArray($fromadminsection=false)
{
    $typearray = array(0=>_AM_SF_TOPICTYPE0, 1=>_AM_SF_TOPICTYPE1, 2=>_AM_SF_TOPICTYPE2);
    return $typearray;
}
*/
function EditQuote($quote_id)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig;

    $myts = MyTextSanitizer::getInstance();

    $result = $xoopsDB->query('SELECT id, quote_nom, quote_pict, quote_titreposte, quote_typeposte, quote_location, quote_experience, quote_quotetitle, citation FROM ' . $xoopsDB->prefix('ev_quote') . " WHERE id=$quote_id");

    [$id, $quote_nom, $quote_pict, $quote_titreposte, $quote_typeposte, $quote_location, $quote_experience, $quote_quotetitle, $citation] = $xoopsDB->fetchRow($result);

    //$citation = $myts->displayTarea($citation);

    $colimage = $quote_pict;

    OpenTable();

    //$log_time = date("Y-m-d");

    //$log_time = formatTimestamp(time(), 'Y-m-d');

    //echo $log_time;

    $sform = new XoopsThemeForm(_AM_EV_FORMNAME, 'EditQuote', xoops_getenv('PHP_SELF'));

    $sform->setExtra('enctype="multipart/form-data"');

    $sform->addElement(new XoopsFormText(_MI_EV_NOM, 'quote_nom', '35', '255', $value = $quote_nom), true);

    if (!$colimage) {
        $colimage = 'blank.png';
    }

    $graph_array = XoopsLists:: getImgListAsArray(XOOPS_ROOT_PATH . '/' . $xoopsModuleConfig['sbuploaddir_quote']);

    $colimage_select = new XoopsFormSelect('', 'colimage', $colimage);

    $colimage_select->addOptionArray($graph_array);

    $colimage_select->setExtra("onchange='showImgSelected(\"image3\", \"colimage\", \"" . $xoopsModuleConfig['sbuploaddir_quote'] . '", "", "' . XOOPS_URL . "\")'");

    $colimage_tray = new XoopsFormElementTray(_AM_SB_COLIMAGE, '&nbsp;');

    $colimage_tray->addElement($colimage_select);

    $colimage_tray->addElement(new XoopsFormLabel('', "<br><br><img src='" . XOOPS_URL . '/' . $xoopsModuleConfig['sbuploaddir_quote'] . '/' . $colimage . "' name='image3' id='image3' alt=''>"));

    $sform->addElement($colimage_tray);

    // Code to call the file browser to select an image to upload

    $sform->addElement(new XoopsFormFile(_AM_SB_COLIMAGEUPLOAD, 'cimage', $xoopsModuleConfig['maxfilesize']), false);

    $sform->addElement(new XoopsFormHidden('quote_id', $quote_id));

    $thearray = GetTopic('ev_titres', 'titres', 'id_titres');

    $formtitre = new XoopsFormSelect(_MI_EV_TITRES, 'quote_titreposte', $quote_titreposte);

    $formtitre->addOptionArray($thearray);

    $sform->addElement($formtitre);

    $thearray = GetTopic('ev_typeposte', 'typeposte', 'id_typeposte');

    $formtypeposte = new XoopsFormSelect(_MI_EV_TYPEPOSTE, 'quote_typeposte', $quote_typeposte);

    $formtypeposte->addOptionArray($thearray);

    $sform->addElement($formtypeposte);

    $thearray = GetTopic('ev_locations', 'locations', 'id_locations');

    $formlocations = new XoopsFormSelect(_MI_EV_LOCATIONS, 'quote_location', $quote_location);

    $formlocations->addOptionArray($thearray);

    $sform->addElement($formlocations);

    $sform->addElement(new XoopsFormText(_MI_EV_EXPERIENCE, 'quote_experience', '35', '255', $value = $quote_experience));

    $sform->addElement(new XoopsFormText(_MI_EV_QUOTETITLE, 'quote_quotetitle', '35', '255', $value = $quote_quotetitle));

    $sform->addElement(new XoopsFormTextArea(_MI_EV_CITATION, 'citation', $citation, $rows = 5, $cols = 50, $hiddentext = 'xoopsHiddenText'), true);

    $button_tray = new XoopsFormElementTray('', '');

    //$button_tray->addElement(new XoopsFormButton('', 'preview', _MI_PREVIEW, 'submit'));

    $button_tray->addElement(new XoopsFormButton('', 'add', _AM_EV_EDITQUOTE, 'submit'));

    $sform->addElement($button_tray);

    $sform->addElement(new XoopsFormHidden('op', 'SaveQuote'));

    $sform->display();

    CloseTable();
}

function DelQuote($quote_id, $ok)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule;

    if (1 == $ok) {
        $xoopsDB->queryF('DELETE FROM ' . $xoopsDB->prefix('ev_quote') . " WHERE id=$quote_id");

        redirect_header('quote.php', 1, _AM_EV_DBDELUPDATED);

        exit();
    }

    $myts = MyTextSanitizer::getInstance();

    $result = $xoopsDB->query('SELECT id, quote_nom, citation FROM ' . $xoopsDB->prefix('ev_quote') . " WHERE id=$quote_id");

    [$id, $autor, $citation] = $xoopsDB->fetchRow($result);

    //$result = $xoopsDB->query("SELECT id_log, time_log, uname_log, ip_log, server_log, command_log, result_log FROM ".$xoopsDB->prefix("ev_job")." WHERE id_log=$log_id");

    //list($log_id, $log_time, $log_uname, $log_ip, $log_server_name, $log_command, $log_result) = $xoopsDB->fetchRow($result);

    $myts = MyTextSanitizer::getInstance();

    //$description = htmlspecialchars($description, 1, 1, 1);

    $citation = $myts->displayTarea($citation);

    OpenTable();

    echo '<big><b>' . _AM_EV_QUOTEDEL . "</big></b>

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
                <td class='bg1'>" . $id . "</td>
                </tr>
                <tr>
                <td class='bg3'><b>" . _AM_EV_QUOTEAUTOR . "</b></td>
                <td class='bg1'>" . $autor . "</td>
                </tr>
                <tr>
                <td class='bg3'><b>" . _AM_EV_QUOTECITATION . "</b></td>
                <td class='bg1'>" . $citation . "</td>
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

    echo "<td width='30%'valign='top'><span style='color:#ff0000;'><b>" . _AM_EV_WANTDEL . '</b></span></td>';

    echo "<td width='3%'>\n";

    echo myTextForm("quote.php?op=DelQuote&quote_id=$quote_id&ok=1", _AM_EV_YES);

    echo "</td><td>\n";

    echo myTextForm('quote.php', _AM_EV_NO);

    echo "</td></tr></table>\n";

    CloseTable();
}

function QuoteAdmin($ordre)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig;

    OpenTable();

    echo "<h4 style='text-align:left;'>" . _AM_EV_QUOTETITLE . "</h4>
        <form action='quote.php' method='post'>
        <table border='0' cellpadding='0' cellspacing='0' valign='top' width='100%'>
        <tr>
        <td class='bg2'>
                <table width='100%' border='0' cellpadding='4' cellspacing='1'>
                <tr class='bg1'>
                <td><b><a href='quote.php?op=QuoteAdmin&ordre=id'>" . _AM_EV_VIEWID . "</a></b></td>
                <td><b><a href='quote.php?op=QuoteAdmin&ordre=quote_nom'>" . _AM_EV_VIEWAUTOR . "</a></b></td>
                <td><b><a href='quote.php?op=QuoteAdmin&ordre=quote_pict'>" . _AM_EV_VIEWPICTURE . "</a></b></td>
                <td><b><a href='quote.php?op=QuoteAdmin&ordre=quote_titreposte'>" . _AM_EV_VIEWTITRE . "</a></b></td>
                <td><b><a href='quote.php?op=QuoteAdmin&ordre=quote_typeposte'>" . _AM_EV_VIEWTYPEPOSTE . "</a></b></td>
                <td><b><a href='quote.php?op=QuoteAdmin&ordre=quote_location'>" . _AM_EV_VIEWLOCATION . '</a></b></td>
                <td><b>' . _AM_EV_VIEWFUNCTION . '</b></td>';

    $result = $xoopsDB->query('SELECT id, quote_nom, quote_pict, quote_titreposte, quote_typeposte, quote_location FROM ' . $xoopsDB->prefix('ev_quote') . " ORDER BY $ordre");

    $myts = MyTextSanitizer::getInstance();

    $i = 0;

    while (list($id, $quote_nom, $quote_pict, $quote_titreposte, $quote_typeposte, $quote_location) = $xoopsDB->fetchRow($result)) {
        //$description = htmlspecialchars($description);

        $quote_titreposte = reference('ev_titres', 'titres', 'id_titres', $quote_titreposte);

        $quote_typeposte = reference('ev_typeposte', 'typeposte', 'id_typeposte', $quote_typeposte);

        $quote_location = reference('ev_locations', 'locations', 'id_locations', $quote_location);

        $upldir = $xoopsModuleConfig['sbuploaddir_quote'];

        echo "<tr class='bg1'><td align='right'>$id</td>";

        echo "<td>$quote_nom</td>";

        echo "<td><a href='" . XOOPS_URL . "$upldir/$quote_pict' target='_blank'>$quote_pict</a></td>";

        echo "<td>$quote_titreposte</td>";

        echo "<td>$quote_typeposte</td>";

        echo "<td>$quote_location</td>";

        echo "<td><a href='../index.php?op=View&row_pos=$i&ordre=$ordre'>" . _AM_EV_VIEW . "</a>&nbsp;&nbsp;<a href='quote.php?op=EditQuote&quote_id=$id'>" . _AM_EV_EDIT . "</a><a href='quote.php?op=DelQuote&amp;quote_id=$id&amp;ok=0'>" . _AM_EV_DELETE . '</a></td>
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

$op = $_POST['op'] ?? $_GET['op'] ?? 'main';
global $_POST;

switch ($op) {
    case 'DelQuote':
        DelQuote($quote_id, $ok);
        break;
    case 'AddQuote':
        global $xoopsDB, $eh, $myts;

        OpenTable();
        $myts = MyTextSanitizer::getInstance();
        //Recuperer la date:
        //$date2 = formatTimeStamp($jobposteddate, 'Y-m-d');
        //echo $date2;
        $name = $myts->addSlashes($name);
        $experience = $myts->addSlashes($experience);
        $quotetitle = $myts->addSlashes($quotetitle);
        $citation = $myts->addSlashes($citation);

        if ('' != $HTTP_POST_FILES['cimage']['name']) {
            if (file_exists(XOOPS_ROOT_PATH . '/' . $xoopsModuleConfig['sbuploaddir_quote'] . '/' . $HTTP_POST_FILES['cimage']['name'])) {
                redirect_header('quote.php', 1, _AM_SB_FILEEXISTS);
            }

            $allowed_mimetypes = ['image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png'];

            uploading($allowed_mimetypes, $HTTP_POST_FILES['cimage']['name'], 'index.php', 0, $xoopsModuleConfig['sbuploaddir_quote']);

            $colimage = $HTTP_POST_FILES['cimage']['name'];
        } elseif ('blank.png' != $_POST['colimage']) {
            $colimage = $myts->addSlashes($_POST['colimage']);
        } else {
            $colimage = '';
        }
        //echo $titres_id."<br>".$typeposte_id."<br>".$locations_id."<br>".$jobstartdate."<br>".$jobenddate."<br>".$status_id."<br>".$description."<br>".$jobposteddate."<br>".$log_time;

        $pictupload = $HTTP_POST_FILES['cimage']['name'];

        if ('' == $pictupload) {
            $pict = $colimage;
        } else {
            $pict = $pictupload;
        }

        $newid = 0;
        $sql = sprintf(
            "INSERT INTO %s (id, quote_nom, quote_pict, quote_titreposte, quote_typeposte, quote_location, quote_experience, quote_quotetitle, citation) VALUES (%u, '%s', '%s', %u, '%u', '%u', '%s', '%s', '%s')",
            $xoopsDB->prefix('ev_quote'),
            $newid,
            $name,
            $pict,
            $titres_id,
            $typeposte_id,
            $locations_id,
            $experience,
            $quotetitle,
            $citation
        );
        $xoopsDB->query($sql) or $eh::show('0013');
        // Si y'a pas d'erreurs ds la requete ci dessus, on redirige vers la page d'accueil ADMIN
        redirect_header('quote.php', 1, _AM_EV_DBUPDATED);
        exit();

        CloseTable();

        //       AddQuote($name, $picture, $titres_id, $typeposte_id, $locations_id, $experience, $quotetitle, $citation);
        break;
    case 'SaveQuote':
        global $xoopsDB;
        $myts = MyTextSanitizer::getInstance();
        $citation = $myts->addSlashes($citation);
        if ('' != $HTTP_POST_FILES['cimage']['name']) {
            if (file_exists(XOOPS_ROOT_PATH . '/' . $xoopsModuleConfig['sbuploaddir_quote'] . '/' . $HTTP_POST_FILES['cimage']['name'])) {
                redirect_header('quote.php', 1, _AM_SB_FILEEXISTS);
            }

            $allowed_mimetypes = ['image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png'];

            uploading($allowed_mimetypes, $HTTP_POST_FILES['cimage']['name'], 'index.php', 0, $xoopsModuleConfig['sbuploaddir_quote']);

            $colimage = $HTTP_POST_FILES['cimage']['name'];
        } elseif ('blank.png' != $_POST['colimage']) {
            $colimage = $myts->addSlashes($_POST['colimage']);
        } else {
            $colimage = '';
        }
        //echo $titres_id."<br>".$typeposte_id."<br>".$locations_id."<br>".$jobstartdate."<br>".$jobenddate."<br>".$status_id."<br>".$description."<br>".$jobposteddate."<br>".$log_time;

        $pictupload = $HTTP_POST_FILES['cimage']['name'];

        if ('' == $pictupload) {
            $pict = $colimage;
        } else {
            $pict = $pictupload;
        }

        $xoopsDB->query(
            'UPDATE '
            . $xoopsDB->prefix('ev_quote')
            . " SET id='$quote_id', quote_nom='$quote_nom', quote_pict='$pict', quote_titreposte='$quote_titreposte', quote_typeposte='$quote_typeposte', quote_location='$quote_location', quote_experience='$quote_experience', quote_quotetitle='$quote_quotetitle', citation='$citation' WHERE id=$quote_id"
        );
        redirect_header('quote.php', 1, _AM_EV_DBUPDATED);
        exit();

        break;
    case 'AddNewQuote':
        AddNewQuote();
        break;
    case 'EditQuote':
        EditQuote($quote_id);
        break;
    case 'DeletePicture':
        DeletePicture();
        break;
    case 'QuoteAdmin':
        QuoteAdmin($ordre);
        break;
    default:
        $ordre = 'id';
        QuoteAdmin($ordre);
        break;
}
xoops_cp_footer();
