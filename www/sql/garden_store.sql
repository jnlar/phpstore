-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 20, 2021 at 06:50 PM
-- Server version: 10.3.29-MariaDB-0ubuntu0.20.04.1
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `garden_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `forum_categories`
--

CREATE TABLE `forum_categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `forum_categories`
--

INSERT INTO `forum_categories` (`category_id`, `category_name`) VALUES
(1, 'General'),
(2, 'Product Reviews'),
(3, 'Gardening Tips');

-- --------------------------------------------------------

--
-- Table structure for table `forum_posts`
--

CREATE TABLE `forum_posts` (
  `post_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `post_text` text DEFAULT NULL,
  `post_create_time` datetime DEFAULT NULL,
  `post_owner` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `forum_posts`
--

INSERT INTO `forum_posts` (`post_id`, `topic_id`, `category_id`, `post_text`, `post_create_time`, `post_owner`) VALUES
(1, 1, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer molestie lobortis bibendum. In hac habitasse platea dictumst. Curabitur maximus sagittis odio, nec tempor purus. Phasellus consectetur nulla a dui lacinia condimentum. Etiam et consequat velit. Aliquam scelerisque, tortor vitae elementum fermentum, nulla lacus venenatis lectus, at ultrices nunc nisl interdum velit. Nullam elementum quam sit amet dui dignissim placerat. Mauris mollis tincidunt porta. ', '2021-05-01 17:45:44', 'jane@mail.com'),
(2, 1, 1, ' Pellentesque gravida ipsum non molestie fringilla. Etiam eget lorem nec nisl lobortis volutpat. Sed congue at sem id sodales. Phasellus et ornare diam, eget blandit velit. Donec ultrices ante sit amet turpis lobortis, tincidunt cursus erat cursus. Ut hendrerit metus quis est faucibus scelerisque. Nullam bibendum vehicula nulla, vitae viverra orci sodales et. Aenean iaculis ligula ipsum, eget vestibulum ex pulvinar sed. Suspendisse aliquam sapien volutpat lacus fringilla lacinia. Vestibulum tincidunt elementum orci sit amet lacinia. ', '2021-05-01 17:47:18', 'bob@mail.com'),
(3, 2, 2, 'I cannot use the shovel, can someone get a robot to do it for me?', '2021-05-01 18:08:44', 'sad@customer.com'),
(4, 2, 2, 'no', '2021-05-01 21:42:49', 'other@person.me'),
(5, 3, 3, 'Consectetur ducimus suscipit eveniet saepe optio! Quas nam voluptatum sit at non! Cum culpa nam impedit maiores dolore, fugiat Eum officia quae reprehenderit obcaecati ipsam. Molestiae magni incidunt aspernatur magnam', '2021-05-13 16:27:36', 'jane@doe.org'),
(6, 4, 3, 'Praesent ut mauris sit amet nisl finibus gravida vel et dui. Nulla ullamcorper sem lorem, vel varius eros cursus nec. Cras non finibus ipsum. Integer nec nunc rhoncus, porttitor mauris a, posuere felis. Fusce at volutpat dui. Ut auctor erat id rhoncus pretium. Sed lacinia mi risus, sed pellentesque magna luctus quis. Vestibulum molestie ultrices mi ut faucibus. Donec vitae venenatis leo. Praesent tristique, velit vel sodales dictum, nulla leo ullamcorper leo, eu sagittis quam arcu ut eros. Donec libero mi, sodales ut accumsan sed, egestas vitae justo. Proin consequat semper tortor, eu mollis ante tristique a. Mauris et efficitur risus.', '2021-05-18 09:26:31', 'loves@gardening.xyz'),
(7, 4, 3, 'Nulla pulvinar eleifend commodo. Morbi dapibus, massa id consequat interdum, tellus quam suscipit erat, non aliquam justo quam eu arcu. Nulla vestibulum bibendum efficitur. Vestibulum vestibulum metus in ex imperdiet porta. Etiam sit amet lacus elit. Curabitur nec odio a ex dignissim dapibus non sit amet dolor. Sed efficitur luctus ex in pellentesque. Aliquam sodales rutrum arcu in scelerisque.', '2021-05-18 09:27:27', 'also.loves@gardening.pots'),
(8, 4, 3, 'Curabitur lobortis ornare metus. In auctor eu mi vitae bibendum. Duis sollicitudin finibus quam sagittis auctor. Nulla facilisi. Ut bibendum neque bibendum ipsum sollicitudin, sed sagittis eros rutrum. Curabitur quis lectus neque. Donec scelerisque ante vitae massa sagittis placerat. Morbi efficitur, erat eget lacinia dapibus, nisl purus accumsan ante, ut sollicitudin est urna ac augue!', '2021-05-18 09:28:02', 'sometimes.loves@gardening.org'),
(9, 5, 1, 'Nulla facilisi. Vivamus non elementum sapien, ac dignissim risus. Aliquam tempus et ante ut mollis. Cras tortor felis, tincidunt lobortis placerat non, ornare id quam. Etiam elementum, sem nec ornare condimentum, tortor nisi ultricies nibh, ac luctus velit elit quis nibh. Nullam in tristique sem, in commodo ipsum. Donec lobortis gravida velit, a tristique nulla bibendum non. Nulla dictum odio sit amet nisl iaculis aliquet. Fusce ac maximus felis. Donec rutrum est lorem, eget dignissim urna porta eget. Integer vitae ipsum in nibh consequat sodales at eu mi. Donec massa lorem, luctus et vehicula a, lacinia dignissim augue. Phasellus ullamcorper facilisis libero, non eleifend metus volutpat nec!', '2021-05-18 09:31:04', 'jane@doe.org');

-- --------------------------------------------------------

--
-- Table structure for table `forum_topics`
--

CREATE TABLE `forum_topics` (
  `topic_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `topic_title` varchar(150) DEFAULT NULL,
  `topic_create_time` datetime DEFAULT NULL,
  `topic_owner` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `forum_topics`
--

INSERT INTO `forum_topics` (`topic_id`, `category_id`, `topic_title`, `topic_create_time`, `topic_owner`) VALUES
(1, 1, 'Come say hi!', '2021-05-01 17:45:44', 'jane@mail.com'),
(2, 2, 'Those shovels suck', '2021-05-01 18:08:44', 'sad@customer.com'),
(3, 3, 'Breaking top soil - A guide to a healthy garden bed', '2021-05-13 16:27:36', 'jane@doe.org'),
(4, 3, 'Summer gardening - Taking care of your budding plants', '2021-05-18 09:26:31', 'loves@gardening.xyz'),
(5, 1, 'We are hiring!', '2021-05-18 09:31:04', 'jane@doe.org');

-- --------------------------------------------------------

--
-- Table structure for table `store_categories`
--

CREATE TABLE `store_categories` (
  `id` int(11) NOT NULL,
  `cat_title` varchar(15) DEFAULT NULL,
  `cat_desc` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `store_categories`
--

INSERT INTO `store_categories` (`id`, `cat_title`, `cat_desc`) VALUES
(1, 'Tools', 'The gardening tools you need!'),
(2, 'Seeds', 'Our assortment of vegetable, flower and herb seeds.'),
(3, 'Soils', 'Compost, manure & top soils');

-- --------------------------------------------------------

--
-- Table structure for table `store_items`
--

CREATE TABLE `store_items` (
  `id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `item_title` varchar(75) DEFAULT NULL,
  `item_price` float(8,2) DEFAULT NULL,
  `item_desc` varchar(150) DEFAULT NULL,
  `item_stock` smallint(6) DEFAULT NULL,
  `item_image` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `store_items`
--

INSERT INTO `store_items` (`id`, `cat_id`, `item_title`, `item_price`, `item_desc`, `item_stock`, `item_image`) VALUES
(1, 1, 'Square Shovel', 35.00, 'Designed for digging in hard-packed soils', 8, 'shovel.png'),
(2, 1, 'Garden Fork', 15.00, 'Used for breaking up, lifting and turning over soil.', 5, 'fork.png'),
(3, 1, 'Hoe', 35.00, 'Used for cultivating soil, removing weeds and breaking up clumped soil.', 6, 'hoe.png'),
(4, 2, 'Sunflower Seeds', 4.95, 'Blooms multiple heads with bi-colour petals', 4, 'sunflower.png'),
(5, 2, 'Garlic Seeds', 4.95, 'Garlic chives have a mild flavor and are fantastic in salads!', 9, 'garlic.png'),
(6, 2, 'Strawberry Seeds', 4.95, 'Fruits within the first year! these are surprisingly sweet.', 15, 'strawberry.png'),
(7, 3, 'Cow Manure', 8.50, 'This manure assists with soil moisture, structure and earthworm activity.', 13, 'manure.png'),
(8, 3, 'Top Soil', 10.15, 'Quick, easy solution to build up and rejuvenate garden beds.', 7, 'soil.png'),
(9, 3, 'Compost', 9.00, 'Ideal for improving soil, helping it hold nutrients and water..', 11, 'compost.png');

-- --------------------------------------------------------

--
-- Table structure for table `store_item_color`
--

CREATE TABLE `store_item_color` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_color` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `store_item_color`
--

INSERT INTO `store_item_color` (`id`, `item_id`, `item_color`) VALUES
(1, 1, 'black'),
(2, 1, 'blue'),
(3, 2, 'black'),
(4, 2, 'green'),
(5, 3, 'black'),
(6, 3, 'red');

-- --------------------------------------------------------

--
-- Table structure for table `store_orders`
--

CREATE TABLE `store_orders` (
  `id` int(11) NOT NULL,
  `order_date` datetime DEFAULT NULL,
  `order_name` varchar(100) DEFAULT NULL,
  `order_address` varchar(255) DEFAULT NULL,
  `order_city` varchar(50) DEFAULT NULL,
  `order_state` char(100) DEFAULT NULL,
  `order_zip` varchar(10) DEFAULT NULL,
  `order_tel` varchar(25) DEFAULT NULL,
  `order_email` varchar(100) DEFAULT NULL,
  `item_total` float(6,2) DEFAULT NULL,
  `shipping_total` float(6,2) DEFAULT NULL,
  `authorization` varchar(50) DEFAULT NULL,
  `status` enum('processed','pending') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `store_orders_items`
--

CREATE TABLE `store_orders_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `sel_item_id` int(11) DEFAULT NULL,
  `sel_item_qty` smallint(6) DEFAULT NULL,
  `sel_item_color` varchar(25) DEFAULT NULL,
  `sel_item_price` float(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `store_shoppertrack`
--

CREATE TABLE `store_shoppertrack` (
  `id` int(11) NOT NULL,
  `session_id` varchar(32) DEFAULT NULL,
  `sel_item_id` int(11) DEFAULT NULL,
  `sel_item_qty` smallint(6) DEFAULT NULL,
  `sel_item_color` varchar(25) DEFAULT NULL,
  `date_added` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `forum_categories`
--
ALTER TABLE `forum_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `forum_posts`
--
ALTER TABLE `forum_posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `forum_topics`
--
ALTER TABLE `forum_topics`
  ADD PRIMARY KEY (`topic_id`);

--
-- Indexes for table `store_categories`
--
ALTER TABLE `store_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cat_title` (`cat_title`);

--
-- Indexes for table `store_items`
--
ALTER TABLE `store_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_item_color`
--
ALTER TABLE `store_item_color`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_orders`
--
ALTER TABLE `store_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_orders_items`
--
ALTER TABLE `store_orders_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_shoppertrack`
--
ALTER TABLE `store_shoppertrack`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `forum_categories`
--
ALTER TABLE `forum_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `forum_posts`
--
ALTER TABLE `forum_posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `forum_topics`
--
ALTER TABLE `forum_topics`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `store_categories`
--
ALTER TABLE `store_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `store_items`
--
ALTER TABLE `store_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `store_item_color`
--
ALTER TABLE `store_item_color`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `store_orders`
--
ALTER TABLE `store_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `store_orders_items`
--
ALTER TABLE `store_orders_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `store_shoppertrack`
--
ALTER TABLE `store_shoppertrack`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
