-- phpMyAdmin SQL Dump
-- version 2.9.1.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost:3833
-- Generation Time: Jan 19, 2007 at 05:33 PM
-- Server version: 4.1.15
-- PHP Version: 5.1.6
-- 
-- Database: `cyrilca_tennis`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `doubles`
-- 

DROP TABLE IF EXISTS `doubles`;
CREATE TABLE IF NOT EXISTS `doubles` (
  `id` int(10) unsigned NOT NULL default '0' COMMENT 'foreign key to player.id',
  `player1_id` int(10) unsigned NOT NULL default '0',
  `player2_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `doubles`
-- 

INSERT INTO `doubles` (`id`, `player1_id`, `player2_id`) VALUES 
(32, 3, 13),
(30, 1, 10),
(33, 2, 13),
(34, 1, 14);

-- --------------------------------------------------------

-- 
-- Table structure for table `draws`
-- 

DROP TABLE IF EXISTS `draws`;
CREATE TABLE IF NOT EXISTS `draws` (
  `event_id` int(10) unsigned NOT NULL default '0',
  `player_id` int(10) unsigned NOT NULL default '0',
  `slot` int(11) NOT NULL default '0',
  `seed` int(11) default NULL,
  PRIMARY KEY  (`player_id`,`event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `draws`
-- 

INSERT INTO `draws` (`event_id`, `player_id`, `slot`, `seed`) VALUES 
(6, 1, 0, NULL),
(11, 1, 0, NULL),
(12, 1, 0, NULL),
(13, 1, 0, NULL),
(6, 2, 0, NULL),
(12, 2, 0, NULL),
(6, 3, 0, NULL),
(11, 3, 0, NULL),
(12, 3, 0, NULL),
(13, 3, 0, NULL),
(6, 7, 0, NULL),
(11, 9, 0, NULL),
(12, 16, 0, NULL),
(11, 17, 0, NULL),
(13, 20, 0, NULL),
(13, 21, 0, NULL),
(10, 30, 0, NULL),
(10, 32, 0, NULL),
(1, 1, 0, NULL),
(1, 21, 0, NULL),
(1, 11, 0, NULL),
(1, 3, 0, NULL),
(1, 7, 0, NULL),
(1, 13, 0, NULL),
(15, 21, 1, 1),
(15, 35, 2, NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `events`
-- 

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `type` enum('robin','tree','log') NOT NULL default 'robin',
  `tour_id` int(10) unsigned NOT NULL default '0',
  `title` varchar(40) NOT NULL default '',
  `starts` date NOT NULL default '0000-00-00',
  `ends` date NOT NULL default '0000-00-00',
  `fee` int(11) default '0',
  `winner_id` int(10) unsigned default NULL,
  `note` varchar(100) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- 
-- Dumping data for table `events`
-- 

INSERT INTO `events` (`id`, `type`, `tour_id`, `title`, `starts`, `ends`, `fee`, `winner_id`, `note`) VALUES 
(11, 'robin', 1, 'QuadRobin 2', '2004-05-01', '2004-05-01', 5, 1, 'Starts at 12:30 Indoor'),
(12, 'robin', 1, 'QuadRobin 3', '2004-05-29', '2004-05-29', 5, 2, ''),
(6, 'robin', 1, 'QuadRobin 1', '2004-04-24', '2004-04-24', 5, 3, 'Hail  Azril, great play !'),
(10, 'log', 2, 'Lord of the Brink', '0000-00-00', '0000-00-00', 0, NULL, NULL),
(13, 'robin', 1, 'QuadRobin 4', '2004-11-13', '2004-11-13', 5, 20, NULL),
(1, 'log', 1, 'General Log', '2005-11-01', '0000-00-00', 0, NULL, 'logs matches w/o particular event'),
(15, 'tree', 1, 'Man A Indoor 2006', '2006-05-15', '2007-05-05', 0, NULL, NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `matches`
-- 

DROP TABLE IF EXISTS `matches`;
CREATE TABLE IF NOT EXISTS `matches` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tour_id` int(10) unsigned NOT NULL default '0',
  `event_id` int(10) unsigned NOT NULL default '0',
  `player1_id` int(10) unsigned NOT NULL default '0',
  `player2_id` int(10) unsigned NOT NULL default '0',
  `winner_id` int(10) unsigned default NULL,
  `score` varchar(30) default NULL,
  `status` enum('scheduled','complete','due','void') NOT NULL default 'due',
  `date` datetime default '0000-00-00 00:00:00',
  `reporter_id` int(10) unsigned default NULL,
  `note` varchar(200) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=73 ;

-- 
-- Dumping data for table `matches`
-- 

INSERT INTO `matches` (`id`, `tour_id`, `event_id`, `player1_id`, `player2_id`, `winner_id`, `score`, `status`, `date`, `reporter_id`, `note`) VALUES 
(17, 2, 10, 30, 32, 32, '2:6 5:7', 'complete', '2004-02-17 20:00:00', 1, 'We''re on right track'),
(16, 2, 10, 30, 32, 32, '3:6 1:6', 'complete', '2004-02-06 12:00:00', 1, 'Azril: I''m alive&kicking !'),
(9, 2, 10, 30, 32, 32, '6:2 7:5', 'complete', '2003-11-18 20:00:00', 1, NULL),
(10, 2, 10, 30, 32, 32, '6:2 6:2', 'complete', '2003-11-25 20:00:00', 1, 'just wait !'),
(11, 2, 10, 30, 32, 32, '6:4 7:5', 'complete', '2003-12-02 20:00:00', 1, 'it''s getting close'),
(12, 2, 10, 30, 32, 30, '6:4 6:1', 'complete', '2003-12-09 20:00:00', 1, 'Hail Karina !'),
(13, 2, 10, 30, 32, 30, '4:6 3:4', 'complete', '2004-01-13 20:00:00', 1, 'voided due to Gail''s injury'),
(14, 2, 10, 30, 32, 30, '7:5 6:3', 'complete', '2004-01-20 20:00:00', 1, 'Karina rocks !'),
(18, 2, 10, 30, 32, 32, '6:2 6:3', 'complete', '2004-03-15 08:00:00', 1, NULL),
(20, 1, 6, 1, 2, 1, '6:2', 'complete', '2004-04-24 16:30:00', 1, NULL),
(21, 1, 6, 1, 3, 3, '3:2', 'complete', '2004-04-24 16:30:00', 1, 'court timeout'),
(22, 1, 6, 1, 7, 1, '7:6 (7:5)', 'complete', '2004-04-24 16:30:00', 1, 'great match'),
(23, 1, 6, 2, 3, 3, '6:1', 'complete', '2004-04-24 16:30:00', 1, NULL),
(24, 1, 6, 3, 7, 3, '6:1', 'complete', '2004-04-24 16:30:00', 1, NULL),
(25, 1, 6, 2, 7, 2, '3:1', 'complete', '2004-04-24 16:30:00', 1, 'court timeout'),
(26, 1, 11, 1, 17, 1, '6:3', 'complete', '2004-05-15 12:30:00', 1, NULL),
(27, 1, 11, 1, 3, 1, '6:3', 'complete', '2004-05-15 12:30:00', 1, NULL),
(28, 1, 11, 1, 9, 9, '2:0 retired', 'complete', '2004-05-15 12:30:00', 1, ''),
(29, 1, 11, 17, 9, 17, '6:5(7:3)', 'complete', '2004-05-15 12:30:00', 1, 'tiebreak played at 5:5'),
(30, 1, 11, 17, 3, 3, '6:2', 'complete', '2004-05-15 12:30:00', 1, NULL),
(31, 1, 11, 3, 9, 3, '6:4', 'complete', '2004-05-15 12:30:00', 1, NULL),
(32, 1, 12, 1, 2, 2, '6:4', 'complete', '2004-05-29 14:30:00', 1, NULL),
(34, 1, 12, 1, 16, 16, '7:6(7:5)', 'complete', '2004-05-29 14:30:00', 1, NULL),
(35, 1, 12, 2, 16, 2, '6:2', 'complete', '2004-05-29 14:30:00', 1, NULL),
(36, 1, 12, 2, 3, 2, '7:6(7:2)', 'complete', '2004-05-29 14:30:00', 1, NULL),
(37, 1, 12, 3, 16, 3, '???', 'complete', '2004-05-29 14:30:00', 1, 'Score unknown'),
(38, 1, 12, 1, 3, NULL, NULL, 'void', '2004-05-29 14:30:00', 1, 'Azril got sore ahilles , dead rubber match anyway'),
(39, 2, 10, 30, 32, 30, '6:1 6:3', 'complete', '2004-06-15 00:00:00', 1, 'Club championship'),
(42, 1, 13, 1, 3, 3, '4:6', 'complete', '2004-11-13 16:30:00', 1, NULL),
(43, 1, 13, 1, 20, 20, '4.6', 'complete', '2004-11-13 16:30:00', 1, NULL),
(44, 1, 13, 1, 21, 1, '7:5', 'complete', '2004-11-13 16:30:00', 1, NULL),
(45, 1, 13, 3, 20, 20, '4:6', 'complete', '2004-11-13 16:30:00', 1, NULL),
(46, 1, 13, 3, 21, 3, '6:4', 'complete', '2004-11-13 16:30:00', NULL, NULL),
(47, 1, 13, 20, 21, 21, '2:6', 'complete', '2004-11-13 16:30:00', NULL, NULL),
(52, 1, 1, 1, 21, 21, '3:6 4:6', 'complete', '2005-11-19 00:00:00', 1, NULL),
(53, 1, 1, 1, 21, NULL, '6:3 3:6', 'void', '2005-11-12 00:00:00', 1, 'draw'),
(54, 1, 1, 1, 3, NULL, '6:3 2:4', 'void', '2005-11-17 00:00:00', 1, 'Draw.'),
(55, 1, 1, 1, 7, 1, '6:3 6:4', 'complete', '2005-11-20 00:00:00', 1, NULL),
(56, 1, 1, 1, 11, NULL, '6:3 3:6', 'void', '2005-11-18 19:30:00', 1, 'draw'),
(57, 1, 1, 1, 13, 1, '6:4', 'complete', '2005-11-14 00:00:00', 1, 'Gail had handicap 30:0 every game'),
(58, 1, 1, 1, 13, 13, '3:6', 'complete', '2005-11-07 00:00:00', 1, NULL),
(59, 1, 1, 1, 13, NULL, '1:6 6:1', 'void', '2005-11-21 00:00:00', 1, 'draw'),
(60, 1, 1, 3, 13, NULL, NULL, 'scheduled', '2005-11-26 15:30:00', NULL, NULL),
(61, 1, 1, 1, 21, NULL, '6:4 1:6', 'void', '2005-11-26 16:30:00', 1, 'draw'),
(63, 1, 1, 1, 13, 1, '2:6', 'complete', '2005-11-28 21:00:00', 1, NULL),
(64, 1, 1, 22, 2, 22, '0:6 6:3 6:1', 'complete', '2006-02-25 19:30:00', 22, NULL),
(65, 1, 1, 22, 2, 22, '6:4 6:3', 'complete', '2006-03-11 00:00:00', 22, NULL),
(66, 1, 1, 22, 2, 2, '6:0 6:2', 'complete', '2006-04-22 00:00:00', 22, NULL),
(67, 1, 1, 1, 21, 21, '6:3 3:3', 'complete', '2006-05-04 19:30:00', 1, NULL),
(68, 1, 1, 1, 21, 21, '6:7  (8:10)', 'complete', '2006-05-20 00:00:00', 1, NULL),
(69, 1, 15, 1, 3, 1, '6:4 6:1', 'complete', '2006-05-17 18:30:00', 1, NULL),
(70, 1, 1, 1, 21, 21, '6:7 4:6', 'complete', '2006-06-07 19:30:00', NULL, NULL),
(71, 1, 1, 1, 21, 21, '6:2 6:2', 'complete', '2006-06-21 20:00:00', 1, NULL),
(72, 1, 1, 1, 11, 1, '7:6(11:9) 1:6  10:8', 'complete', '2006-06-20 19:30:00', 1, NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `players`
-- 

DROP TABLE IF EXISTS `players`;
CREATE TABLE IF NOT EXISTS `players` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `type` enum('doubles','singles') NOT NULL default 'singles',
  `firstname` varchar(20) NOT NULL default '',
  `lastname` varchar(20) NOT NULL default '',
  `phone_w` varchar(15) default NULL,
  `phone_m` varchar(10) default NULL,
  `phone_h` varchar(10) default NULL,
  `email1` varchar(30) default NULL,
  `email2` varchar(30) default NULL,
  `sex` enum('men','ladies','boys','girls','mixed') NOT NULL default 'men',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `firstname` (`firstname`,`lastname`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

-- 
-- Dumping data for table `players`
-- 

INSERT INTO `players` (`id`, `type`, `firstname`, `lastname`, `phone_w`, `phone_m`, `phone_h`, `email1`, `email2`, `sex`) VALUES 
(1, 'singles', 'Eugene', 'Kirillov', '9054132683', '4164197792', '9057618655', 'cyrilcanada@yahoo.com', 'eugene@cyrilcanada.com', 'men'),
(2, 'singles', 'Yuri', 'Kotik', NULL, '4164520755', '9055088774', 'yuri.kotik@rbc.com', NULL, 'men'),
(3, 'singles', 'Azril', 'Rom', '4167890602x229', '9058815565', '4164537691', 'arom@dominionroofing.com', 'romfamily@rogers.com', 'men'),
(4, 'singles', 'Garry', 'Shapp', NULL, NULL, NULL, NULL, NULL, 'men'),
(6, 'singles', 'Max', 'Baer', NULL, NULL, NULL, 'max@bagdesigns.com', NULL, 'men'),
(7, 'singles', 'Rajeev', 'Bhargava', NULL, NULL, NULL, 'rajeev.bhargava@nmiinc.com', NULL, 'men'),
(9, 'singles', 'Fred', 'Rozen', NULL, '4167074171', NULL, NULL, NULL, 'men'),
(30, 'doubles', 'Avramenko', 'Kirillov', NULL, NULL, NULL, NULL, NULL, 'men'),
(13, 'singles', 'Gail', 'Brener', NULL, NULL, NULL, NULL, NULL, 'ladies'),
(32, 'doubles', 'Brener', 'Rom', NULL, NULL, NULL, NULL, NULL, 'mixed'),
(16, 'singles', 'Lauren', 'Kruger', '4167458518', NULL, '9057372700', 'lorenkruger@rogers.com', NULL, 'men'),
(17, 'singles', 'Sheldon', 'Warner', '9056783301x233', NULL, NULL, 'swarner@datamark.ca', NULL, 'men'),
(20, 'singles', 'John', 'Sailes', NULL, NULL, NULL, 'jsailesgel@sympatico.ca', NULL, 'men'),
(21, 'singles', 'Rizwan', 'Khalfan', NULL, NULL, NULL, NULL, NULL, 'men'),
(11, 'singles', 'Kirill', 'Nagorny', NULL, NULL, NULL, NULL, NULL, 'men'),
(22, 'singles', 'Pavel', 'Pavlenko', NULL, '', NULL, 'info@annunicare.com', NULL, 'men'),
(35, 'singles', 'Stieve', 'Kirk', NULL, NULL, NULL, NULL, NULL, 'men');

-- --------------------------------------------------------

-- 
-- Table structure for table `roster`
-- 

DROP TABLE IF EXISTS `roster`;
CREATE TABLE IF NOT EXISTS `roster` (
  `tour_id` int(10) unsigned NOT NULL default '0',
  `player_id` int(10) unsigned NOT NULL default '0',
  `handicap` int(10) unsigned zerofill default NULL,
  PRIMARY KEY  (`player_id`,`tour_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `roster`
-- 

INSERT INTO `roster` (`tour_id`, `player_id`, `handicap`) VALUES 
(1, 1, NULL),
(1, 2, NULL),
(1, 17, NULL),
(1, 3, NULL),
(1, 7, NULL),
(1, 9, NULL),
(2, 30, NULL),
(2, 32, NULL),
(1, 20, NULL),
(1, 21, NULL),
(1, 22, NULL),
(1, 16, NULL),
(1, 13, NULL),
(1, 11, NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `tours`
-- 

DROP TABLE IF EXISTS `tours`;
CREATE TABLE IF NOT EXISTS `tours` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(20) NOT NULL default '',
  `description` varchar(30) default NULL,
  `location` varchar(20) NOT NULL default '',
  `email` varchar(30) default NULL,
  `sex` enum('men','ladies','mixed','boys','girls') NOT NULL default 'men',
  `type` enum('doubles','singles') NOT NULL default 'singles',
  `level` enum('A','B','C','35+','45+','55+','OPEN') NOT NULL default 'A',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- 
-- Dumping data for table `tours`
-- 

INSERT INTO `tours` (`id`, `title`, `description`, `location`, `email`, `sex`, `type`, `level`) VALUES 
(1, 'Men A', 'Singles, Men  4.5', 'RHCC', 'eugene@cyrilcanada.com', 'men', 'singles', 'A'),
(2, 'Mixed A', 'Doubles,Mixed , 4.0+', 'RHCC', 'eugene@cyrilcanada.com', 'mixed', 'doubles', 'A'),
(3, 'Men B', 'Singles,Men  4.0', 'RHCC', NULL, 'men', 'singles', 'B'),
(4, 'Ladies B', 'Singles,Ladies, 4.0+', 'RHCC', NULL, 'ladies', 'singles', 'B'),
(5, 'Men Doubles A', 'Doubles,Men, 4.5', 'RHCC', NULL, 'men', 'doubles', 'A'),
(6, 'Men Doubles B', 'Doubles,Men,4.0', 'RHCC', NULL, 'men', 'doubles', 'B'),
(7, 'Men Seniors', 'Men Seniors', 'RHCC', NULL, 'men', 'singles', '55+'),
(8, 'Men Open Pro', 'Singles,Open with Prizes', 'RHCC', NULL, 'men', 'singles', 'A');

-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `login` varchar(30) NOT NULL default '',
  `password` varchar(64) default '',
  `privilege` enum('developer','admin','member','guest') NOT NULL default 'guest',
  PRIMARY KEY  (`login`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `users`
-- 

INSERT INTO `users` (`login`, `password`, `privilege`) VALUES 
('eugene@cyrilcanada.com', '*A80082C9E4BB16D9C8E41B0D7EED46126DF4A46E', 'member'),
('dev', '2c20d5bd6ff371fc', 'developer'),
('admin', '*A80082C9E4BB16D9C8E41B0D7EED46126DF4A46E', 'admin'),
('cyrilcanada@yahoo.com', '*A80082C9E4BB16D9C8E41B0D7EED46126DF4A46E', 'guest');
