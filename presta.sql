# --------------------------------------------------------
# Host:                         127.0.0.1
# Server version:               5.0.45-community-nt
# Server OS:                    Win32
# HeidiSQL version:             6.0.0.3603
# Date/time:                    2011-09-23 04:50:09
# --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

# Dumping database structure for presta
CREATE DATABASE IF NOT EXISTS `presta` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_general_ci */;
USE `presta`;


# Dumping structure for table presta.department
CREATE TABLE IF NOT EXISTS `department` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL,
  `selectable` tinyint(1) NOT NULL default '0',
  `uid` int(11) NOT NULL default '0',
  `timecreated` varchar(200) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

# Dumping data for table presta.department: 29 rows
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` (`id`, `parent_id`, `name`, `selectable`, `uid`, `timecreated`) VALUES
	(1, 0, 'Rector', 0, 3, '1220575420'),
	(2, 1, 'Corporate Services & Operations', 1, 3, '1220575463'),
	(3, 1, 'Academic Affairs', 1, 3, '1220575499'),
	(4, 1, 'Learning Centre & Student Services', 1, 3, '1220575535'),
	(5, 1, 'Chief of Technology', 1, 3, '1220575548'),
	(6, 1, 'Endowments', 1, 3, '1220575564'),
	(7, 2, 'Marketing', 1, 3, '1220575639'),
	(8, 2, 'Corporate Services', 1, 3, '1220575666'),
	(9, 2, 'Finance', 1, 3, '1220575679'),
	(10, 2, 'Human Resources', 1, 3, '1220575695'),
	(11, 2, 'Business Management Systems', 1, 3, '1220575708'),
	(12, 3, 'Islamic Sciences', 1, 3, '1220575835'),
	(13, 3, 'Languages', 1, 3, '1220575849'),
	(14, 3, 'Information Technology', 1, 3, '1220575891'),
	(15, 3, 'Finance & Administrative Science', 1, 3, '1220575914'),
	(16, 3, 'Post Graduate Studies', 1, 3, '1220575929'),
	(17, 3, 'Corporate Training', 1, 3, '1220575944'),
	(18, 3, 'Prepatory Studies', 1, 3, '1220576095'),
	(19, 3, 'Education', 1, 3, '1220576107'),
	(20, 4, 'Student Services', 1, 3, '1220576135'),
	(21, 4, 'Learning Centres', 1, 3, '1220576154'),
	(22, 4, 'Registry', 1, 3, '1220576208'),
	(23, 20, 'Student Activities, Counseling & Discipline', 1, 3, '1220581892'),
	(24, 20, 'Student Welfare & Advocacy', 1, 3, '1220581933'),
	(25, 20, 'Alumni & Career Services', 1, 3, '1220581951'),
	(26, 20, 'Student Financial Aid', 1, 3, '1220581971'),
	(27, 5, 'Instructional Systems Design Technology', 1, 3, '1220582003'),
	(28, 5, 'Systems Development', 1, 3, '1220582037'),
	(29, 5, 'Network, Security & Server Operations', 1, 3, '1220582081');
/*!40000 ALTER TABLE `department` ENABLE KEYS */;


# Dumping structure for table presta.department_user_kpi
CREATE TABLE IF NOT EXISTS `department_user_kpi` (
  `id` int(11) NOT NULL auto_increment,
  `dept_id` int(11) unsigned NOT NULL,
  `uid` int(11) unsigned NOT NULL,
  `name` varchar(150) NOT NULL,
  `type` varchar(50) NOT NULL,
  `timeframe` int(11) NOT NULL,
  `timecreated` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

# Dumping data for table presta.department_user_kpi: 16 rows
/*!40000 ALTER TABLE `department_user_kpi` DISABLE KEYS */;
INSERT INTO `department_user_kpi` (`id`, `dept_id`, `uid`, `name`, `type`, `timeframe`, `timecreated`) VALUES
	(1, 0, 0, '', 'scorecard', 1220616480, 1220575408),
	(2, 28, 0, '', 'kpi', 1220616480, 1220582247),
	(3, 0, 14, '', 'kpi', 1220616480, 1220584644),
	(4, 5, 0, '', 'kpi', 1220616480, 1220584978),
	(5, 27, 0, '', 'kpi', 1220616480, 1220586800),
	(6, 0, 13, '', 'kpi', 1220616480, 1220595903),
	(7, 0, 16, '', 'kpi', 1220616480, 1220596496),
	(8, 1, 0, '', 'kpi', 1220616480, 1220597285),
	(9, 0, 3, '', 'kpi', 1220616480, 1220597291),
	(10, 2, 0, '', 'kpi', 1221480480, 1221451222),
	(11, 1, 0, '', 'scorecard', 1277640600, 1277627527),
	(12, 23, 0, '', 'kpi', 1277640600, 1277627553),
	(13, 1, 0, '', 'scorecard', 1316718660, 1316712090),
	(14, 3, 0, '', 'kpi', 1316718660, 1316712099),
	(15, 0, 14, '', 'kpi', 1316718660, 1316714119),
	(16, 28, 0, '', 'kpi', 1316718660, 1316715862);
/*!40000 ALTER TABLE `department_user_kpi` ENABLE KEYS */;


# Dumping structure for table presta.dialogue
CREATE TABLE IF NOT EXISTS `dialogue` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `first_quarter` text,
  `second_quarter` text,
  `third_quarter` text,
  `final_review` text,
  `final_rating` int(11) default NULL,
  `timecreated` int(11) NOT NULL,
  `timemodified` int(11) NOT NULL,
  `kpi_id` int(11) unsigned default NULL,
  `uid` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

# Dumping data for table presta.dialogue: 1 rows
/*!40000 ALTER TABLE `dialogue` DISABLE KEYS */;
INSERT INTO `dialogue` (`id`, `first_quarter`, `second_quarter`, `third_quarter`, `final_review`, `final_rating`, `timecreated`, `timemodified`, `kpi_id`, `uid`) VALUES
	(1, 'What?', NULL, NULL, NULL, NULL, 1220597125, 0, 2, 15);
/*!40000 ALTER TABLE `dialogue` ENABLE KEYS */;


# Dumping structure for table presta.group
CREATE TABLE IF NOT EXISTS `group` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `timecreated` varchar(100) default NULL,
  `uid` int(11) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

# Dumping data for table presta.group: 3 rows
/*!40000 ALTER TABLE `group` DISABLE KEYS */;
INSERT INTO `group` (`id`, `name`, `timecreated`, `uid`) VALUES
	(2, 'Supervisor', '1213089361', 0),
	(3, 'Employee', '1213089365', 0),
	(4, 'Admin', '1213111938', 0);
/*!40000 ALTER TABLE `group` ENABLE KEYS */;


# Dumping structure for table presta.initiative
CREATE TABLE IF NOT EXISTS `initiative` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `measure_id` int(11) unsigned default NULL,
  `measure_description` text,
  `action` text,
  `status` varchar(10) default NULL,
  `timecreated` int(11) NOT NULL,
  `timemodified` int(11) NOT NULL,
  `uid` int(11) unsigned default NULL,
  `kpi_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

# Dumping data for table presta.initiative: 1 rows
/*!40000 ALTER TABLE `initiative` DISABLE KEYS */;
INSERT INTO `initiative` (`id`, `measure_id`, `measure_description`, `action`, `status`, `timecreated`, `timemodified`, `uid`, `kpi_id`) VALUES
	(1, NULL, 'Conquer the world!', 'Build killer robots!', '0', 1220597967, 0, 14, 3);
/*!40000 ALTER TABLE `initiative` ENABLE KEYS */;


# Dumping structure for table presta.measure
CREATE TABLE IF NOT EXISTS `measure` (
  `id` int(11) NOT NULL auto_increment,
  `objective_id` int(11) NOT NULL default '0',
  `name` text,
  `target` text,
  `actual` text,
  `timecreated` int(11) default '0',
  `timemodified` int(11) NOT NULL,
  `uid` int(11) default '0',
  `kpi_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

# Dumping data for table presta.measure: 1 rows
/*!40000 ALTER TABLE `measure` DISABLE KEYS */;
INSERT INTO `measure` (`id`, `objective_id`, `name`, `target`, `actual`, `timecreated`, `timemodified`, `uid`, `kpi_id`) VALUES
	(1, 1, 'Support technical questions from lecturers and students', 'Major technical question 2 days and minor 1 day to reply', 'test', 1220589536, 0, 14, 3);
/*!40000 ALTER TABLE `measure` ENABLE KEYS */;


# Dumping structure for table presta.objective
CREATE TABLE IF NOT EXISTS `objective` (
  `id` int(11) NOT NULL auto_increment,
  `strategic_id` int(11) NOT NULL,
  `perspective_id` int(11) NOT NULL COMMENT 'This is Individual KPI',
  `name` text NOT NULL,
  `timecreated` int(11) default NULL,
  `timemodified` int(11) NOT NULL,
  `uid` int(11) NOT NULL default '0',
  `kpi_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

# Dumping data for table presta.objective: 1 rows
/*!40000 ALTER TABLE `objective` DISABLE KEYS */;
INSERT INTO `objective` (`id`, `strategic_id`, `perspective_id`, `name`, `timecreated`, `timemodified`, `uid`, `kpi_id`) VALUES
	(1, 1, 0, 'To design, develop and provide an excellent Learning Management System to support user driven business for students and lecturers to communicate each other and also to monitor student assessment', 1220589536, 0, 14, 3);
/*!40000 ALTER TABLE `objective` ENABLE KEYS */;


# Dumping structure for table presta.perspective
CREATE TABLE IF NOT EXISTS `perspective` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `timecreated` int(11) NOT NULL default '0',
  `timemodified` int(11) NOT NULL,
  `uid` int(11) default '0',
  `kpi_id` int(11) unsigned default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

# Dumping data for table presta.perspective: 1 rows
/*!40000 ALTER TABLE `perspective` DISABLE KEYS */;
INSERT INTO `perspective` (`id`, `name`, `timecreated`, `timemodified`, `uid`, `kpi_id`) VALUES
	(1, 'Technology', 1220589536, 0, 14, 3);
/*!40000 ALTER TABLE `perspective` ENABLE KEYS */;


# Dumping structure for table presta.position
CREATE TABLE IF NOT EXISTS `position` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL,
  `timecreated` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

# Dumping data for table presta.position: 3 rows
/*!40000 ALTER TABLE `position` DISABLE KEYS */;
INSERT INTO `position` (`id`, `name`, `uid`, `timecreated`) VALUES
	(1, 'Analyst Programmer', 3, 1216867254),
	(2, 'Solution Architect', 3, 1216868244),
	(3, 'CTO', 3, 1220584856);
/*!40000 ALTER TABLE `position` ENABLE KEYS */;


# Dumping structure for table presta.strategic
CREATE TABLE IF NOT EXISTS `strategic` (
  `id` int(11) NOT NULL auto_increment,
  `perspective_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `timecreated` int(11) default '0',
  `timemodified` int(11) NOT NULL,
  `uid` int(11) default '0',
  `kpi_id` int(11) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

# Dumping data for table presta.strategic: 1 rows
/*!40000 ALTER TABLE `strategic` DISABLE KEYS */;
INSERT INTO `strategic` (`id`, `perspective_id`, `name`, `timecreated`, `timemodified`, `uid`, `kpi_id`) VALUES
	(1, 1, 'Provide an excellent  and easy to use Learning Management System', 0, 1220589536, 14, 3);
/*!40000 ALTER TABLE `strategic` ENABLE KEYS */;


# Dumping structure for table presta.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL auto_increment,
  `department_id` int(11) NOT NULL default '0',
  `position_id` int(11) NOT NULL,
  `type` varchar(100) default NULL,
  `group_id` int(11) NOT NULL default '0',
  `fullname` varchar(255) NOT NULL,
  `employee_id` varchar(100) default NULL,
  `reports_to` int(11) NOT NULL default '0',
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `activated` tinyint(4) NOT NULL,
  `timecreated` varchar(100) default NULL,
  `uid` int(11) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

# Dumping data for table presta.user: 5 rows
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `department_id`, `position_id`, `type`, `group_id`, `fullname`, `employee_id`, `reports_to`, `username`, `password`, `activated`, `timecreated`, `uid`) VALUES
	(3, 0, 0, 'corporate', 4, 'Administrator', NULL, 0, 'admin', '5f9cd8b76d2660884c6d1bc63a986a60ef7e7792', 1, '1213090229', 0),
	(16, 27, 1, NULL, 2, 'Other HOD', '', 0, 'other_hod', '5f9cd8b76d2660884c6d1bc63a986a60ef7e7792', 1, '1220586788', 0),
	(15, 5, 3, 'individual', 2, 'Dr. CTO', '', 0, 'cto', '5f9cd8b76d2660884c6d1bc63a986a60ef7e7792', 1, '1220584886', 3),
	(14, 28, 1, 'individual', 3, 'Mohd Khairul Anuar', '', 0, 'khairul', '5f9cd8b76d2660884c6d1bc63a986a60ef7e7792', 1, '1220584627', 3),
	(13, 28, 2, 'individual', 2, 'IT Head of Department Guy', '', 0, 'it_hod', '5f9cd8b76d2660884c6d1bc63a986a60ef7e7792', 1, '1220582214', 3);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
