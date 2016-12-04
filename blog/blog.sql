-- phpMyAdmin SQL Dump
-- version 4.5.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2016-11-05 02:18:27
-- 服务器版本： 5.7.10-log
-- PHP Version: 5.6.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- 表的结构 `blog_blog`
--

CREATE TABLE `blog_blog` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `title` varchar(20) NOT NULL,
  `content` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `blog_blog`
--

INSERT INTO `blog_blog` (`id`, `title`, `content`, `date`) VALUES
(1, '第一次发表帖子', '第一次发表帖子第一次发表帖子第一次发表帖子', '2016-10-29 10:15:21'),
(2, '第二次发表帖子', '第二次发表帖子第二次发表帖子', '2016-10-29 10:31:17'),
(3, '第三次发表帖子', '第三次发表帖子第三次发表帖子', '2016-10-29 10:31:42'),
(6, '第四次发文', '第四次发文', '2016-11-01 16:23:23'),
(7, '第五次发文', '第五次发文', '2016-11-02 12:43:53'),
(8, '第六次发文', '第六次发文第六次发文', '2016-11-02 14:47:25'),
(9, '第七次发文', '第七次发文第七次发文', '2016-11-02 18:35:01');

-- --------------------------------------------------------

--
-- 表的结构 `blog_skin`
--

CREATE TABLE `blog_skin` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `small_bg` varchar(200) NOT NULL,
  `big_bg` varchar(200) NOT NULL,
  `bg_color` varchar(200) NOT NULL,
  `bg_text` varchar(200) NOT NULL,
  `bg_flag` tinyint(2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `blog_skin`
--

INSERT INTO `blog_skin` (`id`, `small_bg`, `big_bg`, `bg_color`, `bg_text`, `bg_flag`) VALUES
(1, 'small_bg1.png', 'bg1.jpg', '#E7E9E8', '皮肤1', 0),
(2, 'small_bg2.png', 'bg2.jpg', '#ECF0FC', '皮肤2', 0),
(3, 'small_bg3.png', 'bg3.jpg', '#E2E2E2', '皮肤3', 0),
(4, 'small_bg4.png', 'bg4.jpg', '#FFFFFF', '皮肤4', 0),
(5, 'small_bg5.png', 'bg5.jpg', '#F3F3F3', '皮肤5', 1),
(6, 'small_bg6.png', 'bg6.jpg', '#EBDEBE', '皮肤6', 0);

-- --------------------------------------------------------

--
-- 表的结构 `blog_user`
--

CREATE TABLE `blog_user` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `user` varchar(20) NOT NULL,
  `pass` char(40) NOT NULL,
  `ques` varchar(200) NOT NULL,
  `ans` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `birthday` date NOT NULL,
  `ps` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `blog_user`
--

INSERT INTO `blog_user` (`id`, `user`, `pass`, `ques`, `ans`, `email`, `birthday`, `ps`) VALUES
(1, 'yuzhi', '7686f035981a1ee9bd9f0d1ef831078c5c96a55c', '1', '酸菜鱼', 'yuzhi@qq.com', '1966-08-10', ''),
(2, '王小二', '7686f035981a1ee9bd9f0d1ef831078c5c96a55c', '2', '花花', 'huahua@qq.com', '1970-01-01', ''),
(3, '花木兰', '5e6bb8ff320a2b18993e6a2c7602fabe43a6faff', '1', '酸菜鱼', 'huamulan@qq.com', '1968-09-13', '可可'),
(4, 'admin', '5e6bb8ff320a2b18993e6a2c7602fabe43a6faff', '2', '花花', 'huahua@qq.com', '1950-01-01', ''),
(5, 'adminphp', '7686f035981a1ee9bd9f0d1ef831078c5c96a55c', '2', '花花', 'huhu@qq.com', '1970-01-01', ''),
(6, 'phpmyadmin', '7686f035981a1ee9bd9f0d1ef831078c5c96a55c', '1', '酸菜鱼', 'suancaiyu@163.com', '1968-10-12', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_blog`
--
ALTER TABLE `blog_blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_skin`
--
ALTER TABLE `blog_skin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_user`
--
ALTER TABLE `blog_user`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `blog_blog`
--
ALTER TABLE `blog_blog`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- 使用表AUTO_INCREMENT `blog_skin`
--
ALTER TABLE `blog_skin`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- 使用表AUTO_INCREMENT `blog_user`
--
ALTER TABLE `blog_user`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
