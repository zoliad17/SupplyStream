-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2024 at 12:26 AM
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
-- Database: `supplysystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `Category_Id` int(11) NOT NULL,
  `Category_Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`Category_Id`, `Category_Name`) VALUES
(7, 'Apparel'),
(8, 'Electronics'),
(9, 'Food');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `Inventory_Id` int(11) NOT NULL,
  `Product_Id` int(11) DEFAULT NULL,
  `Category_Id` int(11) NOT NULL,
  `Supplier_Id` int(11) DEFAULT NULL,
  `Last_Added_Stock` int(11) DEFAULT NULL,
  `Total_Stock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`Inventory_Id`, `Product_Id`, `Category_Id`, `Supplier_Id`, `Last_Added_Stock`, `Total_Stock`) VALUES
(23, 10, 8, 6, 11, 13),
(24, 11, 7, 7, 11, 11),
(25, 12, 7, 4, 11, 12);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `Product_Id` int(11) NOT NULL,
  `Product_Name` varchar(255) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Image_Url` varchar(255) NOT NULL,
  `Category_Id` int(11) DEFAULT NULL,
  `Supplier_Id` int(11) DEFAULT NULL,
  `Date_Added` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`Product_Id`, `Product_Name`, `Price`, `Image_Url`, `Category_Id`, `Supplier_Id`, `Date_Added`) VALUES
(10, 'Iphone 15 ', 60000.00, 'The-iPhone-15-Pro-Max-will-have-better-specs-than-the-iPhone-15-Pro.jpg', 8, 6, '2024-06-12'),
(11, 'Adidas Stan Smith', 60000.00, 'stan-smith.jpg', 8, 7, '2024-06-13'),
(13, 'Huawei Pura Pro (CP01)', 8000.00, 'Huawei_Pura_70_Pro_.jpg', 8, 8, '2024-06-13');

-- --------------------------------------------------------

--
-- Table structure for table `reqdelivery`
--

CREATE TABLE `reqdelivery` (
  `Order_Id` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Product_Id` int(11) NOT NULL,
  `Supplier_Id` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Date_Req` date NOT NULL,
  `Date_Approve` date DEFAULT NULL,
  `Reason_Decline` varchar(255) DEFAULT NULL,
  `Address` varchar(255) NOT NULL,
  `Contact_Number` int(11) NOT NULL,
  `Status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reqdelivery`
--

INSERT INTO `reqdelivery` (`Order_Id`, `Username`, `Product_Id`, `Supplier_Id`, `Quantity`, `Date_Req`, `Date_Approve`, `Reason_Decline`, `Address`, `Contact_Number`, `Status`) VALUES
(118, 'Test', 10, 6, 11, '2024-06-14', NULL, 'test test', '', 0, 'Declined');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `Supplier_Id` int(11) NOT NULL,
  `Supplier_Name` varchar(255) NOT NULL,
  `Category_Id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`Supplier_Id`, `Supplier_Name`, `Category_Id`) VALUES
(4, 'Nike', 7),
(6, 'Apple', 8),
(7, 'Adidas', 7),
(8, 'Huawei', 8);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Email Address` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `Username`, `Email Address`, `Password`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$qSyjrZzrhUNtdKNynnY94uhHw99V7jdLjuxkHCePT.ApTnbwQTkJa'),
(2, 'test', 'test@gmail.com', '$2y$10$y/PdP0zdJ7TkbK/Eee75deCel49UMI0nX9h5x1wrzkeHFVDKt24Xq'),
(3, 'bantugan', 'bantugan@gmail.com', '$2y$10$Cm0eZdWYfd2lI7CuJgc.eeeYpsuJWYLdoLJgfA6DDH6T/nTd6KoQS'),
(4, 'test123', 'test@gmail.com', '$2y$10$O.UgB97MmylwvNqfdhmdieo3Z5OWL1YEe4dFnPIt0Xf6ID9inqkui');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`Category_Id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`Inventory_Id`),
  ADD KEY `inventory_ibfk_1` (`Supplier_Id`),
  ADD KEY `inventory_ibfk_2` (`Category_Id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`Product_Id`),
  ADD KEY `product_ibfk_2` (`Category_Id`),
  ADD KEY `product_fk_supplierId` (`Supplier_Id`);

--
-- Indexes for table `reqdelivery`
--
ALTER TABLE `reqdelivery`
  ADD PRIMARY KEY (`Order_Id`),
  ADD KEY `fk_productId` (`Product_Id`),
  ADD KEY `fk_supplierID` (`Supplier_Id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`Supplier_Id`),
  ADD KEY `fk_supplier_category` (`Category_Id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `Category_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `Inventory_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `Product_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `reqdelivery`
--
ALTER TABLE `reqdelivery`
  MODIFY `Order_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `Supplier_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`Supplier_Id`) REFERENCES `supplier` (`Supplier_Id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`Category_Id`) REFERENCES `category` (`Category_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_fk_supplierId` FOREIGN KEY (`Supplier_Id`) REFERENCES `supplier` (`Supplier_Id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`Category_Id`) REFERENCES `category` (`Category_Id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `supplier`
--
ALTER TABLE `supplier`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`Category_Id`) REFERENCES `category` (`Category_Id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_supplier_category` FOREIGN KEY (`Category_Id`) REFERENCES `category` (`Category_Id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
