-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2019 at 01:42 PM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_cifirecms`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_album`
--
DROP TABLE IF EXISTS `t_album`;
CREATE TABLE `t_album` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `seotitle` varchar(200) NOT NULL,
  `active` enum('Y','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_album`
--
INSERT INTO `t_album` (`id`, `title`, `seotitle`, `active`) VALUES
(1, 'Nature', '20190527034902809554383216', 'Y'),
(2, 'Vintage', '20190527034958457628159932', 'Y');
-- --------------------------------------------------------

--
-- Table structure for table `t_category`
--
DROP TABLE IF EXISTS `t_category`;
CREATE TABLE `t_category` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `id_parent` int(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `seotitle` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `picture` text NOT NULL,
  `active` enum('Y','N') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_category`
--

INSERT INTO `t_category` (`id`, `id_parent`, `title`, `seotitle`, `description`, `picture`, `active`) VALUES
(1, 0, 'Uncategory', 'uncategory', 'Kategory tidak ditentukan', '', 'Y'),
(2, 0, 'Life', 'life', 'Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliq', '', 'Y'),
(3, 0, 'Travel', 'travel', 'Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliq', '', 'Y'),
(4, 0, 'Tekno', 'tekno', 'Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliq', '', 'Y'),
(5, 0, 'Entertainment', 'entertainment', 'Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliq', '', 'Y'),
(6, 2, 'Health', 'health', 'Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliq', '', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `t_comment`
--
DROP TABLE IF EXISTS `t_comment`;
CREATE TABLE `t_comment` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `id_user` int(100) NOT NULL,
  `id_post` int(100) NOT NULL,
  `parent` int(100) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `comment` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(30) NOT NULL,
  `active` enum('N','Y','X') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_comment`
--

INSERT INTO `t_comment` (`id`, `id_user`, `id_post`, `parent`, `name`, `email`, `comment`, `date`, `ip`, `active`) VALUES
(1, 0, 1, 0, 'Adiman', 'adiman@alweak.com', 'Oelit esse cillum dolore eu fugiat nulla pariatur xcepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum oluptate velit esse cillum dolore eu fugiat nulla pariatur', '2019-05-26 21:48:04', '127.0.0.1', 'Y'),
(2, 0, 1, 0, 'Sovia', 'sovia@alweak.com', 'Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua', '2019-05-26 21:52:06', '127.0.0.1', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `t_component`
--

DROP TABLE IF EXISTS `t_component`;
CREATE TABLE `t_component` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `type` varchar(100) NOT NULL,
  `class` varchar(200) NOT NULL,
  `table_name` varchar(200) NOT NULL,
  `status` enum('Y','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_gallery`
--
DROP TABLE IF EXISTS `t_gallery`;
CREATE TABLE `t_gallery` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `id_album` int(100) NOT NULL DEFAULT '0',
  `title` varchar(200) NOT NULL,
  `seotitle` varchar(200) NOT NULL,
  `picture` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_gallery`
--

INSERT INTO `t_gallery` (`id`, `id_album`, `title`, `seotitle`, `picture`) VALUES
(1, 1, 'Nature2', 'nature2-8934506721', 'gallery/nature-1.jpg'),
(2, 1, 'Nature3', 'nature3-8527641309', 'gallery/nature-2.jpg'),
(3, 1, 'Nature4', 'nature4-5897463120', 'gallery/nature-3.jpg'),
(4, 1, 'Nature5', 'nature5-9847502136', 'gallery/nature-4.jpg'),
(5, 1, 'Nature6', 'nature6-3582649071', 'gallery/nature-5.jpg'),
(6, 2, 'Vintage2', 'vintage2-2906751438', 'gallery/vintage-1.jpg'),
(7, 2, 'Vintage3', 'vintage3-4170583296', 'gallery/vintage-2.jpg'),
(8, 2, 'Vintage4', 'vintage4-9208513647', 'gallery/vintage-3.jpg'),
(9, 2, 'Vintage5', 'vintage5-9587624310', 'gallery/vintage-4.jpg'),
(10, 2, 'Vintage6', 'vintage6-2651483079', 'gallery/vintage-5.jpg'),
(11, 2, 'Vintage7', 'vintage7-4936502781', 'gallery/vintage-6.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `t_language`
--
DROP TABLE IF EXISTS `t_language`;
CREATE TABLE `t_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `seotitle` varchar(100) NOT NULL,
  `kode` varchar(100) NOT NULL,
  `active` enum('Y','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_language`
--

INSERT INTO `t_language` (`id`, `title`, `seotitle`, `kode`, `active`) VALUES
(1, 'Indonesia', 'indonesia', 'id', 'Y'),
(2, 'English', 'english', 'gb', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `t_mail`
--
DROP TABLE IF EXISTS `t_mail`;
CREATE TABLE `t_mail` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(80) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(50) NOT NULL,
  `active` enum('N','Y') NOT NULL DEFAULT 'N',
  `box` enum('in','out') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_menu`
--
DROP TABLE IF EXISTS `t_menu`;
CREATE TABLE `t_menu` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `parent_id` int(100) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `class` varchar(255) NOT NULL DEFAULT '',
  `position` int(100) NOT NULL,
  `group_id` tinyint(10) UNSIGNED NOT NULL DEFAULT '1',
  `active` enum('Y','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_menu`
--

INSERT INTO `t_menu` (`id`, `parent_id`, `title`, `url`, `class`, `position`, `group_id`, `active`) VALUES
(1, 0, 'Home Dashboard', 'home', 'fa fa-home', 1, 1, 'Y'),
(2, 0, 'Post', 'post', 'fa fa-newspaper-o', 2, 1, 'Y'),
(3, 2, 'All Post', 'post', '', 1, 1, 'Y'),
(4, 2, 'Add New', 'post/add-new', '', 2, 1, 'Y'),
(5, 0, 'Category', 'category', 'fa fa-folder-o', 3, 1, 'Y'),
(6, 5, 'All Category', 'category', '', 1, 1, 'Y'),
(7, 5, 'Add New', 'category/add-new', '', 2, 1, 'Y'),
(8, 0, 'Tag', 'tag', 'fa fa-tags', 4, 1, 'Y'),
(9, 0, 'Comment', 'comment', 'fa fa-comments-o', 5, 1, 'Y'),
(10, 0, 'Pages', 'pages', 'fa fa-file-text-o', 6, 1, 'Y'),
(11, 10, 'All Pages', 'pages', '', 1, 1, 'Y'),
(12, 10, 'Add New', 'pages/add-new', '', 2, 1, 'Y'),
(19, 0, 'Menu Manager', 'menumanager/?', 'fa fa-sitemap', 13, 1, 'Y'),
(20, 0, 'User', 'user', 'fa fa-users', 10, 1, 'Y'),
(21, 20, 'All User', 'user', '', 1, 1, 'Y'),
(22, 20, 'Add New', 'user/add-new', '', 2, 1, 'Y'),
(23, 20, 'Level', 'user/level', '', 3, 1, 'Y'),
(24, 0, 'Setting', 'setting', 'fa fa-gear', 14, 1, 'Y'),
(25, 0, 'Theme', 'theme', 'fa fa-paint-brush', 15, 1, 'Y'),
(26, 0, 'File Manager', '', 'fa fa-th || browse-files', 8, 1, 'N'),
(27, 0, 'Mail', 'mail', 'fa fa-envelope', 11, 1, 'Y'),
(28, 0, 'Gallery', 'gallery', 'fa fa-image', 7, 1, 'Y'),
(29, 0, 'Home', 'home', '', 1, 3, 'Y'),
(51, 0, 'File Manager', 'filemanager', 'fa fa-th', 9, 1, 'Y'),
(55, 0, 'Home Dashboard', 'home', 'fa fa-home', 1, 2, 'Y'),
(81, 0, 'Post', 'post', 'fa fa-newspaper-o', 2, 2, 'Y'),
(82, 81, 'All Post', 'post', '', 1, 2, 'Y'),
(83, 81, 'Add New', 'post/add-new', '', 2, 2, 'Y'),
(84, 0, 'Category', 'category', 'fa fa-folder-o', 3, 2, 'Y'),
(85, 84, 'All Category', 'category', '', 1, 2, 'Y'),
(86, 84, 'Add New', 'category/add-new', '', 2, 2, 'Y'),
(87, 0, 'Home', 'home', '', 1, 4, 'Y'),
(88, 0, 'Life', 'category/life', '', 2, 4, 'Y'),
(89, 0, 'Travel', 'category/travel', '', 3, 4, 'Y'),
(90, 0, 'Tekno', 'category/tekno', '', 4, 4, 'Y'),
(91, 0, 'Tag', 'tag', 'fa fa-tags', 4, 2, 'Y'),
(92, 0, 'Comment', 'comment', 'fa fa-comments-o', 5, 2, 'Y'),
(93, 0, 'Pages', 'pages', 'fa fa-file-text-o', 6, 2, 'Y'),
(94, 0, 'Gallery', 'gallery', 'fa fa-image', 7, 2, 'Y'),
(95, 0, 'Mail', 'mail', 'fa fa-envelope', 8, 2, 'Y'),
(96, 0, 'User', 'user', 'fa fa-users', 9, 2, 'Y'),
(98, 0, 'File Manager', 'filemanager', 'fa fa-th', 10, 2, 'Y'),
(99, 88, 'Health', 'category/health', '', 1, 4, 'Y'),
(100, 0, 'Entertainment', 'category/entertainment', '', 5, 4, 'Y'),
(101, 0, 'Gallery', 'gallery', '', 6, 4, 'Y'),
(102, 0, 'Post', 'post', 'fa fa-newspaper-o', 2, 3, 'Y'),
(103, 0, 'Category', 'category', 'fa fa-folder-o', 3, 3, 'Y'),
(104, 0, 'Tag', 'tag', 'fa fa-tags', 4, 3, 'Y'),
(105, 0, 'Gallery', 'gallery', 'fa fa-image', 5, 3, 'Y'),
(106, 0, 'Component', 'component', 'fa fa-cubes', 12, 1, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `t_menu_group`
--
DROP TABLE IF EXISTS `t_menu_group`;
CREATE TABLE `t_menu_group` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_menu_group`
--

INSERT INTO `t_menu_group` (`id`, `title`) VALUES
(1, 'Menu SU'),
(2, 'Menu Admin'),
(3, 'Menu User'),
(4, 'Menu Web');

-- --------------------------------------------------------

--
-- Table structure for table `t_pages`
--
DROP TABLE IF EXISTS `t_pages`;
CREATE TABLE `t_pages` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `seotitle` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `picture` text NOT NULL,
  `active` enum('Y','N') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_pages`
--

INSERT INTO `t_pages` (`id`, `title`, `seotitle`, `content`, `picture`, `active`) VALUES
(1, 'About Us', 'about-us', '&lt;p style=&quot;text-align: justify;&quot;&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laborissed do eiusmod tempor incididunt ut labore et dolore magna aliqua.&lt;/p&gt;\r\n&lt;p style=&quot;text-align: justify;&quot;&gt;Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laborissed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.&lt;/p&gt;\r\n&lt;p style=&quot;text-align: justify;&quot;&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmonisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim idLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmo&lt;/p&gt;', 'sicily_banner_landscape.jpg', 'Y'),
(2, 'FAQ', 'faq', '&lt;p&gt;Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum&lt;/p&gt;\r\n&lt;p&gt;Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor&lt;/p&gt;\r\n&lt;p&gt;Rin reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborumLorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proi&lt;/p&gt;\r\n&lt;p&gt;Hdent, sunt in culpa qui officia deserunt mollit anim id est laborumLorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum&lt;/p&gt;', '', 'N'),
(3, 'TOS', 'tos', '&lt;p style=&quot;text-align: justify;&quot;&gt;Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum&lt;/p&gt;\r\n&lt;p style=&quot;text-align: justify;&quot;&gt;Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor&lt;/p&gt;\r\n&lt;p style=&quot;text-align: justify;&quot;&gt;Rin reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborumLorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proi&lt;/p&gt;\r\n&lt;p style=&quot;text-align: justify;&quot;&gt;Hdent, sunt in culpa qui officia deserunt mollit anim id est laborumLorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum&lt;/p&gt;', '', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `t_post`
--
DROP TABLE IF EXISTS `t_post`;
CREATE TABLE `t_post` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `id_category` int(100) NOT NULL,
  `id_user` int(100) NOT NULL,
  `tag` varchar(200) NOT NULL,
  `title` varchar(300) NOT NULL,
  `seotitle` varchar(300) NOT NULL,
  `content` text NOT NULL,
  `datepost` date NOT NULL,
  `timepost` time NOT NULL,
  `picture` text NOT NULL,
  `image_caption` text NOT NULL,
  `hits` int(10) NOT NULL DEFAULT '0',
  `headline` enum('N','Y') NOT NULL DEFAULT 'N',
  `comment` enum('N','Y') NOT NULL DEFAULT 'Y',
  `active` enum('N','Y','-1') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_post`
--

INSERT INTO `t_post` (`id`, `id_category`, `id_user`, `tag`, `title`, `seotitle`, `content`, `datepost`, `timepost`, `picture`, `image_caption`, `hits`, `headline`, `comment`, `active`) VALUES
(1, 2, 1, 'bellyaerobic,langsing,tips,artikel', 'Bikin Langsing dan Kencang Dalam Sebulan, Belly Aerobic Ini Wajib Kamu Coba', 'bikin-langsing-dan-kencang-dalam-sebulan-belly-aerobic-ini-wajib-kamu-coba', '&lt;p style=&quot;text-align: justify;&quot;&gt;Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum&lt;/p&gt;\r\n&lt;p style=&quot;text-align: justify;&quot;&gt;&lt;strong&gt;Excepteur sint occaecat cupidatat non proident&lt;/strong&gt;&lt;/p&gt;\r\n&lt;p style=&quot;text-align: justify;&quot;&gt;Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum&lt;/p&gt;\r\n&lt;blockquote&gt;\r\n&lt;p&gt;Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat&lt;/p&gt;\r\n&lt;/blockquote&gt;\r\n&lt;p style=&quot;text-align: justify;&quot;&gt;Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum&lt;/p&gt;', '2018-01-22', '05:17:56', 'ber-belly-aerobic-ria.jpg', 'ber-belly aerobic ria via http://primavit.club', 0, 'Y', 'Y', 'Y'),
(2, 3, 1, 'pantaipink,lombok,wisata,artikel', 'Pesona Romantis Pantai Pink Lombok', 'pesona-romantis-pantai-pink-lombok', '&lt;p&gt;Lorem ipsum dolor sit amet conse ctetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaUt enim ad minim veniam, quis nostrud exercita tion ullamco laboris nisi ut aliquip ex ea commodo consequat oluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum&lt;/p&gt;\r\n&lt;p&gt;Lorem ipsum dolor sit amet con sectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaUt enim ad minim veniam, quis nostrud exerc itation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehen derit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.&lt;/p&gt;\r\n&lt;p&gt;Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laboru uis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum&lt;/p&gt;\r\n&lt;p&gt;Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum&lt;/p&gt;', '2018-03-15', '10:26:55', 'pantai-pink-lombok.jpg', 'https://ayokelombok.com/pantai-pinktangsi-lombok/', 0, 'Y', 'Y', 'Y'),
(3, 2, 1, 'artikel,tips', 'Suka Gaya Rambut Berponi? 5 Tips Ini Akan Membuat Penampilanmu Jadi Makin Kece', 'suka-gaya-rambut-berponi-5-tips-ini-akan-membuat-penampilanmu-jadi-makin-kece', '&lt;p&gt;Lorem ipsum dolor sit amet consec tetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum m, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum&lt;/p&gt;\r\n&lt;p&gt;Roccaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum m, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum&lt;/p&gt;\r\n&lt;p&gt;Er in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum m, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum&lt;/p&gt;', '2018-04-28', '03:13:02', 'Yoon-Eun-Hye.jpg', 'Yoon Eun Hye', 0, 'Y', 'Y', 'Y'),
(4, 4, 1, 'artikel', 'Fosil Langka Burung Dodo', 'fosil-langka-burung-dodo', '&lt;p style=&quot;text-align: justify;&quot;&gt;Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquat enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat sunt in culpa qui officia deserunt mollit anim id est laborum velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia henderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proide&lt;/p&gt;\r\n&lt;p style=&quot;text-align: justify;&quot;&gt;Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa nderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat&lt;/p&gt;', '2018-05-04', '09:32:32', 'burung-dodo.jpg', 'Burung Dodo', 0, 'N', 'Y', 'Y'),
(5, 4, 1, 'artikel,microsoft,billgates', 'Pendiri Microsoft, salah satu orang terkaya di Dunia', 'pendiri-microsoft-salah-satu-orang-terkaya-di-dunia', '&lt;p&gt;Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum&lt;/p&gt;\r\n&lt;p&gt;Reniam, quis nostrud exercitation ullamco laboris&amp;nbsp; nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum&lt;/p&gt;\r\n&lt;p&gt;Tim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo con sequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum&lt;/p&gt;', '2018-06-10', '20:15:15', 'bill-gates.jpg', 'Bill Gates', 0, 'Y', 'Y', 'Y'),
(6, 4, 1, 'artikel,microsoft,soni,game', 'Sony dan Microsoft Kerja Sama Kembangkan Game', 'sony-dan-microsoft-kerja-sama-kembangkan-game', '&lt;p&gt;Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum&lt;/p&gt;\r\n&lt;p&gt;Rolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum&lt;/p&gt;\r\n&lt;p&gt;Ulor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum&lt;/p&gt;', '2018-07-12', '10:06:49', 'xbx-ps.jpg', '', 0, 'N', 'Y', 'Y'),
(7, 3, 1, 'artikel,pulocinta', 'Pulo Cinta, Destinasi Kekinian yang Lebih Indah dari Maldives', 'pulo-cinta-destinasi-kekinian-yang-lebih-indah-dari-maldives', '&lt;p style=&quot;text-align: justify;&quot;&gt;Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum&lt;/p&gt;\r\n&lt;p style=&quot;text-align: justify;&quot;&gt;Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.&lt;/p&gt;\r\n&lt;p style=&quot;text-align: justify;&quot;&gt;Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaU t Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum&lt;/p&gt;', '2018-08-19', '10:18:23', 'pulo-cinta.jpg', '', 0, 'N', 'Y', 'Y'),
(8, 6, 1, 'artikel', 'Kata Peneliti, Cabai Itu Ternyata Resep Rahasia Untuk Panjang Umur', 'kata-peneliti-cabai-itu-ternyata-resep-rahasia-untuk-panjang-umur', '&lt;p&gt;Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum&lt;/p&gt;\r\n&lt;p&gt;Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum r adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor&lt;/p&gt;\r\n&lt;p&gt;Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum&lt;/p&gt;', '2018-09-17', '12:32:38', 'cabe-merah.jpg', '', 0, 'N', 'Y', 'Y'),
(9, 3, 1, 'artikel,sulawesiutara,kotabunga,wisata,tomohon', 'Destinasi Wisata Kota Bunga Tomohon Sulawesi Utara', 'destinasi-wisata-kota-bunga-tomohon-sulawesi-utara', '&lt;p&gt;Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum&lt;/p&gt;\r\n&lt;p&gt;Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum&lt;/p&gt;\r\n&lt;p&gt;Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum&lt;/p&gt;', '2018-10-07', '12:58:40', 'kota-bunga-tomohon.jpg', '', 0, 'Y', 'Y', 'Y'),
(10, 3, 1, 'artikel,pulauharapan', 'Pulau Harapan, Eksotisme dan Pesona Wisata Bahari Pulau Seribu', 'pulau-harapan-eksotisme-dan-pesona-wisata-bahari-pulau-seribu', '&lt;p&gt;Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua&lt;/p&gt;\r\n&lt;p&gt;Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequ atuis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culp&lt;/p&gt;\r\n&lt;blockquote&gt;Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat&lt;/blockquote&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p style=&quot;text-align: center;&quot;&gt;&lt;iframe src=&quot;//www.youtube.com/embed/kzNSiVdD0jU&quot; width=&quot;560&quot; height=&quot;315&quot; frameborder=&quot;0&quot; allowfullscreen=&quot;allowfullscreen&quot;&gt;&lt;/iframe&gt;&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;Oelit esse cillum dolore eu fugiat nulla pariatur xcepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum oluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum oluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum&lt;/p&gt;', '2018-11-14', '13:08:18', 'wisata-pulau-harapan.jpg', '', 0, 'N', 'Y', 'Y'),
(11, 3, 1, 'artikel', 'Wisata Favorit Traveler Buat Lihat Salju di Melbourne Ternyata Banyak yang Seru Loh', 'wisata-favorit-traveler-buat-lihat-salju-di-melbourne-ternyata-banyak-yang-seru-loh', '&lt;p style=&quot;text-align: justify;&quot;&gt;Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua t esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proid t esse cillum dolore eu fugiat nulla pariatur&lt;/p&gt;\r\n&lt;p style=&quot;text-align: justify;&quot;&gt;laboris nisi ut aliquip ex ea commodo consequat ate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mol ate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mol derit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia des&lt;/p&gt;\r\n&lt;p style=&quot;text-align: justify;&quot;&gt;Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Excepteur sint occaecat cupidatat non proid t esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proidostrud exercitation ullamco laboris nisi ut aliquip ex. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit an&lt;/p&gt;', '2018-12-25', '09:25:30', 'wisata-salju.jpg', 'Lorem ipsum dolor sit amet consectetur', 0, 'N', 'Y', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `t_setting`
--
DROP TABLE IF EXISTS `t_setting`;
CREATE TABLE `t_setting` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `groups` varchar(100) NOT NULL,
  `options` varchar(100) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_slug`
--
DROP TABLE IF EXISTS `t_slug`;
CREATE TABLE `t_slug` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `slug` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_slug`
--

INSERT INTO `t_slug` (`id`, `title`, `slug`) VALUES
(1, 'slug/seotitle', 'slug/([a-z0-9-]+)'),
(2, 'yyyy/seotitle', '([0-9-]+)/([a-z0-9-]+)'),
(3, 'yyyy/mm/seotitle', '([0-9-]+)/([0-9-]+)/([a-z0-9-]+)'),
(4, 'yyyy/mm/dd/seotitle', '([0-9-]+)/([0-9-]+)/([0-9-]+)/([a-z0-9-]+)'),
(5, 'seotitle', '([a-z0-9-]+)');

-- --------------------------------------------------------

--
-- Table structure for table `t_tag`
--
DROP TABLE IF EXISTS `t_tag`;
CREATE TABLE `t_tag` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `seotitle` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_tag`
--

INSERT INTO `t_tag` (`id`, `title`, `seotitle`) VALUES
(1, 'Pantai Pink', 'pantaipink'),
(2, 'Lombok', 'lombok'),
(3, 'Langsing', 'langsing'),
(4, 'Belly Aerobic', 'bellyaerobic'),
(5, 'Artikel', 'artikel'),
(6, 'Pulau Harapan', 'pulauharapan'),
(7, 'Tomohon', 'tomohon'),
(8, 'Kota Bunga', 'kotabunga'),
(9, 'Sulawesi Utara', 'sulawesiutara'),
(10, 'Wisata', 'wisata'),
(11, 'Pulo Cinta', 'pulocinta'),
(12, 'Microsoft', 'microsoft'),
(13, 'Soni', 'soni'),
(14, 'Game', 'game'),
(15, 'Bill Gates', 'billgates'),
(16, 'Tips', 'tips');

-- --------------------------------------------------------

--
-- Table structure for table `t_theme`
--
DROP TABLE IF EXISTS `t_theme`;
CREATE TABLE `t_theme` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `folder` varchar(100) NOT NULL,
  `active` enum('Y','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_theme`
--

INSERT INTO `t_theme` (`id`, `title`, `folder`, `active`) VALUES
(1, 'Sovi', 'sovi', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--
DROP TABLE IF EXISTS `t_user`;
CREATE TABLE `t_user` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `level` int(100) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(60) NOT NULL,
  `name` varchar(50) NOT NULL,
  `gender` enum('M','F') NOT NULL DEFAULT 'M',
  `birthday` date NOT NULL DEFAULT '1999-01-01',
  `about` text NOT NULL,
  `address` text NOT NULL,
  `tlpn` varchar(15) NOT NULL,
  `photo` varchar(300) NOT NULL DEFAULT 'avatar.jpg',
  `active` enum('Y','N') NOT NULL DEFAULT 'N',
  `activation_key` varchar(100) NOT NULL DEFAULT '0',
  `forgot_key` varchar(100) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_user_level`
--
DROP TABLE IF EXISTS `t_user_level`;
CREATE TABLE `t_user_level` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `level` varchar(100) NOT NULL,
  `menu` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_user_level`
--

INSERT INTO `t_user_level` (`id`, `title`, `level`, `menu`) VALUES
(1, 'Super Administrator', 'super-admin', 1),
(2, 'Administrator', 'admin', 2),
(3, 'User', 'user', 3),
(4, 'Member', 'member', 0);

-- --------------------------------------------------------

--
-- Table structure for table `t_user_role`
--
DROP TABLE IF EXISTS `t_user_role`;
CREATE TABLE `t_user_role` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `level` int(100) NOT NULL,
  `module` varchar(150) NOT NULL,
  `read_access` enum('N','Y') NOT NULL,
  `write_access` enum('N','Y') NOT NULL,
  `delete_access` enum('N','Y') NOT NULL,
  `modify_access` enum('N','Y') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_user_role`
--

INSERT INTO `t_user_role` (`id`, `level`, `module`, `read_access`, `write_access`, `delete_access`, `modify_access`) VALUES
(1, 2, 'home', 'Y', 'Y', 'Y', 'Y'),
(2, 2, 'post', 'Y', 'Y', 'Y', 'Y'),
(3, 2, 'category', 'Y', 'Y', 'Y', 'Y'),
(4, 2, 'tag', 'Y', 'Y', 'Y', 'Y'),
(6, 2, 'comment', 'Y', 'Y', 'Y', 'Y'),
(7, 2, 'gallery', 'Y', 'Y', 'Y', 'Y'),
(8, 2, 'pages', 'Y', 'Y', 'Y', 'Y'),
(9, 2, 'mail', 'Y', 'Y', 'Y', 'Y'),
(10, 2, 'filemanager', 'Y', 'Y', 'Y', 'Y'),
(11, 2, 'user', 'Y', 'Y', 'Y', 'Y'),
(12, 2, 'component', 'Y', 'N', 'N', 'N'),
(13, 3, 'home', 'Y', 'N', 'N', 'N'),
(14, 3, 'post', 'Y', 'Y', 'Y', 'Y'),
(15, 3, 'category', 'Y', 'N', 'N', 'N'),
(16, 3, 'tag', 'Y', 'N', 'N', 'N'),
(17, 3, 'comment', 'Y', 'N', 'N', 'Y'),
(18, 3, 'gallery', 'Y', 'Y', 'Y', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `t_visitor`
--
DROP TABLE IF EXISTS `t_visitor`;
CREATE TABLE `t_visitor` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) NOT NULL,
  `os` varchar(255) NOT NULL,
  `platform` varchar(255) NOT NULL,
  `browser` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `hits` int(50) NOT NULL,
  `online` int(50) NOT NULL,
  `url` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;