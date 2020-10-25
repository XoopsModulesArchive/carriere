<?php

include 'header.php';
require XOOPS_ROOT_PATH . '/header.php';
require XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require_once __DIR__ . '/include/functions.php';

$GLOBALS['xoopsOption']['template_main'] = 'carriere_jobview.html';

require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';
$myts = MyTextSanitizer::getInstance();
$eh = new ErrorHandler();

foreach ($_REQUEST as $a => $b) {
    $$a = $b;
}

function EVFullview($row_pos, $ordre, $ordtype)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsTpl, $module_tables;

    $myts = MyTextSanitizer::getInstance();

    //$sql = "SELECT id_job, id_titre, id_typeposte, id_locations, posted_date, start_date, end_date, id_status, description FROM ".$xoopsDB->prefix($module_tables[0])." ORDER BY $ordre";

    if (1 == $ordtype) {
        $sql = 'SELECT id_job, id_titre, id_typeposte, id_locations, posted_date, start_date, end_date, id_status, description FROM ' . $xoopsDB->prefix($module_tables[0]) . " ORDER BY $ordre DESC";
    } elseif (0 == $ordtype) {
        $sql = 'SELECT id_job, id_titre, id_typeposte, id_locations, posted_date, start_date, end_date, id_status, description FROM ' . $xoopsDB->prefix($module_tables[0]) . " ORDER BY $ordre ASC";
    }

    // $result va retourner la rangée qui se trouve à la position $row_pos, genre la 6e ligne, peut importe le job_id

    $result = $xoopsDB->query($sql, 1, $row_pos);

    // Si result retourne False, ca veut dire que la requete n'a rien retourner, donc t au debut ou a la fin de la table

    if (!($result)) {
        redirect_header('emplois.php', 1, _MI_EV_RETURNTOINDEX);

        exit;
    }

    if ($row_pos < 0) {
        redirect_header('emplois.php', 1, _MI_EV_RETURNTOINDEX);

        exit;
    }

    [$job_id, $titres_id, $typeposte_id, $locations_id, $jobposteddate, $jobstartdate, $jobenddate, $status_id, $description] = $xoopsDB->fetchRow($result);

    $titreposteid = $titres_id;

    $titres = reference($module_tables[3], 'titres', 'id_titres', $titres_id);

    $typeposte = reference($module_tables[4], 'typeposte', 'id_typeposte', $typeposte_id);

    $locations = reference($module_tables[1], 'locations', 'id_locations', $locations_id);

    $status = reference($module_tables[2], 'status', 'id_status', $status_id);

    $jobposteddate = formatTimestamp($jobposteddate, 'Y-m-d');

    $jobstartdate = formatTimestamp($jobstartdate, 'Y-m-d');

    $jobenddate = formatTimestamp($jobenddate, 'Y-m-d');

    $description = $myts->displayTarea($description, 1, 0, 1, 0);

    // incrémente les valeurs...

    $last = $row_pos - 1;

    $next = $row_pos + 1;

    $xoopsTpl->assign('lang_VIEWID', _MI_EV_VIEWID);

    $xoopsTpl->assign('lang_VIEWTITRE', _MI_EV_VIEWTITRE);

    $xoopsTpl->assign('lang_VIEWTYPEPOSTE', _MI_EV_VIEWTYPEPOSTE);

    $xoopsTpl->assign('lang_VIEWLOCATION', _MI_EV_VIEWLOCATION);

    $xoopsTpl->assign('lang_VIEWSTATUS', _MI_EV_VIEWSTATUS);

    $xoopsTpl->assign('lang_VIEWSTARTDDATE', _MI_EV_VIEWSTARTDDATE);

    $xoopsTpl->assign('lang_VIEWENDDATE', _MI_EV_VIEWENDDATE);

    $xoopsTpl->assign('lang_JOBDESC', _MI_EV_JOBDESC);

    $xoopsTpl->assign('lang_JOBTITRE', _MI_EV_JOBTITRE);

    $xoopsTpl->assign('ev_job_id', $job_id);

    $xoopsTpl->assign('ev_jobposteddate', $jobposteddate);

    $xoopsTpl->assign('ev_titres', $titres);

    $xoopsTpl->assign('ev_typeposte', $typeposte);

    $xoopsTpl->assign('ev_locations', $locations);

    $xoopsTpl->assign('ev_status', $status);

    $xoopsTpl->assign('ev_jobstartdate', $jobstartdate);

    $xoopsTpl->assign('ev_jobenddate', $jobenddate);

    $xoopsTpl->assign('ev_description', $description);

    $xoopsTpl->assign('titreposte_id', $titreposteid);

    $postuler = new XoopsThemeForm('jobapply', 'postuler', 'jobapply.php');

    $postuler->addElement(new XoopsFormHidden('job_id', $job_id));

    $postuler->addElement(new XoopsFormHidden('op', 'postuler'));

    $postuler->addElement(new XoopsFormHidden('prenom', ''));

    $postuler->addElement(new XoopsFormHidden('nom', ''));

    $postuler->addElement(new XoopsFormHidden('email', ''));

    $postuler->addElement(new XoopsFormHidden('address', ''));

    $postuler->addElement(new XoopsFormHidden('ville', ''));

    $postuler->addElement(new XoopsFormHidden('zipcode', ''));

    $postuler->addElement(new XoopsFormHidden('telhome', ''));

    $postuler->addElement(new XoopsFormHidden('telcell', ''));

    $postuler->addElement(new XoopsFormHidden('telautre', ''));

    $postuler->addElement(new XoopsFormHidden('heardodesia', ''));

    $postuler->addElement(new XoopsFormHidden('nomress', ''));

    $postuler->addElement(new XoopsFormHidden('emailress', ''));

    $button_tray = new XoopsFormElementTray('', '');

    $button_tray->addElement(new XoopsFormButton('', 'post', _MI_EV_POSTULER, 'submit'));

    $postuler->addElement($button_tray);

    $postuler->assign($xoopsTpl);

    $sendtofriend = new XoopsThemeForm('sendtofriend', 'sendtofriend', 'sendfriend.php');

    $sendtofriend->addElement(new XoopsFormHidden('job_id', $job_id));

    $sendtofriend->addElement(new XoopsFormHidden('op', 'sendtofriend'));

    $button_tray = new XoopsFormElementTray('', '');

    $button_tray->addElement(new XoopsFormButton('', 'post', _MI_EV_SENDTOFRIEND, 'submit'));

    $sendtofriend->addElement($button_tray);

    $sendtofriend->assign($xoopsTpl);
}

function EVFullviewByID($job_id)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsTpl, $module_tables;

    if ($job_id < 0) {
        redirect_header('emplois.php', 1, _MI_EV_RETURNTOINDEX);

        exit;
    }

    $myts = MyTextSanitizer::getInstance();

    //$sql = "SELECT id_job, id_titre, id_typeposte, id_locations, posted_date, start_date, end_date, id_status, description FROM ".$xoopsDB->prefix("ev_job")." ORDER BY $ordre";

    $result = $xoopsDB->query('SELECT id_job, id_titre, id_typeposte, id_locations, posted_date, start_date, end_date, id_status, description FROM ' . $xoopsDB->prefix($module_tables[0]) . " WHERE id_job=$job_id");

    [$job_id, $titres_id, $typeposte_id, $locations_id, $jobposteddate, $jobstartdate, $jobenddate, $status_id, $description] = $xoopsDB->fetchRow($result);

    $titres = reference($module_tables[3], 'titres', 'id_titres', $titres_id);

    $typeposte = reference($module_tables[4], 'typeposte', 'id_typeposte', $typeposte_id);

    $locations = reference($module_tables[1], 'locations', 'id_locations', $locations_id);

    $status = reference($module_tables[2], 'status', 'id_status', $status_id);

    $jobposteddate = formatTimestamp($jobposteddate, 'Y-m-d');

    $jobstartdate = formatTimestamp($jobstartdate, 'Y-m-d');

    $jobenddate = formatTimestamp($jobenddate, 'Y-m-d');

    $description = $myts->displayTarea($description, 1, 0, 1, 0);

    $xoopsTpl->assign('lang_VIEWID', _MI_EV_VIEWID);

    $xoopsTpl->assign('lang_VIEWTITRE', _MI_EV_VIEWTITRE);

    $xoopsTpl->assign('lang_VIEWTYPEPOSTE', _MI_EV_VIEWTYPEPOSTE);

    $xoopsTpl->assign('lang_VIEWLOCATION', _MI_EV_VIEWLOCATION);

    $xoopsTpl->assign('lang_VIEWSTATUS', _MI_EV_VIEWSTATUS);

    $xoopsTpl->assign('lang_VIEWSTARTDDATE', _MI_EV_VIEWSTARTDDATE);

    $xoopsTpl->assign('lang_VIEWENDDATE', _MI_EV_VIEWENDDATE);

    $xoopsTpl->assign('lang_JOBDESC', _MI_EV_JOBDESC);

    $xoopsTpl->assign('lang_JOBTITRE', _MI_EV_JOBTITRE);

    $xoopsTpl->assign('ev_job_id', $job_id);

    $xoopsTpl->assign('ev_jobposteddate', $jobposteddate);

    $xoopsTpl->assign('ev_titres', $titres);

    $xoopsTpl->assign('ev_typeposte', $typeposte);

    $xoopsTpl->assign('ev_locations', $locations);

    $xoopsTpl->assign('ev_status', $status);

    $xoopsTpl->assign('ev_jobstartdate', $jobstartdate);

    $xoopsTpl->assign('ev_jobenddate', $jobenddate);

    $xoopsTpl->assign('ev_description', $description);

    $postuler = new XoopsThemeForm('jobapply', 'postuler', 'jobapply.php');

    $postuler->addElement(new XoopsFormHidden('job_id', $job_id));

    $postuler->addElement(new XoopsFormHidden('op', 'postuler'));

    $button_tray = new XoopsFormElementTray('', '');

    $button_tray->addElement(new XoopsFormButton('', 'post', _MI_EV_POSTULER, 'submit'));

    $postuler->addElement($button_tray);

    $postuler->assign($xoopsTpl);

    $sendtofriend = new XoopsThemeForm('sendtofriend', 'sendtofriend', 'sendfriend.php');

    $sendtofriend->addElement(new XoopsFormHidden('job_id', $job_id));

    $sendtofriend->addElement(new XoopsFormHidden('op', 'sendtofriend'));

    $button_tray = new XoopsFormElementTray('', '');

    $button_tray->addElement(new XoopsFormButton('', 'post', _MI_EV_SENDTOFRIEND, 'submit'));

    $sendtofriend->addElement($button_tray);

    $sendtofriend->assign($xoopsTpl);
}

$op = $_POST['op'] ?? $_GET['op'] ?? 'main';
switch ($op) {
    case 'EVFullview':
        EVFullview($row_pos, $ordre, $ordtype);
        break;
    case 'EVFullviewByID':
        EVFullviewByID($job_id);
        break;
    default:
        redirect_header('emplois.php', 1, _MI_EV_RETURNTOINDEX);
        exit;
        break;
}

include 'footer.php';
