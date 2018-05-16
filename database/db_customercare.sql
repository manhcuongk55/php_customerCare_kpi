-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 16, 2018 lúc 07:19 PM
-- Phiên bản máy phục vụ: 10.1.32-MariaDB
-- Phiên bản PHP: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `db_customercare`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_category`
--

CREATE TABLE `tbl_category` (
  `id` int(10) NOT NULL,
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `group` tinyint(4) NOT NULL,
  `cdate` date NOT NULL,
  `isactive` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `tbl_category`
--

INSERT INTO `tbl_category` (`id`, `name`, `alias`, `group`, `cdate`, `isactive`) VALUES
(1, 'Thông tin chung cá nhân', 'thong_tin_chung_ca_nhan', 0, '2018-04-01', 1),
(2, 'Sở thích', 'so_thich', 0, '2018-04-01', 1),
(3, 'Quan hệ gia đình', 'quan_he_gia_dinh', 0, '2018-04-01', 1),
(4, 'Quá trình học tập', 'qua_trinh_hoc_tap', 0, '2018-04-01', 1),
(5, 'Lý lịch công tác', 'ly_lich_cong_tac', 0, '2018-04-01', 1),
(6, 'Quan hệ xã hội', 'quan_he_xa_hoi', 0, '2018-04-01', 1),
(7, 'Thông tin chung doanh nghiệp', 'thong_tin_chung_doanh_nghiep', 1, '2018-04-01', 1),
(8, 'Thông tin người đại diện doanh nghiệp', 'thong_tin_nguoi_dai_dien_doanh_nghiep', 1, '2018-04-01', 1),
(9, 'Tổ chức đối tác của doanh nghiệp', 'to_chuc_doi_tac_cua_doanh_nghiep', 1, '2018-04-01', 1),
(10, 'Thông tin chung tổ chức', 'thong_tin_chung_to_chuc', 2, '2018-04-09', 1),
(11, 'Thông tin người đại diện tổ chức', 'thong_tin_nguoi_dai_dien_to_chuc', 2, '2018-04-09', 1),
(12, 'Tổ chức đối tác của tổ chức', 'to_chuc_doi_tac_cua_to_chuc', 2, '2018-04-09', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_common`
--

CREATE TABLE `tbl_common` (
  `id` int(10) NOT NULL,
  `sub_cat_id` int(10) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `tbl_common`
--

INSERT INTO `tbl_common` (`id`, `sub_cat_id`, `name`) VALUES
(1, 4, 'Môn 1'),
(2, 4, 'Môn 2'),
(3, 5, 'Món 1'),
(4, 5, 'Món 2'),
(5, 8, 'Xe 1'),
(6, 8, 'Xe 2'),
(7, 7, 'Quyển 1'),
(8, 9, 'Điện thoại 1'),
(9, 11, 'Giày 1'),
(10, 7, 'Quyển 2'),
(11, 8, 'Xe 3');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `id` int(10) NOT NULL,
  `mem_id` int(10) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `fullname` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `phone` varchar(11) NOT NULL,
  `gender` tinyint(4) NOT NULL DEFAULT '0',
  `avatar` text NOT NULL,
  `diedate` date NOT NULL,
  `birthday_family` text NOT NULL,
  `diedate_family` text NOT NULL,
  `cdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `tbl_customer`
--

INSERT INTO `tbl_customer` (`id`, `mem_id`, `type`, `fullname`, `birthday`, `phone`, `gender`, `avatar`, `diedate`, `birthday_family`, `diedate_family`, `cdate`) VALUES
(32, 2, 0, 'Trần Xuân Bách', '2018-05-17', '09887765556', 0, '', '1970-01-01', '', '', '2018-05-16');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_customer_detail`
--

CREATE TABLE `tbl_customer_detail` (
  `id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `sub_cat_id` int(10) NOT NULL,
  `json` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `tbl_customer_detail`
--

INSERT INTO `tbl_customer_detail` (`id`, `customer_id`, `sub_cat_id`, `json`, `cdate`) VALUES
(2508, 32, 1, '{\"sub_cat_id\":\"1\",\"thong_tin_gan_dinh_danh_co_the\":{\"ho_ten\":\"Trần Xuân Bách\",\"bi_danh\":\"Bách còi\",\"hinh_anh\":\"uploads/avatar/avater.jpg\",\"ngay_sinh\":\"17-05-2018\",\"menh\":\"Thiên thượng hỏa\",\"noi_sinh\":\"Hà Nam\",\"ngay_mat\":\"\",\"gioi_tinh\":\"0\",\"chieu_cao\":\"176\",\"can_nang\":\"80\",\"mau_toc\":\"Đen\",\"kieu_toc\":\"Vuốt\",\"tien_su_benh\":\"Không có\"}}', '2018-05-16'),
(2509, 32, 2, '{\"sub_cat_id\":\"2\",\"thong_tin_quan_ly_ca_nhan_trong_xa_hoi\":{\"so_cmnd\":\"2345678\",\"so_ho_chieu\":\"23546567\",\"dan_toc\":\"Kinh\",\"ton_giao\":\"Không\",\"quoc_tich\":\"Việt Nam\",\"dk_ho_khau_thuong_chu\":\"La Sơn - Bình Lục Hà Nam\",\"noi_o_hien_tai\":\"Nhà số 3 ngách 28/30 Cổ Nhuế 2\"}}', '2018-05-16'),
(2510, 32, 3, '{\"sub_cat_id\":\"3\",\"thong_tin_xa_hoi_hien_tai\":{\"dien_thoai\":\"0988776555687\",\"email\":\"txbachit@gmail.com\",\"so_tai_khoan\":\"4567890\",\"ngan_hang\":\"Vietcombank\",\"ma_so_thue\":\"456789\",\"tinh_trang_ket_hon\":\"da_ket_hon\",\"ngay_ket_hon\":\"14-05-2018\",\"lan_ket_hon\":\"1\",\"noi_ket_hon\":\"nha_hang\",\"trinh_do_hoc_van\":\"dai_hoc\",\"don_vi_cong_tac\":\"FPT\",\"chuc_danh\":\"Dev\"}}', '2018-05-16'),
(2511, 32, 4, '{\"sub_cat_id\":\"4\",\"the_thao\":[{\"mon_yeu_thich\":\"Tennnis\",\"dac_diem_luu_y\":\"Không có\"},{\"mon_yeu_thich\":\"Bóng bàn\",\"dac_diem_luu_y\":\"Thuận tay trái\"}]}', '2018-05-16'),
(2512, 32, 5, '{\"sub_cat_id\":\"5\",\"am_thuc\":[{\"mon_yeu_thich\":\"Vịt quay\",\"ten_quoc_gia\":\"Việt nam\",\"dac_diem_luu_y\":\"Không có\"}]}', '2018-05-16'),
(2513, 32, 6, '{\"sub_cat_id\":\"6\",\"nghe_thuat\":[{\"bo_mon_yeu_thich\":\"Vẽ\",\"tac_pham_yeu_thich\":\"Hai chị em\",\"ten_tac_gia\":\"Nguyễn Văn Cẩn\",\"dac_diem_luu_y\":\"Thích tranh sơn dầu\"}]}', '2018-05-16'),
(2514, 32, 7, '{\"sub_cat_id\":\"7\",\"sach\":[{\"the_loai_yeu_thich\":\"Lập trình\",\"tac_gia\":\"Nguyễn Ngọc Tuấn\",\"tac_pham\":\"Lập trình 24h\",\"dac_diem_luu_y\":\"Rất thích cuốn sách này\"}]}', '2018-05-16'),
(2515, 32, 8, '{\"sub_cat_id\":\"8\",\"xe\":[{\"hang_xe_yeu_thich\":\"Mecerdes\",\"dong_xe\":\"E\",\"mau_sac\":\"Đen\"}]}', '2018-05-16'),
(2516, 32, 9, '{\"sub_cat_id\":\"9\",\"dien_thoai\":[{\"hang_yeu_thich\":\"Iphone\",\"model\":\"2018\",\"mau_sac\":\"Gold\"}]}', '2018-05-16'),
(2517, 32, 10, '{\"sub_cat_id\":\"10\",\"thoi_trang\":[{\"thuong_hieu_thoi_trang_yeu_thich\":\"D&G\",\"mau_chu_dao\":\"Cổ điển\",\"loai_trang_phuc_yeu_thich\":\"Váy\"}]}', '2018-05-16'),
(2518, 32, 11, '{\"sub_cat_id\":\"11\",\"giay\":[{\"thuong_hieu_yeu_thich\":\"Adidas\",\"size\":\"40\",\"mau_sac\":\"Đen\",\"loai_giay\":\"Lười\"}]}', '2018-05-16'),
(2519, 32, 12, '{\"sub_cat_id\":\"12\",\"nuoc_hoa\":[{\"thuong_hieu_yeu_thich\":\"Woman\",\"mui_vi\":\"Hoa hồng\"}]}', '2018-05-16'),
(2520, 32, 13, '{\"sub_cat_id\":\"13\",\"do_uong\":[{\"do_uong_yeu_thich\":\"Beer\",\"hang_nao\":\"Tiger\",\"dac_diem_luu_y\":\"Uống với muối\"}]}', '2018-05-16'),
(2521, 32, 14, '{\"sub_cat_id\":\"14\",\"ca_hat\":[{\"dong_nhac_yeu_thich\":\"Nhạc vàng\",\"bai_hat_yeu_thich\":\"Dĩ vãng một cuộc tình\"}]}', '2018-05-16'),
(2522, 32, 15, '{\"sub_cat_id\":\"15\",\"kinh_deo\":[{\"hang_yeu_thich\":\"D&G\",\"model\":\"2018\",\"mau_sac\":\"Đen\"}]}', '2018-05-16'),
(2523, 32, 16, '{\"sub_cat_id\":\"16\",\"dong_ho\":[{\"hang_yeu_thich\":\"Senko\",\"model\":\"2018\",\"mau_sac\":\"Đen\"}]}', '2018-05-16'),
(2524, 32, 17, '{\"sub_cat_id\":\"17\",\"am_nhac\":[{\"ca_sy_yeu_thich\":\"Trường Vũ\",\"the_loai_yeu_thich\":\"Nhạc vàng\",\"dac_diem_luu_y\":\"\"}]}', '2018-05-16'),
(2525, 32, 18, '{\"sub_cat_id\":\"18\",\"du_lich\":[{\"loai_hinh_du_lich_yeu_thich\":\"Phượt\",\"dia_diem_yeu_thich\":\"Đà nẵng\",\"dac_diem_luu_y\":\"Chơi bà nà\"}]}', '2018-05-16'),
(2526, 32, 19, '{\"sub_cat_id\":\"19\",\"thong_tin_gan_dinh_danh_co_the\":[{\"ho_ten\":\"Trần Văn Minh\",\"bi_danh\":\"Minh còi\",\"ngay_sinh\":\"17-05-2018\",\"menh\":\"\",\"noi_sinh\":\"Hà Nam\",\"ngay_mat\":\"\",\"gioi_tinh\":\"0\",\"tien_su_benh\":\"Chưa có thông tin\",\"hinh_anh\":\"\"},{\"ho_ten\":\"Dương Thị chỉ\",\"bi_danh\":\"Không có\",\"ngay_sinh\":\"18-05-2018\",\"menh\":\"\",\"noi_sinh\":\"Hà Nam\",\"ngay_mat\":\"\",\"gioi_tinh\":\"1\",\"tien_su_benh\":\"Không có\",\"hinh_anh\":\"\"}]}', '2018-05-16'),
(2527, 32, 20, '{\"sub_cat_id\":\"20\",\"thong_tin_khac\":[]}', '2018-05-16'),
(2528, 32, 21, '{\"sub_cat_id\":\"21\",\"qua_trinh_hoc_tap\":[]}', '2018-05-16'),
(2529, 32, 22, '{\"sub_cat_id\":\"22\",\"ly_lich_cong_tac\":[]}', '2018-05-16'),
(2530, 32, 23, '{\"sub_cat_id\":\"23\",\"quan_he_xa_hoi\":[{\"cap_do_quan_he\":\"nha_nuoc\",\"hinh_thuc_quan_he\":\"truc_tiep\",\"dau_moi\":\"Trần Hồng Hà\",\"loai_quan_he\":\"dong_nghiep\",\"so_dien_thoai\":\"09888777888\",\"co_quan\":\"UBND Huyện \",\"dia_chi\":\"Bình Lục\"}]}', '2018-05-16'),
(2531, 32, 39, '{\"sub_cat_id\":\"39\",\"phim_anh\":[{\"the_loai_yeu_thich\":\"Kinh dị\",\"dien_vien_yeu_thich\":\"John\",\"dac_diem_luu_y\":\"Càng kinh dị càng thích\"}]}', '2018-05-16'),
(2532, 32, 41, '{\"sub_cat_id\":\"41\",\"hong_chuyen\":[{\"thich_hong_chuyen_gi\":\"Blala\"}]}', '2018-05-16');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_display`
--

CREATE TABLE `tbl_display` (
  `id` int(11) NOT NULL,
  `sub_cat_id` int(11) NOT NULL,
  `display_item` int(11) NOT NULL,
  `isactive` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `tbl_display`
--

INSERT INTO `tbl_display` (`id`, `sub_cat_id`, `display_item`, `isactive`) VALUES
(1, 4, 2, 1),
(2, 5, 1, 1),
(3, 6, 1, 1),
(4, 7, 1, 1),
(5, 8, 1, 1),
(6, 9, 1, 1),
(7, 10, 1, 1),
(8, 11, 1, 1),
(9, 12, 1, 1),
(10, 13, 1, 1),
(11, 14, 1, 1),
(12, 15, 1, 1),
(13, 16, 1, 1),
(14, 17, 1, 1),
(15, 18, 1, 1),
(16, 21, 5, 1),
(17, 22, 5, 1),
(19, 23, 1, 1),
(25, 26, 2, 1),
(26, 39, 1, 1),
(28, 41, 1, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_export_pdf`
--

CREATE TABLE `tbl_export_pdf` (
  `id` int(11) NOT NULL,
  `mem_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `cat_list` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `note` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `tbl_export_pdf`
--

INSERT INTO `tbl_export_pdf` (`id`, `mem_id`, `customer_id`, `cat_list`, `status`, `note`, `cdate`) VALUES
(1, 2, 32, '1,2,3,4,5,6', 0, '', '2018-05-16 21:46:34');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_field_infomation`
--

CREATE TABLE `tbl_field_infomation` (
  `id` int(10) NOT NULL,
  `sub_cat_id` int(10) NOT NULL,
  `alias` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `data_type` varchar(20) NOT NULL,
  `sort` int(11) NOT NULL,
  `isactive` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `tbl_field_infomation`
--

INSERT INTO `tbl_field_infomation` (`id`, `sub_cat_id`, `alias`, `name`, `data_type`, `sort`, `isactive`) VALUES
(1, 1, 'ho_ten', 'Họ tên', 'text', 1, 1),
(2, 1, 'bi_danh', 'Bí danh', 'text', 2, 1),
(3, 1, 'hinh_anh', 'Hình ảnh đại diện', 'file', 3, 1),
(4, 1, 'ngay_sinh', 'Ngày sinh', 'text', 4, 1),
(5, 1, 'ngay_mat', 'Ngày mất', 'text', 7, 1),
(6, 1, 'menh', 'Mệnh', 'text', 5, 1),
(7, 1, 'noi_sinh', 'Nơi sinh', 'textarea', 6, 1),
(8, 1, 'gioi_tinh', 'Giới tính', 'radio', 8, 1),
(9, 1, 'chieu_cao', 'Chiều cao (cm)', 'text', 9, 1),
(10, 1, 'can_nang', 'Cân nặng (kg)', 'text', 10, 1),
(11, 1, 'mau_toc', 'Màu tóc', 'text', 11, 1),
(12, 1, 'kieu_toc', 'Kiểu tóc', 'text', 12, 1),
(13, 1, 'tien_su_benh', 'Tiền sử bệnh', 'textarea', 13, 1),
(14, 2, 'so_cmnd', 'Số CMND/CCCD', 'text', 0, 1),
(15, 2, 'so_ho_chieu', 'Số hộ chiếu', 'text', 1, 1),
(16, 2, 'dan_toc', 'Dân tộc', 'text', 2, 1),
(17, 2, 'ton_giao', 'Tôn giáo', 'text', 3, 1),
(18, 2, 'quoc_tich', 'Quốc tịch', 'text', 4, 1),
(19, 2, 'dk_ho_khau_thuong_chu', 'Đăng kí hộ khẩu thường trú', 'textarea', 5, 1),
(20, 2, 'noi_o_hien_tai', 'Nơi ở hiện tại', 'textarea', 6, 1),
(22, 3, 'dien_thoai', 'Điện thoại', 'text', 1, 1),
(23, 3, 'email', 'Email', 'text', 2, 1),
(24, 3, 'so_tai_khoan', 'Số tài khoản', 'text', 3, 1),
(25, 3, 'ma_so_thue', 'Mã số thuế', 'text', 5, 1),
(26, 3, 'tinh_trang_ket_hon', 'Tình trạng kết hôn', 'radio', 6, 1),
(27, 3, 'lan_ket_hon', 'Kết hôn lần thứ mấy', 'text', 7, 1),
(28, 3, 'noi_ket_hon', 'Nơi tổ chức kết hôn', 'select', 8, 1),
(29, 3, 'trinh_do_hoc_van', 'Trình độ học vấn', 'select', 9, 1),
(30, 3, 'don_vi_cong_tac', 'Đơn vị công tác', 'textarea', 10, 1),
(31, 3, 'chuc_danh', 'Chức danh', 'text', 11, 1),
(32, 4, 'mon_yeu_thich', 'Môn yêu thích', 'text', 0, 1),
(33, 4, 'dac_diem_luu_y', 'Đặc điểm lưu ý', 'text', 1, 1),
(34, 5, 'mon_yeu_thich', 'Món yêu thích', 'text', 0, 1),
(35, 5, 'ten_quoc_gia', 'Tên quốc gia', 'text', 1, 1),
(36, 5, 'dac_diem_luu_y', 'Đặc điểm lưu ý', 'text', 2, 1),
(37, 6, 'bo_mon_yeu_thich', 'Bộ môn yêu thích', 'text', 0, 1),
(38, 6, 'tac_pham_yeu_thich', 'Tác phẩm yêu thích', 'text', 0, 1),
(39, 6, 'ten_tac_gia', 'Tên tác giả', 'text', 0, 1),
(40, 6, 'dac_diem_luu_y', 'Đặc điểm lưu ý', 'text', 0, 1),
(41, 7, 'the_loai_yeu_thich', 'Thể loại yêu thích', 'text', 0, 1),
(42, 7, 'tac_gia', 'Tác giả', 'text', 0, 1),
(43, 7, 'tac_pham', 'Tác phẩm', 'text', 0, 1),
(44, 7, 'dac_diem_luu_y', 'Đặc điểm lưu ý', 'text', 0, 1),
(45, 8, 'hang_xe_yeu_thich', 'Hãng xe yêu thích', 'text', 0, 1),
(46, 8, 'dong_xe', 'Dòng xe', 'text', 0, 1),
(47, 8, 'mau_sac', 'Màu sắc', 'text', 0, 1),
(48, 9, 'hang_yeu_thich', 'Hãng yêu thích', 'text', 0, 1),
(49, 9, 'model', 'Model', 'text', 0, 1),
(50, 9, 'mau_sac', 'Màu sắc', 'text', 0, 1),
(51, 10, 'thuong_hieu_thoi_trang_yeu_thich', 'Thương hiệu thời trang yêu thích', 'text', 0, 1),
(52, 10, 'mau_chu_dao', 'Màu chủ đạo', 'text', 0, 1),
(53, 10, 'loai_trang_phuc_yeu_thich', 'Loại trang phục yêu thích', 'text', 0, 1),
(54, 11, 'thuong_hieu_yeu_thich', 'Thương hiệu yêu thích', 'text', 0, 1),
(55, 11, 'size', 'Size', 'text', 0, 1),
(56, 11, 'mau_sac', 'Màu sắc', 'text', 0, 1),
(57, 11, 'loai_giay', 'Loại giày', 'text', 0, 1),
(58, 12, 'thuong_hieu_yeu_thich', 'Thương hiệu yêu thích', 'text', 0, 1),
(59, 12, 'mui_vi', 'Mùi vị', 'text', 0, 1),
(60, 13, 'do_uong_yeu_thich', 'Đồ uống yêu thích', 'text', 0, 1),
(61, 13, 'hang_nao', 'Hãng', 'text', 0, 1),
(62, 13, 'dac_diem_luu_y', 'Đặc điểm lưu ý', 'text', 0, 1),
(63, 14, 'thich_hat_hay_khong', 'Thích hát hay không', 'radio', 0, 1),
(64, 14, 'dong_nhac_yeu_thich', 'Dòng nhạc yêu thích', 'text', 0, 1),
(65, 14, 'bai_hat_yeu_thich', 'Bài hát yêu thích', 'text', 0, 1),
(66, 15, 'hang_yeu_thich', 'Hãng yêu thích', 'text', 0, 1),
(67, 15, 'model', 'Model', 'text', 0, 1),
(68, 15, 'mau_sac', 'Màu sắc', 'text', 0, 1),
(69, 16, 'hang_yeu_thich', 'Hãng yêu thích', 'text', 0, 1),
(70, 16, 'model', 'Model', 'text', 0, 1),
(71, 16, 'mau_sac', 'Màu sắc', 'text', 0, 1),
(72, 17, 'ca_sy_yeu_thich', 'Ca sĩ yêu thích', 'text', 0, 1),
(73, 17, 'the_loai_yeu_thich', 'Thể loại yêu thích', 'text', 0, 1),
(74, 17, 'dac_diem_luu_y', 'Đặc điểm lưu ý', 'text', 0, 1),
(75, 18, 'loai_hinh_du_lich_yeu_thich', 'Loại hình du lich yêu thích', 'text', 0, 1),
(76, 18, 'dia_diem_yeu_thich', 'Địa điểm yêu thích', 'text', 0, 1),
(77, 18, 'dac_diem_luu_y', 'Đặc điểm lưu ý', 'text', 0, 1),
(78, 19, 'ho_ten', 'Họ tên', 'text', 1, 1),
(79, 19, 'bi_danh', 'Bí danh', 'text', 2, 1),
(80, 19, 'hinh_anh', 'Hình ảnh đại diện', 'file', 3, 1),
(81, 19, 'ngay_sinh', 'Ngày sinh', 'text', 4, 1),
(82, 19, 'ngay_mat', 'Ngày mất', 'text', 7, 1),
(83, 19, 'menh', 'Mệnh', 'text', 5, 1),
(84, 19, 'gioi_tinh', 'Giới tính', 'radio', 8, 1),
(85, 19, 'noi_sinh', 'Nơi sinh', 'textarea', 6, 1),
(86, 19, 'tien_su_benh', 'Tiền sử bệnh', 'textarea', 9, 1),
(87, 20, 'dien_thoai', 'Điện thoại', 'text', 1, 1),
(88, 20, 'noi_o_hien_tai', 'Nơi ở hiện tại', 'textarea', 2, 1),
(89, 20, 'tinh_trang_ket_hon', 'Tình trạng hôn nhân', 'radio', 3, 1),
(90, 20, 'don_vi_cong_tac', 'Đơn vị công tác', 'textarea', 4, 1),
(91, 20, 'chuc_danh', 'Chức danh', 'textarea', 5, 1),
(92, 20, 'so_thich_dac_biet', 'Sở thích đặc biệt', 'textarea', 6, 1),
(93, 20, 'quan_he', 'Quan hệ với khách hàng', 'hidden', 0, 1),
(94, 21, 'from_year', 'Từ năm', 'select', 0, 1),
(95, 21, 'to_year', 'Đến năm', 'select', 0, 1),
(96, 21, 'cap_hoc', 'Cấp học', 'select', 0, 1),
(97, 21, 'truong_hoc', 'Trường học', 'text', 0, 1),
(98, 21, 'quoc_gia', 'Quốc gia', 'text', 0, 1),
(99, 21, 'chuyen_nganh', 'Chuyên ngành', 'text', 0, 1),
(100, 22, 'from_year', 'Từ năm', 'select', 0, 1),
(101, 22, 'to_year', 'Đến năm', 'select', 0, 1),
(102, 22, 'chuc_danh', 'Chức danh', 'text', 0, 1),
(103, 22, 'don_vi_cong_tac', 'Đơn vị công tác', 'textarea', 0, 1),
(104, 22, 'khen_thuong', 'Khen thưởng', 'text', 0, 1),
(105, 22, 'ky_luat', 'Kỷ luật', 'text', 0, 1),
(106, 22, 'dia_chi', 'Địa chỉ', 'textarea', 0, 1),
(107, 23, 'cap_do_quan_he', 'Cấp độ quan hệ', 'select', 0, 1),
(108, 23, 'hinh_thuc_quan_he', 'Hình thức quan hệ', 'select', 0, 1),
(109, 23, 'dau_moi', 'Đầu mối', 'text', 0, 1),
(110, 23, 'loai_quan_he', 'Loại quan hệ', 'text', 0, 1),
(111, 23, 'so_dien_thoai', 'Số điện thoại', 'text', 0, 1),
(112, 23, 'co_quan', 'Cơ quan', 'text', 0, 1),
(113, 23, 'dia_chi', 'Địa chỉ', 'text', 0, 1),
(114, 24, 'ten_doanh_nghiep', 'Tên doanh nghiệp', 'text', 1, 1),
(115, 24, 'loai_hinh_kinh_doanh', 'Loại hình kinh doanh', 'textarea', 2, 1),
(116, 24, 'cap_do', 'Cấp độ', 'select', 3, 1),
(117, 24, 'ngay_thanh_lap', 'Ngày thành lập', 'text', 4, 1),
(118, 24, 'dia_chi', 'Địa chỉ', 'textarea', 5, 1),
(119, 24, 'giay_phep', 'Giấy phép', 'text', 6, 1),
(120, 24, 'so_dien_thoai', 'Số điện thoại', 'text', 7, 1),
(121, 24, 'ma_so_thue', 'Mã số thuế', 'text', 8, 1),
(122, 24, 'tai_khoan_ngan_hang', 'Tài khoản ngân hàng', 'text', 9, 1),
(123, 24, 'mo_hinh_to_chuc', 'Mô hình tổ chức', 'file', 11, 1),
(124, 25, 'doanh_so_nam_1', 'Doanh số năm 1', 'text', 1, 1),
(125, 25, 'chi_phi_hoat_dong_mua_sam_1', 'Chi phí hoạt động mua sắm năm 1', 'text', 5, 1),
(126, 25, 'thu_hang', 'Thứ hạng trong nghành/quốc gia', 'text', 9, 1),
(127, 26, 'ho_ten', 'Họ tên', 'text', 1, 1),
(128, 26, 'bi_danh', 'Bí danh', 'text', 2, 1),
(129, 26, 'hinh_anh', 'Hình ảnh', 'file', 3, 1),
(130, 26, 'ngay_sinh', 'Ngày sinh', 'text', 4, 1),
(131, 26, 'menh', 'Mệnh', 'text', 5, 1),
(132, 26, 'noi_sinh', 'Nơi sinh', 'textarea', 6, 1),
(133, 26, 'gioi_tinh', 'Giới tính', 'radio', 7, 1),
(134, 26, 'tien_su_benh', 'Tiền sử bệnh', 'textarea', 8, 1),
(135, 27, 'chuc_danh', 'Chức danh', 'text', 1, 1),
(136, 27, 'so_dien_thoai', 'Số điện thoại', 'text', 2, 1),
(137, 27, 'noi_o_hien_tai', 'Nơi ở hiện tại', 'textarea', 3, 1),
(138, 27, 'tinh_trang_ket_hon', 'Tình trạng hôn nhân', 'radio', 4, 1),
(139, 27, 'so_thich_dac_biet', 'Sở thích đặc biệt', 'text', 5, 1),
(140, 31, 'ten_doanh_nghiep', 'Tên doanh nghiệp', 'text', 1, 1),
(141, 31, 'loai_hinh_kinh_doanh', 'Loại hình kinh doanh', 'text', 2, 1),
(142, 31, 'cap_do', 'Cấp độ', 'select', 3, 1),
(143, 31, 'ngay_thanh_lap', 'Ngày thành lập', 'text', 4, 1),
(144, 31, 'dia_chi', 'Địa chỉ', 'textarea', 5, 1),
(145, 31, 'giay_phep', 'Giấy phép', 'text', 6, 1),
(146, 31, 'so_dien_thoai', 'Số điện thoại', 'text', 7, 1),
(147, 31, 'ma_so_thue', 'Mã số thuế', 'text', 8, 1),
(148, 31, 'so_tai_khoan', 'Số tai khoan', 'text', 9, 1),
(149, 31, 'mo_hinh_to_chuc', 'Mô hình tổ chức', 'file', 11, 1),
(150, 32, 'ho_ten', 'Họ tên', 'text', 1, 1),
(151, 32, 'bi_danh', 'Bí danh', 'text', 2, 1),
(152, 32, 'hinh_anh_dai_dien', 'Hình ảnh đại diện', 'file', 3, 1),
(153, 32, 'ngay_sinh', 'Ngày sinh', 'text', 4, 1),
(154, 32, 'menh', 'Mệnh', 'text', 5, 1),
(155, 32, 'gioi_tinh', 'Giới tính', 'radio', 6, 1),
(156, 32, 'tinh_trang_ket_hon', 'Tình trạng hôn nhân', 'radio', 7, 1),
(157, 32, 'so_thich_dac_biet', 'Sở thích đặc biệt', 'textarea', 8, 1),
(158, 33, 'ten_to_chuc', 'Tên tổ chức', 'text', 1, 1),
(159, 33, 'loai_hinh_hoat_dong', 'Loại hình hoạt động', 'text', 3, 1),
(160, 33, 'cap_do', 'Cấp độ', 'select', 3, 1),
(161, 33, 'ngay_thanh_lap', 'Ngày thành lập', 'text', 4, 1),
(162, 33, 'dia_chi', 'Địa chỉ', 'textarea', 5, 1),
(163, 33, 'so_dien_thoai', 'Số điện thoại', 'text', 6, 1),
(164, 33, 'so_tai_khoan', 'Số tài khoản', 'text', 7, 1),
(165, 33, 'mo_hinh_to_chuc', 'Mô hình tổ chức', 'file', 9, 1),
(166, 34, 'chi_phi_mua_sam_1', 'Chi phí mua năm 1', 'text', 1, 1),
(167, 35, 'ho_ten', 'Họ tên', 'text', 1, 1),
(168, 35, 'bi_danh', 'Bí danh', 'text', 2, 1),
(169, 35, 'hinh_anh_dai_dien', 'Hình ảnh đại diện', 'file', 3, 1),
(170, 35, 'ngay_sinh', 'Ngày sinh', 'text', 4, 1),
(171, 35, 'menh', 'Mệnh', 'text', 5, 1),
(172, 35, 'noi_sinh', 'Nơi sinh', 'textarea', 6, 1),
(173, 35, 'gioi_tinh', 'Giới tính', 'radio', 7, 1),
(174, 35, 'tien_su_benh', 'Tiền sử bệnh', 'textarea', 8, 1),
(175, 36, 'chuc_danh', 'Chức danh', 'text', 1, 1),
(176, 36, 'so_dien_thoai', 'Số điện thoại', 'text', 2, 1),
(177, 36, 'noi_o_hien_tai', 'Nơi ở hiện tại', 'textarea', 3, 1),
(178, 36, 'tinh_trang_hon_nhan', 'Tình trạng hôn nhân', 'radio', 4, 1),
(179, 36, 'so_thich_dac_biet', 'Sở thích đặc biệt', 'textarea', 5, 1),
(180, 37, 'ten_to_chuc', 'Tên tổ chức', 'text', 1, 1),
(181, 37, 'loai_hinh_kinh_doanh', 'Loại hình kinh doanh', 'text', 2, 1),
(182, 37, 'cap_do', 'Cấp độ', 'select', 3, 1),
(183, 37, 'ngay_thanh_lap', 'Ngày thành lập', 'text', 4, 1),
(184, 37, 'dia_chi', 'Địa chỉ', 'textarea', 5, 1),
(185, 37, 'so_dien_thoai', 'Số điện thoại', 'text', 6, 1),
(186, 37, 'so_tai_khoan', 'Số tài khoản', 'text', 7, 1),
(187, 37, 'mo_hinh_to_chuc', 'Mô hình tổ chức', 'file', 9, 1),
(188, 38, 'ho_ten', 'Họ tên', 'text', 1, 1),
(189, 38, 'bi_danh', 'Bí danh', 'text', 2, 1),
(190, 38, 'hinh_anh_dai_dien', 'Hình ảnh đại diện', 'file', 3, 1),
(191, 38, 'ngay_sinh', 'Ngày sinh', 'text', 4, 1),
(192, 38, 'menh', 'Mệnh', 'text', 5, 1),
(193, 38, 'gioi_tinh', 'Giới tính ', 'radio', 6, 1),
(194, 38, 'tinh_trang_hon_nhan', 'Tình trạng hôn nhân', 'radio', 7, 1),
(195, 38, 'so_thich_dac_biet', 'Sở thích đặc biệt', 'textarea', 8, 1),
(200, 3, 'ngan_hang', 'Ngân hàng', 'text', 4, 1),
(201, 3, 'ngay_ket_hon', 'Ngày kết hôn', 'text', 7, 1),
(202, 39, 'the_loai_yeu_thich', 'Thể loại yêu thích', 'text', 13, 1),
(203, 39, 'dien_vien_yeu_thich', 'Diễn viên yêu thích', 'text', 13, 1),
(204, 39, 'dac_diem_luu_y', 'Đặc điểm lưu ý', 'text', 13, 1),
(205, 24, 'ngan_hang', 'Ngân hàng', 'text', 10, 1),
(206, 31, 'ngan_hang', 'Ngân hàng', 'text', 10, 1),
(207, 33, 'ngan_hang', 'Ngân hàng', 'text', 8, 1),
(208, 34, 'chi_phi_mua_sam_2', 'Chi phí mua sắm năm 2', 'text', 2, 1),
(209, 34, 'chi_phi_mua_sam_3', 'Chi phí mua sắm năm 3', 'text', 3, 1),
(210, 34, 'don_vi_tien_te', 'Đơn vị tiền tệ', 'select', 4, 1),
(211, 25, 'doanh_so_nam_2', 'Doanh số năm 2', 'text', 2, 1),
(212, 25, 'doanh_so_nam_3', 'Doanh số năm 3', 'text', 3, 1),
(213, 25, 'don_vi_tien_te_doanh_so', 'Đơn vị tiền tệ (doanh số)', 'select', 4, 1),
(214, 25, 'chi_phi_hoat_dong_mua_sam_2', 'Chi phí hoạt động mua sắm năm 2', 'text', 6, 1),
(215, 25, 'chi_phi_hoat_dong_mua_sam_3', 'Chi phí hoạt động mua sắm năm 3', 'text', 7, 1),
(216, 25, 'don_vi_tien_te_mua_sam', 'Đơn vị tiền tệ (mua sắm)', 'select', 8, 1),
(217, 37, 'ngan_hang', 'Ngân hàng', 'text', 8, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_group`
--

CREATE TABLE `tbl_group` (
  `id` int(11) NOT NULL,
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `tbl_group`
--

INSERT INTO `tbl_group` (`id`, `name`, `value`) VALUES
(1, 'Khách hàng cá nhân', 0),
(2, 'Khách hàng doanh nghiệp', 1),
(3, 'Khách hàng tổ chức', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_meet`
--

CREATE TABLE `tbl_meet` (
  `id` int(11) NOT NULL,
  `mem_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `content` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT '0',
  `datetime` datetime NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `address` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `image` text NOT NULL,
  `result` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `next_time` datetime NOT NULL,
  `next_content` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `note` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_member_level`
--

CREATE TABLE `tbl_member_level` (
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `id` int(11) NOT NULL,
  `firebase_id` text COLLATE utf8_unicode_ci,
  `type_platform` tinyint(4) NOT NULL DEFAULT '0',
  `gender` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `identify` int(11) NOT NULL DEFAULT '0',
  `position` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `permistion` tinyint(2) NOT NULL,
  `cdate` datetime NOT NULL,
  `mdate` date NOT NULL,
  `isactive` int(11) DEFAULT '1',
  `avatar` text COLLATE utf8_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8 CHECKSUM=1 COLLATE=utf8_unicode_ci DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `tbl_member_level`
--

INSERT INTO `tbl_member_level` (`username`, `password`, `id`, `firebase_id`, `type_platform`, `gender`, `phone`, `fullname`, `email`, `birthday`, `identify`, `position`, `permistion`, `cdate`, `mdate`, `isactive`, `avatar`) VALUES
('administrator', 'd2bb9c3211ea6baed657a6c23c9c2faa', 2, 'eia0r04XXro:APA91bG3o8sm-7kROMgmqSqJe-GP2fnq-dbt-bNvS53MKLmO8PlpYl711VmACYBlXLz2HvlFlpZa_IL6jllk8anBsCNVVVzmBTXvlwNDgpiD9CQlQBaYJGbNWBZzMboyArp9UmVZ6Ynt', 0, '0', '0903456789', 'Administrator', 'admin@viettel.com.vn', '1991-03-29', 1023456789, 'Quản trị viên', 1, '2016-05-23 00:00:00', '2018-04-12', 1, NULL),
('chuotbeo', 'd2bb9c3211ea6baed657a6c23c9c2faa', 53, '0', 0, '1', '0988777666', 'Mai Minh Anh', 'chuot@gmail.com', '2018-04-11', 98876655, '', 2, '2018-04-11 22:29:15', '2018-04-11', 1, '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_note`
--

CREATE TABLE `tbl_note` (
  `id` int(11) NOT NULL,
  `mem_id` int(10) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `title` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `content` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `cdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_option_field`
--

CREATE TABLE `tbl_option_field` (
  `id` int(10) NOT NULL,
  `field_id` int(10) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `tbl_option_field`
--

INSERT INTO `tbl_option_field` (`id`, `field_id`, `name`, `value`) VALUES
(1, 28, 'Nhà riêng', 'nha_rieng'),
(2, 28, 'Nhà hàng', 'nha_hang'),
(3, 29, 'Cao đẳng', 'cao_dang'),
(4, 29, 'Đại học', 'dai_hoc'),
(5, 29, 'Thạc sĩ', 'thac_si'),
(6, 29, 'Tiến sĩ', 'tien_si'),
(7, 26, 'Đã kết hôn', 'da_ket_hon'),
(8, 26, 'Chưa', 'chua_ket_hon'),
(9, 116, 'Tập đoàn', 'tap_doan'),
(10, 116, 'Tổng công ty', 'tong_cong_ty'),
(11, 116, 'Công ty con', 'cong_ty_con'),
(12, 116, 'Chi nhánh', 'chi_nhanh'),
(13, 133, 'Nam', '0'),
(14, 133, 'Nữ', '1'),
(15, 138, 'Kết hôn', 'da_ket_hon'),
(16, 138, 'Chưa', 'chua_ket_hon'),
(17, 155, 'Nam', '0'),
(18, 155, 'Nữ', '1'),
(19, 156, 'Đã kết hôn', 'da_ket_hon'),
(20, 156, 'Chưa', 'chua_ket_hon'),
(21, 142, 'Tập đoàn', 'tap_doan'),
(22, 142, 'Tổng công ty', 'tong_cong_ty'),
(23, 142, 'Công ty con', 'cong_ty_con'),
(24, 142, 'Chi nhánh', 'chi_nhanh'),
(25, 178, 'Đã kết hôn', 'da_ket_hon'),
(26, 178, 'Chưa', 'chua_ket_hon'),
(27, 173, 'Nam', '0'),
(28, 173, 'Nữ', '0'),
(29, 193, 'Đã kết hôn', 'da_ket_hon'),
(30, 193, 'Chưa', 'chua_ket_hon'),
(31, 194, 'Nam', '0'),
(32, 194, 'Nữ', '1'),
(33, 160, 'Chính phủ', 'chinh_phu'),
(34, 160, 'Bộ', 'bo'),
(35, 160, 'Cục', 'cuc'),
(36, 160, 'Sở', 'so'),
(37, 182, 'Chính phủ', 'chinh_phu'),
(38, 182, 'Bộ', 'bo'),
(39, 182, 'Cục', 'cuc'),
(40, 182, 'Sở', 'so'),
(41, 213, 'USD', 'USD'),
(42, 213, 'VND', 'VND'),
(43, 216, 'USD', 'USD'),
(44, 216, 'VND', 'VND'),
(45, 210, 'USD', 'USD'),
(46, 210, 'VND', 'VND');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_relationship`
--

CREATE TABLE `tbl_relationship` (
  `id` int(10) NOT NULL,
  `relationship` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `tbl_relationship`
--

INSERT INTO `tbl_relationship` (`id`, `relationship`) VALUES
(1, 'Bố đẻ'),
(2, 'Mẹ đẻ'),
(3, 'Bố vợ'),
(4, 'Mẹ vợ'),
(5, 'Con đẻ'),
(6, 'Con nuôi'),
(7, 'Anh trai'),
(8, 'Em trai'),
(9, 'Chị gái'),
(10, 'Em gái'),
(11, 'Vợ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_sub_category`
--

CREATE TABLE `tbl_sub_category` (
  `id` int(10) NOT NULL,
  `cat_id` int(10) NOT NULL,
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(50) NOT NULL,
  `cdate` date NOT NULL,
  `isactive` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `tbl_sub_category`
--

INSERT INTO `tbl_sub_category` (`id`, `cat_id`, `name`, `alias`, `cdate`, `isactive`) VALUES
(1, 1, 'Thông tin chủ thể', 'thong_tin_gan_dinh_danh_co_the', '2018-04-01', 1),
(2, 1, 'Thông tin quản lý cá nhân trong xã hội', 'thong_tin_quan_ly_ca_nhan_trong_xa_hoi', '2018-04-01', 1),
(3, 1, 'Thông tin xã hội hiện tại', 'thong_tin_xa_hoi_hien_tai', '2018-04-01', 1),
(4, 2, 'Thể thao', 'the_thao', '2018-04-01', 1),
(5, 2, 'Ẩm thực', 'am_thuc', '2018-04-01', 1),
(6, 2, 'Nghệ thuật', 'nghe_thuat', '2018-04-01', 1),
(7, 2, 'Sách', 'sach', '2018-04-01', 1),
(8, 2, 'Xe', 'xe', '2018-04-01', 1),
(9, 2, 'Điện thoại', 'dien_thoai', '2018-04-01', 1),
(10, 2, 'Thời trang', 'thoi_trang', '2018-04-01', 1),
(11, 2, 'Giày', 'giay', '2018-04-01', 1),
(12, 2, 'Nước hoa', 'nuoc_hoa', '2018-04-01', 1),
(13, 2, 'Đồ uống', 'do_uong', '2018-04-01', 1),
(14, 2, 'Ca hát', 'ca_hat', '2018-04-01', 1),
(15, 2, 'Kính đeo', 'kinh_deo', '2018-04-01', 1),
(16, 2, 'Đồng hồ', 'dong_ho', '2018-04-01', 1),
(17, 2, 'Âm nhạc', 'am_nhac', '2018-04-01', 1),
(18, 2, 'Du lịch', 'du_lich', '2018-04-01', 1),
(19, 3, 'Thông tin chủ thể', 'thong_tin_gan_dinh_danh_co_the', '2018-04-01', 1),
(20, 3, 'Thông tin khác', 'thong_tin_khac', '2018-04-01', 1),
(21, 4, 'Quá trình học tập', 'qua_trinh_hoc_tap', '2018-04-01', 1),
(22, 5, 'Lý lịch công tác', 'ly_lich_cong_tac', '2018-04-01', 1),
(23, 6, 'Quan hệ xã hội', 'quan_he_xa_hoi', '2018-04-01', 1),
(24, 7, 'Thông tin cơ bản', 'thong_tin_co_ban', '2018-04-01', 1),
(25, 7, 'Thông tin khác', 'thong_tin_khac', '2018-04-01', 1),
(26, 8, 'Thông tin gắn định danh cơ thể', 'thong_tin_gan_dinh_danh_co_the', '2018-04-01', 1),
(27, 8, 'Thông tin khác', 'thong_tin_khac', '2018-04-01', 1),
(31, 9, 'Thông tin định danh gắn với tổ chức', 'thong_tin_dinh_danh_gan_voi_to_chuc', '2018-04-01', 1),
(32, 9, 'Thông tin người đại diện của đối tác', 'thong_tin_nguoi_dai_dien_doi_tac', '2018-04-01', 1),
(33, 10, 'Thông tin cơ bản', 'thong_tin_co_ban', '2018-04-09', 1),
(34, 10, 'Thông tin khác', 'thong_tin_khac', '2018-04-09', 1),
(35, 11, 'Thông tin gán định danh cơ thể', 'thong_tin_gan_dinh_danh_co_the', '2018-04-09', 1),
(36, 11, 'Thông tin khác', 'thong_tin_khac', '2018-04-09', 1),
(37, 12, 'Thông tin định danh gán với tổ chức', 'thong_tin_dinh_danh_gan_to_chu', '2018-04-09', 1),
(38, 12, 'Thông tin người đại diện của đối tác', 'thong_tin_nguoi_dai_dien_cua_doi_tac', '2018-04-09', 1),
(39, 2, 'Phim ảnh', 'phim_anh', '0000-00-00', 1),
(41, 2, 'Hóng chuyện', 'hong_chuyen', '2018-05-16', 0);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tbl_common`
--
ALTER TABLE `tbl_common`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tbl_customer_detail`
--
ALTER TABLE `tbl_customer_detail`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tbl_display`
--
ALTER TABLE `tbl_display`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tbl_export_pdf`
--
ALTER TABLE `tbl_export_pdf`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tbl_field_infomation`
--
ALTER TABLE `tbl_field_infomation`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tbl_group`
--
ALTER TABLE `tbl_group`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tbl_meet`
--
ALTER TABLE `tbl_meet`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tbl_member_level`
--
ALTER TABLE `tbl_member_level`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `11` (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `isactive` (`isactive`);

--
-- Chỉ mục cho bảng `tbl_note`
--
ALTER TABLE `tbl_note`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tbl_option_field`
--
ALTER TABLE `tbl_option_field`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tbl_relationship`
--
ALTER TABLE `tbl_relationship`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tbl_sub_category`
--
ALTER TABLE `tbl_sub_category`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `tbl_common`
--
ALTER TABLE `tbl_common`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT cho bảng `tbl_customer_detail`
--
ALTER TABLE `tbl_customer_detail`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2551;

--
-- AUTO_INCREMENT cho bảng `tbl_display`
--
ALTER TABLE `tbl_display`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT cho bảng `tbl_export_pdf`
--
ALTER TABLE `tbl_export_pdf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `tbl_field_infomation`
--
ALTER TABLE `tbl_field_infomation`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=219;

--
-- AUTO_INCREMENT cho bảng `tbl_group`
--
ALTER TABLE `tbl_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `tbl_meet`
--
ALTER TABLE `tbl_meet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tbl_member_level`
--
ALTER TABLE `tbl_member_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT cho bảng `tbl_note`
--
ALTER TABLE `tbl_note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tbl_option_field`
--
ALTER TABLE `tbl_option_field`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT cho bảng `tbl_relationship`
--
ALTER TABLE `tbl_relationship`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `tbl_sub_category`
--
ALTER TABLE `tbl_sub_category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
