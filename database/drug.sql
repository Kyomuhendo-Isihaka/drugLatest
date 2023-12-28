-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2023 at 09:21 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `drug`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL DEFAULT 'admin',
  `avatar` varchar(255) NOT NULL DEFAULT 'avatar.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `fname`, `lname`, `email`, `phone`, `password`, `role`, `avatar`) VALUES
(2, 'Kyomuhendo', 'Isihaka', 'isihaka@gmail.com', '0761715368', '$2y$10$gB/YVM.0I8Y2Ccg22hetyubrj59MtKXQgjlSvqDyJnr9nsMG.2MRu', 'admin', 'images.png');

-- --------------------------------------------------------

--
-- Table structure for table `drugs`
--

CREATE TABLE `drugs` (
  `id` int(11) NOT NULL,
  `batch_num` varchar(100) NOT NULL,
  `drug_name` varchar(255) NOT NULL,
  `drug_description` varchar(255) NOT NULL,
  `drug_price` float NOT NULL,
  `drug_quantity` varchar(100) NOT NULL,
  `manufacturing_date` text NOT NULL,
  `expiry_date` text NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `drugs`
--

INSERT INTO `drugs` (`id`, `batch_num`, `drug_name`, `drug_description`, `drug_price`, `drug_quantity`, `manufacturing_date`, `expiry_date`, `status`) VALUES
(5, '11321', 'Drug Five', 'Fifth Drug', 1000, '20', '2023-08-14', '2024-08-26', '1'),
(7, '78897', 'Drug nine', 'Ninth Drug', 2500, '74', '2023-08-15', '2024-10-01', '1'),
(13, '40952', 'Drug four', 'Fourth drug', 2000, '234', '2023-09-01', '2023-10-19', '-1'),
(14, '10417', 'Drug Four', 'Fourth drug', 3000, '123', '2023-09-08', '2023-11-04', '0'),
(15, '40952', 'Drug eight', 'Fifth Drug', 43000, '230', '2023-08-18', '2024-09-08', '1'),
(16, '10417', 'Panado', 'Paracentamal', 4000, '30', '2023-09-01', '2024-10-12', '1');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacists`
--

CREATE TABLE `pharmacists` (
  `id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL DEFAULT 'pharmacist',
  `avatar` varchar(100) NOT NULL DEFAULT 'avatar.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pharmacists`
--

INSERT INTO `pharmacists` (`id`, `fname`, `lname`, `email`, `phone`, `password`, `role`, `avatar`) VALUES
(5, 'isihaka', 'Kyomuhendo', 'isihaka@gmail.com', '0778263738', '$2y$10$FD/1EKU1Doo4EtOnutqQxOCRLIxzNeerYNYg/gzWPK3Bhyks.jjci', 'pharmacist', 'avatar.png');

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE `sale` (
  `id` int(11) NOT NULL,
  `salesman_id` text NOT NULL,
  `drug_id` text NOT NULL,
  `quantity_sold` float NOT NULL,
  `total_price` float NOT NULL,
  `time_sold` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sale`
--

INSERT INTO `sale` (`id`, `salesman_id`, `drug_id`, `quantity_sold`, `total_price`, `time_sold`) VALUES
(1, '16', '7', 2, 5000, '2023-12-28'),
(2, '16', '7', 2, 5000, '2023-12-28'),
(3, '16', '5', 5, 5000, '2023-12-28'),
(4, '17', '15', 4, 172000, '2023-12-28');

-- --------------------------------------------------------

--
-- Table structure for table `salesmans`
--

CREATE TABLE `salesmans` (
  `id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `title` text NOT NULL,
  `role` varchar(100) NOT NULL DEFAULT 'salesman',
  `avatar` varchar(255) NOT NULL DEFAULT 'avatar.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `salesmans`
--

INSERT INTO `salesmans` (`id`, `fname`, `lname`, `email`, `phone`, `password`, `title`, `role`, `avatar`) VALUES
(16, 'isihaka', 'isihaka', 'isihaka@gmail.com', '0778237748', '$2y$10$encvf3bVoV4tBx1NG9dErOXLDUZsVQ6Y1qGIyzvXWdAxmXHY9G/Du', 'Nurse', 'salesman', 'avatar.png'),
(17, 'Aisha', 'Kabako', 'aisha@gmail.com', '0775473827', '$2y$10$01.PkW9L80YOBFuMlG5IiuC7yQ3LOid2IZ/tRmIQIMY/qxboSF7Ca', 'Principle Nursing Officer', 'salesman', 'avatar.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drugs`
--
ALTER TABLE `drugs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pharmacists`
--
ALTER TABLE `pharmacists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salesmans`
--
ALTER TABLE `salesmans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `drugs`
--
ALTER TABLE `drugs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pharmacists`
--
ALTER TABLE `pharmacists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `salesmans`
--
ALTER TABLE `salesmans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
