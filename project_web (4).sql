-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 23, 2019 lúc 12:21 PM
-- Phiên bản máy phục vụ: 10.4.8-MariaDB-log
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
-- Cơ sở dữ liệu: `project_web`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `year` year(4) NOT NULL,
  `start_time` datetime NOT NULL,
  `last_time` datetime NOT NULL,
  `choose` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `name`, `year`, `start_time`, `last_time`, `choose`) VALUES
(1, 'Học kì 1', 2019, '2019-12-10 02:00:00', '2019-12-22 00:00:00', 1),
(10, '2', 2002, '2019-12-27 23:12:00', '2019-12-28 17:12:00', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `code` varchar(15) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `subjects`
--

INSERT INTO `subjects` (`id`, `session_id`, `code`, `name`) VALUES
(2, 1, 'INT9', 'Toán rời rạc'),
(3, 1, 'INT1', 'SXTK'),
(5, 1, 'INT6', 'Tin 4'),
(14, 1, 'INT10', 'Cơ nhiệt'),
(22, 10, 'INT2', 'Anh 1'),
(23, 1, 'INT2', 'Anh 1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tests`
--

CREATE TABLE `tests` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `test_room_id` int(11) NOT NULL,
  `time_id` int(11) NOT NULL,
  `computer_registered` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `tests`
--

INSERT INTO `tests` (`id`, `subject_id`, `test_room_id`, `time_id`, `computer_registered`) VALUES
(69, 5, 2, 3, 7),
(73, 3, 2, 1, 0),
(76, 14, 3, 1, 2),
(78, 23, 2, 4, 4),
(80, 2, 2, 6, 1),
(81, 3, 2, 6, 0),
(82, 2, 3, 6, 0),
(83, 2, 1, 3, 30),
(84, 2, 3, 7, 1),
(85, 3, 3, 3, 0),
(86, 2, 4, 3, 0),
(88, 3, 5, 3, 0),
(89, 22, 3, 9, 0),
(90, 22, 2, 9, 0),
(91, 22, 4, 9, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `test_rooms`
--

CREATE TABLE `test_rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `total_computer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `test_rooms`
--

INSERT INTO `test_rooms` (`id`, `name`, `total_computer`) VALUES
(1, '305', 30),
(2, '306', 30),
(3, '307', 30),
(4, '308', 30),
(5, '309', 30);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `times`
--

CREATE TABLE `times` (
  `id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `test_day` date NOT NULL,
  `start_time` time NOT NULL,
  `last_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `times`
--

INSERT INTO `times` (`id`, `session_id`, `test_day`, `start_time`, `last_time`) VALUES
(1, 1, '2019-12-22', '07:00:00', '09:00:00'),
(3, 1, '2019-12-21', '17:20:00', '19:20:00'),
(4, 1, '2019-12-22', '17:40:00', '21:40:00'),
(6, 1, '2019-12-22', '09:40:00', '12:40:00'),
(7, 1, '2019-12-23', '13:00:00', '15:00:00'),
(9, 10, '2019-12-23', '17:46:00', '19:46:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `role` varchar(10) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `date_birth` date NOT NULL,
  `class` varchar(60) NOT NULL,
  `email` varchar(50) NOT NULL,
  `token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `first_name`, `last_name`, `date_birth`, `class`, `email`, `token`) VALUES
(1, 'admin', '$2y$10$T2bingEGDpcI0M6VOH.sweQdvT8i/IRGgNJrnMu3sZgZjp8m.gfD.', 'admin', 'Nguyễn', 'admin', '2019-12-01', 'admin', 'phongcoibg99@gmail.com', '9214ca657e7c1b96e9a10459688a09b852bb845a'),
(2, '17020954', '$2y$10$6bvkR/OREVGwD./9sCBd2uJH.5ncxrQjigoo41fCZLsXppqfyGC4m', 'user', 'Nguyễn Văn', 'Phong', '2019-10-09', 'K62CB', '17020954@jahskjhaskjdj.sa', ''),
(3, '16021910', '$2y$10$3emBP6CckxsNo9.RorMljepFPuiSEN6CW5fE1Ny1f743fCPUnHuHC', 'user', 'Nguyễn Việt', 'Anh', '1997-10-29', 'QH-2016-I/CQ-H', '', ''),
(4, '15022614', '$2y$10$tl7/6dNqkvDENiTldU15EeOE7ohzpuaCS5aQX/0IHfw3r9LRvskz.', 'user', 'Tạ Thị Ngọc', 'Ánh', '1997-07-20', 'QH-2015-I/CQ-V', '', ''),
(5, '17020598', '$2y$10$i1S78/EBZbdJPZa9ePps7.JkR6Uvq1wvPzz34znwDTCBe1xxUBP5q', 'user', 'Vũ Ngọc', 'Ánh', '1999-10-15', 'QH-2017-I/CQ-IE2', '', ''),
(6, '15021207', '$2y$10$tv9LdRsu1BtG1qANmU9T0.E2mLMbChrLD0EmyQooe0JHGqLhZjwvu', 'user', 'Huỳnh Quốc', 'Bảo', '1997-03-26', 'QH-2015-I/CQ-M', '', ''),
(7, '17020612', '$2y$10$rxs8oJf97ioy5cHvR.ejLO/oRvzcf7Y/wGd17E6/MJ8FDPDUe7eMi', 'user', 'Phạm Văn', 'Chính', '1999-06-13', 'QH-2017-I/CQ-IE2', '', ''),
(8, '13020042', '$2y$10$A14mnw0QN7wUac5ZZD56IeyoAPiQ/KOcEm7smhwhod..nTjOZ1Z1W', 'user', 'Hoàng Văn', 'Công', '1995-06-22', 'QH-2013-I/CQ-Đ-B', '', ''),
(9, '17020619', '$2y$10$vYJpxhsL6PqAgCY7ER5m6eGWq2f72avWkhgkqjN4g/vNQfP.JHx3S', 'user', 'Nguyễn Thành', 'Công', '1999-06-07', 'QH-2017-I/CQ-IE2', '', ''),
(10, '17020624', '$2y$10$ZPVCg/84l.9LxHiHAl.yPuwXzmzq9G9lVMKcqYkXBDCLpC1V961ge', 'user', 'Đinh Việt', 'Cường', '1999-03-12', 'QH-2017-I/CQ-IE8', '', ''),
(11, '14020579', '$2y$10$Yzw10AmoTqWuGU1/TzMrr..nCp1aEE//fnEVZHRbNWkfMuOKS6NU6', 'user', 'Trần Bá', 'Cường', '1996-07-27', 'QH-2014-I/CQ-M', '', ''),
(12, '17020631', '$2y$10$lem36WuEcXHGJ72tKNP.YOUkoNfJLeZ4hPHsu7P71FADt7qdIAluK', 'user', 'Phạm Mạnh', 'Dân', '1998-05-26', 'QH-2017-I/CQ-IE2', '', ''),
(13, '17020645', '$2y$10$VLgwIRQyTgGbgUSeGNFJnOhOWS39REn90LEdstyLpHLf/QkHXcs5.', 'user', 'Đào Văn', 'Duy', '1999-03-23', 'QH-2017-I/CQ-IE2', '', ''),
(14, '13020708', '$2y$10$fxHHLh/CU1KL7iD6jknoIuz.TddISaqbo/5VdYXH7eMZ4uY/nx/y6', 'user', 'Hà Mạnh', 'Duy', '1993-10-25', 'QH-2013-I/CQ-C-B', '', ''),
(15, '17020191', '$2y$10$4k68CoYKYIuXI6.fjlOAme2ECfkQmmYfTG41DCZlFcdElwfre4adK', 'user', 'Ngô Quang', 'Dương', '1998-12-01', 'QH-2017-I/CQ-IE5', '', ''),
(16, '14020107', '$2y$10$QoFvPm.J3R2cZ1ftHURrp.jOFoci/4mDaDxiKgoheogBm7pCtcVMa', 'user', 'Vũ Văn', 'Đỉnh', '1996-12-01', 'QH-2014-I/CQ-M', '', ''),
(17, '17020687', '$2y$10$3wo4cS/gWzkZdi9S5qZam.PFEYVvV/./6t7rxi72Vy2f6ymbq8LVy', 'user', 'Phạm Ngọc', 'Đông', '1999-12-08', 'QH-2017-I/CQ-IE2', '', ''),
(18, '15022511', '$2y$10$fl.Ln9OsELfXkwvrrF4Fhe6.sRIlRjEOerW.t1liD6yPhIIvi.Aju', 'user', 'Bạch Thái', 'Đức', '1997-12-05', 'QH-2015-I/CQ-M', '', ''),
(19, '17020691', '$2y$10$yPlWiwy.WiaSlxd6hDQeLu6moriD2pZxqkQyWoG/8OE5Vkmwk0E26', 'user', 'Dương Minh', 'Đức', '1997-10-30', 'QH-2017-I/CQ-IE8', '', ''),
(20, '17020692', '$2y$10$rRVOoJLzSQhXMksN8e6jzuV8x84SVHF9vtJ44gmzkV/Xa/fEU42ie', 'user', 'Đào Anh', 'Đức', '1999-04-26', 'QH-2017-I/CQ-IE5', '', ''),
(21, '16020074', '$2y$10$sD9I/L6w.RNSG9IlncKKc.h3yA9GwUOdT/XKHFJCVky92gGJ4qlTG', 'user', 'Trương Hà Anh', 'Đức', '1997-06-04', 'QH-2016-I/CQ-C-B', '', ''),
(22, '13020532', '$2y$10$wZfZHZhfUgicGduQw59jfeMODjWBvdMtzVysjfOmzSUywq.X2mIRm', 'user', 'Trần Hải', 'Đường', '1995-05-07', 'QH-2013-I/CQ-V', '', ''),
(23, '17020181', '$2y$10$kf9URTSh6T4l9WaEy/J.KeLDRpFQq0YwLD0jNl6aDH0d93X1num7S', 'user', 'Lẻo Thị Thu', 'Hà', '1998-10-24', 'QH-2017-I/CQ-IE2', '', ''),
(24, '13020141', '$2y$10$xXvlpYNH/ZeUtOxnj7I8AujaoAapZrB7fbmrDEm.DEcQcW3z6mz1K', 'user', 'Trần Quang', 'Hải', '1994-10-05', 'QH-2013-I/CQ-V', '', ''),
(25, '16022368', '$2y$10$CHukQiYDmyDPXlbRruJJautQ7lLENkitFUBJkI0xqvw/W4XjjYRf.', 'user', 'Bùi Thị', 'Hiền', '1998-03-13', 'QH-2016-I/CQ-T', '', ''),
(26, '16020370', '$2y$10$8hHqKsWikw/YT3hxYCxxsuQYa15/m7evy5cSAlUWqxJPDAxv0pub6', 'user', 'Nguyễn Vinh', 'Hiển', '1998-11-14', 'QH-2016-I/CQ-H', '', ''),
(27, '17020735', '$2y$10$x8DXISMTlJbQMSVXqYoNoO7oXg1i6BMoiMvBM2Txq6n1Tnd/r2d.m', 'user', 'Nguyễn Quang', 'Hiệp', '1999-03-04', 'QH-2017-I/CQ-IE9', '', ''),
(28, '16022075', '$2y$10$vF36eETH2/DiE.7uWuu88eAUEYW8ZveOVi6mkJ0yTLGaLtxTZKW8G', 'user', 'Đoàn Trung', 'Hiếu', '1998-09-26', 'QH-2016-I/CQ-T', '', ''),
(29, '17020745', '$2y$10$cuIg7PM2cV0qVwIaZJQDCOngJVYx4h7tsGrDDnNhFsWNgPtw8ZVfS', 'user', 'Nguyễn Minh', 'Hiếu', '1999-06-17', 'QH-2017-I/CQ-IE2', '', ''),
(30, '16022327', '$2y$10$QIHd49fhBQKVK/pmy4P78.rq1GZ29qCpyZHX1uK5sMoe4tc59NZnW', 'user', 'Nguyễn Vũ Minh', 'Hiếu', '1998-04-23', 'QH-2016-I/CQ-H', '', ''),
(31, '16022259', '$2y$10$aG7GVfCexVCAgKCUYDwNu.Qv7wOkEcfA4UjALPRppPDQg3Z43LbHW', 'user', 'Lê Công', 'Hoàn', '1997-06-18', 'QH-2016-I/CQ-M', '', ''),
(32, '16020380', '$2y$10$GCdLLcx5PKawWl8aqnweUOcUqKD.qzCfakotusnjvsT0NtgnlMRsq', 'user', 'Nguyễn Thế', 'Hoàng', '1998-01-28', 'QH-2016-I/CQ-H', '', ''),
(33, '17020770', '$2y$10$mrN/SW3j14XeAhM.Js5b9.pIYoyVKii5daWcNXFLJAcspjIz0STXC', 'user', 'Nguyễn Việt', 'Hoàng', '1999-04-13', 'QH-2017-I/CQ-IE3', '17020954@kjhjashjasd.sas', ''),
(38, 'adminsa', '$2y$10$dlneDXqZ14sJC5lEGVXtse9rOoKqjIiKhCkXqmJfPIpFoF0y/4FFu', 'user', 'asdsad', 'dsadsa', '2019-12-26', 'dsadsa', '', NULL),
(40, 'adminád', '$2y$10$TPIV8Tl7TIT9lxPinKcdJ.PUPNONqh/XCJXumK962gFfGWmKQ/wHS', 'user', 'sdasdasd', 'ádasd', '2019-12-05', 'ádasdas', '', NULL),
(42, 'adminsdsfsdfdsffds', '$2y$10$VoF/f2c0K9uSsHH.SiEUau7IeKnmif0bG0x/VDdELSeSt9ixl4mia', 'user', 'sdfdfs', 'sdffds', '2019-12-06', 'dsffdssdf', '', NULL),
(43, '16022372', '$2y$10$sHEkV1YoH7Nb/VnrdtNisO2IoriwuX2jxs1HgnQ/gHlM0EEipdife', 'user', 'Trần Vũ', 'Hoàng', '1997-06-10', 'QH-2016-I/CQ-T', '', NULL),
(44, '16020978', '$2y$10$pWgBYzYgh7o3oHBcCCnGIu8yDvKkZ0UEMuDpBVEvg1n3YzXemhIg2', 'user', 'Vũ Huy', 'Hoàng', '1997-07-27', 'QH-2016-I/CQ-C-C', '', NULL),
(45, '17020779', '$2y$10$m2TPagDYspKaN7lsesdXVeOFO./jMmO6uTXD8s.4pNZHNttnAYTmG', 'user', 'Lê Viết', 'Hoành', '1999-04-26', 'QH-2017-I/CQ-IE6', '', NULL),
(46, '16020980', '$2y$10$SwPzSl66NpucqEutMtCzHuQUXX3GGl8cEWfq2Y9J4PAgTF7NRXjJu', 'user', 'Trần Đức', 'Học', '1997-02-11', 'QH-2016-I/CQ-C-C', '', NULL),
(47, '17020183', '$2y$10$fYi/lHXnNTKuKNc.L14FCeQjJHl29dNL8wSbFRZzwKsZos7PNYP9q', 'user', 'Hoàng Việt', 'Hùng', '1998-10-23', 'QH-2017-I/CQ-IE6', '', NULL),
(48, '17020157', '$2y$10$XZ2Frwp7KvLnCcx3shcsZ.lhQGYC/kZdQQnCPANCUubS2f7lL5UCu', 'user', 'Lê Mạnh', 'Hùng', '1998-09-25', 'QH-2017-I/CQ-IE8', '', NULL),
(49, '16020384', '$2y$10$2vMcAyKj3.zBB5Bwkj0Bae.12Wn9gPzvAwdzz7uVxwThBfU10Ph86', 'user', 'Vương Mạnh', 'Hùng', '1998-01-21', 'QH-2016-I/CQ-H', '', NULL),
(50, '16020388', '$2y$10$bCKQJ7.Zv5zeXgxM/fFMUeYjF58Xlz8KIL2Sj7gs3R50NLB6VIhdK', 'user', 'Lê Quang', 'Huy', '1998-12-31', 'QH-2016-I/CQ-H', '', NULL),
(51, '15021814', '$2y$10$wVItNmcOy/.OJZAR3GpLFehARdj/aPFTcjFxDXprFGkQWGqbWI26C', 'user', 'Nguyễn Duy', 'Huy', '1997-03-01', 'QH-2015-I/CQ-M', '', NULL),
(52, '17020801', '$2y$10$NVGgV1h5zoiSKL94Qfd.2u1Z6W6jYsqry63rmcUzZVCvRmFbRvc/m', 'user', 'Phan Quốc', 'Huy', '1999-02-05', 'QH-2017-I/CQ-IE1', '', NULL),
(53, '17021420', '$2y$10$km5v6OKj1rOlsDRaNE0VquO8FoODRbZVcuWJaooKwU5IwoQ5TQaTO', 'user', 'Nguyễn Xuân', 'Huyến', '1992-04-01', 'QH-2017-I/CQ-PE1', '', NULL),
(54, '16021955', '$2y$10$oj/sXxiuOM9RNkpGszVhq.s4MFqv3HWQS.XdU0lasOFWpjV8iA9T6', 'user', 'Phạm Quốc', 'Hưng', '1998-11-21', 'QH-2016-I/CQ-Đ-B', '', NULL),
(55, '17020818', '$2y$10$o1fIko9tbHdLxXNayJnXieZAaAnmylfa8oO/WHuaPZ4JO.tSGpo4O', 'user', 'Trịnh Ngọc', 'Hưng', '1999-04-02', 'QH-2017-I/CQ-IE2', '', NULL),
(56, '14020232', '$2y$10$vM/zaRR3W7GudyI1fRjTCug4862L3nvflv6/UaU5clsBbEpGEZdvm', 'user', 'Nguyễn Đình', 'Khang', '1995-05-06', 'QH-2014-I/CQ-M', '', NULL),
(57, '14020595', '$2y$10$vPdeJB3VxX/3A8K0wBxj3eDM7E4IN3N4i9K0XiMVCN4EKLuHqeL9y', 'user', 'Võ Văn', 'Khôi', '1996-08-23', 'QH-2014-I/CQ-Đ-B', '', NULL),
(58, '17020841', '$2y$10$JUJAPV7ticDyu4bTk53CH.OsvBsE/hCfBKByusHwaJ8uB9IWlyoau', 'user', 'Nguyễn Trung', 'Kiên', '1999-11-04', 'QH-2017-I/CQ-IE7', '', NULL),
(59, '16022442', '$2y$10$ggVjYXRKjE3aHzNsjXzGzeeilLFUZr8fAMseA0JlTg8.1YG7IaO.q', 'user', 'Hà Ngọc', 'Linh', '1998-04-21', 'QH-2016-I/CQ-N', '', NULL),
(60, '17020862', '$2y$10$WmP0xoIK2YhA/DqRDxMXPussq1HCH6PCjHXAsxdUIbeQzSjY8C7fi', 'user', 'Hà Vũ', 'Long', '1999-11-27', 'QH-2017-I/CQ-IE1', '', NULL),
(61, '17020864', '$2y$10$HNRpnbXnCYOToiBLnd2KqORi0h6qipmnSyBE6XRLuUtzqnX3YHqgq', 'user', 'Nguyễn Đắc', 'Long', '1999-09-13', 'QH-2017-I/CQ-IE6', '', NULL),
(62, '17020867', '$2y$10$aYxbJPQ0JLQOu3TcgH3p2uPEgRthoazgcW0zc7BuiG6c73SnxubU6', 'user', 'Trần Quang', 'Long', '1999-12-03', 'QH-2017-I/CQ-IE2', '', NULL),
(63, '17020879', '$2y$10$/UhtqO3cBZKGBh/ygRCeOu542.CPI9v7SK74.xsGi/l5nWTFsCZ0m', 'user', 'Nguyễn Đức', 'Mạnh', '1999-12-19', 'QH-2017-I/CQ-IE5', '', NULL),
(64, '15022162', '$2y$10$3xTlPdRMGFegijFSTobLKOHlTpSEM9YQ0ED9oZO4XNFx6HnTREAnG', 'user', 'Đỗ Đăng', 'Minh', '1997-10-07', 'QH-2015-I/CQ-V', '', NULL),
(65, '17020902', '$2y$10$DREcTIReUxIJmwFVVCCsAuOT6dszTtzSQCk8navjeUMaVNzbErEl.', 'user', 'Vũ Đức', 'Minh', '1999-09-06', 'QH-2017-I/CQ-IE5', '', NULL),
(66, '16022443', '$2y$10$0TJdZ9NnCLWfURycewpzAunEIEGw/uOt.6vC4sEIMIkOH652kgxX6', 'user', 'Kiều Thanh', 'Nam', '1998-11-03', 'QH-2016-I/CQ-N', '', NULL),
(67, '16021880', '$2y$10$W7BRGzOF701j.n4o6TfY7uf6fgswK.aTWPZRkdKxo6mlqJ151OSq6', 'user', 'Nguyễn Minh', 'Ngọc', '1998-06-22', 'QH-2016-I/CQ-T', '', NULL),
(68, '15023600', '$2y$10$7dEOwTUBjQAU17L03x7TVuURhI41mDUeBe2JuJ076upwShB/fZRoy', 'user', 'Nguyễn Vân', 'Ngọc', '1996-02-18', 'QH-2015-I/CQ-V', '', NULL),
(69, '17020942', '$2y$10$4o8ojy092.lZKTwaj6DpSeV8jlU.n82Ez7kZIryYs2o2lGuP8tw/u', 'user', 'Nguyễn Ngọc', 'Nhanh', '1999-03-02', 'QH-2017-I/CQ-IE5', '', NULL),
(70, '16021843', '$2y$10$2M2Uoyd8PJshZBgwGYDaYegebj/bDhLWlkZiccUSZaI2YNQr03GMO', 'user', 'Nguyễn Thị Hoàng', 'Oanh', '1998-11-10', 'QH-2016-I/CQ-N', '', NULL),
(71, '15022346', '$2y$10$Gg5isHxg/lFZLUTBWmiD.OEOPJz2z67pUVScGkVh1/4PdyQi/Tde6', 'user', 'Đặng Chí', 'Phong', '1997-10-21', 'QH-2015-I/CQ-V', '', NULL),
(72, '15022363', '$2y$10$qbWvGbl3WcbUIvAOEp07He82d2WnYrdPs4QFI8GABVnMdXBMX4GNa', 'user', 'Bùi Thị', 'Phương', '1996-02-21', 'QH-2015-I/CQ-V', '', NULL),
(73, '15022420', '$2y$10$m27H3EuGRC4yR.WE1IClM.rfcXPvpiPVgV2iFGrxlSXOVZmzMdujG', 'user', 'Nguyễn Văn', 'Quang', '1997-03-23', 'QH-2015-I/CQ-H', '', NULL),
(74, '16020693', '$2y$10$DT1h43brvIxwuo2YNqGa/OVurKaSQPs4K251SLjDBnRsZB0xGLUuK', 'user', 'Lê Quốc', 'Anh', '1998-08-11', 'QH-2016-I/CQ-ĐB', '', NULL),
(75, '17020593', '$2y$10$nl.UaxjVHy.3Ru1odb4gR..Xgp.ETmGil.bSrM/ue3HNWpB6oLQVm', 'user', 'Vi Thế', 'Anh', '1999-02-01', 'QH-2017-I/CQ-IE9', '', NULL),
(76, '16020908', '$2y$10$mCi4BuMnWN91gPSOn4136.dq2cbiY//ehvVndsL0bDbyY8aSnJ0J.', 'user', 'Nguyễn Tiến', 'Dũng', '1998-02-17', 'QH-2016-I/CQ-CB', '', NULL),
(77, '14020582', '$2y$10$A.2FxiJyAYmJsnhI9aBWLecq47zlrichPsH7G.FAkDTiEtSaACjKG', 'user', 'Châu Quốc', 'Đạt', '1996-08-12', 'QH-2014-I/CQ-CB', '', NULL),
(78, '17020707', '$2y$10$HtZGn7hH9ikc52J37Q3bVuln4f8CZDalAKHdsze0S21Oez3cz0zI2', 'user', 'Trần Mạnh', 'Giang', '1999-05-06', 'QH-2017-I/CQ-IE1', '', NULL),
(79, '17020720', '$2y$10$V0CohzaGZO4.yk6.yVwONOdya2riBDH7nWCd0B3rHkusRJCZu/NIK', 'user', 'Nguyễn Thị Hồng', 'Hạnh', '1999-02-01', 'QH-2017-I/CQ-IE6', '', NULL),
(80, '16020737', '$2y$10$FwbtZmXrf7.cQFiLK8nh1eWL6ccxDQy5xxrr1GkEgHAiG627nEKjm', 'user', 'Cù Đức', 'Hiệp', '1998-09-14', 'QH-2016-I/CQ-ĐB', '', NULL),
(81, '13020176', '$2y$10$X1QebAENPp3v1KSdHPUdfOYK67fdqk9A1yxhgKJoG2V/97HuSIb6u', 'user', 'Nguyễn Xuân', 'Hoàng', '1995-05-01', 'QH-2013-I/CQ-CC', '', NULL),
(82, '16021004', '$2y$10$w8TRjdSNAIYbjQY8xIkHyuZs8ntX/b4h5JZ2DECj813BICIaMtSaC', 'user', 'Phạm Minh', 'Huyền', '1998-08-10', 'QH-2016-I/CQ-CCLC', '', NULL),
(83, '16021589', '$2y$10$dLn6s4ikNUnOx7zKncwvgOQQBD8hIDMw/U5eG7T/gCNdjpcfNLPlu', 'user', 'Cao Hữu', 'Hưng', '1998-02-19', 'QH-2016-I/CQ-N', '', NULL),
(84, '17020028', '$2y$10$OY.JXA2bQFCZ.0Fv8d6aV.c8uLejD7EiHgE5aL8dX6Hktd43G1uy6', 'user', 'Đỗ Hoàng', 'Khánh', '1999-10-11', 'QH-2017-I/CQ-IE4', '', NULL),
(85, '15021041', '$2y$10$vp2wNIGegeqAFX3Vy4b0y.EDeuffdX7wtncmB42SCI7tweo/sw3H6', 'user', 'Nguyễn Ngọc', 'Khánh', '1997-10-30', 'QH-2015-I/CQ-CC', '', NULL),
(86, '17020057', '$2y$10$7sibXG7u9slGmSx8Nz02RuN/vG8vQ4pgyRSKv5JFAnFGLKqhYWK/u', 'user', 'Hoàng Bảo', 'Long', '1999-11-08', 'QH-2017-I/CQ-IE2', '', NULL),
(87, '16021043', '$2y$10$azPiXdhNvL9rYkBC9YpCa.WN2QBm0RNBnDLBHp6cQgiN55IOclK5i', 'user', 'Đào Tiến', 'Mạnh', '1998-08-09', 'QH-2016-I/CQ-CB', '', NULL),
(88, '17020893', '$2y$10$4RnpZW4TCXlUSHkm/G7CAeDtuVtQsYcKmcTkkfUSZarDYTfMNb8Py', 'user', 'Lê Đức', 'Minh', '1999-10-23', 'QH-2017-I/CQ-IE3', '', NULL),
(89, '16021616', '$2y$10$ltIxOSHAsQAe7pDCSpVslOSLWiBcagOsA21XWF1UDp/C4K2VfXXcC', 'user', 'Trương Văn', 'Nam', '1998-08-31', 'QH-2016-I/CQ-N', '', NULL),
(90, '16022292', '$2y$10$OERVt6nRZkWKDKQAXJ2dTuHdyyTeFB/O3JYejn.9ZXYqCbo0ER9nm', 'user', 'Hoàng Văn', 'Nhất', '1997-12-24', 'QH-2016-I/CQ-ĐB', '', NULL),
(91, '15022286', '$2y$10$3qdvmyzs0jU7ewapWDveQeGZs/xmE.S0y.IYl6HWTM3o3UCYTKpUW', 'user', 'Vũ Huy', 'Phát', '1997-01-13', 'QH-2015-I/CQ-ĐB', '', NULL),
(92, '14020346', '$2y$10$aqvIjk9qf1nHzOOQWqX5M.VdLo.Mi1VTOoRgMi9qAuvG21ais2nOO', 'user', 'Nguyễn Duy', 'Phú', '1996-05-30', 'QH-2014-I/CQ-CB', '', NULL),
(93, '17020981', '$2y$10$0bbzwwjis/q4cAWGB.5u8ufhWlh3YB6lBZw6GteLSnW3pGcVvNQky', 'user', 'Phạm Minh', 'Quang', '1999-09-17', 'QH-2017-I/CQ-IE8', '', NULL),
(94, '17020993', '$2y$10$.NPPf/UWizMEc5/zaSPM7OQdrDjq2.38OQCLhnRAqokZrPbc11D.a', 'user', 'Phạm Trọng', 'Quyết', '1999-02-11', 'QH-2017-I/CQ-IE6', '', NULL),
(95, '16020799', '$2y$10$zQOfeB7qQYaWwoMbo7XLrOtG/UkM4ulI8m3lwFOhL5VjKfunEFalK', 'user', 'Nguyễn Thế', 'Sơn', '1998-04-21', 'QH-2016-I/CQ-ĐB', '', NULL),
(96, '16022146', '$2y$10$8UpTDk8WycPsZQGZWwIBheKH3zx/fKI/xCunXPv.9vI3qMuYlun/O', 'user', 'Lê Công', 'Thái', '1998-07-30', 'QH-2016-I/CQ-CAC', '', NULL),
(97, '17021015', '$2y$10$oibbA206XNaVDx19OYCYx.ikO4M/eRf8YjITMX25PWI1iYPpPCRVO', 'user', 'Vũ Thị', 'Thanh', '1999-03-30', 'QH-2017-I/CQ-IE1', '', NULL),
(98, '14020485', '$2y$10$tf2p0p9v6ATV.BnmV5bOlexETUdgO6I/xw0Vt08UzFG2K3eZzHCHq', 'user', 'Nguyễn Văn', 'Tranh', '1996-09-09', 'QH-2014-I/CQ-CC', '', NULL),
(99, '16021229', '$2y$10$aJkZuGUaLrvcuafmWjsJNeRedT0pn8EIHbTiXFy0Lvyr5mSmvb0T2', 'user', 'Đặng Thị', 'Tuyết', '1998-11-27', 'QH-2016-I/CQ-CB', '', NULL),
(100, '17021141', '$2y$10$Is/Kwxx9nYfXtdX9xSztpebCko/0RkzDpBrNfizxgduO9pJy4pApq', 'user', 'Phùng Xuân', 'Vượng', '1997-05-06', 'QH-2017-I/CQ-IE8', '', NULL),
(101, '1234567', '$2y$10$uEeEHTrdVqkG9DOFaNRa9et.xUKBhpyXlACSG/ysWfzqBYj.0DYU2', 'user', 'Nguyễn', 'A', '2019-12-24', 'K62', '', NULL),
(102, '13020557', '$2y$10$nAi6UeluLxA1ogDEk5Az1.Y0/z9woPzqoSAb/PstwC1UYWnCciT3W', 'user', 'Nguyễn Đình', 'Quyết', '1994-11-15', 'QH-2013-I/CQ-Đ-B', '', NULL),
(103, '14020692', '$2y$10$iZpFZp.M5WTVqwdU1g3aauI2vhyid0lnltocxTEdasZsj/khN6Kdy', 'user', 'Đinh Văn', 'Sao', '1996-12-06', 'QH-2014-I/CQ-Đ-B', '', NULL),
(104, '17020186', '$2y$10$GGLKhWHob8W0VKy02bg4iO/UNOTwt7kYz8uTOOtwgfc7aDkzAV5bm', 'user', 'Hà Trường', 'Sơn', '1998-11-29', 'QH-2017-I/CQ-IE5', '', NULL),
(105, '17021027', '$2y$10$CElkvXAVJjeYB4jbWvPjBO8q42VWBT11CKtYaDL.0g0/De0n0nhQy', 'user', 'Ngô Xuân', 'Thắng', '1999-06-28', 'QH-2017-I/CQ-IE5', '', NULL),
(106, '17021028', '$2y$10$usbAT55RqqnfoztjcAbiTuNZjSY3hJcAmAwsgEsvPxtc85dnoMOEO', 'user', 'Nguyễn Chiến', 'Thắng', '1999-07-06', 'QH-2017-I/CQ-IE7', '', NULL),
(107, '15021685', '$2y$10$E0QAxwu5jymqO/7QY9Y6k.cH3mh9APqE88SDe0VFm6sNqfxG5OM6u', 'user', 'Nguyễn Đức', 'Thắng', '1997-06-28', 'QH-2015-I/CQ-M', '', NULL),
(108, '15022661', '$2y$10$ka.LimzzmpIrmH41kWwvQeXWR3cw5waAh0HgxyXQw2P8wkbeDbUmq', 'user', 'Nguyễn Võ', 'Thắng', '1997-04-18', 'QH-2015-I/CQ-V', '', NULL),
(109, '16020658', '$2y$10$d.ergHnc1L8HL.jfa0Uao.TulHjkEQ2s2Tifb4zlXaemcTgO9jzr2', 'user', 'Phùng Quang', 'Thắng', '1998-02-11', 'QH-2016-I/CQ-M', '', NULL),
(110, '17021042', '$2y$10$YI/4rSeBql5v05nMgnGbnO0nQbi52WUv9D6A5f9xhWNezzvNPI9tm', 'user', 'Nguyễn Đức', 'Thiện', '1999-04-09', 'QH-2017-I/CQ-IE1', '', NULL),
(111, '15020897', '$2y$10$KHqlPh6NDTSYE7tiNXlHAOhNlclPEB0WPdTuzGSW4Zp7MwJBLVNve', 'user', 'Trần Đức', 'Thọ', '1997-07-27', 'QH-2015-I/CQ-C-C', '', NULL),
(112, '15022338', '$2y$10$jkJjTBeWR9jUByZu4NHiO.htEXmfIMW3bDL/YvIbL/vHEXXvCyGie', 'user', 'Chu Quốc', 'Tiệm', '1997-09-09', 'QH-2015-I/CQ-V', '', NULL),
(113, '17021060', '$2y$10$DoaOHJYvI.Iw.jNppgLhhOobyvXVsyXKIxOjYxfhv7oTw.X96zeyi', 'user', 'Đặng Ngọc', 'Tiến', '1999-03-24', 'QH-2017-I/CQ-IE5', '', NULL),
(114, '16022274', '$2y$10$XWIcvht01EOeFLdh.eOUCuVovpR5CdS5GbPItIBL7kW7tfC22V64i', 'user', 'Phạm Trọng', 'Tiến', '1998-09-24', 'QH-2016-I/CQ-M', '', NULL),
(115, '17021077', '$2y$10$Ke7dllaBQso2szHf9v8wS.wM.Iz7HJYWQ0YyR6ZCjvOf2CTk6hWsS', 'user', 'Nguyễn Thị Minh', 'Trang', '1999-06-05', 'QH-2017-I/CQ-IE5', '', NULL),
(116, '17020442', '$2y$10$iAbNfKi3pWoBgj8lN0Ha1uMLuhzTmSHBuoU2tIBpu.hSoIK1QX8s6', 'user', 'Đặng Ngọc', 'Trung', '1999-09-02', 'QH-2017-I/CQ-ME4', '', NULL),
(117, '15021739', '$2y$10$XxZyFVwu..5ii857xapu4O5jeMCwzaYpji47XtAu2IoFuEr27iNjG', 'user', 'Lê Nam', 'Trung', '1997-06-02', 'QH-2015-I/CQ-M', '', NULL),
(118, '15022264', '$2y$10$824klp0ne6EbF7LroVtp5eGozhrGmoaiDkWAKp9APpSrq4qCWMYye', 'user', 'Nguyễn Tiến', 'Trung', '1997-09-02', 'QH-2015-I/CQ-Đ-B', '', NULL),
(119, '17021107', '$2y$10$tW8aiiMYqFRtMObqb3EWpeVvqPIOJovnmCUBx7pN8mTKCsnnZqA.e', 'user', 'Nguyễn Ngọc', 'Tuấn', '1999-01-10', 'QH-2017-I/CQ-IE7', '', NULL),
(120, '16021217', '$2y$10$ENqQ2Kfh7iNBi4X9aiOTLed9qfBwpwwrOqHucSVSLa/joUPrC4Ne2', 'user', 'Trần Mạnh', 'Tuấn', '1998-10-27', 'QH-2016-I/CQ-C-D', '', NULL),
(121, '16022297', '$2y$10$eS/eCYrjAu9pxd4ZxHp/0ejSoqkOxuFbRhvsPDSALj4W0KM9cTGHm', 'user', 'Đỗ Duy', 'Tùng', '1998-02-23', 'QH-2016-I/CQ-Đ-B', '', NULL),
(122, '17021112', '$2y$10$Tnk2GfO72UUrYtrvVi1uM.rUe7SEVScRo8AM84j/QU0l3sokACBJy', 'user', 'Hoàng Duy', 'Tùng', '1999-09-27', 'QH-2017-I/CQ-IE5', '', NULL),
(123, '16022344', '$2y$10$iGNmGccTAcG/pKpj2YMfiOPZxaS0TqSqGkP4WnMSq0nkQSe.u5iK6', 'user', 'Nguyễn Văn', 'Tùng', '1997-02-03', 'QH-2016-I/CQ-H', '', NULL),
(124, '17021121', '$2y$10$pLszy4VyF3zIziE00dExtOWV5CWn2RO8HzFwk4iY61aByPl84TzQa', 'user', 'Trần Văn', 'Tưởng', '1999-05-08', 'QH-2017-I/CQ-IE1', '', NULL),
(125, '14020723', '$2y$10$c3Jvwcak68c6ovQLtjDOB.96ZyRfGvPxzJ4lrYCN1pN51GqYSow3y', 'user', 'Phan Văn', 'Ước', '1996-02-23', 'QH-2014-I/CQ-H', '', NULL),
(126, '15022797', '$2y$10$R/zwqrezh.hj.MijnhtALOj69x5pADSMhypX/2KQqAOwEXR55TTzu', 'user', 'Trần Quốc', 'Việt', '1997-10-28', 'QH-2015-I/CQ-M', '', NULL),
(127, '16020821', '$2y$10$nVJnKKes/jWckNVZTv2Oi.Pt3y.nu.AzCEmk7qaNtG6z96nG8MXrm', 'user', 'Mai Thế', 'Vinh', '1998-08-27', 'QH-2016-I/CQ-Đ-B', '', NULL),
(128, '16020822', '$2y$10$jX1y6Es6C2ySLjXqwoCxBe0iAVW47Cyuky5kkScoYroOf.czSqoe2', 'user', 'Nguyễn Thế', 'Vinh', '1998-04-19', 'QH-2016-I/CQ-Đ-B', '', NULL),
(129, 'admin1', '$2y$10$aCjinHHkjBA2KXRi.YL9nOel5ny4woEr/l8BWbnM0S9MDiIsqgF0W', 'user', 'Nguywwnx', 'admin', '2019-12-27', 'sadsdadsa', '', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users_subjects`
--

CREATE TABLE `users_subjects` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `users_subjects`
--

INSERT INTO `users_subjects` (`id`, `user_id`, `subject_id`) VALUES
(193, 2, 14),
(194, 3, 14),
(195, 4, 14),
(196, 5, 14),
(197, 6, 14),
(198, 7, 14),
(199, 8, 14),
(200, 9, 14),
(201, 10, 14),
(202, 11, 14),
(203, 12, 14),
(204, 13, 14),
(205, 14, 14),
(206, 15, 14),
(207, 16, 14),
(208, 17, 14),
(209, 18, 14),
(210, 19, 14),
(211, 20, 14),
(212, 21, 14),
(213, 22, 14),
(214, 23, 14),
(215, 24, 14),
(216, 25, 14),
(217, 26, 14),
(218, 27, 14),
(219, 28, 14),
(220, 29, 14),
(221, 30, 14),
(222, 31, 14),
(223, 32, 14),
(224, 33, 14),
(231, 2, 2),
(233, 2, 5),
(236, 42, 3),
(238, 42, 2),
(434, 2, 22),
(435, 102, 22),
(436, 94, 22),
(437, 103, 22),
(438, 104, 22),
(439, 97, 22),
(440, 105, 22),
(441, 106, 22),
(442, 107, 22),
(443, 108, 22),
(444, 109, 22),
(445, 110, 22),
(446, 111, 22),
(447, 112, 22),
(448, 113, 22),
(449, 114, 22),
(450, 115, 22),
(451, 116, 22),
(452, 117, 22),
(453, 118, 22),
(454, 119, 22),
(455, 120, 22),
(456, 121, 22),
(457, 122, 22),
(458, 123, 22),
(459, 124, 22),
(460, 125, 22),
(461, 126, 22),
(462, 127, 22),
(463, 128, 22),
(464, 72, 22),
(465, 73, 22),
(466, 129, 2),
(468, 2, 23),
(469, 102, 23),
(470, 94, 23),
(471, 103, 23),
(472, 104, 23),
(473, 97, 23),
(474, 105, 23),
(475, 106, 23),
(476, 107, 23),
(477, 108, 23),
(478, 109, 23),
(479, 110, 23),
(480, 111, 23),
(481, 112, 23),
(482, 113, 23),
(483, 114, 23),
(484, 115, 23),
(485, 116, 23),
(486, 117, 23),
(487, 118, 23),
(488, 119, 23),
(489, 120, 23),
(490, 121, 23),
(491, 122, 23),
(492, 123, 23),
(493, 124, 23),
(494, 125, 23),
(495, 126, 23),
(496, 127, 23),
(497, 128, 23),
(498, 72, 23),
(499, 73, 23);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users_tests`
--

CREATE TABLE `users_tests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `users_tests`
--

INSERT INTO `users_tests` (`id`, `user_id`, `test_id`) VALUES
(61, 2, 84),
(62, 2, 78),
(63, 2, 69),
(64, 2, 76),
(65, 102, 78),
(67, 12, 78),
(68, 13, 69),
(69, 4, 69),
(70, 5, 69),
(71, 7, 69),
(72, 6, 69);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_session_id` (`session_id`);

--
-- Chỉ mục cho bảng `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `test_room_id` (`test_room_id`),
  ADD KEY `fk_test_time_` (`time_id`);

--
-- Chỉ mục cho bảng `test_rooms`
--
ALTER TABLE `test_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `times`
--
ALTER TABLE `times`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_session_time` (`session_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users_subjects`
--
ALTER TABLE `users_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Chỉ mục cho bảng `users_tests`
--
ALTER TABLE `users_tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `test_id` (`test_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `tests`
--
ALTER TABLE `tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT cho bảng `test_rooms`
--
ALTER TABLE `test_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `times`
--
ALTER TABLE `times`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT cho bảng `users_subjects`
--
ALTER TABLE `users_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=500;

--
-- AUTO_INCREMENT cho bảng `users_tests`
--
ALTER TABLE `users_tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `fk_session_id` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tests`
--
ALTER TABLE `tests`
  ADD CONSTRAINT `fk_subject_` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_test_room_` FOREIGN KEY (`test_room_id`) REFERENCES `test_rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_test_time_` FOREIGN KEY (`time_id`) REFERENCES `times` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `times`
--
ALTER TABLE `times`
  ADD CONSTRAINT `fk_session_time` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `users_subjects`
--
ALTER TABLE `users_subjects`
  ADD CONSTRAINT `fk_subject_user` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_subject` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `users_tests`
--
ALTER TABLE `users_tests`
  ADD CONSTRAINT `fk_subject_test` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_test` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
