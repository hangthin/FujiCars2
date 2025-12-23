-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th12 19, 2025 lúc 02:14 PM
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
(129, 'hin', '0382766381', 'RANGER RAPTOR', '', '2025-11-22 22:01:07', '2025-11-23', '10:00', '120 Trần Hưng Đạo, Sóc Trăng, Tp Cần Thơ'),
(130, 'jun', '0382766381', 'CAMRY 2.0Q', 'test', '2025-12-02 16:10:58', '2025-12-02', '11:00', '120 Trần Hưng Đạo, Sóc Trăng, Tp Cần Thơ'),
(131, 'jun', '0382766381', 'CAMRY 2.0Q', 'test', '2025-12-02 16:11:06', '2025-12-02', '11:00', '120 Trần Hưng Đạo, Sóc Trăng, Tp Cần Thơ'),
(132, 'jun', '0382766381', 'CAMRY 2.0Q', 'test', '2025-12-02 16:12:11', '2025-12-02', '11:00', '120 Trần Hưng Đạo, Sóc Trăng, Tp Cần Thơ'),
(133, 'jun', '0382766381', 'CAMRY 2.0Q', 'test', '2025-12-02 16:19:26', '2025-12-02', '13:00', '164 Lê Hồng Phong, Sóc Trăng, Tp Cần Thơ'),
(134, 'Hin', '0382766384', 'Mercedes-AMG G-Class', '', '2025-12-02 16:25:55', '2025-12-02', '11:00', '120 Trần Hưng Đạo, Sóc Trăng, Tp Cần Thơ'),
(135, 'Hin', '0382766383', 'RANGER RAPTOR', '', '2025-12-02 16:33:21', '2025-12-02', '13:00', '120 Trần Hưng Đạo, Sóc Trăng, Tp Cần Thơ'),
(136, 'demo', '0382766381', 'VELOZ CROSS CVT', '', '2025-12-02 16:43:21', '2025-12-02', '14:00', '164 Lê Hồng Phong, Sóc Trăng, Tp Cần Thơ'),
(138, 'jun', '0382766381', 'RANGER RAPTOR', '', '2025-12-06 19:13:42', '2025-12-06', '11:00', '120 Trần Hưng Đạo, Sóc Trăng, Tp Cần Thơ'),
(139, 'jun', '0382766381', 'YARIS CROSS', 'FVR', '2025-12-18 08:56:27', '2025-12-18', '10:00', '120 Trần Hưng Đạo, Sóc Trăng, Tp Cần Thơ'),
(140, 'jun', '0382766381', 'YARIS CROSS', 'EQFRE', '2025-12-18 08:59:10', '2025-12-18', '10:00', '120 Trần Hưng Đạo, Sóc Trăng, Tp Cần Thơ');

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
(28, 38, 0, 10, 1, '2025-12-02 16:34:31'),
(31, 18, 0, 10, 1, '2025-12-18 14:23:06'),
(32, 18, 0, 11, 1, '2025-12-18 14:23:15'),
(36, 49, 0, 10, 3, '2025-12-18 15:48:27'),
(42, 49, 0, 102, 4, '2025-12-18 15:59:08'),
(43, 49, 0, 9, 2, '2025-12-18 17:00:22'),
(44, 49, 0, 7, 4, '2025-12-18 17:00:29'),
(45, 49, 0, 108, 3, '2025-12-18 17:00:38'),
(46, 49, 0, 13, 3, '2025-12-18 17:00:45');

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
(41, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-06', '17:50:24', 'Chuyển khoản ngân hàng', 1, '458000000', '2025-11-06'),
(71, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-20', '23:30:00', 'Chuyển khoản', 1, '1299000000', '2025-11-20'),
(72, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-21', '03:03:27', 'Thanh toán khi nhận hàng', 1, '1220000000', '2025-11-21'),
(73, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-21', '11:20:46', 'Chuyển khoản ngân hàng', 1, '1299000000', '2025-11-21'),
(74, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-21', '15:56:52', 'Chuyển khoản ngân hàng', 1, '1299000000', '2025-11-21'),
(91, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:06:21', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(92, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:06:53', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(93, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:15:39', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(106, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:33:39', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(107, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:36:16', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(108, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:36:28', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(109, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:39:28', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(110, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:39:39', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(111, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '17:39:50', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(123, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '18:00:45', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(124, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '18:01:31', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(125, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '18:01:47', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(126, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '18:02:09', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-11-25'),
(136, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-11-25', '18:51:19', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-11-25'),
(141, 'Nguyen Van A', '0912345678', '123 Đường Lê Lợi, TP HCM', '2023-05-10', '10:00:00', 'Thanh toán khi nhận hàng', 1, '1000000', '2023-05-10'),
(142, 'Tran Thi B', '0912345679', '456 Đường Hai Bà Trưng, Hà Nội', '2023-06-12', '11:00:00', 'Thanh toán khi nhận hàng', 1, '1200000', '2023-06-12'),
(143, 'Le Van C', '0912345680', '789 Đường Nguyễn Huệ, Đà Nẵng', '2023-07-15', '09:00:00', 'Thanh toán khi nhận hàng', 1, '1500000', '2023-07-15'),
(144, 'Pham Thi D', '0912345681', '321 Đường Trần Hưng Đạo, Cần Thơ', '2023-08-18', '14:00:00', 'Thanh toán khi nhận hàng', 1, '900000', '2023-08-18'),
(145, 'Hoang Van E', '0912345682', '654 Đường Phan Đình Phùng, Huế', '2023-09-20', '16:00:00', 'Thanh toán khi nhận hàng', 1, '1100000', '2023-09-20'),
(146, 'Nguyen Van F', '0923456780', '123 Đường Lê Lợi, TP HCM', '2024-03-10', '10:00:00', 'Thanh toán khi nhận hàng', 1, '1000000', '2024-03-10'),
(147, 'Tran Thi G', '0923456781', '456 Đường Hai Bà Trưng, Hà Nội', '2024-04-12', '11:30:00', 'Thanh toán khi nhận hàng', 1, '1200000', '2024-04-12'),
(148, 'Le Van H', '0923456782', '789 Đường Nguyễn Huệ, Đà Nẵng', '2024-05-15', '09:15:00', 'Thanh toán khi nhận hàng', 1, '1500000', '2024-05-15'),
(149, 'Pham Thi I', '0923456783', '321 Đường Trần Hưng Đạo, Cần Thơ', '2024-06-18', '14:20:00', 'Thanh toán khi nhận hàng', 1, '900000', '2024-06-18'),
(150, 'Hoang Van J', '0923456784', '654 Đường Phan Đình Phùng, Huế', '2024-07-20', '16:10:00', 'Thanh toán khi nhận hàng', 1, '1100000', '2024-07-20'),
(151, 'Nguyen Van A', '0912345678', '123 Đường Lê Lợi, TP HCM', '2023-05-10', '10:00:00', 'Thanh toán khi nhận hàng', 1, '1000000', '2023-05-10'),
(152, 'Tran Thi B', '0912345679', '456 Đường Hai Bà Trưng, Hà Nội', '2023-06-12', '11:00:00', 'Thanh toán khi nhận hàng', 1, '1200000', '2023-06-12'),
(153, 'Le Van C', '0912345680', '789 Đường Nguyễn Huệ, Đà Nẵng', '2023-07-15', '09:00:00', 'Thanh toán khi nhận hàng', 1, '1500000', '2023-07-15'),
(154, 'Pham Thi D', '0912345681', '321 Đường Trần Hưng Đạo, Cần Thơ', '2023-08-18', '14:00:00', 'Thanh toán khi nhận hàng', 1, '900000', '2023-08-18'),
(155, 'Hoang Van E', '0912345682', '654 Đường Phan Đình Phùng, Huế', '2023-09-20', '16:00:00', 'Thanh toán khi nhận hàng', 1, '1100000', '2023-09-20'),
(297, 'Nguyen Van A', '0901234001', '123 Le Loi, Quan 1, TP.HCM', '2023-02-15', '10:15:00', 'Chuyển khoản ngân hàng', 1, '12500000', '2023-02-15'),
(298, 'Tran Thi B', '0901234002', '45 Nguyen Trai, Ha Noi', '2023-04-10', '14:30:00', 'Thanh toán khi nhận hàng', 1, '8300000', '2023-04-10'),
(299, 'Le Minh C', '0901234003', '78 Tran Hung Dao, Da Nang', '2023-07-22', '09:05:00', 'Chuyển khoản ngân hàng', 1, '15600000', '2023-07-22'),
(300, 'Pham Thanh D', '0901234004', '12 Nguyen Hue, TP.HCM', '2023-09-03', '11:45:00', 'Thanh toán khi nhận hàng', 1, '5400000', '2023-09-03'),
(301, 'Vo Thi E', '0901234005', '67 Vo Van Tan, Can Tho', '2023-12-18', '16:20:00', 'Chuyển khoản ngân hàng', 1, '9800000', '2023-12-18'),
(302, 'Bui Hoang F', '0901234006', '89 Cach Mang, Da Nang', '2024-01-09', '08:50:00', 'Chuyển khoản ngân hàng', 1, '11100000', '2024-01-09'),
(303, 'Dang Thi G', '0901234007', '34 Hoang Dieu, Ha Noi', '2024-03-14', '13:10:00', 'Thanh toán khi nhận hàng', 1, '7600000', '2024-03-14'),
(304, 'Hoang Minh H', '0901234008', '22 Truong Dinh, Hue', '2024-05-27', '15:00:00', 'Chuyển khoản ngân hàng', 1, '14900000', '2024-05-27'),
(305, 'Ngo Thi I', '0901234009', '55 Hai Ba Trung, TP.HCM', '2024-08-19', '10:40:00', 'Thanh toán khi nhận hàng', 1, '6400000', '2024-08-19'),
(306, 'Pham Quang J', '0901234010', '98 Tran Phu, Da Nang', '2024-10-02', '12:05:00', 'Chuyển khoản ngân hàng', 1, '8500000', '2024-10-02'),
(307, 'Truong Van K', '0901234011', '102 Ly Thuong Kiet, Ha Noi', '2025-01-16', '09:30:00', 'Thanh toán khi nhận hàng', 1, '17200000', '2025-01-16'),
(308, 'Mai Thi L', '0901234012', '11 Bach Dang, Hai Phong', '2025-02-25', '17:20:00', 'Chuyển khoản ngân hàng', 1, '6900000', '2025-02-25'),
(309, 'Dang Bao M', '0901234013', '26 Nguyen Van Cu, TP.HCM', '2025-03-12', '14:55:00', 'Thanh toán khi nhận hàng', 1, '9100000', '2025-03-12'),
(310, 'Nguyen Kim N', '0901234014', '150 Hung Vuong, Hue', '2025-04-29', '11:10:00', 'Chuyển khoản ngân hàng', 1, '13500000', '2025-04-29'),
(311, 'Le Hoai O', '0901234015', '77 Le Duan, Da Nang', '2025-05-20', '16:45:00', 'Thanh toán khi nhận hàng', 1, '7200000', '2025-05-20'),
(312, 'Pham Gia P', '0901234016', '33 Cach Mang Thang 8, Ha Noi', '2025-06-11', '10:00:00', 'Chuyển khoản ngân hàng', 1, '15800000', '2025-06-11'),
(313, 'Hoang Bao Q', '0901234017', '44 Xo Viet Nghe Tinh, TP.HCM', '2025-07-08', '13:25:00', 'Thanh toán khi nhận hàng', 1, '6200000', '2025-07-08'),
(314, 'Ngo Thanh R', '0901234018', '55 Nguyen Thai Hoc, Da Lat', '2025-08-21', '09:40:00', 'Chuyển khoản ngân hàng', 1, '14800000', '2025-08-21'),
(315, 'Vu Thi S', '0901234019', '12 Tran Cao Van, Quang Nam', '2025-09-14', '15:55:00', 'Thanh toán khi nhận hàng', 1, '9100000', '2025-09-14'),
(316, 'Bui Hoang T', '0901234020', '166 Cach Mang, Ha Noi', '2025-11-30', '18:10:00', 'Chuyển khoản ngân hàng', 1, '13400000', '2025-11-30'),
(317, 'Nguyen Van A', '0901234001', '123 Le Loi, Quan 1, TP.HCM', '2023-01-12', '10:15:00', 'Chuyển khoản ngân hàng', 1, '12500000', '2023-01-12'),
(318, 'Tran Thi B', '0901234002', '45 Nguyen Trai, Ha Noi', '2023-02-05', '14:30:00', 'Thanh toán khi nhận hàng', 1, '8300000', '2023-02-05'),
(319, 'Le Minh C', '0901234003', '78 Tran Hung Dao, Da Nang', '2023-03-18', '09:05:00', 'Chuyển khoản ngân hàng', 1, '15600000', '2023-03-18'),
(320, 'Pham Thanh D', '0901234004', '12 Nguyen Hue, TP.HCM', '2023-04-22', '11:45:00', 'Thanh toán khi nhận hàng', 1, '5400000', '2023-04-22'),
(321, 'Vo Thi E', '0901234005', '67 Vo Van Tan, Can Tho', '2023-05-10', '16:20:00', 'Chuyển khoản ngân hàng', 1, '9800000', '2023-05-10'),
(322, 'Bui Hoang F', '0901234006', '89 Cach Mang, Da Nang', '2023-06-15', '08:50:00', 'Chuyển khoản ngân hàng', 1, '11100000', '2023-06-15'),
(323, 'Dang Thi G', '0901234007', '34 Hoang Dieu, Ha Noi', '2023-07-02', '13:10:00', 'Thanh toán khi nhận hàng', 1, '7600000', '2023-07-02'),
(324, 'Hoang Minh H', '0901234008', '22 Truong Dinh, Hue', '2023-07-28', '15:00:00', 'Chuyển khoản ngân hàng', 1, '14900000', '2023-07-28'),
(325, 'Ngo Thi I', '0901234009', '55 Hai Ba Trung, TP.HCM', '2023-08-19', '10:40:00', 'Thanh toán khi nhận hàng', 1, '6400000', '2023-08-19'),
(326, 'Pham Quang J', '0901234010', '98 Tran Phu, Da Nang', '2023-09-05', '12:05:00', 'Chuyển khoản ngân hàng', 1, '8500000', '2023-09-05'),
(328, 'Mai Thi L', '0901234012', '11 Bach Dang, Hai Phong', '2023-10-08', '17:20:00', 'Chuyển khoản ngân hàng', 1, '6900000', '2023-10-08'),
(329, 'Dang Bao M', '0901234013', '26 Nguyen Van Cu, TP.HCM', '2023-10-20', '14:55:00', 'Thanh toán khi nhận hàng', 1, '9100000', '2023-10-20'),
(330, 'Nguyen Kim N', '0901234014', '150 Hung Vuong, Hue', '2023-11-05', '11:10:00', 'Chuyển khoản ngân hàng', 1, '13500000', '2023-11-05'),
(331, 'Le Hoai O', '0901234015', '77 Le Duan, Da Nang', '2023-11-22', '16:45:00', 'Thanh toán khi nhận hàng', 1, '7200000', '2023-11-22'),
(332, 'Pham Gia P', '0901234016', '33 Cach Mang Thang 8, Ha Noi', '2023-12-02', '10:00:00', 'Chuyển khoản ngân hàng', 1, '15800000', '2023-12-02'),
(333, 'Hoang Bao Q', '0901234017', '44 Xo Viet Nghe Tinh, TP.HCM', '2023-12-18', '13:25:00', 'Thanh toán khi nhận hàng', 1, '6200000', '2023-12-18'),
(334, 'Ngo Thanh R', '0901234018', '55 Nguyen Thai Hoc, Da Lat', '2024-01-10', '09:40:00', 'Chuyển khoản ngân hàng', 1, '14800000', '2024-01-10'),
(335, 'Vu Thi S', '0901234019', '12 Tran Cao Van, Quang Nam', '2024-01-22', '15:55:00', 'Thanh toán khi nhận hàng', 1, '9100000', '2024-01-22'),
(336, 'Bui Hoang T', '0901234020', '166 Cach Mang, Ha Noi', '2024-02-15', '18:10:00', 'Chuyển khoản ngân hàng', 1, '13400000', '2024-02-15'),
(337, 'Nguyen Van U', '0901234021', '101 Le Lai, TP.HCM', '2024-03-03', '12:30:00', 'Thanh toán khi nhận hàng', 1, '7700000', '2024-03-03'),
(338, 'Tran Thi V', '0901234022', '88 Tran Quang Khai, Da Nang', '2024-03-20', '09:15:00', 'Chuyển khoản ngân hàng', 1, '11200000', '2024-03-20'),
(339, 'Le Minh W', '0901234023', '22 Nguyen Huu Canh, Hue', '2024-04-11', '14:40:00', 'Thanh toán khi nhận hàng', 1, '8900000', '2024-04-11'),
(340, 'Pham Thanh X', '0901234024', '33 Nguyen Van Cu, Ha Noi', '2024-04-25', '10:50:00', 'Chuyển khoản ngân hàng', 1, '12400000', '2024-04-25'),
(341, 'Vo Thi Y', '0901234025', '44 Tran Phu, TP.HCM', '2024-05-15', '16:20:00', 'Thanh toán khi nhận hàng', 1, '6300000', '2024-05-15'),
(342, 'Bui Hoang Z', '0901234026', '55 Le Lai, Da Nang', '2024-06-02', '11:10:00', 'Chuyển khoản ngân hàng', 1, '15700000', '2024-06-02'),
(343, 'Dang Thi AA', '0901234027', '66 Nguyen Trai, Ha Noi', '2024-06-18', '15:05:00', 'Thanh toán khi nhận hàng', 1, '9800000', '2024-06-18'),
(344, 'Hoang Minh BB', '0901234028', '77 Tran Hung Dao, Hue', '2024-07-05', '09:45:00', 'Chuyển khoản ngân hàng', 1, '12300000', '2024-07-05'),
(345, 'Ngo Thi CC', '0901234029', '88 Hai Ba Trung, TP.HCM', '2024-07-22', '12:35:00', 'Thanh toán khi nhận hàng', 1, '8900000', '2024-07-22'),
(346, 'Pham Quang DD', '0901234030', '99 Le Duan, Da Nang', '2024-08-10', '14:15:00', 'Chuyển khoản ngân hàng', 1, '13100000', '2024-08-10'),
(347, 'admin', '0483777436', '147 le hong phong, p2, tp can tho', '2025-12-07', '21:05:04', 'Thanh toán khi nhận hàng', 1, '1299000000', '2025-12-07'),
(348, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '10:23:35', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-12-08'),
(349, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '10:23:50', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-12-08'),
(350, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '10:24:05', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-12-08'),
(351, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '10:28:33', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-12-08'),
(352, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '10:29:02', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-12-08'),
(353, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '10:29:42', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-12-08'),
(356, 'ju', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '10:34:00', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-12-08'),
(360, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '11:06:16', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-12-08'),
(361, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '11:06:42', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-12-08'),
(362, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '11:11:07', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-12-08'),
(363, 'ju', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '11:18:00', 'Thanh toán khi nhận hàng', 1, '950000000', '2025-12-08'),
(373, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '12:43:39', 'Chuyển khoản ngân hàng', 1, '638000000', '2025-12-08'),
(374, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '12:47:44', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-12-08'),
(375, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '12:47:55', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-12-08'),
(376, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '12:48:57', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-12-08'),
(377, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '12:52:30', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-12-08'),
(378, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '12:53:13', 'Thanh toán khi nhận hàng', 1, '1220000000', '2025-12-08'),
(379, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '12:53:44', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-12-08'),
(380, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '12:53:55', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-12-08'),
(381, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '12:54:08', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-12-08'),
(382, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '12:56:04', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-12-08'),
(383, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '12:56:59', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-12-08'),
(384, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '12:57:34', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-12-08'),
(385, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '12:58:03', 'Thanh toán khi nhận hàng', 1, '1220000000', '2025-12-08'),
(386, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '13:00:51', 'Thanh toán khi nhận hàng', 1, '638000000', '2025-12-08'),
(387, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '13:01:44', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-12-08'),
(388, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '13:02:51', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-12-08'),
(389, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '13:05:24', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-12-08'),
(390, 'ju', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '13:05:00', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-12-08'),
(391, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '13:05:51', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-12-08'),
(392, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '13:33:56', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-12-08'),
(393, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '13:34:32', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-12-08'),
(394, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '13:34:50', 'Chuyển khoản ngân hàng', 1, '1220000000', '2025-12-08'),
(399, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-08', '14:37:47', 'Thanh toán khi nhận hàng', 1, '1220000000', '2025-12-08'),
(400, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-18', '09:01:27', 'Thanh toán khi nhận hàng', 1, '1220000000', '2025-12-18'),
(401, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-18', '09:01:43', 'Chuyển khoản ngân hàng', 1, '725000000', '2025-12-18'),
(402, 'khach2', '0974834373', '2', '2025-12-18', '17:01:12', 'Thanh toán khi nhận hàng', 1, '9999999999', '2025-12-18'),
(403, 'khach2', '0974834373', '2', '2025-12-18', '17:12:14', 'Thanh toán khi nhận hàng', 1, '725000000', '2025-12-18'),
(404, 'jun', '0382766381', '387 phan đình phùng , p3 , tp cần thơ', '2025-12-18', '17:32:07', 'Thanh toán khi nhận hàng', 1, '650000000', '2025-12-18');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `ID` int(11) NOT NULL,
  `TenTK` varchar(30) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `MatKhau` varchar(50) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `Quyen` varchar(8) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `NgayCapNhat` datetime NOT NULL,
  `phone` varchar(15) COLLATE utf8_vietnamese_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `DiaChi` varchar(300) COLLATE utf8_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`ID`, `TenTK`, `MatKhau`, `Quyen`, `NgayCapNhat`, `phone`, `email`, `DiaChi`) VALUES
(15, 'jun', '$2y$10$Tesz4MkS82rM8Liv0F34zOsz5oS.XP31rw/u7sU/ApC', '', '2025-11-05 11:07:38', '0382766381', 'nhthin366@gmail.com', ''),
(16, 'tuan', '$2y$10$WMTkwnXROOT8yYoSlbl5rut7KxSetlHbGF8q1/SEdi/', '', '2025-11-05 17:48:01', '0293872562', 'tuuabgwem', ''),
(17, 'ừvr', '', '', '2025-12-06 18:21:31', '039754577', 'G@gmail.com', '111 lhp , p2 , tp can tho'),
(18, 'khach2', '', '', '2025-12-08 07:53:27', '0974834373', 'dcbd@gmail.com', 'd83gue');

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
(2, 3, '2025-12-07 10:32:48', 0, 3, 1),
(3, 4, '2025-11-18 21:13:36', 4, 2, 0),
(4, 5, '2025-12-07 10:38:58', 10, 0, 2),
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
(24, 111, '2025-11-18 21:15:14', 3, 4, 0);

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
(36, 'FG', '$2y$10$T5MFz1kgR2X.d/EGgVFDKOavMsHHkDIiLKaHcJJUDG1CWj7ti9yde', '1', '2025-12-01 12:07:18', '111 lhp , p2 , tp can tho', '0374888374', 'FE6@gmail.com'),
(40, 'moi', '$2y$10$2zah45WVEyW9ra11XFGsz.6vpn8t9Tm0A6v.xGaMjwqPT9L3Vr5Qa', '1', '2025-12-02 09:59:02', '263 lto ptp st', '0846763547', 'vey6@gmail.com'),
(41, 'bdfry', '$2y$10$Ni9Qsc.lZ0y3x7Sf0Oh7UOo1iOlcBjkyJedoGTpdqlAVcqbv09xEW', '1', '2025-12-06 18:11:02', '35 lhp , p2 , tp can tho', '03957483', 'df@gmail.com'),
(42, 'VBY', '$2y$10$vPVCDezBZXyITU46In6pP.nsnfutRSPbOHoitjIKVzDU.K2jcQida', '1', '2025-12-06 18:15:49', '272 lhp , p2 , tp can tho', '034835344', 'BCY@gmail.com'),
(43, 'cbdh', '$2y$10$zqRucJ57fgx5yKmOpdBRZuzMB/Irn2HGj0NtKdTZpet1duROpurmG', '1', '2025-12-06 18:18:17', '272 lhp , p2 , tp can tho', '034835344', 'chhs@gmail.com'),
(44, 'vêcbd', '$2y$10$KWdDWcUPTzy4.swDovzkS.ANUfVtbfunrdP4I9.ve3txRqLkfh2l.', '1', '2025-12-06 18:19:43', '272 lhp , p2 , tp can tho', '034835344', 'cbysd@gmail.com'),
(48, 'khanh1', '$2y$10$UtDnDo1Zmt/p7wXYglcGhuaPD9RRamGq/Bppg7BUt44rhX5feiU1q', '1', '2025-12-08 07:49:24', '1ff  rfrexw ffs', '023894473', 'khach1@gmail.com'),
(49, 'khach2', '$2y$10$aVdK19eHYX1ouqMONKw15.clgWdh.ilVAmAPy98q8Vzc6NuIH.v7W', '1', '2025-12-18 08:41:30', '2', '0974834373', 'dcbd@gmail.com');

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
(111, 'HONDA JAZZ1', '5 chỗ', '2025-11-30', 'sp1.png', 'Hatchback', 480000000, '20', 'Xăng', 'Nhật Bản');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thongsokithuat`
--

CREATE TABLE `thongsokithuat` (
  `ID` bigint(20) NOT NULL,
  `SanPhamID` bigint(20) NOT NULL,
  `LoaiNhienLieu` varchar(50) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `CongSuatHP` int(11) DEFAULT NULL,
  `HopSo` varchar(50) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `TangToc` float DEFAULT NULL,
  `TocDoToiDa` int(11) DEFAULT NULL,
  `TrongLuong` int(11) DEFAULT NULL,
  `ChoNgoi` int(11) DEFAULT NULL
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
(20, 107, 'Xăng', 380, 'Tự động 9 cấp', 5.5, 250, 2180, 5),
(21, 108, 'Xăng', 375, 'Tự động 8 cấp', 5.3, 243, 2140, 5),
(22, 109, 'Xăng', 82, 'Tự động CVT', 13, 160, 915, 5),
(23, 110, 'Xăng', 106, 'CVT', 12.8, 165, 1040, 5),
(24, 111, 'Xăng', 117, 'CVT', 12, 175, 1120, 5);

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
(16, 113, 'Hủy', '2025-12-02 17:22:18'),
(17, 117, 'Đang láy thử', '2025-11-22 22:04:39'),
(18, 112, 'Đang láy thử', '2025-12-18 08:59:56'),
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
(32, 112, 'Đang láy thử', '2025-12-18 08:59:56'),
(33, 112, 'Đang láy thử', '2025-12-18 08:59:56'),
(34, 115, 'Đang láy thử', '2025-11-17 23:51:42'),
(35, 115, 'Hoàn tất', '2025-11-17 23:51:44'),
(36, 115, 'Hoàn tất', '2025-11-17 23:51:44'),
(37, 115, 'Hoàn tất', '2025-11-17 23:51:45'),
(38, 112, 'Đang láy thử', '2025-12-18 08:59:56'),
(39, 112, 'Đang láy thử', '2025-12-18 08:59:56'),
(40, 112, 'Đang láy thử', '2025-12-18 08:59:56'),
(41, 112, 'Đang láy thử', '2025-12-18 08:59:56'),
(42, 112, 'Đang láy thử', '2025-12-18 08:59:56'),
(43, 112, 'Đang láy thử', '2025-12-18 08:59:56'),
(44, 112, 'Đang láy thử', '2025-12-18 08:59:56'),
(45, 112, 'Đang láy thử', '2025-12-18 08:59:56'),
(46, 112, 'Đang láy thử', '2025-12-18 08:59:56'),
(47, 113, 'Hủy', '2025-12-02 17:22:18'),
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
(59, 129, 'Hoàn tất', '2025-11-22 22:04:29'),
(60, 130, 'Chờ xác nhận', '2025-12-02 17:21:19'),
(61, 131, 'Chờ xác nhận', '2025-12-02 17:21:19'),
(62, 132, 'Chờ xác nhận', '2025-12-02 17:21:19'),
(63, 134, 'Hoàn tất', '2025-12-02 17:23:04'),
(64, 133, 'Chờ xác nhận', '2025-12-02 17:21:19'),
(65, 135, 'Chờ xác nhận', '2025-12-02 17:21:19'),
(66, 136, 'Chờ xác nhận', '2025-12-02 17:21:19'),
(67, 138, 'Chờ xác nhận', '2025-12-07 21:44:45'),
(68, 139, 'Chờ xác nhận', '2025-12-18 08:59:40'),
(69, 140, 'Chờ xác nhận', '2025-12-18 08:59:40');

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
(14, 'Thiên Nh', 21, '0382766381', '190 dương minh quan, p2 , tp sóc trăng', 'Đã giao hàng'),
(16, 'Thiên Nh', 12, '0382766381', '190 dương minh quan, p2 , tp sóc trăng', 'Đã đến kho'),
(19, 'jun', 11, '0382766381', '190 dương minh quan, p2 , tp sóc trăng', 'Đã giao hàng'),
(20, 'jun', 41, '0382766381', '387 phan đình phùng , p3 , tp cần thơ', 'Đã lấy hàng'),
(23, 'jun', 72, '0382766381', '387 phan đình phùng , p3 , tp cần thơ', 'Đã giao hàng'),
(24, 'jun', 73, '0382766381', '387 phan đình phùng , p3 , tp cần thơ', 'Đang giao hàng'),
(32, 'jun', 348, '0382766381', '387 phan đình phùng , p3 , tp cần thơ', 'Đã giao hàng'),
(33, 'jun', 351, '0382766381', '387 phan đình phùng , p3 , tp cần thơ', 'Đã giao hàng'),
(34, 'jun', 349, '0382766381', '387 phan đình phùng , p3 , tp cần thơ', 'Đã giao hàng'),
(35, 'jun', 375, '0382766381', '387 phan đình phùng , p3 , tp cần thơ', 'Đã giao hàng'),
(36, 'jun', 400, '0382766381', '387 phan đình phùng , p3 , tp cần thơ', 'Đã đến kho'),
(37, 'jun', 387, '0382766381', '387 phan đình phùng , p3 , tp cần thơ', 'Đang vận chuyển'),
(38, 'jun', 382, '0382766381', '387 phan đình phùng , p3 , tp cần thơ', 'Đang lấy hàng'),
(39, 'jun', 401, '0382766381', '387 phan đình phùng , p3 , tp cần thơ', 'Đã giao hàng'),
(40, 'khach2', 402, '0974834373', '2', 'Đã giao hàng'),
(41, 'khach2', 403, '0974834373', '2', 'Đã giao hàng'),
(47, 'Nguyen Van A', 151, '0912345678', '123 Đường Lê Lợi, TP HCM', 'Đã giao hàng'),
(48, 'Tran Thi B', 152, '0912345679', '456 Đường Hai Bà Trưng, Hà Nội', 'Đã giao hàng'),
(49, 'Le Van C', 153, '0912345680', '789 Đường Nguyễn Huệ, Đà Nẵng', 'Đã giao hàng'),
(50, 'Pham Thi D', 154, '0912345681', '321 Đường Trần Hưng Đạo, Cần Thơ', 'Đã giao hàng'),
(51, 'Hoang Van E', 155, '0912345682', '654 Đường Phan Đình Phùng, Huế', 'Đã giao hàng'),
(52, 'Nguyen Van F', 146, '0923456780', '123 Đường Lê Lợi, TP HCM', 'Đã giao hàng'),
(53, 'Tran Thi G', 147, '0923456781', '456 Đường Hai Bà Trưng, Hà Nội', 'Đã giao hàng'),
(54, 'Le Van H', 148, '0923456782', '789 Đường Nguyễn Huệ, Đà Nẵng', 'Đã giao hàng'),
(55, 'Pham Thi I', 149, '0923456783', '321 Đường Trần Hưng Đạo, Cần Thơ', 'Đã giao hàng'),
(56, 'Hoang Van J', 150, '0923456784', '654 Đường Phan Đình Phùng, Huế', 'Đã giao hàng'),
(57, 'jun', 404, '0382766381', '387 phan đình phùng , p3 , tp cần thơ', 'Đã giao hàng');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT cho bảng `giohang`
--
ALTER TABLE `giohang`
  MODIFY `MaGioHang` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=405;

--
-- AUTO_INCREMENT cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `kho_xe_laythu`
--
ALTER TABLE `kho_xe_laythu`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;

--
-- AUTO_INCREMENT cho bảng `thongsokithuat`
--
ALTER TABLE `thongsokithuat`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT cho bảng `trangthai_laythu`
--
ALTER TABLE `trangthai_laythu`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT cho bảng `vanchuyen`
--
ALTER TABLE `vanchuyen`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

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
