-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 13, 2020 lúc 10:41 AM
-- Phiên bản máy phục vụ: 10.4.14-MariaDB
-- Phiên bản PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `test`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `status`
--

CREATE TABLE `status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `status`
--

INSERT INTO `status` (`id`, `value`, `created_at`, `updated_at`) VALUES
(1, 'Chờ Duyệt', NULL, NULL),
(2, 'Chờ Lấy Hàng', NULL, NULL),
(3, 'Đang Lấy Hàng', NULL, NULL),
(4, 'Đã Lấy Hàng', NULL, NULL),
(5, 'Hoãn Lấy Hàng', NULL, NULL),
(10, 'Không Lấy Được', NULL, NULL),
(11, 'Đang Nhập Kho', NULL, NULL),
(12, 'Đã Nhập Kho', NULL, NULL),
(13, 'Đang Chuyển Kho Giao', NULL, NULL),
(14, 'Đã Chuyển Kho Giao', NULL, NULL),
(15, 'Đang Giao Hàng', NULL, NULL),
(16, 'Đã Giao Hàng Toàn Bộ', NULL, NULL),
(17, 'Đã Giao Hàng Một Phần', NULL, NULL),
(18, 'Hoãn Giao Hàng', NULL, NULL),
(19, 'Không Giao Được', NULL, NULL),
(20, 'Đã Đối Soát Giao Hàng', NULL, NULL),
(21, 'Đã Đối Soát Trả Hàng', NULL, NULL),
(22, 'Đang Chuyển Kho Trả', NULL, NULL),
(23, 'Đang Trả Hàng', NULL, NULL),
(24, 'Đã Trả Hàng', NULL, NULL),
(25, 'Hoãn Trả Hàng', NULL, NULL),
(26, 'Huỷ', NULL, NULL),
(27, 'Đang Vận Chuyển', NULL, NULL),
(28, 'Xác Nhận Hoàn', NULL, NULL),
(29, 'Đã Hủy', NULL, NULL),
(30, 'Chưa Thanh Toán', NULL, NULL),
(31, 'Đã Thanh Toán', NULL, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `status`
--
ALTER TABLE `status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
