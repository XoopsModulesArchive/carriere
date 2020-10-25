<?php

$myts = MyTextSanitizer::getInstance();
$title = htmlspecialchars($title, ENT_QUOTES | ENT_HTML5);
$link = htmlspecialchars($link, ENT_QUOTES | ENT_HTML5);
echo '<h4>' . _AD_MULTIMENU_ADMIN_01 . '</h4>';
$formtitle = new XoopsFormText(_AD_MULTIMENU_TITLE, 'title', 50, 150, $title);
$formlink = new XoopsFormText(_AD_MULTIMENU_LINK, 'link', 50, 255, $link);
$formhide = new XoopsFormSelect(_AD_MULTIMENU_HIDE, 'hide', $hide);
$formhide->addOption('0', _NO);
$formhide->addOption('1', _YES);
$formtarget = new XoopsFormSelect(_AD_MULTIMENU_TARGET, 'target', $target);
$formtarget->addOption('_self', _AD_MULTIMENU_TARG_SELF);
$formtarget->addOption('_blank', _AD_MULTIMENU_TARG_BLANK);
$formtarget->addOption('_parent', _AD_MULTIMENU_TARG_PARENT);
$formtarget->addOption('_top', _AD_MULTIMENU_TARG_TOP);
$formgroups = new XoopsFormSelectGroup(_AD_MULTIMENU_GROUPS, 'groups', true, $groups, 5, true);
$submit_button = new XoopsFormButton('', 'submit', _AD_MULTIMENU_SUBMIT, 'submit');

$form->addElement($formtitle, true);
$form->addElement($formlink, false);
$form->addElement($formhide);
$form->addElement($formtarget);
$form->addElement($formgroups);
$form->addElement(new XoopsFormHidden('id', $id));
$form->addElement(new XoopsFormHidden('op', 'update'));
$form->addElement($submit_button);
