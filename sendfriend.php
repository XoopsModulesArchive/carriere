<?php

include 'header.php';
$job_id = $_POST['job_id'];
$myts = MyTextSanitizer::getInstance();

if (empty($_POST['submit'])) {
    $GLOBALS['xoopsOption']['template_main'] = 'carriere_sendfriend.html';

    require XOOPS_ROOT_PATH . '/header.php';

    require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

    require_once __DIR__ . '/include/functions.php';

    global $xoopsDB, $xoopsTpl;

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

    $postuler = new XoopsThemeForm(_MI_EV_FORMAPPLY, 'postuler', 'sendfriend.php');

    $postuler->addElement(new XoopsFormHidden('job_id', $job_id));

    $postuler->addElement(new XoopsFormHidden('op', 'sendapply'));

    $postuler->addElement(new XoopsFormHidden('titres', $titres));

    $postuler->addElement(new xoopsFormLabel('<b><u>' . _MI_EV_POSTENVOYEUR . '</u></b>', ''));

    $postuler->addElement(new xoopsFormLabel('<br>', ''));

    $postuler->addElement(new xoopsFormText(_MI_EV_POSTNOMPRENOM, 'envoyeur', 40, 255, ''));

    $postuler->addElement(new xoopsFormLabel('<br><br>', ''));

    $postuler->addElement(new xoopsFormLabel('<b><u>' . _MI_EV_DESTINATAIRES . '</b></u>', ''));

    $postuler->addElement(new xoopsFormLabel('<br>', ''));

    $postuler->addElement(new xoopsFormText(_MI_EV_POSTNOMPRENOM, 'prenomnom1', 40, 255, ''));

    $postuler->addElement(new xoopsFormText(_MI_EV_EMAIL, 'email1', 40, 255, ''));

    $postuler->addElement(new xoopsFormLabel('<br>', ''));

    $postuler->addElement(new xoopsFormText(_MI_EV_POSTNOMPRENOM, 'prenomnom2', 40, 255, ''));

    $postuler->addElement(new xoopsFormText(_MI_EV_EMAIL, 'email2', 40, 255, ''));

    $postuler->addElement(new xoopsFormLabel('<br>', ''));

    $postuler->addElement(new xoopsFormText(_MI_EV_POSTNOMPRENOM, 'prenomnom3', 40, 255, ''));

    $postuler->addElement(new xoopsFormText(_MI_EV_EMAIL, 'email3', 40, 255, ''));

    $postuler->addElement(new xoopsFormLabel('<br>', ''));

    $postuler->addElement(new xoopsFormText(_MI_EV_POSTNOMPRENOM, 'prenomnom4', 40, 255, ''));

    $postuler->addElement(new xoopsFormText(_MI_EV_EMAIL, 'email4', 40, 255, ''));

    $postuler->addElement(new xoopsFormLabel('<br>', ''));

    $postuler->addElement(new xoopsFormText(_MI_EV_POSTNOMPRENOM, 'prenomnom5', 40, 255, ''));

    $postuler->addElement(new xoopsFormText(_MI_EV_EMAIL, 'email5', 40, 255, ''));

    $postuler->addElement(new xoopsFormLabel('<br>', ''));

    $button_tray = new XoopsFormElementTray('', '');

    $button_tray->addElement(new XoopsFormButton('', 'submit', _MI_EV_SENDTOFRIEND, 'submit'));

    $postuler->addElement($button_tray);

    $postuler->assign($xoopsTpl);

    include 'footer.php';
} else {
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig;

    //$xoopsModuleConfig['sbuploaddir']

    extract($_POST);

    $myts = MyTextSanitizer::getInstance();

    $job_id = $myts->stripSlashesGPC($job_id);

    $email = $myts->stripSlashesGPC($email1);

    $CandidatureMessage = $envoyeur;

    $CandidatureMessage .= _MI_EV_SENDFRIENDBODYRH;

    $CandidatureMessage .= "\n\n\t";

    $CandidatureMessage .= $titres;

    $CandidatureMessage .= "\n\n\t";

    if (!empty($prenomnom1) && !empty($email1)) {
        $CandidatureMessage .= $prenomnom1 . '(' . $email1 . ")\n\t";
    }

    if (!empty($prenomnom2) && !empty($email2)) {
        $CandidatureMessage .= $prenomnom2 . '(' . $email2 . ")\n\t";
    }

    if (!empty($prenomnom3) && !empty($email3)) {
        $CandidatureMessage .= $prenomnom3 . '(' . $email3 . ")\n\t";
    }

    if (!empty($prenomnom4) && !empty($email4)) {
        $CandidatureMessage .= $prenomnom4 . '(' . $email4 . ")\n\t";
    }

    if (!empty($prenomnom5) && !empty($email5)) {
        $CandidatureMessage .= $prenomnom5 . '(' . $email5 . ")\n\t";
    }

    $subject = $xoopsConfig['sitename'] . ' - ' . _MI_EV_SENDFRIENDRHCONF . _MI_EV_POSTE . $titres;

    $xoopsMailer = getMailer();

    $xoopsMailer->useMail();

    $xoopsMailer->setToEmails($xoopsModuleConfig['emailrh']);

    $xoopsMailer->setFromEmail($xoopsModuleConfig['emailrh']);

    $xoopsMailer->setFromName($xoopsConfig['sitename']);

    $xoopsMailer->setSubject($subject);

    $xoopsMailer->setBody($CandidatureMessage);

    $xoopsMailer->send();

    $messagesent = _MI_EV_MESSAGESENT . '<br>' . _MI_EV_MESSAGESENT2 . '<br><br>' . _MI_EV_THANKYOU . '';

    //envoie de 1 à 5 email au(x) ami(s)

    for ($x = 1; $x <= 5; $x++) {
        $confirm_subject = sprintf($envoyeur . _MI_EV_SENDFRIENDSUBJET . $titres);

        $xoopsMailer = getMailer();

        $xoopsMailer->useMail();

        $xoopsMailer->setFromEmail($xoopsModuleConfig['emailrh']);

        $xoopsMailer->setFromName($xoopsConfig['sitename']);

        $xoopsMailer->setSubject($confirm_subject);

        $canSend = false;

        switch ($x) {
            case 1:
                if (!empty($prenomnom1) && !empty($email1)) {
                    $CandidatConfirmMessage = sprintf(_MI_EV_CONFIRMHELLO, $prenomnom1);

                    $xoopsMailer->setToEmails($email1);

                    $canSend = true;
                }
                break;
            case 2:
                if (!empty($prenomnom2) && !empty($email2)) {
                    $CandidatConfirmMessage = sprintf(_MI_EV_CONFIRMHELLO, $prenomnom2);

                    $xoopsMailer->setToEmails($email2);

                    $canSend = true;
                }
                break;
            case 3:
                if (!empty($prenomnom3) && !empty($email3)) {
                    $CandidatConfirmMessage = sprintf(_MI_EV_CONFIRMHELLO, $prenomnom3);

                    $xoopsMailer->setToEmails($email3);

                    $canSend = true;
                }
                break;
            case 4:
                if (!empty($prenomnom4) && !empty($email4)) {
                    $CandidatConfirmMessage = sprintf(_MI_EV_CONFIRMHELLO, $prenomnom4);

                    $xoopsMailer->setToEmails($email4);

                    $canSend = true;
                }
                break;
            case 5:
                if (!empty($prenomnom5) && !empty($email5)) {
                    $CandidatConfirmMessage = sprintf(_MI_EV_CONFIRMHELLO, $prenomnom5);

                    $xoopsMailer->setToEmails($email5);

                    $canSend = true;
                }
                break;
        }

        if (true === $canSend) {
            $CandidatConfirmMessage .= "\n\n";

            $CandidatConfirmMessage .= $envoyeur;

            $CandidatConfirmMessage .= sprintf(_MI_EV_SENDFRIENDBODY);

            $CandidatConfirmMessage .= sprintf(_MI_EV_COMPAGNIE);

            $CandidatConfirmMessage .= $xoopsConfig['sitename'];

            $CandidatConfirmMessage .= "\n";

            $CandidatConfirmMessage .= sprintf(_MI_EV_POSTE);

            $CandidatConfirmMessage .= $titres;

            $CandidatConfirmMessage .= "\n\n";

            $CandidatConfirmMessage .= sprintf(_MI_EV_LIEN);

            $CandidatConfirmMessage .= XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . "/viewjob.php?op=EVFullviewByID&job_id=$job_id";

            /*$CandidatureMessage .= _MI_EV_CONFIRMPOSTLINK."\n";
            $CandidatureMessage .= XOOPS_URL. "/modules/". $xoopsModule->getVar('dirname')."/viewjob.php?op=EVFullviewByID&job_id=$job_id\n";
            */

            $CandidatConfirmMessage .= "\n\n";

            $CandidatConfirmMessage .= _MI_EV_RHTANK;

            $CandidatConfirmMessage .= "\n";

            $CandidatConfirmMessage .= $myts->displayTarea($xoopsModuleConfig['departementname']);

            $CandidatConfirmMessage .= "\n";

            $CandidatConfirmMessage .= $xoopsModuleConfig['emailrh'];

            $CandidatConfirmMessage .= "\n";

            $CandidatConfirmMessage .= XOOPS_URL;

            $xoopsMailer->setBody($CandidatConfirmMessage);

            $xoopsMailer->send();
        }
    }

    $messagesent .= sprintf(_CT_SENTASCONFIRM, $usersEmail);

    redirect_header("viewjob.php?op=EVFullviewByID&job_id=$job_id", 10, $messagesent);
}
