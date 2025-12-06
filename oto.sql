-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th12 01, 2025 lúc 09:55 AM
-- Phiên bản máy phục vụ: 8.0.17
-- Phiên bản PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `oto`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitiethoadon`
--

CREATE TABLE `chitiethoadon` (
  `ID_BILL` int(11) NOT NULL,
  `ID_Product` int(11) NOT NULL,
  `Quantiny` int(11) NOT NULL,
  `Price` decimal(10,0) NOT NULL,
  `TotalPrice` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `chitiethoadon`
--

INSERT INTO `chitiethoadon` (`ID_BILL`, `ID_Product`, `Quantiny`, `Price`, `TotalPrice`) VALUES
(1, 1, 1, '458000000', '458000000'),
(2, 1, 1, '458000000', '458000000'),
(3, 1, 1, '4999000000', '4999000000'),
(4, 1, 4, '458000000', '1832000000'),
(5, 1, 4, '725000000', '2900000000'),
(6, 1, 1, '9999999999', '9999999999');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dangkilaithe`
--

CREATE TABLE `dangkilaithe` (
  `id` int(11) NOT NULL,
  `hoten` varchar(100) COLLATE utf8_vietnamese_ci NOT NULL,
  `sdt` varchar(20) COLLATE utf8_vietnamese_ci NOT NULL,
  `tenxe` varchar(100) COLLATE utf8_vietnamese_ci NOT NULL,
  `ghichu` text COLLATE utf8_vietnamese_ci,
  `ngaydangky` datetime DEFAULT CURRENT_TIMESTAMP,
  `ngay` date NOT NULL,
  `gio` varchar(10) COLLATE utf8_vietnamese_ci NOT NULL,
  `diachi` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `dangkilaithe`
--

INSERT INTO `dangkilaithe` (`id`, `hoten`, `sdt`, `tenxe`, `ghichu`, `ngaydangky`, `ngay`, `gio`, `diachi`) VALUES
(112, 'phuc', '0364778365', 'Mercedes-AMG G-Class', 'nj', '2025-11-17 19:31:05', '2025-11-17', '09:00', '120 Trần Hưng Đạo, Sóc Trăng, Tp Cần Thơ'),
(113, 'jun', '0378556376', 'Ford Ranger Raptor X', 'cr', '2025-11-17 22:45:35', '2025-11-19', '14:00', '164 Lê Hồng Phong, Sóc Trăng, Tp Cần Thơ'),
(114, 'bapbietbay', '0374877455', 'EQS SUV', 'dhcv', '2025-11-17 22:46:41', '2025-11-14', '11:00', '120 Trần Hưng Đạo, Sóc Trăng, Tp Cần Thơ'),
(115, 'hin', '0382766381', 'WIGO G', 'dfew', '2025-11-17 22:47:22', '2025-11-29', '15:00', '120 Trần Hưng Đạo, Sóc Trăng, Tp Cần Thơ'),
(116, 'cristina', '0333746463', 'CAMRY 2.0Q', 'jve', '2025-11-17 22:48:31', '2025-11-26', '10:00', '164 Lê Hồng Phong, Sóc Trăng, Tp Cần Thơ'),
(117, 'thinN', '0947558236', 'COROLLA ALTIS 1.8G', 'fri', '2025-11-17 22:49:28', '2025-11-18', '13:00', '120 Trần Hưng Đạo, Sóc Trăng, Tp Cần Thơ'),
(118, 'hin', '0382766381', 'COROLLA ALTIS 1.8G', 'uhg', '2025-11-20 03:43:12', '2025-11-21', '11:00', '164 Lê Hồng Phong, Sóc Trăng, Tp Cần Thơ'),
(119, 'jun', '0382766381', 'CAMRY 2.0Q', 'sdfv', '2025-11-20 04:52:28', '2025-11-28', '13:00', '164 Lê Hồng Phong, Sóc Trăng, Tp Cần Thơ'),
(120, 'jun', '0382766381', 'COROLLA ALTIS 1.8G', '', '2025-11-20 04:55:41', '2025-11-28', '11:00', '120 Trần Hưng Đạo, Sóc Trăng, Tp Cần Thơ'),
(121, 'jun', '0382766381', 'YARIS CROSS', 'XQ', '2025-11-20 05:01:10', '2025-12-06', '14:00', '164 Lê Hồng Phong, Sóc Trăng, Tp Cần Thơ'),
(122, 'jun', '0382766381', 'MERCEDES-BENZ GLE', '', '2025-11-20 05:28:19', '2025-11-28', '14:00', '164 Lê Hồng Phong, Sóc Trăng, Tp Cần Thơ'),
(123, 'hin', '0382766381', 'RANGER RAPTOR', '', '2025-11-20 05:33:10', '2025-11-20', '14:00', '120 Trần Hưng Đạo, Sóc Trăng, Tp Cần Thơ'),
(124, 'jun', '0382766381', 'RANGER RAPTOR', '', '2025-11-20 05:37:00', '2025-11-23', '11:00', '120 Trần Hưng Đạo, Sóc Trăng, Tp Cần Thơ'),
(125, 'jun', '0364778365', 'RANGER RAPTOR', '', '2025-11-20 05:43:05', '2025-11-28', '11:00', '120 Trần Hưng Đạo, Sóc Trăng, Tp Cần Thơ'),
(126, 'jun', '0382766383', 'RANGER RAPTOR', '', '2025-11-20 05:43:44', '2025-11-29', '10:00', '120 Trần Hưng Đạo, Sóc Trăng, Tp Cần Thơ'),
(127, 'jun', '0382766381', 'HILUX 2.4L 4X4 MT', 'qưd', '2025-11-21 03:05:07', '2025-11-22', '11:00', '164 Lê Hồng Phong, Sóc Trăng, Tp Cần Thơ'),
(128, 'thin', '0382766381', 'WIGO G', 'sx', '2025-11-21 03:36:50', '2025-11-29', '11:00', '164 Lê Hồng Phong, Sóc Trăng, Tp Cần Thơ'),
(129, 'hin', '0382766381', 'RANGER RAPTOR', '', '2025-11-22 22:01:07', '2025-11-23', '10:00', '120 Trần Hưng Đạo, Sóc Trăng, Tp Cần Thơ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giohang`
--

CREATE TABLE `giohang` (
  `MaGioHang` int(100) NOT NULL,
  `MaKH` int(11) NOT NULL,
  `ID` int(100) NOT NULL,
  `MaSP` int(100) NOT NULL,
  `SoLuong` int(255) NOT NULL,
  `NgayCapNhat` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `giohang`
--

INSERT INTO `giohang` (`MaGioHang`, `MaKH`, `ID`, `MaSP`, `SoLuong`, `NgayCapNhat`) VALUES
(16, 0, 2, 10, 1, '0000-00-00 00:00:00'),
(24, 32, 0, 10, 1, '2025-11-22 10:10:20'),
(25, 18, 0, 10, 1, '2025-11-22 21:54:01'),
(26, 18, 0, 2, 4, '2025-11-22 22:01:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoadon`
--

CREATE TABLE `hoadon` (
  `ID` int(11) NOT NULL,
  `Name` varchar(500) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `Phone` varchar(50) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `Address` varchar(1000) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `DateReceive` date NOT NULL,
  `TimeReceive` time NOT NULL,
  `Method` varchar(500) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `Status` int(20) NOT NULL,
  `TotalPrice` decimal(10,0) NOT NULL,
  `DateCreate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `hoadon`
--

INSERT INTO `hoadon` (`ID`, `Name`, `Phone`, `Address`, `DateReceive`, `TimeReceive`, `Method`, `Status`, `TotalPrice`, `DateCreate`) VALUES
(1, 'admin', '0382766381', 'uihuh', '2025-10-21', '13:18:29', 'Chuyển khoản ngân hàng', 1, '458030000', '2025-10-21'),
(3, 'admin', '0382766381', '123 lhp, pst, tp can tho', '2025-10-22', '09:04:06', 'Thanh toán khi nhận hàng', 1, '4999000000', '2025-10-22'),
(5, 'Thiên Nh', '0382766381', '190 dương minh quan, p2 , tp sóc trăng', '2025-10-24', '13:27:33', 'Tiền mặt', 1, '458030000', '2025-10-24'),
(6, 'jun', '0382766381', '190 dương minh quan, p2 , tp sóc trăng', '2025-10-24', '13:28:43', 'Tiền mặt', 1, '1000030035', '2025-10-24'),
(7, 'Thiên Nh', '0382766381', '190 dương minh quan, p2 , tp sóc trăng', '2025-10-24', '13:59:28', 'Chuyển khoản ngân hàng', 1, '638000000', '2025-10-24'),
(8, 'Thiên Nh', '0382766381', '190 dương minh quan, p2 , tp sóc trăng', '2025-10-24', '14:17:34', 'Chuyển khoản ngân hàng', 1, '1299000000', '2025-10-24'),
(9, 'JUN', '0473644735', '190 30/4, Phường Sóc Trăng , Tp Cần Thơ', '2025-10-30', '16:09:57', 'Thanh toán khi nhận hàng', 1, '1299030000', '2025-10-30'),
(10, 'Thiên Nh', '0382766381', '190 dương minh quan, p2 , tp sóc trăng', '2025-10-30', '16:10:09', 'Thanh toán khi nhận hàng', 1, '1299030000', '2025-10-30'),
(11, 'jun', '0382766381', '190 dương minh quan, p2 , tp sóc trăng', '2025-10-30', '23:18:30', 'Thanh toán khi nhận hàng', 1, '1510030000', '2025-10-30'),
(12, 'Thiên Nh', '0382766381', '190 dương minh quan, p2 , tp sóc trăng', '2025-11-03', '18:52:53', 'Thanh toán khi nhận hàng', 1, '1299030000', '2025-11-03'),
(13, 'Thiên Nh', '0382766381', '190 dương minh quan, p2 , tp sóc trăng', '2025-11-03', '19:29:43', 'Thanh toán khi nhận hàng', 1, '1299030000', '2025-11-03'),
(14, 'Thiên Nh', '0382766381', '190 dương minh quan, p2 , tp sóc trăng', '2025-11-03', '19:36:14', 'Thanh toán khi nhận hàng', 1, '1299030000', '2025-11-03'),
(15, 'Thiên Nh', '0382766381', '190 dương minh quan, p2 , tp sóc trăng', '2025-11-03', '19:52:55', 'Thanh toán khi nhận hàng', 1, '1299030000', '2025-11-03'),
(16, 'Thiên', '0382766381', '190 dương minh quan, p2 , tp sóc trăng', '2025-11-03', '19:55:48', 'Thanh toán khi nhận hàng', 1, '1299030000', '2025-11-03'),
(17, 'thien', '0382766381', '190 dương minh quan, p2 , tp sóc trăng', '2025-11-03', '20:01:46', 'Thanh toán khi nhận hàng', 1, '1299030000', '2025-11-03'),
(18, 'Thiên Nh', '0382766381', '190 dương minh quan, p2 , tp sóc trăng', '2025-11-03', '20:07:59', 'Thanh toán khi nhận hàng', 1, '2839030000', '2025-11-03'),
(19, 'hin', '0382766381', '190 dương minh quan, p2 , tp sóc trăng', '2025-11-03', '20:18:25', 'Thanh toán khi nhận hàng', 1, '405030000', '2025-11-03'),
(20, 'Thiên Nh', '0382766381', '190 dương minh quan, p2 , tp sóc trăng', '2025-11-03', '20:30:45', 'Thanh toán khi nhận hàng', 1, '638030000', '2025-11-03'),
(21, 'Thiên Nh', '0382766381', '190 dương minh quan, p2 , tp sóc trăng', '2025-11-04', '13:29:02', 'Thanh toán khi nhận hàng', 1, '405030000', '2025-11-04'),
(22, 'Thiên Nh', '0382766381', '190 dương minh quan, p2 , tp sóc trăng', '2025-11-04', '13:40:56', 'Thanh toán khi nhận hàng', 1, '1000030035', '2025-11-04'),
(23, 'Thiên Nh', '0382766381', '190 dương minh quan, p2 , tp sóc trăng', '2025-11-04', '13:41:29', 'Thanh toán khi nhận hàng', 1, '1000030035', '2025-11-04'),
(24, 'Thiên Nh', '0382766381', '190 dương minh quan, p2 , tp sóc trăng', '2025-11-04', '13:41:50', 'Chuyển khoản ngân hàng', 1, '1000030035', '2025-11-04'),
(25, 'Thiên Nh', '0382766381', '190 dương minh quan, p2 , tp sóc trăng', '2025-11-04', '14:09:27', 'MOMO', 1, '1000000035', '2025-11-04'),
(26, 'Thiên Nh', '0382766381', '190 dương minh quan, p2 , tp sóc trăng', '2025-11-04', '15:01:16', 'VNPAY', 1, '668000000', '2025-11-04'),
(28, 'Thiên Nh', '0382766381', '190 dương minh quan, p2 , tp sóc trăng', '2025-11-06', '07:52:08', 'MOMO', 1, '1299000000', '2025-11-06'),
(34, 'Khách hàng', 'Chưa có', 'Chưa có', '2025-11-06', '16:27:21', 'Chuyển khoản', 1, '638000000', '2025-11-06'),
(35, 'Thiên Nh', '0382766381', '190 dương minh quan, p2 , tp sóc trăng', '2025-11-06', '17:17:19', 'COD', 1, '668000000', '2025-11-06'),
(37, 'admin', '0382766381', '147 le hong phong, p2, tp can tho', '2025-11-06', '17:30:07', 'COD', 1, '668000000', '2025-11-06'),
(39, 'admin', '0382766381', '147 le hong phong, p2, tp can tho', '2025-11-06', '17:32:32', 'Chuyển khoản ngân hàng', 1, '668000000', '2025-11-06'),
(40, 'admin', '0382766381', '147 le hong phong, p2, tp can tho', '2025-11-06', '17:34:20', 'Chuyển khoản ngân hàng', 1, '1299000000', '2025-11-06'),
(41, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-06', '17:50:24', 'Chuyển khoản ngân hàng', 1, '458000000', '2025-11-06'),
(42, 'admin', '0382766381', '147 le hong phong, p2, tp can tho', '2025-11-06', '18:15:46', 'Thanh toán khi nhận hàng', 1, '2839000000', '2025-11-06'),
(43, 'admin', '0382766381', '147 le hong phong, p2, tp can tho', '2025-11-06', '18:19:24', 'Thanh toán khi nhận hàng', 1, '1299000000', '2025-11-06'),
(44, 'admin', '0382766381', '147 le hong phong, p2, tp can tho', '2025-11-06', '18:20:52', 'Thanh toán khi nhận hàng', 1, '1299000000', '2025-11-06'),
(45, 'admin', '0382766381', '147 le hong phong, p2, tp can tho', '2025-11-06', '18:25:10', 'Thanh toán khi nhận hàng', 1, '1299000000', '2025-11-06'),
(46, 'admin', '0382766381', '147 le hong phong, p2, tp can tho', '2025-11-06', '18:26:49', 'Thanh toán khi nhận hàng', 1, '1299000000', '2025-11-06'),
(47, 'admin', '0382766381', '147 le hong phong, p2, tp can tho', '2025-11-06', '18:29:00', 'Tiền mặt', 1, '1000000035', '2025-11-06'),
(59, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-11-18', '23:03:47', 'Thanh toán khi nhận hàng', 1, '9999999999', '2025-11-18'),
(60, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-11-18', '23:07:54', 'Chuyển khoản ngân hàng', 1, '638000000', '2025-11-18'),
(61, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-11-18', '23:08:56', 'Chuyển khoản ngân hàng', 1, '1299000000', '2025-11-18'),
(64, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-11-19', '00:40:40', 'Thanh toán khi nhận hàng', 1, '405000000', '2025-11-19'),
(65, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-11-19', '00:46:10', 'Thanh toán khi nhận hàng', 1, '1299000000', '2025-11-19'),
(66, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-11-19', '00:49:47', 'Thanh toán khi nhận hàng', 1, '600000000', '2025-11-19'),
(68, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-11-20', '00:49:43', 'Chuyển khoản ngân hàng', 1, '1299000000', '2025-11-20'),
(69, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-11-20', '23:29:24', 'Chuyển khoản ngân hàng', 1, '405000000', '2025-11-20'),
(71, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-20', '23:30:00', 'Chuyển khoản', 1, '1299000000', '2025-11-20'),
(72, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-21', '03:03:27', 'Thanh toán khi nhận hàng', 1, '1220000000', '2025-11-21'),
(73, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-21', '11:20:46', 'Chuyển khoản ngân hàng', 1, '1299000000', '2025-11-21'),
(74, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-21', '15:56:52', 'Chuyển khoản ngân hàng', 1, '1299000000', '2025-11-21'),
(76, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-11-22', '11:49:17', 'Thanh toán khi nhận hàng', 1, '1299000000', '2025-11-22'),
(79, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-11-22', '11:55:34', 'Thanh toán khi nhận hàng', 1, '1299000000', '2025-11-22'),
(91, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:06:21', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(92, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:06:53', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(93, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:15:39', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(94, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:22:43', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(95, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:22:53', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(96, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:23:02', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(97, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:23:22', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(98, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:24:17', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(99, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:24:41', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(100, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:25:02', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(101, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:32:03', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(102, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:32:49', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(103, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:32:59', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(104, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:33:17', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(105, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:33:27', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(106, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:33:39', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(107, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:36:16', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(108, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:36:28', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(109, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:39:28', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(110, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:39:39', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(111, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:39:50', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(112, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:39:59', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(113, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:40:18', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(114, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:40:54', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-11-25'),
(115, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:47:31', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-11-25'),
(116, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:47:45', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-11-25'),
(117, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:48:14', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-11-25'),
(118, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:48:32', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(119, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:50:45', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(120, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:53:58', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-11-25'),
(121, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:54:10', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-11-25'),
(122, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '18:00:25', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-11-25'),
(123, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '18:00:45', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(124, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '18:01:31', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(125, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '18:01:47', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(126, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '18:02:09', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(127, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-11-25', '18:19:12', 'Thanh toán khi nhận hàng', 1, '1299000000', '2025-11-25'),
(128, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-11-25', '18:21:07', 'Thanh toán khi nhận hàng', 1, '1299000000', '2025-11-25'),
(129, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-11-25', '18:30:52', 'Thanh toán khi nhận hàng', 1, '1299000000', '2025-11-25'),
(130, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-11-25', '18:33:56', 'Thanh toán khi nhận hàng', 1, '600000000', '2025-11-25'),
(131, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-11-25', '18:34:15', 'Chuyển khoản ngân hàng', 1, '600000000', '2025-11-25'),
(132, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-11-25', '18:39:14', 'Chuyển khoản ngân hàng', 1, '600000000', '2025-11-25'),
(133, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-11-25', '18:39:26', 'Chuyển khoản ngân hàng', 1, '600000000', '2025-11-25'),
(134, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-11-25', '18:40:11', 'Chuyển khoản ngân hàng', 1, '600000000', '2025-11-25'),
(135, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-11-25', '18:40:34', 'Chuyển khoản ngân hàng', 1, '600000000', '2025-11-25'),
(136, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '18:51:19', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-11-25'),
(137, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '18:51:47', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-11-25'),
(138, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '18:52:17', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-11-25'),
(139, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '18:53:00', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-11-25'),
(146, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-11-25', '19:22:04', 'Thanh toán khi nhận hàng', 1, '600000000', '2025-11-25'),
(147, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-11-25', '19:22:14', 'Thanh toán khi nhận hàng', 1, '600000000', '2025-11-25'),
(148, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-11-25', '19:22:44', 'Thanh toán khi nhận hàng', 1, '600000000', '2025-11-25'),
(149, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-11-25', '19:22:55', 'Thanh toán khi nhận hàng', 1, '600000000', '2025-11-25'),
(150, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-11-25', '19:24:02', 'Thanh toán khi nhận hàng', 1, '600000000', '2025-11-25'),
(151, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-11-25', '19:24:22', 'Thanh toán khi nhận hàng', 1, '600000000', '2025-11-25'),
(152, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-11-25', '19:34:09', 'Thanh toán khi nhận hàng', 1, '600000000', '2025-11-25'),
(153, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-11-25', '19:34:21', 'Thanh toán khi nhận hàng', 1, '600000000', '2025-11-25'),
(154, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-11-25', '19:34:56', 'Thanh toán khi nhận hàng', 1, '600000000', '2025-11-25'),
(155, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-11-25', '19:35:10', 'Chuyển khoản ngân hàng', 1, '600000000', '2025-11-25'),
(156, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-11-25', '19:35:23', 'Thanh toán khi nhận hàng', 1, '600000000', '2025-11-25'),
(157, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-11-25', '19:35:40', 'Thanh toán khi nhận hàng', 1, '600000000', '2025-11-25'),
(160, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '19:39:51', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(161, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '19:40:00', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(162, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '19:41:13', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(163, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '19:41:36', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-11-25'),
(164, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '19:51:45', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-11-25'),
(165, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '19:52:03', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(166, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '19:52:37', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(167, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '19:52:53', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(168, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '19:53:47', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(169, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '19:55:27', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(170, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '19:56:37', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(171, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '19:59:34', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-11-25'),
(172, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '20:03:39', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(173, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '20:03:51', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(175, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '20:06:40', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(176, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '20:06:57', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(177, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '20:11:19', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(178, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '20:15:03', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(179, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '20:16:08', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(180, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '20:16:18', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(181, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '20:16:31', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(182, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '20:16:56', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(183, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '20:17:09', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(184, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '20:17:26', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(185, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '20:17:34', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(186, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '20:17:56', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(187, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '20:19:37', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(188, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '20:20:29', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(189, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '20:22:30', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(190, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-11-26', '07:32:57', 'Thanh toán khi nhận hàng', 1, '1299000000', '2025-11-26'),
(191, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-26', '07:34:22', 'Thanh toán khi nhận hàng', 1, '1200000000', '2025-11-26'),
(209, 'test', '0382766381', '190 dương minh quan, p2 , tp sóc trăng', '2025-11-26', '10:23:00', 'Chuyển khoản ngân hàng', 1, '120000000', '2025-11-26'),
(210, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-26', '10:24:10', 'Thanh toán khi nhận hàng', 1, '1299000000', '2025-11-26'),
(211, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-26', '10:24:22', 'Chuyển khoản ngân hàng', 1, '1299000000', '2025-11-26'),
(212, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-26', '10:24:31', 'Thanh toán khi nhận hàng', 1, '1299000000', '2025-11-26'),
(213, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-26', '10:30:07', 'Thanh toán khi nhận hàng', 1, '1299000000', '2025-11-26'),
(214, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-26', '10:30:18', 'Thanh toán khi nhận hàng', 1, '600000000', '2025-11-26'),
(215, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-26', '13:19:54', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-26'),
(219, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-26', '14:23:49', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-11-26'),
(220, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-26', '14:24:06', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-11-26'),
(221, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-26', '17:24:47', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-11-26'),
(222, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-26', '17:26:23', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-11-26'),
(223, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-26', '17:26:43', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-11-26'),
(224, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-26', '17:27:00', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-11-26'),
(225, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-26', '17:27:22', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-11-26'),
(226, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-26', '17:28:22', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-11-26'),
(227, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-26', '17:28:53', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-11-26'),
(228, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-26', '17:29:55', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-11-26'),
(229, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-26', '17:32:03', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-11-26'),
(230, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-26', '17:33:01', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-11-26'),
(231, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-26', '17:33:29', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-11-26'),
(232, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-26', '17:33:50', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-11-26'),
(233, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-27', '07:12:12', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-27'),
(234, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-27', '07:13:19', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-27'),
(235, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-27', '07:13:29', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-27'),
(236, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-28', '15:32:51', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-28'),
(237, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-28', '15:33:10', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-28'),
(238, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-28', '15:34:30', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-28'),
(239, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-28', '15:36:23', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-28'),
(240, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-28', '15:36:37', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-28'),
(241, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-28', '15:37:10', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-28'),
(242, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-28', '15:37:29', 'Thanh toán khi nhận hàng', 1, '1220000000', '2025-11-28'),
(243, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-28', '15:39:42', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-28'),
(244, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-28', '15:40:54', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-28'),
(245, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-28', '15:41:18', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-28'),
(246, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-28', '15:43:59', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-28'),
(247, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-28', '15:44:09', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-28'),
(248, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-28', '15:44:23', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-28'),
(249, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-01', '16:43:15', 'Thanh toán khi nhận hàng', 1, '1000000035', '2025-12-01'),
(250, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-01', '16:43:27', 'Thanh toán khi nhận hàng', 1, '1200000000', '2025-12-01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `ID` int(11) NOT NULL,
  `MaTK` varchar(20) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `TenTK` varchar(30) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `MatKhau` varchar(50) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `Quyen` varchar(8) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `HinhAnh` varchar(100) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `NgayCapNhat` datetime NOT NULL,
  `GhiChu` varchar(300) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8_vietnamese_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`ID`, `MaTK`, `TenTK`, `MatKhau`, `Quyen`, `HinhAnh`, `NgayCapNhat`, `GhiChu`, `phone`, `email`) VALUES
(15, 'TK8235', 'jun', '$2y$10$Tesz4MkS82rM8Liv0F34zOsz5oS.XP31rw/u7sU/ApC', '', 'default.png', '2025-11-05 11:07:38', '', '0382766381', 'nhthin366@gmail.com'),
(16, 'TK8237', 'tuan', '$2y$10$WMTkwnXROOT8yYoSlbl5rut7KxSetlHbGF8q1/SEdi/', '', 'default.png', '2025-11-05 17:48:01', '', '0293872562', 'tuuabgwem');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `kho_xe_laythu`
--

CREATE TABLE `kho_xe_laythu` (
  `ID` int(11) NOT NULL,
  `MaXe` bigint(20) NOT NULL,
  `NgayCapNhat` datetime DEFAULT CURRENT_TIMESTAMP,
  `SoLuong_CoSan` int(11) DEFAULT '0',
  `SoLuong_LaiThu` int(11) NOT NULL DEFAULT '0',
  `SoLuong_BaoTri` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `kho_xe_laythu`
--

INSERT INTO `kho_xe_laythu` (`ID`, `MaXe`, `NgayCapNhat`, `SoLuong_CoSan`, `SoLuong_LaiThu`, `SoLuong_BaoTri`) VALUES
(1, 2, '2025-11-19 20:42:00', 0, 1, 3),
(2, 3, '2025-11-18 21:30:10', 3, 1, 0),
(3, 4, '2025-11-18 21:13:36', 4, 2, 0),
(4, 5, '2025-11-14 14:02:56', 10, 0, 0),
(5, 7, '2025-11-14 14:02:56', 18, 1, 0),
(6, 8, '2025-11-18 21:14:13', 2, 2, 0),
(7, 9, '2025-11-18 21:14:20', 6, 0, 0),
(8, 10, '2025-11-14 14:02:56', 14, 2, 0),
(9, 11, '2025-11-18 21:14:31', 7, 1, 0),
(10, 12, '2025-11-14 14:02:56', 8, 0, 0),
(11, 13, '2025-11-14 14:02:56', 10, 2, 0),
(12, 99, '2025-11-18 21:14:43', 5, 0, 0),
(13, 100, '2025-11-18 21:14:55', 4, 0, 0),
(14, 101, '2025-11-14 14:02:56', 12, 3, 0),
(15, 102, '2025-11-14 14:02:56', 4, 1, 0),
(16, 103, '2025-11-18 21:15:34', 3, 0, 0),
(17, 104, '2025-11-14 14:02:56', 6, 1, 0),
(18, 105, '2025-11-18 21:15:26', 5, 2, 0),
(19, 106, '2025-11-18 21:27:08', 4, 0, 0),
(20, 107, '2025-11-14 14:02:56', 2, 0, 0),
(21, 108, '2025-11-14 14:02:56', 1, 1, 0),
(22, 109, '2025-11-14 14:02:56', 18, 2, 0),
(23, 110, '2025-11-14 14:02:56', 12, 3, 0),
(24, 111, '2025-11-18 21:15:14', 3, 4, 0),
(25, 113, '2025-11-18 21:15:43', 4, 2, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaisanpham`
--

CREATE TABLE `loaisanpham` (
  `ID` int(11) NOT NULL,
  `TenLoai` varchar(100) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `MoTa` varchar(100) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `LoaiSP` varchar(30) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `GhiChu` varchar(255) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `loaisanpham`
--

INSERT INTO `loaisanpham` (`ID`, `TenLoai`, `MoTa`, `LoaiSP`, `GhiChu`) VALUES
(1, 'Sedan', '5 chỗ', 'Sedan', ''),
(2, 'Suv', '5 chỗ', 'Suv', ''),
(3, 'Bán Tải', '5 chỗ', 'Bán tải', ''),
(4, 'Đa Dụng', '7 chỗ', 'Đa dụng', ''),
(5, 'Hatchback', '5 chỗ', 'Hatchback', ''),
(6, 'Đa dụng', '7 chỗ', 'Đa dụng', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoidung`
--

CREATE TABLE `nguoidung` (
  `ID` int(11) NOT NULL,
  `TenTK` varchar(30) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `MatKhau` varchar(255) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `Quyen` varchar(8) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `NgayCapNhat` datetime NOT NULL,
  `DiaChi` varchar(300) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `phone` varchar(15) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoidung`
--

INSERT INTO `nguoidung` (`ID`, `TenTK`, `MatKhau`, `Quyen`, `NgayCapNhat`, `DiaChi`, `phone`, `email`) VALUES
(1, 'admin', '$2y$10$zvZc2hnWgkeuplkZrELOxOMwct7AvDiAvzn.x.uEJmKydPIiBRqVy', '3', '2025-11-10 18:34:22', '147 le hong phong, p2, tp can tho', '0483777436', 'ad@gmail.com'),
(18, 'jun', '$2y$10$.l/ke3LpeyNar.eRQDgbOuiesWEtC51h9W9x7HXFrEdoqfO.uF2PC', '1', '2025-11-10 18:41:19', '387 phan đình phùng , p3 , tp cần thơ', '0382766381', 'nhthin366@gmail.com'),
(29, 'phuclỏr', '$2y$10$CXfgKNPoZ/Mmi3jaHbChGukWsro691nPYsMoJRg.2WnrWaO2NnAZ.', '1', '2025-11-15 13:08:08', '12 jdv p4. tp st', '0382645384', 'phuc@gmail.com'),
(30, 'crhy', '$2y$10$w0ZhlPm1XQJa8qR8NKHQj.n2YJLXW3dLzbL83MqnKVR4Fc33935YC', '1', '2025-11-19 17:03:26', '23 mạc đĩnh chi, p3 tp cần thơ', '0374877352', 'fr@gmail.com'),
(31, 'xc', '$2y$10$n4qRBYk260Aig1vBrC03X.2oyUHMVJi9/M9jxGrjR6iK4ABAoCwLK', '1', '2025-11-21 08:57:35', '136 lê duẩn, p2, tp cần thơ', '0384666362', 'cx366@gmail.com'),
(32, 'dfrrgr', '$2y$10$AlLLcnlE.eYgWfwEV3Q.3OPurzlcXsfGrjUzIAai3rWDG5pPTjh7e', '1', '2025-11-22 02:30:17', '111 lhp , p2 , tp can tho', '02877323733', 'nfge@gmail.com'),
(33, 'test', '$2y$10$vTcaUfoPsTsFzJjv/a70Hev7L922e1L5pyFgBxjxh9BFgws1H8jJy', '1', '2025-11-22 02:37:45', '111 lhp , p2 , tp can tho', '0397467234', 'fvr@gmail.com'),
(34, 'ccede', '$2y$10$SNMujatir6AlIDDpEctcM.9q7Zl6N1vBy.7LLFxBgeoy3b1gzCiSu', '1', '2025-11-22 03:23:48', '35 lhp , p2 , tp can tho', '0485474643', '4t4@gmail.com'),
(35, 'EWFR', '$2y$10$wFRGhZws4tuAwwMRjP/sluskPoLJdpzYLnOGUk1RyqhNfBViDRNxm', '1', '2025-11-22 20:21:21', '272 lhp , p2 , tp can tho', '0375835738', 'EY@gmail.com'),
(36, 'FGY', '$2y$10$T5MFz1kgR2X.d/EGgVFDKOavMsHHkDIiLKaHcJJUDG1CWj7ti9yde', '1', '2025-11-22 20:22:08', '111 lhp , p2 , tp can tho', '0374888374', 'FE6@gmail.com');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `ID` bigint(20) NOT NULL,
  `TenSP` varchar(30) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `MoTa` varchar(255) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `NgayCapNhat` date NOT NULL,
  `HinhAnh` varchar(100) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `LoaiSP` varchar(255) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `Gia` bigint(255) NOT NULL,
  `SoLuong` varchar(255) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `NhienLieu` varchar(50) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `XuatXu` varchar(100) COLLATE utf8_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`ID`, `TenSP`, `MoTa`, `NgayCapNhat`, `HinhAnh`, `LoaiSP`, `Gia`, `SoLuong`, `NhienLieu`, `XuatXu`) VALUES
(2, 'COROLLA ALTIS 1.8G', '5 chỗ', '2025-09-23', 'hinh2.jpg', 'Sedan', 725000000, '24', 'Xăng', 'Thái Lan'),
(3, 'CAMRY 2.0Q', '5 chỗ', '2025-09-23', 'h3.jpg', 'Sedan', 1220000000, '30', 'Xăng', 'Thái Lan'),
(4, 'YARIS CROSS', '5 chỗ', '2025-09-25', 'hinh4.jpg', 'Suv', 650000000, '30', 'Xăng', 'Indonesia'),
(5, 'HILUX 2.4L 4X4 MT', '5 chỗ', '2025-10-07', 'h5.avif', 'Bán tải', 600000000, '25', 'Xăng', 'Thái Lan'),
(7, 'VELOZ CROSS CVT', '7 chỗ', '2025-10-08', 'h7.png', 'Đa dụng', 638000000, '33', 'Xăng', 'Indonesia'),
(8, 'WIGO G', '5 chỗ', '2025-11-04', 'wigo.png', 'Hatchback', 405000000, '40', 'Xăng', 'Indonesia'),
(9, 'LAND CRUISER PRADO M', '7 chỗ', '2025-10-31', 'h7.jpg', 'Đa dụng', 3480000000, '10', 'Xăng', 'Nhật Bản'),
(10, 'RANGER RAPTOR', '5 chỗ', '2025-10-31', 'h8.jpg', 'Bán tải', 1299000000, '20', 'Xăng', 'Thái Lan'),
(11, 'Ford Ranger Raptor X', '5 chỗ', '2025-10-31', '8.jpg', 'Bán tải', 1000000035, '9', 'Xăng', 'Thái Lan'),
(12, 'EQS SUV', '5 chỗ', '2025-10-09', 'h8.png', 'Suv', 4999000000, '10', 'Xăng', 'Đức'),
(13, 'Mercedes-AMG G-Class', '5 chỗ', '2025-11-07', 'h1.avif', 'Bán tải', 11750000000, '20', 'Xăng', 'Đức'),
(99, 'TOYOTA COROLLA CROSS', '5 chỗ', '2025-11-11', 'sp11.png', 'Suv', 950000000, '15', 'Xăng', 'Thái Lan'),
(100, 'HONDA CR-V', '5 chỗ', '2025-11-11', 'sp10.png', 'Suv', 1100000000, '12', 'Xăng', 'Nhật Bản'),
(101, 'MITSUBISHI Xpander', '7 chỗ', '2025-11-11', 'sp8.png', 'Đa dụng', 650000000, '20', 'Xăng', 'Indonesia'),
(102, 'FORD RANGER XL', '5 chỗ', '2025-11-11', 'sp7.png', 'Bán tải', 1200000000, '10', 'Xăng', 'Thái Lan'),
(103, 'NISSAN NAVARA', '5 chỗ', '2025-11-11', 'sp6.png', 'Bán tải', 1250000000, '8', 'Xăng', 'Thái Lan'),
(104, 'HYUNDAI SANTAFE', '5 chỗ', '2025-11-11', 'sp5.png', 'Suv', 1350000000, '12', 'Xăng', 'Nhật Bản'),
(105, 'KIA SELTOS', '5 chỗ', '2025-11-11', 'sp4.png', 'Suv', 750000000, '18', 'Xăng', 'Nhật Bản'),
(106, 'TOYOTA VELLFIRE', '7 chỗ', '2025-11-11', 'sp3.png', 'Đa dụng', 4500000000, '5', 'Xăng', 'Nhật Bản'),
(107, 'MERCEDES-BENZ GLE', '5 chỗ', '2025-11-10', 'gle.avif', 'Suv', 4800000000, '3', 'Xăng', 'Đức'),
(108, 'BMW X5', '5 chỗ', '2025-11-10', 'x5.png', 'Suv', 5200000000, '2', 'Xăng', 'Đức'),
(109, 'SUZUKI SWIFT', '5 chỗ', '2025-11-11', 'szk.jpg', 'Hatchback', 450000000, '20', 'Xăng', 'Nhật Bản'),
(110, 'TOYOTA YARIS', '5 chỗ', '2025-11-11', 'sp2.png', 'Hatchback', 420000000, '15', 'Xăng', 'Thái Lan'),
(111, 'HONDA JAZZ1', '5 chỗ', '2025-11-30', 'sp1.png', 'Hatchback', 480000000, '18', 'Xăng', 'Nhật Bản'),
(113, 'test', '5 chỗ', '2025-11-30', 'xerua.jpg', 'Bán tải', 100000000, '1', 'Điện', 'Đức'),
(150, 'test2', '5 chỗ', '2025-11-30', 'chat.avif', 'Bán tải', 100000000, '1', 'Điện', 'Đức'),
(152, 'test4', '5 chỗ', '2025-11-30', 'chat.webp', 'Bán tải', 100000000, '1', 'Điện', 'Đức');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thongsokithuat`
--

CREATE TABLE `sanpham` (
  `ID` bigint(20) NOT NULL,
  `TenSP` varchar(30) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `MoTa` varchar(255) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `NgayCapNhat` date NOT NULL,
  `HinhAnh` varchar(100) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `LoaiSP` varchar(255) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `Gia` bigint(255) NOT NULL,
  `SoLuong` varchar(255) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `NhienLieu` varchar(50) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `XuatXu` varchar(100) COLLATE utf8_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `thongsokithuat`
--

INSERT INTO `thongsokithuat` (`ID`, `SanPhamID`, `LoaiNhienLieu`, `CongSuatHP`, `HopSo`, `TangToc`, `TocDoToiDa`, `TrongLuong`, `ChoNgoi`) VALUES
(1, 2, 'Xăng', 138, 'CVT', 10.2, 195, 1320, 5),
(2, 3, 'Xăng', 170, 'Tự động 6 cấp', 9.2, 210, 1470, 5),
(3, 4, 'Xăng', 106, 'CVT', 11.7, 175, 1250, 5),
(4, 5, 'Xăng', 147, 'Số sàn 6 cấp', 12.8, 170, 2040, 5),
(5, 7, 'Xăng', 105, 'CVT', 12, 175, 1290, 7),
(6, 8, 'Xăng', 67, 'Tự động 4 cấp', 14.8, 150, 865, 5),
(7, 9, 'Xăng', 278, 'Tự động 6 cấp', 8.1, 210, 2300, 7),
(8, 10, 'Xăng', 210, 'Tự động 10 cấp', 7.5, 200, 2500, 5),
(9, 11, 'Xăng', 210, 'Tự động 10 cấp', 7.8, 200, 2450, 5),
(10, 12, 'Điện', 355, '1 cấp', 6, 210, 2800, 5),
(11, 13, 'Xăng', 577, 'Tự động 9 cấp', 4.5, 240, 2560, 5),
(12, 99, 'Xăng', 138, 'CVT', 10.5, 190, 1325, 5),
(13, 100, 'Xăng', 188, 'CVT', 9.1, 195, 1500, 5),
(14, 101, 'Xăng', 104, 'Tự động 4 cấp', 12.5, 165, 1290, 7),
(15, 102, 'Xăng', 160, 'Số sàn 6 cấp', 12, 175, 2030, 5),
(16, 103, 'Xăng', 190, 'Tự động 7 cấp', 10.8, 180, 2050, 5),
(17, 104, 'Xăng', 180, 'Tự động 8 cấp', 10, 195, 1690, 5),
(18, 105, 'Xăng', 147, 'Tự động 6 cấp', 10.3, 190, 1320, 5),
(19, 106, 'Xăng', 276, 'Tự động 8 cấp', 7, 200, 2100, 7),
(20, 107, 'Xăng', 381, 'Tự động 9 cấp', 5.5, 250, 2180, 5),
(21, 108, 'Xăng', 375, 'Tự động 8 cấp', 5.3, 243, 2140, 5),
(22, 109, 'Xăng', 82, 'Tự động CVT', 13, 160, 915, 5),
(23, 110, 'Xăng', 106, 'CVT', 12.8, 165, 1040, 5),
(24, 111, 'Xăng', 118, 'CVT', 12, 175, 1120, 5),
(25, 113, 'Xăng', 100, 'AT', 12.5, 180, 1200, 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `trangthai_laythu`
--

CREATE TABLE `trangthai_laythu` (
  `ID` int(11) NOT NULL,
  `DangKyID` int(11) NOT NULL,
  `TrangThai` enum('Chờ xác nhận','Đang láy thử','Hoàn tất','Hủy') COLLATE utf8_vietnamese_ci NOT NULL DEFAULT 'Chờ xác nhận',
  `NgayCapNhat` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `trangthai_laythu`
--

INSERT INTO `trangthai_laythu` (`ID`, `DangKyID`, `TrangThai`, `NgayCapNhat`) VALUES
(14, 115, 'Đang láy thử', '2025-11-17 23:41:43'),
(15, 116, 'Chờ xác nhận', '2025-11-17 23:46:41'),
(16, 113, 'Chờ xác nhận', '2025-11-21 00:08:20'),
(17, 117, 'Đang láy thử', '2025-11-22 22:04:39'),
(18, 112, 'Hoàn tất', '2025-11-18 00:50:07'),
(19, 114, 'Hủy', '2025-11-18 00:50:20'),
(20, 115, 'Hoàn tất', '2025-11-17 23:48:50'),
(21, 115, 'Hoàn tất', '2025-11-17 23:48:51'),
(22, 115, 'Hoàn tất', '2025-11-17 23:48:52'),
(23, 115, 'Hoàn tất', '2025-11-17 23:48:52'),
(24, 115, 'Hoàn tất', '2025-11-17 23:48:52'),
(25, 115, 'Hoàn tất', '2025-11-17 23:48:53'),
(26, 115, 'Hoàn tất', '2025-11-17 23:48:53'),
(27, 115, 'Hoàn tất', '2025-11-17 23:48:55'),
(28, 115, 'Hoàn tất', '2025-11-17 23:48:56'),
(29, 115, 'Đang láy thử', '2025-11-17 23:48:59'),
(30, 115, 'Đang láy thử', '2025-11-17 23:48:59'),
(31, 115, 'Đang láy thử', '2025-11-17 23:48:59'),
(32, 112, 'Hoàn tất', '2025-11-18 00:50:07'),
(33, 112, 'Hoàn tất', '2025-11-18 00:50:07'),
(34, 115, 'Đang láy thử', '2025-11-17 23:51:42'),
(35, 115, 'Hoàn tất', '2025-11-17 23:51:44'),
(36, 115, 'Hoàn tất', '2025-11-17 23:51:44'),
(37, 115, 'Hoàn tất', '2025-11-17 23:51:45'),
(38, 112, 'Hoàn tất', '2025-11-18 00:50:07'),
(39, 112, 'Hoàn tất', '2025-11-18 00:50:07'),
(40, 112, 'Hoàn tất', '2025-11-18 00:50:07'),
(41, 112, 'Hoàn tất', '2025-11-18 00:50:07'),
(42, 112, 'Hoàn tất', '2025-11-18 00:50:07'),
(43, 112, 'Hoàn tất', '2025-11-18 00:50:07'),
(44, 112, 'Hoàn tất', '2025-11-18 00:50:07'),
(45, 112, 'Hoàn tất', '2025-11-18 00:50:07'),
(46, 112, 'Hoàn tất', '2025-11-18 00:50:07'),
(47, 113, 'Chờ xác nhận', '2025-11-21 00:08:20'),
(48, 121, 'Chờ xác nhận', '2025-11-20 22:15:48'),
(49, 126, 'Chờ xác nhận', '2025-11-20 22:15:48'),
(50, 120, 'Chờ xác nhận', '2025-11-20 22:15:48'),
(51, 125, 'Chờ xác nhận', '2025-11-20 22:15:48'),
(52, 119, 'Chờ xác nhận', '2025-11-20 22:15:48'),
(53, 122, 'Chờ xác nhận', '2025-11-20 22:15:48'),
(54, 124, 'Chờ xác nhận', '2025-11-20 22:15:48'),
(55, 118, 'Chờ xác nhận', '2025-11-20 22:15:48'),
(56, 123, 'Chờ xác nhận', '2025-11-20 22:15:48'),
(57, 128, 'Chờ xác nhận', '2025-11-21 05:08:54'),
(58, 127, 'Chờ xác nhận', '2025-11-21 05:08:54'),
(59, 129, 'Hoàn tất', '2025-11-22 22:04:29');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vanchuyen`
--

CREATE TABLE `vanchuyen` (
  `ID` int(11) NOT NULL,
  `TenTK` varchar(30) COLLATE utf8_vietnamese_ci NOT NULL,
  `ID_HoaDon` int(11) NOT NULL,
  `Phone` varchar(50) COLLATE utf8_vietnamese_ci NOT NULL,
  `Address` varchar(1000) COLLATE utf8_vietnamese_ci NOT NULL,
  `TrangThai` enum('Đang lấy hàng','Đã lấy hàng','Đang vận chuyển','Đã đến kho','Đang giao hàng','Đã giao hàng') COLLATE utf8_vietnamese_ci NOT NULL DEFAULT 'Đang lấy hàng',
  `NgayCapNhat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `vanchuyen`
--

INSERT INTO `vanchuyen` (`ID`, `TenTK`, `ID_HoaDon`, `Phone`, `Address`, `TrangThai`) VALUES
(12, 'admin', 40, '0382766381', '147 le hong phong, p2, tp can tho', 'Đang vận chuyển'),
(13, 'admin', 39, '0382766381', '147 le hong phong, p2, tp can tho', 'Đã đến kho'),
(14, 'Thiên Nh', 21, '0382766381', '190 dương minh quan, p2 , tp sóc trăng', 'Đã lấy hàng'),
(15, 'Thiên Nh', 28, '0382766381', '190 dương minh quan, p2 , tp sóc trăng', 'Đang giao hàng'),
(16, 'Thiên Nh', 12, '0382766381', '190 dương minh quan, p2 , tp sóc trăng', 'Đã giao hàng'),
(17, 'Thiên Nh', 35, '0382766381', '190 dương minh quan, p2 , tp sóc trăng', 'Đã giao hàng'),
(18, 'admin', 47, '0382766381', '147 le hong phong, p2, tp can tho', 'Đã đến kho'),
(19, 'jun', 11, '0382766381', '190 dương minh quan, p2 , tp sóc trăng', 'Đang vận chuyển'),
(20, 'jun', 41, '0382766381', '387 phan đình phùng , p3 , tp cần thơ', 'Đang giao hàng'),
(21, 'jun', 6, '0382766381', '190 dương minh quan, p2 , tp sóc trăng', 'Đã giao hàng'),
(22, 'admin', 64, '0483777436', '147 le hong phong, p2, tp can tho', 'Đã lấy hàng'),
(23, 'jun', 72, '0382766381', '387 phan đình phùng , p3 , tp cần thơ', 'Đã lấy hàng'),
(24, 'jun', 73, '0382766381', '387 phan đình phùng , p3 , tp cần thơ', 'Đang giao hàng');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD PRIMARY KEY (`ID_BILL`);

--
-- Chỉ mục cho bảng `dangkilaithe`
--
ALTER TABLE `dangkilaithe`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`MaGioHang`);

--
-- Chỉ mục cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `kho_xe_laythu`
--
ALTER TABLE `kho_xe_laythu`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `MaXe` (`MaXe`);

--
-- Chỉ mục cho bảng `loaisanpham`
--
ALTER TABLE `loaisanpham`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `thongsokithuat`
--
ALTER TABLE `thongsokithuat`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `SanPhamID` (`SanPhamID`);

--
-- Chỉ mục cho bảng `trangthai_laythu`
--
ALTER TABLE `trangthai_laythu`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `DangKyID` (`DangKyID`);

--
-- Chỉ mục cho bảng `vanchuyen`
--
ALTER TABLE `vanchuyen`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_HoaDon` (`ID_HoaDon`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  MODIFY `ID_BILL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `dangkilaithe`
--
ALTER TABLE `dangkilaithe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT cho bảng `giohang`
--
ALTER TABLE `giohang`
  MODIFY `MaGioHang` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `kho_xe_laythu`
--
ALTER TABLE `kho_xe_laythu`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `loaisanpham`
--
ALTER TABLE `loaisanpham`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT cho bảng `thongsokithuat`
--
ALTER TABLE `thongsokithuat`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `trangthai_laythu`
--
ALTER TABLE `trangthai_laythu`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT cho bảng `vanchuyen`
--
ALTER TABLE `vanchuyen`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `kho_xe_laythu`
--
ALTER TABLE `kho_xe_laythu`
  ADD CONSTRAINT `kho_xe_laythu_ibfk_1` FOREIGN KEY (`MaXe`) REFERENCES `sanpham` (`ID`);

--
-- Các ràng buộc cho bảng `thongsokithuat`
--
ALTER TABLE `thongsokithuat`
  ADD CONSTRAINT `thongsokithuat_ibfk_1` FOREIGN KEY (`SanPhamID`) REFERENCES `sanpham` (`ID`);

--
-- Các ràng buộc cho bảng `trangthai_laythu`
--
ALTER TABLE `trangthai_laythu`
  ADD CONSTRAINT `trangthai_laythu_ibfk_1` FOREIGN KEY (`DangKyID`) REFERENCES `dangkilaithe` (`id`);

--
-- Các ràng buộc cho bảng `vanchuyen`
--
ALTER TABLE `vanchuyen`
  ADD CONSTRAINT `vanchuyen_ibfk_1` FOREIGN KEY (`ID_HoaDon`) REFERENCES `hoadon` (`ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
