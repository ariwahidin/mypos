-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2023 at 04:05 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mypos`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`prg`@`%` PROCEDURE `select_item` (IN `input_item_code` VARCHAR(255))  begin

	select * from p_item where item_code = input_item_code;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `gender` enum('L','P') NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `name`, `gender`, `phone`, `address`, `created`, `updated`) VALUES
(1, 'Sindi A', 'P', '084343434', 'Juwana', '2019-04-13 21:36:41', '2019-04-13 22:57:35'),
(3, 'Tono', 'L', '089232323', 'Pati', '2019-04-13 21:43:14', NULL),
(5, 'Idwan Hadi', 'L', '0342232323', 'Kudus\r\n', '2019-04-13 22:57:28', '2019-04-13 22:58:37'),
(6, 'Anton', 'L', '0813434344', 'Kudus', '2019-04-13 22:57:49', NULL),
(7, 'Ana', 'P', '082332932', 'Kediri', '2019-04-13 22:58:07', NULL),
(8, 'Raka', 'L', '083483449', 'Pati', '2019-04-13 22:58:31', NULL),
(9, 'Purnomo', 'L', '08734347734', 'Jogjakarta', '2019-04-13 22:58:55', NULL),
(10, 'Zahier', 'L', '601300808888', 'Malaysia', '2019-04-13 22:59:49', '2019-04-13 23:00:00'),
(11, 'Syafi''i', 'L', '08232323', 'Kudus', '2019-04-13 23:00:21', NULL),
(12, 'Ahmad Masruri', 'L', '08943444372', 'Pati', '2019-04-13 23:00:37', NULL),
(13, 'Ifan Fadillah', 'L', '087778444422', 'Kudus', '2019-04-13 23:00:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `master_gudang`
--

CREATE TABLE `master_gudang` (
  `id` int(11) NOT NULL,
  `whs_code` varchar(255) DEFAULT NULL,
  `whs_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `master_gudang`
--

INSERT INTO `master_gudang` (`id`, `whs_code`, `whs_name`) VALUES
(1, 'WH06.07', 'DG Chocolate Gallery Kelapa Gading'),
(2, 'WH06.01', 'DG Chocolate Gallery Aeon BSD'),
(3, 'WH06.02', 'DG Chocolate Gallery Alam Sutera'),
(4, 'WH06.03', 'DG Chocolate Gallery Bay Walk'),
(5, 'WH06.04', 'DG Chocolate Gallery Central Park'),
(6, 'WH06.05', 'DG Chocolate Gallery Emporium'),
(7, 'WH06.06', 'DG Chocolate Gallery Gandaria City'),
(8, 'WH06.08', 'DG Chocolate Gallery Kota Kasablanka '),
(9, 'WH06.09', 'DG Chocolate Gallery Pondok Indah 1'),
(10, 'WH06.10', 'DG Chocolate Gallery Lippo Mall Puri'),
(11, 'WH06.11', 'DG Chocolate Gallery Senayan City');

-- --------------------------------------------------------

--
-- Table structure for table `p_category`
--

CREATE TABLE `p_category` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `p_category`
--

INSERT INTO `p_category` (`category_id`, `name`, `created`, `updated`) VALUES
(15, 'groceries', '2022-12-05 15:22:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `p_item`
--

CREATE TABLE `p_item` (
  `item_id` int(11) NOT NULL,
  `item_code` varchar(100) NOT NULL,
  `barcode` varchar(100) DEFAULT NULL,
  `name` text,
  `min_stock` float DEFAULT NULL,
  `item_name_toko` text,
  `item_name_sap` text,
  `packing` text,
  `category_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `price` float DEFAULT NULL,
  `harga_jual` float DEFAULT NULL,
  `harga_bersih` float DEFAULT NULL,
  `exp_date` date DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL,
  `updated_info` text,
  `created_by` varchar(50) DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `p_item`
--

INSERT INTO `p_item` (`item_id`, `item_code`, `barcode`, `name`, `min_stock`, `item_name_toko`, `item_name_sap`, `packing`, `category_id`, `unit_id`, `price`, `harga_jual`, `harga_bersih`, `exp_date`, `image`, `created`, `updated`, `updated_info`, `created_by`, `updated_by`) VALUES
(4331, 'ALB0100', '9311766000007', 'ALB - Mozzarella 250 g # 12 x 250 g', 15, 'ALB - Mozzarella 250 g # 12 x 250 g', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4332, 'ALB0110', '9311766000014', 'ALB - Mozzarella 500 g # 12 x 500 g', 15, 'ALB - Mozzarella 500 g # 12 x 500 g', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4333, 'AMS0100', '6936756230580', 'AMS - 4D Gummy Block 40g # 8 x 12 x 40g', 15, 'AMS - 4D Gummy Block 40g # 8 x 12 x 40g', NULL, '', 15, 5, 8577, 8577, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4334, 'AMS0200', '6936756230603', 'AMS - 4D Gummy Block 72g # 36 x 72g', 15, 'AMS - 4D Gummy Block 72g # 36 x 72g', NULL, '', 15, 5, 15136, 15136, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4335, 'ASF0130', '6281073210181', 'ASF - Natural Honey # 12 x 500 g', 15, 'ASF - Natural Honey # 12 x 500 g', NULL, '', 15, 5, 114000, 114000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4336, 'ASF01A0', '6281073210198', 'ASF - Natural Honey 500g+125g 1Pc # 12 x 625 Pcs', 15, 'ASF - Natural Honey 500g+125g 1Pc # 12 x 625 Pcs', NULL, '', 15, 5, 105000, 105000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4337, 'BCF0200', '8888089990502', 'BCF - Colombiana Instant Coffee (Merah) 50g # 12 x 50g', 15, 'BCF - Colombiana Instant Coffee (Merah) 50g # 12 x 50g', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4338, 'BCF0210', '8888089991004', 'BCF - Colombiana Instant Coffee (Merah) 100g # 12 x 100g', 15, 'BCF - Colombiana Instant Coffee (Merah) 100g # 12 x 100g', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4339, 'CAO0100', '7612100113110', 'CAO - Caotina Original 200 g # 6 x 200 g', 15, 'CAO - Caotina Original 200 g # 6 x 200 g', NULL, '', 15, 5, 83755, 83755, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4340, 'CAO0110', '7612100019184', 'CAO - Caotina Original 500 g # 6 x 500 g', 15, 'CAO - Caotina Original 500 g # 6 x 500 g', NULL, '', 15, 5, 160445, 160445, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4341, 'CAO0120', '7612100055519', 'CAO - Caotina Noir 500 g # 6 x 500 g', 15, 'CAO - Caotina Noir 500 g # 6 x 500 g', NULL, '', 15, 5, 185168, 185168, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4342, 'CAO0130', '7612100055496', 'CAO - Caotina Blanc 500 g # 6 x 500 g', 15, 'CAO - Caotina Blanc 500 g # 6 x 500 g', NULL, '', 15, 5, 185168, 185168, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4343, 'CAO0140', '7612100800621', 'CAO - Chocolate Spread 300 g # 6 x 300 g', 15, 'CAO - Chocolate Spread 300 g # 6 x 300 g', NULL, '', 15, 5, 88800, 88800, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4344, 'CAV0100', '5413623900032', 'CAV - Cavalier Bar Milk 44 g # 10 X 16 X 44 g', 15, 'CAV - Cavalier Bar Milk 44 g # 10 X 16 X 44 g', NULL, '', 15, 5, 31282, 31282, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4345, 'CAV0111', '5413623900025', 'CAV - Cavalier Bar Dark 44 g # 10 X 16 X 44 g', 15, 'CAV - Cavalier Bar Dark 44 g # 10 X 16 X 44 g', NULL, '', 15, 5, 31282, 31282, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4346, 'CAV0120', '5413623900063', 'CAV - Cavalier Bar Milk Pralinut 42 g # 10 X 16 X 42 g', 15, 'CAV - Cavalier Bar Milk Pralinut 42 g # 10 X 16 X 42 g', NULL, '', 15, 5, 31282, 31282, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4347, 'CAV0130', '5413623101002', 'CAV - Cavalier Tablet Milk 85 g # 6 X 14 X 85 g', 15, 'CAV - Cavalier Tablet Milk 85 g # 6 X 14 X 85 g', NULL, '', 15, 5, 58527, 58527, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4348, 'CAV0140', '5413623301006', 'CAV - Cavalier Tablet Dark 85 g # 6 X 14 X 85 g', 15, 'CAV - Cavalier Tablet Dark 85 g # 6 X 14 X 85 g', NULL, '', 15, 5, 58527, 58527, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4349, 'CAV0151', '5413623201009', 'CAV - Cavalier Tablet M Hazelnut 85 g # 6 X 14 X 85 g', 15, 'CAV - Cavalier Tablet M Hazelnut 85 g # 6 X 14 X 85 g', NULL, '', 15, 5, 58527, 58527, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4350, 'CAV0160', '5413623850047', 'CAV - Cavalier Tablet White 85 g # 6 X 14 X 85 g', 15, 'CAV - Cavalier Tablet White 85 g # 6 X 14 X 85 g', NULL, '', 15, 5, 58527, 58527, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4351, 'CCO0300', '8997011630871', 'CCO - Bali Ass gift Pack # 24 x 170 g', 15, 'CCO - Bali Ass gift Pack # 24 x 170 g', NULL, '', 15, 5, 86277, 86277, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4352, 'CCO0310', '8997011630888', 'CCO - Borobudur Almond gift Pack # 24 x 170 g', 15, 'CCO - Borobudur Almond gift Pack # 24 x 170 g', NULL, '', 15, 5, 86355, 86355, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4353, 'CCO0320', '8997011631823', 'CCO - Wayang Kulit Nakula 170 g # 1 x 24 x 170 g', 15, 'CCO - Wayang Kulit Nakula 170 g # 1 x 24 x 170 g', NULL, '', 15, 5, 86277, 86277, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4354, 'CCO0330', '8997011631830', 'CCO - Wayang Kulit Bima 170 g # 1 x 24 x 170 g', 15, 'CCO - Wayang Kulit Bima 170 g # 1 x 24 x 170 g', NULL, '', 15, 5, 86277, 86277, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4355, 'CCO0340', '8997011631816', 'CCO - Wayang Kulit Arjuna Ass 170 g # 1 x 24 x 170 g', 15, 'CCO - Wayang Kulit Arjuna Ass 170 g # 1 x 24 x 170 g', NULL, '', 15, 5, 86277, 86277, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4356, 'CCO0350', '8997011631809', 'CCO - Wayang Kulit Yudhistira Ass 170 g # 1 x 24 x 170 g', 15, 'CCO - Wayang Kulit Yudhistira Ass 170 g # 1 x 24 x 170 g', NULL, '', 15, 5, 86277, 86277, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4357, 'CCO0380', '8997011631229', 'CCO - Bali 3Dancers Gift Pack # 24 x 170 g', 15, 'CCO - Bali 3Dancers Gift Pack # 24 x 170 g', NULL, '', 15, 5, 90314, 90314, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4358, 'CCO0390', '8997011631212', 'CCO - Bali Lion Head Gift Pack # 24 x 170 g', 15, 'CCO - Bali Lion Head Gift Pack # 24 x 170 g', NULL, '', 15, 5, 90314, 90314, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4359, 'CCO03A0', '8997011631236', 'CCO - Beautiful Indonesia Asst # 24 x 170 g', 15, 'CCO - Beautiful Indonesia Asst # 24 x 170 g', NULL, '', 15, 5, 90314, 90314, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4360, 'CCO0400', '8997011630314', 'CCO - Hazelnut w/ Rice Cereal  # 24 x 135 g', 15, 'CCO - Hazelnut w/ Rice Cereal  # 24 x 135 g', NULL, '', 15, 5, 83250, 83250, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4361, 'CCO0410', '8997011630284', 'CCO - Almond w/ Rice Cereal # 24 x 135 g', 15, 'CCO - Almond w/ Rice Cereal # 24 x 135 g', NULL, '', 15, 5, 83250, 83250, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4362, 'CCO0420', '8997011630253', 'CCO - Milk Choco w/ Rice Cereal # 24 x 135 g', 15, 'CCO - Milk Choco w/ Rice Cereal # 24 x 135 g', NULL, '', 15, 5, 83250, 83250, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4363, 'CCO0430', '8997011630321', 'CCO - Cylinder Jar Hazelnut  # 24 x 262.5 g', 15, 'CCO - Cylinder Jar Hazelnut  # 24 x 262.5 g', NULL, '', 15, 5, 71645, 71645, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4364, 'CCO0440', '8997011630291', 'CCO - Cylinder Jar Almond  # 24 x 262.5 g', 15, 'CCO - Cylinder Jar Almond  # 24 x 262.5 g', NULL, '', 15, 5, 71645, 71645, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4365, 'CCO0450', '8997011630260', 'CCO - Cylinder Jar Milk Chocolat # 24 x 262.5 g', 15, 'CCO - Cylinder Jar Milk Chocolat # 24 x 262.5 g', NULL, '', 15, 5, 71645, 71645, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4366, 'CCO0460', '8997011630338', 'CCO - Square Jar Hazelnut # 18 x 525 g', 15, 'CCO - Square Jar Hazelnut # 18 x 525 g', NULL, '', 15, 5, 115036, 115036, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4367, 'CCO0470', '8997011630307', 'CCO - Square Jar Almond # 18 x 525 g', 15, 'CCO - Square Jar Almond # 18 x 525 g', NULL, '', 15, 5, 115036, 115036, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4368, 'CCO0480', '8997011630277', 'CCO - Square Jar Milk Chocolate # 18 x 525 g', 15, 'CCO - Square Jar Milk Chocolate # 18 x 525 g', NULL, '', 15, 5, 115036, 115036, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4369, 'CCO0500', '8997011630017', 'CCO - Milk Bar 50 g # 12 x 20 x 50 g', 15, 'CCO - Milk Bar 50 g # 12 x 20 x 50 g', NULL, '', 15, 5, 11100, 11100, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4370, 'CCO0510', '8997011630024', 'CCO - Milk Bar 100 g # 12 x 10 x 100 g', 15, 'CCO - Milk Bar 100 g # 12 x 10 x 100 g', NULL, '', 15, 5, 20182, 20182, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4371, 'CCO0520', '8997011630031', 'CCO - Milk Bar 200 g # 6 x 10 x 200 g', 15, 'CCO - Milk Bar 200 g # 6 x 10 x 200 g', NULL, '', 15, 5, 38850, 38850, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4372, 'CCO0530', '8997011630079', 'CCO - Almond Bar 50 g # 12 x 20 x 50 g', 15, 'CCO - Almond Bar 50 g # 12 x 20 x 50 g', NULL, '', 15, 5, 11605, 11605, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4373, 'CCO0540', '8997011630086', 'CCO - Almond Bar 100 g # 12 x 10 x 100 g', 15, 'CCO - Almond Bar 100 g # 12 x 10 x 100 g', NULL, '', 15, 5, 22200, 22200, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4374, 'CCO0550', '8997011630093', 'CCO - Almond Bar 200 g # 6 x 10 x 200 g', 15, 'CCO - Almond Bar 200 g # 6 x 10 x 200 g', NULL, '', 15, 5, 40868, 40868, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4375, 'CCO0560', '8997011630109', 'CCO - Fruit and Nut Bar 50 g # 12 x 20 x 50 g', 15, 'CCO - Fruit and Nut Bar 50 g # 12 x 20 x 50 g', NULL, '', 15, 5, 11605, 11605, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4376, 'CCO0570', '8997011630116', 'CCO - Fruit and Nut Bar 100 g # 12 x 10 x 100 g', 15, 'CCO - Fruit and Nut Bar 100 g # 12 x 10 x 100 g', NULL, '', 15, 5, 22200, 22200, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4377, 'CCO0580', '8997011630123', 'CCO - Fruit and Nut Bar 200 g # 6 x 10 x 200 g', 15, 'CCO - Fruit and Nut Bar 200 g # 6 x 10 x 200 g', NULL, '', 15, 5, 40868, 40868, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4378, 'CCO0590', '8997011630048', 'CCO - Hazelnut Bar 50 g # 12 x 20 x 50 g', 15, 'CCO - Hazelnut Bar 50 g # 12 x 20 x 50 g', NULL, '', 15, 5, 11605, 11605, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4379, 'CCO05A0', '8997011630055', 'CCO - Hazelnut Bar 100 g # 12 x 10 x 100 g', 15, 'CCO - Hazelnut Bar 100 g # 12 x 10 x 100 g', NULL, '', 15, 5, 22200, 22200, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4380, 'CCO05B0', '8997011630062', 'CCO - Hazelnut Bar 200 g # 6 x 10 x 200 g', 15, 'CCO - Hazelnut Bar 200 g # 6 x 10 x 200 g', NULL, '', 15, 5, 40868, 40868, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4381, 'CLN0100', '8992919141405', 'CLN - Collin''s Butter Nut 48g # 20 (15 x 3.2)', NULL, 'CLN - Collin''s Butter Nut 48g ', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4382, 'CRM0160', '9319133338012', 'CRM - Deluxe  Gluten Free 400 g # 6 x 400 g', 15, 'CRM - Deluxe  Gluten Free 400 g # 6 x 400 g', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4383, 'DCG0100', '00004', 'FA-Large Canopy Toys', 15, 'FA-Large Canopy Toys', NULL, '', 15, 5, 475000, 475000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4384, 'DCG0200', '0022', 'FA-Roadster Car-Green', 15, 'FA-Roadster Car-Green', NULL, '', 15, 5, 110000, 110000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4385, 'DCG0300', '00330006', 'FA-Mug w/Animal CharacterHandl', 15, 'FA-Mug w/Animal CharacterHandl', NULL, '', 15, 5, 152500, 152500, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4386, 'DCG0400', '0049', 'FA-Embassed Pasta & Sphagetty ', 15, 'FA-Embassed Pasta & Sphagetty ', NULL, '', 15, 5, 395000, 395000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4387, 'DCG0500', '1509200831029', 'FA-Parcel Type B', 15, 'FA-Parcel Type B', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4388, 'DCG0600', '1509200831036', 'FA-Parcel Type D', 15, 'FA-Parcel Type D', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4389, 'DCG0700', '38011955', 'LDT-W/Teddy Bear Big Mix Valen', 15, 'LDT-W/Teddy Bear Big Mix Valen', NULL, '', 15, 5, 215000, 215000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4390, 'DCG0800', '2008313600052', 'FA-Paper Bag (L)', 15, 'FA-Paper Bag (L)', NULL, '', 15, 5, 50000, 50000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4391, 'DCG0900', '2008313600076', 'FA-Paper Bag (S)', 15, 'FA-Paper Bag (S)', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4392, 'DCG1000', '2008313600083', 'FA-Paper Bag (M)', 15, 'FA-Paper Bag (M)', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4393, 'DCG1100', '38000255', 'FA-Teddy In Bath', 15, 'FA-Teddy In Bath', NULL, '', 15, 5, 120000, 120000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4394, 'DCG1200', '38000300', 'FA-Large Canopy Grocer', 15, 'FA-Large Canopy Grocer', NULL, '', 15, 5, 475000, 475000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4395, 'DCG1300', '38000317', 'FA-Large Canopy Bakery', 15, 'FA-Large Canopy Bakery', NULL, '', 15, 5, 475000, 475000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4396, 'DCG1400', '38000331', 'FA-Winter Canopy Cookies', 15, 'FA-Winter Canopy Cookies', NULL, '', 15, 5, 173500, 173500, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4397, 'DCG1500', '38000768', 'Box Teddy Bear W/Handle (S)', 15, 'Box Teddy Bear W/Handle (S)', NULL, '', 15, 5, 90900, 90900, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4398, 'DCG1600', '38001048', 'FA-Brown Basket W/ Handle (S)', 15, 'FA-Brown Basket W/ Handle (S)', NULL, '', 15, 5, 90900, 90900, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4399, 'DCG1700', '38001055', 'FA-Brown Basket W/ Handle (M)', 15, 'FA-Brown Basket W/ Handle (M)', NULL, '', 15, 5, 121200, 121200, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4400, 'DCG1800', '38001727', 'FA-Kereta Salju Besar', 15, 'FA-Kereta Salju Besar', NULL, '', 15, 5, 227249, 227249, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4401, 'DCG1900', '38003134', 'FA-Terry Box Chef Medium 5426 ', 15, 'FA-Terry Box Chef Medium 5426 ', NULL, '', 15, 5, 110000, 110000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4402, 'DCG2000', '38003158', 'FA-Ugly Cute Boy Medium 5554', 15, 'FA-Ugly Cute Boy Medium 5554', NULL, '', 15, 5, 110000, 110000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4403, 'DCG2100', '38003172', 'FA-Ugly Cute Boy Birthday 5563', 15, 'FA-Ugly Cute Boy Birthday 5563', NULL, '', 15, 5, 110000, 110000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4404, 'DCG2200', '38003189', 'FA-Ugly Cute Girl Birthday5564', 15, 'FA-Ugly Cute Girl Birthday5564', NULL, '', 15, 5, 110000, 110000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4405, 'DCG2300', '38003219', 'FA-Bull Medium Jar 5430', 15, 'FA-Bull Medium Jar 5430', NULL, '', 15, 5, 110000, 110000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4406, 'DCG2400', '38003226', 'FA-Cow Medium Jar 5432', 15, 'FA-Cow Medium Jar 5432', NULL, '', 15, 5, 110000, 110000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4407, 'DCG2500', '38003240', 'FA-Tiger Medium Jar 5550', 15, 'FA-Tiger Medium Jar 5550', NULL, '', 15, 5, 110000, 110000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4408, 'DCG2600', '38003257', 'FA-Dwarf Medium Jar 5670', 15, 'FA-Dwarf Medium Jar 5670', NULL, '', 15, 5, 110000, 110000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4409, 'DCG2700', '38003301', 'FA-Layer Pandan Box', 15, 'FA-Layer Pandan Box', NULL, '', 15, 5, 187000, 187000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4410, 'DCG2800', '38003363', 'FA-Chicken Medium Jar w/Choc', 15, 'FA-Chicken Medium Jar w/Choc', NULL, '', 15, 5, 110000, 110000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4411, 'DCG2900', '38003417', 'FA-Frog Medium Jar with Choco', 15, 'FA-Frog Medium Jar with Choco', NULL, '', 15, 5, 110000, 110000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4412, 'DCG3000', '38003523', 'FA-Maize Basket Mocca 0274 (L)', 15, 'FA-Maize Basket Mocca 0274 (L)', NULL, '', 15, 5, 210000, 210000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4413, 'DCG3100', '38003530', 'FA-Maize Basket Mocca 0274 (M)', 15, 'FA-Maize Basket Mocca 0274 (M)', NULL, '', 15, 5, 189000, 189000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4414, 'DCG3200', '38003547', 'FA-Maize Basket Mocca 0274 (S)', 15, 'FA-Maize Basket Mocca 0274 (S)', NULL, '', 15, 5, 157500, 157500, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4415, 'DCG3300', '38006081', 'Pack - Keranjang Majalah Imlek', 15, 'Pack - Keranjang Majalah Imlek', NULL, '', 15, 5, 165000, 165000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4416, 'DCG3700', '38008276', 'Pack- Keranjang Rutan Bulat', 15, 'Pack- Keranjang Rutan Bulat', NULL, '', 15, 5, 60600, 60600, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4417, 'DCG3800', '38008319', 'Pack - Box Kotak DG Coklat ', 15, 'Pack - Box Kotak DG Coklat ', NULL, '', 15, 5, 101000, 101000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4418, 'DCG4000', '38008405', 'Pack- Fa Happy Holiday Paper S', 15, 'Pack- Fa Happy Holiday Paper S', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4419, 'DCG4100', '38008412', 'Pack- Fa Happy Holiday Paper L', 15, 'Pack- Fa Happy Holiday Paper L', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4420, 'DCG4200', '38008474', 'Pack - Keranjang Kotak Kuping ', 15, 'Pack - Keranjang Kotak Kuping ', NULL, '', 15, 5, 121100, 121100, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4421, 'DCG4300', '38008481', 'Pack - Keranjang Rotan Besar ', 15, 'Pack - Keranjang Rotan Besar ', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4422, 'DCG4400', '38008665', 'Pack - Keranjang Tangkai 1 Pcs', 15, 'Pack - Keranjang Tangkai 1 Pcs', NULL, '', 15, 5, 160000, 160000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4423, 'DCG4500', '38009044', 'Pack - FA Lebaran Green Round ', 15, 'Pack - FA Lebaran Green Round ', NULL, '', 15, 5, 171600, 171600, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4424, 'DCG4600', '38010514', 'Pack- Box Christmas Long', 15, 'Pack- Box Christmas Long', NULL, '', 15, 5, 80800, 80800, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4425, 'DCG4700', '38010873', 'Pack-FA Baki Gelombang Natal S', 15, 'Pack-FA Baki Gelombang Natal S', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4426, 'DCG4800', '38010958', 'Pack-keranjang Tangkai Saley K', 15, 'Pack-keranjang Tangkai Saley K', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4427, 'DCG4900', '38010965', 'Pack-Keranjang Sariman Kotak ', 15, 'Pack-Keranjang Sariman Kotak ', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4428, 'DCG5000', '38010972', 'Pack - Keranjang Santa', 15, 'Pack - Keranjang Santa', NULL, '', 15, 5, 227250, 227250, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4429, 'DCG5200', '4891034041048', 'Gift-Lindt Coffee Mug', 15, 'Gift-Lindt Coffee Mug', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4430, 'DCG5300', '7610062081065', 'Jura Waffer mini', 15, 'Jura Waffer mini', NULL, '', 15, 5, 55000, 55000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4431, 'DCG5400', '7610062092566', 'Mini Chocobeau ', 15, 'Mini Chocobeau ', NULL, '', 15, 5, 105000, 105000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4432, 'DCG5500', '7610400030632', 'Lindor Cornet White 200 g', 15, 'Lindor Cornet White 200 g', NULL, '', 15, 5, 155400, 155400, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4433, 'DCG5600', '7610400936521', 'LDT-SURFIN BULK', 15, 'LDT-SURFIN BULK', NULL, '', 15, 5, 83250, 83250, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4434, 'DCG5700', '7610400988889', 'Lindor White Gift Box', 15, 'Lindor White Gift Box', NULL, '', 15, 5, 165491, 165491, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4435, 'DCG5800', '8000000780003', 'FA-Pix Mix Chocolate 1', 15, 'FA-Pix Mix Chocolate 1', NULL, '', 15, 5, 83250, 83250, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4436, 'DCG6000', '9403142002238', 'White Chocolate block 200 gr', 15, 'White Chocolate block 200 gr', NULL, '', 15, 5, 91827, 91827, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4437, 'DCG6100', '38011634', 'Pack-Keranjang Oval Rotan S', 15, 'Pack-Keranjang Oval Rotan S', NULL, '', 15, 5, 110000, 110000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4438, 'DCG6200', '38011641', 'Pack-keranjang Oval Rotan M', 15, 'Pack-keranjang Oval Rotan M', NULL, '', 15, 5, 150000, 150000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4439, 'DCG6400', '70177118495', 'TWN- Strawberry & Mango 50 gr', 15, 'TWN- Strawberry & Mango 50 gr', NULL, '', 15, 5, 79000, 79000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4440, 'DCG6500', '7610062211851', 'WNL- Pack Sleeve', 15, 'WNL- Pack Sleeve', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4441, 'DCG7100', '38008887', 'FA - kantor plastik coklat 1 pcs ', 15, 'FA - kantor plastik coklat 1 pcs ', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4442, 'ESP0210', '9311755200609', 'ESP - OLD STYLE LEMON LIME BITTE # 24 x 275 Ml', 15, 'ESP - OLD STYLE LEMON LIME BITTE # 24 x 275 Ml', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4443, 'ESP0220', '9349277000612', 'ESP - Classic Cola 275 ml # 24 x 275 ml', 15, 'ESP - Classic Cola 275 ml # 24 x 275 ml', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4444, 'ESP0230', '9311755200586', 'ESP - OLD STYLE GINGER BEER # 24 x 275 Ml', 15, 'ESP - OLD STYLE GINGER BEER # 24 x 275 Ml', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4445, 'FAM9710', '38000614', 'FA - Plastic Bag # 1 x 1 pcs', 15, 'FA - Plastic Bag # 1 x 1 pcs', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4446, 'FAM9760', '2008311300237', 'FA - Thermal Roll Paper # 1 x 1 pcs', 15, 'FA - Thermal Roll Paper # 1 x 1 pcs', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4447, 'FAM9800', '38006678', 'FA - Fa Hand glove 1 Pck # 1 x 1 Pck', 15, 'FA - Fa Hand glove 1 Pck # 1 x 1 Pck', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4448, 'FAM9830', '38006685', 'FA - Fa Plastik Opp 1 Pck # 1 x 1 Pck', 15, 'FA - Fa Plastik Opp 1 Pck # 1 x 1 Pck', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4449, 'FAM9860', '38006692', 'FA - Fa Solatip/Nachi Tape 1 Pc # 1 x 1 Pc', 15, 'FA - Fa Solatip/Nachi Tape 1 Pc # 1 x 1 Pc', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4450, 'FAM9900', '38008603', 'FA - Pack Christmas Box Large 1 Pcs # 1 x 1 Pcs', 15, 'FA - Pack Christmas Box Large 1 Pcs # 1 x 1 Pcs', NULL, '', 15, 5, 186700, 186700, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4451, 'FAM9910', '38008597', 'FA - Pack Christmas Box Medium 1 Pcs # 1 x 1 Pcs', 15, 'FA - Pack Christmas Box Medium 1 Pcs # 1 x 1 Pcs', NULL, '', 15, 5, 181700, 181700, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4452, 'FAM9920', '38008580', 'FA - Christmas Box Small 1 Pcs # 1 x 1 Pcs', 15, 'FA - Christmas Box Small 1 Pcs # 1 x 1 Pcs', NULL, '', 15, 5, 141300, 141300, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4453, 'GAL0150', '8001420003383', 'GAL - Base Mushroom # 5x1kg', 15, 'GAL - Base Mushroom # 5x1kg', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4454, 'GOL0100', '7610403072547', 'GOLD - Amarula #10(1x100g) # 10 x 1 x 100 g', 15, 'GOLD - Amarula #10(1x100g) # 10 x 1 x 100 g', NULL, '', 15, 5, 120082, 120082, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4455, 'GOL0110', '7610403072103', 'GOLD - Cointreau #10(1x100g) # 10 x 1 x 100 g', 15, 'GOLD - Cointreau #10(1x100g) # 10 x 1 x 100 g', NULL, '', 15, 5, 120082, 120082, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4456, 'GOL0120', '7610403072561', 'GOLD - Jackdaniels Tennessee Honey 100g # 10 x1x100 g', 15, 'GOLD - Jackdaniels Tennessee Honey 100g # 10 x1x100 g', NULL, '', 15, 5, 120082, 120082, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4457, 'GOL0130', '7610403072509', 'GOLD - Jackdaniels Tennessee Whiskey 100 # 10 x 1x 100 g', 15, 'GOLD - Jackdaniels Tennessee Whiskey 100 # 10 x 1x 100 g', NULL, '', 15, 5, 120082, 120082, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4458, 'GOL0140', '7610403072707', 'GOLD - Remy Martin #10(1x100g) # 10 x 1 x 100 g', 15, 'GOLD - Remy Martin #10(1x100g) # 10 x 1 x 100 g', NULL, '', 15, 5, 120082, 120082, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4459, 'GOL0150', '7610403072523', 'GOLD - The Famous gouse #10(1x100g) # 10 x 1 x 100 g', 15, 'GOLD - The Famous gouse #10(1x100g) # 10 x 1 x 100 g', NULL, '', 15, 5, 120082, 120082, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4460, 'HOR0120', '8886467076145', 'HOR - Cereal 3 in 1 320g # 24x320g', 15, 'HOR - Cereal 3 in 1 320g # 24x320g', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4461, 'JLB0100', '745092012295', 'JLB - Jelly Bean Sachet 50 g # 24 x 50 g', 15, 'JLB - Jelly Bean Sachet 50 g # 24 x 50 g', NULL, '', 15, 5, 20686, 20686, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4462, 'JLB0110', '745092006942', 'JLB - Jelly Bean 36Flavours 75gr # 9x16x75gr', 15, 'JLB - Jelly Bean 36Flavours 75gr # 9x16x75gr', NULL, '', 15, 5, 30172, 30172, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4463, 'JLB0120', '745092014428', 'JLB - Jelly Bean Pop A Bean 100gr # 12 x 100gr', 15, 'JLB - Jelly Bean Pop A Bean 100gr # 12 x 100gr', NULL, '', 15, 5, 81736, 81736, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4464, 'JLB0130', '745092006058', 'JLB - Jelly Bean 36 Flavours # 4 x 24 x 100gr', 15, 'JLB - Jelly Bean 36 Flavours # 4 x 24 x 100gr', NULL, '', 15, 5, 45813, 45813, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4465, 'JLB0140', '745092010932', 'JLB - Jelly Bean Pouch Bag 113gr # 12 x 113gr', 15, 'JLB - Jelly Bean Pouch Bag 113gr # 12 x 113gr', NULL, '', 15, 5, 50555, 50555, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4466, 'JLB0150', '745092000933', 'JLB - Jelly Bean Cup # 12 x 200 gr', 15, 'JLB - Jelly Bean Cup # 12 x 200 gr', NULL, '', 15, 5, 69627, 69627, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4467, 'JLB0160', '8713800139307', 'JLB - Jelly Bean Tube 90g # 24 x 90g', 15, 'JLB - Jelly Bean Tube 90g # 24 x 90g', NULL, '', 15, 5, 50000, 50000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4468, 'JLB0170', '8713800139208', 'JLB - Jelly Bean Pouch 70g # 20 x 70g', 15, 'JLB - Jelly Bean Pouch 70g # 20 x 70g', NULL, '', 15, 5, 28500, 28500, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4469, 'LAK0100', '8013399168338', 'LAKE - Fruity Drops Honey Lemon #  ( 12 x 16 ) x 40g', 15, 'LAKE - Fruity Drops Honey Lemon #  ( 12 x 16 ) x 40g', NULL, '', 15, 5, 20989, 20989, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4470, 'LAK0110', '8013399168345', 'LAKE - Fruity Drops Honey Strawberry # ( 12 x 16 ) x 40g', 15, 'LAKE - Fruity Drops Honey Strawberry # ( 12 x 16 ) x 40g', NULL, '', 15, 5, 20989, 20989, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4471, 'LAK0120', '8013399168222', 'LAKE - Fruity Drops Honey Yuzu # ( 12 x 16 ) x 40g', 15, 'LAKE - Fruity Drops Honey Yuzu # ( 12 x 16 ) x 40g', NULL, '', 15, 5, 20989, 20989, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4472, 'LAK0130', '8013399168291', 'LAKE - Fruity Drops Honey Lemon Tea #  ( 12 x 16 ) x 40g', 15, 'LAKE - Fruity Drops Honey Lemon Tea #  ( 12 x 16 ) x 40g', NULL, '', 15, 5, 20989, 20989, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4473, 'LDT0100', '7610400010108', 'LDT - Surfin 100gr # (12x12)x100 gr', 15, 'LDT - Surfin 100gr # (12x12)x100 gr', NULL, '', 15, 5, 53986, 53986, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4474, 'LDT0110', '7610400014571', 'LDT - White Chocolate 100gr # (12x12)x100 gr', 15, 'LDT - White Chocolate 100gr # (12x12)x100 gr', NULL, '', 15, 5, 53986, 53986, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4475, 'LDT0120', '7610400010016', 'LDT - Milk 100gr # (12x12)x100 gr', 15, 'LDT - Milk 100gr # (12x12)x100 gr', NULL, '', 15, 5, 53986, 53986, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4476, 'LDT0130', '7610400010023', 'LDT - Milk Hazelnut 100gr # (12x12)x100 gr', 15, 'LDT - Milk Hazelnut 100gr # (12x12)x100 gr', NULL, '', 15, 5, 60545, 60545, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4477, 'LDT0140', '7610400014038', 'LDT - Milk Whole Almonds 100gr # (12x12)x100 gr', 15, 'LDT - Milk Whole Almonds 100gr # (12x12)x100 gr', NULL, '', 15, 5, 60545, 60545, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4478, 'LDT0150', '7610400010368', 'LDT - Milk Raisin Nut 100gr # (12x12)x100 gr', 15, 'LDT - Milk Raisin Nut 100gr # (12x12)x100 gr', NULL, '', 15, 5, 60545, 60545, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4479, 'LDT0400', '3046920028721', 'LDT - Excellence Dark Cocoa 99% # 6 x 18 x 50 g', 15, 'LDT - Excellence Dark Cocoa 99% # 6 x 18 x 50 g', NULL, '', 15, 5, 75177, 75177, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4480, 'LDT0410', '3046920029759', 'LDT - Excellence 90% Cacao 100 gr # 6x20x100 gr', 15, 'LDT - Excellence 90% Cacao 100 gr # 6x20x100 gr', NULL, '', 15, 5, 72655, 72655, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4481, 'LDT0420', '3046920028363', 'LDT - Excellence Dark 85 # 6 x 20 x 100 g', 15, 'LDT - Excellence Dark 85 # 6 x 20 x 100 g', NULL, '', 15, 5, 72655, 72655, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4482, 'LDT0430', '3046920010047', 'LDT - Excellence Dark Cocoa 78% 100g # 6 x 20 x 100g', 15, 'LDT - Excellence Dark Cocoa 78% 100g # 6 x 20 x 100g', NULL, '', 15, 5, 72655, 72655, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4483, 'LDT0440', '3046920028004', 'LDT - Excellence Dark Cocoa 70% # 6 x 20 x 100 g', 15, 'LDT - Excellence Dark Cocoa 70% # 6 x 20 x 100 g', NULL, '', 15, 5, 72655, 72655, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4484, 'LDT0450', '3046920028370', 'LDT - Excellence Orange 100g # 6 x 20 x 100 g', 15, 'LDT - Excellence Orange 100g # 6 x 20 x 100 g', NULL, '', 15, 5, 72655, 72655, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4485, 'LDT0460', '7610400010481', 'LDT - Excellence Extra Creamy # 6 x 20 x100 g', 15, 'LDT - Excellence Extra Creamy # 6 x 20 x100 g', NULL, '', 15, 5, 72655, 72655, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4486, 'LDT0470', '3046920028752', 'LDT - Exellence Mint Intense # 6 x 20 x 100 g', 15, 'LDT - Exellence Mint Intense # 6 x 20 x 100 g', NULL, '', 15, 5, 72655, 72655, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4487, 'LDT0480', '3046920029674', 'LDT - Excel  Sea Salt 100 g # 6 x 20 x 100 g', 15, 'LDT - Excel  Sea Salt 100 g # 6 x 20 x 100 g', NULL, '', 15, 5, 72655, 72655, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4488, 'LDT0491', '3046920028585', 'LDT - Excellence Dark 70% 35g # 2 x 24 x 35g', 15, 'LDT - Excellence Dark 70% 35g # 2 x 24 x 35g', NULL, '', 15, 5, 24218, 24218, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4489, 'LDT04A1', '3046920011600', 'LDT - Excellence Milk 35 g # 2 x 24 x 35 g', 15, 'LDT - Excellence Milk 35 g # 2 x 24 x 35 g', NULL, '', 15, 5, 24218, 24218, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4490, 'LDT04B0', '3046920029582', 'LDT - Excellence Dark 85% 35g # 2 x 24 x 35g', 15, 'LDT - Excellence Dark 85% 35g # 2 x 24 x 35g', NULL, '', 15, 5, 24218, 24218, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4491, 'LDT0622', '7610400087346', 'LDT - Les Grandes Noisettes Caramel # 6 x 13 x 150g', 15, 'LDT - Les Grandes Noisettes Caramel # 6 x 13 x 150g', NULL, '', 15, 5, 92836, 92836, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4492, 'LDT0631', '7610400085946', 'LDT - Les Grandes Amandes-Fleur De Sel # 15 x 150g', 15, 'LDT - Les Grandes Amandes-Fleur De Sel # 15 x 150g', NULL, '', 15, 5, 92836, 92836, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4493, 'LDT0700', '7610400029841', 'LDT - Dark Thins 125 g # (1x9)x125 g', 15, 'LDT - Dark Thins 125 g # (1x9)x125 g', NULL, '', 15, 5, 136732, 136732, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4494, 'LDT0710', '7610400029810', 'LDT - Milk Thins 125g # (1x9)x125 g', 15, 'LDT - Milk Thins 125g # (1x9)x125 g', NULL, '', 15, 5, 136732, 136732, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4495, 'LDT0800', '7610400071925', 'LDT - Lindor Trio Extra Dark 60% # 24 X 37 g', 15, 'LDT - Lindor Trio Extra Dark 60% # 24 X 37 g', NULL, '', 15, 5, 22099, 22099, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4496, 'LDT0820', '7610400069502', 'LDT - Lindor Trio Assorted 37g # 24 x 37g', 15, 'LDT - Lindor Trio Assorted 37g # 24 x 37g', NULL, '', 15, 5, 22099, 22099, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4497, 'LDT0830', '4894475100190', 'LDT - Lindor Trio Strawberry 37g # 24 x 37g', 15, 'LDT - Lindor Trio Strawberry 37g # 24 x 37g', NULL, '', 15, 5, 22099, 22099, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4498, 'LDT0840', '4894475100497', 'LDT - Lindor Trio Matcha 37g # 24 x 37g', 15, 'LDT - Lindor Trio Matcha 37g # 24 x 37g', NULL, '', 15, 5, 22099, 22099, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4499, 'LDT0900', '7610400074155', 'LDT - Lindor Single 60%Dark 100g # (12x12)x100 g', 15, 'LDT - Lindor Single 60%Dark 100g # (12x12)x100 g', NULL, '', 15, 5, 70636, 70636, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4500, 'LDT0910', '7610400068369', 'LDT - Lindor Single Hazelnut100g # (12x12)x100 g', 15, 'LDT - Lindor Single Hazelnut100g # (12x12)x100 g', NULL, '', 15, 5, 70636, 70636, 0, NULL, '', '2023-01-18 16:27:23', '2023-02-06 09:36:51', NULL, NULL, NULL),
(4501, 'LDT0920', '7610400014649', 'LDT - Lindor Single Milk 100g # (12x12)x100 g', 15, 'LDT - Lindor Single Milk 100g # (12x12)x100 g', NULL, '', 15, 5, 70636, 70636, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4502, 'LDT0930', '7610400014632', 'LDT - Lindor Single White 100g # (12x12)x100 g', 15, 'LDT - Lindor Single White 100g # (12x12)x100 g', NULL, '', 15, 5, 70636, 70636, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4503, 'LDT1000', '8003340091280', 'LDT - Lindor Extra Dark 60%Cocoa # 4 X 8 X 200g', 15, 'LDT - Lindor Extra Dark 60%Cocoa # 4 X 8 X 200g', NULL, '', 15, 5, 155400, 155400, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4504, 'LDT1010', '7610400068505', 'LDT - Lindor Cornet Milk # 4 x 8 x 200 g', 15, 'LDT - Lindor Cornet Milk # 4 x 8 x 200 g', NULL, '', 15, 5, 155400, 155400, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4505, 'LDT1020', '7610400068529', 'LDT - Lindor Cornet Assorted # 4 x 8 x 200 g', 15, 'LDT - Lindor Cornet Assorted # 4 x 8 x 200 g', NULL, '', 15, 5, 155400, 155400, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4506, 'LDT1040', '8003340097619', 'LDT - Lindor Cornet Strawberry 200g # 8 x 200g', 15, 'LDT - Lindor Cornet Strawberry 200g # 8 x 200g', NULL, '', 15, 5, 155400, 155400, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4507, 'LDT1100', '7610400983082', 'LDT - Lindor Extra Dark 60% gift # 1 x 10 x 168 g', 15, 'LDT - Lindor Extra Dark 60% gift # 1 x 10 x 168 g', NULL, '', 15, 5, 165491, 165491, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4508, 'LDT1101', '7610400987318', 'LDT - Lindor Ass Gift Box 168g # 1 x 10 x 168 g', 15, 'LDT - Lindor Ass Gift Box 168g # 1 x 10 x 168 g', NULL, '', 15, 5, 165491, 165491, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4509, 'LDT1110', '7610400060950', 'LDT - Lindor Milk Gift Box 168g # 1 x 10 x 168 g', 15, 'LDT - Lindor Milk Gift Box 168g # 1 x 10 x 168 g', NULL, '', 15, 5, 165491, 165491, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4510, 'LDT1150', '4894475100343', 'LDT - Lindor gift Box Straw&Cream 144g # 12 x 144 g', 15, 'LDT - Lindor gift Box Straw&Cream 144g # 12 x 144 g', NULL, '', 15, 5, 165491, 165491, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4511, 'LDT8070', '4894475100022', 'LDT - 3D Star Tin 37 g # 10 x 37 g', 15, 'LDT - 3D Star Tin 37 g # 10 x 37 g', NULL, '', 15, 5, 79900, 79900, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4512, 'LDT8080', '4894475100015', 'LDT - 3D Tree Tin 37 g # 10 x 37 g', 15, 'LDT - 3D Tree Tin 37 g # 10 x 37 g', NULL, '', 15, 5, 79900, 79900, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4513, 'Ldt8090', '4894475100053', 'LDT - Lindor Mini 3D Heart Tin # 10 x 37 g', 15, 'LDT - Lindor Mini 3D Heart Tin # 10 x 37 g', NULL, '', 15, 5, 69627, 69627, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4514, 'LDT80A0', '7610400099967', 'LDT - Lindor Mini Box # 24 x 37 g', 15, 'LDT - Lindor Mini Box # 24 x 37 g', NULL, '', 15, 5, 22099, 22099, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4515, 'LDT80B0', '4894475100435', 'LDT - Lindor Straw & Cream Mini Heart Tin # 12 x 37 g', 15, 'LDT - Lindor Straw & Cream Mini Heart Tin # 12 x 37 g', NULL, '', 15, 5, 69627, 69627, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4516, 'LDT80G1', '4894475100176', 'LDT - Lindor Crystal Pink Heart Tin 96g # 10 x 96 g', 15, 'LDT - Lindor Crystal Pink Heart Tin 96g # 10 x 96 g', NULL, '', 15, 5, 160445, 160445, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4517, 'LDT80H0', '4894475100138', 'LDT - Blue Mini Milk Can 96 g # 10 x 96 g', 15, 'LDT - Blue Mini Milk Can 96 g # 10 x 96 g', NULL, '', 15, 5, 115000, 115000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4518, 'LDT80I0', '7610400987172', 'LDT - Lindor Crystal Heart Tin 96 g # 10 x 96 g', 15, 'LDT - Lindor Crystal Heart Tin 96 g # 10 x 96 g', NULL, '', 15, 5, 160445, 160445, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4519, 'LDT80K0', '7610400075770', 'LDT - Grand Dark Hazelnut 150 g # 6 x 13 x 150 g', 15, 'LDT - Grand Dark Hazelnut 150 g # 6 x 13 x 150 g', NULL, '', 15, 5, 92836, 92836, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4520, 'LDT80L0', '7610400075787', 'LDT - Grand Milk Hazelnut 150 g # 6 x 13 x 150 g', 15, 'LDT - Grand Milk Hazelnut 150 g # 6 x 13 x 150 g', NULL, '', 15, 5, 92836, 92836, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4521, 'LDT9010', '2009380400002', 'LDT - Lindor Dark Bulk # 1 X 1 Kg', 15, 'LDT - Lindor Dark Bulk # 1 X 1 Kg', NULL, '', 15, 5, 83250, 83250, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4522, 'LDT9020', '38004131', 'LDT - Lindor Hazelnut Bulk 1Kg # 1 X 1 Kg', 15, 'LDT - Lindor Hazelnut Bulk 1Kg # 1 X 1 Kg', NULL, '', 15, 5, 83250, 83250, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4523, 'LDT9030', '8000000900005', 'LDT - Lindor Milk Bulk # 1 X 1 Kg', 15, 'LDT - Lindor Milk Bulk # 1 X 1 Kg', NULL, '', 15, 5, 83250, 83250, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4524, 'LDT9041', '38010828', 'LDT - Lindor Teddy Tin 8''s #10x96 gr', NULL, 'LDT - Lindor Teddy Tin 8''s ', NULL, '', 15, 5, 96000, 96000, 86486.5, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4525, 'LIP0120', '8999999573409', 'LIP - Delight 24gr # 24 x (15x1.6gr)', 15, 'LIP - Delight 24gr # 24 x (15x1.6gr)', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4526, 'MAN0100', '048176990091', 'MANT -  SPRAY EXTRA VIRGIN OIL # 6(1x250ml)', 15, 'MANT -  SPRAY EXTRA VIRGIN OIL # 6(1x250ml)', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4527, 'MCV0100', '8906033742455', 'MCV - Digestive Zero 75g # 120x75g', 15, 'MCV - Digestive Zero 75g # 120x75g', NULL, '', 15, 5, 15800, 15800, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4528, 'MCV0110', '8906033740208', 'MCV - Butter Cookies 60g # 144x60g', 15, 'MCV - Butter Cookies 60g # 144x60g', NULL, '', 15, 5, 8900, 8900, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4529, 'MCV0120', '8906033741595', 'MCV - Marie Wholewheat 100g # 96x100g', 15, 'MCV - Marie Wholewheat 100g # 96x100g', NULL, '', 15, 5, 14500, 14500, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4530, 'MCV0130', '8906033740758', 'MCV - Digestive 100g # 96x100g', 15, 'MCV - Digestive 100g # 96x100g', NULL, '', 15, 5, 15800, 15800, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4531, 'MCV0140', '8906033740963', 'MCV - Bourbon 100g #  96x100g', 15, 'MCV - Bourbon 100g #  96x100g', NULL, '', 15, 5, 15800, 15800, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4532, 'MCV0230', '5000396037548', 'MCV - Digestive Dark Choco UK # 24x200', 15, 'MCV - Digestive Dark Choco UK # 24x200', NULL, '', 15, 5, 49000, 49000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4533, 'MCV0240', '5000396037531', 'MCV - Digestive Milk Choco UK # 24x200', 15, 'MCV - Digestive Milk Choco UK # 24x200', NULL, '', 15, 5, 49000, 49000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4534, 'MCV0260', '5000396033311', 'MCV - HobNobs Oat Crunch # 10x300', 15, 'MCV - HobNobs Oat Crunch # 10x300', NULL, '', 15, 5, 69000, 69000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4535, 'MCV0270', '5000396022315', 'MCV - HobNobs Milk Choco Oat # 24x300', 15, 'MCV - HobNobs Milk Choco Oat # 24x300', NULL, '', 15, 5, 69000, 69000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4536, 'NAT0140', '016000295704', 'NATY - Apple Crisp 253 g # 12 x 253 g', 15, 'NATY - Apple Crisp 253 g # 12 x 253 g', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4537, 'OEP0100', '8410076481597', 'OEP - Tortilla Chips Original  # 10X185G', 15, 'OEP - Tortilla Chips Original  # 10X185G', NULL, '', 15, 5, 55000, 55000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4538, 'OEP0110', '8410076481764', 'OEP - Tortilla Chips Chili # 10X185G', 15, 'OEP - Tortilla Chips Chili # 10X185G', NULL, '', 15, 5, 55000, 55000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4539, 'OEP0120', '8410076482556', 'OEP - Tortila Chips Paprika # 10X185G', 15, 'OEP - Tortila Chips Paprika # 10X185G', NULL, '', 15, 5, 55000, 55000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4540, 'OEP0130', '8410076481757', 'OEP - Tortilla Chips Fajita # 10X185G', 15, 'OEP - Tortilla Chips Fajita # 10X185G', NULL, '', 15, 5, 55000, 55000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4541, 'OVM0100', '7612100027158', 'OVM - Crunchy Cream 380g # 12 x 380g', 15, 'OVM - Crunchy Cream 380g # 12 x 380g', NULL, '', 15, 5, 86277, 86277, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4542, 'OVM0110', '7612100030677', 'OVM - Crunchy Cream 680g # 6 x 680g', 15, 'OVM - Crunchy Cream 680g # 6 x 680g', NULL, '', 15, 5, 149345, 149345, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4543, 'STD0120', '084380957741', 'STD - Raspberry 284g # 12 x 284g', 15, 'STD - Raspberry 284g # 12 x 284g', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4544, 'STK0100', '4014400400007', 'STK - Toffiffee 125g # 15 x 125 g', 15, 'STK - Toffiffee 125g # 15 x 125 g', NULL, '', 15, 5, 48941, 48941, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4545, 'STK0110', '4014400900804', 'STK - Mint Chocs 200g # 15 x 200g', 15, 'STK - Mint Chocs 200g # 15 x 200g', NULL, '', 15, 5, 46317, 46317, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4546, 'STK0120', '40144078', 'STK - Knoppers 75g # 24 x 75g', 15, 'STK - Knoppers 75g # 24 x 75g', NULL, '', 15, 5, 31786, 31786, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4547, 'STK0130', '40144061', 'STK - Knoppers 25g # 6 x 24 x 25g', 15, 'STK - Knoppers 25g # 6 x 24 x 25g', NULL, '', 15, 5, 11100, 11100, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4548, 'STK0140', '4014400901191', 'STK - Mercy Grosse Vielfalt (Red) 250gr # 3 x 10 x 250gr', 15, 'STK - Mercy Grosse Vielfalt (Red) 250gr # 3 x 10 x 250gr', NULL, '', 15, 5, 125127, 125127, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4549, 'STK0141', '4014400900217', 'STK - Mercy Grosse Vielfalt (red) 400 gr # 8 x 400 gr', 15, 'STK - Mercy Grosse Vielfalt (red) 400 gr # 8 x 400 gr', NULL, '', 15, 5, 249000, 249000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4550, 'STK0150', '4014400901405', 'STK - Mercy Helle Viefalt (Blue) 250gr # 3 x 10 x 250gr', 15, 'STK - Mercy Helle Viefalt (Blue) 250gr # 3 x 10 x 250gr', NULL, '', 15, 5, 125127, 125127, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4551, 'STK0160', '4014400925395', 'STK - Merci Petits Collection 125g # 12 x 125g', 15, 'STK - Merci Petits Collection 125g # 12 x 125g', NULL, '', 15, 5, 71141, 71141, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4552, 'STK0170', '40144924', 'STK - Riesen 45g # 4 x 24 x 45g', 15, 'STK - Riesen 45g # 4 x 24 x 45g', NULL, '', 15, 5, 13623, 13623, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4553, 'STK0190', '4014400902495', 'STK - Riesen 150g # 15 x 150g', 15, 'STK - Riesen 150g # 15 x 150g', NULL, '', 15, 5, 46317, 46317, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4554, 'STK0200', '40144016', 'STK - Werthers Echte Original 50g # 6 x 24 x 50g', 15, 'STK - Werthers Echte Original 50g # 6 x 24 x 50g', NULL, '', 15, 5, 12614, 12614, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4555, 'STK0210', '4014400918083', 'STK - Werthers Echte Original 90g # 12 x 90g', 15, 'STK - Werthers Echte Original 90g # 12 x 90g', NULL, '', 15, 5, 24723, 24723, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4556, 'STK0220', '4014400918113', 'STK - Werthers Original Toffee 80g # 12 x 80g', 15, 'STK - Werthers Original Toffee 80g # 12 x 80g', NULL, '', 15, 5, 24723, 24723, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4557, 'STK0230', '4014400918205', 'STK - Werthers Original Caramel Chew 48g # 6 x 24 x 48g', 15, 'STK - Werthers Original Caramel Chew 48g # 6 x 24 x 48g', NULL, '', 15, 5, 12614, 12614, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4558, 'STK0240', '4014400918106', 'STK - Werthers Original Creamy Filling80g # 12 x 80g', 15, 'STK - Werthers Original Creamy Filling80g # 12 x 80g', NULL, '', 15, 5, 24723, 24723, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4559, 'STR0101', '38006821', 'STR - Lady Bird Bag 42g # 12 x 42g', 15, 'STR - Lady Bird Bag 42g # 12 x 42g', NULL, '', 15, 5, 37841, 37841, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4560, 'STR0111', '38006845', 'STR - Sea Life Bag 43g # 12 x 43g', 15, 'STR - Sea Life Bag 43g # 12 x 43g', NULL, '', 15, 5, 37841, 37841, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4561, 'STR0121', '38006852', 'STR - Farm Life Bag 55g # 12 x 55g', 15, 'STR - Farm Life Bag 55g # 12 x 55g', NULL, '', 15, 5, 37841, 37841, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4562, 'STR0131', '38006838', 'STR - Wild Life Bag # 12 x 58g', 15, 'STR - Wild Life Bag # 12 x 58g', NULL, '', 15, 5, 37841, 37841, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4563, 'STR0140', '4003006010260', 'STR - Bee Bag  37.5 g # 6 x 36 x 37.5 g', 15, 'STR - Bee Bag  37.5 g # 6 x 36 x 37.5 g', NULL, '', 15, 5, 37841, 37841, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4564, 'STR0150', '4003006030749', 'STR - Sheep Bag  50 g # 6 x 36 x 50 g', 15, 'STR - Sheep Bag  50 g # 6 x 36 x 50 g', NULL, '', 15, 5, 37842, 37842, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4565, 'STR0161', '4003006130548', 'STR - Lady Birds Tub 100 g # 6 x 24 x 100 g', 15, 'STR - Lady Birds Tub 100 g # 6 x 24 x 100 g', NULL, '', 15, 5, 81736, 81736, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4566, 'STR0171', '4003006141032', 'STR - Soccer Player Tub  # 6 x 24 x 75 g', 15, 'STR - Soccer Player Tub  # 6 x 24 x 75 g', NULL, '', 15, 5, 81736, 81736, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL);
INSERT INTO `p_item` (`item_id`, `item_code`, `barcode`, `name`, `min_stock`, `item_name_toko`, `item_name_sap`, `packing`, `category_id`, `unit_id`, `price`, `harga_jual`, `harga_bersih`, `exp_date`, `image`, `created`, `updated`, `updated_info`, `created_by`, `updated_by`) VALUES
(4567, 'STR0180', '4003006129245', 'STR - Big Box Farm 300 g # 8 x 300 g', 15, 'STR - Big Box Farm 300 g # 8 x 300 g', NULL, '', 15, 5, 200809, 200809, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4568, 'STR0190', '4003006118249', 'STR - Big Box Wildlife 300 g # 8 x 300 g', 15, 'STR - Big Box Wildlife 300 g # 8 x 300 g', NULL, '', 15, 5, 200809, 200809, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4569, 'STR01A0', '4003006152243', 'STR - Big Box Sealife 300 g # 8 x 300 g', 15, 'STR - Big Box Sealife 300 g # 8 x 300 g', NULL, '', 15, 5, 200809, 200809, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4570, 'TWN0100', '070177010799', 'TWN - Darjeeling Tea 50 g # 12 x ( 25 x 2 g)', 15, 'TWN - Darjeeling Tea 50 g # 12 x ( 25 x 2 g)', NULL, '', 15, 5, 78780, 78780, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4571, 'TWN0110', '070177010775', 'TWN - English Breakfast Tea 50 g # 12 x (25 x 2 g)', 15, 'TWN - English Breakfast Tea 50 g # 12 x (25 x 2 g)', NULL, '', 15, 5, 78780, 78780, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4572, 'TWN0210', '070177173173', 'TWN - Green Tea Earl Grey 40 g # 12 x (25 x 1.6 g)', 15, 'TWN - Green Tea Earl Grey 40 g # 12 x (25 x 1.6 g)', NULL, '', 15, 5, 78780, 78780, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4573, 'TWN0220', '070177077198', 'TWN - Lady Grey Tea 50 g # 12 x (25 x 2 g)', 15, 'TWN - Lady Grey Tea 50 g # 12 x (25 x 2 g)', NULL, '', 15, 5, 78780, 78780, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4574, 'TWN0230', '070177051174', 'TWN - TWN - Earl Grey Decaf Tea 50 g # 12 x (25x2 g)', 15, 'TWN - TWN - Earl Grey Decaf Tea 50 g # 12 x (25x2 g)', NULL, '', 15, 5, 78000, 78000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4575, 'TWN0260', '070177055639', 'TWN - Peach Tea 50 g # 12 x (25x2 g)', 15, 'TWN - Peach Tea 50 g # 12 x (25x2 g)', NULL, '', 15, 5, 78780, 78780, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4576, 'TWN0300', '070177086664', 'TWN - Pure  Green Tea 50 g # 12 x (25x2 g)', 15, 'TWN - Pure  Green Tea 50 g # 12 x (25x2 g)', NULL, '', 15, 5, 78780, 78780, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4577, 'TWN0310', '070177173166', 'TWN - Green Tea Jasmine 45 g # 12 x (25x1.8 g)', 15, 'TWN - Green Tea Jasmine 45 g # 12 x (25x1.8 g)', NULL, '', 15, 5, 78780, 78780, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4578, 'TWN0340', '070177229986', 'TWN - Green Tea Collection 34 g # 8 x (25x1.7 g)', 15, 'TWN - Green Tea Collection 34 g # 8 x (25x1.7 g)', NULL, '', 15, 5, 89000, 89000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4579, 'TWN0400', '070177118525', 'TWN - Pure Peppermint 50 g # 12 x (25x2 g)', 15, 'TWN - Pure Peppermint 50 g # 12 x (25x2 g)', NULL, '', 15, 5, 78780, 78780, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4580, 'TWN0430', '070177118495', 'TWN - Strawberry & Mango 50gr # 12 x (25x2gr)', 15, 'TWN - Strawberry & Mango 50gr # 12 x (25x2gr)', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4581, 'TWN0500', '070177029623', 'TWN - Black Tea Earl  Grey Tin 100 g # 6 x 100 g', 15, 'TWN - Black Tea Earl  Grey Tin 100 g # 6 x 100 g', NULL, '', 15, 5, 120189, 120189, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4582, 'TWN0510', '070177029630', 'TWN - English Breakfast Tea Tin 100 g # 6 x 100 g', 15, 'TWN - English Breakfast Tea Tin 100 g # 6 x 100 g', NULL, '', 15, 5, 230000, 230000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4583, 'TWN1020', '0070177010768', 'TWN - Promo Pack (Earl Grey+Asf Nat 125g) # 12 X (25x2g)', 15, 'TWN - Promo Pack (Earl Grey+Asf Nat 125g) # 12 X (25x2g)', NULL, '', 15, 5, 230000, 230000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4584, 'TWN1050', '38010132', 'TWN - Seasonal (English 50g+WNL 100g)#6x150g', 15, 'TWN - Seasonal (English 50g+WNL 100g)#6x150g', NULL, '', 15, 5, 155000, 155000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4585, 'TWN1070', '38010712', 'TWN - Seasonal Breakfast Box 714gr # 12 x (50gr+380gr+284gr)', 15, 'TWN - Seasonal Breakfast Box 714gr # 12 x (50gr+380gr+284gr)', NULL, '', 15, 5, 230000, 230000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4586, 'TWN9910', '38008054', 'TWN - Twn Mug Trumpet 1 Pcs # 1 x 1 Pcs', 15, 'TWN - Twn Mug Trumpet 1 Pcs # 1 x 1 Pcs', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4587, 'VLR0100', '8410109055887', 'VLR - Dark Chocolate Sugar Free 100 g # 6 x 17 x 100 g', 15, 'VLR - Dark Chocolate Sugar Free 100 g # 6 x 17 x 100 g', NULL, '', 15, 5, 64330, 64330, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4588, 'VLR0110', '8410109055795', 'VLR - Milk Chocolate No Sugar Added 100 g # 6 x 17 x 100 g', 15, 'VLR - Milk Chocolate No Sugar Added 100 g # 6 x 17 x 100 g', NULL, '', 15, 5, 64330, 64330, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4589, 'VLR0120', '8410109050882', 'VLR - 70% Dark Chocolate Sugar Free 100 g # 6 x 17 x 100 g', 15, 'VLR - 70% Dark Chocolate Sugar Free 100 g # 6 x 17 x 100 g', NULL, '', 15, 5, 64330, 64330, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4590, 'VLR0130', '8410109109832', 'VLR - 85% Dark Chocolate Sugar Free 100 g # 6 x 17 x 100 g', 15, 'VLR - 85% Dark Chocolate Sugar Free 100 g # 6 x 17 x 100 g', NULL, '', 15, 5, 64330, 64330, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4591, 'VLR0140', '8410109056525', 'VLR - Dark Chocolate W/ Orange Creamy 100 g # 6 x 17 x 100 g', 15, 'VLR - Dark Chocolate W/ Orange Creamy 100 g # 6 x 17 x 100 g', NULL, '', 15, 5, 64330, 64330, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4592, 'VLR0150', '8410109056532', 'VLR - Dark Chocolate W/ Truffle Creamy 100 g # 6 x 17 x 100 g', 15, 'VLR - Dark Chocolate W/ Truffle Creamy 100 g # 6 x 17 x 100 g', NULL, '', 15, 5, 64330, 64330, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4593, 'VOR0120', '067312005499', 'VORT - Sugar Free Fudge Choc Chip 227 g # 12 x 227 g', 15, 'VORT - Sugar Free Fudge Choc Chip 227 g # 12 x 227 g', NULL, '', 15, 5, 79000, 79000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4594, 'VOR0130', '067312005505', 'VORT - Sugar Free Chocolate Chip 227 g # 12 x 227 g', 15, 'VORT - Sugar Free Chocolate Chip 227 g # 12 x 227 g', NULL, '', 15, 5, 79000, 79000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4595, 'VOR0200', '067312005215', 'VORT - Sugar Free Lemon Wafers 255 g # 12 x 255 g', 15, 'VORT - Sugar Free Lemon Wafers 255 g # 12 x 255 g', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4596, 'VOR0220', '067312005260', 'VORT - Sugar Free Chocolate Wafers 255 g # 12 x 255 g', 15, 'VORT - Sugar Free Chocolate Wafers 255 g # 12 x 255 g', NULL, '', 15, 5, 69000, 69000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4597, 'WDR0100', '014113940092', 'WDR - Pistachios Clas Salt 50 g # 48 x 50 g', 15, 'WDR - Pistachios Clas Salt 50 g # 48 x 50 g', NULL, '', 15, 5, 34814, 34814, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4598, 'WDR0110', '014113940054', 'WDR  -Pistachios Clas Salt 168 g # 24 x 168 g', 15, 'WDR  -Pistachios Clas Salt 168 g # 24 x 168 g', NULL, '', 15, 5, 107468, 107468, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4599, 'WDR0120', '014113940023', 'WDR - Pistachios Clas Salt 454 g # 12 x 454 g', 15, 'WDR - Pistachios Clas Salt 454 g # 12 x 454 g', NULL, '', 15, 5, 259336, 259336, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4600, 'WDR0130', '014113940214', 'WDR - Pistachios Clas Salt 400 g # 12 x 400 g', 15, 'WDR - Pistachios Clas Salt 400 g # 12 x 400 g', NULL, '', 15, 5, 147450, 147450, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4601, 'WDR0140', '014113940108', 'WDR - Pistachios PPR & GRLC 50 g # 48 x 50 g', 15, 'WDR - Pistachios PPR & GRLC 50 g # 48 x 50 g', NULL, '', 15, 5, 34814, 34814, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4602, 'WDR0150', '014113940061', 'WDR - Pistachios PPR & GRLC 168 g # 24 x 168 g', 15, 'WDR - Pistachios PPR & GRLC 168 g # 24 x 168 g', NULL, '', 15, 5, 107468, 107468, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4603, 'WDR0160', '014113940207', 'WDR - Pistachios Clas No Salt 50 g # 48 x 50 g', 15, 'WDR - Pistachios Clas No Salt 50 g # 48 x 50 g', NULL, '', 15, 5, 34814, 34814, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4604, 'WDR0170', '014113940191', 'WDR - Pistachios Clas No Salt 300 g# 24 x 300 g', 15, 'WDR - Pistachios Clas No Salt 300 g# 24 x 300 g', NULL, '', 15, 5, 159570, 159570, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4605, 'WDR0200', '014113240055', 'WDR - Almonds Clas Salt 50 g # 48 x 50 g', 15, 'WDR - Almonds Clas Salt 50 g # 48 x 50 g', NULL, '', 15, 5, 31786, 31786, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4606, 'WDR0210', '014113240024', 'WDR - Almonds Clas Salt 168 g # 24 x 168 g', 15, 'WDR - Almonds Clas Salt 168 g # 24 x 168 g', NULL, '', 15, 5, 96368, 96368, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4607, 'WDR0220', '014113240031', 'WDR - Almonds Clas Salt 318 g # 24 x 318 g', 15, 'WDR - Almonds Clas Salt 318 g # 24 x 318 g', NULL, '', 15, 5, 162464, 162464, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4608, 'WDR0230', '014113240116', 'WDR - Almonds Clas Salt 500 g # 12 x 500 g', 15, 'WDR - Almonds Clas Salt 500 g # 12 x 500 g', NULL, '', 15, 5, 295930, 295930, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4609, 'WNL0110', '7610037000893', 'WNL - Wernli Choco Fin 100 g  # 12 x 100 g', 15, 'WNL - Wernli Choco Fin 100 g  # 12 x 100 g', NULL, '', 15, 5, 77000, 77000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4610, 'WNL0120', '7610062041809', 'WNL - Wernli Choco Belle 100 g # 12 x 100 g', 15, 'WNL - Wernli Choco Belle 100 g # 12 x 100 g', NULL, '', 15, 5, 77000, 77000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4611, 'WNL0130', '7610062080341', 'WNL - Choco Petit Beurre 125 g # 16 x 125 g', 15, 'WNL - Choco Petit Beurre 125 g # 16 x 125 g', NULL, '', 15, 5, 77000, 77000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4612, 'WNL0140', '7610062091903', 'WNL - Truffet 100 g # 12 x 100 g', 15, 'WNL - Truffet 100 g # 12 x 100 g', NULL, '', 15, 5, 77000, 77000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4613, 'WNL0150', '7610062000301', 'WNL - Japonais 100 g # 12 x 100 g', 15, 'WNL - Japonais 100 g # 12 x 100 g', NULL, '', 15, 5, 77000, 77000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4614, 'WNL0180', '07610062092566', 'WNL - Mini Chocobeau 150 g # 12 x 150 g', 15, 'WNL - Mini Chocobeau 150 g # 12 x 150 g', NULL, '', 15, 5, 0, 0, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4615, 'WNL0191', '7610062087135', 'WNL - Petit Amour 150g # 8 x 150 g', 15, 'WNL - Petit Amour 150g # 8 x 150 g', NULL, '', 15, 5, 130000, 130000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4616, 'WNL0200', '7610062001001', 'WNL - Wernli Jura Waffers 250 g # 12 x 250 g', 15, 'WNL - Wernli Jura Waffers 250 g # 12 x 250 g', NULL, '', 15, 5, 83000, 83000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4617, 'WNL0210', '07610062081065', 'WNL - Jura Waffer mini 130 g # 12 x 130 g', 15, 'WNL - Jura Waffer mini 130 g # 12 x 130 g', NULL, '', 15, 5, 55000, 55000, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4618, 'WTK0100', '94314212', 'WTK - Peanut Slab 50 g # 4 x 50 x 50 g', 15, 'WTK - Peanut Slab 50 g # 4 x 50 x 50 g', NULL, '', 15, 5, 25227, 25227, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4619, 'WTK0110', '94314243', 'WTK - Roasted Almond Gold 45 g # 4 x 50 x 45 g', 15, 'WTK - Roasted Almond Gold 45 g # 4 x 50 x 45 g', NULL, '', 15, 5, 25227, 25227, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4620, 'WTK0120', '9403142000210', 'WTK - Almond Gold Multi 135 g # 24 x 135 g', 15, 'WTK - Almond Gold Multi 135 g # 24 x 135 g', NULL, '', 15, 5, 72150, 72150, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4621, 'WTK0130', '9403142000142', 'WTK - Peanut Slab Multi 150 g # 24 x 150 g', 15, 'WTK - Peanut Slab Multi 150 g # 24 x 150 g', NULL, '', 15, 5, 72150, 72150, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4622, 'WTK0200', '9403142002375', 'WTK - Ghana Peppermint Block 220 g # 12 x 220 g', 15, 'WTK - Ghana Peppermint Block 220 g # 12 x 220 g', NULL, '', 15, 5, 91827, 91827, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4623, 'WTK0210', '9403142002245', 'WTK - Hazelnut Block 200 g # 12 x 200 g', 15, 'WTK - Hazelnut Block 200 g # 12 x 200 g', NULL, '', 15, 5, 91827, 91827, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4624, 'WTK0220', '9403142002467', 'WTK - Peanut Butter Block 220 g # 12 x 220 g', 15, 'WTK - Peanut Butter Block 220 g # 12 x 220 g', NULL, '', 15, 5, 91827, 91827, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4625, 'WTK0230', '9403142002252', 'WTK - Almond  Gold Block 200 g # 14 x 200 g', 15, 'WTK - Almond  Gold Block 200 g # 14 x 200 g', NULL, '', 15, 5, 91827, 91827, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4626, 'WTK0240', '9403142002320', 'WTK - Berry Biscuit Block 200 g # 14 x 200 g', 15, 'WTK - Berry Biscuit Block 200 g # 14 x 200 g', NULL, '', 15, 5, 91827, 91827, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4627, 'WTK0250', '9403142002221', 'WTK - Creamy Milk Block 200 g # 14 x 200 g', 15, 'WTK - Creamy Milk Block 200 g # 14 x 200 g', NULL, '', 15, 5, 91827, 91827, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4628, 'WTK0260', '9403142002269', 'WTK - Dark Almond Block 200 g # 14 x 200 g', 15, 'WTK - Dark Almond Block 200 g # 14 x 200 g', NULL, '', 15, 5, 91827, 91827, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4629, 'WTK0270', '9403142002351', 'WTK - Dark Ghana Block 200 g # 14 x 200 g', 15, 'WTK - Dark Ghana Block 200 g # 14 x 200 g', NULL, '', 15, 5, 91827, 91827, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4630, 'WTK0280', '9403142002214', 'WTK - Fruit Nut Block 200 g # 14 x 200 g', 15, 'WTK - Fruit Nut Block 200 g # 14 x 200 g', NULL, '', 15, 5, 91827, 91827, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4631, 'WTK0300', '94184648', 'WTK - Sante 72% Dark Ghana # 9 x 48 x 25 g', 15, 'WTK - Sante 72% Dark Ghana # 9 x 48 x 25 g', NULL, '', 15, 5, 13118, 13118, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4632, 'WTK0310', '94314281', 'WTK - Sante Dark Choco # 9 x 48 x 25 g', 15, 'WTK - Sante Dark Choco # 9 x 48 x 25 g', NULL, '', 15, 5, 13118, 13118, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4633, 'WTK0320', '94314274', 'WTK - Sante Milk Choco Bar # 9 x 48 x 25 g', 15, 'WTK - Sante Milk Choco Bar # 9 x 48 x 25 g', NULL, '', 15, 5, 13118, 13118, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4634, 'WTK0330', '94314229', 'WTK - Sante White Choco Bar # 9 x 48 x 25 g', 15, 'WTK - Sante White Choco Bar # 9 x 48 x 25 g', NULL, '', 15, 5, 13118, 13118, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4635, 'WTK0400', '9403142000678', 'WTK - Almond Gold Chunks 50 g # 6 x 36 x 50 g', 15, 'WTK - Almond Gold Chunks 50 g # 6 x 36 x 50 g', NULL, '', 15, 5, 26236, 26236, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4636, 'WTK0410', '9403142000630', 'WTK - Berry Biscuit Chunks 50 g # 6 x 36 x 50 g', 15, 'WTK - Berry Biscuit Chunks 50 g # 6 x 36 x 50 g', NULL, '', 15, 5, 26236, 26236, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4637, 'WTK0420', '9403142000609', 'WTK - Creamy Milk Cho Chunk 50 g # 6 x ( 36 x 50 g )', 15, 'WTK - Creamy Milk Cho Chunk 50 g # 6 x ( 36 x 50 g )', NULL, '', 15, 5, 26236, 26236, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4638, 'WTK0430', '9403142000654', 'WTK - Dark Almond Chunks 50 g # 6 x 36 x 50 g', 15, 'WTK - Dark Almond Chunks 50 g # 6 x 36 x 50 g', NULL, '', 15, 5, 26236, 26236, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4639, 'WTK0440', '9403142000623', 'WTK - Dark Choc ChunkS 50 g # 6 x ( 36 x 50 g )', 15, 'WTK - Dark Choc ChunkS 50 g # 6 x ( 36 x 50 g )', NULL, '', 15, 5, 26236, 26236, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4640, 'WTK0450', '9403142000685', 'WTK - Peppermint Chunks 6 x 36 x 50 g # 6 x 36 x 50 g', 15, 'WTK - Peppermint Chunks 6 x 36 x 50 g # 6 x 36 x 50 g', NULL, '', 15, 5, 26236, 26236, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4641, 'WTK0460', '9403142000661', 'WTK - Hazelnut Chunks 6 x 36 x 50 g # 6 x 36 x 50 g', 15, 'WTK - Hazelnut Chunks 6 x 36 x 50 g # 6 x 36 x 50 g', NULL, '', 15, 5, 26236, 26236, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4642, 'WTK0470', '9403142001361', 'WTK - 72 % Dark Ghana Chochunks  # 6 x ( 36 x 50 g )', 15, 'WTK - 72 % Dark Ghana Chochunks  # 6 x ( 36 x 50 g )', NULL, '', 15, 5, 26236, 26236, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4643, 'WTK0480', '9403142000616', 'WTK - Fruit & Nut Choc Chunks # 6 x ( 36 x 50 g )', 15, 'WTK - Fruit & Nut Choc Chunks # 6 x ( 36 x 50 g )', NULL, '', 15, 5, 26236, 26236, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4644, 'WTK0490', '9403142001088', 'WTK - White Choc Chunks # 6 x ( 36 x 50 g )', 15, 'WTK - White Choc Chunks # 6 x ( 36 x 50 g )', NULL, '', 15, 5, 26236, 26236, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4645, 'WTK0500', '9403142001675', 'WTK - Berry & Biscuit 180 g # 12 x 180 g', 15, 'WTK - Berry & Biscuit 180 g # 12 x 180 g', NULL, '', 15, 5, 98386, 98386, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4646, 'WTK0510', '9403142001668', 'WTK - Hokey - Pokey 180 g # 12 x 180 g', 15, 'WTK - Hokey - Pokey 180 g # 12 x 180 g', NULL, '', 15, 5, 98386, 98386, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4647, 'WTR0100', '8003535023218', 'WTR - Bianco Coure 250 g # 12 x 250 g', 15, 'WTR - Bianco Coure 250 g # 12 x 250 g', NULL, '', 15, 5, 109486, 109486, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4648, 'WTR0110', '8003535023171', 'WTR - Golden 250 g # 12 x 250 g', 15, 'WTR - Golden 250 g # 12 x 250 g', NULL, '', 15, 5, 109486, 109486, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4649, 'WTR0120', '8003535020934', 'WTR - Golden 1 kg # 9 x 1 kg', 15, 'WTR - Golden 1 kg # 9 x 1 kg', NULL, '', 15, 5, 344605, 344605, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4650, 'WTR0130', '8003535044138', 'WTR - Noir 250 g # 12 x 250 g', 15, 'WTR - Noir 250 g # 12 x 250 g', NULL, '', 15, 5, 109486, 109486, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4651, 'WTR0140', '8003535023256', 'WTR - Selection Classic 250 g # 12 x 250 g', 15, 'WTR - Selection Classic 250 g # 12 x 250 g', NULL, '', 15, 5, 109486, 109486, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4652, 'WTR0150', '8003535026578', 'WTR - Selection Classic 1 kg # 9 x 1 kg', 15, 'WTR - Selection Classic 1 kg # 9 x 1 kg', NULL, '', 15, 5, 344605, 344605, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4653, 'WTR0160', '8003535022778', 'WTR - Pyramid Selection 300 g # 6 x 300 g', 15, 'WTR - Pyramid Selection 300 g # 6 x 300 g', NULL, '', 15, 5, 199800, 199800, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4654, 'WTR0170', '8003535026295', 'WTR - Selection Ice Bucket 350 g # 5 x 350 g', 15, 'WTR - Selection Ice Bucket 350 g # 5 x 350 g', NULL, '', 15, 5, 231082, 231082, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4655, 'ZAI0100', '8004735069594', 'ZAI - Egg Trio Frozen 60 g # 24 x 60 g', 15, 'ZAI - Egg Trio Frozen 60 g # 24 x 60 g', NULL, '', 15, 5, 64481, 64481, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4656, 'ZAI0110', '8004735031089', 'ZAI - Egg Trio Princess 60 g # 24 x 60 g', 15, 'ZAI - Egg Trio Princess 60 g # 24 x 60 g', NULL, '', 15, 5, 64481, 64481, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4657, 'ZAI0120', '8004735030662', 'ZAI - Egg Trio Toy Story # 24 x 60 g', 15, 'ZAI - Egg Trio Toy Story # 24 x 60 g', NULL, '', 15, 5, 64481, 64481, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4658, 'ZAI0130', '8004735091175', 'ZAI - Egg Trio Insideout  # 24 x 60 g', 15, 'ZAI - Egg Trio Insideout  # 24 x 60 g', NULL, '', 15, 5, 64481, 64481, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4659, 'ZAI0140', '8004735101034', 'ZAI - Egg Trio Mickey 60 g # 24 x 60 g', 15, 'ZAI - Egg Trio Mickey 60 g # 24 x 60 g', NULL, '', 15, 5, 64481, 64481, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4660, 'ZAI0150', '8004735031218', 'ZAI - Egg Trio Cars 60 g # 24 x 60 g', 15, 'ZAI - Egg Trio Cars 60 g # 24 x 60 g', NULL, '', 15, 5, 64481, 64481, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4661, 'ZAI0160', '8004735101041', 'ZAI - Egg Trio Sofia 60 g # 24 x 60 g', 15, 'ZAI - Egg Trio Sofia 60 g # 24 x 60 g', NULL, '', 15, 5, 64481, 64481, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4662, 'ZAI0170', '8004735031621', 'ZAI - Egg Trio Minnie 60 g # 24 x 60 g', 15, 'ZAI - Egg Trio Minnie 60 g # 24 x 60 g', NULL, '', 15, 5, 64481, 64481, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4663, 'ZAI0180', '8004735096545', 'ZAI - Egg Trio Tsum - Tsum 60 g # 24 x 60 g', 15, 'ZAI - Egg Trio Tsum - Tsum 60 g # 24 x 60 g', NULL, '', 15, 5, 64481, 64481, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4664, 'ZAI0190', '8004735092547', 'ZAI - Egg Trio Hello Kitty 60 g # 24 x 60 g', 15, 'ZAI - Egg Trio Hello Kitty 60 g # 24 x 60 g', NULL, '', 15, 5, 64481, 64481, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4665, 'ZAI01A0', '8004735109184', 'ZAI - Pororo Trio Eggs 60 g # 24 x 60 g', 15, 'ZAI - Pororo Trio Eggs 60 g # 24 x 60 g', NULL, '', 15, 5, 64481, 64481, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4666, 'ZAI01B0', '8004735111163', 'ZAI - Hot Wheels Trio Eggs 60 g # 24 x 60 g', 15, 'ZAI - Hot Wheels Trio Eggs 60 g # 24 x 60 g', NULL, '', 15, 5, 64481, 64481, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4667, 'ZAI01C0', '8004735093933', 'ZAI - Barbie Trio Eggs 60 g # 24 x 60 g', 15, 'ZAI - Barbie Trio Eggs 60 g # 24 x 60 g', NULL, '', 15, 5, 64481, 64481, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4668, 'ZAI01D0', '8004735094473', 'ZAI - Paw Patrol Trio Eggs 60 g # 24 X 60 g', 15, 'ZAI - Paw Patrol Trio Eggs 60 g # 24 X 60 g', NULL, '', 15, 5, 64481, 64481, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4669, 'ZAI01E0', '8004735110579', 'ZAI - Pj Masks Trio Eggs 60 g # 24 x 60 g', 15, 'ZAI - Pj Masks Trio Eggs 60 g # 24 x 60 g', NULL, '', 15, 5, 64481, 64481, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4670, 'ZAI01F0', '8004735106183', 'ZAI - Tayo Trio Eggs 60 g # 24 x 60 g', 15, 'ZAI - Tayo Trio Eggs 60 g # 24 x 60 g', NULL, '', 15, 5, 64481, 64481, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4671, 'ZAI0200', '80838876', 'ZAI - Crockki Mickey 18 g # 2 x 24 x 18 g', 15, 'ZAI - Crockki Mickey 18 g # 2 x 24 x 18 g', NULL, '', 15, 5, 22099, 22099, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4672, 'ZAI0211', '80774914', 'ZAI - Crockki Minnie 18 g # 2 x 24 x 18 g', 15, 'ZAI - Crockki Minnie 18 g # 2 x 24 x 18 g', NULL, '', 15, 5, 22099, 22099, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4673, 'ZAI0220', '80871170', 'ZAI - Crockki Frozen 18 g # 2 x 24 x 18 g', 15, 'ZAI - Crockki Frozen 18 g # 2 x 24 x 18 g', NULL, '', 15, 5, 22099, 22099, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4674, 'ZAI0230', '80884415', 'ZAI - Crockki Cars 18 g # 2 x 24 x 18 g', 15, 'ZAI - Crockki Cars 18 g # 2 x 24 x 18 g', NULL, '', 15, 5, 22099, 22099, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4675, 'ZAI0240', '80985754', 'ZAI - Crockki Tsum - Tsum 18 g # 2 x 24 x 18 g', 15, 'ZAI - Crockki Tsum - Tsum 18 g # 2 x 24 x 18 g', NULL, '', 15, 5, 22099, 22099, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4676, 'ZAI0400', '8004735065206', 'ZAI - Ciocobisco # 18 x 100 g', 15, 'ZAI - Ciocobisco # 18 x 100 g', NULL, '', 15, 5, 72655, 72655, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4677, 'ZAI0410', '8004735065237', 'ZAI - Noughita # 18 x 100 g', 15, 'ZAI - Noughita # 18 x 100 g', NULL, '', 15, 5, 72655, 72655, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4678, 'ZAI0421', '8004735108064', 'ZAI - Boero Cherry  # 12 X 210 g', 15, 'ZAI - Boero Cherry  # 12 X 210 g', NULL, '', 15, 5, 128155, 128155, 0, NULL, '', '2023-01-18 16:27:23', NULL, NULL, NULL, NULL),
(4679, 'ALB0120', '9311766000212', 'ALB - Shredded Cheddar 250 g # 16 x 250 g', 15, 'ALB - Shredded Cheddar 250 g # 16 x 250 g', NULL, '', 15, 5, 100000, 100000, 0, NULL, '', '2023-02-06 13:44:12', NULL, NULL, NULL, NULL),
(4680, 'ALB0190', '9311766000205', 'ALB - Grated Parmesan 2 kg # 6 x 2 kg', 15, 'ALB - Grated Parmesan 2 kg # 6 x 2 kg', NULL, '', 15, 5, 300000, 300000, 0, NULL, '', '2023-02-06 15:27:54', NULL, NULL, NULL, NULL),
(4681, 'DCG0610', '38009747', 'Pack-FA Kain Tile (S)', 15, 'Pack-FA Kain Tile (S)', NULL, NULL, 15, 5, 15000, 15000, 0, NULL, NULL, '2023-02-07 10:13:11', NULL, NULL, NULL, NULL),
(4682, 'DCG0620', '38009761', 'Pack-FA Pita', 15, 'Pack-FA Pita', NULL, NULL, 15, 5, 8000, 8000, 0, NULL, NULL, '2023-02-07 10:13:11', NULL, NULL, NULL, NULL),
(4683, 'DCG0630', '38011887', 'LDT-Exc Mix Valentine 200gr', 15, 'LDT-Exc Mix Valentine 200gr', NULL, NULL, 15, 5, 105000, 105000, 0, NULL, NULL, '2023-02-07 10:13:11', NULL, NULL, NULL, NULL),
(4684, 'DCG0640', '38011894', 'LDT-Lindor Mix Valentine 250gr', 15, 'LDT-Lindor Mix Valentine 250gr', NULL, NULL, 15, 5, 122000, 122000, 0, NULL, NULL, '2023-02-07 10:13:11', NULL, NULL, NULL, NULL),
(4685, 'DCG0650', '38011900', 'LDT-Les Garndes Mix Valent250g', 15, 'LDT-Les Garndes Mix Valent250g', NULL, NULL, 15, 5, 105000, 105000, 0, NULL, NULL, '2023-02-07 10:13:11', NULL, NULL, NULL, NULL),
(4686, 'DCG0660', '38011917', 'WTR-Teddy Bear Cream Choco', 15, 'WTR-Teddy Bear Cream Choco', NULL, NULL, 15, 5, 99000, 99000, 0, NULL, NULL, '2023-02-07 10:13:11', NULL, NULL, NULL, NULL),
(4687, 'DCG0670', '38011924', 'WTR-Teddy Bear White Choco', 15, 'WTR-Teddy Bear White Choco', NULL, NULL, 15, 5, 99000, 99000, 0, NULL, NULL, '2023-02-07 10:13:11', NULL, NULL, NULL, NULL),
(4688, 'DCG0680', '38011948', 'VLR-w/Teddy Bear Brown Mix Val', 15, 'VLR-w/Teddy Bear Brown Mix Val', NULL, NULL, 15, 5, 115000, 115000, 0, NULL, NULL, '2023-02-07 10:13:11', NULL, NULL, NULL, NULL),
(4689, 'DCG0690', '38011931', 'MCV-w/Teddy Bear Cream Valenti', 15, 'MCV-w/Teddy Bear Cream Valenti', NULL, NULL, 15, 5, 179000, 179000, 0, NULL, NULL, '2023-02-07 10:13:11', NULL, NULL, NULL, NULL),
(4690, 'ALB0130', '9311766000625', 'ALB - Shredded Cheddar 500 g # 12 x 500 g', 15, 'ALB - Shredded Cheddar 500 g # 12 x 500 g', NULL, NULL, 15, 5, 50000, 50000, 0, NULL, NULL, '2023-02-08 13:02:55', NULL, NULL, NULL, NULL),
(4691, 'DCG0710', '380084120', 'Buy paper bag L', 15, 'Buy paper bag L', NULL, NULL, 15, 5, 45000, 45000, 0, NULL, NULL, '2023-02-08 13:25:28', NULL, NULL, NULL, NULL),
(4692, 'ZAI0241', '080985754', 'ZAI - Crockki Tsum - Tsum 18 g # 12 x 12 x 18 g', 15, 'ZAI - Crockki Tsum - Tsum 18 g # 12 x 12 x 18 g', NULL, NULL, 15, 5, 0, 0, 0, NULL, NULL, '2023-02-11 11:14:45', NULL, NULL, NULL, NULL),
(4693, 'DCG7101', '38011597', 'Pack-Keranjang Santa Claus', NULL, 'Pack-Keranjang Santa Claus', NULL, NULL, 15, 5, 195000, 195000, 177273, NULL, NULL, '2023-02-21 09:14:34', NULL, NULL, NULL, NULL),
(4694, 'DCG7102', '0000000000481', 'LDT-Excellence Extra Creamy', NULL, 'LDT-Excellence Extra Creamy', NULL, NULL, 15, 5, 0, 0, 0, NULL, NULL, '2023-02-21 09:14:34', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `p_item_detail`
--

CREATE TABLE `p_item_detail` (
  `id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_code` varchar(255) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `exp_date` date DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `p_item_detail`
--

INSERT INTO `p_item_detail` (`id`, `item_id`, `item_code`, `barcode`, `name`, `qty`, `exp_date`, `created_by`, `created_at`) VALUES
(4989, 4331, 'ALB0100', '9311766000007', 'ALB - Mozzarella 250 g # 12 x 250 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(4990, 4332, 'ALB0110', '9311766000014', 'ALB - Mozzarella 500 g # 12 x 500 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(4991, 4333, 'AMS0100', '6936756230580', 'AMS - 4D Gummy Block 40g # 8 x 12 x 40g', 997, '2023-12-31', '1', '2023-02-21 01:49:50'),
(4992, 4334, 'AMS0200', '6936756230603', 'AMS - 4D Gummy Block 72g # 36 x 72g', 986, '2023-12-31', '1', '2023-02-21 01:49:50'),
(4993, 4335, 'ASF0130', '6281073210181', 'ASF - Natural Honey # 12 x 500 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(4994, 4336, 'ASF01A0', '6281073210198', 'ASF - Natural Honey 500g+125g 1Pc # 12 x 625 Pcs', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(4995, 4337, 'BCF0200', '8888089990502', 'BCF - Colombiana Instant Coffee (Merah) 50g # 12 x 50g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(4996, 4338, 'BCF0210', '8888089991004', 'BCF - Colombiana Instant Coffee (Merah) 100g # 12 x 100g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(4997, 4339, 'CAO0100', '7612100113110', 'CAO - Caotina Original 200 g # 6 x 200 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(4998, 4340, 'CAO0110', '7612100019184', 'CAO - Caotina Original 500 g # 6 x 500 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(4999, 4341, 'CAO0120', '7612100055519', 'CAO - Caotina Noir 500 g # 6 x 500 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5000, 4342, 'CAO0130', '7612100055496', 'CAO - Caotina Blanc 500 g # 6 x 500 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5001, 4343, 'CAO0140', '7612100800621', 'CAO - Chocolate Spread 300 g # 6 x 300 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5002, 4344, 'CAV0100', '5413623900032', 'CAV - Cavalier Bar Milk 44 g # 10 X 16 X 44 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5003, 4345, 'CAV0111', '5413623900025', 'CAV - Cavalier Bar Dark 44 g # 10 X 16 X 44 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5004, 4346, 'CAV0120', '5413623900063', 'CAV - Cavalier Bar Milk Pralinut 42 g # 10 X 16 X 42 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5005, 4347, 'CAV0130', '5413623101002', 'CAV - Cavalier Tablet Milk 85 g # 6 X 14 X 85 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5006, 4348, 'CAV0140', '5413623301006', 'CAV - Cavalier Tablet Dark 85 g # 6 X 14 X 85 g', 998, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5007, 4349, 'CAV0151', '5413623201009', 'CAV - Cavalier Tablet M Hazelnut 85 g # 6 X 14 X 85 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5008, 4350, 'CAV0160', '5413623850047', 'CAV - Cavalier Tablet White 85 g # 6 X 14 X 85 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5009, 4351, 'CCO0300', '8997011630871', 'CCO - Bali Ass gift Pack # 24 x 170 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5010, 4352, 'CCO0310', '8997011630888', 'CCO - Borobudur Almond gift Pack # 24 x 170 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5011, 4353, 'CCO0320', '8997011631823', 'CCO - Wayang Kulit Nakula 170 g # 1 x 24 x 170 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5012, 4354, 'CCO0330', '8997011631830', 'CCO - Wayang Kulit Bima 170 g # 1 x 24 x 170 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5013, 4355, 'CCO0340', '8997011631816', 'CCO - Wayang Kulit Arjuna Ass 170 g # 1 x 24 x 170 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5014, 4356, 'CCO0350', '8997011631809', 'CCO - Wayang Kulit Yudhistira Ass 170 g # 1 x 24 x 170 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5015, 4357, 'CCO0380', '8997011631229', 'CCO - Bali 3Dancers Gift Pack # 24 x 170 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5016, 4358, 'CCO0390', '8997011631212', 'CCO - Bali Lion Head Gift Pack # 24 x 170 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5017, 4359, 'CCO03A0', '8997011631236', 'CCO - Beautiful Indonesia Asst # 24 x 170 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5018, 4360, 'CCO0400', '8997011630314', 'CCO - Hazelnut w/ Rice Cereal  # 24 x 135 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5019, 4361, 'CCO0410', '8997011630284', 'CCO - Almond w/ Rice Cereal # 24 x 135 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5020, 4362, 'CCO0420', '8997011630253', 'CCO - Milk Choco w/ Rice Cereal # 24 x 135 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5021, 4363, 'CCO0430', '8997011630321', 'CCO - Cylinder Jar Hazelnut  # 24 x 262.5 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5022, 4364, 'CCO0440', '8997011630291', 'CCO - Cylinder Jar Almond  # 24 x 262.5 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5023, 4365, 'CCO0450', '8997011630260', 'CCO - Cylinder Jar Milk Chocolat # 24 x 262.5 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5024, 4366, 'CCO0460', '8997011630338', 'CCO - Square Jar Hazelnut # 18 x 525 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5025, 4367, 'CCO0470', '8997011630307', 'CCO - Square Jar Almond # 18 x 525 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5026, 4368, 'CCO0480', '8997011630277', 'CCO - Square Jar Milk Chocolate # 18 x 525 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5027, 4369, 'CCO0500', '8997011630017', 'CCO - Milk Bar 50 g # 12 x 20 x 50 g', 998, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5028, 4370, 'CCO0510', '8997011630024', 'CCO - Milk Bar 100 g # 12 x 10 x 100 g', 998, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5029, 4371, 'CCO0520', '8997011630031', 'CCO - Milk Bar 200 g # 6 x 10 x 200 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5030, 4372, 'CCO0530', '8997011630079', 'CCO - Almond Bar 50 g # 12 x 20 x 50 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5031, 4373, 'CCO0540', '8997011630086', 'CCO - Almond Bar 100 g # 12 x 10 x 100 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5032, 4374, 'CCO0550', '8997011630093', 'CCO - Almond Bar 200 g # 6 x 10 x 200 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5033, 4375, 'CCO0560', '8997011630109', 'CCO - Fruit and Nut Bar 50 g # 12 x 20 x 50 g', 995, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5034, 4376, 'CCO0570', '8997011630116', 'CCO - Fruit and Nut Bar 100 g # 12 x 10 x 100 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5035, 4377, 'CCO0580', '8997011630123', 'CCO - Fruit and Nut Bar 200 g # 6 x 10 x 200 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5036, 4378, 'CCO0590', '8997011630048', 'CCO - Hazelnut Bar 50 g # 12 x 20 x 50 g', 998, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5037, 4379, 'CCO05A0', '8997011630055', 'CCO - Hazelnut Bar 100 g # 12 x 10 x 100 g', 997, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5038, 4380, 'CCO05B0', '8997011630062', 'CCO - Hazelnut Bar 200 g # 6 x 10 x 200 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5039, 4381, 'CLN0100', '8992919141405', 'CLN - Collin''s Butter Nut 48g # 20 (15 x 3.2)', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5040, 4382, 'CRM0160', '9319133338012', 'CRM - Deluxe  Gluten Free 400 g # 6 x 400 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5041, 4383, 'DCG0100', '00004', 'FA-Large Canopy Toys', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5042, 4384, 'DCG0200', '0022', 'FA-Roadster Car-Green', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5043, 4385, 'DCG0300', '00330006', 'FA-Mug w/Animal CharacterHandl', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5044, 4386, 'DCG0400', '0049', 'FA-Embassed Pasta & Sphagetty ', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5045, 4387, 'DCG0500', '1509200831029', 'FA-Parcel Type B', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5046, 4388, 'DCG0600', '1509200831036', 'FA-Parcel Type D', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5047, 4389, 'DCG0700', '38011955', 'LDT-W/Teddy Bear Big Mix Valen', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5048, 4390, 'DCG0800', '2008313600052', 'FA-Paper Bag (L)', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5049, 4391, 'DCG0900', '2008313600076', 'FA-Paper Bag (S)', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5050, 4392, 'DCG1000', '2008313600083', 'FA-Paper Bag (M)', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5051, 4393, 'DCG1100', '38000255', 'FA-Teddy In Bath', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5052, 4394, 'DCG1200', '38000300', 'FA-Large Canopy Grocer', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5053, 4395, 'DCG1300', '38000317', 'FA-Large Canopy Bakery', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5054, 4396, 'DCG1400', '38000331', 'FA-Winter Canopy Cookies', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5055, 4397, 'DCG1500', '38000768', 'Box Teddy Bear W/Handle (S)', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5056, 4398, 'DCG1600', '38001048', 'FA-Brown Basket W/ Handle (S)', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5057, 4399, 'DCG1700', '38001055', 'FA-Brown Basket W/ Handle (M)', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5058, 4400, 'DCG1800', '38001727', 'FA-Kereta Salju Besar', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5059, 4401, 'DCG1900', '38003134', 'FA-Terry Box Chef Medium 5426 ', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5060, 4402, 'DCG2000', '38003158', 'FA-Ugly Cute Boy Medium 5554', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5061, 4403, 'DCG2100', '38003172', 'FA-Ugly Cute Boy Birthday 5563', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5062, 4404, 'DCG2200', '38003189', 'FA-Ugly Cute Girl Birthday5564', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5063, 4405, 'DCG2300', '38003219', 'FA-Bull Medium Jar 5430', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5064, 4406, 'DCG2400', '38003226', 'FA-Cow Medium Jar 5432', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5065, 4407, 'DCG2500', '38003240', 'FA-Tiger Medium Jar 5550', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5066, 4408, 'DCG2600', '38003257', 'FA-Dwarf Medium Jar 5670', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5067, 4409, 'DCG2700', '38003301', 'FA-Layer Pandan Box', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5068, 4410, 'DCG2800', '38003363', 'FA-Chicken Medium Jar w/Choc', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5069, 4411, 'DCG2900', '38003417', 'FA-Frog Medium Jar with Choco', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5070, 4412, 'DCG3000', '38003523', 'FA-Maize Basket Mocca 0274 (L)', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5071, 4413, 'DCG3100', '38003530', 'FA-Maize Basket Mocca 0274 (M)', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5072, 4414, 'DCG3200', '38003547', 'FA-Maize Basket Mocca 0274 (S)', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5073, 4415, 'DCG3300', '38006081', 'Pack - Keranjang Majalah Imlek', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5074, 4416, 'DCG3700', '38008276', 'Pack- Keranjang Rutan Bulat', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5075, 4417, 'DCG3800', '38008319', 'Pack - Box Kotak DG Coklat ', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5076, 4418, 'DCG4000', '38008405', 'Pack- Fa Happy Holiday Paper S', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5077, 4419, 'DCG4100', '38008412', 'Pack- Fa Happy Holiday Paper L', 989, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5078, 4420, 'DCG4200', '38008474', 'Pack - Keranjang Kotak Kuping ', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5079, 4421, 'DCG4300', '38008481', 'Pack - Keranjang Rotan Besar ', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5080, 4422, 'DCG4400', '38008665', 'Pack - Keranjang Tangkai 1 Pcs', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5081, 4423, 'DCG4500', '38009044', 'Pack - FA Lebaran Green Round ', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5082, 4424, 'DCG4600', '38010514', 'Pack- Box Christmas Long', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5083, 4425, 'DCG4700', '38010873', 'Pack-FA Baki Gelombang Natal S', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5084, 4426, 'DCG4800', '38010958', 'Pack-keranjang Tangkai Saley K', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5085, 4427, 'DCG4900', '38010965', 'Pack-Keranjang Sariman Kotak ', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5086, 4428, 'DCG5000', '38010972', 'Pack - Keranjang Santa', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5087, 4429, 'DCG5200', '4891034041048', 'Gift-Lindt Coffee Mug', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5088, 4430, 'DCG5300', '7610062081065', 'Jura Waffer mini', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5089, 4431, 'DCG5400', '7610062092566', 'Mini Chocobeau ', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5090, 4432, 'DCG5500', '7610400030632', 'Lindor Cornet White 200 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5091, 4433, 'DCG5600', '7610400936521', 'LDT-SURFIN BULK', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5092, 4434, 'DCG5700', '7610400988889', 'Lindor White Gift Box', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5093, 4435, 'DCG5800', '8000000780003', 'FA-Pix Mix Chocolate 1', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5094, 4436, 'DCG6000', '9403142002238', 'White Chocolate block 200 gr', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5095, 4437, 'DCG6100', '38011634', 'Pack-Keranjang Oval Rotan S', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5096, 4438, 'DCG6200', '38011641', 'Pack-keranjang Oval Rotan M', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5097, 4439, 'DCG6400', '70177118495', 'TWN- Strawberry & Mango 50 gr', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5098, 4440, 'DCG6500', '7610062211851', 'WNL- Pack Sleeve', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5099, 4441, 'DCG7100', '38008887', 'FA - kantor plastik coklat 1 pcs ', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5100, 4442, 'ESP0210', '9311755200609', 'ESP - OLD STYLE LEMON LIME BITTE # 24 x 275 Ml', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5101, 4443, 'ESP0220', '9349277000612', 'ESP - Classic Cola 275 ml # 24 x 275 ml', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5102, 4444, 'ESP0230', '9311755200586', 'ESP - OLD STYLE GINGER BEER # 24 x 275 Ml', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5103, 4445, 'FAM9710', '38000614', 'FA - Plastic Bag # 1 x 1 pcs', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5104, 4446, 'FAM9760', '2008311300237', 'FA - Thermal Roll Paper # 1 x 1 pcs', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5105, 4447, 'FAM9800', '38006678', 'FA - Fa Hand glove 1 Pck # 1 x 1 Pck', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5106, 4448, 'FAM9830', '38006685', 'FA - Fa Plastik Opp 1 Pck # 1 x 1 Pck', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5107, 4449, 'FAM9860', '38006692', 'FA - Fa Solatip/Nachi Tape 1 Pc # 1 x 1 Pc', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5108, 4450, 'FAM9900', '38008603', 'FA - Pack Christmas Box Large 1 Pcs # 1 x 1 Pcs', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5109, 4451, 'FAM9910', '38008597', 'FA - Pack Christmas Box Medium 1 Pcs # 1 x 1 Pcs', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5110, 4452, 'FAM9920', '38008580', 'FA - Christmas Box Small 1 Pcs # 1 x 1 Pcs', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5111, 4453, 'GAL0150', '8001420003383', 'GAL - Base Mushroom # 5x1kg', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5112, 4454, 'GOL0100', '7610403072547', 'GOLD - Amarula #10(1x100g) # 10 x 1 x 100 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5113, 4455, 'GOL0110', '7610403072103', 'GOLD - Cointreau #10(1x100g) # 10 x 1 x 100 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5114, 4456, 'GOL0120', '7610403072561', 'GOLD - Jackdaniels Tennessee Honey 100g # 10 x1x100 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5115, 4457, 'GOL0130', '7610403072509', 'GOLD - Jackdaniels Tennessee Whiskey 100 # 10 x 1x 100 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5116, 4458, 'GOL0140', '7610403072707', 'GOLD - Remy Martin #10(1x100g) # 10 x 1 x 100 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5117, 4459, 'GOL0150', '7610403072523', 'GOLD - The Famous gouse #10(1x100g) # 10 x 1 x 100 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5118, 4460, 'HOR0120', '8886467076145', 'HOR - Cereal 3 in 1 320g # 24x320g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5119, 4461, 'JLB0100', '745092012295', 'JLB - Jelly Bean Sachet 50 g # 24 x 50 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5120, 4462, 'JLB0110', '745092006942', 'JLB - Jelly Bean 36Flavours 75gr # 9x16x75gr', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5121, 4463, 'JLB0120', '745092014428', 'JLB - Jelly Bean Pop A Bean 100gr # 12 x 100gr', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5122, 4464, 'JLB0130', '745092006058', 'JLB - Jelly Bean 36 Flavours # 4 x 24 x 100gr', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5123, 4465, 'JLB0140', '745092010932', 'JLB - Jelly Bean Pouch Bag 113gr # 12 x 113gr', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5124, 4466, 'JLB0150', '745092000933', 'JLB - Jelly Bean Cup # 12 x 200 gr', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5125, 4467, 'JLB0160', '8713800139307', 'JLB - Jelly Bean Tube 90g # 24 x 90g', 998, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5126, 4468, 'JLB0170', '8713800139208', 'JLB - Jelly Bean Pouch 70g # 20 x 70g', 997, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5127, 4469, 'LAK0100', '8013399168338', 'LAKE - Fruity Drops Honey Lemon #  ( 12 x 16 ) x 40g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5128, 4470, 'LAK0110', '8013399168345', 'LAKE - Fruity Drops Honey Strawberry # ( 12 x 16 ) x 40g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5129, 4471, 'LAK0120', '8013399168222', 'LAKE - Fruity Drops Honey Yuzu # ( 12 x 16 ) x 40g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5130, 4472, 'LAK0130', '8013399168291', 'LAKE - Fruity Drops Honey Lemon Tea #  ( 12 x 16 ) x 40g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5131, 4473, 'LDT0100', '7610400010108', 'LDT - Surfin 100gr # (12x12)x100 gr', 997, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5132, 4474, 'LDT0110', '7610400014571', 'LDT - White Chocolate 100gr # (12x12)x100 gr', 995, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5133, 4475, 'LDT0120', '7610400010016', 'LDT - Milk 100gr # (12x12)x100 gr', 998, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5134, 4476, 'LDT0130', '7610400010023', 'LDT - Milk Hazelnut 100gr # (12x12)x100 gr', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5135, 4477, 'LDT0140', '7610400014038', 'LDT - Milk Whole Almonds 100gr # (12x12)x100 gr', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5136, 4478, 'LDT0150', '7610400010368', 'LDT - Milk Raisin Nut 100gr # (12x12)x100 gr', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5137, 4479, 'LDT0400', '3046920028721', 'LDT - Excellence Dark Cocoa 99% # 6 x 18 x 50 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5138, 4480, 'LDT0410', '3046920029759', 'LDT - Excellence 90% Cacao 100 gr # 6x20x100 gr', 998, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5139, 4481, 'LDT0420', '3046920028363', 'LDT - Excellence Dark 85 # 6 x 20 x 100 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5140, 4482, 'LDT0430', '3046920010047', 'LDT - Excellence Dark Cocoa 78% 100g # 6 x 20 x 100g', 997, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5141, 4483, 'LDT0440', '3046920028004', 'LDT - Excellence Dark Cocoa 70% # 6 x 20 x 100 g', 998, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5142, 4484, 'LDT0450', '3046920028370', 'LDT - Excellence Orange 100g # 6 x 20 x 100 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5143, 4485, 'LDT0460', '7610400010481', 'LDT - Excellence Extra Creamy # 6 x 20 x100 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5144, 4486, 'LDT0470', '3046920028752', 'LDT - Exellence Mint Intense # 6 x 20 x 100 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5145, 4487, 'LDT0480', '3046920029674', 'LDT - Excel  Sea Salt 100 g # 6 x 20 x 100 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5146, 4488, 'LDT0491', '3046920028585', 'LDT - Excellence Dark 70% 35g # 2 x 24 x 35g', 996, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5147, 4489, 'LDT04A1', '3046920011600', 'LDT - Excellence Milk 35 g # 2 x 24 x 35 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5148, 4490, 'LDT04B0', '3046920029582', 'LDT - Excellence Dark 85% 35g # 2 x 24 x 35g', 997, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5149, 4491, 'LDT0622', '7610400087346', 'LDT - Les Grandes Noisettes Caramel # 6 x 13 x 150g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5150, 4492, 'LDT0631', '7610400085946', 'LDT - Les Grandes Amandes-Fleur De Sel # 15 x 150g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5151, 4493, 'LDT0700', '7610400029841', 'LDT - Dark Thins 125 g # (1x9)x125 g', 996, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5152, 4494, 'LDT0710', '7610400029810', 'LDT - Milk Thins 125g # (1x9)x125 g', 992, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5153, 4495, 'LDT0800', '7610400071925', 'LDT - Lindor Trio Extra Dark 60% # 24 X 37 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5154, 4496, 'LDT0820', '7610400069502', 'LDT - Lindor Trio Assorted 37g # 24 x 37g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5155, 4497, 'LDT0830', '4894475100190', 'LDT - Lindor Trio Strawberry 37g # 24 x 37g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5156, 4498, 'LDT0840', '4894475100497', 'LDT - Lindor Trio Matcha 37g # 24 x 37g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5157, 4499, 'LDT0900', '7610400074155', 'LDT - Lindor Single 60%Dark 100g # (12x12)x100 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5158, 4500, 'LDT0910', '7610400068369', 'LDT - Lindor Single Hazelnut100g # (12x12)x100 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5159, 4501, 'LDT0920', '7610400014649', 'LDT - Lindor Single Milk 100g # (12x12)x100 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5160, 4502, 'LDT0930', '7610400014632', 'LDT - Lindor Single White 100g # (12x12)x100 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5161, 4503, 'LDT1000', '8003340091280', 'LDT - Lindor Extra Dark 60%Cocoa # 4 X 8 X 200g', 998, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5162, 4504, 'LDT1010', '7610400068505', 'LDT - Lindor Cornet Milk # 4 x 8 x 200 g', 997, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5163, 4505, 'LDT1020', '7610400068529', 'LDT - Lindor Cornet Assorted # 4 x 8 x 200 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5164, 4506, 'LDT1040', '8003340097619', 'LDT - Lindor Cornet Strawberry 200g # 8 x 200g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5165, 4507, 'LDT1100', '7610400983082', 'LDT - Lindor Extra Dark 60% gift # 1 x 10 x 168 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5166, 4508, 'LDT1101', '7610400987318', 'LDT - Lindor Ass Gift Box 168g # 1 x 10 x 168 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5167, 4509, 'LDT1110', '7610400060950', 'LDT - Lindor Milk Gift Box 168g # 1 x 10 x 168 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5168, 4510, 'LDT1150', '4894475100343', 'LDT - Lindor gift Box Straw&Cream 144g # 12 x 144 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5169, 4511, 'LDT8070', '4894475100022', 'LDT - 3D Star Tin 37 g # 10 x 37 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5170, 4512, 'LDT8080', '4894475100015', 'LDT - 3D Tree Tin 37 g # 10 x 37 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5171, 4513, 'Ldt8090', '4894475100053', 'LDT - Lindor Mini 3D Heart Tin # 10 x 37 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5172, 4514, 'LDT80A0', '7610400099967', 'LDT - Lindor Mini Box # 24 x 37 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5173, 4515, 'LDT80B0', '4894475100435', 'LDT - Lindor Straw & Cream Mini Heart Tin # 12 x 37 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5174, 4516, 'LDT80G1', '4894475100176', 'LDT - Lindor Crystal Pink Heart Tin 96g # 10 x 96 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5175, 4517, 'LDT80H0', '4894475100138', 'LDT - Blue Mini Milk Can 96 g # 10 x 96 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5176, 4518, 'LDT80I0', '7610400987172', 'LDT - Lindor Crystal Heart Tin 96 g # 10 x 96 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5177, 4519, 'LDT80K0', '7610400075770', 'LDT - Grand Dark Hazelnut 150 g # 6 x 13 x 150 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5178, 4520, 'LDT80L0', '7610400075787', 'LDT - Grand Milk Hazelnut 150 g # 6 x 13 x 150 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5179, 4521, 'LDT9010', '2009380400002', 'LDT - Lindor Dark Bulk # 1 X 1 Kg', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5180, 4522, 'LDT9020', '38004131', 'LDT - Lindor Hazelnut Bulk 1Kg # 1 X 1 Kg', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5181, 4523, 'LDT9030', '8000000900005', 'LDT - Lindor Milk Bulk # 1 X 1 Kg', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5182, 4524, 'LDT9041', '38010828', 'LDT - Lindor Teddy Tin 8''s #10x96 gr', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5183, 4525, 'LIP0120', '8999999573409', 'LIP - Delight 24gr # 24 x (15x1.6gr)', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5184, 4526, 'MAN0100', '048176990091', 'MANT -  SPRAY EXTRA VIRGIN OIL # 6(1x250ml)', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5185, 4527, 'MCV0100', '8906033742455', 'MCV - Digestive Zero 75g # 120x75g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5186, 4528, 'MCV0110', '8906033740208', 'MCV - Butter Cookies 60g # 144x60g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5187, 4529, 'MCV0120', '8906033741595', 'MCV - Marie Wholewheat 100g # 96x100g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5188, 4530, 'MCV0130', '8906033740758', 'MCV - Digestive 100g # 96x100g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5189, 4531, 'MCV0140', '8906033740963', 'MCV - Bourbon 100g #  96x100g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5190, 4532, 'MCV0230', '5000396037548', 'MCV - Digestive Dark Choco UK # 24x200', 996, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5191, 4533, 'MCV0240', '5000396037531', 'MCV - Digestive Milk Choco UK # 24x200', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5192, 4534, 'MCV0260', '5000396033311', 'MCV - HobNobs Oat Crunch # 10x300', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5193, 4535, 'MCV0270', '5000396022315', 'MCV - HobNobs Milk Choco Oat # 24x300', 992, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5194, 4536, 'NAT0140', '016000295704', 'NATY - Apple Crisp 253 g # 12 x 253 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5195, 4537, 'OEP0100', '8410076481597', 'OEP - Tortilla Chips Original  # 10X185G', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5196, 4538, 'OEP0110', '8410076481764', 'OEP - Tortilla Chips Chili # 10X185G', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5197, 4539, 'OEP0120', '8410076482556', 'OEP - Tortila Chips Paprika # 10X185G', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5198, 4540, 'OEP0130', '8410076481757', 'OEP - Tortilla Chips Fajita # 10X185G', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5199, 4541, 'OVM0100', '7612100027158', 'OVM - Crunchy Cream 380g # 12 x 380g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5200, 4542, 'OVM0110', '7612100030677', 'OVM - Crunchy Cream 680g # 6 x 680g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5201, 4543, 'STD0120', '084380957741', 'STD - Raspberry 284g # 12 x 284g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5202, 4544, 'STK0100', '4014400400007', 'STK - Toffiffee 125g # 15 x 125 g', 997, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5203, 4545, 'STK0110', '4014400900804', 'STK - Mint Chocs 200g # 15 x 200g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5204, 4546, 'STK0120', '40144078', 'STK - Knoppers 75g # 24 x 75g', 998, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5205, 4547, 'STK0130', '40144061', 'STK - Knoppers 25g # 6 x 24 x 25g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5206, 4548, 'STK0140', '4014400901191', 'STK - Mercy Grosse Vielfalt (Red) 250gr # 3 x 10 x 250gr', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5207, 4549, 'STK0141', '4014400900217', 'STK - Mercy Grosse Vielfalt (red) 400 gr # 8 x 400 gr', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5208, 4550, 'STK0150', '4014400901405', 'STK - Mercy Helle Viefalt (Blue) 250gr # 3 x 10 x 250gr', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5209, 4551, 'STK0160', '4014400925395', 'STK - Merci Petits Collection 125g # 12 x 125g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5210, 4552, 'STK0170', '40144924', 'STK - Riesen 45g # 4 x 24 x 45g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5211, 4553, 'STK0190', '4014400902495', 'STK - Riesen 150g # 15 x 150g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5212, 4554, 'STK0200', '40144016', 'STK - Werthers Echte Original 50g # 6 x 24 x 50g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5213, 4555, 'STK0210', '4014400918083', 'STK - Werthers Echte Original 90g # 12 x 90g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5214, 4556, 'STK0220', '4014400918113', 'STK - Werthers Original Toffee 80g # 12 x 80g', 998, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5215, 4557, 'STK0230', '4014400918205', 'STK - Werthers Original Caramel Chew 48g # 6 x 24 x 48g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5216, 4558, 'STK0240', '4014400918106', 'STK - Werthers Original Creamy Filling80g # 12 x 80g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5217, 4559, 'STR0101', '38006821', 'STR - Lady Bird Bag 42g # 12 x 42g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5218, 4560, 'STR0111', '38006845', 'STR - Sea Life Bag 43g # 12 x 43g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5219, 4561, 'STR0121', '38006852', 'STR - Farm Life Bag 55g # 12 x 55g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5220, 4562, 'STR0131', '38006838', 'STR - Wild Life Bag # 12 x 58g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5221, 4563, 'STR0140', '4003006010260', 'STR - Bee Bag  37.5 g # 6 x 36 x 37.5 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5222, 4564, 'STR0150', '4003006030749', 'STR - Sheep Bag  50 g # 6 x 36 x 50 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5223, 4565, 'STR0161', '4003006130548', 'STR - Lady Birds Tub 100 g # 6 x 24 x 100 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5224, 4566, 'STR0171', '4003006141032', 'STR - Soccer Player Tub  # 6 x 24 x 75 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5225, 4567, 'STR0180', '4003006129245', 'STR - Big Box Farm 300 g # 8 x 300 g', 998, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5226, 4568, 'STR0190', '4003006118249', 'STR - Big Box Wildlife 300 g # 8 x 300 g', 997, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5227, 4569, 'STR01A0', '4003006152243', 'STR - Big Box Sealife 300 g # 8 x 300 g', 998, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5228, 4570, 'TWN0100', '070177010799', 'TWN - Darjeeling Tea 50 g # 12 x ( 25 x 2 g)', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5229, 4571, 'TWN0110', '070177010775', 'TWN - English Breakfast Tea 50 g # 12 x (25 x 2 g)', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5230, 4572, 'TWN0210', '070177173173', 'TWN - Green Tea Earl Grey 40 g # 12 x (25 x 1.6 g)', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5231, 4573, 'TWN0220', '070177077198', 'TWN - Lady Grey Tea 50 g # 12 x (25 x 2 g)', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5232, 4574, 'TWN0230', '070177051174', 'TWN - TWN - Earl Grey Decaf Tea 50 g # 12 x (25x2 g)', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5233, 4575, 'TWN0260', '070177055639', 'TWN - Peach Tea 50 g # 12 x (25x2 g)', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5234, 4576, 'TWN0300', '070177086664', 'TWN - Pure  Green Tea 50 g # 12 x (25x2 g)', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5235, 4577, 'TWN0310', '070177173166', 'TWN - Green Tea Jasmine 45 g # 12 x (25x1.8 g)', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5236, 4578, 'TWN0340', '070177229986', 'TWN - Green Tea Collection 34 g # 8 x (25x1.7 g)', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5237, 4579, 'TWN0400', '070177118525', 'TWN - Pure Peppermint 50 g # 12 x (25x2 g)', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5238, 4580, 'TWN0430', '070177118495', 'TWN - Strawberry & Mango 50gr # 12 x (25x2gr)', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5239, 4581, 'TWN0500', '070177029623', 'TWN - Black Tea Earl  Grey Tin 100 g # 6 x 100 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5240, 4582, 'TWN0510', '070177029630', 'TWN - English Breakfast Tea Tin 100 g # 6 x 100 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5241, 4583, 'TWN1020', '0070177010768', 'TWN - Promo Pack (Earl Grey+Asf Nat 125g) # 12 X (25x2g)', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5242, 4584, 'TWN1050', '38010132', 'TWN - Seasonal (English 50g+WNL 100g)#6x150g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5243, 4585, 'TWN1070', '38010712', 'TWN - Seasonal Breakfast Box 714gr # 12 x (50gr+380gr+284gr)', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5244, 4586, 'TWN9910', '38008054', 'TWN - Twn Mug Trumpet 1 Pcs # 1 x 1 Pcs', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5245, 4587, 'VLR0100', '8410109055887', 'VLR - Dark Chocolate Sugar Free 100 g # 6 x 17 x 100 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5246, 4588, 'VLR0110', '8410109055795', 'VLR - Milk Chocolate No Sugar Added 100 g # 6 x 17 x 100 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5247, 4589, 'VLR0120', '8410109050882', 'VLR - 70% Dark Chocolate Sugar Free 100 g # 6 x 17 x 100 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5248, 4590, 'VLR0130', '8410109109832', 'VLR - 85% Dark Chocolate Sugar Free 100 g # 6 x 17 x 100 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5249, 4591, 'VLR0140', '8410109056525', 'VLR - Dark Chocolate W/ Orange Creamy 100 g # 6 x 17 x 100 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5250, 4592, 'VLR0150', '8410109056532', 'VLR - Dark Chocolate W/ Truffle Creamy 100 g # 6 x 17 x 100 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5251, 4593, 'VOR0120', '067312005499', 'VORT - Sugar Free Fudge Choc Chip 227 g # 12 x 227 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5252, 4594, 'VOR0130', '067312005505', 'VORT - Sugar Free Chocolate Chip 227 g # 12 x 227 g', 998, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5253, 4595, 'VOR0200', '067312005215', 'VORT - Sugar Free Lemon Wafers 255 g # 12 x 255 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5254, 4596, 'VOR0220', '067312005260', 'VORT - Sugar Free Chocolate Wafers 255 g # 12 x 255 g', 998, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5255, 4597, 'WDR0100', '014113940092', 'WDR - Pistachios Clas Salt 50 g # 48 x 50 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5256, 4598, 'WDR0110', '014113940054', 'WDR  -Pistachios Clas Salt 168 g # 24 x 168 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5257, 4599, 'WDR0120', '014113940023', 'WDR - Pistachios Clas Salt 454 g # 12 x 454 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5258, 4600, 'WDR0130', '014113940214', 'WDR - Pistachios Clas Salt 400 g # 12 x 400 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5259, 4601, 'WDR0140', '014113940108', 'WDR - Pistachios PPR & GRLC 50 g # 48 x 50 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5260, 4602, 'WDR0150', '014113940061', 'WDR - Pistachios PPR & GRLC 168 g # 24 x 168 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5261, 4603, 'WDR0160', '014113940207', 'WDR - Pistachios Clas No Salt 50 g # 48 x 50 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5262, 4604, 'WDR0170', '014113940191', 'WDR - Pistachios Clas No Salt 300 g# 24 x 300 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5263, 4605, 'WDR0200', '014113240055', 'WDR - Almonds Clas Salt 50 g # 48 x 50 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5264, 4606, 'WDR0210', '014113240024', 'WDR - Almonds Clas Salt 168 g # 24 x 168 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5265, 4607, 'WDR0220', '014113240031', 'WDR - Almonds Clas Salt 318 g # 24 x 318 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5266, 4608, 'WDR0230', '014113240116', 'WDR - Almonds Clas Salt 500 g # 12 x 500 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5267, 4609, 'WNL0110', '7610037000893', 'WNL - Wernli Choco Fin 100 g  # 12 x 100 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5268, 4610, 'WNL0120', '7610062041809', 'WNL - Wernli Choco Belle 100 g # 12 x 100 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5269, 4611, 'WNL0130', '7610062080341', 'WNL - Choco Petit Beurre 125 g # 16 x 125 g', 995, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5270, 4612, 'WNL0140', '7610062091903', 'WNL - Truffet 100 g # 12 x 100 g', 994, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5271, 4613, 'WNL0150', '7610062000301', 'WNL - Japonais 100 g # 12 x 100 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5272, 4614, 'WNL0180', '07610062092566', 'WNL - Mini Chocobeau 150 g # 12 x 150 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5273, 4615, 'WNL0191', '7610062087135', 'WNL - Petit Amour 150g # 8 x 150 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5274, 4616, 'WNL0200', '7610062001001', 'WNL - Wernli Jura Waffers 250 g # 12 x 250 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5275, 4617, 'WNL0210', '07610062081065', 'WNL - Jura Waffer mini 130 g # 12 x 130 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5276, 4618, 'WTK0100', '94314212', 'WTK - Peanut Slab 50 g # 4 x 50 x 50 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5277, 4619, 'WTK0110', '94314243', 'WTK - Roasted Almond Gold 45 g # 4 x 50 x 45 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5278, 4620, 'WTK0120', '9403142000210', 'WTK - Almond Gold Multi 135 g # 24 x 135 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5279, 4621, 'WTK0130', '9403142000142', 'WTK - Peanut Slab Multi 150 g # 24 x 150 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5280, 4622, 'WTK0200', '9403142002375', 'WTK - Ghana Peppermint Block 220 g # 12 x 220 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5281, 4623, 'WTK0210', '9403142002245', 'WTK - Hazelnut Block 200 g # 12 x 200 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5282, 4624, 'WTK0220', '9403142002467', 'WTK - Peanut Butter Block 220 g # 12 x 220 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5283, 4625, 'WTK0230', '9403142002252', 'WTK - Almond  Gold Block 200 g # 14 x 200 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5284, 4626, 'WTK0240', '9403142002320', 'WTK - Berry Biscuit Block 200 g # 14 x 200 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5285, 4627, 'WTK0250', '9403142002221', 'WTK - Creamy Milk Block 200 g # 14 x 200 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5286, 4628, 'WTK0260', '9403142002269', 'WTK - Dark Almond Block 200 g # 14 x 200 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5287, 4629, 'WTK0270', '9403142002351', 'WTK - Dark Ghana Block 200 g # 14 x 200 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5288, 4630, 'WTK0280', '9403142002214', 'WTK - Fruit Nut Block 200 g # 14 x 200 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5289, 4631, 'WTK0300', '94184648', 'WTK - Sante 72% Dark Ghana # 9 x 48 x 25 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5290, 4632, 'WTK0310', '94314281', 'WTK - Sante Dark Choco # 9 x 48 x 25 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5291, 4633, 'WTK0320', '94314274', 'WTK - Sante Milk Choco Bar # 9 x 48 x 25 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5292, 4634, 'WTK0330', '94314229', 'WTK - Sante White Choco Bar # 9 x 48 x 25 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5293, 4635, 'WTK0400', '9403142000678', 'WTK - Almond Gold Chunks 50 g # 6 x 36 x 50 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5294, 4636, 'WTK0410', '9403142000630', 'WTK - Berry Biscuit Chunks 50 g # 6 x 36 x 50 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5295, 4637, 'WTK0420', '9403142000609', 'WTK - Creamy Milk Cho Chunk 50 g # 6 x ( 36 x 50 g )', 991, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5296, 4638, 'WTK0430', '9403142000654', 'WTK - Dark Almond Chunks 50 g # 6 x 36 x 50 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5297, 4639, 'WTK0440', '9403142000623', 'WTK - Dark Choc ChunkS 50 g # 6 x ( 36 x 50 g )', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5298, 4640, 'WTK0450', '9403142000685', 'WTK - Peppermint Chunks 6 x 36 x 50 g # 6 x 36 x 50 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5299, 4641, 'WTK0460', '9403142000661', 'WTK - Hazelnut Chunks 6 x 36 x 50 g # 6 x 36 x 50 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5300, 4642, 'WTK0470', '9403142001361', 'WTK - 72 % Dark Ghana Chochunks  # 6 x ( 36 x 50 g )', 998, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5301, 4643, 'WTK0480', '9403142000616', 'WTK - Fruit & Nut Choc Chunks # 6 x ( 36 x 50 g )', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5302, 4644, 'WTK0490', '9403142001088', 'WTK - White Choc Chunks # 6 x ( 36 x 50 g )', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5303, 4645, 'WTK0500', '9403142001675', 'WTK - Berry & Biscuit 180 g # 12 x 180 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5304, 4646, 'WTK0510', '9403142001668', 'WTK - Hokey - Pokey 180 g # 12 x 180 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5305, 4647, 'WTR0100', '8003535023218', 'WTR - Bianco Coure 250 g # 12 x 250 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5306, 4648, 'WTR0110', '8003535023171', 'WTR - Golden 250 g # 12 x 250 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5307, 4649, 'WTR0120', '8003535020934', 'WTR - Golden 1 kg # 9 x 1 kg', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5308, 4650, 'WTR0130', '8003535044138', 'WTR - Noir 250 g # 12 x 250 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5309, 4651, 'WTR0140', '8003535023256', 'WTR - Selection Classic 250 g # 12 x 250 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5310, 4652, 'WTR0150', '8003535026578', 'WTR - Selection Classic 1 kg # 9 x 1 kg', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5311, 4653, 'WTR0160', '8003535022778', 'WTR - Pyramid Selection 300 g # 6 x 300 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5312, 4654, 'WTR0170', '8003535026295', 'WTR - Selection Ice Bucket 350 g # 5 x 350 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5313, 4655, 'ZAI0100', '8004735069594', 'ZAI - Egg Trio Frozen 60 g # 24 x 60 g', 996, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5314, 4656, 'ZAI0110', '8004735031089', 'ZAI - Egg Trio Princess 60 g # 24 x 60 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5315, 4657, 'ZAI0120', '8004735030662', 'ZAI - Egg Trio Toy Story # 24 x 60 g', 998, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5316, 4658, 'ZAI0130', '8004735091175', 'ZAI - Egg Trio Insideout  # 24 x 60 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5317, 4659, 'ZAI0140', '8004735101034', 'ZAI - Egg Trio Mickey 60 g # 24 x 60 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5318, 4660, 'ZAI0150', '8004735031218', 'ZAI - Egg Trio Cars 60 g # 24 x 60 g', 998, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5319, 4661, 'ZAI0160', '8004735101041', 'ZAI - Egg Trio Sofia 60 g # 24 x 60 g', 997, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5320, 4662, 'ZAI0170', '8004735031621', 'ZAI - Egg Trio Minnie 60 g # 24 x 60 g', 996, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5321, 4663, 'ZAI0180', '8004735096545', 'ZAI - Egg Trio Tsum - Tsum 60 g # 24 x 60 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5322, 4664, 'ZAI0190', '8004735092547', 'ZAI - Egg Trio Hello Kitty 60 g # 24 x 60 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5323, 4665, 'ZAI01A0', '8004735109184', 'ZAI - Pororo Trio Eggs 60 g # 24 x 60 g', 998, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5324, 4666, 'ZAI01B0', '8004735111163', 'ZAI - Hot Wheels Trio Eggs 60 g # 24 x 60 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5325, 4667, 'ZAI01C0', '8004735093933', 'ZAI - Barbie Trio Eggs 60 g # 24 x 60 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5326, 4668, 'ZAI01D0', '8004735094473', 'ZAI - Paw Patrol Trio Eggs 60 g # 24 X 60 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5327, 4669, 'ZAI01E0', '8004735110579', 'ZAI - Pj Masks Trio Eggs 60 g # 24 x 60 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5328, 4670, 'ZAI01F0', '8004735106183', 'ZAI - Tayo Trio Eggs 60 g # 24 x 60 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5329, 4671, 'ZAI0200', '80838876', 'ZAI - Crockki Mickey 18 g # 2 x 24 x 18 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5330, 4672, 'ZAI0211', '80774914', 'ZAI - Crockki Minnie 18 g # 2 x 24 x 18 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5331, 4673, 'ZAI0220', '80871170', 'ZAI - Crockki Frozen 18 g # 2 x 24 x 18 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5332, 4674, 'ZAI0230', '80884415', 'ZAI - Crockki Cars 18 g # 2 x 24 x 18 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5333, 4675, 'ZAI0240', '80985754', 'ZAI - Crockki Tsum - Tsum 18 g # 2 x 24 x 18 g', 998, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5334, 4676, 'ZAI0400', '8004735065206', 'ZAI - Ciocobisco # 18 x 100 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5335, 4677, 'ZAI0410', '8004735065237', 'ZAI - Noughita # 18 x 100 g', 995, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5336, 4678, 'ZAI0421', '8004735108064', 'ZAI - Boero Cherry  # 12 X 210 g', 999, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5337, 4679, 'ALB0120', '9311766000212', 'ALB - Shredded Cheddar 250 g # 16 x 250 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5338, 4680, 'ALB0190', '9311766000205', 'ALB - Grated Parmesan 2 kg # 6 x 2 kg', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5339, 4681, 'DCG0610', '38009747', 'Pack-FA Kain Tile (S)', 998, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5340, 4682, 'DCG0620', '38009761', 'Pack-FA Pita', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5341, 4683, 'DCG0630', '38011887', 'LDT-Exc Mix Valentine 200gr', 998, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5342, 4684, 'DCG0640', '38011894', 'LDT-Lindor Mix Valentine 250gr', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5343, 4685, 'DCG0650', '38011900', 'LDT-Les Garndes Mix Valent250g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5344, 4686, 'DCG0660', '38011917', 'WTR-Teddy Bear Cream Choco', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5345, 4687, 'DCG0670', '38011924', 'WTR-Teddy Bear White Choco', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5346, 4688, 'DCG0680', '38011948', 'VLR-w/Teddy Bear Brown Mix Val', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5347, 4689, 'DCG0690', '38011931', 'MCV-w/Teddy Bear Cream Valenti', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5348, 4690, 'ALB0130', '9311766000625', 'ALB - Shredded Cheddar 500 g # 12 x 500 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5349, 4691, 'DCG0710', '380084120', 'Buy paper bag L', 1000, '2023-12-31', '1', '2023-02-21 01:49:50'),
(5350, 4692, 'ZAI0241', '080985754', 'ZAI - Crockki Tsum - Tsum 18 g # 12 x 12 x 18 g', 1000, '2023-12-31', '1', '2023-02-21 01:49:50');

-- --------------------------------------------------------

--
-- Table structure for table `p_item_produksi`
--

CREATE TABLE `p_item_produksi` (
  `id` int(11) NOT NULL,
  `item_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `p_item_produksi`
--

INSERT INTO `p_item_produksi` (`id`, `item_code`) VALUES
(1, 'DCG0500'),
(2, 'DCG0600');

-- --------------------------------------------------------

--
-- Table structure for table `p_unit`
--

CREATE TABLE `p_unit` (
  `unit_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `p_unit`
--

INSERT INTO `p_unit` (`unit_id`, `name`, `created`, `updated`) VALUES
(5, 'Pcs', '2022-12-05 15:21:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(200) NOT NULL,
  `description` text,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `name`, `phone`, `address`, `description`, `created`, `updated`) VALUES
(1, 'Toko A', '0295382222', 'Pati', NULL, '2019-03-17 09:31:37', NULL),
(2, 'Toko B', '021433488', 'Jakarta', 'Toko ATK Terbesar', '2019-03-17 09:31:37', NULL),
(4, 'Toko C', '0215454', 'Kudus\r\n', 'Toko Oke', '2019-03-17 09:59:41', '2019-03-17 10:10:58'),
(6, 'Pandurasa Kharisma', '0216505335', 'Podomoro, Jalan Indokarya 2, Jl. Sunter Agung Utara No.5, RT.7/RW.4, Papanggo, Kec. Tj. Priok, Kota Jkt Utara, Daerah Khusus Ibukota Jakarta 14340', 'Suplier', '2022-12-05 16:11:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tax`
--

CREATE TABLE `tax` (
  `id` int(11) NOT NULL,
  `tax` float NOT NULL,
  `tax_value` float NOT NULL,
  `update_by` varchar(50) NOT NULL,
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tax`
--

INSERT INTO `tax` (`id`, `tax`, `tax_value`, `update_by`, `update_date`) VALUES
(1, 0.1, 110, '1', '2023-02-08 16:38:58');

-- --------------------------------------------------------

--
-- Table structure for table `tb_event`
--

CREATE TABLE `tb_event` (
  `id_event` int(11) NOT NULL,
  `nama_event` varchar(255) DEFAULT NULL,
  `min_sales` float DEFAULT NULL,
  `start_periode` datetime DEFAULT NULL,
  `end_periode` datetime DEFAULT NULL,
  `is_active` varchar(255) DEFAULT 'y',
  `created_by` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_event`
--

INSERT INTO `tb_event` (`id_event`, `nama_event`, `min_sales`, `start_periode`, `end_periode`, `is_active`, `created_by`, `created`) VALUES
(1, 'bonus1', 300000, '2023-01-20 12:00:00', '2025-01-20 12:00:00', 'n', '1', '2023-02-15 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_item_bonus`
--

CREATE TABLE `tb_item_bonus` (
  `id` int(11) NOT NULL,
  `id_event` int(11) DEFAULT NULL,
  `item_code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_item_bonus`
--

INSERT INTO `tb_item_bonus` (`id`, `id_event`, `item_code`) VALUES
(1, 1, 'DCG0800');

-- --------------------------------------------------------

--
-- Table structure for table `tb_item_produksi`
--

CREATE TABLE `tb_item_produksi` (
  `id` int(11) NOT NULL,
  `item_code` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_item_produksi_detail`
--

CREATE TABLE `tb_item_produksi_detail` (
  `id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `exp_date` datetime DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `item_code` varchar(255) DEFAULT NULL,
  `id_item_detail` int(11) DEFAULT NULL,
  `id_item_produksi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_printer`
--

CREATE TABLE `tb_printer` (
  `id` int(11) NOT NULL,
  `printer_name` varchar(255) DEFAULT NULL,
  `jumlah_print` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_printer`
--

INSERT INTO `tb_printer` (`id`, `printer_name`, `jumlah_print`) VALUES
(1, 'EPSON TM-T82 Receipt', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_stock_order`
--

CREATE TABLE `tb_stock_order` (
  `id` int(11) NOT NULL,
  `no_order` varchar(255) DEFAULT NULL,
  `item_code` varchar(255) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `stock` float DEFAULT NULL,
  `min_stock` float DEFAULT NULL,
  `qty_order` float DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `is_approve` varchar(50) DEFAULT NULL,
  `approve_by` varchar(100) DEFAULT NULL,
  `approve_at` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_stock_order`
--

INSERT INTO `tb_stock_order` (`id`, `no_order`, `item_code`, `barcode`, `item_name`, `stock`, `min_stock`, `qty_order`, `created_by`, `created`, `is_approve`, `approve_by`, `approve_at`) VALUES
(20, 'PO202302150002', 'DCG0200', '0022', 'FA-Roadster Car-Green', 2, 15, 13, '1', '2023-02-15 11:06:26', 'y', 'admin', '2023-02-15 11:28:25.000'),
(21, 'PO202302150002', 'DCG0400', '0049', 'FA-Embassed Pasta & Sphagetty ', 0, 15, 15, '1', '2023-02-15 11:06:26', 'y', 'admin', '2023-02-15 11:28:25.000'),
(22, 'PO202302150003', 'DCG1300', '38000317', 'FA-Large Canopy Bakery', 7, 15, 8, '1', '2023-02-15 11:31:02', 'y', 'admin', '2023-02-15 11:31:14.000'),
(23, 'PO202302150003', 'DCG1200', '38000300', 'FA-Large Canopy Grocer', 6, 15, 9, '1', '2023-02-15 11:31:02', 'y', 'admin', '2023-02-15 11:31:14.000'),
(24, 'PO202302150003', 'DCG0300', '00330006', 'FA-Mug w/Animal CharacterHandl', 5, 15, 10, '1', '2023-02-15 11:31:02', 'y', 'admin', '2023-02-15 11:31:14.000'),
(25, 'PO202302150003', 'DCG0400', '0049', 'FA-Embassed Pasta & Sphagetty ', 0, 15, 15, '1', '2023-02-15 11:31:02', 'y', 'admin', '2023-02-15 11:31:14.000'),
(26, 'PO202302150004', 'DCG1100', '38000255', 'FA-Teddy In Bath', 8, 15, 7, '1', '2023-02-15 11:34:11', 'y', 'admin', '2023-02-15 11:40:49.000'),
(27, 'PO202302150004', 'DCG0300', '00330006', 'FA-Mug w/Animal CharacterHandl', 5, 15, 10, '1', '2023-02-15 11:34:11', 'y', 'admin', '2023-02-15 11:40:49.000'),
(28, 'PO202302150004', 'DCG0400', '0049', 'FA-Embassed Pasta & Sphagetty ', 0, 15, 15, '1', '2023-02-15 11:34:11', 'y', 'admin', '2023-02-15 11:40:49.000'),
(29, 'PO202302150005', 'DCG1500', '38000768', 'Box Teddy Bear W/Handle (S)', 12, 15, 3, '1', '2023-02-15 11:53:58', 'y', 'admin', '2023-02-15 13:03:17.000'),
(30, 'PO202302150005', 'DCG1400', '38000331', 'FA-Winter Canopy Cookies', 7, 15, 8, '1', '2023-02-15 11:53:58', 'y', 'admin', '2023-02-15 13:03:17.000'),
(31, 'PO202302150005', 'FAM9710', '38000614', 'FA - Plastic Bag # 1 x 1 pcs', 6, 15, 9, '1', '2023-02-15 11:53:58', 'y', 'admin', '2023-02-15 13:03:17.000'),
(32, 'PO202302150006', 'DCG1300', '38000317', 'FA-Large Canopy Bakery', 7, 15, 8, '1', '2023-02-15 13:05:37', NULL, NULL, NULL),
(33, 'PO202302150006', 'DCG1400', '38000331', 'FA-Winter Canopy Cookies', 7, 15, 8, '1', '2023-02-15 13:05:37', NULL, NULL, NULL),
(34, 'PO202302150006', 'DCG1200', '38000300', 'FA-Large Canopy Grocer', 6, 15, 9, '1', '2023-02-15 13:05:37', NULL, NULL, NULL),
(35, 'PO202302150006', 'FAM9710', '38000614', 'FA - Plastic Bag # 1 x 1 pcs', 6, 15, 9, '1', '2023-02-15 13:05:37', NULL, NULL, NULL),
(36, 'PO202302150007', 'DCG1100', '38000255', 'FA-Teddy In Bath', 8, 15, 5, '1', '2023-02-15 13:06:59', 'y', 'admin', '2023-02-15 15:25:48.000'),
(37, 'PO202302150007', 'DCG1300', '38000317', 'FA-Large Canopy Bakery', 7, 15, 15, '1', '2023-02-15 13:06:59', 'y', 'admin', '2023-02-15 15:25:48.000'),
(38, 'PO202302150007', 'DCG1200', '38000300', 'FA-Large Canopy Grocer', 6, 15, 20, '1', '2023-02-15 13:06:59', 'y', 'admin', '2023-02-15 15:25:48.000'),
(39, 'PO202302150007', 'DCG0300', '00330006', 'FA-Mug w/Animal CharacterHandl', 5, 15, 25, '1', '2023-02-15 13:06:59', 'y', 'admin', '2023-02-15 15:25:48.000'),
(40, 'PO202302150008', 'DCG1100', '38000255', 'FA-Teddy In Bath', 8, 15, 7, '1', '2023-02-15 13:32:52', 'y', 'admin', '2023-02-15 13:33:34.000'),
(41, 'PO202302150008', 'DCG1200', '38000300', 'FA-Large Canopy Grocer', 6, 15, 9, '1', '2023-02-15 13:32:52', 'y', 'admin', '2023-02-15 13:33:34.000'),
(42, 'PO202302150008', 'DCG0300', '00330006', 'FA-Mug w/Animal CharacterHandl', 5, 15, 12, '1', '2023-02-15 13:32:52', 'y', 'admin', '2023-02-15 13:33:34.000'),
(43, 'PO202302150009', 'DCG1100', '38000255', 'FA-Teddy In Bath', 8, 15, 7, '1', '2023-02-15 15:38:53', NULL, NULL, NULL),
(44, 'PO202302150009', 'DCG1300', '38000317', 'FA-Large Canopy Bakery', 7, 15, 8, '1', '2023-02-15 15:38:53', NULL, NULL, NULL),
(45, 'PO202302150009', 'DCG1200', '38000300', 'FA-Large Canopy Grocer', 6, 15, 9, '1', '2023-02-15 15:38:53', NULL, NULL, NULL),
(46, 'PO202302150010', 'DCG1100', '38000255', 'FA-Teddy In Bath', 8, 15, 7, '1', '2023-02-15 17:32:02', NULL, NULL, NULL),
(47, 'PO202302150010', 'DCG1200', '38000300', 'FA-Large Canopy Grocer', 6, 15, 9, '1', '2023-02-15 17:32:02', NULL, NULL, NULL),
(48, 'PO202302150010', 'DCG0300', '00330006', 'FA-Mug w/Animal CharacterHandl', 5, 15, 10, '1', '2023-02-15 17:32:02', NULL, NULL, NULL),
(49, 'PO202302150010', 'DCG0400', '0049', 'FA-Embassed Pasta & Sphagetty ', 0, 15, 15, '1', '2023-02-15 17:32:02', NULL, NULL, NULL),
(50, 'PO202302150011', 'DCG1100', '38000255', 'FA-Teddy In Bath', 8, 15, 7, '1', '2023-02-15 17:48:44', NULL, NULL, NULL),
(51, 'PO202302150011', 'DCG1300', '38000317', 'FA-Large Canopy Bakery', 7, 15, 8, '1', '2023-02-15 17:48:44', NULL, NULL, NULL),
(52, 'PO202302150011', 'DCG1400', '38000331', 'FA-Winter Canopy Cookies', 7, 15, 8, '1', '2023-02-15 17:48:44', NULL, NULL, NULL),
(53, 'PO202302150011', 'DCG1200', '38000300', 'FA-Large Canopy Grocer', 6, 15, 9, '1', '2023-02-15 17:48:44', NULL, NULL, NULL),
(54, 'PO202302150012', 'DCG1100', '38000255', 'FA-Teddy In Bath', 7, 15, 8, '1', '2023-02-15 18:49:17', 'y', 'admin', '2023-02-15 18:49:49.000'),
(55, 'PO202302150012', 'DCG1200', '38000300', 'FA-Large Canopy Grocer', 5, 15, 20, '1', '2023-02-15 18:49:17', 'y', 'admin', '2023-02-15 18:49:49.000'),
(56, 'PO202302150012', 'DCG0300', '00330006', 'FA-Mug w/Animal CharacterHandl', 4, 15, 20, '1', '2023-02-15 18:49:17', 'y', 'admin', '2023-02-15 18:49:49.000');

-- --------------------------------------------------------

--
-- Table structure for table `tb_transfer_stock`
--

CREATE TABLE `tb_transfer_stock` (
  `id` int(11) NOT NULL,
  `docnum` varchar(255) DEFAULT NULL,
  `whs_code_rec` varchar(255) DEFAULT NULL,
  `whs_code_send` varchar(255) DEFAULT NULL,
  `type_transfer` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_transfer_stock_detail`
--

CREATE TABLE `tb_transfer_stock_detail` (
  `id` int(11) NOT NULL,
  `docnum` varchar(255) DEFAULT NULL,
  `item_code` varchar(255) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_id_detail` int(11) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `exp_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `type_bayar`
--

CREATE TABLE `type_bayar` (
  `id` int(11) NOT NULL,
  `type_bayar` varchar(100) NOT NULL,
  `create_by` varchar(50) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `type_bayar`
--

INSERT INTO `type_bayar` (`id`, `type_bayar`, `create_by`, `create_date`) VALUES
(1, 'tunai', '', '2022-12-02 13:35:02'),
(2, 'debit', '', '2022-12-02 13:35:02'),
(5, 'master', '1', '2022-12-12 10:23:43'),
(6, 'visa', '1', '2022-12-12 10:23:50'),
(8, 'lain-lain', '1', '2022-12-12 10:28:51'),
(9, 'cash', '1', '2022-12-12 10:29:19');

-- --------------------------------------------------------

--
-- Table structure for table `t_cart`
--

CREATE TABLE `t_cart` (
  `cart_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_id_detail` int(11) DEFAULT NULL,
  `item_expired` date DEFAULT NULL,
  `item_expired_2` datetime DEFAULT NULL,
  `price` float NOT NULL,
  `qty` float NOT NULL,
  `discount_item` float NOT NULL DEFAULT '0',
  `discount_percent` int(11) DEFAULT '0',
  `total` float NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `t_cart_produksi`
--

CREATE TABLE `t_cart_produksi` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_id_detail` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `exp_date` datetime NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_cart_stockout`
--

CREATE TABLE `t_cart_stockout` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_id_detail` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `exp_date` datetime NOT NULL,
  `info` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_cart_suggest_order`
--

CREATE TABLE `t_cart_suggest_order` (
  `id` int(11) NOT NULL,
  `item_code` varchar(255) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `stock` float DEFAULT NULL,
  `min_stock` float DEFAULT NULL,
  `suggest_qty` float DEFAULT NULL,
  `qty_order` float DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_cart_suggest_order`
--

INSERT INTO `t_cart_suggest_order` (`id`, `item_code`, `barcode`, `item_name`, `stock`, `min_stock`, `suggest_qty`, `qty_order`, `created_by`, `created`) VALUES
(45, 'DCG1100', '38000255', 'FA-Teddy In Bath', 7, 15, 8, 8, '1', '2023-02-16 13:36:54'),
(46, 'DCG0100', '00004', 'FA-Large Canopy Toys', 4, 15, 11, 11, '1', '2023-02-16 13:36:54'),
(47, 'DCG0300', '00330006', 'FA-Mug w/Animal CharacterHandl', 1, 15, 14, 14, '1', '2023-02-16 13:36:54'),
(48, 'DCG0200', '0022', 'FA-Roadster Car-Green', 0, 15, 15, 15, '1', '2023-02-16 13:36:54');

-- --------------------------------------------------------

--
-- Table structure for table `t_cart_sync_item`
--

CREATE TABLE `t_cart_sync_item` (
  `whs_code` varchar(255) DEFAULT NULL,
  `item_code` varchar(255) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `brand_code` varchar(255) DEFAULT NULL,
  `min_stock` float DEFAULT NULL,
  `harga_jual` float DEFAULT NULL,
  `harga_bersih` float DEFAULT NULL,
  `harga_ppn` float DEFAULT NULL,
  `percent_ppn` float DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_cart_sync_item`
--

INSERT INTO `t_cart_sync_item` (`whs_code`, `item_code`, `barcode`, `item_name`, `brand_code`, `min_stock`, `harga_jual`, `harga_bersih`, `harga_ppn`, `percent_ppn`, `user_id`, `created`) VALUES
('WH06.07', 'ALB0100', '9311766000007', 'ALB - Mozzarella 250 g # 12 x 250 g', '102', 15, 0, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'ALB0110', '9311766000014', 'ALB - Mozzarella 500 g # 12 x 500 g', '102', 15, 0, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'ALB0120', '9311766000212', 'ALB - Shredded Cheddar 250 g # 16 x 250 g', '102', 15, 100000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'ALB0130', '9311766000625', 'ALB - Shredded Cheddar 500 g # 12 x 500 g', '102', 15, 50000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'ALB0190', '9311766000205', 'ALB - Grated Parmesan 2 kg # 6 x 2 kg', '102', 15, 300000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'AMS0100', '6936756230580', 'AMS - 4D Gummy Block 40g # 8 x 12 x 40g', '171', 15, 8577, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'AMS0200', '6936756230603', 'AMS - 4D Gummy Block 72g # 36 x 72g', '171', 15, 15136, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'ASF0130', '6281073210181', 'ASF - Natural Honey # 12 x 500 g', '101', 15, 114000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'ASF01A0', '6281073210198', 'ASF - Natural Honey 500g+125g 1Pc # 12 x 625 Pcs', '101', 15, 105000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'BCF0200', '8888089990502', 'BCF - Colombiana Instant Coffee (Merah) 50g # 12 x 50g', '108', 15, 0, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'BCF0210', '8888089991004', 'BCF - Colombiana Instant Coffee (Merah) 100g # 12 x 100g', '108', 15, NULL, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CAO0100', '7612100113110', 'CAO - Caotina Original 200 g # 6 x 200 g', '110', 15, 83755, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CAO0110', '7612100019184', 'CAO - Caotina Original 500 g # 6 x 500 g', '110', 15, 160445, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CAO0120', '7612100055519', 'CAO - Caotina Noir 500 g # 6 x 500 g', '110', 15, 185168, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CAO0130', '7612100055496', 'CAO - Caotina Blanc 500 g # 6 x 500 g', '110', 15, 185168, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CAO0140', '7612100800621', 'CAO - Chocolate Spread 300 g # 6 x 300 g', '110', 15, 88800, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CAV0100', '5413623900032', 'CAV - Cavalier Bar Milk 44 g # 10 X 16 X 44 g', '113', 15, 31282, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CAV0111', '5413623900025', 'CAV - Cavalier Bar Dark 44 g # 10 X 16 X 44 g', '113', 15, 31282, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CAV0120', '5413623900063', 'CAV - Cavalier Bar Milk Pralinut 42 g # 10 X 16 X 42 g', '113', 15, 31282, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CAV0130', '5413623101002', 'CAV - Cavalier Tablet Milk 85 g # 6 X 14 X 85 g', '113', 15, 58527, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CAV0140', '5413623301006', 'CAV - Cavalier Tablet Dark 85 g # 6 X 14 X 85 g', '113', 15, 58527, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CAV0151', '5413623201009', 'CAV - Cavalier Tablet M Hazelnut 85 g # 6 X 14 X 85 g', '113', 15, 58527, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CAV0160', '5413623850047', 'CAV - Cavalier Tablet White 85 g # 6 X 14 X 85 g', '113', 15, 58527, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CCO0300', '8997011630871', 'CCO - Bali Ass gift Pack # 24 x 170 g', '115', 15, 86277, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CCO0310', '8997011630888', 'CCO - Borobudur Almond gift Pack # 24 x 170 g', '115', 15, 86355, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CCO0320', '8997011631823', 'CCO - Wayang Kulit Nakula 170 g # 1 x 24 x 170 g', '115', 15, 86277, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CCO0330', '8997011631830', 'CCO - Wayang Kulit Bima 170 g # 1 x 24 x 170 g', '115', 15, 86277, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CCO0340', '8997011631816', 'CCO - Wayang Kulit Arjuna Ass 170 g # 1 x 24 x 170 g', '115', 15, 86277, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CCO0350', '8997011631809', 'CCO - Wayang Kulit Yudhistira Ass 170 g # 1 x 24 x 170 g', '115', 15, 86277, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CCO0380', '8997011631229', 'CCO - Bali 3Dancers Gift Pack # 24 x 170 g', '115', 15, 90314, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CCO0390', '8997011631212', 'CCO - Bali Lion Head Gift Pack # 24 x 170 g', '115', 15, 90314, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CCO03A0', '8997011631236', 'CCO - Beautiful Indonesia Asst # 24 x 170 g', '115', 15, 90314, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CCO0400', '8997011630314', 'CCO - Hazelnut w/ Rice Cereal  # 24 x 135 g', '115', 15, 83250, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CCO0410', '8997011630284', 'CCO - Almond w/ Rice Cereal # 24 x 135 g', '115', 15, 83250, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CCO0420', '8997011630253', 'CCO - Milk Choco w/ Rice Cereal # 24 x 135 g', '115', 15, 83250, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CCO0430', '8997011630321', 'CCO - Cylinder Jar Hazelnut  # 24 x 262.5 g', '115', 15, 71645, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CCO0440', '8997011630291', 'CCO - Cylinder Jar Almond  # 24 x 262.5 g', '115', 15, 71645, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CCO0450', '8997011630260', 'CCO - Cylinder Jar Milk Chocolat # 24 x 262.5 g', '115', 15, 71645, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CCO0460', '8997011630338', 'CCO - Square Jar Hazelnut # 18 x 525 g', '115', 15, 115036, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CCO0470', '8997011630307', 'CCO - Square Jar Almond # 18 x 525 g', '115', 15, 115036, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CCO0480', '8997011630277', 'CCO - Square Jar Milk Chocolate # 18 x 525 g', '115', 15, 115036, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CCO0500', '8997011630017', 'CCO - Milk Bar 50 g # 12 x 20 x 50 g', '115', 15, 11100, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CCO0510', '8997011630024', 'CCO - Milk Bar 100 g # 12 x 10 x 100 g', '115', 15, 20182, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CCO0520', '8997011630031', 'CCO - Milk Bar 200 g # 6 x 10 x 200 g', '115', 15, 38850, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CCO0530', '8997011630079', 'CCO - Almond Bar 50 g # 12 x 20 x 50 g', '115', 15, 11605, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CCO0540', '8997011630086', 'CCO - Almond Bar 100 g # 12 x 10 x 100 g', '115', 15, 22200, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CCO0550', '8997011630093', 'CCO - Almond Bar 200 g # 6 x 10 x 200 g', '115', 15, 40868, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CCO0560', '8997011630109', 'CCO - Fruit and Nut Bar 50 g # 12 x 20 x 50 g', '115', 15, 11605, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CCO0570', '8997011630116', 'CCO - Fruit and Nut Bar 100 g # 12 x 10 x 100 g', '115', 15, 22200, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CCO0580', '8997011630123', 'CCO - Fruit and Nut Bar 200 g # 6 x 10 x 200 g', '115', 15, 40868, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CCO0590', '8997011630048', 'CCO - Hazelnut Bar 50 g # 12 x 20 x 50 g', '115', 15, 11605, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CCO05A0', '8997011630055', 'CCO - Hazelnut Bar 100 g # 12 x 10 x 100 g', '115', 15, 22200, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CCO05B0', '8997011630062', 'CCO - Hazelnut Bar 200 g # 6 x 10 x 200 g', '115', 15, 40868, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CLN0100', '8992919141405', 'CLN - Collin''s Butter Nut 48g # 20 (15 x 3.2)', '180', 15, NULL, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'CRM0160', '9319133338012', 'CRM - Deluxe  Gluten Free 400 g # 6 x 400 g', '111', 15, NULL, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG0100', '00004', 'FA-Large Canopy Toys', '222', 15, 475000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG0200', '0022', 'FA-Roadster Car-Green', '222', 15, 110000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG0300', '00330006', 'FA-Mug w/Animal CharacterHandl', '222', 15, 152500, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG0400', '0049', 'FA-Embassed Pasta & Sphagetty ', '222', 15, 395000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG0500', '1509200831029', 'FA-Parcel Type B', '222', 15, 0, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG0600', '1509200831036', 'FA-Parcel Type D', '222', 15, 0, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG0610', '38009747', 'Pack-FA Kain Tile (S)', '222', 15, 15000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG0620', '38009761', 'Pack-FA Pita', '222', 15, 8000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG0630', '38011887', 'LDT-Exc Mix Valentine 200gr', '222', 15, 105000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG0640', '38011894', 'LDT-Lindor Mix Valentine 250gr', '222', 15, 122000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG0650', '38011900', 'LDT-Les Garndes Mix Valent250g', '222', 15, 105000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG0660', '38011917', 'WTR-Teddy Bear Cream Choco', '222', 15, 99000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG0670', '38011924', 'WTR-Teddy Bear White Choco', '222', 15, 99000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG0680', '38011948', 'VLR-w/Teddy Bear Brown Mix Val', '222', 15, 115000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG0690', '38011931', 'MCV-w/Teddy Bear Cream Valenti', '222', 15, 179000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG0700', '38011955', 'LDT-W/Teddy Bear Big Mix Valen', '222', 15, 215000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG0710', '380084120', 'Buy paper bag L', '222', 15, 45000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG0800', '2008313600052', 'FA-Paper Bag (L)', '222', 15, 50000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG0900', '2008313600076', 'FA-Paper Bag (S)', '222', 15, 0, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG1000', '2008313600083', 'FA-Paper Bag (M)', '222', 15, 0, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG1100', '38000255', 'FA-Teddy In Bath', '222', 15, 120000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG1200', '38000300', 'FA-Large Canopy Grocer', '222', 15, 475000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG1300', '38000317', 'FA-Large Canopy Bakery', '222', 15, 475000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG1400', '38000331', 'FA-Winter Canopy Cookies', '222', 15, 173500, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG1500', '38000768', 'Box Teddy Bear W/Handle (S)', '222', 15, 90900, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG1600', '38001048', 'FA-Brown Basket W/ Handle (S)', '222', 15, 90900, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG1700', '38001055', 'FA-Brown Basket W/ Handle (M)', '222', 15, 121200, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG1800', '38001727', 'FA-Kereta Salju Besar', '222', 15, 227249, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG1900', '38003134', 'FA-Terry Box Chef Medium 5426 ', '222', 15, 110000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG2000', '38003158', 'FA-Ugly Cute Boy Medium 5554', '222', 15, 110000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG2100', '38003172', 'FA-Ugly Cute Boy Birthday 5563', '222', 15, 110000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG2200', '38003189', 'FA-Ugly Cute Girl Birthday5564', '222', 15, 110000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG2300', '38003219', 'FA-Bull Medium Jar 5430', '222', 15, 110000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG2400', '38003226', 'FA-Cow Medium Jar 5432', '222', 15, 110000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG2500', '38003240', 'FA-Tiger Medium Jar 5550', '222', 15, 110000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG2600', '38003257', 'FA-Dwarf Medium Jar 5670', '222', 15, 110000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG2700', '38003301', 'FA-Layer Pandan Box', '222', 15, 187000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG2800', '38003363', 'FA-Chicken Medium Jar w/Choc', '222', 15, 110000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG2900', '38003417', 'FA-Frog Medium Jar with Choco', '222', 15, 110000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG3000', '38003523', 'FA-Maize Basket Mocca 0274 (L)', '222', 15, 210000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG3100', '38003530', 'FA-Maize Basket Mocca 0274 (M)', '222', 15, 189000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG3200', '38003547', 'FA-Maize Basket Mocca 0274 (S)', '222', 15, 157500, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG3300', '38006081', 'Pack - Keranjang Majalah Imlek', '222', 15, 165000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG3700', '38008276', 'Pack- Keranjang Rutan Bulat', '222', 15, 60600, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG3800', '38008319', 'Pack - Box Kotak DG Coklat ', '222', 15, 101000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG4000', '38008405', 'Pack- Fa Happy Holiday Paper S', '222', 15, 0, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG4100', '38008412', 'Pack- Fa Happy Holiday Paper L', '222', 15, 0, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG4200', '38008474', 'Pack - Keranjang Kotak Kuping ', '222', 15, 121100, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG4300', '38008481', 'Pack - Keranjang Rotan Besar ', '222', 15, 0, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG4400', '38008665', 'Pack - Keranjang Tangkai 1 Pcs', '222', 15, 160000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG4500', '38009044', 'Pack - FA Lebaran Green Round ', '222', 15, 171600, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG4600', '38010514', 'Pack- Box Christmas Long', '222', 15, 80800, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG4700', '38010873', 'Pack-FA Baki Gelombang Natal S', '222', 15, 0, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG4800', '38010958', 'Pack-keranjang Tangkai Saley K', '222', 15, 0, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG4900', '38010965', 'Pack-Keranjang Sariman Kotak ', '222', 15, 0, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG5000', '38010972', 'Pack - Keranjang Santa', '222', 15, 227250, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG5200', '4891034041048', 'Gift-Lindt Coffee Mug', '222', 15, 0, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG5300', '7610062081065', 'Jura Waffer mini', '222', 15, 55000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG5400', '7610062092566', 'Mini Chocobeau ', '222', 15, 105000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG5500', '7610400030632', 'Lindor Cornet White 200 g', '222', 15, 155400, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG5600', '7610400936521', 'LDT-SURFIN BULK', '222', 15, 83250, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG5700', '7610400988889', 'Lindor White Gift Box', '222', 15, 165491, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG5800', '8000000780003', 'FA-Pix Mix Chocolate 1', '222', 15, 83250, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG6000', '9403142002238', 'White Chocolate block 200 gr', '222', 15, 91827, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG6100', '38011634', 'Pack-Keranjang Oval Rotan S', '222', 15, 110000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG6200', '38011641', 'Pack-keranjang Oval Rotan M', '222', 15, 150000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG6400', '70177118495', 'TWN- Strawberry & Mango 50 gr', '222', 15, 79000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG6500', '7610062211851', 'WNL- Pack Sleeve', '222', 15, 0, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG7100', '38008887', 'FA - kantor plastik coklat 1 pcs ', '222', 15, 0, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG7101', '38011597', 'Pack-Keranjang Santa Claus', '222', NULL, 195000, 177273, 17727.3, 10, 1, '2023-02-21 09:14:30'),
('WH06.07', 'DCG7102', '0000000000481', 'LDT-Excellence Extra Creamy', '222', NULL, 0, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'ESP0210', '9311755200609', 'ESP - OLD STYLE LEMON LIME BITTE # 24 x 275 Ml', '120', 15, NULL, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'ESP0220', '9349277000612', 'ESP - Classic Cola 275 ml # 24 x 275 ml', '120', 15, NULL, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'ESP0230', '9311755200586', 'ESP - OLD STYLE GINGER BEER # 24 x 275 Ml', '120', 15, NULL, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'FAM9710', '38000614', 'FA - Plastic Bag # 1 x 1 pcs', '121', 15, 0, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'FAM9760', '2008311300237', 'FA - Thermal Roll Paper # 1 x 1 pcs', '121', 15, 0, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'FAM9800', '38006678', 'FA - Fa Hand glove 1 Pck # 1 x 1 Pck', '121', 15, 0, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'FAM9830', '38006685', 'FA - Fa Plastik Opp 1 Pck # 1 x 1 Pck', '121', 15, 0, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'FAM9860', '38006692', 'FA - Fa Solatip/Nachi Tape 1 Pc # 1 x 1 Pc', '121', 15, 0, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'FAM9900', '38008603', 'FA - Pack Christmas Box Large 1 Pcs # 1 x 1 Pcs', '121', 15, 186700, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'FAM9910', '38008597', 'FA - Pack Christmas Box Medium 1 Pcs # 1 x 1 Pcs', '121', 15, 181700, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'FAM9920', '38008580', 'FA - Christmas Box Small 1 Pcs # 1 x 1 Pcs', '121', 15, 141300, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'GAL0150', '8001420003383', 'GAL - Base Mushroom # 5x1kg', '182', 15, NULL, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'GOL0100', '7610403072547', 'GOLD - Amarula #10(1x100g) # 10 x 1 x 100 g', '124', 15, 120082, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'GOL0110', '7610403072103', 'GOLD - Cointreau #10(1x100g) # 10 x 1 x 100 g', '124', 15, 120082, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'GOL0120', '7610403072561', 'GOLD - Jackdaniels Tennessee Honey 100g # 10 x1x100 g', '124', 15, 120082, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'GOL0130', '7610403072509', 'GOLD - Jackdaniels Tennessee Whiskey 100 # 10 x 1x 100 g', '124', 15, 120082, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'GOL0140', '7610403072707', 'GOLD - Remy Martin #10(1x100g) # 10 x 1 x 100 g', '124', 15, 120082, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'GOL0150', '7610403072523', 'GOLD - The Famous gouse #10(1x100g) # 10 x 1 x 100 g', '124', 15, 120082, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'HOR0120', '8886467076145', 'HOR - Cereal 3 in 1 320g # 24x320g', '179', 15, NULL, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'JLB0100', '745092012295', 'JLB - Jelly Bean Sachet 50 g # 24 x 50 g', '129', 15, 20686, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'JLB0110', '745092006942', 'JLB - Jelly Bean 36Flavours 75gr # 9x16x75gr', '129', 15, 30172, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'JLB0120', '745092014428', 'JLB - Jelly Bean Pop A Bean 100gr # 12 x 100gr', '129', 15, 81736, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'JLB0130', '745092006058', 'JLB - Jelly Bean 36 Flavours # 4 x 24 x 100gr', '129', 15, 45813, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'JLB0140', '745092010932', 'JLB - Jelly Bean Pouch Bag 113gr # 12 x 113gr', '129', 15, 50555, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'JLB0150', '745092000933', 'JLB - Jelly Bean Cup # 12 x 200 gr', '129', 15, 69627, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'JLB0160', '8713800139307', 'JLB - Jelly Bean Tube 90g # 24 x 90g', '129', 15, 50000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'JLB0170', '8713800139208', 'JLB - Jelly Bean Pouch 70g # 20 x 70g', '129', 15, 28500, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LAK0100', '8013399168338', 'LAKE - Fruity Drops Honey Lemon #  ( 12 x 16 ) x 40g', '131', 15, 20989, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LAK0110', '8013399168345', 'LAKE - Fruity Drops Honey Strawberry # ( 12 x 16 ) x 40g', '131', 15, 20989, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LAK0120', '8013399168222', 'LAKE - Fruity Drops Honey Yuzu # ( 12 x 16 ) x 40g', '131', 15, 20989, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LAK0130', '8013399168291', 'LAKE - Fruity Drops Honey Lemon Tea #  ( 12 x 16 ) x 40g', '131', 15, 20989, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT0100', '7610400010108', 'LDT - Surfin 100gr # (12x12)x100 gr', '135', 15, 53986, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT0110', '7610400014571', 'LDT - White Chocolate 100gr # (12x12)x100 gr', '135', 15, 53986, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT0120', '7610400010016', 'LDT - Milk 100gr # (12x12)x100 gr', '135', 15, 53986, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT0130', '7610400010023', 'LDT - Milk Hazelnut 100gr # (12x12)x100 gr', '135', 15, 60545, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT0140', '7610400014038', 'LDT - Milk Whole Almonds 100gr # (12x12)x100 gr', '135', 15, 60545, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT0150', '7610400010368', 'LDT - Milk Raisin Nut 100gr # (12x12)x100 gr', '135', 15, 60545, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT0400', '3046920028721', 'LDT - Excellence Dark Cocoa 99% # 6 x 18 x 50 g', '135', 15, 75177, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT0410', '3046920029759', 'LDT - Excellence 90% Cacao 100 gr # 6x20x100 gr', '135', 15, 72655, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT0420', '3046920028363', 'LDT - Excellence Dark 85 # 6 x 20 x 100 g', '135', 15, 72655, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT0430', '3046920010047', 'LDT - Excellence Dark Cocoa 78% 100g # 6 x 20 x 100g', '135', 15, 72655, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT0440', '3046920028004', 'LDT - Excellence Dark Cocoa 70% # 6 x 20 x 100 g', '135', 15, 72655, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT0450', '3046920028370', 'LDT - Excellence Orange 100g # 6 x 20 x 100 g', '135', 15, 72655, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT0460', '7610400010481', 'LDT - Excellence Extra Creamy # 6 x 20 x100 g', '135', 15, 72655, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT0470', '3046920028752', 'LDT - Exellence Mint Intense # 6 x 20 x 100 g', '135', 15, 72655, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT0480', '3046920029674', 'LDT - Excel  Sea Salt 100 g # 6 x 20 x 100 g', '135', 15, 72655, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT0491', '3046920028585', 'LDT - Excellence Dark 70% 35g # 2 x 24 x 35g', '135', 15, 24218, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT04A1', '3046920011600', 'LDT - Excellence Milk 35 g # 2 x 24 x 35 g', '135', 15, 24218, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT04B0', '3046920029582', 'LDT - Excellence Dark 85% 35g # 2 x 24 x 35g', '135', 15, 24218, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT0622', '7610400087346', 'LDT - Les Grandes Noisettes Caramel # 6 x 13 x 150g', '135', 15, 92836, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT0631', '7610400085946', 'LDT - Les Grandes Amandes-Fleur De Sel # 15 x 150g', '135', 15, 92836, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT0700', '7610400029841', 'LDT - Dark Thins 125 g # (1x9)x125 g', '135', 15, 136732, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT0710', '7610400029810', 'LDT - Milk Thins 125g # (1x9)x125 g', '135', 15, 136732, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT0800', '7610400071925', 'LDT - Lindor Trio Extra Dark 60% # 24 X 37 g', '135', 15, 22099, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT0820', '7610400069502', 'LDT - Lindor Trio Assorted 37g # 24 x 37g', '135', 15, 22099, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT0830', '4894475100190', 'LDT - Lindor Trio Strawberry 37g # 24 x 37g', '135', 15, 22099, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT0840', '4894475100497', 'LDT - Lindor Trio Matcha 37g # 24 x 37g', '135', 15, 22099, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT0900', '7610400074155', 'LDT - Lindor Single 60%Dark 100g # (12x12)x100 g', '135', 15, 70636, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT0910', '7610400068369', 'LDT - Lindor Single Hazelnut100g # (12x12)x100 g', '135', 15, 70636, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT0920', '7610400014649', 'LDT - Lindor Single Milk 100g # (12x12)x100 g', '135', 15, 70636, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT0930', '7610400014632', 'LDT - Lindor Single White 100g # (12x12)x100 g', '135', 15, 70636, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT1000', '8003340091280', 'LDT - Lindor Extra Dark 60%Cocoa # 4 X 8 X 200g', '135', 15, 155400, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT1010', '7610400068505', 'LDT - Lindor Cornet Milk # 4 x 8 x 200 g', '135', 15, 155400, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT1020', '7610400068529', 'LDT - Lindor Cornet Assorted # 4 x 8 x 200 g', '135', 15, 155400, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT1040', '8003340097619', 'LDT - Lindor Cornet Strawberry 200g # 8 x 200g', '135', 15, 155400, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT1100', '7610400983082', 'LDT - Lindor Extra Dark 60% gift # 1 x 10 x 168 g', '135', 15, 165491, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT1101', '7610400987318', 'LDT - Lindor Ass Gift Box 168g # 1 x 10 x 168 g', '135', 15, 165491, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT1110', '7610400060950', 'LDT - Lindor Milk Gift Box 168g # 1 x 10 x 168 g', '135', 15, 165491, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT1150', '4894475100343', 'LDT - Lindor gift Box Straw&Cream 144g # 12 x 144 g', '135', 15, 165491, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT8070', '4894475100022', 'LDT - 3D Star Tin 37 g # 10 x 37 g', '135', 15, 79900, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT8080', '4894475100015', 'LDT - 3D Tree Tin 37 g # 10 x 37 g', '135', 15, 79900, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'Ldt8090', '4894475100053', 'LDT - Lindor Mini 3D Heart Tin # 10 x 37 g', '135', 15, 69627, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT80A0', '7610400099967', 'LDT - Lindor Mini Box # 24 x 37 g', '135', 15, 22099, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT80B0', '4894475100435', 'LDT - Lindor Straw & Cream Mini Heart Tin # 12 x 37 g', '135', 15, 69627, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT80G1', '4894475100176', 'LDT - Lindor Crystal Pink Heart Tin 96g # 10 x 96 g', '135', 15, 160445, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT80H0', '4894475100138', 'LDT - Blue Mini Milk Can 96 g # 10 x 96 g', '135', 15, 115000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT80I0', '7610400987172', 'LDT - Lindor Crystal Heart Tin 96 g # 10 x 96 g', '135', 15, 160445, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT80K0', '7610400075770', 'LDT - Grand Dark Hazelnut 150 g # 6 x 13 x 150 g', '135', 15, 92836, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT80L0', '7610400075787', 'LDT - Grand Milk Hazelnut 150 g # 6 x 13 x 150 g', '135', 15, 92836, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT9010', '2009380400002', 'LDT - Lindor Dark Bulk # 1 X 1 Kg', '135', 15, 83250, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT9020', '38004131', 'LDT - Lindor Hazelnut Bulk 1Kg # 1 X 1 Kg', '135', 15, 83250, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT9030', '8000000900005', 'LDT - Lindor Milk Bulk # 1 X 1 Kg', '135', 15, 83250, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LDT9041', '38010828', 'LDT - Lindor Teddy Tin 8''s #10x96 gr', '135', 15, 96000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'LIP0120', '8999999573409', 'LIP - Delight 24gr # 24 x (15x1.6gr)', '168', 15, NULL, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'MAN0100', '048176990091', 'MANT -  SPRAY EXTRA VIRGIN OIL # 6(1x250ml)', '137', 15, NULL, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'MCV0100', '8906033742455', 'MCV - Digestive Zero 75g # 120x75g', '178', 15, 15800, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'MCV0110', '8906033740208', 'MCV - Butter Cookies 60g # 144x60g', '178', 15, 8900, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'MCV0120', '8906033741595', 'MCV - Marie Wholewheat 100g # 96x100g', '178', 15, 14500, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'MCV0130', '8906033740758', 'MCV - Digestive 100g # 96x100g', '178', 15, 15800, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'MCV0140', '8906033740963', 'MCV - Bourbon 100g #  96x100g', '178', 15, 15800, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'MCV0230', '5000396037548', 'MCV - Digestive Dark Choco UK # 24x200', '178', 15, 49000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'MCV0240', '5000396037531', 'MCV - Digestive Milk Choco UK # 24x200', '178', 15, 49000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'MCV0260', '5000396033311', 'MCV - HobNobs Oat Crunch # 10x300', '178', 15, 69000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'MCV0270', '5000396022315', 'MCV - HobNobs Milk Choco Oat # 24x300', '178', 15, 69000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'NAT0140', '016000295704', 'NATY - Apple Crisp 253 g # 12 x 253 g', '143', 15, NULL, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'OEP0100', '8410076481597', 'OEP - Tortilla Chips Original  # 10X185G', '177', 15, 55000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'OEP0110', '8410076481764', 'OEP - Tortilla Chips Chili # 10X185G', '177', 15, 55000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'OEP0120', '8410076482556', 'OEP - Tortila Chips Paprika # 10X185G', '177', 15, 55000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'OEP0130', '8410076481757', 'OEP - Tortilla Chips Fajita # 10X185G', '177', 15, 55000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'OVM0100', '7612100027158', 'OVM - Crunchy Cream 380g # 12 x 380g', '145', 15, 86277, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'OVM0110', '7612100030677', 'OVM - Crunchy Cream 680g # 6 x 680g', '145', 15, 149345, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'STD0120', '084380957741', 'STD - Raspberry 284g # 12 x 284g', '167', 15, NULL, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'STK0100', '4014400400007', 'STK - Toffiffee 125g # 15 x 125 g', '151', 15, 48941, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'STK0110', '4014400900804', 'STK - Mint Chocs 200g # 15 x 200g', '151', 15, 46317, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'STK0120', '40144078', 'STK - Knoppers 75g # 24 x 75g', '151', 15, 31786, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'STK0130', '40144061', 'STK - Knoppers 25g # 6 x 24 x 25g', '151', 15, 11100, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'STK0140', '4014400901191', 'STK - Mercy Grosse Vielfalt (Red) 250gr # 3 x 10 x 250gr', '151', 15, 125127, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'STK0141', '4014400900217', 'STK - Mercy Grosse Vielfalt (red) 400 gr # 8 x 400 gr', '151', 15, 249000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'STK0150', '4014400901405', 'STK - Mercy Helle Viefalt (Blue) 250gr # 3 x 10 x 250gr', '151', 15, 125127, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'STK0160', '4014400925395', 'STK - Merci Petits Collection 125g # 12 x 125g', '151', 15, 71141, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'STK0170', '40144924', 'STK - Riesen 45g # 4 x 24 x 45g', '151', 15, 13623, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'STK0190', '4014400902495', 'STK - Riesen 150g # 15 x 150g', '151', 15, 46317, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'STK0200', '40144016', 'STK - Werthers Echte Original 50g # 6 x 24 x 50g', '151', 15, 12614, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'STK0210', '4014400918083', 'STK - Werthers Echte Original 90g # 12 x 90g', '151', 15, 24723, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'STK0220', '4014400918113', 'STK - Werthers Original Toffee 80g # 12 x 80g', '151', 15, 24723, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'STK0230', '4014400918205', 'STK - Werthers Original Caramel Chew 48g # 6 x 24 x 48g', '151', 15, 12614, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'STK0240', '4014400918106', 'STK - Werthers Original Creamy Filling80g # 12 x 80g', '151', 15, 24723, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'STR0101', '38006821', 'STR - Lady Bird Bag 42g # 12 x 42g', '152', 15, 37841, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'STR0111', '38006845', 'STR - Sea Life Bag 43g # 12 x 43g', '152', 15, 37841, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'STR0121', '38006852', 'STR - Farm Life Bag 55g # 12 x 55g', '152', 15, 37841, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'STR0131', '38006838', 'STR - Wild Life Bag # 12 x 58g', '152', 15, 37841, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'STR0140', '4003006010260', 'STR - Bee Bag  37.5 g # 6 x 36 x 37.5 g', '152', 15, 37841, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'STR0150', '4003006030749', 'STR - Sheep Bag  50 g # 6 x 36 x 50 g', '152', 15, 37842, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'STR0161', '4003006130548', 'STR - Lady Birds Tub 100 g # 6 x 24 x 100 g', '152', 15, 81736, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'STR0171', '4003006141032', 'STR - Soccer Player Tub  # 6 x 24 x 75 g', '152', 15, 81736, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'STR0180', '4003006129245', 'STR - Big Box Farm 300 g # 8 x 300 g', '152', 15, 200809, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'STR0190', '4003006118249', 'STR - Big Box Wildlife 300 g # 8 x 300 g', '152', 15, 200809, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'STR01A0', '4003006152243', 'STR - Big Box Sealife 300 g # 8 x 300 g', '152', 15, 200809, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'TWN0100', '070177010799', 'TWN - Darjeeling Tea 50 g # 12 x ( 25 x 2 g)', '154', 15, 78780, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'TWN0110', '070177010775', 'TWN - English Breakfast Tea 50 g # 12 x (25 x 2 g)', '154', 15, 78780, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'TWN0210', '070177173173', 'TWN - Green Tea Earl Grey 40 g # 12 x (25 x 1.6 g)', '154', 15, 78780, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'TWN0220', '070177077198', 'TWN - Lady Grey Tea 50 g # 12 x (25 x 2 g)', '154', 15, 78780, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'TWN0230', '070177051174', 'TWN - TWN - Earl Grey Decaf Tea 50 g # 12 x (25x2 g)', '154', 15, 78000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'TWN0260', '070177055639', 'TWN - Peach Tea 50 g # 12 x (25x2 g)', '154', 15, 78780, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'TWN0300', '070177086664', 'TWN - Pure  Green Tea 50 g # 12 x (25x2 g)', '154', 15, 78780, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'TWN0310', '070177173166', 'TWN - Green Tea Jasmine 45 g # 12 x (25x1.8 g)', '154', 15, 78780, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'TWN0340', '070177229986', 'TWN - Green Tea Collection 34 g # 8 x (25x1.7 g)', '154', 15, 89000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'TWN0400', '070177118525', 'TWN - Pure Peppermint 50 g # 12 x (25x2 g)', '154', 15, 78780, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'TWN0430', '070177118495', 'TWN - Strawberry & Mango 50gr # 12 x (25x2gr)', '154', 15, 0, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'TWN0500', '070177029623', 'TWN - Black Tea Earl  Grey Tin 100 g # 6 x 100 g', '154', 15, 120189, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'TWN0510', '070177029630', 'TWN - English Breakfast Tea Tin 100 g # 6 x 100 g', '154', 15, 230000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'TWN1020', '0070177010768', 'TWN - Promo Pack (Earl Grey+Asf Nat 125g) # 12 X (25x2g)', '154', 15, 230000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'TWN1050', '38010132', 'TWN - Seasonal (English 50g+WNL 100g)#6x150g', '154', 15, 155000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'TWN1070', '38010712', 'TWN - Seasonal Breakfast Box 714gr # 12 x (50gr+380gr+284gr)', '154', 15, 230000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'TWN9910', '38008054', 'TWN - Twn Mug Trumpet 1 Pcs # 1 x 1 Pcs', '154', 15, 0, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'VLR0100', '8410109055887', 'VLR - Dark Chocolate Sugar Free 100 g # 6 x 17 x 100 g', '155', 15, 64330, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'VLR0110', '8410109055795', 'VLR - Milk Chocolate No Sugar Added 100 g # 6 x 17 x 100 g', '155', 15, 64330, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'VLR0120', '8410109050882', 'VLR - 70% Dark Chocolate Sugar Free 100 g # 6 x 17 x 100 g', '155', 15, 64330, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'VLR0130', '8410109109832', 'VLR - 85% Dark Chocolate Sugar Free 100 g # 6 x 17 x 100 g', '155', 15, 64330, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'VLR0140', '8410109056525', 'VLR - Dark Chocolate W/ Orange Creamy 100 g # 6 x 17 x 100 g', '155', 15, 64330, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'VLR0150', '8410109056532', 'VLR - Dark Chocolate W/ Truffle Creamy 100 g # 6 x 17 x 100 g', '155', 15, 64330, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'VOR0120', '067312005499', 'VORT - Sugar Free Fudge Choc Chip 227 g # 12 x 227 g', '156', 15, 79000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'VOR0130', '067312005505', 'VORT - Sugar Free Chocolate Chip 227 g # 12 x 227 g', '156', 15, 79000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'VOR0200', '067312005215', 'VORT - Sugar Free Lemon Wafers 255 g # 12 x 255 g', '156', 15, 0, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'VOR0220', '067312005260', 'VORT - Sugar Free Chocolate Wafers 255 g # 12 x 255 g', '156', 15, 69000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'WDR0100', '014113940092', 'WDR - Pistachios Clas Salt 50 g # 48 x 50 g', '161', 15, 34814, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'WDR0110', '014113940054', 'WDR  -Pistachios Clas Salt 168 g # 24 x 168 g', '161', 15, 107468, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'WDR0120', '014113940023', 'WDR - Pistachios Clas Salt 454 g # 12 x 454 g', '161', 15, 259336, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'WDR0130', '014113940214', 'WDR - Pistachios Clas Salt 400 g # 12 x 400 g', '161', 15, 147450, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'WDR0140', '014113940108', 'WDR - Pistachios PPR & GRLC 50 g # 48 x 50 g', '161', 15, 34814, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'WDR0150', '014113940061', 'WDR - Pistachios PPR & GRLC 168 g # 24 x 168 g', '161', 15, 107468, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'WDR0160', '014113940207', 'WDR - Pistachios Clas No Salt 50 g # 48 x 50 g', '161', 15, 34814, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'WDR0170', '014113940191', 'WDR - Pistachios Clas No Salt 300 g# 24 x 300 g', '161', 15, 159570, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'WDR0200', '014113240055', 'WDR - Almonds Clas Salt 50 g # 48 x 50 g', '161', 15, 31786, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'WDR0210', '014113240024', 'WDR - Almonds Clas Salt 168 g # 24 x 168 g', '161', 15, 96368, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'WDR0220', '014113240031', 'WDR - Almonds Clas Salt 318 g # 24 x 318 g', '161', 15, 162464, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'WDR0230', '014113240116', 'WDR - Almonds Clas Salt 500 g # 12 x 500 g', '161', 15, 295930, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'WNL0110', '7610037000893', 'WNL - Wernli Choco Fin 100 g  # 12 x 100 g', '158', 15, 77000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'WNL0120', '7610062041809', 'WNL - Wernli Choco Belle 100 g # 12 x 100 g', '158', 15, 77000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'WNL0130', '7610062080341', 'WNL - Choco Petit Beurre 125 g # 16 x 125 g', '158', 15, 77000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'WNL0140', '7610062091903', 'WNL - Truffet 100 g # 12 x 100 g', '158', 15, 77000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'WNL0150', '7610062000301', 'WNL - Japonais 100 g # 12 x 100 g', '158', 15, 77000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'WNL0180', '07610062092566', 'WNL - Mini Chocobeau 150 g # 12 x 150 g', '158', 15, NULL, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'WNL0191', '7610062087135', 'WNL - Petit Amour 150g # 8 x 150 g', '158', 15, 130000, 0, 0, 0, 1, '2023-02-21 09:14:30'),
('WH06.07', 'WNL0200', '7610062001001', 'WNL - Wernli Jura Waffers 250 g # 12 x 250 g', '158', 15, 83000, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WNL0210', '07610062081065', 'WNL - Jura Waffer mini 130 g # 12 x 130 g', '158', 15, 55000, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTK0100', '94314212', 'WTK - Peanut Slab 50 g # 4 x 50 x 50 g', '159', 15, 25227, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTK0110', '94314243', 'WTK - Roasted Almond Gold 45 g # 4 x 50 x 45 g', '159', 15, 25227, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTK0120', '9403142000210', 'WTK - Almond Gold Multi 135 g # 24 x 135 g', '159', 15, 72150, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTK0130', '9403142000142', 'WTK - Peanut Slab Multi 150 g # 24 x 150 g', '159', 15, 72150, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTK0200', '9403142002375', 'WTK - Ghana Peppermint Block 220 g # 12 x 220 g', '159', 15, 91827, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTK0210', '9403142002245', 'WTK - Hazelnut Block 200 g # 12 x 200 g', '159', 15, 91827, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTK0220', '9403142002467', 'WTK - Peanut Butter Block 220 g # 12 x 220 g', '159', 15, 91827, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTK0230', '9403142002252', 'WTK - Almond  Gold Block 200 g # 14 x 200 g', '159', 15, 91827, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTK0240', '9403142002320', 'WTK - Berry Biscuit Block 200 g # 14 x 200 g', '159', 15, 91827, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTK0250', '9403142002221', 'WTK - Creamy Milk Block 200 g # 14 x 200 g', '159', 15, 91827, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTK0260', '9403142002269', 'WTK - Dark Almond Block 200 g # 14 x 200 g', '159', 15, 91827, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTK0270', '9403142002351', 'WTK - Dark Ghana Block 200 g # 14 x 200 g', '159', 15, 91827, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTK0280', '9403142002214', 'WTK - Fruit Nut Block 200 g # 14 x 200 g', '159', 15, 91827, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTK0300', '94184648', 'WTK - Sante 72% Dark Ghana # 9 x 48 x 25 g', '159', 15, 13118, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTK0310', '94314281', 'WTK - Sante Dark Choco # 9 x 48 x 25 g', '159', 15, 13118, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTK0320', '94314274', 'WTK - Sante Milk Choco Bar # 9 x 48 x 25 g', '159', 15, 13118, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTK0330', '94314229', 'WTK - Sante White Choco Bar # 9 x 48 x 25 g', '159', 15, 13118, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTK0400', '9403142000678', 'WTK - Almond Gold Chunks 50 g # 6 x 36 x 50 g', '159', 15, 26236, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTK0410', '9403142000630', 'WTK - Berry Biscuit Chunks 50 g # 6 x 36 x 50 g', '159', 15, 26236, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTK0420', '9403142000609', 'WTK - Creamy Milk Cho Chunk 50 g # 6 x ( 36 x 50 g )', '159', 15, 26236, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTK0430', '9403142000654', 'WTK - Dark Almond Chunks 50 g # 6 x 36 x 50 g', '159', 15, 26236, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTK0440', '9403142000623', 'WTK - Dark Choc ChunkS 50 g # 6 x ( 36 x 50 g )', '159', 15, 26236, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTK0450', '9403142000685', 'WTK - Peppermint Chunks 6 x 36 x 50 g # 6 x 36 x 50 g', '159', 15, 26236, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTK0460', '9403142000661', 'WTK - Hazelnut Chunks 6 x 36 x 50 g # 6 x 36 x 50 g', '159', 15, 26236, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTK0470', '9403142001361', 'WTK - 72 % Dark Ghana Chochunks  # 6 x ( 36 x 50 g )', '159', 15, 26236, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTK0480', '9403142000616', 'WTK - Fruit & Nut Choc Chunks # 6 x ( 36 x 50 g )', '159', 15, 26236, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTK0490', '9403142001088', 'WTK - White Choc Chunks # 6 x ( 36 x 50 g )', '159', 15, 26236, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTK0500', '9403142001675', 'WTK - Berry & Biscuit 180 g # 12 x 180 g', '159', 15, 98386, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTK0510', '9403142001668', 'WTK - Hokey - Pokey 180 g # 12 x 180 g', '159', 15, 98386, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTR0100', '8003535023218', 'WTR - Bianco Coure 250 g # 12 x 250 g', '160', 15, 109486, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTR0110', '8003535023171', 'WTR - Golden 250 g # 12 x 250 g', '160', 15, 109486, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTR0120', '8003535020934', 'WTR - Golden 1 kg # 9 x 1 kg', '160', 15, 344605, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTR0130', '8003535044138', 'WTR - Noir 250 g # 12 x 250 g', '160', 15, 109486, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTR0140', '8003535023256', 'WTR - Selection Classic 250 g # 12 x 250 g', '160', 15, 109486, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTR0150', '8003535026578', 'WTR - Selection Classic 1 kg # 9 x 1 kg', '160', 15, 344605, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTR0160', '8003535022778', 'WTR - Pyramid Selection 300 g # 6 x 300 g', '160', 15, 199800, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'WTR0170', '8003535026295', 'WTR - Selection Ice Bucket 350 g # 5 x 350 g', '160', 15, 231082, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'ZAI0100', '8004735069594', 'ZAI - Egg Trio Frozen 60 g # 24 x 60 g', '162', 15, 64481, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'ZAI0110', '8004735031089', 'ZAI - Egg Trio Princess 60 g # 24 x 60 g', '162', 15, 64481, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'ZAI0120', '8004735030662', 'ZAI - Egg Trio Toy Story # 24 x 60 g', '162', 15, 64481, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'ZAI0130', '8004735091175', 'ZAI - Egg Trio Insideout  # 24 x 60 g', '162', 15, 64481, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'ZAI0140', '8004735101034', 'ZAI - Egg Trio Mickey 60 g # 24 x 60 g', '162', 15, 64481, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'ZAI0150', '8004735031218', 'ZAI - Egg Trio Cars 60 g # 24 x 60 g', '162', 15, 64481, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'ZAI0160', '8004735101041', 'ZAI - Egg Trio Sofia 60 g # 24 x 60 g', '162', 15, 64481, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'ZAI0170', '8004735031621', 'ZAI - Egg Trio Minnie 60 g # 24 x 60 g', '162', 15, 64481, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'ZAI0180', '8004735096545', 'ZAI - Egg Trio Tsum - Tsum 60 g # 24 x 60 g', '162', 15, 64481, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'ZAI0190', '8004735092547', 'ZAI - Egg Trio Hello Kitty 60 g # 24 x 60 g', '162', 15, 64481, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'ZAI01A0', '8004735109184', 'ZAI - Pororo Trio Eggs 60 g # 24 x 60 g', '162', 15, 64481, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'ZAI01B0', '8004735111163', 'ZAI - Hot Wheels Trio Eggs 60 g # 24 x 60 g', '162', 15, 64481, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'ZAI01C0', '8004735093933', 'ZAI - Barbie Trio Eggs 60 g # 24 x 60 g', '162', 15, 64481, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'ZAI01D0', '8004735094473', 'ZAI - Paw Patrol Trio Eggs 60 g # 24 X 60 g', '162', 15, 64481, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'ZAI01E0', '8004735110579', 'ZAI - Pj Masks Trio Eggs 60 g # 24 x 60 g', '162', 15, 64481, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'ZAI01F0', '8004735106183', 'ZAI - Tayo Trio Eggs 60 g # 24 x 60 g', '162', 15, 64481, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'ZAI0200', '80838876', 'ZAI - Crockki Mickey 18 g # 2 x 24 x 18 g', '162', 15, 22099, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'ZAI0211', '80774914', 'ZAI - Crockki Minnie 18 g # 2 x 24 x 18 g', '162', 15, 22099, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'ZAI0220', '80871170', 'ZAI - Crockki Frozen 18 g # 2 x 24 x 18 g', '162', 15, 22099, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'ZAI0230', '80884415', 'ZAI - Crockki Cars 18 g # 2 x 24 x 18 g', '162', 15, 22099, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'ZAI0240', '80985754', 'ZAI - Crockki Tsum - Tsum 18 g # 2 x 24 x 18 g', '162', 15, 22099, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'ZAI0241', '080985754', 'ZAI - Crockki Tsum - Tsum 18 g # 12 x 12 x 18 g', '162', 15, 0, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'ZAI0400', '8004735065206', 'ZAI - Ciocobisco # 18 x 100 g', '162', 15, 72655, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'ZAI0410', '8004735065237', 'ZAI - Noughita # 18 x 100 g', '162', 15, 72655, 0, 0, 0, 1, '2023-02-21 09:14:31'),
('WH06.07', 'ZAI0421', '8004735108064', 'ZAI - Boero Cherry  # 12 X 210 g', '162', 15, 128155, 0, 0, 0, 1, '2023-02-21 09:14:31');

-- --------------------------------------------------------

--
-- Table structure for table `t_cart_transfer_stockin`
--

CREATE TABLE `t_cart_transfer_stockin` (
  `docnum` varchar(255) DEFAULT NULL,
  `whs_code_send` varchar(255) DEFAULT NULL,
  `whs_code_rec` varchar(255) DEFAULT NULL,
  `item_code` varchar(255) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `exp_date` datetime DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `t_cart_transfer_stockout`
--

CREATE TABLE `t_cart_transfer_stockout` (
  `id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_id_detail` int(11) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `exp_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `t_header_stock`
--

CREATE TABLE `t_header_stock` (
  `id` int(11) NOT NULL,
  `stock_code` varchar(255) DEFAULT NULL,
  `jenis_stock` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_header_stock`
--

INSERT INTO `t_header_stock` (`id`, `stock_code`, `jenis_stock`, `created_by`, `created_at`) VALUES
(1, 'FA12-IN-2301130001', NULL, NULL, '2023-01-13 09:43:46'),
(2, 'FA12-OUT-2301130001', NULL, NULL, '2023-01-13 10:09:56');

-- --------------------------------------------------------

--
-- Table structure for table `t_sale`
--

CREATE TABLE `t_sale` (
  `sale_id` int(11) NOT NULL,
  `id_toko` int(11) DEFAULT NULL,
  `invoice` varchar(50) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `total_price` float NOT NULL,
  `discount` float NOT NULL,
  `final_price` float NOT NULL,
  `total_item_value` float DEFAULT NULL,
  `tax` float NOT NULL,
  `service` float NOT NULL,
  `total_bayar` float NOT NULL,
  `type_bayar` varchar(10) NOT NULL,
  `nomor_kartu` varchar(50) NOT NULL,
  `jenis_kartu` varchar(100) NOT NULL,
  `nama_pemilik_kartu` varchar(200) NOT NULL,
  `cash` float NOT NULL,
  `remaining` float NOT NULL,
  `note` text NOT NULL,
  `date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `printed` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_sale`
--

INSERT INTO `t_sale` (`sale_id`, `id_toko`, `invoice`, `customer_id`, `total_price`, `discount`, `final_price`, `total_item_value`, `tax`, `service`, `total_bayar`, `type_bayar`, `nomor_kartu`, `jenis_kartu`, `nama_pemilik_kartu`, `cash`, `remaining`, `note`, `date`, `user_id`, `created`, `printed`) VALUES
(4, 5, 'FA23-2302210001', NULL, 218330, 0, 218330, 218330, 19848.2, 0, 300000, '1', '', '', '', 300000, 81670, '', '2023-02-21', 2, '2023-02-21 11:40:21', 0),
(5, 5, 'FA23-2302210002', NULL, 15136, 0, 15136, 15136, 1376, 0, 20000, '1', '', '', '', 20000, 4864, '', '2023-02-21', 2, '2023-02-21 12:50:53', 0),
(6, 5, 'FA23-2302210003', NULL, 30676, 0, 30676, 30676, 2788.73, 0, 50000, '1', '', '', '', 50000, 19324, '', '2023-02-21', 2, '2023-02-21 14:19:30', 0),
(7, 5, 'FA23-2302210004', NULL, 3712510, 0, 3712510, 3712510, 337501, 0, 3712510, '1', '', '', '', 3712510, 0, '', '2023-02-21', 2, '2023-02-21 14:51:58', 0),
(8, 5, 'FA23-2302210005', NULL, 44399, 0, 44399, 44399, 4036.27, 0, 44399, '6', '', '', '', 44399, 0, '', '2023-02-21', 2, '2023-02-21 15:29:35', 0),
(9, 5, 'FA23-2302210006', NULL, 155400, 0, 155400, 155400, 14127.3, 0, 155400, '8', '', '', '', 155400, 0, '', '2023-02-21', 2, '2023-02-21 17:23:32', 0),
(10, 5, 'FA23-2302210007', NULL, 217965, 0, 217965, 217965, 19815, 0, 217965, '2', '', '', '', 217965, 0, '', '2023-02-21', 2, '2023-02-21 18:35:03', 0),
(11, 5, 'FA23-2302210008', NULL, 52472, 0, 52472, 52472, 4770.18, 0, 52472, '1', '', '', '', 52472, 0, '', '2023-02-21', 2, '2023-02-21 19:51:13', 0),
(12, 5, 'FA23-2302210009', NULL, 181634, 0, 181634, 181634, 16512.2, 0, 181634, '6', '', '', '', 181634, 0, '', '2023-02-21', 2, '2023-02-21 19:52:25', 0),
(13, 5, 'FA23-2302210010', NULL, 69000, 0, 69000, 69000, 6272.73, 0, 69000, '2', '', '', '', 69000, 0, '', '2023-02-21', 2, '2023-02-21 19:53:13', 0),
(14, 5, 'FA23-2302210011', NULL, 64481, 0, 64481, 64481, 5861.91, 0, 70000, '1', '', '', '', 70000, 5519, '', '2023-02-21', 2, '2023-02-21 20:58:22', 0),
(15, 5, 'FA23-2302210012', NULL, 64481, 0, 64481, 64481, 5861.91, 0, 100000, '1', '', '', '', 100000, 35519, '', '2023-02-21', 2, '2023-02-21 20:59:02', 0),
(16, 5, 'FA23-2302210013', NULL, 226540, 0, 226540, 226540, 20594.5, 0, 226540, '2', '', '', '', 226540, 0, '', '2023-02-21', 2, '2023-02-21 21:37:04', 0),
(17, 5, 'FA23-2302220001', NULL, 128000, 0, 128000, 128000, 11636.4, 0, 128000, '1', '', '', '', 128000, 0, '', '2023-02-22', 2, '2023-02-22 11:26:38', 0),
(18, 5, 'FA23-2302220002', NULL, 128000, 0, 128000, 128000, 11636.4, 0, 128000, '1', '', '', '', 128000, 0, '', '2023-02-22', 2, '2023-02-22 11:48:55', 1),
(19, 5, 'FA23-2302220003', NULL, 151061, 0, 151061, 151061, 13732.8, 0, 151061, '2', '', '', '', 151061, 0, '', '2023-02-22', 2, '2023-02-22 11:49:57', 0),
(20, 5, 'FA23-2302220004', NULL, 69000, 0, 69000, 69000, 6272.73, 0, 69000, '2', '', '', '', 69000, 0, '', '2023-02-22', 2, '2023-02-22 11:50:27', 0),
(21, 5, 'FA23-2302220005', NULL, 64481, 0, 64481, 64481, 5861.91, 0, 64481, '1', '', '', '', 64481, 0, '', '2023-02-22', 2, '2023-02-22 12:51:47', 0),
(22, 5, 'FA23-2302220006', NULL, 15136, 0, 15136, 15136, 1376, 0, 50000, '1', '', '', '', 50000, 34864, '', '2023-02-22', 2, '2023-02-22 15:55:38', 0),
(23, 5, 'FA23-2302220007', NULL, 155400, 0, 155400, 155400, 14127.3, 0, 155400, '2', '', '', '', 155400, 0, '', '2023-02-22', 2, '2023-02-22 17:59:30', 0),
(24, 5, 'FA23-2302220008', NULL, 183654, 0, 183654, 183654, 16695.8, 0, 183654, '8', '', '', '', 183654, 0, '', '2023-02-22', 2, '2023-02-22 18:28:32', 0),
(25, 5, 'FA23-2302220009', NULL, 155400, 0, 155400, 155400, 14127.3, 0, 200000, '1', '', '', '', 200000, 44600, '', '2023-02-22', 2, '2023-02-22 18:48:07', 0),
(26, 5, 'FA23-2302220010', NULL, 375778, 0, 375778, 375778, 34161.6, 0, 375778, '2', '', '', '', 375778, 0, '', '2023-02-22', 2, '2023-02-22 20:33:07', 0),
(27, 5, 'FA23-2302220011', NULL, 64481, 0, 64481, 64481, 5861.91, 0, 64481, '2', '', '', '', 64481, 0, '', '2023-02-22', 2, '2023-02-22 20:56:30', 0),
(28, 5, 'FA23-2302220012', NULL, 72654, 0, 72654, 72654, 6604.91, 0, 72654, '2', '', '', '', 72654, 0, '', '2023-02-22', 2, '2023-02-22 21:01:09', 0),
(29, 5, 'FA23-2302220013', NULL, 154000, 0, 154000, 154000, 14000, 0, 154000, '6', '', '', '', 154000, 0, '', '2023-02-22', 2, '2023-02-22 21:01:45', 0),
(30, 5, 'FA23-2302220014', NULL, 176539, 0, 176539, 176539, 16049, 0, 176539, '2', '', '', '', 176539, 0, '', '2023-02-22', 2, '2023-02-22 21:45:39', 0),
(31, 5, 'FA23-2302220015', NULL, 267913, 0, 267913, 267913, 24355.7, 0, 300000, '1', '', '', '', 300000, 32087, '', '2023-02-22', 2, '2023-02-22 21:48:08', 0),
(32, 5, 'FA23-2302220016', NULL, 69000, 0, 69000, 69000, 6272.73, 0, 69000, '1', '', '', '', 69000, 0, '', '2023-02-22', 2, '2023-02-22 21:48:30', 0),
(33, 5, 'FA23-2302230001', NULL, 117054, 0, 117054, 117054, 10641.3, 0, 200000, '1', '', '', '', 200000, 82946, '', '2023-02-23', 2, '2023-02-23 12:51:06', 0),
(34, 5, 'FA23-2302230002', NULL, 30272, 0, 30272, 30272, 2752, 0, 50000, '1', '', '', '', 50000, 19728, '', '2023-02-23', 2, '2023-02-23 12:51:38', 0),
(35, 5, 'FA23-2302230003', NULL, 145310, 0, 145310, 145310, 13210, 0, 145310, '2', '', '', '', 145310, 0, '', '2023-02-23', 2, '2023-02-23 13:00:44', 0),
(36, 5, 'FA23-2302230004', NULL, 104971, 0, 104971, 104970, 9542.82, 0, 104971, '6', '', '', '', 104971, 0, '', '2023-02-23', 2, '2023-02-23 13:05:50', 0),
(37, 5, 'FA23-2302230005', NULL, 126641, 0, 126641, 126641, 11512.8, 0, 126641, '8', '', '', '', 126641, 0, '', '2023-02-23', 2, '2023-02-23 13:39:33', 0),
(38, 5, 'FA23-2302230006', NULL, 190440, 0, 190440, 190440, 17312.7, 0, 190440, '2', '', '', '', 190440, 0, '', '2023-02-23', 2, '2023-02-23 15:14:38', 0),
(39, 5, 'FA23-2302230007', NULL, 186176, 0, 186176, 186176, 16925.1, 0, 186176, '2', '', '', '', 186176, 0, '', '2023-02-23', 2, '2023-02-23 16:20:23', 0),
(40, 5, 'FA23-2302230008', NULL, 22200, 0, 22200, 22200, 2018.18, 0, 22200, '1', '', '', '', 22200, 0, '', '2023-02-23', 2, '2023-02-23 16:22:19', 0),
(41, 5, 'FA23-2302230009', NULL, 357420, 0, 357420, 357420, 32492.7, 0, 357420, '2', '', '', '', 357420, 0, '', '2023-02-23', 2, '2023-02-23 16:25:41', 0),
(42, 5, 'FA23-2302230010', NULL, 20182, 0, 20182, 20182, 1834.73, 0, 20182, '1', '', '', '', 20182, 0, '', '2023-02-23', 2, '2023-02-23 16:26:10', 0),
(43, 5, 'FA23-2302230011', NULL, 64481, 0, 64481, 64481, 5861.91, 0, 64481, '2', '', '', '', 64481, 0, '', '2023-02-23', 2, '2023-02-23 16:26:53', 0),
(44, 5, 'FA23-2302230012', NULL, 64481, 0, 64481, 64481, 5861.91, 0, 64481, '2', '', '', '', 64481, 0, '', '2023-02-23', 2, '2023-02-23 18:44:41', 0),
(45, 5, 'FA23-2302230013', NULL, 128155, 0, 128155, 128155, 11650.5, 0, 128155, '2', '', '', '', 128155, 0, '', '2023-02-23', 2, '2023-02-23 19:56:11', 0),
(46, 5, 'FA23-2302230014', NULL, 64481, 0, 64481, 64481, 5861.91, 0, 64481, '2', '', '', '', 64481, 0, '', '2023-02-23', 2, '2023-02-23 20:19:39', 0),
(47, 5, 'FA23-2302230015', NULL, 245440, 0, 245440, 245440, 22312.7, 0, 245440, '5', '', '', '', 245440, 0, '', '2023-02-23', 2, '2023-02-23 20:33:48', 0),
(48, 5, 'FA23-2302230016', NULL, 15136, 0, 15136, 15136, 1376, 0, 15200, '1', '', '', '', 15200, 64, '', '2023-02-23', 2, '2023-02-23 21:40:27', 0),
(49, 5, 'FA23-2302240001', NULL, 143290, 0, 143290, 143290, 13026.4, 0, 143290, '5', '', '', '', 143290, 0, '', '2023-02-24', 2, '2023-02-24 13:01:37', 0),
(50, 5, 'FA23-2302240002', NULL, 366804, 0, 366804, 366804, 33345.8, 0, 366804, '5', '', '', '', 366804, 0, '', '2023-02-24', 2, '2023-02-24 13:33:50', 0),
(51, 5, 'FA23-2302240003', NULL, 308479, 0, 308479, 308479, 28043.5, 0, 308479, '6', '', '', '', 308479, 0, '', '2023-02-24', 2, '2023-02-24 13:50:43', 0),
(52, 5, 'FA23-2302240004', NULL, 287590, 0, 287590, 287590, 26144.5, 0, 287590, '2', '', '', '', 287590, 0, '', '2023-02-24', 2, '2023-02-24 14:44:51', 0),
(53, 5, 'FA23-2302240005', NULL, 702230, 0, 702230, 702230, 63839.1, 0, 702230, '2', '', '', '', 702230, 0, '', '2023-02-24', 2, '2023-02-24 15:15:55', 0),
(54, 5, 'FA23-2302240006', NULL, 49000, 0, 49000, 49000, 4454.55, 0, 49000, '8', '', '', '', 49000, 0, '', '2023-02-24', 2, '2023-02-24 17:05:45', 0),
(55, 5, 'FA23-2302240007', NULL, 22099, 0, 22099, 22099, 2009, 0, 30200, '1', '', '', '', 30200, 8101, '', '2023-02-24', 2, '2023-02-24 17:06:24', 0),
(56, 5, 'FA23-2302240008', NULL, 240668, 0, 240668, 240668, 21878.9, 0, 240668, '8', '', '', '', 240668, 0, '', '2023-02-24', 2, '2023-02-24 17:10:14', 0),
(57, 5, 'FA23-2302240009', NULL, 77000, 0, 77000, 77000, 7000, 0, 77000, '2', '', '', '', 77000, 0, '', '2023-02-24', 2, '2023-02-24 17:43:05', 0),
(58, 5, 'FA23-2302240010', NULL, 230000, 0, 230000, 230000, 20909.1, 0, 230000, '6', '', '', '', 230000, 0, '', '2023-02-24', 2, '2023-02-24 18:34:00', 0),
(59, 5, 'FA23-2302240011', NULL, 161454, 0, 161454, 161454, 14677.6, 0, 161454, '1', '', '', '', 161454, 0, '', '2023-02-24', 2, '2023-02-24 20:44:18', 0),
(60, 5, 'FA23-2302240012', NULL, 87272, 0, 87272, 87272, 7933.82, 0, 87272, '1', '', '', '', 87272, 0, '', '2023-02-24', 2, '2023-02-24 20:44:53', 0),
(61, 5, 'FA23-2302240013', NULL, 53986, 0, 53986, 53986, 4907.82, 0, 53986, '8', '', '', '', 53986, 0, '', '2023-02-24', 2, '2023-02-24 20:51:18', 0),
(62, 5, 'FA23-2302240014', NULL, 37841, 0, 37841, 37841, 3440.09, 0, 37841, '2', '', '', '', 37841, 0, '', '2023-02-24', 2, '2023-02-24 21:05:26', 0),
(63, 5, 'FA23-2302240015', NULL, 135724, 0, 135724, 135724, 12338.5, 0, 135724, '8', '', '', '', 135724, 0, '', '2023-02-24', 2, '2023-02-24 21:20:53', 0),
(64, 5, 'FA23-2302240016', NULL, 47428, 0, 47428, 47428, 4311.64, 0, 47428, '1', '', '', '', 47428, 0, '', '2023-02-24', 2, '2023-02-24 21:24:41', 0),
(65, 5, 'FA23-2302240017', NULL, 64330, 0, 64330, 64330, 5848.18, 0, 64330, '8', '', '', '', 64330, 0, '', '2023-02-24', 2, '2023-02-24 21:46:49', 0),
(66, 5, 'FA23-2302240018', NULL, 146000, 0, 146000, 146000, 13272.7, 0, 146000, '2', '', '', '', 146000, 0, '', '2023-02-24', 2, '2023-02-24 21:51:06', 0);

-- --------------------------------------------------------

--
-- Table structure for table `t_sale_detail`
--

CREATE TABLE `t_sale_detail` (
  `detail_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_id_detail` int(11) DEFAULT NULL,
  `price` float NOT NULL,
  `qty` float NOT NULL,
  `exp_date` datetime DEFAULT NULL,
  `exp_date_2` datetime DEFAULT NULL,
  `discount_item` float NOT NULL,
  `total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_sale_detail`
--

INSERT INTO `t_sale_detail` (`detail_id`, `sale_id`, `item_id`, `item_id_detail`, `price`, `qty`, `exp_date`, `exp_date_2`, `discount_item`, `total`) VALUES
(5, 4, 4683, 5341, 105000, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 105000),
(6, 4, 4592, 5250, 64330, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 64330),
(7, 4, 4532, 5190, 49000, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 49000),
(8, 5, 4334, 4992, 15136, 1, '2023-12-31 00:00:00', '2024-11-04 00:00:00', 0, 15136),
(9, 6, 4333, 4991, 8577, 1, '2023-12-31 00:00:00', '2024-11-05 00:00:00', 0, 8577),
(10, 6, 4673, 5331, 22099, 1, '2023-12-31 00:00:00', '2024-05-30 00:00:00', 0, 22099),
(11, 7, 4677, 5335, 72655, 5, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 363275),
(12, 7, 4334, 4992, 15136, 2, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 30272),
(13, 7, 4466, 5124, 69627, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 69627),
(14, 7, 4468, 5126, 28500, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 28500),
(15, 7, 4341, 4999, 185168, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 185168),
(16, 7, 4612, 5270, 77000, 2, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 154000),
(17, 7, 4662, 5320, 64481, 2, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 128962),
(18, 7, 4664, 5322, 64481, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 64481),
(19, 7, 4661, 5319, 64481, 2, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 128962),
(20, 7, 4610, 5268, 77000, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 77000),
(21, 7, 4494, 5152, 136732, 6, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 20509.8, 697333),
(22, 7, 4493, 5151, 136732, 2, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 20509.8, 232444),
(23, 7, 4568, 5226, 200809, 3, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 602427),
(24, 7, 4569, 5227, 200809, 2, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 401618),
(25, 7, 4567, 5225, 200809, 2, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 401618),
(26, 7, 4373, 5031, 22200, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 22200),
(27, 7, 4376, 5034, 22200, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 22200),
(28, 7, 4379, 5037, 22200, 2, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 44400),
(29, 7, 4375, 5033, 11605, 5, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 58025),
(30, 7, 4419, 5077, 0, 4, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 0),
(31, 8, 4461, 5119, 20686, 1, '2023-12-31 00:00:00', '2024-07-21 00:00:00', 0, 20686),
(32, 8, 4334, 4992, 15136, 1, '2023-12-31 00:00:00', '2024-11-04 00:00:00', 0, 15136),
(33, 8, 4333, 4991, 8577, 1, '2023-12-31 00:00:00', '2024-09-18 00:00:00', 0, 8577),
(34, 9, 4504, 5162, 155400, 1, '2023-12-31 00:00:00', '2023-11-30 00:00:00', 0, 155400),
(35, 10, 4482, 5140, 72655, 3, '2023-12-31 00:00:00', '2023-05-31 00:00:00', 0, 217965),
(36, 11, 4637, 5295, 26236, 2, '2023-12-31 00:00:00', '2023-09-03 00:00:00', 0, 52472),
(37, 12, 4637, 5295, 26236, 6, '2023-12-31 00:00:00', '2023-09-03 00:00:00', 0, 157416),
(38, 12, 4490, 5148, 24218, 1, '2023-12-31 00:00:00', '2023-09-29 00:00:00', 0, 24218),
(39, 13, 4535, 5193, 69000, 2, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 34500, 69000),
(40, 14, 4655, 5313, 64481, 1, '2023-12-31 00:00:00', '2024-08-08 00:00:00', 0, 64481),
(41, 15, 4655, 5313, 64481, 1, '2023-12-31 00:00:00', '2024-08-08 00:00:00', 0, 64481),
(42, 16, 4334, 4992, 15136, 1, '2023-12-31 00:00:00', '2024-11-04 00:00:00', 0, 15136),
(43, 16, 4475, 5133, 53986, 2, '2023-12-31 00:00:00', '2023-09-30 00:00:00', 0, 107972),
(44, 16, 4556, 5214, 24723, 2, '2023-12-31 00:00:00', '2024-02-04 00:00:00', 0, 49446),
(45, 16, 4473, 5131, 53986, 1, '2023-12-31 00:00:00', '2023-08-31 00:00:00', 0, 53986),
(46, 17, 4532, 5190, 49000, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 49000),
(47, 17, 4594, 5252, 79000, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 79000),
(48, 18, 4532, 5190, 49000, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 49000),
(49, 18, 4594, 5252, 79000, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 79000),
(50, 19, 4656, 5314, 64481, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 64481),
(51, 19, 4663, 5321, 64481, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 64481),
(52, 19, 4675, 5333, 22099, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 22099),
(53, 20, 4535, 5193, 69000, 2, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 34500, 69000),
(54, 21, 4667, 5325, 64481, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 64481),
(55, 22, 4334, 4992, 15136, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 15136),
(56, 23, 4503, 5161, 155400, 1, '2023-12-31 00:00:00', '2023-08-30 00:00:00', 0, 155400),
(57, 24, 4622, 5280, 91827, 1, '2023-12-31 00:00:00', '2023-09-27 00:00:00', 0, 91827),
(58, 24, 4629, 5287, 91827, 1, '2023-12-31 00:00:00', '2023-09-28 00:00:00', 0, 91827),
(59, 25, 4503, 5161, 155400, 1, '2023-12-31 00:00:00', '2023-05-08 00:00:00', 0, 155400),
(60, 26, 4518, 5176, 160445, 1, '2023-12-31 00:00:00', '2023-10-10 00:00:00', 24066.8, 136378),
(61, 26, 4504, 5162, 155400, 1, '2023-12-31 00:00:00', '2023-11-30 00:00:00', 0, 155400),
(62, 26, 4681, 5339, 15000, 1, '2023-12-31 00:00:00', '2023-11-30 00:00:00', 0, 15000),
(63, 26, 4535, 5193, 69000, 2, '2023-12-31 00:00:00', '2023-04-08 00:00:00', 34500, 69000),
(64, 26, 4419, 5077, 0, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 0),
(65, 27, 4662, 5320, 64481, 1, '2023-12-31 00:00:00', '2024-05-30 00:00:00', 0, 64481),
(66, 28, 4488, 5146, 24218, 3, '2023-12-31 00:00:00', '2023-12-22 00:00:00', 0, 72654),
(67, 29, 4611, 5269, 77000, 2, '2023-12-31 00:00:00', '2023-10-06 00:00:00', 0, 154000),
(68, 30, 4655, 5313, 64481, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 64481),
(69, 30, 4334, 4992, 15136, 2, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 30272),
(70, 30, 4546, 5204, 31786, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 31786),
(71, 30, 4467, 5125, 50000, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 50000),
(72, 31, 4544, 5202, 48941, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 48941),
(73, 31, 4647, 5305, 109486, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 109486),
(74, 31, 4650, 5308, 109486, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 109486),
(75, 32, 4535, 5193, 69000, 2, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 34500, 69000),
(76, 33, 4348, 5006, 58527, 2, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 117054),
(77, 34, 4334, 4992, 15136, 2, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 30272),
(78, 35, 4480, 5138, 72655, 2, '2023-12-31 00:00:00', '2023-10-31 00:00:00', 0, 145310),
(79, 36, 4665, 5323, 64481, 1, '2023-12-31 00:00:00', '2024-09-30 00:00:00', 0, 64481),
(80, 36, 4474, 5132, 53986, 1, '2023-12-31 00:00:00', '2023-05-30 00:00:00', 13496.5, 40489.5),
(81, 37, 4483, 5141, 72655, 1, '2023-12-31 00:00:00', '2023-08-31 00:00:00', 0, 72655),
(82, 37, 4473, 5131, 53986, 1, '2023-12-31 00:00:00', '2023-08-31 00:00:00', 0, 53986),
(83, 38, 4493, 5151, 136732, 1, '2023-12-31 00:00:00', '2023-11-30 00:00:00', 20509.8, 116222),
(84, 38, 4467, 5125, 50000, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 50000),
(85, 38, 4490, 5148, 24218, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 24218),
(86, 38, 4419, 5077, 0, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 0),
(87, 39, 4474, 5132, 53986, 4, '2023-12-31 00:00:00', '2023-05-31 00:00:00', 13496.5, 161958),
(88, 39, 4488, 5146, 24218, 1, '2023-12-31 00:00:00', '2023-08-12 00:00:00', 0, 24218),
(89, 40, 4369, 5027, 11100, 2, '2023-12-31 00:00:00', '2024-03-04 00:00:00', 0, 22200),
(90, 41, 4504, 5162, 155400, 1, '2023-12-31 00:00:00', '2023-11-30 00:00:00', 0, 155400),
(91, 41, 4662, 5320, 64481, 1, '2023-12-31 00:00:00', '2024-05-30 00:00:00', 0, 64481),
(92, 41, 4657, 5315, 64481, 1, '2023-12-31 00:00:00', '2024-08-30 00:00:00', 0, 64481),
(93, 41, 4333, 4991, 8577, 1, '2023-12-31 00:00:00', '2024-11-04 00:00:00', 0, 8577),
(94, 41, 4419, 5077, 0, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 0),
(95, 41, 4655, 5313, 64481, 1, '2023-12-31 00:00:00', '2024-08-31 00:00:00', 0, 64481),
(96, 42, 4370, 5028, 20182, 1, '2023-12-31 00:00:00', '2024-04-03 00:00:00', 0, 20182),
(97, 43, 4666, 5324, 64481, 1, '2023-12-31 00:00:00', '2024-08-31 00:00:00', 0, 64481),
(98, 44, 4661, 5319, 64481, 1, '2023-12-31 00:00:00', '2024-05-30 00:00:00', 0, 64481),
(99, 45, 4678, 5336, 128155, 1, '2023-12-31 00:00:00', '2024-05-30 00:00:00', 0, 128155),
(100, 46, 4657, 5315, 64481, 1, '2023-12-31 00:00:00', '2024-08-30 00:00:00', 0, 64481),
(101, 47, 4683, 5341, 105000, 1, '2023-12-31 00:00:00', '2023-05-31 00:00:00', 0, 105000),
(102, 47, 4493, 5151, 136732, 1, '2023-12-31 00:00:00', '2023-11-30 00:00:00', 20509.8, 116222),
(103, 47, 4489, 5147, 24218, 1, '2023-12-31 00:00:00', '2023-10-23 00:00:00', 0, 24218),
(104, 48, 4334, 4992, 15136, 1, '2023-12-31 00:00:00', '2024-11-04 00:00:00', 0, 15136),
(105, 49, 4370, 5028, 20182, 1, '2023-12-31 00:00:00', '2024-03-05 00:00:00', 0, 20182),
(106, 49, 4463, 5121, 81736, 1, '2023-12-31 00:00:00', '2024-03-16 00:00:00', 0, 81736),
(107, 49, 4637, 5295, 26236, 1, '2023-12-31 00:00:00', '2023-09-03 00:00:00', 0, 26236),
(108, 49, 4334, 4992, 15136, 1, '2023-12-31 00:00:00', '2024-11-04 00:00:00', 0, 15136),
(109, 50, 4599, 5257, 259336, 1, '2023-12-31 00:00:00', '2024-02-01 00:00:00', 0, 259336),
(110, 50, 4602, 5260, 107468, 1, '2023-12-31 00:00:00', '2023-08-01 00:00:00', 0, 107468),
(111, 50, 4419, 5077, 0, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 0),
(112, 51, 4520, 5178, 92836, 1, '2023-12-31 00:00:00', '2023-11-30 00:00:00', 0, 92836),
(113, 51, 4660, 5318, 64481, 2, '2023-12-31 00:00:00', '2024-08-31 00:00:00', 0, 128962),
(114, 51, 4665, 5323, 64481, 1, '2023-12-31 00:00:00', '2024-08-31 00:00:00', 0, 64481),
(115, 51, 4379, 5037, 22200, 1, '2023-12-31 00:00:00', '2024-04-03 00:00:00', 0, 22200),
(116, 51, 4419, 5077, 0, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 0),
(117, 52, 4499, 5157, 70636, 1, '2023-12-31 00:00:00', '2023-05-31 00:00:00', 0, 70636),
(118, 52, 4483, 5141, 72655, 1, '2023-12-31 00:00:00', '2023-09-30 00:00:00', 0, 72655),
(119, 52, 4628, 5286, 91827, 1, '2023-12-31 00:00:00', '2023-10-28 00:00:00', 0, 91827),
(120, 52, 4642, 5300, 26236, 2, '2023-12-31 00:00:00', '2023-09-07 00:00:00', 0, 52472),
(121, 52, 4419, 5077, 0, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 0),
(122, 53, 4546, 5204, 31786, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 31786),
(123, 53, 4612, 5270, 77000, 4, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 308000),
(124, 53, 4494, 5152, 136732, 2, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 20509.8, 232444),
(125, 53, 4419, 5077, 0, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 0),
(126, 53, 4615, 5273, 130000, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 130000),
(127, 54, 4532, 5190, 49000, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 49000),
(128, 55, 4675, 5333, 22099, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 22099),
(129, 56, 4479, 5137, 75177, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 75177),
(130, 56, 4507, 5165, 165491, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 165491),
(131, 57, 4611, 5269, 77000, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 38500, 38500),
(132, 57, 4613, 5271, 77000, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 38500, 38500),
(133, 58, 4389, 5047, 215000, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 215000),
(134, 58, 4681, 5339, 15000, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 15000),
(135, 59, 4374, 5032, 40868, 1, '2023-12-31 00:00:00', '2024-03-06 00:00:00', 0, 40868),
(136, 59, 4380, 5038, 40868, 1, '2023-12-31 00:00:00', '2024-03-06 00:00:00', 0, 40868),
(137, 59, 4377, 5035, 40868, 1, '2023-12-31 00:00:00', '2024-03-06 00:00:00', 0, 40868),
(138, 59, 4371, 5029, 38850, 1, '2023-12-31 00:00:00', '2024-03-06 00:00:00', 0, 38850),
(139, 60, 4468, 5126, 28500, 2, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 57000),
(140, 60, 4334, 4992, 15136, 2, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 30272),
(141, 61, 4473, 5131, 53986, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 53986),
(142, 62, 4561, 5219, 37841, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 37841),
(143, 63, 4544, 5202, 48941, 2, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 97882),
(144, 63, 4564, 5222, 37842, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 37842),
(145, 64, 4378, 5036, 11605, 2, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 23210),
(146, 64, 4490, 5148, 24218, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 24218),
(147, 65, 4590, 5248, 64330, 1, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 0, 64330),
(148, 66, 4596, 5254, 69000, 2, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 34500, 69000),
(149, 66, 4611, 5269, 77000, 2, '2023-12-31 00:00:00', '2023-12-31 00:00:00', 38500, 77000);

-- --------------------------------------------------------

--
-- Table structure for table `t_stock`
--

CREATE TABLE `t_stock` (
  `stock_id` int(11) NOT NULL,
  `doc_id` varchar(255) DEFAULT NULL,
  `item_code` varchar(255) DEFAULT NULL,
  `whs_code` varchar(255) DEFAULT NULL,
  `docnum` int(11) DEFAULT NULL,
  `item_id` int(11) NOT NULL,
  `item_id_detail` int(11) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `type` enum('in','out') NOT NULL,
  `detail` varchar(200) NOT NULL,
  `info` varchar(255) DEFAULT NULL,
  `docnum_transfer` varchar(255) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `qty` int(10) NOT NULL,
  `expired_date` date DEFAULT NULL,
  `date` date NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `id_item_produksi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `t_toko`
--

CREATE TABLE `t_toko` (
  `id` int(11) NOT NULL,
  `kode_seller` varchar(50) DEFAULT NULL,
  `kode_area` varchar(50) DEFAULT NULL,
  `store_id` varchar(100) DEFAULT NULL,
  `code_store` varchar(4) DEFAULT NULL,
  `series_name` varchar(255) DEFAULT NULL,
  `whs_code` varchar(255) DEFAULT NULL,
  `nama_toko` varchar(100) NOT NULL,
  `toko_cabang` varchar(200) NOT NULL,
  `alamat_toko` text NOT NULL,
  `is_active` varchar(10) DEFAULT 'n',
  `created` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_toko`
--

INSERT INTO `t_toko` (`id`, `kode_seller`, `kode_area`, `store_id`, `code_store`, `series_name`, `whs_code`, `nama_toko`, `toko_cabang`, `alamat_toko`, `is_active`, `created`, `created_by`, `updated`, `updated_by`) VALUES
(5, 'FA', 'JKT', NULL, 'FA23', NULL, 'WH06.07', 'MALL KELAPA GADING', 'MALL KELAPA GADING', 'MALL KELAPA GADING\r\n', 'y', NULL, NULL, '2023-01-14 13:38:46', '1');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(200) DEFAULT NULL,
  `level` int(1) NOT NULL COMMENT '1:admin, 2:kasir'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `name`, `address`, `level`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Admin Toko', 'Pati', 1),
(2, 'kasir1', '8cfab3d2724448440ea03b9cfa0194cb962a7723', 'Lina', 'Jakarta', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `master_gudang`
--
ALTER TABLE `master_gudang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p_category`
--
ALTER TABLE `p_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `p_item`
--
ALTER TABLE `p_item`
  ADD PRIMARY KEY (`item_id`),
  ADD UNIQUE KEY `barcode` (`barcode`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `unit_id` (`unit_id`);

--
-- Indexes for table `p_item_detail`
--
ALTER TABLE `p_item_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p_item_produksi`
--
ALTER TABLE `p_item_produksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p_unit`
--
ALTER TABLE `p_unit`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `tax`
--
ALTER TABLE `tax`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_event`
--
ALTER TABLE `tb_event`
  ADD PRIMARY KEY (`id_event`);

--
-- Indexes for table `tb_item_bonus`
--
ALTER TABLE `tb_item_bonus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_item_produksi`
--
ALTER TABLE `tb_item_produksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_item_produksi_detail`
--
ALTER TABLE `tb_item_produksi_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_printer`
--
ALTER TABLE `tb_printer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_stock_order`
--
ALTER TABLE `tb_stock_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_transfer_stock`
--
ALTER TABLE `tb_transfer_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_transfer_stock_detail`
--
ALTER TABLE `tb_transfer_stock_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `type_bayar`
--
ALTER TABLE `type_bayar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_cart`
--
ALTER TABLE `t_cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `t_cart_produksi`
--
ALTER TABLE `t_cart_produksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_cart_stockout`
--
ALTER TABLE `t_cart_stockout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_cart_suggest_order`
--
ALTER TABLE `t_cart_suggest_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_cart_transfer_stockout`
--
ALTER TABLE `t_cart_transfer_stockout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_header_stock`
--
ALTER TABLE `t_header_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_sale`
--
ALTER TABLE `t_sale`
  ADD PRIMARY KEY (`sale_id`);

--
-- Indexes for table `t_sale_detail`
--
ALTER TABLE `t_sale_detail`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `t_stock`
--
ALTER TABLE `t_stock`
  ADD PRIMARY KEY (`stock_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `t_toko`
--
ALTER TABLE `t_toko`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `master_gudang`
--
ALTER TABLE `master_gudang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `p_category`
--
ALTER TABLE `p_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `p_item`
--
ALTER TABLE `p_item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4695;
--
-- AUTO_INCREMENT for table `p_item_detail`
--
ALTER TABLE `p_item_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5351;
--
-- AUTO_INCREMENT for table `p_item_produksi`
--
ALTER TABLE `p_item_produksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `p_unit`
--
ALTER TABLE `p_unit`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tax`
--
ALTER TABLE `tax`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tb_event`
--
ALTER TABLE `tb_event`
  MODIFY `id_event` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tb_item_bonus`
--
ALTER TABLE `tb_item_bonus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tb_item_produksi`
--
ALTER TABLE `tb_item_produksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tb_item_produksi_detail`
--
ALTER TABLE `tb_item_produksi_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tb_printer`
--
ALTER TABLE `tb_printer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tb_stock_order`
--
ALTER TABLE `tb_stock_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT for table `tb_transfer_stock`
--
ALTER TABLE `tb_transfer_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tb_transfer_stock_detail`
--
ALTER TABLE `tb_transfer_stock_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `type_bayar`
--
ALTER TABLE `type_bayar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `t_cart_produksi`
--
ALTER TABLE `t_cart_produksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_cart_stockout`
--
ALTER TABLE `t_cart_stockout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_cart_suggest_order`
--
ALTER TABLE `t_cart_suggest_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `t_cart_transfer_stockout`
--
ALTER TABLE `t_cart_transfer_stockout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_header_stock`
--
ALTER TABLE `t_header_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `t_sale`
--
ALTER TABLE `t_sale`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
--
-- AUTO_INCREMENT for table `t_sale_detail`
--
ALTER TABLE `t_sale_detail`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;
--
-- AUTO_INCREMENT for table `t_stock`
--
ALTER TABLE `t_stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_toko`
--
ALTER TABLE `t_toko`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `p_item`
--
ALTER TABLE `p_item`
  ADD CONSTRAINT `p_item_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `p_category` (`category_id`),
  ADD CONSTRAINT `p_item_ibfk_2` FOREIGN KEY (`unit_id`) REFERENCES `p_unit` (`unit_id`);

--
-- Constraints for table `t_cart`
--
ALTER TABLE `t_cart`
  ADD CONSTRAINT `t_cart_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `p_item` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_cart_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_sale_detail`
--
ALTER TABLE `t_sale_detail`
  ADD CONSTRAINT `t_sale_detail_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `p_item` (`item_id`);

--
-- Constraints for table `t_stock`
--
ALTER TABLE `t_stock`
  ADD CONSTRAINT `t_stock_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `p_item` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_stock_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`),
  ADD CONSTRAINT `t_stock_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
