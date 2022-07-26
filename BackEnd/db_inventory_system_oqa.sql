-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2022 at 06:55 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_inventory_system_oqa`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_opening_stock`
--

CREATE TABLE `tbl_opening_stock` (
  `op_id` int(11) NOT NULL,
  `item_code` varchar(45) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `item_price` decimal(11,2) NOT NULL,
  `item_units` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sales_out`
--

CREATE TABLE `tbl_sales_out` (
  `so_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `item_code` varchar(45) NOT NULL,
  `units` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stock_in`
--

CREATE TABLE `tbl_stock_in` (
  `si_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `item_code` varchar(45) NOT NULL,
  `units` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `uname` varchar(45) NOT NULL,
  `password` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `uname`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_auth`
--

CREATE TABLE `tbl_user_auth` (
  `user_auth_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expiration` timestamp NOT NULL DEFAULT current_timestamp(),
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user_auth`
--

INSERT INTO `tbl_user_auth` (`user_auth_id`, `user_id`, `token`, `expiration`, `time_stamp`) VALUES
(1, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoxfQ.WhwDib_q8hHNgSiKmMx0E7FfRKd_y997VOYu7ozVvo8', '2022-07-29 09:19:38', '2022-07-26 15:19:38'),
(2, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoxfQ.WhwDib_q8hHNgSiKmMx0E7FfRKd_y997VOYu7ozVvo8', '2022-07-29 09:29:01', '2022-07-26 15:29:01'),
(3, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoxfQ.WhwDib_q8hHNgSiKmMx0E7FfRKd_y997VOYu7ozVvo8', '2022-07-29 09:33:08', '2022-07-26 15:33:08'),
(4, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoxfQ.WhwDib_q8hHNgSiKmMx0E7FfRKd_y997VOYu7ozVvo8', '2022-07-29 09:50:54', '2022-07-26 15:50:54'),
(5, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoxfQ.WhwDib_q8hHNgSiKmMx0E7FfRKd_y997VOYu7ozVvo8', '2022-07-29 10:03:16', '2022-07-26 16:03:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_opening_stock`
--
ALTER TABLE `tbl_opening_stock`
  ADD PRIMARY KEY (`op_id`),
  ADD UNIQUE KEY `item_code` (`item_code`);

--
-- Indexes for table `tbl_sales_out`
--
ALTER TABLE `tbl_sales_out`
  ADD PRIMARY KEY (`so_id`);

--
-- Indexes for table `tbl_stock_in`
--
ALTER TABLE `tbl_stock_in`
  ADD PRIMARY KEY (`si_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `uname` (`uname`);

--
-- Indexes for table `tbl_user_auth`
--
ALTER TABLE `tbl_user_auth`
  ADD PRIMARY KEY (`user_auth_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_opening_stock`
--
ALTER TABLE `tbl_opening_stock`
  MODIFY `op_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_sales_out`
--
ALTER TABLE `tbl_sales_out`
  MODIFY `so_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_stock_in`
--
ALTER TABLE `tbl_stock_in`
  MODIFY `si_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_user_auth`
--
ALTER TABLE `tbl_user_auth`
  MODIFY `user_auth_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
