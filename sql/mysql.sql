# phpMyAdmin SQL Dump
# version 2.5.3
# http://www.phpmyadmin.net
#
# Serveur: localhost
# Généré le : Mardi 20 Avril 2004 à 13:35
# Version du serveur: 4.0.15
# Version de PHP: 4.3.3
# 
# Base de données: `xoopsdev`
# 

# --------------------------------------------------------

#
# Structure de la table `ev_job`
#

CREATE TABLE `ev_job` (
    `id_job`       INT(5)  NOT NULL AUTO_INCREMENT,
    `id_titre`     INT(5)  NOT NULL DEFAULT '0',
    `id_typeposte` INT(5)  NOT NULL DEFAULT '0',
    `id_locations` INT(5)  NOT NULL DEFAULT '0',
    `posted_date`  INT(11) NOT NULL DEFAULT '0',
    `start_date`   INT(11) NOT NULL DEFAULT '0',
    `end_date`     INT(11) NOT NULL DEFAULT '0',
    `id_status`    INT(5)  NOT NULL DEFAULT '0',
    `description`  TEXT    NOT NULL,
    KEY `id_job` (`id_job`)
)
    ENGINE = ISAM;

#
# Contenu de la table `ev_job`
#


# --------------------------------------------------------

#
# Structure de la table `ev_locations`
#

CREATE TABLE `ev_locations` (
    `id_locations` INT(5)       NOT NULL AUTO_INCREMENT,
    `locations`    VARCHAR(255) NOT NULL DEFAULT '',
    KEY `ev_id_locations` (`id_locations`)
)
    ENGINE = ISAM
    AUTO_INCREMENT = 2;

#
# Contenu de la table `ev_locations`
#

INSERT INTO `ev_locations`
VALUES (1, 'Montreal, Qc');

# --------------------------------------------------------

#
# Structure de la table `ev_status`
#

CREATE TABLE `ev_status` (
    `id_status` INT(5)       NOT NULL AUTO_INCREMENT,
    `status`    VARCHAR(255) NOT NULL DEFAULT '',
    KEY `id_status` (`id_status`)
)
    ENGINE = ISAM;

#
# Contenu de la table `ev_status`
#

INSERT INTO `ev_status`
VALUES (1, 'Ouvert');
INSERT INTO `ev_status`
VALUES (2, 'Fermer');
INSERT INTO `ev_status`
VALUES (3, 'Occuper');

# --------------------------------------------------------

#
# Structure de la table `ev_titres`
#
CREATE TABLE `xoops_ev_titres` (
    `id_titres`   INT(5)       NOT NULL AUTO_INCREMENT,
    `titres`      VARCHAR(255) NOT NULL DEFAULT '',
    `description` TEXT         NOT NULL,
    KEY `id_titres` (`id_titres`)
)
    ENGINE = ISAM;

#
# Contenu de la table `ev_titres`
#

# --------------------------------------------------------

#
# Structure de la table `ev_typeposte`
#

CREATE TABLE `ev_typeposte` (
    `id_typeposte` INT(5)       NOT NULL AUTO_INCREMENT,
    `typeposte`    VARCHAR(255) NOT NULL DEFAULT '',
    KEY `id_status` (`id_typeposte`)
)
    ENGINE = ISAM
    AUTO_INCREMENT = 6;

#
# Contenu de la table `ev_typeposte`
#

INSERT INTO `ev_typeposte`
VALUES (1, 'Permanent');
INSERT INTO `ev_typeposte`
VALUES (2, 'Temporaire');
INSERT INTO `ev_typeposte`
VALUES (3, 'Temps partielles');
INSERT INTO `ev_typeposte`
VALUES (4, 'À contrats');
INSERT INTO `ev_typeposte`
VALUES (5, 'Consultant');


# --------------------------------------------------------


#
# Structure de la table `ev_quote`
#

CREATE TABLE `ev_quote` (
    `id`               INT(11)      NOT NULL AUTO_INCREMENT,
    `quote_nom`        VARCHAR(255) NOT NULL DEFAULT '',
    `quote_pict`       VARCHAR(255) NOT NULL DEFAULT '',
    `quote_titreposte` INT(5)       NOT NULL DEFAULT '0',
    `quote_typeposte`  INT(5)       NOT NULL DEFAULT '0',
    `quote_location`   INT(5)       NOT NULL DEFAULT '0',
    `quote_experience` VARCHAR(255) NOT NULL DEFAULT '',
    `quote_quotetitle` TEXT         NOT NULL,
    `citation`         TEXT         NOT NULL,
    PRIMARY KEY (`id`),
    KEY `id` (`id`)
)
    ENGINE = ISAM
    AUTO_INCREMENT = 1;

#
# Contenu de la table `ev_quote`
#

CREATE TABLE ev_menulink (
    id     INT(5) UNSIGNED     NOT NULL AUTO_INCREMENT,
    title  VARCHAR(150)        NOT NULL DEFAULT '',
    hide   TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
    link   VARCHAR(255)                 DEFAULT NULL,
    weight TINYINT(4) UNSIGNED NOT NULL DEFAULT '0',
    target VARCHAR(10)                  DEFAULT NULL,
    groups VARCHAR(255)                 DEFAULT NULL,
    PRIMARY KEY (id)
)
    ENGINE = ISAM;

#
# Table structure for table `ev_jobform_forms`
#
CREATE TABLE `ev_jobform_forms` (
    `form_id`            SMALLINT(5)  NOT NULL AUTO_INCREMENT,
    `form_send_method`   CHAR(1)      NOT NULL DEFAULT 'e',
    `form_send_to_group` SMALLINT(3)  NOT NULL DEFAULT '0',
    `form_order`         SMALLINT(3)  NOT NULL DEFAULT '0',
    `form_delimiter`     CHAR(1)      NOT NULL DEFAULT 's',
    `form_title`         VARCHAR(255) NOT NULL DEFAULT '',
    `form_submit_text`   VARCHAR(50)  NOT NULL DEFAULT '',
    `form_desc`          TEXT         NOT NULL,
    `form_intro`         TEXT         NOT NULL,
    `form_whereto`       VARCHAR(255) NOT NULL DEFAULT '',
    PRIMARY KEY (`form_id`),
    KEY `form_order` (`form_order`)
)
    ENGINE = ISAM;

#
# Dumping data for table `ev_jobform_forms`
#
INSERT INTO `ev_jobform_forms`
VALUES (1, 'e', 0, 1, 'b', 'Send feedback', 'Submit', 'Tell us about your comments for this site.', 'Contact us by filling out this form.', '');

#
# Table structure for table `ev_jobform_formelements`
#
CREATE TABLE `ev_jobform_formelements` (
    `ele_id`      SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    `form_id`     SMALLINT(5)          NOT NULL DEFAULT '0',
    `ele_type`    VARCHAR(10)          NOT NULL DEFAULT '',
    `ele_caption` VARCHAR(255)         NOT NULL DEFAULT '',
    `ele_order`   SMALLINT(2)          NOT NULL DEFAULT '0',
    `ele_req`     TINYINT(1)           NOT NULL DEFAULT '1',
    `ele_value`   TEXT                 NOT NULL,
    `ele_display` TINYINT(1)           NOT NULL DEFAULT '1',
    PRIMARY KEY (`ele_id`),
    KEY `ele_display` (`ele_display`),
    KEY `ele_order` (`ele_order`)
)
    ENGINE = ISAM;

#
# Dumping data for table `ev_jobform_formelements`
#
INSERT INTO `ev_jobform_formelements`
VALUES (1, 1, 'checkbox', 'What are your hobbies?', 11, 1,
        'a:7:{s:13:"I\'m a dreary.";i:1;s:35:"Searching adult contents on the net";i:0;s:66:"Arguing with people about those stupid things on discussion boards";i:0;s:33:"Searching software serial numbers";i:0;s:6:"Speech";i:0;s:34:"Making weapons of mass destruction";i:0;s:10:"{OTHER|30}";i:0;}',
        1);
INSERT INTO `ev_jobform_formelements`
VALUES (2, 1, 'text', 'Your name', 0, 1, 'a:3:{i:0;i:30;i:1;i:255;i:2;s:7:"{UNAME}";}', 1);
INSERT INTO `ev_jobform_formelements`
VALUES (3, 1, 'text', 'Email', 1, 1, 'a:3:{i:0;i:30;i:1;i:255;i:2;s:7:"{EMAIL}";}', 1);
INSERT INTO `ev_jobform_formelements`
VALUES (4, 1, 'text', 'Website', 3, 0, 'a:3:{i:0;i:30;i:1;i:255;i:2;s:7:"http://";}', 1);
INSERT INTO `ev_jobform_formelements`
VALUES (5, 1, 'text', 'Company', 4, 0, 'a:3:{i:0;i:30;i:1;i:255;i:2;s:0:"";}', 1);
INSERT INTO `ev_jobform_formelements`
VALUES (6, 1, 'text', 'Location', 5, 0, 'a:3:{i:0;i:30;i:1;i:255;i:2;s:0:"";}', 1);
INSERT INTO `ev_jobform_formelements`
VALUES (7, 1, 'textarea', 'Comments', 6, 1, 'a:3:{i:0;s:0:"";i:1;i:5;i:2;i:35;}', 1);
INSERT INTO `ev_jobform_formelements`
VALUES (8, 1, 'select', 'How are you today?', 7, 0, 'a:3:{i:0;i:1;i:1;i:0;i:2;a:6:{s:6:"Great!";i:0;s:9:"I\'m fine.";i:1;s:6:"So so.";i:0;s:8:"No good.";i:0;s:9:"I\'m sick.";i:0;s:5:"What?";i:0;}}', 1);
INSERT INTO `ev_jobform_formelements`
VALUES (9, 1, 'text', 'Your credit card number', 14, 0, 'a:3:{i:0;i:30;i:1;i:255;i:2;s:15:"Are you crazy!?";}', 1);
INSERT INTO `ev_jobform_formelements`
VALUES (10, 1, 'radio', 'How old are you?', 9, 0, 'a:8:{s:3:"0-9";i:0;s:5:"10-19";i:0;s:5:"20-29";i:0;s:5:"30-39";i:0;s:5:"40-49";i:0;s:5:"50-59";i:0;s:3:"60+";i:0;s:27:"It\'s none of your business.";i:1;}', 1);
INSERT INTO `ev_jobform_formelements`
VALUES (11, 1, 'checkbox', 'foo', 13, 0, 'a:1:{s:3:"bar";i:0;}', 0);
INSERT INTO `ev_jobform_formelements`
VALUES (12, 1, 'select', 'Why did you buy a computer?', 8, 1, 'a:3:{i:0;i:10;i:1;i:1;i:2;a:6:{s:25:"My room is too big for me";i:1;s:25:"I don\'t have a girlfriend";i:0;s:18:"My wife is a biddy";i:0;s:17:"I like spam mails";i:0;s:29:"That makes me look more smart";i:0;s:13:"I just forgot";i:0;}}',
        1);
INSERT INTO `ev_jobform_formelements`
VALUES (13, 1, 'radio', 'Gender', 2, 0, 'a:3:{s:4:"Male";i:0;s:6:"Female";i:0;s:15:"I won\'t tell ya";i:1;}', 1);
INSERT INTO `ev_jobform_formelements`
VALUES (14, 1, 'yn', 'Do you believe your government?', 12, 0, 'a:2:{s:4:"_YES";i:1;s:3:"_NO";i:0;}', 1);
INSERT INTO `ev_jobform_formelements`
VALUES (15, 1, 'html', '', 10, 0,
        'a:3:{i:0;s:316:"I have no idea what should be placed here. Maybe a chapter from the holy bible? [url=http://www.randomwebsearch.com/cgi-bin/randomWebSearch.pl?mode=generate]Click here[/url] if you have too much time to waste, or [url=http://www.landoverbaptist.org/news0104/ps2.html]get a free PlayStation 2[/url] if you are boring.";i:1;i:10;i:2;i:50;}',
        1);


