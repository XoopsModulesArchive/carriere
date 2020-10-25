<?php

include '../../../include/cp_header.php';
//if ( file_exists("../language/".$xoopsConfig['language']."/admin.php") ) {
//	include "../language/".$xoopsConfig['language']."/admin.php";
//} else include "../language/english/admin.php";

$op = '';
foreach ($_POST as $k => $v) {
    ${$k} = $v;
}

if (isset($_GET['op'])) {
    $op = $_GET['op'];

    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
    }
}
switch ($op) {
    case 'new':
        im_admin_new();
        break;
    case 'edit':
        im_admin_edit($id);
        break;
    case 'update':
        im_admin_update($id, $title, $link, $hide, $groups, $target);
        break;
    case 'del':
        im_admin_del($id, $del);
        break;
    case 'move':
        im_admin_move($id, $weight);
        im_admin_list();
        break;
    default:
        im_admin_list();
        break;
}

function im_admin_update($id, $title, $link, $hide, $groups, $target)
{
    $xoopsDB = XoopsDatabaseFactory::getDatabaseConnection();

    $myts = MyTextSanitizer::getInstance();

    $title = $myts->addSlashes($title);

    $link = $myts->addSlashes($link);

    $groups = (is_array($groups)) ? implode(' ', $groups) : '';

    if (empty($id)) {
        $newid = $xoopsDB->genId($xoopsDB->prefix('ev_menulink') . '_id_seq');

        $success = $xoopsDB->query('INSERT INTO ' . $xoopsDB->prefix('ev_menulink') . " (id,title,hide,link,weight,groups,target) VALUES ($newid,'$title','$hide','$link','255','$groups','$target')");

        im_admin_clean();
    } else {
        $success = $xoopsDB->query('UPDATE ' . $xoopsDB->prefix('ev_menulink') . " SET title='$title', hide='$hide', link='$link', groups='$groups', target='$target' WHERE id='$id'");
    }

    if (!$success) {
        redirect_header('menulink.php', 2, _MI_EV_MENULINK_UPDATED);
    } else {
        redirect_header('menulink.php', 2, _MI_EV_MENULINK_UPDATED);
    }

    exit();
}

function im_admin_edit($id)
{
    xoops_cp_header();

    $xoopsDB = XoopsDatabaseFactory::getDatabaseConnection();

    $result = $xoopsDB->query('SELECT title, hide, link, groups, target FROM ' . $xoopsDB->prefix('ev_menulink') . " WHERE id=$id");

    [$title, $hide, $link, $groups, $target] = $xoopsDB->fetchRow($result);

    $groups = explode(' ', $groups);

    require XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

    $form = new XoopsThemeForm(_MI_EV_MENULINK_EDITIMENU, 'editform', 'menulink.php');

    require dirname(__DIR__) . '/include/menulink.inc.php';

    $form->display();

    xoops_cp_footer();
}

function im_admin_del($id, $del = 0)
{
    $xoopsDB = XoopsDatabaseFactory::getDatabaseConnection();

    if (1 == $del) {
        if ($xoopsDB->query('DELETE FROM ' . $xoopsDB->prefix('ev_menulink') . " WHERE id=$id")) {
            im_admin_clean();

            redirect_header('menulink.php', 2, _MI_EV_MENULINK_UPDATED);
        } else {
            redirect_header('menulink.php', 2, _MI_EV_MENULINK_NOTUPDATED);
        }

        exit();
    }

    xoops_cp_header();

    echo '<h4>' . _MI_EV_MENULINK_ADMIN . '</h4>';

    xoops_confirm(['op' => 'del', 'id' => $id, 'del' => 1], 'menulink.php', _MI_EV_MENULINK_SUREDELETE);

    xoops_cp_footer();
}

function im_admin_move($id, $weight)
{
    $xoopsDB = XoopsDatabaseFactory::getDatabaseConnection();

    $xoopsDB->queryF('UPDATE ' . $xoopsDB->prefix('ev_menulink') . " SET weight=weight+1 WHERE weight>=$weight AND id<>$id");

    $xoopsDB->queryF('UPDATE ' . $xoopsDB->prefix('ev_menulink') . " SET weight=$weight WHERE id=$id");

    im_admin_clean();
}

function im_admin_new()
{
    xoops_cp_header();

    $id = 0;

    $title = '';

    $link = '';

    $hide = '';

    $weight = 255;

    $target = '_self';

    $memberHandler = xoops_getHandler('member');

    $xoopsgroups = $memberHandler->getGroups();

    $count = count($xoopsgroups);

    $groups = [];

    for ($i = 0; $i < $count; $i++) {
        $groups[] = $xoopsgroups[$i]->getVar('groupid');
    }

    require XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

    $form = new XoopsThemeForm(_MI_EV_MENULINK_NEWIMENU, 'newform', 'menulink.php');

    require dirname(__DIR__) . '/include/menulink.inc.php';

    $form->display();

    xoops_cp_footer();
}

function im_admin_list()
{
    xoops_cp_header();

    $xoopsDB = XoopsDatabaseFactory::getDatabaseConnection();

    echo '<h4>' . _MI_EV_MENULINK_ADMIN . "</h4>
	<form action='menulink.php?op=new' method='post' name='form1'>
	<table width='100%' border='0' cellspacing='1' cellpadding='0' class='outer'><tr>
	<th align='center'>" . _MI_EV_MENULINK_TITLE . "</th>
	<th align='center'>" . _MI_EV_MENULINK_HIDE . "</th>
	<th align='center'>" . _MI_EV_MENULINK_LINK . "</th>
	<th align='center'>" . _MI_EV_MENULINK_OPERATION . '</th></tr>';

    $result = $xoopsDB->query('SELECT id, link, title, hide, weight FROM ' . $xoopsDB->prefix('ev_menulink') . ' ORDER BY weight ASC');

    $class = 'even';

    while (false !== ($row = $xoopsDB->fetchArray($result))) {
        $status = (0 == $row['hide']) ? _NO : _YES;

        if (0 != $row['weight']) {
            $moveup = "<a href='menulink.php?op=move&id=" . $row['id'] . '&weight=' . ($row['weight'] - 1) . "'>[" . _MI_EV_MENULINK_UP . ']</a>';
        } else {
            $moveup = '[' . _MI_EV_MENULINK_UP . ']';
        }

        if ($row['weight'] != ($xoopsDB->getRowsNum($result) - 1)) {
            $movedown = "<a href='menulink.php?op=move&id=" . $row['id'] . '&weight=' . ($row['weight'] + 2) . "'>[" . _MI_EV_MENULINK_DOWN . ']</a>';
        } else {
            $movedown = '[' . _MI_EV_MENULINK_DOWN . ']';
        }

        echo "<tr>
			<td class='$class'>" . $row['title'] . "</td>
			<td class='$class' align='center'>$status</td>
			<td class='$class'>" . $row['link'] . "</td>
			<td class='$class' align='center'><small><a href='menulink.php?op=del&id=" . $row['id'] . "'>[" . _DELETE . "]</a>
			<a href='menulink.php?op=edit&id=" . $row['id'] . "'>[" . _EDIT . ']</a>' . $moveup . $movedown . '</small></td></tr>';

        $class = ('odd' == $class) ? 'even' : 'odd';
    }

    echo "<tr><td class='foot' colspan='4' align='right'>
	<input type='submit' name='submit' value='" . _MI_EV_MENULINK_NEW . "'>
	</td></tr></table></form>";

    xoops_cp_footer();
}

function im_admin_clean()
{
    global $xoopsDB;

    $i = 0;

    $result = $xoopsDB->query('SELECT id FROM ' . $xoopsDB->prefix('ev_menulink') . ' ORDER BY weight ASC');

    while (list($id) = $xoopsDB->fetchRow($result)) {
        $xoopsDB->queryF('UPDATE ' . $xoopsDB->prefix('ev_menulink') . " SET weight='$i' WHERE id=$id");

        $i++;
    }
}
