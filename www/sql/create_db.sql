-- You can optionally use this .sql script to import the database

-- create garden_store database, run this command first and then select the database in phpymadmin
create database garden_store;

-- copy & paste the code below and execute multiple queries at once 

-- create forum tables
create table forum_topics (
	topic_id int not null primary key auto_increment,
	category_id int not null,
	topic_title varchar(150),
	topic_create_time datetime,
	topic_owner varchar(150)
);

create table forum_posts (
	post_id int not null primary key auto_increment,
	topic_id int not null,
	category_id int not null,
	post_text text,
	post_create_time datetime,
	post_owner varchar(150)
);

create table forum_categories (
	category_id int not null primary key auto_increment,
	category_name varchar(20)
);

-- create store tables
create table store_categories (
	id int not null primary key auto_increment,
	cat_title varchar(15) unique,
	cat_desc varchar(150)
);

create table store_items (
  id int not null primary key auto_increment,
	cat_id int not null, 
	item_title varchar(75),
	item_price float(8,2),
	item_desc varchar(150),
	item_stock smallint,
	item_image varchar(50)
);

create table store_item_color (
  id int not null primary key auto_increment,
	item_id int not null,
	item_color varchar(25)
);

-- create store_shoppertrack table
create table store_shoppertrack (
	id int not null primary key auto_increment,
	session_id varchar(32),
	sel_item_id int,
	sel_item_qty smallint,
	sel_item_color varchar(25),
	date_added datetime
);

-- create store_orders table 
create table store_orders (
	id int not null primary key auto_increment,
	order_date datetime,
	order_name varchar(100),
	order_address varchar(255),
	order_city varchar(50),
	order_state char(2),
	order_zip varchar(10),
	order_tel varchar(25),
	order_email varchar(100),
	item_total float(6, 2),
	shipping_total float(6, 2),
	authorization varchar(50),
	status enum('processed', 'pending')
);

-- create store_orders_items table
create table store_orders_items (
	id int not null primary key auto_increment,
	order_id int,
	sel_item_id int,
	sel_item_qty smallint,
	sel_item_color varchar(25),
	sel_item_price float(6, 2)
);

-- inserting forum categories
insert into forum_categories values (1, 'General');
insert into forum_categories values (3, 'Gardening Tips');
insert into forum_categories values (2, 'Product Reviews');

-- inserting item categories
insert into store_categories values (1, 'Tools', 'The gardening tools you need!');
insert into store_categories values (2, 'Seeds', 'Our assortment of vegetable, flower and herb seeds.');
insert into store_categories values (3, 'Soils', 'Compost, manure & top soils');

-- inserting store items
insert into store_items values (1, 1, 'Square Shovel', 35.00, 'Designed for digging in hard-packed soils', 8, 'shovel.png');
insert into store_items values (2, 1, 'Garden Fork', 15.00, 'Used for breaking up, lifting and turning over soil.', 5, 'fork.png');
insert into store_items values (3, 1, 'Hoe', 35.00, 'Used for cultivating soil, removing weeds and breaking up clumped soil.', 6, 'hoe.png');
insert into store_items values (4, 2, 'Sunflower Seeds', 4.95, 'Blooms multiple heads with bi-colour petals', 4, 'sunflower.png');
insert into store_items values (5, 2, 'Garlic Seeds', 4.95, 'Garlic chives have a mild flavor and are fantastic in salads!', 9, 'garlic.png');
insert into store_items values (6, 2, 'Strawberry Seeds', 4.95, 'Fruits within the first year! these are surprisingly sweet.', 15, 'strawberry.png');
insert into store_items values (7, 3, "Cow Manure", 8.50, 'This manure assists with soil moisture, structure and earthworm activity.', 13, 'manure.png');
insert into store_items values (8, 3, "Top Soil", 10.15, 'Quick, easy solution to build up and rejuvenate garden beds.', 7, 'soil.png');
insert into store_items values (9, 3, "Compost", 9.00, 'Ideal for improving soil, helping it hold nutrients and water..', 11, 'compost.png');

--inserting into store item color
insert into store_item_color (item_id, item_color) values (1, 'black');
insert into store_item_color (item_id, item_color) values (1, 'blue');
insert into store_item_color (item_id, item_color) values (2, 'black');
insert into store_item_color (item_id, item_color) values (2, 'green');
insert into store_item_color (item_id, item_color) values (3, 'black');
insert into store_item_color (item_id, item_color) values (3, 'red');
