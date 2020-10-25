<?php

function a_menulink_show($options)
{
    global $xoopsDB, $xoopsUser, $myts;

    $myts = MyTextSanitizer::getInstance();

    $block = [];

    $group = is_object($xoopsUser) ? $xoopsUser->getGroups() : [XOOPS_GROUP_ANONYMOUS];

    $result = $xoopsDB->query('SELECT groups, link, title, target FROM ' . $xoopsDB->prefix('xent_cr_menulink') . ' WHERE hide=0 ORDER BY weight ASC');

    while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
        $title = htmlspecialchars($myrow['title'], ENT_QUOTES | ENT_HTML5);

        if (!XOOPS_USE_MULTIBYTES) {
            /*if (strlen($myrow['title']) >= $options[0]) {
                $title = htmlspecialchars(substr($myrow['title'],0,($options[0]-1)))."...";
            }*/
        }

        $groups = explode(' ', $myrow['groups']);

        if (count(array_intersect($group, $groups)) > 0) {
            $imenu['title'] = $title;

            $imenu['target'] = $myrow['target'];

            $imenu['link'] = $myrow['link'];

            if (eregi("^\[([a-z0-9]+)\]$", $myrow['link'], $moduledir)) {
                $moduleHandler = xoops_getHandler('module');

                $module = $moduleHandler->getByDirname($moduledir[1]);

                if (is_object($module) && $module->getVar('isactive')) {
                    $imenu['link'] = XOOPS_URL . '/modules/' . $moduledir[1];
                }
            }

            // Hack by marcan - Possibility to pu a special link for special language

            $imenu['link'] = htmlspecialchars($imenu['link'], ENT_QUOTES | ENT_HTML5);

            // End of hack by marcan

            $block['contents'][] = $imenu;
        }
    }

    return $block;
}

function a_menulink_edit($options)
{
    $form = _BM_XENT_CR_MENULINK_CHARS . "&nbsp;<input type='text' name='options[]' value='" . $options[0] . "'>&nbsp;" . _BM_XENT_CR_MENULINK_LENGTH . '';

    return $form;
}
