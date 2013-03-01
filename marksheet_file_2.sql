-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 03, 2013 at 04:33 PM
-- Server version: 5.5.28
-- PHP Version: 5.3.10-1ubuntu3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `school`
--

-- --------------------------------------------------------

--
-- Table structure for table `marksheet_blocks_exam`
--

CREATE TABLE IF NOT EXISTS `marksheet_blocks_exam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `marksheet_section_blocks_id` int(11) NOT NULL,
  `exammap_id` int(11) NOT NULL,
  `max_marks` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `marksheet_blocks_exam`
--

INSERT INTO `marksheet_blocks_exam` (`id`, `marksheet_section_blocks_id`, `exammap_id`, `max_marks`) VALUES
(1, 1, 6, 10),
(2, 1, 16, 10),
(3, 1, 22, 20),
(4, 3, 28, 50),
(5, 3, 82, 50),
(6, 4, 33, 0),
(7, 4, 85, 0),
(8, 2, 28, 0);

-- --------------------------------------------------------

--
-- Table structure for table `marksheet_designer`
--

CREATE TABLE IF NOT EXISTS `marksheet_designer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `session_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `marksheet_designer`
--

INSERT INTO `marksheet_designer` (`id`, `class_id`, `name`, `session_id`) VALUES
(1, 21, 'marksheet1', 8),
(2, 16, 'Marksheet2', 8);

-- --------------------------------------------------------

--
-- Table structure for table `marksheet_sections`
--

CREATE TABLE IF NOT EXISTS `marksheet_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `marksheet_designer_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `has_grand_total` tinyint(4) NOT NULL,
  `max_marks_for_each_subject` tinyint(4) NOT NULL,
  `grade_decider` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `marksheet_sections`
--

INSERT INTO `marksheet_sections` (`id`, `marksheet_designer_id`, `name`, `has_grand_total`, `max_marks_for_each_subject`, `grade_decider`) VALUES
(1, 1, 'Main Exam Section', 1, 1, 1),
(2, 1, 'Optional Subjects', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `marksheet_section_blocks`
--

CREATE TABLE IF NOT EXISTS `marksheet_section_blocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `marksheet_sections_id` int(11) NOT NULL,
  `is_total_required` tinyint(4) NOT NULL DEFAULT '0',
  `total_title` varchar(100) NOT NULL DEFAULT 'Total',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `marksheet_section_blocks`
--

INSERT INTO `marksheet_section_blocks` (`id`, `name`, `marksheet_sections_id`, `is_total_required`, `total_title`) VALUES
(1, 'samayik pariksha', 1, 1, 'sTotal'),
(2, 'ardhvarshik', 2, 1, 'Total'),
(3, 'Ardhvarshik Pariksha', 1, 1, 'aTotal'),
(4, 'Varshik Pariksha', 1, 1, 'vTotal');

-- --------------------------------------------------------

--
-- Table structure for table `marksheet_section_subjects`
--

CREATE TABLE IF NOT EXISTS `marksheet_section_subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `marksheet_section_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `marksheet_section_subjects`
--

INSERT INTO `marksheet_section_subjects` (`id`, `marksheet_section_id`, `subject_id`, `session_id`) VALUES
(3, 2, 14, 8),
(4, 2, 15, 8),
(8, 1, 5, 8),
(9, 1, 6, 8),
(10, 1, 7, 8),
(11, 1, 8, 8),
(12, 1, 9, 8),
(13, 1, 10, 8);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;