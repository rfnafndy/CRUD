-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2024 at 05:42 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `musicians`
--

-- --------------------------------------------------------

--
-- Table structure for table `artist`
--

CREATE TABLE `artist` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `stage_name` varchar(255) DEFAULT NULL,
  `origin` varchar(255) DEFAULT NULL,
  `genre` varchar(255) DEFAULT NULL,
  `active_since` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artist`
--

INSERT INTO `artist` (`id`, `name`, `stage_name`, `origin`, `genre`, `active_since`) VALUES
(4, 'John Clayton Mayer', 'John Mayer', 'America', 'Blues', '1998'),
(5, 'Roberth nesta Marley', 'Bob Marley', 'America', 'Reggae', '1962 – 1981'),
(7, 'Francis Albert Sinatra', 'Frank Sinatra', 'America', 'Jazz', '1935–1995'),
(8, 'Eric Patrick Clapton', 'Eric Clapton', 'England', 'Blues', '1963'),
(9, 'John Winston Lennon', 'John Lennon', 'England', 'Rock', '1956–1980'),
(10, 'Henry John Deutschendorf Junior', 'John Danver', 'America', 'Country', '1962 - 1997'),
(11, 'Kurt Donald Cobain', 'Kurt Cobain', 'America', 'Grunge', '1982 - 1994'),
(12, 'Corey Todd Taylor', 'Corey Taylor', 'America', 'Metal', '1992'),
(13, 'Michael Kenji Shinoda', 'Mike Shinoda', 'America', 'Hip Hop', '1994'),
(14, '	Toni Michelle Braxton', '	Toni Braxton', 'America', 'R & B', '1989'),
(15, 'Céline Marie Claudette Dion', 'Céline Dion', 'Kanada', 'Slow Rock', '1980'),
(16, 'David Walter Foster', 'David Foster', 'Kanada', 'Pop', '1971'),
(17, 'Madonna Louise Ciccone', 'Madonna', 'America', 'Pop', '1979');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artist`
--
ALTER TABLE `artist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artist`
--
ALTER TABLE `artist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
