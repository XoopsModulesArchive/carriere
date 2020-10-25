<?php

// ------------------------------------------------------------------------- //
//                    Module Carrière pour Xoops 2.0.7                       //
//                              Version:  1.0                                //
// ------------------------------------------------------------------------- //
// Author: Yoyo2021                                        				     //
// Purpose: Module Carrière                          				 //
// email: info@fpsquebec.net                                                 //
// URLs: http://www.fpsquebec.net                      //
//---------------------------------------------------------------------------//
global $xoopsModuleConfig;
$modversion['name'] = _MI_EV_NAME;
$modversion['version'] = 1.0;
$modversion['description'] = _MI_EV_DESC;
$modversion['credits'] = 'Mathieu Delisle (info@site3web.net)';
$modversion['author'] = 'Ecrit pour Xoops2<br>par MAthieu Delisle (Yoyo2021)<br>http://www.site3web.net';
$modversion['license'] = '';
$modversion['official'] = 1;
$modversion['image'] = 'images/ev_slogo.png';
$modversion['help'] = '';
$modversion['dirname'] = 'carriere';

// MYSQL FILE
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';

// Tables created by sql file
//If you hack this modules, dont change the order of the table.
//All
$modversion['tables'][0] = 'ev_job';
$modversion['tables'][1] = 'ev_locations';
$modversion['tables'][2] = 'ev_status';
$modversion['tables'][3] = 'ev_titres';
$modversion['tables'][4] = 'ev_typeposte';
$modversion['tables'][5] = 'ev_quote';
$modversion['tables'][6] = 'ev_menulink';
$modversion['tables'][7] = 'ev_jobform_forms';
$modversion['tables'][8] = 'ev_jobform_formelements';

$modversion['onInstall'] = 'include/functions.php';

$modversion['templates'][1]['file'] = 'carriere_index.html';
$modversion['templates'][1]['description'] = '';
$modversion['templates'][2]['file'] = 'carriere_joblist.html';
$modversion['templates'][2]['description'] = '';
$modversion['templates'][3]['file'] = 'carriere_jobview.html';
$modversion['templates'][3]['description'] = '';
$modversion['templates'][4]['file'] = 'carriere_temoignageview.html';
$modversion['templates'][4]['description'] = '';
$modversion['templates'][5]['file'] = 'carriere_temoignagelist.html';
$modversion['templates'][5]['description'] = '';
$modversion['templates'][6]['file'] = 'carriere_jobform.html';
$modversion['templates'][6]['description'] = '';
$modversion['templates'][7]['file'] = 'carriere_desctitre.html';
$modversion['templates'][7]['description'] = '';
$modversion['templates'][8]['file'] = 'carriere_sendfriend.html';
$modversion['templates'][8]['description'] = '';

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';

// Menu
$modversion['hasMain'] = 1;
$modversion['sub'][1]['name'] = _MI_EV_SMNAME1;
$modversion['sub'][1]['url'] = 'emplois.php';
$modversion['sub'][2]['name'] = _MI_EV_SMNAME2;
$modversion['sub'][2]['url'] = 'temoignage.php';

// Blocks
$modversion['blocks'][1]['file'] = 'carriere_block.php';
$modversion['blocks'][1]['name'] = _MI_EV_BNAME1;
$modversion['blocks'][1]['description'] = 'Affiche les 5 derniers postes disponibles. ';
$modversion['blocks'][1]['show_func'] = 'carriere_show'; // fonction affichage du bloc
$modversion['blocks'][1]['template'] = 'carriere_block.html';

$modversion['blocks'][2]['file'] = 'random_quote.php';
$modversion['blocks'][2]['name'] = _MI_EV_BNAME2;
$modversion['blocks'][2]['description'] = _MI_EV_BDESC2;
$modversion['blocks'][2]['show_func'] = 'random_quote_show';
$modversion['blocks'][2]['template'] = 'random_quote.html';

$modversion['blocks'][3]['file'] = 'menulink.php';
$modversion['blocks'][3]['name'] = _MB_EV_NAME;
$modversion['blocks'][3]['description'] = _MB_EV_MENULINKDESC;
$modversion['blocks'][3]['show_func'] = 'a_menulink_show';
$modversion['blocks'][3]['edit_func'] = 'a_menulink_edit';
$modversion['blocks'][3]['options'] = '40';
$modversion['blocks'][3]['template'] = 'carriere_menulink.html';

//CONFIGUE

$modversion['config'][1]['name'] = 'maxfilesize';
$modversion['config'][1]['title'] = '_MI_EV_MAXFILESIZE';
$modversion['config'][1]['description'] = '_MI_EV_MAXFILESIZEDSC';
$modversion['config'][1]['formtype'] = 'textbox';
$modversion['config'][1]['valuetype'] = 'int';
$modversion['config'][1]['default'] = 250000;

$modversion['config'][2]['name'] = 'maximgwidth';
$modversion['config'][2]['title'] = '_MI_EV_IMGWIDTH';
$modversion['config'][2]['description'] = '_MI_EV_IMGWIDTHDSC';
$modversion['config'][2]['formtype'] = 'textbox';
$modversion['config'][2]['valuetype'] = 'int';
$modversion['config'][2]['default'] = 800;

$modversion['config'][3]['name'] = 'maximgheight';
$modversion['config'][3]['title'] = '_MI_EV_IMGHEIGHT';
$modversion['config'][3]['description'] = '_MI_EV_IMGHEIGHTDSC';
$modversion['config'][3]['formtype'] = 'textbox';
$modversion['config'][3]['valuetype'] = 'int';
$modversion['config'][3]['default'] = 800;

$modversion['config'][4]['name'] = 'sbuploaddir_quote';
$modversion['config'][4]['title'] = '_MI_EV_UPLOADDIR_QUOTE';
$modversion['config'][4]['description'] = '_MI_EV_UPLOADDIRDSC_QUOTE';
$modversion['config'][4]['formtype'] = 'textbox';
$modversion['config'][4]['valuetype'] = 'text';
$modversion['config'][4]['default'] = '/uploads/carriere/temoignage';

$modversion['config'][5]['name'] = 'sbuploaddir_cv';
$modversion['config'][5]['title'] = '_MI_EV_UPLOADDIR_CV';
$modversion['config'][5]['description'] = '_MI_EV_UPLOADDIRDSC_CV';
$modversion['config'][5]['formtype'] = 'textbox';
$modversion['config'][5]['valuetype'] = 'text';
$modversion['config'][5]['default'] = '/uploads/carriere/cv';

$modversion['config'][6]['name'] = 'image_extention';
$modversion['config'][6]['title'] = '_MI_EV_IMAGEEXTENTION';
$modversion['config'][6]['description'] = '_MI_EV_IMAGEEXTENTIONDSC';
$modversion['config'][6]['formtype'] = 'textbox';
$modversion['config'][6]['valuetype'] = 'text';
$modversion['config'][6]['default'] = 'image/gif;image/jpg';

$modversion['config'][7]['name'] = 'cv_extention';
$modversion['config'][7]['title'] = '_MI_EV_CVEXTENTION';
$modversion['config'][7]['description'] = '_MI_EV_CVEXTENTIONDSC';
$modversion['config'][7]['formtype'] = 'textbox';
$modversion['config'][7]['valuetype'] = 'text';
$modversion['config'][7]['default'] = 'cv/doc;cv/pdf';

$modversion['config'][8]['name'] = 'dateformat';
$modversion['config'][8]['title'] = '_MI_EV_DATEFORMAT';
$modversion['config'][8]['description'] = '_MI_EV_DATEFORMATDSC';
$modversion['config'][8]['formtype'] = 'textbox';
$modversion['config'][8]['valuetype'] = 'text';
$modversion['config'][8]['default'] = 'd-M-Y';

$modversion['config'][9]['name'] = 'emailrh';
$modversion['config'][9]['title'] = '_MI_EV_EMAILRH';
$modversion['config'][9]['description'] = '_MI_EV_EMAILRHDESC';
$modversion['config'][9]['formtype'] = 'textbox';
$modversion['config'][9]['valuetype'] = 'text';
$modversion['config'][9]['default'] = $xoopsConfig['adminmail'];

$modversion['config'][10]['name'] = 'evintro';
$modversion['config'][10]['title'] = '_MI_EV_INTRO';
$modversion['config'][10]['description'] = '_MI_EV_INTRODESC';
$modversion['config'][10]['formtype'] = 'textarea';
$modversion['config'][10]['valuetype'] = 'text';
$modversion['config'][10]['default'] = '[fr]Introduction[/fr][en]Introduction[/en]';

$modversion['config'][11]['name'] = 'ev_cie';
$modversion['config'][11]['title'] = '_MI_EV_CIE';
$modversion['config'][11]['description'] = '_MI_EV_CIEDESC';
$modversion['config'][11]['formtype'] = 'textbox';
$modversion['config'][11]['valuetype'] = 'text';
$modversion['config'][11]['default'] = '';

$modversion['config'][12]['name'] = 'sendbymail';
$modversion['config'][12]['title'] = '_MI_EV_SENDBYMAIL';
$modversion['config'][12]['description'] = '_MI_EV_SENDBYMAILDSC';
$modversion['config'][12]['formtype'] = 'yesno';
$modversion['config'][12]['valuetype'] = 'int';
$modversion['config'][12]['default'] = 1;

$modversion['config'][13]['name'] = 'savedb';
$modversion['config'][13]['title'] = '_MI_EV_SAVEDB';
$modversion['config'][13]['description'] = '_MI_EV_SAVEDBDSC';
$modversion['config'][13]['formtype'] = 'yesno';
$modversion['config'][13]['valuetype'] = 'int';
$modversion['config'][13]['default'] = 1;

$modversion['config'][14]['name'] = 'departementname';
$modversion['config'][14]['title'] = '_MI_EV_DEPARTEMENTNAME';
$modversion['config'][14]['description'] = '_MI_EV_DEPARTEMENTNAMEDSC';
$modversion['config'][14]['formtype'] = 'textbox';
$modversion['config'][14]['valuetype'] = 'text';
$modversion['config'][14]['default'] = '[fr][/fr][en][/en]';

/*$modversion['config'][12]['name'] = 'ev_valeur';
$modversion['config'][12]['title'] = '_MI_EV_VALEUR';
$modversion['config'][12]['description'] = '_MI_EV_VALEURDESC';
$modversion['config'][12]['formtype'] = 'textarea';
$modversion['config'][12]['valuetype'] = 'text';
$modversion['config'][12]['default'] = '[fr][/fr][en][/en]';*/
