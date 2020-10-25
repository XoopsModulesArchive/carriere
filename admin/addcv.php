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
}

function EVEdit($id_cv)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule;

    $myts = MyTextSanitizer::getInstance();

    $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('ev_cv') . " WHERE id=$id_cv");

    [$id, $name, $family_name, $email, $address, $city, $province, $country, $zipcode, $tel_home, $tel_cell, $tel_other, $cv, $rec_letter, $heard_odesia, $rec_name, $rec_email, $id_poste] = $xoopsDB->fetchRow($result);

    OpenTable();

    $sform = new XoopsThemeForm(_AM_EV_FORMNAME, 'editjob', xoops_getenv('PHP_SELF'));

    $sform->setExtra('enctype="multipart/form-data"');

    $sform->addElement(new XoopsFormText('Prénom :', 'cv_name', 50, 255, $name . ' ' . $family_name));

    $sform->addElement(new XoopsFormText('Email :', 'cv_email', 50, 255, $email));

    $sform->addElement(new XoopsFormText('Adresse :', 'cv_address', 50, 255, $address));

    $sform->addElement(new XoopsFormText('Ville :', 'cv_city', 50, 255, $city));

    $sform->addElement(new XoopsFormText('Province :', 'cv_province', 50, 255, $province));

    $sform->addElement(new XoopsFormText('Pays :', 'cv_country', 50, 255, $country));

    $sform->addElement(new XoopsFormText('Code Postal :', 'cv_zipcode', 50, 255, $zipcode));

    $sform->addElement(new XoopsFormText('Téléphone à la maison :', 'cv_telhome', 50, 255, $tel_home));

    $sform->addElement(new XoopsFormText('Téléphone cellulaire :', 'cv_telcell', 50, 255, $tel_cell));

    $sform->addElement(new XoopsFormText('Téléphone autre :', 'cv_telother', 50, 255, $tel_other));

    $sform->addElement(new XoopsFormText('CV :', 'cv_cv', 50, 255, $cv));

    $sform->addElement(new XoopsFormText('Lettre de recommandation :', 'cv_rec', 50, 255, $rec));

    $sform->addElement(new XoopsFormText("Entendu parler d'ODESIA ? :", 'cv_heardodesia', 50, 255, $heard_odesia));

    $sform->addElement(new XoopsFormText('Personne ressource :', 'cv_ressname', 50, 255, $rec_name . ' (' . $rec_email . ')'));

    $sform->display();

    CloseTable();
}

function EVDel($job_id, $ok = 0)
{
}

function EVAddjob($titres_id, $typeposte_id, $locations_id, $jobstartdate, $jobenddate, $status_id, $description)
{
}

$op = $_POST['op'] ?? $_GET['op'] ?? 'main';
switch ($op) {
    case 'EVDel':
        EVDel($job_id, $ok);
        break;
    case 'EVAddjob':
        EVAddjob($titres_id, $typeposte_id, $locations_id, $jobstartdate, $jobenddate, $status_id, $description);
        break;
    case 'EVAdmin':
        EVAdmin();
        break;
    case 'EVEdit':
        EVEdit($id_cv);
        break;
    default:
        EVAdmin();
        break;
}
xoops_cp_footer();
