-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2023 at 05:15 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `login_sample_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `menuitems` (
  `id` int(5) PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `category` varchar(100) NOT NULL,
  `price` int(5) NOT NULL,
  `pickupOnly` boolean NOT NULL,
  `imageLink` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `menuitems` (`id`, `name`, `category`, `price`, `pickupOnly`, `imageLink`) VALUES
(1, 'Cabonara', 'Pastas', 23, 'false','https://img.jamieoliver.com/jamieoliver/recipe-database/oldImages/large/1558_1_1436795948.jpg?tr=w-800,h-1066'),
(2, 'Marghereita', 'Pizzas', 25, 'true','https://upload.wikimedia.org/wikipedia/commons/thumb/c/c8/Pizza_Margherita_stu_spivack.jpg/330px-Pizza_Margherita_stu_spivack.jpg'),
(3, 'Marghereita with olives', 'Pizzas', 28, 'true','https://upload.wikimedia.org/wikipedia/commons/thumb/c/c8/Pizza_Margherita_stu_spivack.jpg/330px-Pizza_Margherita_stu_spivack.jpg'),
(4, 'Meatlovers', 'Pizzas', 27, 'true','https://www.vincenzosplate.com/wp-content/uploads/2021/08/610x350-Photo-5_863-How-to-Make-MEATLOVERS-PIZZA-Like-an-Italian-V1.jpg'),
(5, 'Garlic Bread', 'Entrees', 12, 'false', 'https://www.ambitiouskitchen.com/wp-content/uploads/2023/02/Garlic-Bread-4-750x750.jpg'),
(6, 'Italian Bruschetta', 'Entrees', 17, 'true', 'https://i0.wp.com/palatablepastime.com/wp-content/uploads/2021/10/Italian-Bruschetta-og.jpg?resize=768%2C401&ssl=1'),
(7, 'Autumn Fritto Misto', 'Entrees', 19, 'true', 'https://hips.hearstapps.com/del.h-cdn.co/assets/cm/15/10/54f6a5428bebf_-_autumn-fritto-misto-recipe-fw1010-xl-xl.jpg?resize=980:*');

CREATE TABLE `events` (
  `eventID` bigint(20) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `organiserID` bigint(20) NOT NULL,
  `name` VARCHAR(180) NOT NULL,
  `numAtendees` bigint(20) NOT NULL,
  `date` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'submitted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `specialRequests` (
  `specialRequestsID` bigint(20) PRIMARY KEY AUTO_INCREMENT, 
  `veganOptions` varchar(100),
  `specialCake` varchar(100),
  `largeTable` varchar(100),
  `tablesOutside` boolean,
  `kidsMeals` boolean,
  `exLargePizzas` boolean,
  `playSong` varchar(100),
  `eventID` bigint(20)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--

ALTER TABLE `events`
  MODIFY `eventID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

ALTER TABLE `specialRequests`
  MODIFY `specialRequestsID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

ALTER TABLE `specialRequests`
    ADD CONSTRAINT `specialRequestsFK`
    FOREIGN KEY (`eventID`)
    REFERENCES `events`(`eventID`);
    
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL, -- If you have user information
    menu_item_id INT NOT NULL,
    order_date DATETIME NOT NULL,
    quantity INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (menu_item_id) REFERENCES menuitems(id)
);

INSERT INTO orders (user_id, menu_item_id, order_date, quantity, total_price)
VALUES
    (1, 1, '2023-05-18 12:30:00', 2, 46.00),
    (2, 2, '2023-05-18 13:15:00', 1, 25.00),
    (3, 4, '2023-05-18 14:00:00', 3, 81.00)
    -- Add more sample orders as needed
;



SELECT
    menuitems.id AS menu_item_id,
    menuitems.name AS menu_item_name,
    DATE(orders.order_date) AS order_day,
    SUM(orders.quantity) AS total_quantity,
    SUM(orders.total_price) AS total_revenue
FROM
    orders
JOIN
    menuitems ON orders.menu_item_id = menuitems.id
WHERE
    DATE(orders.order_date) = '2023-05-18' -- Replace with the desired date
GROUP BY
    menu_item_id, menu_item_name, order_day
ORDER BY
    order_day;
