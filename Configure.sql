
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Creating a database
--

-- CREATE DATABASE `Att_sys_db`;


--
-- Table structure for table `user`
--

CREATE TABLE `u766469921_att`.`user_table` (
  `uid` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


--
-- Table structure for table `students`
--

CREATE TABLE `u766469921_att`.`student_table` (
  `sid` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `rno` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `dept` varchar(10) NOT NULL,
  `year` int(2) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Table structure for table `feeds`
--

CREATE TABLE `u766469921_att`.`feed_table` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `feed` varchar(2500) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;



--
-- Table structure for table `attendance`
--

CREATE TABLE `u766469921_att`.`attendance`(
    `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `rno` varchar(20) NOT NULL,
    `date_` varchar(15) NOT NULL,
    `1` int(2) NOT NULL,
    `2` int(2) NOT NULL,
    `3` int(2) NOT NULL,
    `4` int(2) NOT NULL,
    `5` int(2) NOT NULL,
    `6` int(2) NOT NULL,
    `7` int(2) NOT NULL
)