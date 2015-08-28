-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 12, 2015 at 12:29 PM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rg_auction`
--

-- --------------------------------------------------------

--
-- Table structure for table `auctions`
--

CREATE TABLE IF NOT EXISTS `auctions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL,
  `start_date` datetime NOT NULL,
  `duration` int(11) NOT NULL COMMENT 'in minutes',
  `amount` double NOT NULL DEFAULT '0',
  `company` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `priority` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `company` (`company`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `auctions_criteria`
--

CREATE TABLE IF NOT EXISTS `auctions_criteria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auction` int(11) NOT NULL,
  `security` double NOT NULL DEFAULT '0' COMMENT 'security deposit in rs. ',
  `is_percent` tinyint(4) NOT NULL COMMENT '0=:fixed cost,1=:percentage cost',
  `create_date` datetime NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bid` (`auction`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `auction_preference`
--

CREATE TABLE IF NOT EXISTS `auction_preference` (
  `auction` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `brand` int(11) DEFAULT NULL,
  KEY `auction` (`auction`,`category`,`brand`),
  KEY `category` (`category`),
  KEY `brand` (`brand`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bids_term`
--

CREATE TABLE IF NOT EXISTS `bids_term` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `max_bid` int(11) NOT NULL,
  `cooling_prd` int(11) NOT NULL COMMENT 'cooling period',
  `last_min_extd` int(11) NOT NULL COMMENT 'last minute extention',
  `max_extd` int(11) NOT NULL COMMENT 'max extention',
  `auction` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bid` (`auction`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE IF NOT EXISTS `brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `create_date` datetime NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE IF NOT EXISTS `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `domain` varchar(255) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `description` text,
  `image` varchar(255) NOT NULL COMMENT 'logo image',
  `is_active` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `company_users`
--

CREATE TABLE IF NOT EXISTS `company_users` (
  `company` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  KEY `company` (`company`),
  KEY `user` (`user`),
  KEY `company_2` (`company`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dealers`
--

CREATE TABLE IF NOT EXISTS `dealers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `auth_key` varchar(50) DEFAULT NULL,
  `user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dealer_auctions`
--

CREATE TABLE IF NOT EXISTS `dealer_auctions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dealer` int(11) NOT NULL,
  `auction` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `status` int(11) NOT NULL,
  `amount` double DEFAULT '0' COMMENT 'bid amount',
  PRIMARY KEY (`id`),
  KEY `dealer` (`dealer`,`auction`),
  KEY `auction` (`auction`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dealer_company`
--

CREATE TABLE IF NOT EXISTS `dealer_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dealer` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `aprv_date` datetime DEFAULT NULL COMMENT 'approve date',
  `aprv_by` int(11) DEFAULT NULL COMMENT 'approve by',
  `status` int(11) NOT NULL DEFAULT '0',
  `is_active` tinyint(4) NOT NULL,
  `mode` int(11) NOT NULL COMMENT '1:-auto approve,2:-approval required',
  PRIMARY KEY (`id`),
  KEY `dealer_id` (`dealer`),
  KEY `company_id` (`company`),
  KEY `approve_by` (`aprv_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dealer_company_preferences`
--

CREATE TABLE IF NOT EXISTS `dealer_company_preferences` (
  `dc_id` int(11) NOT NULL,
  `brand` int(11) DEFAULT NULL,
  `category` int(11) NOT NULL,
  KEY `dc_id` (`dc_id`,`brand`),
  KEY `brand` (`brand`),
  KEY `category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dealer_preference`
--

CREATE TABLE IF NOT EXISTS `dealer_preference` (
  `dealer` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `brand` int(11) NOT NULL,
  KEY `dealer` (`dealer`),
  KEY `category` (`category`),
  KEY `brand` (`brand`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dealer_security`
--

CREATE TABLE IF NOT EXISTS `dealer_security` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `security` double NOT NULL DEFAULT '0',
  `dealer` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dealer` (`dealer`),
  KEY `dealer_2` (`dealer`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dealer_security_consume`
--

CREATE TABLE IF NOT EXISTS `dealer_security_consume` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `security` int(11) NOT NULL COMMENT 'dealer security id',
  `auction` int(11) NOT NULL,
  `amount` double NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '0:-acquire, 1:-used, 2:-free',
  PRIMARY KEY (`id`),
  KEY `dealer_security` (`security`,`auction`),
  KEY `auction` (`auction`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `forgot_password_history`
--

CREATE TABLE IF NOT EXISTS `forgot_password_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `token` varchar(255) NOT NULL COMMENT 'for email',
  `mode` tinyint(4) NOT NULL COMMENT '0=:opt,1=:token',
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `valid_till` datetime NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lots`
--

CREATE TABLE IF NOT EXISTS `lots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `auction` int(11) NOT NULL,
  `condition` varchar(255) NOT NULL,
  `lot_size` int(11) NOT NULL,
  `is_quantity` tinyint(4) NOT NULL COMMENT '0=:in amount,1=:in quantity',
  PRIMARY KEY (`id`),
  KEY `auction` (`auction`),
  KEY `auction_2` (`auction`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lot_preference`
--

CREATE TABLE IF NOT EXISTS `lot_preference` (
  `lots` int(11) NOT NULL,
  `brand` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  KEY `lots` (`lots`,`brand`,`category`),
  KEY `lots_2` (`lots`),
  KEY `brand` (`brand`),
  KEY `category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payment_history`
--

CREATE TABLE IF NOT EXISTS `payment_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `companyId` varchar(32) NOT NULL,
  `paymentId` varchar(255) NOT NULL,
  `paymentStatus` varchar(255) NOT NULL,
  `dateTime` datetime NOT NULL,
  `paymentMode` varchar(20) NOT NULL,
  `paymentReference` varchar(20) NOT NULL,
  `paidBy` varchar(32) NOT NULL,
  `description` varchar(5000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `brand` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `lot` int(11) NOT NULL,
  `prize` double NOT NULL,
  `condition` varchar(255) NOT NULL,
  `extra_condition` varchar(255) NOT NULL COMMENT 'like bluetooth not working.',
  PRIMARY KEY (`id`),
  KEY `brand` (`brand`,`category`),
  KEY `category` (`category`),
  KEY `lot` (`lot`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `txn_id` int(11) NOT NULL AUTO_INCREMENT,
  `entered_by_user` varchar(50) NOT NULL,
  `txn_amount` double(10,3) NOT NULL,
  `txn_is_debit` tinyint(1) NOT NULL,
  `txn_date` datetime NOT NULL,
  `paymentMode` varchar(20) NOT NULL,
  `txn_desc` varchar(100) DEFAULT NULL,
  `visibility` bit(1) NOT NULL,
  PRIMARY KEY (`txn_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=249 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login_name` varchar(255) NOT NULL COMMENT 'unique value for login',
  `password` varchar(255) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_login_ip` varchar(15) DEFAULT NULL,
  `user_role` int(11) NOT NULL COMMENT '1:-company user, 2:-dealer user',
  `is_active` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auctions`
--
ALTER TABLE `auctions`
  ADD CONSTRAINT `auctions_ibfk_1` FOREIGN KEY (`company`) REFERENCES `companies` (`id`);

--
-- Constraints for table `auctions_criteria`
--
ALTER TABLE `auctions_criteria`
  ADD CONSTRAINT `auctions_criteria_ibfk_1` FOREIGN KEY (`auction`) REFERENCES `auctions` (`id`);

--
-- Constraints for table `auction_preference`
--
ALTER TABLE `auction_preference`
  ADD CONSTRAINT `auction_preference_ibfk_1` FOREIGN KEY (`auction`) REFERENCES `auctions` (`id`),
  ADD CONSTRAINT `auction_preference_ibfk_2` FOREIGN KEY (`category`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `auction_preference_ibfk_3` FOREIGN KEY (`brand`) REFERENCES `brands` (`id`);

--
-- Constraints for table `bids_term`
--
ALTER TABLE `bids_term`
  ADD CONSTRAINT `bids_term_ibfk_1` FOREIGN KEY (`auction`) REFERENCES `auctions` (`id`);

--
-- Constraints for table `company_users`
--
ALTER TABLE `company_users`
  ADD CONSTRAINT `company_users_ibfk_2` FOREIGN KEY (`user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `company_users_ibfk_3` FOREIGN KEY (`company`) REFERENCES `companies` (`id`);

--
-- Constraints for table `dealers`
--
ALTER TABLE `dealers`
  ADD CONSTRAINT `dealers_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Constraints for table `dealer_auctions`
--
ALTER TABLE `dealer_auctions`
  ADD CONSTRAINT `dealer_auctions_ibfk_1` FOREIGN KEY (`dealer`) REFERENCES `dealers` (`id`),
  ADD CONSTRAINT `dealer_auctions_ibfk_2` FOREIGN KEY (`auction`) REFERENCES `auctions` (`id`);

--
-- Constraints for table `dealer_company`
--
ALTER TABLE `dealer_company`
  ADD CONSTRAINT `dealer_company_ibfk_1` FOREIGN KEY (`dealer`) REFERENCES `dealers` (`id`),
  ADD CONSTRAINT `dealer_company_ibfk_2` FOREIGN KEY (`company`) REFERENCES `companies` (`id`);

--
-- Constraints for table `dealer_company_preferences`
--
ALTER TABLE `dealer_company_preferences`
  ADD CONSTRAINT `dealer_company_preferences_ibfk_1` FOREIGN KEY (`dc_id`) REFERENCES `dealer_company` (`id`),
  ADD CONSTRAINT `dealer_company_preferences_ibfk_2` FOREIGN KEY (`brand`) REFERENCES `brands` (`id`),
  ADD CONSTRAINT `dealer_company_preferences_ibfk_3` FOREIGN KEY (`category`) REFERENCES `categories` (`id`);

--
-- Constraints for table `dealer_preference`
--
ALTER TABLE `dealer_preference`
  ADD CONSTRAINT `dealer_preference_ibfk_1` FOREIGN KEY (`dealer`) REFERENCES `dealers` (`id`),
  ADD CONSTRAINT `dealer_preference_ibfk_2` FOREIGN KEY (`category`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `dealer_preference_ibfk_3` FOREIGN KEY (`brand`) REFERENCES `brands` (`id`);

--
-- Constraints for table `dealer_security`
--
ALTER TABLE `dealer_security`
  ADD CONSTRAINT `dealer_security_ibfk_1` FOREIGN KEY (`dealer`) REFERENCES `dealers` (`id`);

--
-- Constraints for table `dealer_security_consume`
--
ALTER TABLE `dealer_security_consume`
  ADD CONSTRAINT `dealer_security_consume_ibfk_1` FOREIGN KEY (`security`) REFERENCES `dealer_security` (`id`),
  ADD CONSTRAINT `dealer_security_consume_ibfk_2` FOREIGN KEY (`auction`) REFERENCES `auctions` (`id`);

--
-- Constraints for table `forgot_password_history`
--
ALTER TABLE `forgot_password_history`
  ADD CONSTRAINT `forgot_password_history_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Constraints for table `lots`
--
ALTER TABLE `lots`
  ADD CONSTRAINT `lots_ibfk_1` FOREIGN KEY (`auction`) REFERENCES `auctions` (`id`);

--
-- Constraints for table `lot_preference`
--
ALTER TABLE `lot_preference`
  ADD CONSTRAINT `lot_preference_ibfk_1` FOREIGN KEY (`lots`) REFERENCES `lots` (`id`),
  ADD CONSTRAINT `lot_preference_ibfk_2` FOREIGN KEY (`brand`) REFERENCES `brands` (`id`),
  ADD CONSTRAINT `lot_preference_ibfk_3` FOREIGN KEY (`category`) REFERENCES `categories` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`brand`) REFERENCES `brands` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`category`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_ibfk_3` FOREIGN KEY (`lot`) REFERENCES `lots` (`id`);
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
