<?php

include 'header.php';
$job_id = $_POST['job_id'];
$myts = MyTextSanitizer::getInstance();

if (empty($_POST['submit'])) {
    foreach ($_REQUEST as $a => $b) {
        $$a = $b;
    }

    if (empty($_POST['nom'])) {
        $nom = '';
    }

    if (empty($_POST['prenom'])) {
        $prenom = '';
    }

    if (empty($_POST['email'])) {
        $email = '';
    }

    if (empty($_POST['address'])) {
        $address = '';
    }

    if (empty($_POST['ville'])) {
        $ville = '';
    }

    if (empty($_POST['zipcode'])) {
        $zipcode = '';
    }

    if (empty($_POST['telhome'])) {
        $telhome = '';
    }

    if (empty($_POST['telcell'])) {
        $telcell = '';
    }

    if (empty($_POST['telautre'])) {
        $telautre = '';
    }

    if (empty($_POST['heardodesia'])) {
        $heardodesia = '';
    }

    if (empty($_POST['nomress'])) {
        $nomress = '';
    }

    if (empty($_POST['emailress'])) {
        $emailress = '';
    }

    if (empty($_POST['cv'])) {
        $cv = '';
    }

    if (empty($_POST['rec'])) {
        $rec = '';
    }

    $GLOBALS['xoopsOption']['template_main'] = 'carriere_jobform.html';

    require XOOPS_ROOT_PATH . '/header.php';

    require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

    require_once __DIR__ . '/include/functions.php';

    global $xoopsDB, $xoopsTpl, $xoopsModule, $xoopsModuleConfig;

    $result = $xoopsDB->query('SELECT id_job, id_titre, id_typeposte, id_locations, posted_date, start_date, end_date, id_status FROM ' . $xoopsDB->prefix('ev_job') . " WHERE id_job=$job_id");

    [$job_id, $titres_id, $typeposte_id, $locations_id, $jobposteddate, $jobstartdate, $jobenddate, $status_id] = $xoopsDB->fetchRow($result);

    $titres = reference('ev_titres', 'titres', 'id_titres', $titres_id);

    $typeposte = reference('ev_typeposte', 'typeposte', 'id_typeposte', $typeposte_id);

    $locations = reference('ev_locations', 'locations', 'id_locations', $locations_id);

    $status = reference('ev_status', 'status', 'id_status', $status_id);

    $jobposteddate = formatTimestamp($jobposteddate, 'Y-m-d');

    $jobstartdate = formatTimestamp($jobstartdate, 'Y-m-d');

    $jobenddate = formatTimestamp($jobenddate, 'Y-m-d');

    $xoopsTpl->assign('lang_VIEWID', _MI_EV_VIEWID);

    $xoopsTpl->assign('lang_VIEWTITRE', _MI_EV_VIEWTITRE);

    $xoopsTpl->assign('lang_VIEWTYPEPOSTE', _MI_EV_VIEWTYPEPOSTE);

    $xoopsTpl->assign('lang_VIEWLOCATION', _MI_EV_VIEWLOCATION);

    $xoopsTpl->assign('lang_VIEWSTATUS', _MI_EV_VIEWSTATUS);

    $xoopsTpl->assign('lang_VIEWSTARTDDATE', _MI_EV_VIEWSTARTDDATE);

    $xoopsTpl->assign('lang_VIEWENDDATE', _MI_EV_VIEWENDDATE);

    $xoopsTpl->assign('ev_job_id', $job_id);

    $xoopsTpl->assign('ev_jobposteddate', $jobposteddate);

    $xoopsTpl->assign('ev_titres', $titres);

    $xoopsTpl->assign('ev_typeposte', $typeposte);

    $xoopsTpl->assign('ev_locations', $locations);

    $xoopsTpl->assign('ev_status', $status);

    $xoopsTpl->assign('ev_jobstartdate', $jobstartdate);

    $xoopsTpl->assign('ev_jobenddate', $jobenddate);

    $postuler = new XoopsThemeForm(_MI_EV_FORMAPPLY, 'postuler', 'jobapply.php');

    $postuler->setExtra("enctype='multipart/form-data'"); //de xoops-doc

    $postuler->addElement(new XoopsFormHidden('job_id', $job_id));

    $postuler->addElement(new XoopsFormHidden('op', 'sendapply'));

    $postuler->addElement(new XoopsFormHidden('titres', $titres));

    $postuler->addElement(new xoopsFormText('* ' . _MI_EV_POSTPRENOM, 'prenom', 40, 255, $prenom), true);

    $postuler->addElement(new xoopsFormText('* ' . _MI_EV_POSTNOM, 'nom', 40, 255, $nom), true);

    $postuler->addElement(new xoopsFormText('* ' . _MI_EV_EMAIL, 'email', 40, 255, $email), true);

    $postuler->addElement(new xoopsFormText(_MI_EV_ADDRESS, 'address', 40, 255, $address));

    $postuler->addElement(new xoopsFormText(_MI_EV_VILLE, 'ville', 40, 255, $ville));

    $postuler->addElement(new xoopsFormText(_MI_EV_PROVINCE, 'province', 40, 255, 'Quebec'));

    $postuler->addElement(new xoopsFormText(_MI_EV_PAYS, 'pays', 40, 255, 'Canada'));

    $postuler->addElement(new xoopsFormText(_MI_EV_ZIPCODE, 'zipcode', 10, 7, $zipcode));

    $postuler->addElement(new xoopsFormText(_MI_EV_TELHOME, 'telhome', 16, 21, $telhome));

    $postuler->addElement(new xoopsFormText(_MI_EV_TELCELL, 'telcell', 16, 21, $telcell));

    $postuler->addElement(new xoopsFormText(_MI_EV_TELAUTRE, 'telautre', 16, 21, $telautre));

    $postuler->addElement(new xoopsFormLabel('<br><HR><br>', '<br><HR><br>'));

    $cv_box = new XoopsFormFile('* ' . _MI_EV_CVFULL, 'cv', 50000);

    $postuler->addElement($cv_box, true);

    $postuler->addElement(new xoopsFormLabel('<br>', '<br>'));

    $rec_box = new XoopsFormFile(_MI_EV_RECFULL, 'rec', 50000);

    $postuler->addElement($rec_box, false);

    $postuler->addElement(new xoopsFormLabel('<br><HR><br>', '<br><HR><br>'));

    $object = new xoopsFormSelect(_MI_EV_WHEREODESIA, 'heardodesia', $heardodesia, 1, false);

    $object->addOption('------------------------');

    $object->addOption("Site web de l'entreprise");

    $object->addOption('Jobbom');

    $object->addOption('Monster');

    $object->addOption("Recommandation d'un employé");

    $object->addOption('Revues spécialisées');

    $postuler->addElement($object);

    $postuler->addElement(new xoopsFormLabel('<br><HR>', '<br><HR>'));

    $postuler->addElement(new xoopsFormLabel('', _MI_EV_RECOMMANDFULL));

    $postuler->addElement(new xoopsFormLabel('<br>', '<br>'));

    $postuler->addElement(new xoopsFormText(_MI_EV_POSTNOMPRENOM, 'nomress', 40, 255, $nomress));

    $postuler->addElement(new xoopsFormText(_MI_EV_EMAIL, 'emailress', 40, 255, $emailress));

    $button_tray = new XoopsFormElementTray('', '');

    $button_tray->addElement(new XoopsFormButton('', 'submit', _MI_EV_POSTULER, 'submit'));

    $postuler->addElement($button_tray);

    $postuler->assign($xoopsTpl);

    include 'footer.php';
} else {
    require_once XOOPS_ROOT_PATH . '/class/uploader.php';

    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig;

    if (empty($_POST['nom'])) {
        $nom = '';
    }

    if (empty($_POST['prenom'])) {
        $prenom = '';
    }

    if (empty($_POST['email'])) {
        $email = '';
    }

    if (empty($_POST['address'])) {
        $address = '';
    }

    if (empty($_POST['ville'])) {
        $ville = '';
    }

    if (empty($_POST['zipcode'])) {
        $zipcod = '';
    }

    if (empty($_POST['telhome'])) {
        $telhome = '';
    }

    if (empty($_POST['telcell'])) {
        $telcell = '';
    }

    if (empty($_POST['telautre'])) {
        $telautre = '';
    }

    if (empty($_POST['heardodesia'])) {
        $heardodesia = '';
    }

    if (empty($_POST['nomress'])) {
        $nomress = '';
    }

    if (empty($_POST['emailress'])) {
        $emailress = '';
    }

    if (empty($_POST['cv'])) {
        $cv = '';
    }

    if (empty($_POST['rec'])) {
        $rec = '';
    }

    //$xoopsModuleConfig['sbuploaddir']

    extract($_POST);

    $myts = MyTextSanitizer::getInstance();

    $job_id = $myts->stripSlashesGPC($job_id);

    $prenom = $myts->stripSlashesGPC($prenom);

    $nom = $myts->stripSlashesGPC($nom);

    $email = $myts->stripSlashesGPC($email);

    $address = $myts->stripSlashesGPC($address);

    $ville = $myts->stripSlashesGPC($ville);

    $province = $myts->stripSlashesGPC($province);

    $pays = $myts->stripSlashesGPC($pays);

    $zipcode = $myts->stripSlashesGPC($zipcode);

    $telcell = $myts->stripSlashesGPC($telcell);

    $telhome = $myts->stripSlashesGPC($telhome);

    $telautre = $myts->stripSlashesGPC($telautre);

    $titres = $myts->stripSlashesGPC($titres);

    $Name = "$prenom $nom";

    $cv = $cv;

    $CandidatureMessage = '' . _MI_EV_SUBMITTED . " $Name\n";

    $CandidatureMessage .= '' . _MI_EV_EMAIL . " $email\n";

    $CandidatureMessage .= "\n";

    $CandidatureMessage .= sprintf(_MI_EV_INFOPOST, $titres, $job_id) . "\n";

    $CandidatureMessage .= "\n";

    $CandidatureMessage .= _MI_EV_POSTLINK . "\n";

    $CandidatureMessage .= XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . "/viewjob.php?op=EVFullviewByID&job_id=$job_id\n";

    $CandidatureMessage .= "\n";

    $CandidatureMessage .= _MI_EV_POSTINFORMATION . "\n";

    if (!empty($address)) {
        $CandidatureMessage .= "\t" . _MI_EV_ADDRESS . "  $address\n";
    }

    if (!empty($ville)) {
        $CandidatureMessage .= "\t" . _MI_EV_VILLE . "    $ville\n";
    }

    if (!empty($pays)) {
        $CandidatureMessage .= "\t" . _MI_EV_PROVINCE . " $province\n";
    }

    if (!empty($pays)) {
        $CandidatureMessage .= "\t" . _MI_EV_PAYS . "     $pays\n";
    }

    if (!empty($zipcode)) {
        $CandidatureMessage .= "\t" . _MI_EV_ZIPCODE . " $zipcode\n";
    }

    if (!empty($telcell)) {
        $CandidatureMessage .= "\t" . _MI_EV_TELCELL . "  $telcell\n";
    }

    if (!empty($telhome)) {
        $CandidatureMessage .= "\t" . _MI_EV_TELHOME . " $telhome\n";
    }

    if (!empty($telautre)) {
        $CandidatureMessage .= "\t" . _MI_EV_TELAUTRE . "       $telautre\n";
    }

    $CandidatureMessage .= "\n" . _MI_EV_POSTINFORMATIONPLUS . "\n";

    $cvname = mb_strrchr($cv, '\\');

    $cvname = str_replace('\\', '/', $cvname);

    //pour l'uploader sur le serveur
    $max_imgsize = $xoopsModuleConfig['maxfilesize']; // ou = $xoopsModuleConfig[max_imgsize]
    $allowed_mimetypes = explode(';', $xoopsModuleConfig['cv_extention']);

    $cv_dir = XOOPS_ROOT_PATH . $xoopsModuleConfig['sbuploaddir_cv']; // ou = XOOPS_UPLOAD_PATH; (répertoire upload de xoops)

    $field = $_POST['xoops_upload_file'][0];

    if (!empty($field) || '' != $field) {
        if ('' == $_FILES[$field]['tmp_name'] || !is_readable($_FILES[$field]['tmp_name'])) {
            redirect_header(
                "jobapply.php?op=EVFullviewByID&job_id=$job_id&prenom=$prenom&nom=$nom&email=$email&address=$address&ville=$ville&zipcode=$zipcode&telcell=$telcell&telhome=$telhome&telautre=$telautre&heardodesia=$heardodesia&nomress=$nomress&emailress=$emailress",
                4,
                _MI_EV_SENDDOCTYPEERROR
            );

            exit;
        }

        $uploader = new XoopsMediaUploader($cv_dir, $allowed_mimetypes, $max_imgsize, null, null);

        if ($uploader->fetchMedia($field) && $uploader->upload('ahh' . $field)) {
            $mydate = date('Ymd_His');

            $oldfile = XOOPS_ROOT_PATH . $xoopsModuleConfig['sbuploaddir_cv'] . '/' . mb_strtolower($HTTP_POST_FILES['cv']['name']);

            $newfile = XOOPS_ROOT_PATH . $xoopsModuleConfig['sbuploaddir_cv'] . '/' . $mydate . '_' . mb_strtolower($HTTP_POST_FILES['cv']['name']);

            //$oldfile = "c:\temp.txt";

            //$newfile = "c:\temp1.txt";

            rename($oldfile, $newfile);

            chmod($newfile, 0755);

            $msgformupdate = 'File uploaded successfully!';
        } else {
            $msgformupdate = $uploader->getErrors();
        }
    }

    //fin de uploader pour le serveur

    $url = XOOPS_URL . $xoopsModuleConfig['sbuploaddir_cv'] . '/' . $mydate . '_' . mb_strtolower($HTTP_POST_FILES['cv']['name']);

    $url = str_replace(' ', '%20', $url);

    $CandidatureMessage .= "\t" . _MI_EV_CVSHORT . $url . "\n";

    $CandidatureMessage .= "\t" . _MI_EV_WHEREODESIA;

    $CandidatureMessage .= "\t" . $heardodesia . "\n";

    $CandidatureMessage .= "\t" . _MI_EV_RECOMMANDSHORT;

    $CandidatureMessage .= "\t" . $nomress . ' (' . $emailress . ')';

    $subject = $xoopsConfig['sitename'] . ' - ' . _MI_EV_APPLYFORM . $titres;

    $xoopsMailer = getMailer();

    $xoopsMailer->useMail();

    $xoopsMailer->setToEmails($xoopsModuleConfig['emailrh']);

    $xoopsMailer->setFromEmail($email);

    $xoopsMailer->setFromName($xoopsConfig['sitename']);

    $xoopsMailer->setSubject($subject);

    $xoopsMailer->setBody($CandidatureMessage);

    $xoopsMailer->send();

    $messagesent = _MI_EV_MESSAGESENT . '<br>' . _MI_EV_MESSAGESENT2 . '<br><br>' . _MI_EV_THANKYOU . '';

    // uncomment the following lines if you want to send confirmation mail to the user

    $CandidatConfirmMessage = sprintf(_MI_EV_CONFIRMHELLO, $Name);

    $CandidatConfirmMessage .= "\n\n";

    $CandidatConfirmMessage .= sprintf(_MI_EV_THANKYOUDEMANDE, $titres);

    //$CandidatureMessage .= _MI_EV_CONFIRMPOSTLINK."\n";

    //$CandidatureMessage .= XOOPS_URL. "/modules/". $xoopsModule->getVar('dirname')."/viewjob.php?op=EVFullviewByID&job_id=$job_id\n";

    $CandidatConfirmMessage .= "\n\n";

    $CandidatConfirmMessage .= _MI_EV_CONFIRMMSGINFO;

    $CandidatConfirmMessage .= "\n";

    if (!empty($address)) {
        $CandidatConfirmMessage .= "\t" . _MI_EV_ADDRESS . "  $address\n";
    }

    if (!empty($ville)) {
        $CandidatConfirmMessage .= "\t" . _MI_EV_VILLE . "    $ville\n";
    }

    if (!empty($pays)) {
        $CandidatConfirmMessage .= "\t" . _MI_EV_PROVINCE . " $province\n";
    }

    if (!empty($pays)) {
        $CandidatConfirmMessage .= "\t" . _MI_EV_PAYS . "     $pays\n";
    }

    if (!empty($zipcode)) {
        $CandidatConfirmMessage .= "\t" . _MI_EV_ZIPCODE . " $zipcode\n";
    }

    if (!empty($telcell)) {
        $CandidatConfirmMessage .= "\t" . _MI_EV_TELCELL . "  $telcell\n";
    }

    if (!empty($telhome)) {
        $CandidatConfirmMessage .= "\t" . _MI_EV_TELHOME . " $telhome\n";
    }

    if (!empty($telautre)) {
        $CandidatConfirmMessage .= "\t" . _MI_EV_TELAUTRE . "       $telautre\n";
    }

    $CandidatConfirmMessage .= "\t" . _MI_EV_CVSHORT . $HTTP_POST_FILES['cv']['name'] . "\n";

    $CandidatConfirmMessage .= "\t" . _MI_EV_RECSHORT . $HTTP_POST_FILES['rec']['name'] . "\n";

    $CandidatConfirmMessage .= "\t" . _MI_EV_WHEREODESIA;

    $CandidatConfirmMessage .= "\t" . $heardodesia . "\n";

    $CandidatConfirmMessage .= "\t" . _MI_EV_RECOMMANDSHORT;

    $CandidatConfirmMessage .= "\t" . $nomress . ' (' . $emailress . ')';

    $CandidatConfirmMessage .= "\n\n";

    $CandidatConfirmMessage .= _MI_EV_RHTANK;

    $CandidatConfirmMessage .= "\n";

    $CandidatConfirmMessage .= $myts->displayTarea($xoopsModuleConfig['departementname']);

    $CandidatConfirmMessage .= "\n";

    $CandidatConfirmMessage .= $xoopsModuleConfig['emailrh'];

    $CandidatConfirmMessage .= "\n";

    $CandidatConfirmMessage .= XOOPS_URL;

    $confirm_subject = sprintf(_MI_EV_CONFIRMTHANKYOU, $titres);

    $xoopsMailer = getMailer();

    $xoopsMailer->useMail();

    $xoopsMailer->setToEmails($email);

    $xoopsMailer->setFromEmail($xoopsModuleConfig['emailrh']);

    $xoopsMailer->setFromName($xoopsConfig['sitename']);

    $xoopsMailer->setSubject($confirm_subject);

    $xoopsMailer->setBody($CandidatConfirmMessage);

    $xoopsMailer->send();

    //requêtre SQL pour domper les trucs dans la bd

    //$query = "INSERT INTO ".$xoopsDB->prefix("ev_cv")." VALUES('$prenom','$nom','$email','$address', '$ville', '$province', '$pays', '$zipcode', '$telhome', '$telcell', '$telautre', '$HTTP_POST_FILES['cv']['name']','$HTTP_POST_FILES['rec']['name']', '$heardodesia', '$nomress', '$emailress'";

    //$query = "INSERT INTO ".$xoopsDB->prefix("ev_cv")." VALUES('$prenom', '$nom','$email','$address', '$ville', '$province', '$pays', '$zipcode', '$telhome', '$telcell', '$telautre', '$url_cv_short', '$url_rec_short', '$heardodesia', '$nomress', '$emailress')";

    //$real_query = "INSERT INTO xoops_ev_cv (name, family_name, email, address, city, province, country, zipcode, telhome, telcell, telother, cv, rec_letter, heardodesia, rec_name, rec_email) VALUES('alex', 'parent','aparent@odesia.com','', '', 'Quebec', 'Canada', '', '', '', '', 'CV_20040922_150747_bi market.doc', '', '------------------------', '', '')";

    $real_query = sprintf(
        "INSERT INTO %s (name, family_name, email, address, city, province, country, zipcode, tel_home, tel_cell, tel_other, cv, rec_letter, heard_odesia, rec_name, rec_email, id_poste) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', %u)",
        $xoopsDB->prefix('ev_cv'),
        $prenom,
        $nom,
        $email,
        $address,
        $ville,
        $province,
        $pays,
        $zipcode,
        $telhome,
        $telcell,
        $telautre,
        $url_cv_short,
        $url_rec_short,
        $heardodesia,
        $nomress,
        $emailress,
        $job_id
    );

    $result = $xoopsDB->query($real_query);

    redirect_header("viewjob.php?op=EVFullviewByID&job_id=$job_id", 7, $messagesent . "\n" . $msgformupdate);
}
