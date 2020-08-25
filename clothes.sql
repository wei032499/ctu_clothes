-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 
-- 伺服器版本： 10.4.11-MariaDB
-- PHP 版本： 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `clothes`
--

-- --------------------------------------------------------

--
-- 資料表結構 `branch`
--

CREATE TABLE `branch` (
  `Bran_Num` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '分店編號',
  `Bran_Name` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '分店名稱',
  `Bran_Start` date NOT NULL COMMENT '設立日期',
  `Bran_Addr` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '地址',
  `Bran_Tel` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '電話',
  `Bran_Supr` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '店長',
  `Bran_Depo` int(10) UNSIGNED NOT NULL COMMENT '押金',
  `Bran_Deco` int(10) UNSIGNED NOT NULL COMMENT '裝潢費',
  `Bran_Memo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '租約注意事項',
  `Adduser` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '建檔人員',
  `Addtime` datetime NOT NULL DEFAULT current_timestamp() COMMENT '建檔時間',
  `Chguser` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '最後修改人員',
  `Chgtime` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '最後修改時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `branch`
--

INSERT INTO `branch` (`Bran_Num`, `Bran_Name`, `Bran_Start`, `Bran_Addr`, `Bran_Tel`, `Bran_Supr`, `Bran_Depo`, `Bran_Deco`, `Bran_Memo`, `Adduser`, `Addtime`, `Chguser`, `Chgtime`) VALUES
('M001', '沙鹿市場店', '2020-06-23', '沙鹿第一市場10號', '0426001300', '李春水', 12000, 236890, '', 'Admin', '2020-06-29 22:29:32', 'Admin', '2020-07-18 02:19:06'),
('M002', '彰化中山店', '2020-04-02', '彰化市中山路2段200號', '0476001300', '趙小平', 25000, 500000, '', 'Admin', '2020-07-26 11:06:39', 'Admin', '2020-07-26 11:06:39'),
('M03', '彰化總店', '2020-01-01', '彰化市中山路2段210號', '037054261', '張玉婷', 26000, 0, '', 'E202007005', '2020-08-16 14:20:48', 'E202007005', '2020-08-16 14:20:48'),
('N01', '台北建國店', '2019-01-01', '台北市建國路100號', '0233883388', '吳秀秀', 60000, 100000, '', 'E202007005', '2020-08-16 14:31:16', 'E202007005', '2020-08-16 14:31:16');

-- --------------------------------------------------------

--
-- 資料表結構 `branchexpenditure`
--

CREATE TABLE `branchexpenditure` (
  `EB_Id` int(10) UNSIGNED NOT NULL COMMENT '自動編號',
  `Bran_Num` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '分店編號',
  `EB_Date` date NOT NULL COMMENT '支出日期',
  `EB_CT` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'C04',
  `EB_Cate` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '費用類型',
  `EB_Amt` int(10) UNSIGNED NOT NULL COMMENT '支出金額',
  `EB_Msg` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '費用說明',
  `Adduser` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '建檔人員',
  `Addtime` datetime NOT NULL DEFAULT current_timestamp() COMMENT '建檔時間',
  `Chguser` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '最後修改人員',
  `Chgtime` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '最後修改時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `branchexpenditure`
--

INSERT INTO `branchexpenditure` (`EB_Id`, `Bran_Num`, `EB_Date`, `EB_CT`, `EB_Cate`, `EB_Amt`, `EB_Msg`, `Adduser`, `Addtime`, `Chguser`, `Chgtime`) VALUES
(2, 'M001', '2020-07-26', 'C04', '001', 30000, '8月份租金', 'Admin', '2020-07-26 11:01:58', 'Admin', '2020-07-26 11:01:58'),
(3, 'M001', '2020-07-23', 'C04', '002', 2500, '7月份電費', 'Admin', '2020-07-26 11:02:35', 'Admin', '2020-07-26 11:02:35'),
(4, 'M001', '2020-07-28', 'C04', '002', 250, '7月份水費', 'Admin', '2020-07-26 11:02:59', 'Admin', '2020-07-26 11:02:59'),
(5, 'M002', '2020-07-26', 'C04', '001', 20000, '8月份', 'Admin', '2020-07-26 11:07:18', 'Admin', '2020-07-26 11:07:18'),
(6, 'M002', '2020-06-04', 'C04', '001', 20000, '七月份', 'Admin', '2020-07-26 11:07:40', 'Admin', '2020-07-26 11:07:40'),
(7, 'M002', '2020-05-12', 'C04', '004', 1500, '修理門鎖', 'Admin', '2020-07-26 11:08:22', 'Admin', '2020-07-26 11:08:22');

-- --------------------------------------------------------

--
-- 資料表結構 `custmeasure`
--

CREATE TABLE `custmeasure` (
  `Cust_Num` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '顧客編號(C+西元年+月份+流水號5碼)',
  `BodyM_Date` date NOT NULL COMMENT '量身日期',
  `Emp_Num` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '量身人員',
  `Bran_Num` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '量身分店',
  `BodyM_High` float UNSIGNED NOT NULL COMMENT '身高',
  `BodyM_Weight` decimal(7,3) UNSIGNED NOT NULL COMMENT '體重',
  `BodyM_Cup` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '罩杯',
  `Unit_CT` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'B08',
  `BodyM_Unit` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '量身單位',
  `Cust_Memo` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '備註',
  `BodyM_SW` decimal(7,3) UNSIGNED NOT NULL COMMENT '肩寛',
  `BodyM_DFS` decimal(7,3) UNSIGNED NOT NULL COMMENT '前胸吊帶距',
  `BodyM_BH` decimal(7,3) UNSIGNED NOT NULL COMMENT '乳高',
  `BodyM_BR` decimal(7,3) UNSIGNED NOT NULL COMMENT '乳深',
  `BodyM_SBW` decimal(7,3) UNSIGNED NOT NULL COMMENT '單乳寬',
  `BodyM_FBW` decimal(7,3) UNSIGNED NOT NULL COMMENT '前胸寬',
  `BodyM_UpB` decimal(7,3) UNSIGNED NOT NULL COMMENT '胸上圍',
  `BodyM_B` decimal(7,3) UNSIGNED NOT NULL COMMENT '胸圍',
  `BodyM_UdB` decimal(7,3) UNSIGNED NOT NULL COMMENT '胸下圍',
  `BodyM_ArtoUdB` decimal(7,3) UNSIGNED NOT NULL COMMENT '腋下->胸下',
  `BodyM_ArtoW` decimal(7,3) UNSIGNED NOT NULL COMMENT '腋下->腰',
  `BodyM_ArtoT` decimal(7,3) UNSIGNED NOT NULL COMMENT '腋下->大腿',
  `BodyM_UdBtoW` decimal(7,3) UNSIGNED NOT NULL COMMENT '胸下->腰',
  `BodyM_UdBtoT` decimal(7,3) UNSIGNED NOT NULL COMMENT '胸下->大腿',
  `BodyM_W` decimal(7,3) UNSIGNED NOT NULL COMMENT '腰圍',
  `BodyM_AbH` decimal(7,3) UNSIGNED NOT NULL COMMENT '腹高',
  `BodyM_Ab` decimal(7,3) UNSIGNED NOT NULL COMMENT '腹圍',
  `BodyM_UdBtoY` decimal(7,3) UNSIGNED NOT NULL COMMENT '胸下->Y',
  `BodyM_Hip` decimal(7,3) UNSIGNED NOT NULL COMMENT '臀圍',
  `BodyM_HL` decimal(7,3) UNSIGNED NOT NULL COMMENT '臀長',
  `BodyM_WtoT` decimal(7,3) UNSIGNED NOT NULL COMMENT '平口側邊長',
  `BodyM_OTS` decimal(7,3) UNSIGNED NOT NULL COMMENT '斜大腿圍',
  `BodyM_BL` decimal(7,3) UNSIGNED NOT NULL COMMENT '背長',
  `BodyM_BW` decimal(7,3) UNSIGNED NOT NULL COMMENT '背寬',
  `BodyM_CD` decimal(7,3) UNSIGNED NOT NULL COMMENT '股上長',
  `BodyM_HLH` decimal(7,3) UNSIGNED NOT NULL COMMENT '提臀高',
  `BodyM_BHLH` decimal(7,3) UNSIGNED NOT NULL COMMENT '四角提臀高',
  `BodyM_CL` decimal(7,3) UNSIGNED NOT NULL COMMENT '褲檔長',
  `BodyM_UdBtoC` decimal(7,3) UNSIGNED NOT NULL COMMENT '總檔長',
  `Adduser` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '建檔人員',
  `Addtime` datetime NOT NULL DEFAULT current_timestamp() COMMENT '建檔時間',
  `Chguser` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '最後修改人員',
  `Chgtime` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '最後修改時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `custmeasure`
--

INSERT INTO `custmeasure` (`Cust_Num`, `BodyM_Date`, `Emp_Num`, `Bran_Num`, `BodyM_High`, `BodyM_Weight`, `BodyM_Cup`, `Unit_CT`, `BodyM_Unit`, `Cust_Memo`, `BodyM_SW`, `BodyM_DFS`, `BodyM_BH`, `BodyM_BR`, `BodyM_SBW`, `BodyM_FBW`, `BodyM_UpB`, `BodyM_B`, `BodyM_UdB`, `BodyM_ArtoUdB`, `BodyM_ArtoW`, `BodyM_ArtoT`, `BodyM_UdBtoW`, `BodyM_UdBtoT`, `BodyM_W`, `BodyM_AbH`, `BodyM_Ab`, `BodyM_UdBtoY`, `BodyM_Hip`, `BodyM_HL`, `BodyM_WtoT`, `BodyM_OTS`, `BodyM_BL`, `BodyM_BW`, `BodyM_CD`, `BodyM_HLH`, `BodyM_BHLH`, `BodyM_CL`, `BodyM_UdBtoC`, `Adduser`, `Addtime`, `Chguser`, `Chgtime`) VALUES
('C20200600004', '2020-07-28', 'E202007004', 'M001', 100, '2.000', '3', 'B08', 'INC', '456', '4.000', '5.000', '6.000', '7.000', '8.000', '9.000', '1.000', '2.000', '3.000', '4.000', '5.000', '67.000', '8.000', '9.000', '1.000', '2.000', '3.000', '45.000', '8.000', '9.000', '3.000', '1.000', '2.000', '3.000', '2.000', '3.000', '4.000', '6.000', '5.000', 'Admin', '2020-07-28 22:14:57', 'Admin', '2020-07-30 21:51:14'),
('C20200800007', '2020-08-16', 'E202007005', 'M002', 164, '65.000', 'C', 'B08', 'INC', 'test', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', 'E202007005', '2020-08-16 13:35:29', 'E202007005', '2020-08-16 13:49:52'),
('C20200800007', '2020-08-17', 'E202007005', 'N01', 160, '50.000', 'B', 'B08', 'FT', 'test', '24.000', '34.000', '5.600', '34.000', '6.000', '7.000', '45.000', '45.000', '45.000', '45.000', '6.000', '7.000', '8.000', '12.000', '30.000', '4.500', '34.000', '15.000', '15.000', '15.000', '15.000', '15.000', '15.000', '15.000', '15.000', '15.000', '15.000', '15.000', '15.000', 'E202007005', '2020-08-17 10:29:14', 'E202007005', '2020-08-17 10:29:14'),
('C20200800013', '2020-08-17', 'E202007005', 'M001', 156, '55.000', 'C', 'B08', 'FT', 'test', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '12.000', '21.000', '23.000', '23.000', '23.000', '23.000', '23.000', '23.000', '23.000', 'Admin', '2020-08-17 14:37:46', 'Admin', '2020-08-17 14:37:46');

-- --------------------------------------------------------

--
-- 資料表結構 `custom`
--

CREATE TABLE `custom` (
  `Cust_Num` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '客製圖編號',
  `Order_Num` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '訂單編號',
  `Item_Num` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '訂單品項',
  `ProtoM_Num` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '原型圖編號',
  `ProtoM_Pho` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '圖檔路徑',
  `Adduser` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '建檔人員',
  `Addtime` datetime NOT NULL DEFAULT current_timestamp() COMMENT '建檔時間',
  `Chguser` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '最後修改人員',
  `Chgtime` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '最後修改時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `custom`
--

INSERT INTO `custom` (`Cust_Num`, `Order_Num`, `Item_Num`, `ProtoM_Num`, `ProtoM_Pho`, `Adduser`, `Addtime`, `Chguser`, `Chgtime`) VALUES
('CP20200714001', 'OM0011090700006', '002', 'PM000A_S', 'path', '', '2020-08-10 19:35:41', '', '2020-08-10 19:37:08');

-- --------------------------------------------------------

--
-- 資料表結構 `customer`
--

CREATE TABLE `customer` (
  `Cust_Num` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '顧客編號(C+西元年+月份+流水號5碼)',
  `Cust_Name` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '顧客姓名',
  `Cust_Birth` date NOT NULL COMMENT '出生日期',
  `Cust_Postal` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '郵遞區號',
  `Cust_Addr` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '住址',
  `Cust_Tel` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '電話(包括家用電話及手機)',
  `Cust_Mobile` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '手機',
  `Cust_Email` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Email',
  `Cust_Memo` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '特殊備註',
  `Bran_Num` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '建檔分店',
  `Adduser` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '建檔人員',
  `Addtime` datetime NOT NULL DEFAULT current_timestamp() COMMENT '建檔時間',
  `Chguser` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '最後修改人員',
  `Chgtime` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '最後修改時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `customer`
--

INSERT INTO `customer` (`Cust_Num`, `Cust_Name`, `Cust_Birth`, `Cust_Postal`, `Cust_Addr`, `Cust_Tel`, `Cust_Mobile`, `Cust_Email`, `Cust_Memo`, `Bran_Num`, `Adduser`, `Addtime`, `Chguser`, `Chgtime`) VALUES
('C20200600004', '于美人', '2020-06-09', '123', '台南市中西區民生路二段416號', '00-0000000', '0900-000000', 'test@test', 'TTTTTTTTTT1', 'M002', 'Admin', '2020-06-29 00:12:31', 'E202007005', '2020-08-16 11:44:07'),
('C20200700001', '李聖經', '2020-07-14', '30049', '新竹市西大路658號', '035221082', '0977123254', 'test4@gmail.com', '2號', 'M001', 'Admin', '2020-07-27 15:10:45', 'Admin', '2020-08-16 10:46:05'),
('C20200800001', '林志玲', '1995-02-07', '123', '新竹市北區中正路178號', '035282323', '0900000000', 'test1@gmail.com', 'test', 'M001', 'Admin', '2020-08-16 10:34:50', 'Admin', '2020-08-16 10:34:50'),
('C20200800002', '劉嘉玲', '2002-06-12', '30060', '新竹市東區中華路二段188號', '035151111', '0911000000', 'test2@gmail.com', '一號身型', 'M001', 'Admin', '2020-08-16 10:36:36', 'Admin', '2020-08-16 10:36:36'),
('C20200800003', '劉詩詩', '2006-07-17', '30080', '新竹市大學路16號', '035715888', '0988888888', 'test3@gmail.com', '二號身型', 'M001', 'Admin', '2020-08-16 10:40:36', 'Admin', '2020-08-16 10:40:36'),
('C20200800004', '李知恩', '1998-09-23', '300', '新竹市民族路69號', '036238899', '0911623999', 'test5@gmail.com', 'test', 'M001', 'Admin', '2020-08-16 10:48:40', 'Admin', '2020-08-16 10:48:40'),
('C20200800007', '吳淡如', '1984-03-05', '70050', '台南市忠義路二段132號', '06-2225655', '0906-222655', 'test7@gmail.com', '', 'M002', 'E202007005', '2020-08-16 11:47:44', 'E202007005', '2020-08-16 11:47:44'),
('C20200800008', '李艾莎', '1999-03-10', '354', '彰化市中山路250號', '', '0910000999', 'elsali@gmail.com', '', 'M002', 'E202007005', '2020-08-16 14:16:15', 'E202007005', '2020-08-16 14:17:58'),
('C20200800010', '周文文', '1995-01-01', '261', '台北市中正路100號', '', '0910999888', 'winzhou@gmail.com', '', 'N01', 'E202007005', '2020-08-16 15:15:58', 'E202007005', '2020-08-16 15:15:58'),
('C20200800011', '韓瑜', '2007-12-25', '950', '台東縣台東市博愛路362巷18號', '08-9356589', '0908-356589', 'test9@gmail.com', '', 'N01', 'E202007005', '2020-08-17 08:00:30', 'E202007005', '2020-08-17 08:00:30'),
('C20200800012', 'test', '2020-07-30', '500', '中山路2段644巷15號', '047123456', '09047123456', 'test3@gmail.com', '', 'N01', 'E202007005', '2020-08-17 08:01:22', 'E202007005', '2020-08-17 08:01:22'),
('C20200800013', '趙萌萌', '2020-08-13', '000', 'test', '02-123456', '0904-7123456', 'A@a', 'test', 'M001', 'Admin', '2020-08-17 14:34:22', 'Admin', '2020-08-17 14:34:22');

-- --------------------------------------------------------

--
-- 資料表結構 `custorder`
--

CREATE TABLE `custorder` (
  `Order_Num` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '訂單編號',
  `Cust_Num` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '顧客編號',
  `Order_Date` date NOT NULL COMMENT '訂購日期',
  `BodyM_Date` date NOT NULL COMMENT '量身日期',
  `Order_Qty` int(10) UNSIGNED NOT NULL COMMENT '總件數',
  `Order_Amt` int(10) UNSIGNED NOT NULL COMMENT '總金額',
  `Order_Deposit` int(10) UNSIGNED NOT NULL COMMENT '訂金金額',
  `Plan_Date` date NOT NULL COMMENT '預定交期',
  `DeliveryWay_CT` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT 'A03',
  `DeliveryWay` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '預定交貨方式',
  `Order_Postal` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '郵遞區號',
  `DeliveryAddr` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '送貨地點',
  `OrderStatus_CT` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A01',
  `OrderStatus` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '000' COMMENT '訂單狀態',
  `OrderCancel` tinyint(1) NOT NULL DEFAULT 0 COMMENT '取消訂單',
  `OrderReason` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '取消原因',
  `Bran_Num` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '建檔分店',
  `Adduser` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '建檔人員',
  `Addtime` datetime NOT NULL DEFAULT current_timestamp() COMMENT '建檔時間',
  `Chguser` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '最後修改人員',
  `Chgtime` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '最後修改時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `custorder`
--

INSERT INTO `custorder` (`Order_Num`, `Cust_Num`, `Order_Date`, `BodyM_Date`, `Order_Qty`, `Order_Amt`, `Order_Deposit`, `Plan_Date`, `DeliveryWay_CT`, `DeliveryWay`, `Order_Postal`, `DeliveryAddr`, `OrderStatus_CT`, `OrderStatus`, `OrderCancel`, `OrderReason`, `Bran_Num`, `Adduser`, `Addtime`, `Chguser`, `Chgtime`) VALUES
('OM0011090700001', 'C20200700001', '2020-07-28', '2020-07-01', 3, 6, 9, '2020-08-11', 'A03', '000', 'x', 'x', 'A01', '000', 0, '', 'M001', 'Admin', '2020-07-28 20:38:04', 'Admin', '2020-07-31 20:27:30'),
('OM0011090700002', 'C20200700001', '2020-07-28', '2020-07-01', 3, 6, 9, '2020-08-11', 'A03', '000', 'x', 'x', 'A01', '001', 0, '', 'M001', 'Admin', '2020-07-28 20:38:44', 'Admin', '2020-08-09 22:04:20'),
('OM0011090700003', 'C20200700001', '2020-07-28', '2020-07-01', 3, 6, 9, '2020-08-11', 'A03', '000', 'x', 'x', 'A01', '002', 0, '', 'M001', 'Admin', '2020-07-28 20:39:16', 'Admin', '2020-08-09 21:49:46'),
('OM0011090700004', 'C20200700001', '2020-07-28', '2020-07-01', 3, 6, 9, '2020-08-11', 'A03', '000', 'x', 'x', 'A01', '002', 0, '', 'M001', 'Admin', '2020-07-28 20:42:08', 'Admin', '2020-08-10 17:35:18'),
('OM0011090700005', 'C20200700001', '2020-07-28', '2020-07-01', 3, 6, 9, '2020-08-11', 'A03', '000', 'x', 'x', 'A01', '004', 0, '', 'M001', 'Admin', '2020-07-28 21:14:27', 'Admin', '2020-08-16 10:30:05'),
('OM0011090700006', 'C20200700001', '2020-07-28', '2020-07-01', 10, 78, 9, '2020-08-14', 'A03', '001', 'aa', 'xz', 'A01', '006', 0, '', 'M001', 'Admin', '2020-07-28 21:15:34', 'Admin', '2020-08-16 09:48:19'),
('OM0011090700007', 'C20200600004', '2020-07-29', '2020-07-28', 7, 42, 5, '2020-08-12', 'A03', '000', '123', '456', 'A01', '002', 1, 'test', 'M001', 'Admin', '2020-07-29 00:04:47', 'Admin', '2020-08-09 21:56:25'),
('OM0011090800001', 'C20200800013', '2020-08-17', '2020-08-17', 1, 200, 50, '2020-08-31', 'A03', '000', '000', 'test', 'A01', '000', 0, '', 'M001', 'Admin', '2020-08-17 14:40:06', 'Admin', '2020-08-17 14:40:06'),
('OM0021090800001', 'C20200600004', '2020-08-16', '2020-07-28', 3, 7900, 3000, '2020-08-30', 'A03', '000', '123', '台南市中西區民生路二段416號', 'A01', '004', 0, '', 'M002', 'E202007005', '2020-08-16 13:42:17', 'E202007005', '2020-08-16 14:22:54'),
('OM0021090800002', 'C20200800007', '2020-08-16', '2020-08-16', 3, 2100, 500, '2020-08-30', 'A03', '000', '70050', '台南市忠義路二段132號', 'A01', '002', 0, '', 'M002', 'E202007005', '2020-08-16 13:51:58', 'E202007005', '2020-08-16 13:59:08');

-- --------------------------------------------------------

--
-- 資料表結構 `department`
--

CREATE TABLE `department` (
  `Dep_Num` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '部門編號(D+流水號3碼)',
  `Dep_Name` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '部門名稱',
  `Dep_Supr` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '部門主管',
  `Adduser` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '建檔人員',
  `Addtime` datetime NOT NULL DEFAULT current_timestamp() COMMENT '建檔時間',
  `Chguser` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '最後修改人員',
  `Chgtime` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '最後修改時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `department`
--

INSERT INTO `department` (`Dep_Num`, `Dep_Name`, `Dep_Supr`, `Adduser`, `Addtime`, `Chguser`, `Chgtime`) VALUES
('D000', '行銷', 'E202007003', 'SYSTEM', '2020-07-24 00:20:01', 'Admin', '2020-07-26 11:12:22'),
('D001', '銷售', 'E202007005', 'admin', '2020-07-29 09:04:18', 'admin', '2020-07-29 09:04:18'),
('D002', '生產', 'E202008001', 'Admin', '2020-08-16 14:09:49', 'Admin', '2020-08-16 14:09:49');

-- --------------------------------------------------------

--
-- 資料表結構 `employee`
--

CREATE TABLE `employee` (
  `Emp_Num` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '員工編號(EYYYYMM999)',
  `Emp_Name` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '員工姓名',
  `Emp_ID` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '身份證字號',
  `Emp_Addr` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '住址',
  `Emp_Tel` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '住家電話',
  `Emp_Mobile` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '手機',
  `Emp_Start` date NOT NULL COMMENT '到職日',
  `Emp_Invalid` date NOT NULL COMMENT '權限失效日',
  `Level_CT` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'C05',
  `Emp_Level` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '薪級',
  `Dep_Num` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '所屬部門',
  `Bran_Num` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '上班分店',
  `Emp_PSW` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '密碼',
  `Emp_Role` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '角色',
  `Adduser` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '建檔人員',
  `Addtime` datetime NOT NULL DEFAULT current_timestamp() COMMENT '建檔時間',
  `Chguser` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '最後修改人員',
  `Chgtime` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '最後修改時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `employee`
--

INSERT INTO `employee` (`Emp_Num`, `Emp_Name`, `Emp_ID`, `Emp_Addr`, `Emp_Tel`, `Emp_Mobile`, `Emp_Start`, `Emp_Invalid`, `Level_CT`, `Emp_Level`, `Dep_Num`, `Bran_Num`, `Emp_PSW`, `Emp_Role`, `Adduser`, `Addtime`, `Chguser`, `Chgtime`) VALUES
('Admin', 'Admin', '', '', '', '', '0000-00-00', '0000-00-00', 'C05', '001', 'D000', 'M001', 'fb001dfcffd1c899f3297871406242f097aecf1a5342ccf3ebcd116146188e4b', '000', 'SYSTEM', '2020-07-23 23:32:00', 'SYSTEM', '2020-07-24 12:03:38'),
('E000000000', '系統管理員', 'A000000000', '-', '', '-', '2020-06-01', '0000-00-00', 'C05', '003', 'D000', 'M001', '50b317db143dcf0aeeb85434d91cd10ae84267848c179e4c6eee890da3a11728', '000', 'SYSTEM', '2020-08-16 14:02:02', 'Admin', '2020-08-17 10:02:41'),
('E202006001', '莎莉賽隆', 'P123456789', '新竹市北大路225號', '05-0000000', '0921-000000', '2020-06-22', '2020-06-29', 'C05', '001', 'D000', 'M001', '36f028580bb02cc8272a9a020f4200e346e276ae664e45ee80745574e2f5ab80', '111', 'Admin', '2020-06-29 20:44:04', 'Admin', '2020-08-16 10:52:31'),
('E202007003', '王珊珊', 'K123456789', '彰化市中正路1號', '04-7123456', '0965-234815', '2020-07-01', '0000-00-00', 'C05', '001', 'D000', 'M002', '5835085655da884a7245b6fc0c4252ab330ab0517510f72e94c79b4c558fd141', '112', 'Admin', '2020-07-26 11:11:53', 'Admin', '2020-08-16 12:11:18'),
('E202007004', '李冰冰', 'L123456789', '台中市南區', '04-2456789', '0965-235477', '2020-07-01', '0000-00-00', 'C05', '001', 'D000', 'M001', 'd1f3519ebe48075c1817e9e8f946aa751cf83735c58cf3600c7376525216a73a', '112', 'Admin', '2020-07-26 11:20:10', 'Admin', '2020-08-16 12:07:19'),
('E202007005', '陳小微', 'M222123456', '新竹市東區大同路11號', '03-123422', '0912-534888', '2020-07-01', '0000-00-00', 'C05', '001', 'D000', 'N01', '3a7a2ad22be114f9119d2c2b5d7abf8095983b3cd68a8d136006b3e865c55682', '201', 'admin', '2020-07-29 09:02:40', 'Admin', '2020-08-16 17:24:59'),
('E202008001', '李若彤', 'C123456789', '台中市南屯區文昌街353號', '04-22288765', '0904-288765', '2020-08-20', '0000-00-00', 'C05', '002', 'D002', 'M001', '51500822da5e4eded570d733acbb8239a85e3a0b988bb956c3d689be720feff2', '000', 'Admin', '2020-08-16 14:09:19', 'Admin', '2020-08-16 14:11:46'),
('E202008002', '賈靜雯', 'J123456789', 'test', '047123456', '0904-123456', '2020-08-10', '2020-08-15', 'C05', '001', 'D002', 'M03', 'be8f8a0c48688a8156be3fd8937a5298ff86860375c9f4720c5019bc134b62a9', '112', 'Admin', '2020-08-17 11:19:08', 'Admin', '2020-08-17 11:23:25'),
('E202008003', '周揚青', 'G123456789', 'test', '04-7123456', '0905_000999', '2020-08-17', '0000-00-00', 'C05', '001', 'D002', 'M03', '2961ad9a5c3712922e0932450fc008b06dba3ef8e8bc2876c363ee3d0bb2a778', '112', 'Admin', '2020-08-17 11:33:20', 'Admin', '2020-08-17 11:33:20');

-- --------------------------------------------------------

--
-- 資料表結構 `material`
--

CREATE TABLE `material` (
  `Mate_Num` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用料編號',
  `Mate_Name` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用料名稱',
  `CT_No` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用料大類',
  `CI_No` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用料小類',
  `Color_CT` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'B07',
  `Mate_Color` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '顏色',
  `Safe_Qty` int(10) UNSIGNED NOT NULL COMMENT '安全存量',
  `Unit_CT` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'B08',
  `Mate_Unit` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '單位',
  `Supply_Num` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '預設供應商',
  `Adduser` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '建檔人員',
  `Addtime` datetime NOT NULL DEFAULT current_timestamp() COMMENT '建檔時間',
  `Chguser` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '最後修改人員',
  `Chgtime` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '最後修改時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `material`
--

INSERT INTO `material` (`Mate_Num`, `Mate_Name`, `CT_No`, `CI_No`, `Color_CT`, `Mate_Color`, `Safe_Qty`, `Unit_CT`, `Mate_Unit`, `Supply_Num`, `Adduser`, `Addtime`, `Chguser`, `Chgtime`) VALUES
('B01001000001', 'Z', 'B01', '001', 'B07', 'B02', 2, 'B08', 'SYD', 'S202007001', 'Admin', '2020-07-08 00:00:00', 'Admin', '2020-07-18 16:38:08'),
('B01001000002', '蕾絲布_黑色(整前)', 'B01', '001', 'B07', 'B01', 300, 'B08', 'YD', 'S202007001', 'Admin', '2020-07-26 10:08:22', 'Admin', '2020-07-26 10:37:13'),
('B01001000003', '蕾絲布_紅色', 'B01', '001', 'B07', 'R01', 250, 'B08', 'YD', 'S202007002', 'Admin', '2020-07-26 10:09:57', 'Admin', '2020-07-26 10:09:57'),
('B01001000004', '蕾絲布_黑色(整後)', 'B01', '001', 'B07', 'B01', 150, 'B08', 'YD', 'S202007005', 'Admin', '2020-07-26 10:33:54', 'Admin', '2020-07-26 10:35:56'),
('B01002000001', '絲棉_原色', 'B01', '002', 'B07', 'P01', 50, 'B08', 'YD', 'S202007001', 'Admin', '2020-07-26 10:07:30', 'Admin', '2020-07-26 10:07:30'),
('B01004000001', '彈性蕾絲_綠', 'B01', '004', 'B07', 'G01', 50, 'B08', 'YD', 'S202007001', 'Admin', '2020-07-26 10:11:01', 'Admin', '2020-07-26 10:11:16'),
('B02001000001', '胸墊_厚', 'B02', '001', 'B07', 'P01', 20, 'B08', 'FT', 'S202007001', 'Admin', '2020-07-26 10:52:59', 'Admin', '2020-08-14 22:44:58'),
('B04003000001', '3號勾勾', 'B04', '003', 'B07', 'P01', 100, 'B08', 'INC', 'S202007003', 'Admin', '2020-07-26 09:50:09', 'Admin', '2020-08-14 22:44:45'),
('B05001000001', '肩帶_粗_原色', 'B05', '001', 'B07', 'P01', 20, 'B08', 'YD', 'S202007003', 'Admin', '2020-07-26 10:17:25', 'Admin', '2020-07-26 10:17:25'),
('B05002000001', '肩帶_細_原色', 'B05', '002', 'B07', 'P01', 20, 'B08', 'YD', 'S202007003', 'Admin', '2020-07-26 10:18:11', 'Admin', '2020-07-26 10:18:11'),
('B06001000001', '布邊線_原色', 'B06', '001', 'B07', 'P01', 5, 'B08', 'PCS', 'S202007004', 'Admin', '2020-07-26 10:21:02', 'Admin', '2020-07-26 10:21:02'),
('B06003000001', '一般線_紅', 'B06', '003', 'B07', 'R01', 10, 'B08', 'PCS', 'S202007003', 'Admin', '2020-07-26 10:14:37', 'Admin', '2020-07-26 10:14:37');

-- --------------------------------------------------------

--
-- 資料表結構 `mateusa`
--

CREATE TABLE `mateusa` (
  `WU_Num` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '派工用料單號',
  `Work_Num` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '派工單號',
  `WU_Date` date NOT NULL COMMENT '派工用料日期',
  `WU_Item` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '派料品項',
  `Mate_Num` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '料品編號',
  `WU_Unit` decimal(12,3) NOT NULL COMMENT '單件用量',
  `WU_Qty` decimal(12,3) NOT NULL COMMENT '總扣帳數量',
  `Adduser` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '建檔人員',
  `Addtime` datetime NOT NULL DEFAULT current_timestamp() COMMENT '建檔時間',
  `Chguser` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '最後修改人員',
  `Chgtime` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '最後修改時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `mateusa`
--

INSERT INTO `mateusa` (`WU_Num`, `Work_Num`, `WU_Date`, `WU_Item`, `Mate_Num`, `WU_Unit`, `WU_Qty`, `Adduser`, `Addtime`, `Chguser`, `Chgtime`) VALUES
('M20200809001', 'W20200809001', '2020-08-16', '001', 'B01001000004', '5.000', '5.000', '', '2020-08-16 10:29:04', '', '2020-08-16 10:29:04'),
('M20200809001', 'W20200809001', '2020-08-16', '002', 'B02001000001', '2.000', '2.000', '', '2020-08-16 10:29:04', '', '2020-08-16 10:29:04'),
('z', 'W20200810002', '2020-08-05', '002', 'B04003000001', '5.000', '6.000', '', '2020-08-14 21:49:33', '', '2020-08-14 21:49:33');

-- --------------------------------------------------------

--
-- 資料表結構 `orderitem`
--

CREATE TABLE `orderitem` (
  `Order_Num` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '訂單編號',
  `Item_Num` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '訂單品項',
  `Design_Num` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '塑身衣編號',
  `Design_Mate_CT` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'B01',
  `Design_Mate` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '布料材質',
  `Color_CT` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'B07',
  `Item_Color` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '顏色',
  `Item_BgColor` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '基底色',
  `Effect_CT` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A04',
  `Item_Effect` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '塑身效果',
  `Item_Extra` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '特殊需求',
  `Item_EPrice` int(10) UNSIGNED DEFAULT NULL COMMENT '特殊需求加價',
  `Item_Price` int(10) UNSIGNED NOT NULL COMMENT '單價',
  `Item_Qty` int(10) UNSIGNED NOT NULL COMMENT '數量',
  `Item_PDate` date NOT NULL COMMENT '交貨日期',
  `Item_Amt` int(10) UNSIGNED NOT NULL COMMENT '小計金額',
  `Bside_CT` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A05',
  `Item_Bside` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '乳側處理',
  `Breast_CT` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A06',
  `Item_Breast` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '乳房包覆',
  `Spon_CT` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A07',
  `Item_Spon` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '海棉需求',
  `Cup_CT` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A08',
  `Item_Cup` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '罩杯類型',
  `Pocket_CT` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A09',
  `Item_Pocket` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '口袋需求',
  `Strap_CT` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A10',
  `Item_Strap` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '肩帶類型',
  `Wear_CT` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A11',
  `Item_Wear` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '釦鏈喜好',
  `Pattern_Num` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '版型編號',
  `Work_Qty` int(10) UNSIGNED NOT NULL COMMENT '已派工件數',
  `Adduser` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '建檔人員',
  `Addtime` datetime NOT NULL DEFAULT current_timestamp() COMMENT '建檔時間',
  `Chguser` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '最後修改人員',
  `Chgtime` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '最後修改時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `orderitem`
--

INSERT INTO `orderitem` (`Order_Num`, `Item_Num`, `Design_Num`, `Design_Mate_CT`, `Design_Mate`, `Color_CT`, `Item_Color`, `Item_BgColor`, `Effect_CT`, `Item_Effect`, `Item_Extra`, `Item_EPrice`, `Item_Price`, `Item_Qty`, `Item_PDate`, `Item_Amt`, `Bside_CT`, `Item_Bside`, `Breast_CT`, `Item_Breast`, `Spon_CT`, `Item_Spon`, `Cup_CT`, `Item_Cup`, `Pocket_CT`, `Item_Pocket`, `Strap_CT`, `Item_Strap`, `Wear_CT`, `Item_Wear`, `Pattern_Num`, `Work_Qty`, `Adduser`, `Addtime`, `Chguser`, `Chgtime`) VALUES
('OM0011090700005', '001', '1', 'B01', '004', 'B07', 'B01', 'B02', 'A04', '00A', '5', 6, 2, 2, '0000-00-00', 6, 'A05', '00A', 'A06', '00B', 'A07', '00B', 'A08', '00B', 'A09', '00A', 'A10', '00A', 'A11', '00B', '', 2, 'Admin', '2020-07-28 21:14:27', 'Admin', '2020-08-10 18:57:11'),
('OM0011090700006', '001', '1', 'B01', '004', 'B07', 'B01', 'B02', 'A04', '00A', '5', 16, 500, 2, '2020-08-14', 6, 'A05', '00A', 'A06', '00B', 'A07', '00B', 'A08', '00A', 'A09', '00A', 'A10', '00A', 'A11', '00B', '', 2, 'Admin', '2020-07-28 21:15:34', 'Admin', '2020-08-10 14:25:37'),
('OM0011090700006', '002', 'z', 'B01', '002', 'B07', 'G01', 'B01', 'A04', '00B', 'z', 0, 400, 7, '2020-08-14', 72, 'A05', '00A', 'A06', '00C', 'A07', '00B', 'A08', '00A', 'A09', '00B', 'A10', '00A', 'A11', '00A', '', 1, 'Admin', '2020-07-28 21:15:34', 'Admin', '2020-08-10 14:15:49'),
('OM0011090700007', '001', '5', 'B01', '002', 'B07', 'B01', 'B02', 'A04', '00C', '', 0, 6, 7, '2020-08-12', 42, 'A05', '00B', 'A06', '00A', 'A07', '00A', 'A08', '00B', 'A09', '00B', 'A10', '00A', 'A11', '00B', '', 0, 'Admin', '2020-07-29 00:04:47', 'Admin', '2020-07-29 00:04:47'),
('OM0011090700008', '001', '5', 'B01', '002', 'B07', 'B01', 'B02', 'A04', '00C', '', 0, 6, 7, '2020-08-12', 42, 'A05', '00B', 'A06', '00A', 'A07', '00A', 'A08', '00B', 'A09', '00B', 'A10', '00A', 'A11', '00B', '', 0, 'Admin', '2020-07-29 00:05:29', 'Admin', '2020-07-29 00:05:29'),
('OM0011090800001', '001', 'F20-0003', 'B01', '001', 'B07', 'B01', 'R01', 'A04', '00A', '', 0, 200, 1, '2020-08-31', 200, 'A05', '00A', 'A06', '00C', 'A07', '00B', 'A08', '00A', 'A09', '00B', 'A10', '00A', 'A11', '00A', '', 0, 'Admin', '2020-08-17 14:40:06', 'Admin', '2020-08-17 14:40:06'),
('OM0021090800001', '001', 'F20-0002', 'B01', '001', 'B07', 'G01', 'B01', 'A04', '00D', '', 5000, 500, 1, '2020-08-30', 5500, 'A05', '00A', 'A06', '00C', 'A07', '00A', 'A08', '00B', 'A09', '00A', 'A10', '00B', 'A11', '00B', '', 0, 'E202007005', '2020-08-16 13:42:17', 'E202007005', '2020-08-16 13:47:24'),
('OM0021090800001', '002', 'F20-0003', 'B01', '001', 'B07', 'B01', 'G01', 'A04', '00A', '', 1000, 200, 2, '2020-08-30', 2400, 'A05', '00B', 'A06', '00A', 'A07', '00B', 'A08', '00A', 'A09', '00A', 'A10', '00A', 'A11', '00A', '', 2, 'E202007005', '2020-08-16 13:42:17', 'E202007005', '2020-08-16 14:20:31'),
('OM0021090800002', '001', 'F20-0004', 'B01', '001', 'B07', 'B02', 'R01', 'A04', '00B', 'test', 500, 800, 2, '2020-08-30', 1600, 'A05', '00B', 'A06', '00C', 'A07', '00B', 'A08', '00A', 'A09', '00B', 'A10', '00A', 'A11', '00A', '', 0, 'E202007005', '2020-08-16 13:51:58', 'E202007005', '2020-08-16 13:51:58'),
('OM0021090800002', '002', 'F20-0001', 'B01', '003', 'B07', 'B01', 'G01', 'A04', '00B', 'test', 0, 500, 1, '2020-08-30', 500, 'A05', '00B', 'A06', '00A', 'A07', '00A', 'A08', '00B', 'A09', '00A', 'A10', '00A', 'A11', '00A', '', 0, 'E202007005', '2020-08-16 13:51:58', 'E202007005', '2020-08-16 13:51:58');

-- --------------------------------------------------------

--
-- 資料表結構 `prototype`
--

CREATE TABLE `prototype` (
  `ProtoM_Num` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '原型圖編號',
  `ProtoM_Name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '原型圖名稱',
  `Unit_CT` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'B08',
  `ProtoM_Unit` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '量身單位',
  `ProtoM_Pho` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '圖檔路徑',
  `ProtoM_SW` decimal(7,3) UNSIGNED NOT NULL COMMENT '肩寛',
  `ProtoM_DFS` decimal(7,3) UNSIGNED NOT NULL COMMENT '前胸吊帶距',
  `ProtoM_BH` decimal(7,3) UNSIGNED NOT NULL COMMENT '乳高',
  `ProtoM_BR` decimal(7,3) UNSIGNED NOT NULL COMMENT '乳深',
  `ProtoM_SBW` decimal(7,3) UNSIGNED NOT NULL COMMENT '單乳寬',
  `ProtoM_FBW` decimal(7,3) UNSIGNED NOT NULL COMMENT '前胸寬',
  `ProtoM_UpB` decimal(7,3) UNSIGNED NOT NULL COMMENT '胸上圍',
  `ProtoM_B` decimal(7,3) UNSIGNED NOT NULL COMMENT '胸圍',
  `ProtoM_UdB` decimal(7,3) UNSIGNED NOT NULL COMMENT '胸下圍',
  `ProtoM_ArtoUdB` decimal(7,3) UNSIGNED NOT NULL COMMENT '腋下->胸下',
  `ProtoM_ArtoW` decimal(7,3) UNSIGNED NOT NULL COMMENT '腋下->腰',
  `ProtoM_ArtoT` decimal(7,3) UNSIGNED NOT NULL COMMENT '腋下->大腿',
  `ProtoM_UdBtoW` decimal(7,3) UNSIGNED NOT NULL COMMENT '胸下->腰',
  `ProtoM_UdBtoT` decimal(7,3) UNSIGNED NOT NULL COMMENT '胸下->大腿',
  `ProtoM_W` decimal(7,3) UNSIGNED NOT NULL COMMENT '腰圍',
  `ProtoM_AbH` decimal(7,3) UNSIGNED NOT NULL COMMENT '腹高',
  `ProtoM_Ab` decimal(7,3) UNSIGNED NOT NULL COMMENT '腹圍',
  `ProtoM_UdBtoY` decimal(7,3) UNSIGNED NOT NULL COMMENT '胸下->Y',
  `ProtoM_Hip` decimal(7,3) UNSIGNED NOT NULL COMMENT '臀圍',
  `ProtoM_HL` decimal(7,3) UNSIGNED NOT NULL COMMENT '臀長',
  `ProtoM_WtoT` decimal(7,3) UNSIGNED NOT NULL COMMENT '平口側邊長',
  `ProtoM_OTS` decimal(7,3) UNSIGNED NOT NULL COMMENT '斜大腿圍',
  `ProtoM_BL` decimal(7,3) UNSIGNED NOT NULL COMMENT '背長',
  `ProtoM_BW` decimal(7,3) UNSIGNED NOT NULL COMMENT '背寬',
  `ProtoM_CD` decimal(7,3) UNSIGNED NOT NULL COMMENT '股上長',
  `ProtoM_HLH` decimal(7,3) UNSIGNED NOT NULL COMMENT '提臀高',
  `ProtoM_BHLH` decimal(7,3) UNSIGNED NOT NULL COMMENT '四角提臀高',
  `ProtoM_CL` decimal(7,3) UNSIGNED NOT NULL COMMENT '褲檔長',
  `ProtoM_UdBtoC` decimal(7,3) UNSIGNED NOT NULL COMMENT '總檔長',
  `Adduser` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '建檔人員',
  `Addtime` datetime NOT NULL DEFAULT current_timestamp() COMMENT '建檔時間',
  `Chguser` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '最後修改人員',
  `Chgtime` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '最後修改時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `prototype`
--

INSERT INTO `prototype` (`ProtoM_Num`, `ProtoM_Name`, `Unit_CT`, `ProtoM_Unit`, `ProtoM_Pho`, `ProtoM_SW`, `ProtoM_DFS`, `ProtoM_BH`, `ProtoM_BR`, `ProtoM_SBW`, `ProtoM_FBW`, `ProtoM_UpB`, `ProtoM_B`, `ProtoM_UdB`, `ProtoM_ArtoUdB`, `ProtoM_ArtoW`, `ProtoM_ArtoT`, `ProtoM_UdBtoW`, `ProtoM_UdBtoT`, `ProtoM_W`, `ProtoM_AbH`, `ProtoM_Ab`, `ProtoM_UdBtoY`, `ProtoM_Hip`, `ProtoM_HL`, `ProtoM_WtoT`, `ProtoM_OTS`, `ProtoM_BL`, `ProtoM_BW`, `ProtoM_CD`, `ProtoM_HLH`, `ProtoM_BHLH`, `ProtoM_CL`, `ProtoM_UdBtoC`, `Adduser`, `Addtime`, `Chguser`, `Chgtime`) VALUES
('PM000A_S', '經典款標準身形', 'B08', 'INC', 'path', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', '2020-08-10 19:34:29', '', '2020-08-10 19:54:17');

-- --------------------------------------------------------

--
-- 資料表結構 `purchase`
--

CREATE TABLE `purchase` (
  `Pur_Num` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '進貨單號，PYYYYMM999(P+西元年+月份+流水號3碼)',
  `Pur_Date` date NOT NULL COMMENT '進貨日期',
  `Mate_Num` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用料代碼',
  `Supply_Num` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '供應商代碼',
  `Pur_Price` int(10) UNSIGNED NOT NULL COMMENT '單價',
  `Pur_Qty` int(10) UNSIGNED NOT NULL COMMENT '進貨數量',
  `Pur_Amt` int(10) UNSIGNED NOT NULL COMMENT '總計金額',
  `Adduser` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '建檔人員',
  `Addtime` datetime NOT NULL DEFAULT current_timestamp() COMMENT '建檔時間',
  `Chguser` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '最後修改人員',
  `Chgtime` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '最後修改時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `purchase`
--

INSERT INTO `purchase` (`Pur_Num`, `Pur_Date`, `Mate_Num`, `Supply_Num`, `Pur_Price`, `Pur_Qty`, `Pur_Amt`, `Adduser`, `Addtime`, `Chguser`, `Chgtime`) VALUES
('P202007001', '2020-07-01', 'B04003000001', 'S202007003', 2, 500, 1000, 'Admin', '2020-07-26 09:52:39', 'Admin', '2020-07-26 09:52:39'),
('P202007002', '2020-07-14', 'B01001000002', 'S202007002', 30, 200, 6000, 'Admin', '2020-07-26 10:38:17', 'Admin', '2020-07-26 10:38:17'),
('P202007003', '2020-07-17', 'B01001000004', 'S202007005', 20, 100, 2000, 'Admin', '2020-07-26 10:38:58', 'Admin', '2020-07-26 10:38:58'),
('P202007004', '2020-06-28', 'B04003000001', 'S202007004', 2, 100, 200, 'Admin', '2020-07-26 10:43:54', 'Admin', '2020-07-26 10:43:54'),
('P202007005', '2020-07-26', 'B01002000001', 'S202007001', 50, 25, 1250, 'Admin', '2020-07-26 10:50:39', 'Admin', '2020-07-26 10:50:39'),
('P202007006', '2020-07-22', 'B01001000003', 'S202007002', 50, 250, 12500, 'Admin', '2020-07-26 10:51:55', 'Admin', '2020-07-26 10:51:55'),
('P202007007', '2020-07-20', 'B02001000001', 'S202007001', 25, 20, 500, 'Admin', '2020-07-26 10:53:36', 'Admin', '2020-07-26 10:53:36');

-- --------------------------------------------------------

--
-- 資料表結構 `stock`
--

CREATE TABLE `stock` (
  `Mate_Num` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用料編號',
  `Stk_Date` date NOT NULL COMMENT '庫存日期',
  `Stk_Pre` int(11) NOT NULL COMMENT '前日結餘',
  `Stk_In` int(11) NOT NULL COMMENT '當日進貨',
  `Stk_Out` int(11) NOT NULL COMMENT '當日出庫',
  `Stk_Qty` int(11) NOT NULL COMMENT '當日庫存',
  `Adduser` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '建檔人員',
  `Addtime` datetime NOT NULL DEFAULT current_timestamp() COMMENT '建檔時間',
  `Chguser` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '最後修改人員',
  `Chgtime` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '最後修改時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `stock`
--

INSERT INTO `stock` (`Mate_Num`, `Stk_Date`, `Stk_Pre`, `Stk_In`, `Stk_Out`, `Stk_Qty`, `Adduser`, `Addtime`, `Chguser`, `Chgtime`) VALUES
('B01001000002', '2020-07-14', 0, 200, 0, 200, 'Admin', '2020-07-26 10:38:17', 'Admin', '2020-07-26 10:38:17'),
('B01001000003', '2020-07-22', 0, 250, 0, 250, 'Admin', '2020-07-26 10:51:55', 'Admin', '2020-07-26 10:51:55'),
('B01001000004', '2020-07-17', 0, 100, 0, 100, 'Admin', '2020-07-26 10:38:58', 'Admin', '2020-07-26 10:38:58'),
('B01002000001', '2020-07-26', 0, 25, 0, 25, 'Admin', '2020-07-26 10:50:39', 'Admin', '2020-07-26 10:50:39'),
('B02001000001', '2020-07-20', 0, 20, 0, 20, 'Admin', '2020-07-26 10:53:36', 'Admin', '2020-07-26 10:53:36'),
('B04003000001', '2020-06-28', 0, 100, 0, 100, 'Admin', '2020-07-26 10:43:54', 'Admin', '2020-07-26 10:43:54'),
('B04003000001', '2020-07-01', 100, 500, 0, 600, 'Admin', '2020-07-26 09:52:39', 'Admin', '2020-07-26 10:43:54'),
('B04003000001', '2020-07-26', 600, 0, 0, 600, 'Admin', '2020-07-26 10:40:20', 'Admin', '2020-07-26 10:43:54');

-- --------------------------------------------------------

--
-- 資料表結構 `supply`
--

CREATE TABLE `supply` (
  `Supply_Num` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '供應商編號，SYYYYMM999(S+西元年+月份+流水號3碼)',
  `Supply_Name` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '供應商名稱',
  `Supply_Adrs` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '住址',
  `Supply_Tel` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '市話(市話#分機)',
  `Supply_Mobi` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '手機',
  `Supply_Respon` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '負責人員',
  `Cate_CT` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'B09',
  `Cate` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '供應商類別(SysCodeInfo.CI_NO; NO=B09)',
  `Adduser` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '建檔人員',
  `Addtime` datetime NOT NULL DEFAULT current_timestamp() COMMENT '建檔時間',
  `Chguser` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '最後修改人員',
  `Chgtime` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '最後修改時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `supply`
--

INSERT INTO `supply` (`Supply_Num`, `Supply_Name`, `Supply_Adrs`, `Supply_Tel`, `Supply_Mobi`, `Supply_Respon`, `Cate_CT`, `Cate`, `Adduser`, `Addtime`, `Chguser`, `Chgtime`) VALUES
('S202007003', '成嘉材料行', '台中市大有路1段', '0426599552', '0923456789', '趙六', 'C09', '00B', 'Admin', '2020-07-26 09:45:33', 'Admin', '2020-07-26 09:45:33'),
('S202007004', '台灣材料行', '台中市台灣大道1段', '0423356891', '0911456789', '陳參', 'C09', '00B', 'Admin', '2020-07-26 10:20:01', 'Admin', '2020-07-26 10:20:01'),
('S202007005', '大大整布', '新北', '021111111', '0922987456', '李林', 'C09', '00C', 'Admin', '2020-07-26 10:24:22', 'Admin', '2020-07-26 10:28:40'),
('S202007006', '雲良染布坊', '嘉義市', '0445632155', '0923456000', '張右', 'C09', '00C', 'Admin', '2020-07-26 10:30:27', 'Admin', '2020-07-26 10:30:27');

-- --------------------------------------------------------

--
-- 資料表結構 `syscodeinfo`
--

CREATE TABLE `syscodeinfo` (
  `CT_No` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '代碼類別碼',
  `CI_No` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '系統代碼',
  `CI_Name` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '系統代碼說明',
  `CI_Value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Adduser` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '建檔人員',
  `Addtime` datetime NOT NULL DEFAULT current_timestamp() COMMENT '建檔時間',
  `Chguser` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '最後修改人員',
  `Chgtime` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '最後修改時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `syscodeinfo`
--

INSERT INTO `syscodeinfo` (`CT_No`, `CI_No`, `CI_Name`, `CI_Value`, `Adduser`, `Addtime`, `Chguser`, `Chgtime`) VALUES
('000', '00A', '顧客訂單管理', '', 'SYSTEM', '2020-07-17 18:53:16', 'Admin', '2020-07-17 18:58:29'),
('000', '00B', '用料庫存管理', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('000', '00C', '人事薪資管理', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('000', '00D', '分店管理', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('000', '00E', '打版圖管理', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('000', '00Z', '系統維護', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('001', 'A01', '顧客訂單維護', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('001', 'A02', '顧客基本資料維護', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('001', 'A03', '顧客量身資料維護', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('001', 'A04', '訂單派工維護', '', 'SYSTEM', '2020-07-17 18:53:16', 'Admin', '2020-08-10 01:56:05'),
('001', 'A05', '派工用料維護', '', 'SYSTEM', '2020-07-17 18:53:16', 'Admin', '2020-08-10 01:56:11'),
('001', 'A06', '訂單狀態維護', '', 'Admin', '2020-08-10 01:56:18', 'Admin', '2020-08-10 01:56:18'),
('001', 'B01', '供應商資料維護', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('001', 'B02', '用料品項維護', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('001', 'B03', '用料進貨維護', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('001', 'B04', '用料庫存查詢', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('001', 'C01', '部門資料維護', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('001', 'C02', '員工資料維護', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('001', 'C03', '薪資資料維護', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('001', 'D01', '分店基本資料維護', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('001', 'D02', '分店費用報支維護', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('001', 'E01', '原型圖維護', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('001', 'E02', '客製圖維護', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('001', 'Z01', '系統代碼設定', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('001', 'Z02', '系統作業日誌查詢', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('001', 'Z03', '使用權限設定', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('002', '001', '店員', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('002', '002', '店長', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('002', '003', '經理', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('002', '004', '人事', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('002', '005', '老闆', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('002', '009', '系統管理員', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('003', '001', '查詢', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('003', '002', '新增', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('003', '003', '修改', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('003', '004', '刪除', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('003', '005', '匯出', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('003', '006', '審核', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('A01', '000', '未處理', '', 'Admin', '2020-07-28 20:23:59', 'Admin', '2020-07-28 20:23:59'),
('A01', '001', '製版', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('A01', '002', '裁剪', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('A01', '003', '車縫', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('A01', '004', '完工', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('A01', '005', '理貨', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('A01', '006', '待出貨/取件', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('A01', '007', '已出貨', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('A02', '001', '現金/轉帳/匯款', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('A02', '002', '刷卡', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('A03', '000', '自取', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('A03', '001', '郵寄', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('A04', '00A', '立體罩杯剪裁、加強提臀', '100', 'SYSTEM', '2020-07-17 18:53:16', 'Admin', '2020-08-09 17:13:42'),
('A04', '00B', '包含a；且腹部加壓', '200', 'SYSTEM', '2020-07-17 18:53:16', 'Admin', '2020-08-09 17:13:45'),
('A04', '00C', '包含a、b；且褲底拉鏈', '300', 'SYSTEM', '2020-07-17 18:53:16', 'Admin', '2020-08-09 17:13:47'),
('A04', '00D', '包含a、b、c；且加褲管', '400', 'SYSTEM', '2020-07-17 18:53:16', 'Admin', '2020-08-09 17:13:51'),
('A05', '00A', '要包', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('A05', '00B', '不包', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('A06', '00A', '大深', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('A06', '00B', '小貼', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('A06', '00C', '標準', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('A07', '00A', '需要', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('A07', '00B', '不需要', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('A08', '00A', '全罩', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('A08', '00B', '３／４罩', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('A09', '00A', '需要', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('A09', '00B', '不需要', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('A10', '00A', '寬', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('A10', '00B', '細', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('A11', '00A', '側邊排釦', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('A11', '00B', '置中拉錬（條）', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('A12', '00A', '內部派工', '', 'Admin', '2020-08-09 17:09:25', 'Admin', '2020-08-09 17:09:25'),
('A12', '00B', '委外加工', '', 'Admin', '2020-08-09 17:09:36', 'Admin', '2020-08-09 17:09:36'),
('B01', '001', '蕾絲布', '100', 'SYSTEM', '2020-07-17 18:53:16', 'Admin', '2020-08-09 17:12:54'),
('B01', '002', '絲棉', '200', 'SYSTEM', '2020-07-17 18:53:16', 'Admin', '2020-08-09 17:12:57'),
('B01', '003', '日本棉', '300', 'SYSTEM', '2020-07-17 18:53:16', 'Admin', '2020-08-09 17:12:59'),
('B01', '004', '彈性蕾絲', '400', 'SYSTEM', '2020-07-17 18:53:16', 'Admin', '2020-08-09 17:13:02'),
('B02', '001', '厚', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('B02', '002', '一般', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('B02', '003', '薄', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('B03', '001', '拉鏈款式', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('B04', '001', '鈕釦', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('B04', '002', '扣環', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('B04', '003', '勾勾', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('B05', '001', '肩帶', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('B06', '001', '布邊線', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('B06', '002', '彈性線', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('B06', '003', '一般線', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('B07', 'B01', '黑色', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('B07', 'B02', '藍色', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('B07', 'G01', '綠色', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('B07', 'R01', '紅色', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('B08', 'FT', 'ft. 英呎', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('B08', 'INC', 'in. 英吋', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('B08', 'KG', 'kg.公斤', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('B08', 'PAC', '包', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('B08', 'PCS', '件', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('B08', 'SFT', 'sq. ft 平方英呎', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('B08', 'SYD', 'sq. yd 平方碼', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('B08', 'YD', '碼', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('B09', '00A', '布業', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('B09', '00B', '材料行', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('C01', '00A', '月薪制', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('C01', '00B', '日薪制', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('C01', '00C', '計件制', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('C02', '001', '底薪', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('C02', '002', '職務加給', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('C02', '003', '其它津貼', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('C02', '004', '加工薪給', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('C04', '001', '租金', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('C04', '002', '水電瓦斯', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('C04', '003', '文具用品', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('C04', '004', '雜支', '', 'SYSTEM', '2020-07-17 18:53:16', 'SYSTEM', '2020-07-17 18:55:24'),
('C05', '001', '1級', '', 'Admin', '2020-07-23 23:27:49', 'Admin', '2020-07-23 23:27:49'),
('C05', '002', '2級', '', 'Admin', '2020-07-23 23:27:54', 'Admin', '2020-07-23 23:27:54'),
('C05', '003', '3級', '', 'Admin', '2020-07-23 23:27:58', 'Admin', '2020-07-23 23:27:58');

-- --------------------------------------------------------

--
-- 資料表結構 `syscodetype`
--

CREATE TABLE `syscodetype` (
  `CT_No` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '代碼類別碼',
  `CT_Name` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '代碼類別說明',
  `Adduser` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '建檔人員',
  `Addtime` datetime NOT NULL DEFAULT current_timestamp() COMMENT '建檔時間',
  `Chguser` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '最後修改人員',
  `Chgtime` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '最後修改時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `syscodetype`
--

INSERT INTO `syscodetype` (`CT_No`, `CT_Name`, `Adduser`, `Addtime`, `Chguser`, `Chgtime`) VALUES
('000', '系統主選單', 'SYSTEM', '2020-07-17 18:53:00', 'SYSTEM', '2020-07-17 18:53:00'),
('001', '系統功能', 'SYSTEM', '2020-07-17 18:53:00', 'SYSTEM', '2020-07-17 18:53:00'),
('002', '角色類別', 'SYSTEM', '2020-07-17 18:53:00', 'SYSTEM', '2020-07-17 18:53:00'),
('003', '權限別', 'SYSTEM', '2020-07-17 18:53:00', 'SYSTEM', '2020-07-17 18:53:00'),
('A01', '訂單進度', 'SYSTEM', '2020-07-17 18:53:00', 'SYSTEM', '2020-07-17 18:53:00'),
('A02', '付款方式', 'SYSTEM', '2020-07-17 18:53:00', 'SYSTEM', '2020-07-17 18:53:00'),
('A03', '取貨方式', 'SYSTEM', '2020-07-17 18:53:00', 'SYSTEM', '2020-07-17 18:53:00'),
('A04', '塑身效果', 'SYSTEM', '2020-07-17 18:53:00', 'SYSTEM', '2020-07-17 18:53:00'),
('A05', '乳側處理', 'SYSTEM', '2020-07-17 18:53:00', 'SYSTEM', '2020-07-17 18:53:00'),
('A06', '乳房包覆', 'SYSTEM', '2020-07-17 18:53:00', 'SYSTEM', '2020-07-17 18:53:00'),
('A07', '海綿需求', 'SYSTEM', '2020-07-17 18:53:00', 'SYSTEM', '2020-07-17 18:53:00'),
('A08', '罩杯類型', 'SYSTEM', '2020-07-17 18:53:00', 'SYSTEM', '2020-07-17 18:53:00'),
('A09', '口袋需求', 'SYSTEM', '2020-07-17 18:53:00', 'SYSTEM', '2020-07-17 18:53:00'),
('A10', '肩帶類型', 'SYSTEM', '2020-07-17 18:53:00', 'SYSTEM', '2020-07-17 18:53:00'),
('A11', '釦鏈喜好', 'SYSTEM', '2020-07-17 18:53:00', 'SYSTEM', '2020-07-17 18:53:00'),
('A12', '派工類型', 'Admin', '2020-08-09 17:08:56', 'Admin', '2020-08-09 17:08:56'),
('A13', '材質選擇', 'Admin', '2020-08-16 11:41:37', 'Admin', '2020-08-16 11:41:37'),
('B01', '布料材質', 'SYSTEM', '2020-07-17 18:53:00', 'SYSTEM', '2020-07-17 18:53:00'),
('B02', '胸墊分類', 'SYSTEM', '2020-07-17 18:53:00', 'SYSTEM', '2020-07-17 18:53:00'),
('B03', '拉鏈款式', 'SYSTEM', '2020-07-17 18:53:00', 'SYSTEM', '2020-07-17 18:53:00'),
('B04', '鈕釦配件', 'SYSTEM', '2020-07-17 18:53:00', 'SYSTEM', '2020-07-17 18:53:00'),
('B05', '肩帶', 'SYSTEM', '2020-07-17 18:53:00', 'SYSTEM', '2020-07-17 18:53:00'),
('B06', '車縫線', 'SYSTEM', '2020-07-17 18:53:00', 'SYSTEM', '2020-07-17 18:53:00'),
('B07', '料品顏色', 'SYSTEM', '2020-07-17 18:53:00', 'SYSTEM', '2020-07-17 18:53:00'),
('B08', '單位', 'SYSTEM', '2020-07-17 18:53:00', 'SYSTEM', '2020-07-17 18:53:00'),
('B09', '供應商類別', 'SYSTEM', '2020-07-17 18:53:00', 'SYSTEM', '2020-07-17 18:53:00'),
('C01', '薪資分類', 'SYSTEM', '2020-07-17 18:53:00', 'SYSTEM', '2020-07-17 18:53:00'),
('C02', '薪資科目', 'SYSTEM', '2020-07-17 18:53:00', 'SYSTEM', '2020-07-17 18:53:00'),
('C03', '加工級別', 'SYSTEM', '2020-07-17 18:53:00', 'SYSTEM', '2020-07-17 18:53:00'),
('C04', '費用分類', 'SYSTEM', '2020-07-17 18:53:00', 'SYSTEM', '2020-07-17 18:53:00'),
('C05', '薪資級距', 'Admin', '2020-07-23 23:27:19', 'Admin', '2020-07-23 23:27:19');

-- --------------------------------------------------------

--
-- 資料表結構 `sysoplog`
--

CREATE TABLE `sysoplog` (
  `sl_id` int(10) UNSIGNED NOT NULL COMMENT '自動編碼',
  `Func_CT` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '001',
  `Func_No` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '功能畫面',
  `Op_CT` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT '003',
  `Op_No` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '系統代碼說明',
  `Op_Key` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '關鍵值',
  `Op_Msg` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '訊息',
  `Adduser` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '操作人員',
  `Addtime` datetime NOT NULL DEFAULT current_timestamp() COMMENT '操作時間',
  `Chguser` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '最後修改人員',
  `Chgtime` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '最後修改時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `sysoprole`
--

CREATE TABLE `sysoprole` (
  `Or_No` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '角色代碼',
  `Or_Name` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '角色名稱',
  `Or_CT` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '002',
  `Or_Type` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '角色類別',
  `Adduser` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '建檔人員',
  `Addtime` datetime NOT NULL DEFAULT current_timestamp() COMMENT '建檔時間',
  `Chguser` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '最後修改人員',
  `Chgtime` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '最後修改時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `sysoprole`
--

INSERT INTO `sysoprole` (`Or_No`, `Or_Name`, `Or_CT`, `Or_Type`, `Adduser`, `Addtime`, `Chguser`, `Chgtime`) VALUES
('000', '系統管理員', '002', '009', 'SYSTEM', '2020-07-21 23:10:59', 'Admin', '2020-07-25 14:51:16'),
('111', '中區店員', '002', '001', 'Admin', '2020-07-21 16:34:14', 'E202006001', '2020-08-16 21:18:14'),
('112', '中區店長', '002', '002', 'Admin', '2020-08-16 12:06:44', 'Admin', '2020-08-17 16:05:54'),
('201', '北區店員', '002', '001', 'E202007005', '2020-08-16 14:29:06', 'Admin', '2020-08-17 14:43:54');

-- --------------------------------------------------------

--
-- 資料表結構 `sysoprolebranch`
--

CREATE TABLE `sysoprolebranch` (
  `Or_No` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '角色代碼',
  `Bran_Num` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '可維護門店',
  `Adduser` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '建檔人員',
  `Addtime` datetime NOT NULL DEFAULT current_timestamp() COMMENT '建檔時間',
  `Chguser` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '最後修改人員',
  `Chgtime` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '最後修改時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `sysoprolebranch`
--

INSERT INTO `sysoprolebranch` (`Or_No`, `Bran_Num`, `Adduser`, `Addtime`, `Chguser`, `Chgtime`) VALUES
('111', 'M001', 'E202006001', '2020-08-16 21:18:14', 'E202006001', '2020-08-16 21:18:14'),
('111', 'M002', 'E202006001', '2020-08-16 21:18:14', 'E202006001', '2020-08-16 21:18:14'),
('112', 'M001', 'Admin', '2020-08-17 16:05:54', 'Admin', '2020-08-17 16:05:54'),
('112', 'M002', 'Admin', '2020-08-17 16:05:54', 'Admin', '2020-08-17 16:05:54'),
('201', 'N01', 'Admin', '2020-08-17 14:43:54', 'Admin', '2020-08-17 14:43:54');

-- --------------------------------------------------------

--
-- 資料表結構 `sysoprolefunc`
--

CREATE TABLE `sysoprolefunc` (
  `Or_No` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '角色代碼',
  `Func_CT` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '001',
  `Func_No` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '功能代碼',
  `Right_CT` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '003',
  `Func_Right` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '功能權限',
  `Adduser` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '建檔人員',
  `Addtime` datetime NOT NULL DEFAULT current_timestamp() COMMENT '建檔時間',
  `Chguser` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '最後修改人員',
  `Chgtime` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '最後修改時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `sysoprolefunc`
--

INSERT INTO `sysoprolefunc` (`Or_No`, `Func_CT`, `Func_No`, `Right_CT`, `Func_Right`, `Adduser`, `Addtime`, `Chguser`, `Chgtime`) VALUES
('111', '001', 'A01', '003', '003', 'E202006001', '2020-08-16 21:18:14', 'E202006001', '2020-08-16 21:18:14'),
('111', '001', 'A02', '003', '004', 'E202006001', '2020-08-16 21:18:14', 'E202006001', '2020-08-16 21:18:14'),
('111', '001', 'A03', '003', '004', 'E202006001', '2020-08-16 21:18:14', 'E202006001', '2020-08-16 21:18:14'),
('111', '001', 'A04', '003', '001', 'E202006001', '2020-08-16 21:18:14', 'E202006001', '2020-08-16 21:18:14'),
('111', '001', 'A05', '003', '001', 'E202006001', '2020-08-16 21:18:14', 'E202006001', '2020-08-16 21:18:14'),
('111', '001', 'A06', '003', '003', 'E202006001', '2020-08-16 21:18:14', 'E202006001', '2020-08-16 21:18:14'),
('111', '001', 'B01', '003', '003', 'E202006001', '2020-08-16 21:18:14', 'E202006001', '2020-08-16 21:18:14'),
('111', '001', 'B02', '003', '004', 'E202006001', '2020-08-16 21:18:14', 'E202006001', '2020-08-16 21:18:14'),
('111', '001', 'B03', '003', '004', 'E202006001', '2020-08-16 21:18:14', 'E202006001', '2020-08-16 21:18:14'),
('111', '001', 'B04', '003', '001', 'E202006001', '2020-08-16 21:18:14', 'E202006001', '2020-08-16 21:18:14'),
('111', '001', 'C01', '003', '001', 'E202006001', '2020-08-16 21:18:14', 'E202006001', '2020-08-16 21:18:14'),
('111', '001', 'C02', '003', '001', 'E202006001', '2020-08-16 21:18:14', 'E202006001', '2020-08-16 21:18:14'),
('111', '001', 'C03', '003', '001', 'E202006001', '2020-08-16 21:18:14', 'E202006001', '2020-08-16 21:18:14'),
('111', '001', 'D01', '003', '003', 'E202006001', '2020-08-16 21:18:14', 'E202006001', '2020-08-16 21:18:14'),
('111', '001', 'D02', '003', '004', 'E202006001', '2020-08-16 21:18:14', 'E202006001', '2020-08-16 21:18:14'),
('112', '001', 'A01', '003', '003', 'Admin', '2020-08-17 16:05:54', 'Admin', '2020-08-17 16:05:54'),
('112', '001', 'A02', '003', '003', 'Admin', '2020-08-17 16:05:54', 'Admin', '2020-08-17 16:05:54'),
('112', '001', 'A03', '003', '003', 'Admin', '2020-08-17 16:05:54', 'Admin', '2020-08-17 16:05:54'),
('112', '001', 'A04', '003', '003', 'Admin', '2020-08-17 16:05:54', 'Admin', '2020-08-17 16:05:54'),
('112', '001', 'A05', '003', '003', 'Admin', '2020-08-17 16:05:54', 'Admin', '2020-08-17 16:05:54'),
('112', '001', 'A06', '003', '003', 'Admin', '2020-08-17 16:05:54', 'Admin', '2020-08-17 16:05:54'),
('112', '001', 'C02', '003', '003', 'Admin', '2020-08-17 16:05:54', 'Admin', '2020-08-17 16:05:54'),
('112', '001', 'C03', '003', '003', 'Admin', '2020-08-17 16:05:54', 'Admin', '2020-08-17 16:05:54'),
('112', '001', 'D01', '003', '004', 'Admin', '2020-08-17 16:05:54', 'Admin', '2020-08-17 16:05:54'),
('112', '001', 'D02', '003', '004', 'Admin', '2020-08-17 16:05:54', 'Admin', '2020-08-17 16:05:54'),
('201', '001', 'A01', '003', '004', 'Admin', '2020-08-17 14:43:54', 'Admin', '2020-08-17 14:43:54'),
('201', '001', 'A02', '003', '004', 'Admin', '2020-08-17 14:43:54', 'Admin', '2020-08-17 14:43:54'),
('201', '001', 'A03', '003', '004', 'Admin', '2020-08-17 14:43:54', 'Admin', '2020-08-17 14:43:54'),
('201', '001', 'A06', '003', '001', 'Admin', '2020-08-17 14:43:54', 'Admin', '2020-08-17 14:43:54'),
('201', '001', 'B01', '003', '001', 'Admin', '2020-08-17 14:43:54', 'Admin', '2020-08-17 14:43:54'),
('201', '001', 'Z03', '003', '001', 'Admin', '2020-08-17 14:43:54', 'Admin', '2020-08-17 14:43:54');

-- --------------------------------------------------------

--
-- 資料表結構 `working`
--

CREATE TABLE `working` (
  `Work_Num` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '派工單號',
  `Work_Date` date NOT NULL COMMENT '派工日期',
  `Type_CT` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A12',
  `Work_Type` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '派工類型',
  `Order_Num` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '訂單編號',
  `Item_Num` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '訂單品項',
  `Sour_Po` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '來源進料單',
  `Dest_Po` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '目的進料單',
  `Work_Qty` int(10) UNSIGNED NOT NULL COMMENT '加工件數',
  `Plan_Arrive` date NOT NULL COMMENT '預定到貨日',
  `Work_Emp` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '加工人員',
  `Work_Price` int(10) UNSIGNED NOT NULL COMMENT '加工單價',
  `Work_Memo` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '加工備註',
  `ProtoM_Num` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '原型圖編號',
  `Cust_Num` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '客製圖編號',
  `Work_Status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '完工狀態',
  `Okay_Date` date NOT NULL COMMENT '租約注意事項',
  `Adduser` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '建檔人員',
  `Addtime` datetime NOT NULL DEFAULT current_timestamp() COMMENT '建檔時間',
  `Chguser` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '最後修改人員',
  `Chgtime` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '最後修改時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `working`
--

INSERT INTO `working` (`Work_Num`, `Work_Date`, `Type_CT`, `Work_Type`, `Order_Num`, `Item_Num`, `Sour_Po`, `Dest_Po`, `Work_Qty`, `Plan_Arrive`, `Work_Emp`, `Work_Price`, `Work_Memo`, `ProtoM_Num`, `Cust_Num`, `Work_Status`, `Okay_Date`, `Adduser`, `Addtime`, `Chguser`, `Chgtime`) VALUES
('W20200809001', '2020-08-09', 'A12', '00A', 'OM0011090700006', '002', NULL, NULL, 1, '2020-08-05', 'E202007003', 10, 'x', NULL, NULL, 1, '2020-08-10', '', '2020-08-09 23:33:54', '', '2020-08-10 21:09:13'),
('W20200810001', '2020-08-10', 'A12', '00A', 'OM0011090700006', '001', NULL, NULL, 2, '2020-08-05', 'E202007004', 10, 'zzz', NULL, NULL, 0, '0000-00-00', '', '2020-08-10 14:25:37', '', '2020-08-10 18:07:38'),
('W20200810002', '2020-08-10', 'A12', '00A', 'OM0011090700005', '001', NULL, NULL, 2, '2020-07-29', 'E202006001', 5, '', NULL, NULL, 0, '0000-00-00', '', '2020-08-10 18:57:11', '', '2020-08-10 18:57:11'),
('W20200816001', '2020-08-16', 'A12', '00B', '', '', 'P202007002', 'P202007003', 0, '0000-00-00', '', 0, '', NULL, NULL, 1, '2020-08-16', '', '2020-08-16 10:22:14', '', '2020-08-16 10:22:26'),
('W20200816002', '2020-08-16', 'A12', '00A', 'OM0021090800001', '002', NULL, NULL, 1, '2020-08-22', 'E202008001', 300, '', NULL, NULL, 0, '0000-00-00', '', '2020-08-16 14:19:21', '', '2020-08-16 14:19:21'),
('W20200816003', '2020-08-16', 'A12', '00A', 'OM0021090800001', '002', NULL, NULL, 1, '2020-08-30', 'E202008001', 300, '', NULL, NULL, 0, '0000-00-00', '', '2020-08-16 14:20:31', '', '2020-08-16 14:20:31');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`Bran_Num`);

--
-- 資料表索引 `branchexpenditure`
--
ALTER TABLE `branchexpenditure`
  ADD PRIMARY KEY (`EB_Id`),
  ADD KEY `Bran_Num` (`Bran_Num`),
  ADD KEY `EB_CT` (`EB_CT`,`EB_Cate`);

--
-- 資料表索引 `custmeasure`
--
ALTER TABLE `custmeasure`
  ADD PRIMARY KEY (`Cust_Num`,`BodyM_Date`) USING BTREE,
  ADD KEY `Unit_CT` (`Unit_CT`,`BodyM_Unit`);

--
-- 資料表索引 `custom`
--
ALTER TABLE `custom`
  ADD PRIMARY KEY (`Cust_Num`),
  ADD KEY `custom_ibfk_1` (`Order_Num`,`Item_Num`),
  ADD KEY `ProtoM_Num` (`ProtoM_Num`);

--
-- 資料表索引 `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`Cust_Num`),
  ADD KEY `Cust_Tel` (`Cust_Tel`),
  ADD KEY `Cust_Mobile` (`Cust_Mobile`),
  ADD KEY `Bran_Num` (`Bran_Num`);

--
-- 資料表索引 `custorder`
--
ALTER TABLE `custorder`
  ADD PRIMARY KEY (`Order_Num`),
  ADD KEY `Cust_Num` (`Cust_Num`),
  ADD KEY `DeliveryWay_CT` (`DeliveryWay_CT`,`DeliveryWay`),
  ADD KEY `OrderStatus_CT` (`OrderStatus_CT`,`OrderStatus`),
  ADD KEY `Bran_Num` (`Bran_Num`),
  ADD KEY `Cust_Num_2` (`Cust_Num`,`BodyM_Date`);

--
-- 資料表索引 `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`Dep_Num`),
  ADD KEY `Dep_Supr` (`Dep_Supr`);

--
-- 資料表索引 `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`Emp_Num`),
  ADD KEY `Level_CT` (`Level_CT`,`Emp_Level`),
  ADD KEY `Bran_Num` (`Bran_Num`),
  ADD KEY `Dep_Num` (`Dep_Num`),
  ADD KEY `Emp_Role` (`Emp_Role`);

--
-- 資料表索引 `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`Mate_Num`),
  ADD KEY `index` (`CT_No`,`CI_No`,`Mate_Color`) USING BTREE,
  ADD KEY `Color_CT` (`Color_CT`,`Mate_Color`),
  ADD KEY `Unit_CT` (`Unit_CT`,`Mate_Unit`),
  ADD KEY `Supply_Num` (`Supply_Num`);

--
-- 資料表索引 `mateusa`
--
ALTER TABLE `mateusa`
  ADD PRIMARY KEY (`WU_Num`,`WU_Item`) USING BTREE,
  ADD KEY `mateusa_ibfk_1` (`Work_Num`),
  ADD KEY `Mate_Num` (`Mate_Num`);

--
-- 資料表索引 `orderitem`
--
ALTER TABLE `orderitem`
  ADD PRIMARY KEY (`Order_Num`,`Item_Num`) USING BTREE,
  ADD KEY `Design_Mate_CT` (`Design_Mate_CT`,`Design_Mate`),
  ADD KEY `Color_CT` (`Color_CT`,`Item_Color`),
  ADD KEY `Color_CT_2` (`Color_CT`,`Item_BgColor`),
  ADD KEY `Effect_CT` (`Effect_CT`,`Item_Effect`),
  ADD KEY `Bside_CT` (`Bside_CT`,`Item_Bside`),
  ADD KEY `Breast_CT` (`Breast_CT`,`Item_Breast`),
  ADD KEY `Spon_CT` (`Spon_CT`,`Item_Spon`),
  ADD KEY `Cup_CT` (`Cup_CT`,`Item_Cup`),
  ADD KEY `Pocket_CT` (`Pocket_CT`,`Item_Pocket`),
  ADD KEY `Strap_CT` (`Strap_CT`,`Item_Strap`),
  ADD KEY `Wear_CT` (`Wear_CT`,`Item_Wear`);

--
-- 資料表索引 `prototype`
--
ALTER TABLE `prototype`
  ADD PRIMARY KEY (`ProtoM_Num`),
  ADD KEY `Unit_CT` (`Unit_CT`,`ProtoM_Unit`);

--
-- 資料表索引 `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`Pur_Num`);

--
-- 資料表索引 `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`Mate_Num`,`Stk_Date`) USING BTREE;

--
-- 資料表索引 `supply`
--
ALTER TABLE `supply`
  ADD PRIMARY KEY (`Supply_Num`),
  ADD KEY `Cate_CT` (`Cate_CT`,`Cate`);

--
-- 資料表索引 `syscodeinfo`
--
ALTER TABLE `syscodeinfo`
  ADD PRIMARY KEY (`CT_No`,`CI_No`);

--
-- 資料表索引 `syscodetype`
--
ALTER TABLE `syscodetype`
  ADD PRIMARY KEY (`CT_No`);

--
-- 資料表索引 `sysoplog`
--
ALTER TABLE `sysoplog`
  ADD PRIMARY KEY (`sl_id`),
  ADD KEY `Op_CT` (`Op_CT`,`Op_No`),
  ADD KEY `Func_CT` (`Func_CT`,`Func_No`);

--
-- 資料表索引 `sysoprole`
--
ALTER TABLE `sysoprole`
  ADD PRIMARY KEY (`Or_No`),
  ADD KEY `Or_CT` (`Or_CT`,`Or_Type`);

--
-- 資料表索引 `sysoprolebranch`
--
ALTER TABLE `sysoprolebranch`
  ADD PRIMARY KEY (`Or_No`,`Bran_Num`),
  ADD KEY `Bran_Num` (`Bran_Num`);

--
-- 資料表索引 `sysoprolefunc`
--
ALTER TABLE `sysoprolefunc`
  ADD PRIMARY KEY (`Or_No`,`Func_No`) USING BTREE,
  ADD KEY `Or_No` (`Or_No`),
  ADD KEY `Right_CT` (`Right_CT`,`Func_Right`),
  ADD KEY `Func_CT` (`Func_CT`,`Func_No`);

--
-- 資料表索引 `working`
--
ALTER TABLE `working`
  ADD PRIMARY KEY (`Work_Num`),
  ADD KEY `Type_CT` (`Type_CT`,`Work_Type`),
  ADD KEY `ProtoM_Num` (`ProtoM_Num`),
  ADD KEY `Cust_Num` (`Cust_Num`),
  ADD KEY `Sour_Po` (`Sour_Po`),
  ADD KEY `Dest_Po` (`Dest_Po`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `branchexpenditure`
--
ALTER TABLE `branchexpenditure`
  MODIFY `EB_Id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自動編號', AUTO_INCREMENT=10;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `sysoplog`
--
ALTER TABLE `sysoplog`
  MODIFY `sl_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自動編碼', AUTO_INCREMENT=35;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `branchexpenditure`
--
ALTER TABLE `branchexpenditure`
  ADD CONSTRAINT `branchexpenditure_ibfk_1` FOREIGN KEY (`Bran_Num`) REFERENCES `branch` (`Bran_Num`),
  ADD CONSTRAINT `branchexpenditure_ibfk_2` FOREIGN KEY (`EB_CT`,`EB_Cate`) REFERENCES `syscodeinfo` (`CT_No`, `CI_No`);

--
-- 資料表的限制式 `custmeasure`
--
ALTER TABLE `custmeasure`
  ADD CONSTRAINT `custmeasure_ibfk_1` FOREIGN KEY (`Unit_CT`,`BodyM_Unit`) REFERENCES `syscodeinfo` (`CT_No`, `CI_No`);

--
-- 資料表的限制式 `custom`
--
ALTER TABLE `custom`
  ADD CONSTRAINT `custom_ibfk_1` FOREIGN KEY (`Order_Num`,`Item_Num`) REFERENCES `orderitem` (`Order_Num`, `Item_Num`),
  ADD CONSTRAINT `custom_ibfk_2` FOREIGN KEY (`ProtoM_Num`) REFERENCES `prototype` (`ProtoM_Num`);

--
-- 資料表的限制式 `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`Bran_Num`) REFERENCES `branch` (`Bran_Num`);

--
-- 資料表的限制式 `custorder`
--
ALTER TABLE `custorder`
  ADD CONSTRAINT `custorder_ibfk_1` FOREIGN KEY (`Cust_Num`) REFERENCES `customer` (`Cust_Num`),
  ADD CONSTRAINT `custorder_ibfk_2` FOREIGN KEY (`DeliveryWay_CT`,`DeliveryWay`) REFERENCES `syscodeinfo` (`CT_No`, `CI_No`),
  ADD CONSTRAINT `custorder_ibfk_3` FOREIGN KEY (`OrderStatus_CT`,`OrderStatus`) REFERENCES `syscodeinfo` (`CT_No`, `CI_No`),
  ADD CONSTRAINT `custorder_ibfk_4` FOREIGN KEY (`Bran_Num`) REFERENCES `branch` (`Bran_Num`),
  ADD CONSTRAINT `custorder_ibfk_5` FOREIGN KEY (`Cust_Num`,`BodyM_Date`) REFERENCES `custmeasure` (`Cust_Num`, `BodyM_Date`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 資料表的限制式 `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `department_ibfk_1` FOREIGN KEY (`Dep_Supr`) REFERENCES `employee` (`Emp_Num`);

--
-- 資料表的限制式 `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`Level_CT`,`Emp_Level`) REFERENCES `syscodeinfo` (`CT_No`, `CI_No`),
  ADD CONSTRAINT `employee_ibfk_2` FOREIGN KEY (`Bran_Num`) REFERENCES `branch` (`Bran_Num`),
  ADD CONSTRAINT `employee_ibfk_3` FOREIGN KEY (`Dep_Num`) REFERENCES `department` (`Dep_Num`),
  ADD CONSTRAINT `employee_ibfk_4` FOREIGN KEY (`Emp_Role`) REFERENCES `sysoprole` (`Or_No`);

--
-- 資料表的限制式 `material`
--
ALTER TABLE `material`
  ADD CONSTRAINT `material_ibfk_1` FOREIGN KEY (`CT_No`,`CI_No`) REFERENCES `syscodeinfo` (`CT_No`, `CI_No`),
  ADD CONSTRAINT `material_ibfk_2` FOREIGN KEY (`Color_CT`,`Mate_Color`) REFERENCES `syscodeinfo` (`CT_No`, `CI_No`),
  ADD CONSTRAINT `material_ibfk_3` FOREIGN KEY (`Unit_CT`,`Mate_Unit`) REFERENCES `syscodeinfo` (`CT_No`, `CI_No`),
  ADD CONSTRAINT `material_ibfk_4` FOREIGN KEY (`Supply_Num`) REFERENCES `supply` (`Supply_Num`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 資料表的限制式 `mateusa`
--
ALTER TABLE `mateusa`
  ADD CONSTRAINT `mateusa_ibfk_1` FOREIGN KEY (`Work_Num`) REFERENCES `working` (`Work_Num`),
  ADD CONSTRAINT `mateusa_ibfk_2` FOREIGN KEY (`Mate_Num`) REFERENCES `material` (`Mate_Num`);

--
-- 資料表的限制式 `orderitem`
--
ALTER TABLE `orderitem`
  ADD CONSTRAINT `orderitem_ibfk_1` FOREIGN KEY (`Design_Mate_CT`,`Design_Mate`) REFERENCES `syscodeinfo` (`CT_No`, `CI_No`),
  ADD CONSTRAINT `orderitem_ibfk_10` FOREIGN KEY (`Cup_CT`,`Item_Cup`) REFERENCES `syscodeinfo` (`CT_No`, `CI_No`),
  ADD CONSTRAINT `orderitem_ibfk_11` FOREIGN KEY (`Pocket_CT`,`Item_Pocket`) REFERENCES `syscodeinfo` (`CT_No`, `CI_No`),
  ADD CONSTRAINT `orderitem_ibfk_12` FOREIGN KEY (`Strap_CT`,`Item_Strap`) REFERENCES `syscodeinfo` (`CT_No`, `CI_No`),
  ADD CONSTRAINT `orderitem_ibfk_13` FOREIGN KEY (`Wear_CT`,`Item_Wear`) REFERENCES `syscodeinfo` (`CT_No`, `CI_No`),
  ADD CONSTRAINT `orderitem_ibfk_2` FOREIGN KEY (`Color_CT`,`Item_Color`) REFERENCES `syscodeinfo` (`CT_No`, `CI_No`),
  ADD CONSTRAINT `orderitem_ibfk_3` FOREIGN KEY (`Color_CT`,`Item_BgColor`) REFERENCES `syscodeinfo` (`CT_No`, `CI_No`),
  ADD CONSTRAINT `orderitem_ibfk_4` FOREIGN KEY (`Color_CT`,`Item_Color`) REFERENCES `syscodeinfo` (`CT_No`, `CI_No`),
  ADD CONSTRAINT `orderitem_ibfk_5` FOREIGN KEY (`Color_CT`,`Item_BgColor`) REFERENCES `syscodeinfo` (`CT_No`, `CI_No`),
  ADD CONSTRAINT `orderitem_ibfk_6` FOREIGN KEY (`Effect_CT`,`Item_Effect`) REFERENCES `syscodeinfo` (`CT_No`, `CI_No`),
  ADD CONSTRAINT `orderitem_ibfk_7` FOREIGN KEY (`Bside_CT`,`Item_Bside`) REFERENCES `syscodeinfo` (`CT_No`, `CI_No`),
  ADD CONSTRAINT `orderitem_ibfk_8` FOREIGN KEY (`Breast_CT`,`Item_Breast`) REFERENCES `syscodeinfo` (`CT_No`, `CI_No`),
  ADD CONSTRAINT `orderitem_ibfk_9` FOREIGN KEY (`Spon_CT`,`Item_Spon`) REFERENCES `syscodeinfo` (`CT_No`, `CI_No`);

--
-- 資料表的限制式 `prototype`
--
ALTER TABLE `prototype`
  ADD CONSTRAINT `prototype_ibfk_1` FOREIGN KEY (`Unit_CT`,`ProtoM_Unit`) REFERENCES `syscodeinfo` (`CT_No`, `CI_No`);

--
-- 資料表的限制式 `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`Mate_Num`) REFERENCES `material` (`Mate_Num`);

--
-- 資料表的限制式 `supply`
--
ALTER TABLE `supply`
  ADD CONSTRAINT `supply_ibfk_1` FOREIGN KEY (`Cate_CT`,`Cate`) REFERENCES `syscodeinfo` (`CT_No`, `CI_No`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 資料表的限制式 `syscodeinfo`
--
ALTER TABLE `syscodeinfo`
  ADD CONSTRAINT `syscodeinfo_ibfk_1` FOREIGN KEY (`CT_No`) REFERENCES `syscodetype` (`CT_No`);

--
-- 資料表的限制式 `sysoplog`
--
ALTER TABLE `sysoplog`
  ADD CONSTRAINT `sysoplog_ibfk_1` FOREIGN KEY (`Op_CT`,`Op_No`) REFERENCES `syscodeinfo` (`CT_No`, `CI_No`),
  ADD CONSTRAINT `sysoplog_ibfk_2` FOREIGN KEY (`Func_CT`,`Func_No`) REFERENCES `syscodeinfo` (`CT_No`, `CI_No`);

--
-- 資料表的限制式 `sysoprole`
--
ALTER TABLE `sysoprole`
  ADD CONSTRAINT `sysoprole_ibfk_1` FOREIGN KEY (`Or_CT`,`Or_Type`) REFERENCES `syscodeinfo` (`CT_No`, `CI_No`);

--
-- 資料表的限制式 `sysoprolebranch`
--
ALTER TABLE `sysoprolebranch`
  ADD CONSTRAINT `sysoprolebranch_ibfk_1` FOREIGN KEY (`Or_No`) REFERENCES `sysoprole` (`Or_No`),
  ADD CONSTRAINT `sysoprolebranch_ibfk_2` FOREIGN KEY (`Bran_Num`) REFERENCES `branch` (`Bran_Num`);

--
-- 資料表的限制式 `sysoprolefunc`
--
ALTER TABLE `sysoprolefunc`
  ADD CONSTRAINT `sysoprolefunc_ibfk_1` FOREIGN KEY (`Right_CT`,`Func_Right`) REFERENCES `syscodeinfo` (`CT_No`, `CI_No`),
  ADD CONSTRAINT `sysoprolefunc_ibfk_2` FOREIGN KEY (`Or_No`) REFERENCES `sysoprole` (`Or_No`),
  ADD CONSTRAINT `sysoprolefunc_ibfk_3` FOREIGN KEY (`Func_CT`,`Func_No`) REFERENCES `syscodeinfo` (`CT_No`, `CI_No`);

--
-- 資料表的限制式 `working`
--
ALTER TABLE `working`
  ADD CONSTRAINT `working_ibfk_1` FOREIGN KEY (`Type_CT`,`Work_Type`) REFERENCES `syscodeinfo` (`CT_No`, `CI_No`),
  ADD CONSTRAINT `working_ibfk_2` FOREIGN KEY (`ProtoM_Num`) REFERENCES `prototype` (`ProtoM_Num`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `working_ibfk_3` FOREIGN KEY (`Cust_Num`) REFERENCES `custom` (`Cust_Num`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `working_ibfk_4` FOREIGN KEY (`Sour_Po`) REFERENCES `purchase` (`Pur_Num`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `working_ibfk_5` FOREIGN KEY (`Dest_Po`) REFERENCES `purchase` (`Pur_Num`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
