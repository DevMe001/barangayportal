-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2024 at 07:13 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id21672546_barangayportal`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `updationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `UserName`, `Password`, `updationDate`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '2020-11-03 05:55:30');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `admin` varchar(255) NOT NULL,
  `signature` varchar(300) DEFAULT NULL,
  `valid_until` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `message`, `admin`, `signature`, `valid_until`, `created_at`) VALUES
(1, 'Stay tuned for updates and announcements.', 'default_value', NULL, 0, '2023-12-19 20:24:39'),
(2, 'Welcome to our Barangay Information Portal!!!', 'default_value', NULL, 0, '2023-12-19 20:26:04'),
(26, 'we have a brgy night on the day of February 14,2024 7pm at Brgy. Bernardo District Court please wear a semi formal attire! SEE YOU KA BARANGAYS', 'default_value', NULL, 0, '2024-02-08 15:44:29'),
(27, 'WELCOME BACK!\\r\\n\\r\\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean vitae ultrices nulla, ut aliquet leo. Donec lobortis est enim, at pellentesque ex pellentesque in. Cras sed libero massa. Nunc rhoncus nunc erat, at laoreet risus efficitur vitae. Curabitur auctor eleifend sapien eu malesuada. Quisque enim erat, mattis non facilisis iaculis, gravida quis urna. Suspendisse euismod quam magna, eget lobortis risus condimentum nec. Praesent cursus leo vitae suscipit elementum. Proin ac enim luctus, scelerisque purus eget, varius orci. Etiam interdum in mi quis cursus. Donec viverra mauris magna, nec luctus nunc sollicitudin vel. Aenean dui nisl, vulputate in elit ac, laoreet euismod odio.\\r\\n\\r\\nNunc eu ultricies dolor. Curabitur vestibulum metus eu imperdiet vehicula. Etiam a vestibulum nunc. Phasellus sed dolor commodo, gravida purus sit amet, efficitur felis. Nunc ullamcorper et eros non consequat. Morbi sem ante, viverra vitae ultrices a, tempor non mi. Vivamus eleifend, ex sed viverra dignissim, lacus ipsum euismod nibh, semper iaculis velit nunc a metus.\\r\\n\\r\\nInteger eros arcu, dapibus quis rhoncus sed, ultrices eu ligula. Ut cursus malesuada augue, et pellentesque dolor pharetra non. Sed vel metus sed augue eleifend facilisis. Ut commodo eu felis eu sodales. Donec porta et eros a semper. Cras ornare mollis nibh, nec blandit dolor condimentum et. Praesent id congue diam, a tempor tortor. Donec id magna lorem. Sed at aliquam nulla. Sed a sapien ut turpis aliquam semper. Proin nulla nulla, viverra eu magna ut, consequat facilisis sapien. Nulla facilisi. Proin a cursus lacus. Proin non ante nec tortor mattis imperdiet.\\r\\n\\r\\nDuis vel nulla mollis, posuere tellus imperdiet, egestas purus. Morbi euismod ac leo nec maximus. Morbi quis augue ut quam finibus eleifend eget vitae nisl. Nunc vulputate urna id lorem vestibulum, nec ultrices justo hendrerit. Mauris quis pellentesque lectus. In a eleifend leo. Maecenas lobortis dui id elementum ultrices. Etiam fermentum semper mi eget hendrerit. Pellentesque pellentesque eleifend mollis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Aliquam venenatis, nisl nec dapibus dapibus, ligula ligula blandit ante, et bibendum quam lacus non tortor. Nullam scelerisque leo et augue pellentesque laoreet. Morbi id metus sed ante convallis sagittis. Fusce bibendum pretium condimentum. Donec a purus vel augue faucibus finibus in ac metus.\\r\\n\\r\\nSuspendisse sed nunc felis. In in tortor id neque feugiat eleifend non in risus. Cras ut enim hendrerit, fermentum velit et, varius odio. Aliquam fringilla risus at neque faucibus, nec sollicitudin risus interdum. Etiam luctus lectus ipsum, in congue dui consequat sit amet. Praesent faucibus lorem ex, et pulvinar libero maximus id. Etiam finibus, ipsum sit amet ornare lacinia, sapien neque viverra libero, eu lobortis quam eros viverra nisi. Donec nec aliquet justo.', 'default_value', NULL, 0, '2024-02-09 09:46:17'),
(28, 'hello hello helloo helloo', 'default_value', NULL, 0, '2024-02-09 10:08:12'),
(33, 'New world order ni kapitana', 'default_value', 'signature_65d627cf30464.png', 0, '2024-02-21 16:41:51'),
(34, 'Tree planting activity', 'default_value', 'signature_65d62bfb746f3.png', 0, '2024-02-21 16:59:39'),
(36, 'Moon landing NASA', 'default_value', NULL, 0, '2024-02-21 17:09:10'),
(37, 'Moon landing NASA', 'default_value', 'signature_65d62e687fa87.png', 0, '2024-02-21 17:10:00'),
(38, 'Warrior is loving moon', 'default_value', 'signature_65d62ec050f96.png', 0, '2024-02-21 17:11:28'),
(39, 'Movie flying away', 'default_value', 'signature_65d62f12cec5f.png', 0, '2024-02-21 17:12:50'),
(40, 'Calling aspiring encoder', 'default_value', 'signature_65d62f872590e.png', 0, '2024-02-21 17:14:47'),
(41, 'three planting activities', 'default_value', 'signature_65d711ec5f088.png', 2, '2024-02-22 09:20:44'),
(44, 'Nutrition month event coming on march ', 'default_value', 'signature_65d713709fff2.png', 3, '2024-02-22 09:27:12'),
(46, 'Typhoon urgent preparation', 'default_value', 'signature_65d718e67e101.png', 3, '2024-02-22 09:50:30');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `feedback_photo` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `feedback` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `content`, `timestamp`, `feedback_photo`, `photo`, `feedback`) VALUES
(1, 'Barado yung kanal sa centro street.', '2023-12-19 21:05:11', 'yawa.png', NULL, 'gege'),
(2, 'secret', '2023-12-19 22:16:07', 'aaa.jpg', NULL, 'heehehe'),
(3, 'grrr', '2024-01-23 21:45:00', 'keeping up with zayn.png', NULL, 'OKS'),
(4, 'AYOKO NA', '2024-01-23 23:26:58', 'keeping up with zayn.png', NULL, 'wag'),
(5, 'abc', '2024-01-24 08:28:03', 'i miss her.png', NULL, 'monitor ko po'),
(6, 'bad influence si grace', '2024-01-24 08:30:41', 'IMG_20230118_215358-1.png', NULL, 'okay na po ba?'),
(7, 'test try 123', '2024-02-06 19:20:42', 'IMG_20230118_215358-1.png', 'aaa.jpg', 'SIGE PO WHAHAHAHA'),
(8, 'lord wag paaaaaaAAAAaaaAa', '2024-02-09 01:57:49', NULL, 'aaaaaaaaaaaaaaaaaaa.jpg', NULL),
(9, 'test try 123', '2024-02-09 05:33:18', 'aaaaaaaaaaaaaaaaaaa.jpg', 'F4LozrQbYAA9lE1.jpg', 'gegegeg');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `complaint_id` int(11) DEFAULT NULL,
  `feedback_content` text DEFAULT NULL,
  `star_rating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `content`, `timestamp`, `complaint_id`, `feedback_content`, `star_rating`) VALUES
(1, 'hahaha', '2023-12-19 22:14:40', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `inquiries`
--

INSERT INTO `inquiries` (`id`, `content`, `timestamp`) VALUES
(1, 'hahaha', '2023-12-19 22:14:47'),
(2, 'hello', '2024-02-09 00:01:45');

-- --------------------------------------------------------

--
-- Table structure for table `resident`
--

CREATE TABLE `resident` (
  `id` int(11) NOT NULL,
  `FirstName` varchar(150) NOT NULL,
  `LastName` varchar(150) NOT NULL,
  `EmailId` varchar(150) NOT NULL,
  `Password` varchar(180) NOT NULL,
  `Gender` varchar(100) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `PhoneNumber` char(11) NOT NULL,
  `RegistrationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `resident`
--

INSERT INTO `resident` (`id`, `FirstName`, `LastName`, `EmailId`, `Password`, `Gender`, `Address`, `PhoneNumber`, `RegistrationDate`, `role`) VALUES
(1, 'gregor', 'mcgregor', 'jajaja@gmail.com', 'b4cc344d25a2efe540adbf2678e2304c', 'male', 'secret', '1111', '2023-12-19 20:36:42', 'Resident'),
(2, 'aaa', 'zxczc', 'aasda@gmail.com', 'b4cc344d25a2efe540adbf2678e2304c', 'male', 'secretaasd', '1111', '2023-12-19 20:50:24', 'Resident'),
(3, 'Justin', 'alfonso', 'justin@gmail.com', 'b4cc344d25a2efe540adbf2678e2304c', 'male', 'secret', '111', '2024-02-01 13:54:37', 'Resident'),
(4, 'kael', 'alfonso', 'kael@gmail.com', 'b4cc344d25a2efe540adbf2678e2304c', 'male', 'secret', '09519907449', '2024-02-09 00:45:31', 'Resident');

-- --------------------------------------------------------

--
-- Table structure for table `tbldepartments`
--

CREATE TABLE `tbldepartments` (
  `id` int(11) NOT NULL,
  `DepartmentName` varchar(150) DEFAULT NULL,
  `DepartmentShortName` varchar(100) NOT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbldepartments`
--

INSERT INTO `tbldepartments` (`id`, `DepartmentName`, `DepartmentShortName`, `CreationDate`) VALUES
(2, 'Barangay Office', 'BO', '2017-11-01 07:19:37'),
(4, 'Bikers Club', 'BC', '2023-12-19 20:33:31'),
(5, 'Sanggunian Kabataan Club', 'SKC', '2024-01-24 06:08:38'),
(6, 'Basket Club', 'BC', '2024-02-09 09:46:07'),
(7, 'Basketball', 'bg', '2024-02-21 09:20:31');

-- --------------------------------------------------------

--
-- Table structure for table `tblemployees`
--

CREATE TABLE `tblemployees` (
  `emp_id` int(11) NOT NULL,
  `FirstName` varchar(150) NOT NULL,
  `LastName` varchar(150) NOT NULL,
  `EmailId` varchar(200) NOT NULL,
  `Password` varchar(180) NOT NULL,
  `Gender` varchar(100) NOT NULL,
  `Dob` varchar(100) NOT NULL,
  `Department` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Phonenumber` char(11) NOT NULL,
  `Status` int(1) NOT NULL,
  `RegDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(30) NOT NULL,
  `location` varchar(200) NOT NULL,
  `is_active` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblemployees`
--

INSERT INTO `tblemployees` (`emp_id`, `FirstName`, `LastName`, `EmailId`, `Password`, `Gender`, `Dob`, `Department`, `Address`, `Phonenumber`, `Status`, `RegDate`, `role`, `location`, `is_active`) VALUES
(1, 'Margaux', 'Roque', 'marga@gmail.com', 'b4cc344d25a2efe540adbf2678e2304c', 'Female', '24 December 2023', 'BO', 'Midway, Cabanatuan City', '09117764557', 1, '2017-11-10 11:29:59', 'Resident', 'F4LozrQbYAA9lE1.jpg', 0),
(2, 'Zayn', 'Malik', 'zayn@gmail.com', 'b4cc344d25a2efe540adbf2678e2304c', 'Male', '12 January, 1993', 'Barangay Office', 'Bradford', '09519907449', 1, '2017-11-10 13:40:02', 'Admin', 'zaynie.png', 0),
(3, 'yannie', 'sideup', 'yanniesideup@gmail.com', 'b4cc344d25a2efe540adbf2678e2304c', 'Female', '3 March, 2003', 'BC', 'secret', '222222', 1, '2023-12-11 03:55:58', 'Staff', '370231412_708154214068378_9068138329438679683_n.jpg', 0),
(12, 'kaelll', 'alfonso', 'kael@gmail.com', 'b4cc344d25a2efe540adbf2678e2304c', 'male', '09 February 2024', 'BO', 'secret', '09519907449', 1, '2024-02-09 09:55:40', 'Resident', 'NO-IMAGE-AVAILABLE.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblrequest`
--

CREATE TABLE `tblrequest` (
  `id` int(11) NOT NULL,
  `FirstName` varchar(110) NOT NULL,
  `LastName` varchar(120) NOT NULL,
  `EmailId` varchar(120) NOT NULL,
  `RequestType` varchar(110) NOT NULL,
  `ToDate` varchar(120) NOT NULL,
  `FromDate` varchar(120) NOT NULL,
  `Description` mediumtext NOT NULL,
  `PostingDate` date NOT NULL,
  `AdminRemark` mediumtext DEFAULT NULL,
  `registra_remarks` varchar(255) DEFAULT 'default_value',
  `AdminRemarkDate` varchar(120) DEFAULT NULL,
  `Status` int(1) NOT NULL,
  `admin_status` int(11) NOT NULL DEFAULT 0,
  `IsRead` int(1) NOT NULL,
  `empid` int(11) DEFAULT NULL,
  `num_days` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblrequest`
--

INSERT INTO `tblrequest` (`id`, `FirstName`, `LastName`, `EmailId`, `RequestType`, `ToDate`, `FromDate`, `Description`, `PostingDate`, `AdminRemark`, `registra_remarks`, `AdminRemarkDate`, `Status`, `admin_status`, `IsRead`, `empid`, `num_days`) VALUES
(13, 'Zayn', 'Malik', 'zayn@gmail.com', 'Permit', '2021-05-02', '2021-05-12', 'I wanna die.', '2021-05-20', 'Ok', 'ok', '2021-05-24 20:26:19 ', 1, 1, 1, 7, 3),
(34, 'yannie', 'sideup', 'yanniesideup@gmail.com', 'simbang gabi', '2024-02-09', '2024-02-10', 'secret', '2024-02-09', NULL, 'okay na ean HAHAHAHAHA', '2024-02-09 8:34:16 ', 1, 1, 1, 3, 1),
(35, 'yannie', 'sideup', 'yanniesideup@gmail.com', 'simbang gabi', '1970-01-01', '2024-02-10', 'aaaaa', '2024-02-09', NULL, 'sorry gar', '2024-02-09 8:28:45 ', 2, 2, 1, 3, 19763),
(37, 'yannie', 'sideup', 'yanniesideup@gmail.com', 'simbang gabi', '2024-02-09', '2024-02-10', 'nyenye', '2024-02-09', NULL, 'naice one', '2024-02-09 8:31:13 ', 1, 0, 1, 3, 1),
(38, 'Marga', 'Roque', 'marga@gmail.com', 'simbang gabi', '2024-02-09', '2024-02-10', 'nyenye', '2024-02-09', NULL, 'default_value', NULL, 0, 0, 0, 1, 0),
(39, 'Marga', 'Roque', 'marga@gmail.com', 'simbang gabi', '2024-02-09', '2024-02-10', 'brttttt', '2024-02-09', NULL, 'okay', '2024-02-09 15:15:18 ', 1, 0, 1, 1, 0),
(40, 'yannie', 'sideup', 'yanniesideup@gmail.com', 'simbang gabi', '2024-02-07', '2024-02-16', 'gasadsasd', '2024-02-09', NULL, 'default_value', NULL, 0, 0, 0, 3, 9),
(41, 'Marga', 'Roque', 'marga@gmail.com', 'Permit', '2024-02-09', '2024-02-10', 'aAAAAaaaaAAAAAAaa', '2024-02-09', NULL, 'ocakez wahaha', '2024-02-09 14:50:31 ', 1, 0, 1, 1, 0),
(42, 'yannie', 'sideup', 'yanniesideup@gmail.com', 'simbang gabi', '2024-02-09', '2024-02-10', 'nyenye', '2024-02-09', NULL, 'default_value', NULL, 0, 0, 0, 3, 1),
(43, 'Zayn', 'Malik', 'zayn@gmail.com', 'Other', '2024-02-07', '2024-02-03', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean vitae ultrices nulla, ut aliquet leo. Donec lobortis est enim, at pellentesque ex pell', '2024-02-09', NULL, 'default_value', NULL, 0, 0, 1, 2, 0),
(44, 'Zayn', 'Malik', 'zayn@gmail.com', 'Permit', '2024-02-09', '2024-02-10', 'need q na', '2024-02-09', NULL, 'default_value', NULL, 0, 0, 0, 2, 0),
(45, 'kaelll', 'alfonso', 'kael@gmail.com', 'Permit', '2024-02-16', '2021-11-29', 'asdasdasdasdasdasdasdasdasdasdasd', '2024-02-09', NULL, 'appprove', '2024-02-22 22:45:03 ', 1, 1, 1, 12, 0),
(46, 'kaelll', 'alfonso', 'kael@gmail.com', 'Permit', '2024-02-16', '2021-11-29', 'asdasdasdasdasdasdasdasdasdasdasd', '2024-02-09', NULL, 'approved', '2024-02-22 22:12:15 ', 1, 1, 1, 12, 0),
(47, 'kaelll', 'alfonso', 'kael@gmail.com', 'Permit', '2024-02-16', '2021-11-29', 'asdasdasdasdasdasdasdasdasdasdasd', '2024-02-09', NULL, 'urgency', '2024-02-22 22:25:07 ', 1, 1, 1, 12, 0),
(48, 'kaelll', 'alfonso', 'kael@gmail.com', 'Permit', '2024-02-16', '2021-11-29', 'asdasdasdasdasdasdasdasdasdasdasd', '2024-02-09', NULL, 'approved', '2024-02-22 22:45:23 ', 1, 0, 1, 12, 0),
(49, 'kaelll', 'alfonso', 'kael@gmail.com', 'Permit', '2024-02-16', '2021-11-29', 'asdasdasdasdasdasdasdasdasdasdasd', '2024-02-09', NULL, 'approve urgency', '2024-02-22 22:20:06 ', 1, 1, 1, 12, 0),
(50, 'kaelll', 'alfonso', 'kael@gmail.com', 'Permit', '2024-02-16', '2021-11-29', 'asdasdasdasdasdasdasdasdasdasdasd', '2024-02-09', NULL, 'approve urgently ', '2024-02-22 22:44:39 ', 1, 1, 1, 12, 0),
(51, 'kaelll', 'alfonso', 'kael@gmail.com', 'Permit', '2024-02-16', '2021-11-29', 'asdasdasdasdasdasdasdasdasdasdasd', '2024-02-09', NULL, 'default_value', NULL, 0, 0, 0, 12, 0),
(52, 'kaelll', 'alfonso', 'kael@gmail.com', 'Permit', '2024-02-16', '2021-11-29', 'asdasdasdasdasdasdasdasdasdasdasd', '2024-02-09', NULL, 'default_value', NULL, 0, 0, 1, 12, 0),
(53, 'kaelll', 'alfonso', 'kael@gmail.com', 'Permit', '2024-02-16', '2021-11-29', 'asdasdasdasdasdasdasdasdasdasdasd', '2024-02-09', NULL, 'default_value', NULL, 0, 0, 1, 12, 0),
(54, 'kaelll', 'alfonso', 'kael@gmail.com', 'Permit', '2024-02-16', '2021-11-29', 'asdasdasdasdasdasdasdasdasdasdasd', '2024-02-09', NULL, 'test', '2024-02-21 11:07:05 ', 1, 1, 1, 12, 0),
(55, 'Zayn', 'Malik', 'zayn@gmail.com', 'ticket basketball', '2024-02-09', '2024-02-05', 'fghfdhgfg', '2024-02-09', NULL, 'default_value', NULL, 0, 0, 0, 2, 0),
(56, 'Margaux', 'Roque', 'marga@gmail.com', 'simbang gabi', '2024-02-22', '2024-02-22', 'multiple request', '2024-02-21', NULL, 'default_value', NULL, 0, 0, 0, 1, 0),
(57, 'Margaux', 'Roque', 'marga@gmail.com', 'Permit', '2024-02-22', '2024-02-22', 'multiple request', '2024-02-21', NULL, 'default_value', NULL, 0, 0, 0, 1, 0),
(58, 'Margaux', 'Roque', 'marga@gmail.com', 'ticket basketball', '2024-02-22', '2024-02-22', 'multiple request', '2024-02-21', NULL, 'default_value', NULL, 0, 0, 0, 1, 0),
(59, 'Margaux', 'Roque', 'marga@gmail.com', 'Certification', '2024-02-22', '2024-02-21', 'request', '2024-02-21', NULL, 'default_value', NULL, 0, 0, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblrequesttype`
--

CREATE TABLE `tblrequesttype` (
  `id` int(11) NOT NULL,
  `RequestType` varchar(200) DEFAULT NULL,
  `Description` mediumtext DEFAULT NULL,
  `date_from` varchar(200) NOT NULL,
  `date_to_valid` varchar(200) NOT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblrequesttype`
--

INSERT INTO `tblrequesttype` (`id`, `RequestType`, `Description`, `date_from`, `date_to_valid`, `CreationDate`) VALUES
(9, 'simbang gabi', 'entrance reservation', '2023-12-20', '2023-12-24', '2023-12-19 20:33:59'),
(10, 'Permit', 'COURT', '2024-01-22', '2024-01-22', '2024-01-22 02:00:39'),
(12, 'ticket basketball', 'asdasdfs', '2024-02-09', '2024-02-10', '2024-02-09 09:52:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resident`
--
ALTER TABLE `resident`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbldepartments`
--
ALTER TABLE `tbldepartments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblemployees`
--
ALTER TABLE `tblemployees`
  ADD PRIMARY KEY (`emp_id`);

--
-- Indexes for table `tblrequest`
--
ALTER TABLE `tblrequest`
  ADD PRIMARY KEY (`id`),
  ADD KEY `UserEmail` (`empid`);

--
-- Indexes for table `tblrequesttype`
--
ALTER TABLE `tblrequesttype`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `resident`
--
ALTER TABLE `resident`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbldepartments`
--
ALTER TABLE `tbldepartments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblemployees`
--
ALTER TABLE `tblemployees`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tblrequest`
--
ALTER TABLE `tblrequest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `tblrequesttype`
--
ALTER TABLE `tblrequesttype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
