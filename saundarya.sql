-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 10, 2016 at 11:25 PM
-- Server version: 5.7.12-0ubuntu1
-- PHP Version: 7.0.4-7ubuntu2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `saundarya`
--

-- --------------------------------------------------------

--
-- Table structure for table `beautician`
--

CREATE TABLE `beautician` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `pincode` int(10) NOT NULL,
  `mobileno` bigint(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `jobset` varchar(255) NOT NULL,
  `certification` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `beautician`
--

INSERT INTO `beautician` (`id`, `name`, `street`, `city`, `state`, `pincode`, `mobileno`, `email`, `jobset`, `certification`, `rating`) VALUES
(1, 'Neha Sharma', 'Suyash Heights, Plot No 36, Sector 18', 'Navi Mumbai', 'Maharashtra', 415263, 4585685956, 'neha@mail.com', 'threading', 'NA', 0),
(2, 'Khushi Garg', 'Suyash Heights, Plot No 36, Sector 18', 'Navi Mumbai', 'Maharashtra', 410210, 4585685956, 'khushi@mail.com', 'facial, spa, threading', 'NA', 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `pincode` int(10) NOT NULL,
  `mobileno` bigint(10) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `name`, `street`, `city`, `state`, `pincode`, `mobileno`, `email`) VALUES
(12, 'Manas', 'Glomax Mall, Kharghar', 'Navi Mumbai', 'Kharghar', 410210, 9322156568, 'manas@mail.com'),
(13, 'Bhramar', 'Central Park', 'Navi Mumbai', 'Maharashtra', 410210, 4758963325, 'bhramar@mail.com'),
(14, 'Abhishek Joshi', 'Kharghar Railway Station', 'Navi Mumbai', 'Maharashtra', 410210, 9057494483, 'abhi@mail.com'),
(18, 'Rishabh Mittar', 'Little World Mall, Kharghar', 'Navi Mumbai', 'Maharashtra', 410210, 9322156568, 'rishabh@mail.com'),
(21, 'Mohit Garg', 'Andheri Railway Station', 'Navi Mumbai', 'Maharashtra', 400053, 9057494483, 'mohitgarg68@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(25) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `password_hash`, `email`, `role`, `status`) VALUES
(12, 'manas123', '55d50b38628db9c493be776840f8470d', 'manas@mail.com', 'customer', '0'),
(13, 'bhramar123', '43d27c6989280d950712ddea4ab783e8', 'bhramar@mail.com', 'customer', ''),
(14, 'abhi', '167784d36ab99e49738fe6a6a98798b7', 'abhi@mail.com', 'customer', ''),
(19, 'neha.smart', '3fede54cd3cf786471ca20e4d40d9b8c', 'neha@mail.com', 'beautician', '0'),
(22, 'khushi.great', 'cae5161fc8156ab2de412ec4007a76e2', 'khushi@mail.com', 'beautician', '0'),
(23, 'rishabh', '40783d43271a642d22073ec883c4a3af', 'rishabh@mail.com', 'customer', '0'),
(26, 'mohit123', 'NA', 'mohitgarg68@gmail.com', 'customer', '0');

-- --------------------------------------------------------

--
-- Table structure for table `pendingrequests`
--

CREATE TABLE `pendingrequests` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `service` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pendingrequests`
--

INSERT INTO `pendingrequests` (`id`, `email`, `service`, `time`, `date`, `status`) VALUES
(2, 'rishabh@mail.com', 'facial', '3PM-4PM', '12-25-1997', 0),
(3, 'abhi@mail.com', 'facial', '2PM-3PM', '21-04-2016', 0),
(4, 'bhramar@mail.com', 'threading', '5PM-6PM', '17-07-2016', 0),
(5, 'mohitgarg68@gmail.com', 'facial', '7-8PM', '22-07-2016', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `beautician`
--
ALTER TABLE `beautician`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pendingrequests`
--
ALTER TABLE `pendingrequests`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `beautician`
--
ALTER TABLE `beautician`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `pendingrequests`
--
ALTER TABLE `pendingrequests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
