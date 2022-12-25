-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2022 at 07:02 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hr_workshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `dept`
--

CREATE TABLE `dept` (
  `dno` varchar(6) NOT NULL COMMENT 'ລະຫັດພະແນກ',
  `name` varchar(255) NOT NULL COMMENT 'ຊື່ພະແນກ',
  `loc` varchar(255) NOT NULL COMMENT 'ສະຖານທີ່',
  `incentive` decimal(7,0) NOT NULL COMMENT 'ເງິນອຸດໜູນ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dept`
--

INSERT INTO `dept` (`dno`, `name`, `loc`, `incentive`) VALUES
('CEIT', 'ພາກວິຊາ ວິສະວະກໍາຄອມພິວເຕີ ແລະ ເຕັກໂນໂລຊີຂໍ້ມູນຂ່າວສານ', 'ຕຶກ A', '200000'),
('TR', 'ພາກວິຊາ ວິສະວະກໍາຄົມມະນາຄົມ', 'ຕຶກ ຂ', '250000');

-- --------------------------------------------------------

--
-- Table structure for table `emp`
--

CREATE TABLE `emp` (
  `empno` varchar(6) NOT NULL COMMENT 'ລະຫັດພະນັກງານ',
  `name` varchar(25) NOT NULL COMMENT 'ຊື່ພະນັກງານ',
  `gender` char(1) NOT NULL COMMENT 'ເພດ',
  `dateOfBirth` date NOT NULL COMMENT 'ວັນ ເດືອນ ປີເກີດ',
  `address` varchar(255) NOT NULL COMMENT 'ທີ່ຢູ່',
  `incentive` decimal(7,0) DEFAULT NULL COMMENT 'ເງິນອຸດໜູນ',
  `language` varchar(255) DEFAULT NULL COMMENT 'ພາສາຕ່າງປະເທດ',
  `picture` varchar(50) NOT NULL COMMENT 'ຮູບພະນັກງານ',
  `grade` varchar(3) DEFAULT NULL COMMENT 'ຂັ້ນເງິນເດືອນ salary(grade)',
  `dno` varchar(6) NOT NULL COMMENT 'ລະຫັດພະແນກ dept(dno)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `emp`
--

INSERT INTO `emp` (`empno`, `name`, `gender`, `dateOfBirth`, `address`, `incentive`, `language`, `picture`, `grade`, `dno`) VALUES
('EMP001', 'ສຸກສະຫວັນ', 'ຊ', '1981-08-29', 'ວຽກຈັນ', '250000', 'ອັງກິດ', '1643461951picture2.jpg', 'A03', 'TR'),
('EMP002', 'ພອນປະເສີດ ສີໃສແກ້ວ', 'ຊ', '1995-01-05', 'ຈັນທະບູລີ<br />\r\nນະຄອນຫຼວງວຽງຈັນ', '200000', 'ອັງກິດ,ຈີນ,ຫວຽດນາມ', '1643339006picture2.jpg', 'A02', 'CEIT'),
('EMP003', 'ສັກດາ', 'ຊ', '1998-01-19', 'ກກກກກ', '250000', 'ອັງກິດ,ອື່ນໆ...', '1643345238picture2.jpg', 'A03', 'CEIT');

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE `salary` (
  `grade` varchar(3) NOT NULL COMMENT 'ຂັ້ນເງິນເດືອນ',
  `salary` decimal(10,0) NOT NULL COMMENT 'ເງິນເດືອນ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `salary`
--

INSERT INTO `salary` (`grade`, `salary`) VALUES
('A01', '1200000'),
('A02', '15000000'),
('A03', '2000000');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL COMMENT 'ລະຫັດບັນຊີເຂົ້າໃຊ້',
  `name` varchar(25) NOT NULL COMMENT 'ຊື່',
  `tel` varchar(15) NOT NULL COMMENT 'ເບີໂທ',
  `username` varchar(25) NOT NULL COMMENT 'ບັນຊີເຂົ້າໃຊ້',
  `password` varchar(32) NOT NULL COMMENT 'ລະຫັດຜ່ານ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `tel`, `username`, `password`) VALUES
(2, 'souk', '9999999', 'souk', '81dc9bdb52d04dc20036dbd8313ed055'),
(3, 'ສຸກສະຫວັນ', '96887222', 'admin', '81dc9bdb52d04dc20036dbd8313ed055');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dept`
--
ALTER TABLE `dept`
  ADD PRIMARY KEY (`dno`);

--
-- Indexes for table `emp`
--
ALTER TABLE `emp`
  ADD PRIMARY KEY (`empno`),
  ADD KEY `grade` (`grade`),
  ADD KEY `dno` (`dno`);

--
-- Indexes for table `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`grade`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດບັນຊີເຂົ້າໃຊ້', AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `emp`
--
ALTER TABLE `emp`
  ADD CONSTRAINT `emp_ibfk_1` FOREIGN KEY (`grade`) REFERENCES `salary` (`grade`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `emp_ibfk_2` FOREIGN KEY (`dno`) REFERENCES `dept` (`dno`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
