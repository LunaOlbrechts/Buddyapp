-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2020 at 12:09 PM
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
  `courseInterests` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `schoolYear` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `sportType` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `goingOutType` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `matchId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `tl_user`
--

INSERT INTO `tl_user` (`id`, `firstName`, `lastName`, `email`, `description`, `profilePicture`, `password`, `city`, `courseInterests`, `schoolYear`, `sportType`, `goingOutType`, `matchId`) VALUES
(7, 'Wannes', 'Aelbrecht', 'r0706641@student.thomasmore.be', '', '', '$2y$12$AW9iVycgv5wHMzDXo5mRYunFb8GIVwupVE8H.gE4wq4Hwk8mMi9J6', '', '', '', '', '', 1),
(8, 'Lowie', 'Aelbrecht', 'rr0706641@student.thomasmore.be', '', '', '$2y$12$JG.ekSdsdkDA9Zxt8WjoWOwexrjDj2CkdwgMMEcI0wVuKQ2KGVEYi', '', '', '', '', '', 2),
(9, 'Amelie', 'Aelbrecht', 'rrr07060641@student.thomasmore.be', '', '', '$2y$12$mffo6wYxNNl0KdtfYVfqdO1V0HGFHoA3Vj10SqJD50t4NpMl4wIzO', '', '', '', '', '', 3),
(10, 'Jos', 'Aelbrecht', 'L0706641@student.thomasmore.be', '', '', '$2y$12$/zOUv/t2xAhNHCUb1TTRo.K6lHScsdRSdO9xQ1.HrxA39YS1BdQLm', '', '', '', '', '', 3),
(11, 'Frank', 'Aelbrecht', 'ror0706641@student.thomasmore.be', '', '', '$2y$12$AVJ6pTADce/OeCgS1bHH/OiWV3PTJUtxgcNH.KEFRbGNtXEMZPD9a', '', '', '', '', '', 2),
(12, 'Fredyy', 'Aelbrecht', 'lowie@student.thomasmore.be', '', '', '$2y$12$BOcUSCdhzGUVC7ai7IwVJuJsztO4aIw/tY0DN/6l0L3ZVDA5lwo2S', '', '', '', '', '', 1),
(13, 'Jefke', 'Aelbrecht', 'aelbrecht@student.thomasmore.be', 'hallo', 'uploads/1585333212BACKGROUND.jpg', '$2y$12$VKz30nRbk4otBzVAV4RgqOpkb/3nA/Uw6UHB4DvkPHg3.PWurIMfa', 'Bornem', '[\"inputBackendDevelopment\"]', '1 IMD', 'Waterrat', 'Party animal', 4),
(16, 'Lowie', 'Aelbrecht', 'aelbrecht.lowie@student.thomasmore.be', '', '', '$2y$12$OYuriu4pQofTzZOvblVYv.0AA9IoUNrq8Pxt.6YnqOEXYna2AsNrm', '', '', '', '', '', NULL),
(17, 'Lowie', 'Aelbrecht', 'aelbrechtlowie@student.thomasmore.be', '', '', '$2y$12$lkLrjdsh6SKHnAV3TKEhEOSBq4DCmfW4HUMABZ/4i9xPfagQJ9C7u', '', '', '', '', '', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tl_user`
--
ALTER TABLE `tl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tl_user`
--
ALTER TABLE `tl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
