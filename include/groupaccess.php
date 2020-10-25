<?php

// $Id: groupaccess.php,v 1.1 2006/02/22 15:35:20 mikhail Exp $

/* -----------------------------------------------------------------------------------------
Useage:
require_once XOOPS_ROOT_PATH . "/include/groupaccess.php";
------------------------------------------------------------------------------------------*/

/* -----------------------------------------------------------------------------------------
listGroups()
Lists all availiable groups in the database. Used in admin interface.

Useage:
listGroups("checkAll"); or listGroups(); or listGroups($groupid); or listGroups("1 3 4");

listGroups("checkAll"); & listGroups();
* Will preckeck all boxes.
* This is usefull for new entries where groupids don't pre-exist.

listGroups($groupid);
* Will preckeck any matches.
* $groupid can either contain a space delimited string of numbers or an array of numbers.
* $groupid is normaly taken from the dbtable of the module in question.

listGroups("1 3 4");
* Will preckeck any group matching any of the numbers.
------------------------------------------------------------------------------------------*/
function listGroups($grps = 'checkAll')
{
    global $xoopsDB, $myts;

    $result = $xoopsDB->queryF('SELECT groupid, name FROM ' . $xoopsDB->prefix('groups') . ' ORDER BY name ASC');

    if (!is_array($grps)) {
        $grps = explode(' ', $grps);
    }

    while (list($groupid, $name) = $xoopsDB->fetchRow($result)) {
        if ('4' == $i) {
            $grouplist .= '<br>';

            $i = 0;
        }

        $grouplist .= "<input type='checkbox' name='groupid[]' value='$groupid'";

        if (@in_array($groupid, $grps, true) || @in_array('checkAll', $grps, true)) {
            $grouplist .= ' checked';
        }

        $grouplist .= '>' . htmlspecialchars($name, ENT_QUOTES | ENT_HTML5);

        $i++;
    }

    echo $grouplist;
}

/* -----------------------------------------------------------------------------------------
checkAccess()
Checks if the current user accessing the page belongs to one of the $grps, and if not,
sends him where you like. Used in modules.

Useage:
checkAccess(<groups to check against>, <redirect to>, <time>, <error message>);

Example:
checkAccess($groupid, XOOPS_URL . "/", 2, _NOPERM);
checkAccess($groupid, "javascript:history.go(-1)", 2, _NOPERM);
checkAccess($groupid);
checkAccess("1 2 3");

* $groupid is normaly taken from the dbtable of the module in question.
* $groupid can either be an array of numbers or a space delimited string. see: listGroups()
------------------------------------------------------------------------------------------*/
function checkAccess($groupid, $url = 'index.php', $time = '2', $msg = _NOPERM)
{
    global $xoopsUser;

    if (!$xoopsUser) {
        $grps = [XOOPS_GROUP_ANONYMOUS];
    } else {
        $grps = array_merge($xoopsUser->getGroups(), XOOPS_GROUP_ANONYMOUS);
    }

    $groupid = explode(' ', $groupid);

    for ($i = 0, $iMax = count($groupid); $i < $iMax; $i++) {
        if (@in_array($groupid[$i], $grps, true)) {
            $hasAccess = 'TRUE';
        }
    }

    if ('TRUE' == !$hasAccess) {
        if (-1 == $time) {
            return 0;
        }

        redirect_header($url, $time, $msg);

        exit();
    }

    return 1;
}

/*
$hasAccess = '';

$groupid = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(XOOPS_GROUP_ANONYMOUS);

$grps = explode(" ", $grps);
    for ($i=0; $i<count($grps); $i++) {
        if (@in_array($grps[$i], $groupid)) {
        $hasAccess="TRUE";
        }
    }

    if ($hasAccess) {
     if ($hasAccess != "TRUE") {
            if($time == -1) {
                return 0;
            } else {
            redirect_header($url, $time, $msg);
            exit();
            }
        }
    }
return 1;
}
*/

/* -----------------------------------------------------------------------------------------
saveAccess()
Makes sure $groupid is a space delimited string and not an array, before saving to database.
Used in admin interface.

Useage:
$groupid = saveAccess($groupid);
------------------------------------------------------------------------------------------*/
function saveAccess($grps)
{
    if (is_array($grps)) {
        $grps = implode(' ', $grps);
    }

    return ($grps);
}
