-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2020 at 04:25 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `buddy_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `buddie_request`
--

CREATE TABLE `buddie_request` (
  `id` int(11) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `reciever` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tl_buddies`
--

CREATE TABLE `tl_buddies` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_one` int(11) NOT NULL,
  `user_two` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tl_buddies`
--

INSERT INTO `tl_buddies` (`id`, `user_one`, `user_two`) VALUES
(42, 18, 19),
(44, 17, 21);

-- --------------------------------------------------------

--
-- Table structure for table `tl_chat`
--

CREATE TABLE `tl_chat` (
  `id` int(11) NOT NULL,
  `senderId` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recieverId` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senderName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recieverName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tl_chat`
--

INSERT INTO `tl_chat` (`id`, `senderId`, `recieverId`, `senderName`, `recieverName`, `message`, `created_on`) VALUES
(89, '26', '21', 'Lowieee', 'Lotte', 'YOYO\r\n', '2020-04-17 14:10:39'),
(90, '26', '21', 'Lowieee', 'Lotte', 'YOYO\r\n', '2020-04-17 14:12:09'),
(91, '26', '25', 'Lowieee', 'Lowie', 'Ello', '2020-04-17 14:12:21'),
(92, '25', '26', 'Lowie', 'Lowieee', 'Yoo', '2020-04-17 14:12:40'),
(93, '26', '26', 'Lowieee', 'Lowieee', 'Sorry maat da ga ni', '2020-04-17 14:20:12'),
(94, '26', '25', 'Lowieee', 'Lowie', 'Eyoo', '2020-04-17 14:25:31');

-- --------------------------------------------------------

--
-- Table structure for table `tl_user`
--

CREATE TABLE `tl_user` (
  `id` int(11) NOT NULL,
  `firstName` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `lastName` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `description` mediumtext COLLATE utf8mb4_bin NOT NULL,
  `profilePicture` longtext COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `mainCourseInterest` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `schoolYear` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `sportType` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `goingOutType` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `buddyType` varchar(255) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `tl_user`
--

INSERT INTO `tl_user` (`id`, `firstName`, `lastName`, `email`, `description`, `profilePicture`, `password`, `city`, `mainCourseInterest`, `schoolYear`, `sportType`, `goingOutType`, `buddyType`) VALUES
(16, 'Lieselotte', 'Philips', 'lieselotte.philips@student.thomasmore.be', '', 'uploads/1585921945_Assets_default_images_plex_wp_edited_image_default_1.jpg', '$2y$12$uj8ntvGl4YEOLYGF19BaYue66OLafRgxB/o2Woad.O6ksckWOrGv.', 'Nieuwerkerken - Aalst', 'Frontend development', '3 IMD', 'Zetelhanger', 'Gezellig samen met vrienden', 'wantToBeABuddy'),
(17, 'Laura', 'Philips', 'laura.philips@student.thomasmore.be', '', '', '$2y$12$hqnQN.RDGUT9NvFlsfIT4uFXGDIJ4FeEmEGJP71rJXWSSed14c7WC', 'Nieuwerkerken - Aalst', 'Frontend development', '2 IMD', 'Zetelhanger', 'Gezellig samen met vrienden', 'wantToBeABuddy'),
(18, 'Lieve', 'Boon', 'lieve.boon@student.thomasmore.be', '', '', '$2y$12$kpt17C7GWIho6JKho0T19eoecRwoLE6nto9mPuZRbG7xglmxrliPe', 'Nieuwerkerken - Aalst', 'Frontend development', '2 IMD', 'Zetelhanger', 'Gezellig samen met vrienden', 'lookingForABuddy'),
(19, 'Jos', 'Vermeulen', 'jos.vermeulen@student.thomasmore.be', '', '', '$2y$12$82UwmgJBUIfXqY1Zu9cgXuwPkd6g53qDoMOj3n3pavrNPnYic7RtS', 'Aalst', 'Backend development', '3 IMD', 'Uithoudingsvermogen', 'Gezellig samen met vrienden', 'wantToBeABuddy'),
(20, 'jacques', 'Vermeulen', 'jacques.vermeulen@student.thomasmore.be', '', '', '$2y$12$QapWXOu24C/8ZIKN2J4K5.FhokMmPjdKha2eTLRtu4flk2GEnqndK', 'Mechelen ', 'Web design', '3 IMD', 'Waterrat', 'Home sweet home', 'lookingForABuddy'),
(21, 'Lotte', 'Philips', 'lotte.philips@student.thomasmore.be', '', '', '$2y$12$FV5yCE1t9KYsOVYwSCYo0enj5iM9SC8ZneKyJ6zob.w/92zYZTevC', 'Mechelen ', 'Web design', '3 IMD', 'Teamplayer', 'Party animal', 'wantToBeABuddy'),
(22, 'Laura', 'Fleerackers', 'laura.fleerackers@student.thomasmore.be', '', '', '$2y$12$hzsDZGkj4BVQBK84hmyH1O93euKOR9wZAaVEPbtJAHtOiE8P.wx1u', 'Erembodegem', 'Web design', 'Aangepast programma', 'Teamplayer', 'Gezellig samen met vrienden', 'wantToBeABuddy'),
(23, 'Jos', 'Vermeulen', 'jos.v@student.thomasmore.be', '', '', '$2y$12$9PD7nY17pWLZ9LpQtrPMUeLhe0JduBMXXn5D5bZBe676n5wrg8oYq', '', '', '', '', '', ''),
(24, 'Lowie', 'Aelbrecht', 'aelbrecht.lowie@student.thomasmore.be', '', '', '$2y$12$FidIzUASSe8WjFfCoX7/x.dIfKeXnDFI6AaHqAL/MGe7BGhREJCtO', '', '', '', '', '', ''),
(25, 'Lowie', 'Aelbrecht', 'aaelbrecht.lowie@student.thomasmore.be', '', '', '$2y$12$wYuA1kWzZ/AY3IyKqVOoQ.Ntuu6XA6ozhCjQ6nm/Qc./uBtA4Wn5W', 'Bornem', 'Frontend development', '1 IMD', 'Krachtpatser', 'Party animal', 'lookingForABuddy'),
(26, 'Lowieee', 'Aaaaelbrecht', 'r0706641@student.thomasmore.be', '', '', '$2y$12$XlfPV2u21pAKb0kPbrdSbeSN0WclIOMvDnyN.SOFG3C9bHt2y/6nu', 'Mariekerke', 'Frontend development', 'Aangepast programma', 'Krachtpatser', 'Party animal', 'lookingForABuddy'),
(29, 'jefke', 'vermassen', 'aaaaaaaaaaelbrecht.lowie@student.thomasmore.be', '', '', '$2y$12$TYxZJHelCv3uOBt5soJ9A.e8n7vPm5UmEQXUREqHn5.eifSPJyMqK', '', '', '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buddie_request`
--
ALTER TABLE `buddie_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tl_buddies`
--
ALTER TABLE `tl_buddies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tl_chat`
--
ALTER TABLE `tl_chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tl_user`
--
ALTER TABLE `tl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buddie_request`
--
ALTER TABLE `buddie_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT for table `tl_buddies`
--
ALTER TABLE `tl_buddies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `tl_chat`
--
ALTER TABLE `tl_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `tl_user`
--
ALTER TABLE `tl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
