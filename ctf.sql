-- phpMyAdmin SQL Dump
-- version 4.4.15.6
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生時間： 2017 年 09 月 21 日 20:09
-- 伺服器版本: 10.0.23-MariaDB-log
-- PHP 版本： 7.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `ctf`
--

-- --------------------------------------------------------

--
-- 資料表結構 `Announcement`
--

CREATE TABLE IF NOT EXISTS `Announcement` (
  `aid` int(11) NOT NULL,
  `Description` varchar(300) NOT NULL,
  `Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `Challenge`
--

CREATE TABLE IF NOT EXISTS `Challenge` (
  `pid` int(11) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Point` int(11) NOT NULL,
  `Description` varchar(1000) NOT NULL,
  `Flag` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `Eventlog`
--

CREATE TABLE IF NOT EXISTS `Eventlog` (
  `eid` int(11) NOT NULL,
  `UID` int(11) NOT NULL,
  `Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `Userinfo`
--

CREATE TABLE IF NOT EXISTS `Userinfo` (
  `uid` int(11) NOT NULL,
  `ID` varchar(30) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Comment` varchar(100) NOT NULL,
  `Point` int(11) NOT NULL,
  `Email` varchar(300) NOT NULL,
  `LastIP` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `Announcement`
--
ALTER TABLE `Announcement`
  ADD PRIMARY KEY (`aid`);

--
-- 資料表索引 `Challenge`
--
ALTER TABLE `Challenge`
  ADD PRIMARY KEY (`pid`);

--
-- 資料表索引 `Eventlog`
--
ALTER TABLE `Eventlog`
  ADD PRIMARY KEY (`eid`);

--
-- 資料表索引 `Userinfo`
--
ALTER TABLE `Userinfo`
  ADD PRIMARY KEY (`uid`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `Announcement`
--
ALTER TABLE `Announcement`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `Challenge`
--
ALTER TABLE `Challenge`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- 使用資料表 AUTO_INCREMENT `Eventlog`
--
ALTER TABLE `Eventlog`
  MODIFY `eid` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `Userinfo`
--
ALTER TABLE `Userinfo`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
