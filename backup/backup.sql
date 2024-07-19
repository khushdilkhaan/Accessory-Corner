/*
SQLyog Ultimate v10.00 Beta1
MySQL - 5.5.5-10.4.11-MariaDB : Database - accessorycorner
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`accessorycorner` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `accessorycorner`;

/*Table structure for table `cart` */

DROP TABLE IF EXISTS `cart`;

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_image` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_price` decimal(10,2) DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`cart_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `cart` */

insert  into `cart`(`cart_id`,`customer_id`,`product_id`,`quantity`,`product_image`,`product_name`,`product_price`,`description`) values (14,3,4,1,'1-removebg-preview.png','makeup product','900.00','beauty product for facial.'),(15,3,2,4,'pexels-madebymath-90946.jpg','DSLR Camera','3000.00','it is a very usefull Camera product.'),(17,1,4,1,'1-removebg-preview.png','makeup product','900.00','beauty product for facial.'),(18,1,7,2,'donuts.jpg','bakery product','800.00','very sweet and delicious'),(19,1,4,1,'1-removebg-preview.png','makeup product','900.00','beauty product for facial.');

/*Table structure for table `customers` */

DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `profile_image` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` enum('admin','customer') COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `customers` */

insert  into `customers`(`id`,`username`,`contact`,`address`,`profile_image`,`email`,`password`,`role`) values (1,'dummy name','746577463','mingora','istockphoto-954699820-612x612-removebg-preview.png','dumy1@gmail.com','1122','customer'),(2,'admin site','9876545678','namaloma','istockphoto-1309328823-1024x1024.jpg','dummyadmin@gmail.com','1212','admin'),(3,'First User','938464738','peshawar','Professional CV Resume (3).jpg','user11@gmail.com','321','customer'),(4,'kinzakhan','8765456789','mingora','profile_images/pexels-javon-swaby-197616-2783873.jpg','kinzakhan600@gmail.com','2233','customer'),(5,'random person','9738468663','random','profile_images/cake.jpg','randomperson@gmail.com','12345','customer');

/*Table structure for table `orders` */

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customer_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customer_contact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customer_address` text COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `product_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('rejected','pending','accepted') COLLATE utf8_unicode_ci DEFAULT 'pending',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `orders` */

insert  into `orders`(`order_id`,`customer_id`,`product_id`,`product_name`,`customer_name`,`customer_contact`,`customer_address`,`quantity`,`total_price`,`product_image`,`order_date`,`status`) values (6,3,5,'Harding Bennett','Marah Reid','575','Qui nihil est volupt',1,'19.00','pexels-harper-sunday-2866796.jpg','2024-07-06 12:27:26','rejected'),(7,3,5,'Harding Bennett','Dahlia Wilkerson','58','Omnis consequatur N',3,'57.00','pexels-harper-sunday-2866796.jpg','2024-07-06 12:27:31','rejected'),(8,3,5,'Harding Bennett','Rooney Pickett','902','Expedita minima eos',1,'19.00','pexels-harper-sunday-2866796.jpg','2024-07-06 12:27:33','accepted'),(9,3,5,'Harding Bennett','Marshall Guerrero','592','Fugiat dolore recusa',1,'19.00','pexels-harper-sunday-2866796.jpg','2024-05-29 14:36:46','accepted'),(10,3,5,'Harding Bennett','Marshall Guerrero','592','Fugiat dolore recusa',2,'38.00','pexels-harper-sunday-2866796.jpg','2024-05-29 14:36:35','accepted'),(11,1,7,'bakery product','random order','873468634','random address',3,'2400.00','donuts.jpg','0000-00-00 00:00:00','pending');

/*Table structure for table `products` */

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_quantity` int(11) NOT NULL,
  `product_price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `products` */

insert  into `products`(`product_id`,`product_name`,`description`,`product_image`,`product_quantity`,`product_price`) values (2,'DSLR Camera','it is a very usefull Camera product.','pexels-madebymath-90946.jpg',44,'3000.00'),(4,'makeup product','beauty product for facial.','1-removebg-preview.png',90,'900.00'),(7,'bakery product','very sweet and delicious','donuts.jpg',27,'800.00');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
