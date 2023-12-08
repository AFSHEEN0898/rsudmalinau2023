/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.25-MariaDB : Database - siatika
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `ids` */

DROP TABLE IF EXISTS `ids`;

CREATE TABLE `ids` (
  `id_ids` int(11) NOT NULL AUTO_INCREMENT,
  `id_theme` int(11) NOT NULL,
  `nama_ids` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  `permalink` varchar(255) NOT NULL,
  `all_reload` float NOT NULL,
  `warna_latar` varchar(255) NOT NULL,
  `header_color` varchar(255) NOT NULL,
  `header_color_teks` varchar(255) NOT NULL,
  PRIMARY KEY (`id_ids`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ids` */

/*Table structure for table `ids_fields` */

DROP TABLE IF EXISTS `ids_fields`;

CREATE TABLE `ids_fields` (
  `id_ids_field` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `field` varchar(225) DEFAULT NULL,
  `id_konten` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_ids_field`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `ids_fields` */

/*Table structure for table `ids_galeri` */

DROP TABLE IF EXISTS `ids_galeri`;

CREATE TABLE `ids_galeri` (
  `id_galeri` int(11) NOT NULL AUTO_INCREMENT,
  `urut` int(2) DEFAULT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jeda` int(12) DEFAULT NULL,
  `posisi` int(1) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  PRIMARY KEY (`id_galeri`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ids_galeri` */

/*Table structure for table `ids_konten` */

DROP TABLE IF EXISTS `ids_konten`;

CREATE TABLE `ids_konten` (
  `id_konten` int(11) NOT NULL AUTO_INCREMENT,
  `id_kategori` int(11) DEFAULT NULL,
  `id_tipe_konten` int(11) NOT NULL,
  `id_ids` int(11) NOT NULL,
  `posisi` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `id_data` int(11) DEFAULT NULL,
  `id_font` int(11) DEFAULT NULL,
  `data_img` varchar(255) DEFAULT NULL,
  `status` int(1) NOT NULL,
  `urut` int(11) NOT NULL,
  `durasi` varchar(50) DEFAULT NULL,
  `per_page` int(11) DEFAULT NULL,
  `param1` varchar(255) DEFAULT NULL,
  `param2` varchar(255) DEFAULT NULL,
  `param3` varchar(255) DEFAULT NULL,
  `param4` varchar(255) DEFAULT NULL,
  `param5` varchar(255) DEFAULT NULL,
  `mulai_tayang` date DEFAULT NULL,
  `selesai_tayang` date DEFAULT NULL,
  PRIMARY KEY (`id_konten`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ids_konten` */

/*Table structure for table `ids_ref_konten` */

DROP TABLE IF EXISTS `ids_ref_konten`;

CREATE TABLE `ids_ref_konten` (
  `id_ref_konten` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `ref_konten` varchar(255) NOT NULL,
  PRIMARY KEY (`id_ref_konten`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `ids_ref_konten` */

insert  into `ids_ref_konten`(`id_ref_konten`,`code`,`ref_konten`) values 
(1,'Peg','Data Pegawai'),
(2,'VI','Video'),
(3,'INF','Informasi'),
(4,'AGN','Agenda'),
(6,'PGM','Pengumuman'),
(7,'Foto','Galeri Foto'),
(8,'TK','Teks Bergerak');

/*Table structure for table `ids_ref_theme` */

DROP TABLE IF EXISTS `ids_ref_theme`;

CREATE TABLE `ids_ref_theme` (
  `id_theme` int(11) NOT NULL AUTO_INCREMENT,
  `theme` varchar(255) NOT NULL,
  PRIMARY KEY (`id_theme`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `ids_ref_theme` */

insert  into `ids_ref_theme`(`id_theme`,`theme`) values 
(1,'1 Kolom'),
(2,'2 Kolom'),
(3,'3 Kolom'),
(4,'4 Kolom'),
(5,'5 Kolom'),
(6,'6 Kolom');

/*Table structure for table `ids_setting` */

DROP TABLE IF EXISTS `ids_setting`;

CREATE TABLE `ids_setting` (
  `id_setting` int(11) NOT NULL AUTO_INCREMENT,
  `id_ids` int(11) NOT NULL,
  `posisi` int(11) NOT NULL,
  `tinggi` float NOT NULL,
  `background_title` varchar(20) DEFAULT NULL,
  `background_kolom` varchar(255) NOT NULL,
  `color_title` varchar(20) DEFAULT NULL,
  `lebar` varchar(255) NOT NULL,
  PRIMARY KEY (`id_setting`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ids_setting` */

/*Table structure for table `ids_teks` */

DROP TABLE IF EXISTS `ids_teks`;

CREATE TABLE `ids_teks` (
  `id_teks` int(11) NOT NULL AUTO_INCREMENT,
  `teks` text NOT NULL,
  `urut` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `op` int(11) NOT NULL,
  PRIMARY KEY (`id_teks`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ids_teks` */

/*Table structure for table `ids_tipe_konten` */

DROP TABLE IF EXISTS `ids_tipe_konten`;

CREATE TABLE `ids_tipe_konten` (
  `id_tipe_konten` int(11) NOT NULL AUTO_INCREMENT,
  `tipe_konten` varchar(255) NOT NULL,
  `kode_konten` varchar(50) NOT NULL,
  `id_aplikasi` int(11) NOT NULL,
  PRIMARY KEY (`id_tipe_konten`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ids_tipe_konten` */

/*Table structure for table `log_book` */

DROP TABLE IF EXISTS `log_book`;

CREATE TABLE `log_book` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(20) DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `op` int(11) DEFAULT NULL,
  `date_act` datetime DEFAULT NULL,
  `action` int(1) DEFAULT NULL,
  `kait` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_log`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `log_book` */

insert  into `log_book`(`id_log`,`kode`,`keterangan`,`op`,`date_act`,`action`,`kait`) values 
(1,'datainduk',NULL,1,'2023-10-11 11:14:36',1,29),
(2,'datainduk',NULL,1,'2023-10-11 11:19:05',2,29),
(3,'datainduk',NULL,1,'2023-10-11 11:26:03',1,30),
(4,'datainduk',NULL,1,'2023-10-11 11:29:32',2,30),
(5,'datainduk',NULL,1,'2023-10-11 11:31:27',1,31),
(6,'datainduk',NULL,1,'2023-10-26 15:24:25',2,29),
(7,'datainduk',NULL,1,'2023-10-28 20:21:54',1,33),
(8,'datainduk',NULL,1,'2023-11-01 11:27:15',1,48),
(9,'datainduk',NULL,46,'2023-11-01 11:30:01',1,49),
(10,'datainduk',NULL,46,'2023-11-01 11:33:38',2,49),
(11,'datainduk',NULL,1,'2023-11-02 11:43:56',1,50),
(12,'datainduk',NULL,1,'2023-11-02 11:47:11',2,29),
(13,'datainduk',NULL,1,'2023-11-02 11:47:37',2,31),
(14,'datainduk',NULL,1,'2023-11-02 11:48:58',2,30),
(15,'datainduk',NULL,1,'2023-12-04 12:37:47',1,52),
(16,'datainduk',NULL,1,'2023-12-04 12:38:31',2,52);

/*Table structure for table `log_db` */

DROP TABLE IF EXISTS `log_db`;

CREATE TABLE `log_db` (
  `id_log_db` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(1) NOT NULL,
  `moddate` datetime NOT NULL,
  `detail` text NOT NULL,
  PRIMARY KEY (`id_log_db`)
) ENGINE=MyISAM AUTO_INCREMENT=141 DEFAULT CHARSET=utf8;

/*Data for the table `log_db` */

insert  into `log_db`(`id_log_db`,`type`,`moddate`,`detail`) values 
(1,2,'2018-04-30 02:42:33','Modul <b>Operator SITIKA</b> ditambahkan'),
(2,2,'2018-04-30 02:42:33','Modul <b>Pengaturan</b> ditambahkan'),
(3,2,'2018-04-30 02:42:33','Modul <b>Kewenangan</b> ditambahkan'),
(4,2,'2018-04-30 02:42:33','Modul <b>Operator</b> ditambahkan'),
(5,2,'2018-04-30 02:42:34','Modul <b>Informasi</b> ditambahkan'),
(6,2,'2018-04-30 02:42:34','Modul <b>Berita</b> ditambahkan'),
(7,2,'2018-04-30 02:42:34','Modul <b>Pengumuman</b> ditambahkan'),
(8,2,'2018-04-30 02:42:34','Modul <b>Agenda Kegiatan</b> ditambahkan'),
(9,2,'2018-04-30 02:42:34','Modul <b>Gallery</b> ditambahkan'),
(10,2,'2018-04-30 02:42:34','Modul <b>Video</b> ditambahkan'),
(11,2,'2018-04-30 02:42:34','Modul <b>Foto</b> ditambahkan'),
(12,2,'2018-04-30 02:42:34','Modul <b>Running Text</b> ditambahkan'),
(13,2,'2018-04-30 02:42:34','Modul <b>Backsound</b> ditambahkan'),
(14,1,'2018-04-30 04:06:59','Tabel <strong>sitika_articles</strong> ditambahkan'),
(15,1,'2018-04-30 04:42:05','Tabel <strong>sitika_categories</strong> ditambahkan'),
(16,1,'2018-04-30 04:42:05','Tabel <strong>sitika_uploads</strong> ditambahkan'),
(17,2,'2018-04-30 04:52:29','Modul <b>Operator SITIKA</b> ditambahkan'),
(18,2,'2018-04-30 04:52:29','Modul <b>Pengaturan</b> ditambahkan'),
(19,2,'2018-04-30 04:52:29','Modul <b>Kewenangan</b> ditambahkan'),
(20,2,'2018-04-30 04:52:29','Modul <b>Operator</b> ditambahkan'),
(21,2,'2018-04-30 04:52:29','Modul <b>Informasi</b> ditambahkan'),
(22,2,'2018-04-30 04:52:29','Modul <b>Berita</b> ditambahkan'),
(23,2,'2018-04-30 04:52:29','Modul <b>Pengumuman</b> ditambahkan'),
(24,2,'2018-04-30 04:52:29','Modul <b>Agenda Kegiatan</b> ditambahkan'),
(25,2,'2018-04-30 04:52:29','Modul <b>Gallery</b> ditambahkan'),
(26,2,'2018-04-30 04:52:29','Modul <b>Video</b> ditambahkan'),
(27,2,'2018-04-30 04:52:29','Modul <b>Foto</b> ditambahkan'),
(28,2,'2018-04-30 04:52:29','Modul <b>Running Text</b> ditambahkan'),
(29,2,'2018-04-30 04:52:29','Modul <b>Backsound</b> ditambahkan'),
(30,2,'2018-04-30 04:53:46','Modul <b>Operator SITIKA</b> ditambahkan'),
(31,2,'2018-04-30 04:53:46','Modul <b>Pengaturan</b> ditambahkan'),
(32,2,'2018-04-30 04:53:46','Modul <b>Kewenangan</b> ditambahkan'),
(33,2,'2018-04-30 04:53:46','Modul <b>Operator</b> ditambahkan'),
(34,2,'2018-04-30 04:53:46','Modul <b>Informasi</b> ditambahkan'),
(35,2,'2018-04-30 04:53:46','Modul <b>Berita</b> ditambahkan'),
(36,2,'2018-04-30 04:53:46','Modul <b>Pengumuman</b> ditambahkan'),
(37,2,'2018-04-30 04:53:46','Modul <b>Agenda Kegiatan</b> ditambahkan'),
(38,2,'2018-04-30 04:53:46','Modul <b>Gallery</b> ditambahkan'),
(39,2,'2018-04-30 04:53:46','Modul <b>Video</b> ditambahkan'),
(40,2,'2018-04-30 04:53:46','Modul <b>Foto</b> ditambahkan'),
(41,2,'2018-04-30 04:53:46','Modul <b>Running Text</b> ditambahkan'),
(42,2,'2018-04-30 04:53:46','Modul <b>Backsound</b> ditambahkan'),
(43,1,'2018-04-30 04:56:46','Tabel <strong>sitika_categories</strong> ditambahkan'),
(44,1,'2018-05-07 08:55:19','Tabel <strong>sitika_foto</strong> ditambahkan'),
(45,1,'2018-05-07 08:56:37','Tabel <strong>sitika_video</strong> ditambahkan'),
(46,1,'2018-05-14 10:06:46','Kolom <strong>foto</strong> pada <strong>sitika_video</strong> ditambahkan'),
(47,1,'2018-05-14 10:06:46','Tabel <strong>sitika_running_text</strong> ditambahkan'),
(48,1,'2018-05-15 03:07:09','Tabel <strong>sitika_backsound</strong> ditambahkan'),
(49,2,'2018-05-15 03:34:03','Modul <b>Operator SITIKA</b> ditambahkan'),
(50,2,'2018-05-15 03:34:03','Modul <b>Pengaturan</b> ditambahkan'),
(51,2,'2018-05-15 03:34:03','Modul <b>Kewenangan</b> ditambahkan'),
(52,2,'2018-05-15 03:34:03','Modul <b>Operator</b> ditambahkan'),
(53,2,'2018-05-15 03:34:03','Modul <b>Informasi</b> ditambahkan'),
(54,2,'2018-05-15 03:34:03','Modul <b>Berita</b> ditambahkan'),
(55,2,'2018-05-15 03:34:03','Modul <b>Pengumuman</b> ditambahkan'),
(56,2,'2018-05-15 03:34:03','Modul <b>Agenda Kegiatan</b> ditambahkan'),
(57,2,'2018-05-15 03:34:03','Modul <b>Gallery</b> ditambahkan'),
(58,2,'2018-05-15 03:34:03','Modul <b>Video</b> ditambahkan'),
(59,2,'2018-05-15 03:34:03','Modul <b>Foto</b> ditambahkan'),
(60,2,'2018-05-15 03:34:03','Modul <b>Running Text</b> ditambahkan'),
(61,2,'2018-05-15 03:34:03','Modul <b>Backsound</b> ditambahkan'),
(62,2,'2018-05-15 03:35:27','Modul <b>Operator SITIKA</b> ditambahkan'),
(63,2,'2018-05-15 03:35:27','Modul <b>Pengaturan</b> ditambahkan'),
(64,2,'2018-05-15 03:35:27','Modul <b>Kewenangan</b> ditambahkan'),
(65,2,'2018-05-15 03:35:27','Modul <b>Operator</b> ditambahkan'),
(66,2,'2018-05-15 03:35:27','Modul <b>Informasi</b> ditambahkan'),
(67,2,'2018-05-15 03:35:27','Modul <b>Berita</b> ditambahkan'),
(68,2,'2018-05-15 03:35:27','Modul <b>Pengumuman</b> ditambahkan'),
(69,2,'2018-05-15 03:35:27','Modul <b>Agenda Kegiatan</b> ditambahkan'),
(70,2,'2018-05-15 03:35:27','Modul <b>Gallery</b> ditambahkan'),
(71,2,'2018-05-15 03:35:28','Modul <b>Video</b> ditambahkan'),
(72,2,'2018-05-15 03:35:28','Modul <b>Foto</b> ditambahkan'),
(73,2,'2018-05-15 03:35:28','Modul <b>Running Text</b> ditambahkan'),
(74,2,'2018-05-15 03:35:28','Modul <b>Backsound</b> ditambahkan'),
(75,1,'2018-05-16 07:10:04','Tabel <strong>sitika_widget</strong> ditambahkan'),
(76,1,'2018-05-24 07:05:27','Kolom <strong>jeda</strong> pada <strong>sitika_articles</strong> ditambahkan'),
(77,2,'2018-05-24 07:05:27','Modul <b>Setting</b> ditambahkan'),
(78,1,'2018-05-25 02:04:24','Kolom <strong>urut</strong> pada <strong>sitika_running_text</strong> ditambahkan'),
(79,1,'2018-05-25 02:32:31','Kolom <strong>urut</strong> pada <strong>sitika_backsound</strong> ditambahkan'),
(80,2,'2018-05-25 14:31:08','Modul <b>Operator SITIKA</b> ditambahkan'),
(81,2,'2018-05-25 14:31:08','Modul <b>Pengaturan</b> ditambahkan'),
(82,2,'2018-05-25 14:31:08','Modul <b>Kewenangan</b> ditambahkan'),
(83,2,'2018-05-25 14:31:08','Modul <b>Operator</b> ditambahkan'),
(84,2,'2018-05-25 14:31:08','Modul <b>Publikasi</b> ditambahkan'),
(85,2,'2018-05-25 14:31:09','Modul <b>Informasi</b> ditambahkan'),
(86,2,'2018-05-25 14:31:09','Modul <b>Berita</b> ditambahkan'),
(87,2,'2018-05-25 14:31:09','Modul <b>Agenda Kegiatan</b> ditambahkan'),
(88,2,'2018-05-25 14:31:09','Modul <b>Pengumuman</b> ditambahkan'),
(89,2,'2018-05-25 14:31:09','Modul <b>Gallery</b> ditambahkan'),
(90,2,'2018-05-25 14:31:09','Modul <b>Video</b> ditambahkan'),
(91,2,'2018-05-25 14:31:09','Modul <b>Foto</b> ditambahkan'),
(92,2,'2018-05-25 14:31:09','Modul <b>Running Text</b> ditambahkan'),
(93,2,'2018-05-25 14:31:09','Modul <b>Backsound</b> ditambahkan'),
(94,2,'2018-05-25 14:31:09','Modul <b>Parameter</b> ditambahkan'),
(95,2,'2018-05-26 01:59:57','Modul <b>Operator SITIKA</b> ditambahkan'),
(96,2,'2018-05-26 01:59:57','Modul <b>Pengaturan</b> ditambahkan'),
(97,2,'2018-05-26 01:59:57','Modul <b>Kewenangan</b> ditambahkan'),
(98,2,'2018-05-26 01:59:57','Modul <b>Operator</b> ditambahkan'),
(99,2,'2018-05-26 01:59:58','Modul <b>Publikasi</b> ditambahkan'),
(100,2,'2018-05-26 01:59:58','Modul <b>Informasi</b> ditambahkan'),
(101,2,'2018-05-26 01:59:58','Modul <b>Berita</b> ditambahkan'),
(102,2,'2018-05-26 01:59:58','Modul <b>Agenda Kegiatan</b> ditambahkan'),
(103,2,'2018-05-26 01:59:58','Modul <b>Pengumuman</b> ditambahkan'),
(104,2,'2018-05-26 01:59:58','Modul <b>Gallery</b> ditambahkan'),
(105,2,'2018-05-26 01:59:58','Modul <b>Video</b> ditambahkan'),
(106,2,'2018-05-26 01:59:58','Modul <b>Foto</b> ditambahkan'),
(107,2,'2018-05-26 01:59:58','Modul <b>Running Text</b> ditambahkan'),
(108,2,'2018-05-26 01:59:58','Modul <b>Backsound</b> ditambahkan'),
(109,2,'2018-05-26 01:59:58','Modul <b>Parameter</b> ditambahkan'),
(110,2,'2018-05-26 01:59:58','Modul <b>Parameter IDS 1</b> ditambahkan'),
(111,2,'2018-05-26 01:59:58','Modul <b>Parameter IDS 2</b> ditambahkan'),
(112,2,'2018-05-26 02:01:06','Modul <b>Operator SITIKA</b> ditambahkan'),
(113,2,'2018-05-26 02:01:06','Modul <b>Pengaturan</b> ditambahkan'),
(114,2,'2018-05-26 02:01:06','Modul <b>Kewenangan</b> ditambahkan'),
(115,2,'2018-05-26 02:01:06','Modul <b>Operator</b> ditambahkan'),
(116,2,'2018-05-26 02:01:06','Modul <b>Publikasi</b> ditambahkan'),
(117,2,'2018-05-26 02:01:06','Modul <b>Informasi</b> ditambahkan'),
(118,2,'2018-05-26 02:01:06','Modul <b>Berita</b> ditambahkan'),
(119,2,'2018-05-26 02:01:06','Modul <b>Agenda Kegiatan</b> ditambahkan'),
(120,2,'2018-05-26 02:01:06','Modul <b>Pengumuman</b> ditambahkan'),
(121,2,'2018-05-26 02:01:06','Modul <b>Gallery</b> ditambahkan'),
(122,2,'2018-05-26 02:01:06','Modul <b>Video</b> ditambahkan'),
(123,2,'2018-05-26 02:01:06','Modul <b>Foto</b> ditambahkan'),
(124,2,'2018-05-26 02:01:06','Modul <b>Running Text</b> ditambahkan'),
(125,2,'2018-05-26 02:01:06','Modul <b>Backsound</b> ditambahkan'),
(126,2,'2018-05-26 02:01:06','Modul <b>Parameter</b> ditambahkan'),
(127,2,'2018-05-26 02:01:06','Modul <b>Parameter IDS 1</b> ditambahkan'),
(128,2,'2018-05-26 02:01:06','Modul <b>Parameter IDS 2</b> ditambahkan'),
(129,1,'2018-05-28 09:25:27','Kolom <strong>foto</strong> pada <strong>sitika_articles</strong> ditambahkan'),
(130,1,'2019-04-11 05:15:24','Tabel <strong>ref_font</strong> ditambahkan'),
(131,1,'2019-04-11 05:15:25','Tabel <strong>ids</strong> ditambahkan'),
(132,1,'2019-04-11 05:15:25','Tabel <strong>ids_konten</strong> ditambahkan'),
(133,1,'2019-04-11 05:15:26','Tabel <strong>ids_tipe_konten</strong> ditambahkan'),
(134,1,'2019-04-11 05:15:26','Tabel <strong>ids_ref_konten</strong> ditambahkan'),
(135,1,'2019-04-11 05:15:27','Tabel <strong>ids_ref_theme</strong> ditambahkan'),
(136,1,'2019-04-11 05:15:27','Tabel <strong>ids_setting</strong> ditambahkan'),
(137,1,'2019-04-11 05:15:27','Tabel <strong>ids_teks</strong> ditambahkan'),
(138,1,'2019-04-11 05:15:28','Tabel <strong>ids_galeri</strong> ditambahkan'),
(139,2,'2019-04-11 05:15:28','Modul <b>Pengaturan IDS</b> ditambahkan'),
(140,2,'2019-04-11 05:15:28','Modul <b>IDS</b> ditambahkan');

/*Table structure for table `nav` */

DROP TABLE IF EXISTS `nav`;

CREATE TABLE `nav` (
  `id_nav` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_par_nav` int(11) DEFAULT NULL,
  `id_aplikasi` int(1) DEFAULT NULL,
  `ref` int(1) DEFAULT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `tipe` int(1) DEFAULT NULL,
  `judul` varchar(128) DEFAULT NULL,
  `link` varchar(128) DEFAULT NULL,
  `fa` varchar(50) DEFAULT NULL,
  `urut` int(3) DEFAULT NULL,
  `aktif` int(1) DEFAULT NULL,
  PRIMARY KEY (`id_nav`)
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8;

/*Data for the table `nav` */

insert  into `nav`(`id_nav`,`id_par_nav`,`id_aplikasi`,`ref`,`kode`,`tipe`,`judul`,`link`,`fa`,`urut`,`aktif`) values 
(99,NULL,1,1,'operator_siatika',1,'Operator SIATIKA','','',1,1),
(100,NULL,1,1,NULL,2,'Pengaturan',NULL,'cog',2,1),
(101,100,1,1,'',2,'Kewenangan','siatika/kewenangan','',3,1),
(102,100,1,1,NULL,2,'Operator','siatika/operator',NULL,4,1),
(103,NULL,1,1,'',2,'Konten','','briefcase',5,1),
(104,103,1,1,NULL,2,'Informasi','siatika/articles/list_data/1',NULL,9,1),
(106,103,1,1,'',2,'Agenda','siatika/articles/list_data/3','',6,1),
(107,103,1,1,NULL,2,'Pengumuman','siatika/articles/list_data/4',NULL,8,1),
(108,NULL,1,1,'',2,'Galeri','','photo-video',6,1),
(109,108,1,1,NULL,2,'Video','siatika/video',NULL,12,1),
(110,108,1,1,NULL,2,'Foto','siatika/foto',NULL,11,1),
(112,NULL,1,1,'',2,'IDS','siatika/list_ids','file-audio-o',7,0),
(115,NULL,3,1,NULL,2,'Pengaturan IDS','ids/pengaturan','desktop',1,1),
(116,NULL,3,1,NULL,2,'IDS','ids/list_ids','laptop',2,1),
(117,NULL,1,1,'',2,'Data Pegawai','siatika/pegawai','users',4,1),
(118,NULL,1,1,'',2,'Referensi','','asterisk',3,1),
(119,103,1,1,'',2,'Teks Bergerak','siatika/running_text','',19,1),
(120,118,1,1,'',2,'Status Pegawai','siatika/umum/ke/status_pegawai','',22,1),
(121,118,1,1,'',2,'Golongan Ruang/Pangkat','siatika/umum/ke/pangkat','',23,1),
(122,118,1,1,'',2,'Jabatan','siatika/umum/ke/jabatan','',29,1),
(123,118,1,1,'',2,'Eselon','siatika/umum/ke/eselon','',24,1),
(124,118,1,1,'',2,'Unit Kerja','siatika/ref_unit','',20,1),
(125,118,1,1,'',2,'Unit Organisasi','siatika/bidang','',21,1),
(126,108,1,1,'',2,'Audio','siatika/backsound','',26,1),
(127,108,1,1,'',2,'Poster','siatika/set_umum','',27,1),
(128,NULL,1,1,'',2,'Parameter','siatika/parameter','tachometer-alt',8,1),
(129,100,1,1,'',2,'Umum','siatika/setting','',28,1),
(130,118,1,1,'',2,'Jenis Jabatan','siatika/umum/ke/jabatan_jenis','',25,1);

/*Table structure for table `parameter` */

DROP TABLE IF EXISTS `parameter`;

CREATE TABLE `parameter` (
  `param` varchar(32) NOT NULL,
  `val` text DEFAULT NULL,
  PRIMARY KEY (`param`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `parameter` */

insert  into `parameter`(`param`,`val`) values 
('alamat',''),
('all_reload','30'),
('aplikasi','Sistem Informasi Aplikasi TV Info Publikasi'),
('aplikasi_code','SIATIKA'),
('aplikasi_logo','logo.png'),
('aplikasi_logo_only',NULL),
('aplikasi_s','SIATIKA'),
('application_title','TV-INFO PUBLIKASI DAN PROMOSI'),
('application_title_2','WARTA PASAR'),
('app_active','1'),
('basic_color',''),
('color_basic_1','#ffffff'),
('color_basic_2','#f8e5ff'),
('color_berlangsung_1','#478eb1'),
('color_box_berlangsung_1','#ffffff'),
('color_box_foto_1','#ffffff'),
('color_box_foto_2','#ffffff'),
('color_box_informasi_1','#dde6eb'),
('color_box_informasi_2','#ffffff'),
('color_box_pengumuman_1','#dde6eb'),
('color_box_pengumuman_2','#e4bbbb'),
('color_box_profil_1','#d0b3b3'),
('color_box_rencana_1','#ffffff'),
('color_box_video_1','#ffffff'),
('color_box_video_2','#b16e6e'),
('color_date_1','#000000'),
('color_date_2','#000000'),
('color_footer_1','#9bc4db'),
('color_footer_2','#000000'),
('color_foto_1','#478eb1'),
('color_foto_2','#510045'),
('color_foto_pegawai','#dde6eb'),
('color_header_1','#9bc4db'),
('color_header_2','#500380'),
('color_informasi_1','#478eb1'),
('color_informasi_2','#510045'),
('color_pengumuman_1','#478eb1'),
('color_pengumuman_2','#510045'),
('color_profil_1','#510045'),
('color_rencana_1','#478eb1'),
('color_text_basic',''),
('color_text_berlangsung_1','#000000'),
('color_text_column',NULL),
('color_text_date',NULL),
('color_text_date_1','#9bc4db'),
('color_text_date_2','#ffffff'),
('color_text_footer_1','#000000'),
('color_text_footer_2','#ffffff'),
('color_text_foto_1','#000000'),
('color_text_foto_2','#000000'),
('color_text_galeri',NULL),
('color_text_header',NULL),
('color_text_header_1','#000000'),
('color_text_header_2','#ffffff'),
('color_text_informasi_1','#000000'),
('color_text_informasi_2','#000000'),
('color_text_marquee',NULL),
('color_text_pengumuman_1','#000000'),
('color_text_pengumuman_2','#000000'),
('color_text_profil_1','#000000'),
('color_text_rencana_1','#000000'),
('color_text_time',NULL),
('color_text_time_1','#9bc4db'),
('color_text_time_2','#ffffff'),
('color_text_title',NULL),
('color_text_video_1','#000000'),
('color_text_video_2','#000000'),
('color_time_1','#000000'),
('color_time_2','#000000'),
('color_title_berlangsung_1','#ffffff'),
('color_title_foto_1','#ffffff'),
('color_title_foto_2','#ffffff'),
('color_title_informasi_1','#ffffff'),
('color_title_informasi_2','#ffffff'),
('color_title_pengumuman_1','#ffffff'),
('color_title_pengumuman_2','#ffffff'),
('color_title_profil_1','#ffffff'),
('color_title_rencana_1','#ffffff'),
('color_title_video_1','#ffffff'),
('color_title_video_2','#ffffff'),
('color_video_1','#478eb1'),
('color_video_2','#510045'),
('column_color','#ffffff'),
('copyright','2023'),
('default_pass',''),
('demo','2'),
('font_berlangsung_1','14'),
('font_informasi_1','14'),
('font_informasi_2','14'),
('font_pengumuman_1','14'),
('font_pengumuman_2',''),
('font_profil_1','14'),
('font_rencana_1','16'),
('foto_latar_login',''),
('header_image','Selamat_Datang_(1).png'),
('height_berlangsung_1',NULL),
('height_foto_1',NULL),
('height_foto_2',NULL),
('height_foto_pegawai',NULL),
('height_informasi_1',NULL),
('height_informasi_2',NULL),
('height_konten',''),
('height_pengumuman_1',NULL),
('height_pengumuman_2',NULL),
('height_profil_1',NULL),
('height_rencana_1',NULL),
('height_sidebar_1',NULL),
('height_sidebar_2',NULL),
('height_video_1',NULL),
('ibukota','Malinau'),
('instansi','Rumah Sakit Umum Daerah'),
('instansi_code','RSUD MALINAU'),
('instansi_s','RSUD MALINAU'),
('login_captcha',NULL),
('main_color','#79ACD4'),
('marquee_color','#f8c300'),
('mode_video_umum','2'),
('multi_unit','1'),
('pemerintah','Kabupaten Malinau'),
('pemerintah_logo','logo_230902093750.png'),
('pemerintah_logo_bw','logo_2309020937501.png'),
('pemerintah_s','MALINAU'),
('photo_height','300'),
('photo_height_2','165'),
('refresh_time_1','1000'),
('refresh_time_2','10'),
('slide_foto_pegawai','6'),
('time_color','#f8c300'),
('title_color','#ffffff'),
('title_color_2','#ffffff');

/*Table structure for table `peg_jabatan` */

DROP TABLE IF EXISTS `peg_jabatan`;

CREATE TABLE `peg_jabatan` (
  `id_peg_jabatan` int(11) NOT NULL AUTO_INCREMENT,
  `id_pegawai` int(11) NOT NULL,
  `id_unit` int(11) NOT NULL,
  `id_jabatan` int(11) NOT NULL,
  `id_bidang` int(11) NOT NULL,
  `id_atasan` int(11) DEFAULT NULL,
  `id_atasan_atasan` int(11) DEFAULT NULL,
  `id_penetap` int(1) DEFAULT NULL,
  `id_status_pegawai` int(1) NOT NULL,
  `id_golru` int(11) DEFAULT NULL,
  `no_sk` varchar(50) DEFAULT NULL,
  `tanggal_sk` date DEFAULT NULL,
  `tmt_jabatan` date DEFAULT NULL,
  `selesai_jabatan` date DEFAULT NULL,
  `tanggal_cetak` datetime DEFAULT NULL,
  `perpanjangan` int(3) DEFAULT NULL,
  `puncak` int(1) NOT NULL,
  `status` int(1) NOT NULL,
  `tgl_pelantikan` date DEFAULT NULL,
  PRIMARY KEY (`id_peg_jabatan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `peg_jabatan` */

/*Table structure for table `peg_pegawai` */

DROP TABLE IF EXISTS `peg_pegawai`;

CREATE TABLE `peg_pegawai` (
  `id_pegawai` int(11) NOT NULL AUTO_INCREMENT,
  `id_unit` int(11) DEFAULT NULL,
  `id_bidang` int(11) DEFAULT NULL,
  `id_jabatan` int(11) DEFAULT NULL,
  `id_eselon` int(11) DEFAULT NULL,
  `id_agama` int(1) DEFAULT NULL,
  `id_jeniskelamin` int(1) DEFAULT NULL,
  `id_status_pegawai` int(11) DEFAULT NULL,
  `id_gol_darah` int(1) DEFAULT NULL,
  `id_tempat_lahir` int(11) DEFAULT NULL,
  `id_statuskawin` int(11) DEFAULT NULL,
  `id_suku` int(11) DEFAULT NULL,
  `id_kelurahan` int(11) DEFAULT NULL,
  `id_tipe_pegawai` int(1) DEFAULT NULL,
  `username` varchar(32) DEFAULT NULL,
  `password` varchar(32) NOT NULL,
  `nip` char(18) DEFAULT NULL,
  `nip_lama` varchar(18) DEFAULT NULL,
  `no_nik` varchar(30) DEFAULT NULL,
  `no_npwp` varchar(30) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `gelar_depan` varchar(20) DEFAULT NULL,
  `gelar_belakang` varchar(20) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `hobi` varchar(100) DEFAULT NULL,
  `tinggi` int(1) DEFAULT NULL,
  `berat` int(1) DEFAULT NULL,
  `rambut` varchar(100) DEFAULT NULL,
  `bentuk_muka` varchar(100) DEFAULT NULL,
  `warna_kulit` varchar(100) DEFAULT NULL,
  `ciri_khas` varchar(100) DEFAULT NULL,
  `cacat` varchar(100) DEFAULT NULL,
  `alamat` varchar(150) DEFAULT NULL,
  `kodepos` varchar(10) DEFAULT NULL,
  `telepon` varchar(12) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `pin` varchar(20) DEFAULT NULL,
  `website` varchar(150) DEFAULT NULL,
  `photo` varchar(150) DEFAULT NULL,
  `cpns_tmt` date DEFAULT NULL,
  `cpns_no` varchar(100) DEFAULT NULL,
  `cpns_tanggal` date DEFAULT NULL,
  `cpns_berkas` varchar(50) DEFAULT NULL,
  `mkg_tahun` int(1) DEFAULT NULL,
  `mkg_bulan` int(1) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `mn_jabatan` varchar(255) DEFAULT NULL COMMENT 'Manual Jabatan',
  `mn_golru` varchar(255) DEFAULT NULL COMMENT 'Manual Golongan',
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT 1,
  `id_golru` int(11) DEFAULT NULL,
  `id_jab_jenis` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_pegawai`),
  UNIQUE KEY `nip` (`nip`),
  UNIQUE KEY `username` (`username`),
  KEY `id_jeniskelamin` (`id_jeniskelamin`),
  KEY `id_agama` (`id_agama`),
  KEY `id_gol_darah` (`id_gol_darah`),
  KEY `id_kelurahan` (`id_kelurahan`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

/*Data for the table `peg_pegawai` */

insert  into `peg_pegawai`(`id_pegawai`,`id_unit`,`id_bidang`,`id_jabatan`,`id_eselon`,`id_agama`,`id_jeniskelamin`,`id_status_pegawai`,`id_gol_darah`,`id_tempat_lahir`,`id_statuskawin`,`id_suku`,`id_kelurahan`,`id_tipe_pegawai`,`username`,`password`,`nip`,`nip_lama`,`no_nik`,`no_npwp`,`nama`,`gelar_depan`,`gelar_belakang`,`tanggal_lahir`,`hobi`,`tinggi`,`berat`,`rambut`,`bentuk_muka`,`warna_kulit`,`ciri_khas`,`cacat`,`alamat`,`kodepos`,`telepon`,`email`,`pin`,`website`,`photo`,`cpns_tmt`,`cpns_no`,`cpns_tanggal`,`cpns_berkas`,`mkg_tahun`,`mkg_bulan`,`last_login`,`mn_jabatan`,`mn_golru`,`tempat_lahir`,`status`,`id_golru`,`id_jab_jenis`) values 
(1,0,0,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,'admin','d8578edf8458ce06fbc5bb76a58c5ca4','adminsitipro',NULL,NULL,NULL,'Administrator',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-12-06 02:26:54',NULL,NULL,'',0,NULL,NULL),
(52,0,0,0,0,0,1,0,0,NULL,0,NULL,NULL,1,'123456789012345678','9efebb3d7d059bff092842bf31dd2816','123456789012345678',NULL,NULL,NULL,'Anicetus Heri Gunawan','dr','','2023-12-04',NULL,0,0,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'123456789012345678.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0',1,NULL,NULL);

/*Table structure for table `pegawai_role` */

DROP TABLE IF EXISTS `pegawai_role`;

CREATE TABLE `pegawai_role` (
  `id_peg_role` int(11) NOT NULL AUTO_INCREMENT,
  `id_pegawai` int(11) NOT NULL,
  `id_role` int(3) NOT NULL,
  PRIMARY KEY (`id_peg_role`),
  KEY `id_pegawai` (`id_pegawai`,`id_role`),
  KEY `id_role` (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

/*Data for the table `pegawai_role` */

insert  into `pegawai_role`(`id_peg_role`,`id_pegawai`,`id_role`) values 
(13,1,1),
(3,3,2),
(14,28,8),
(16,32,8),
(17,35,8),
(26,36,21),
(19,37,10),
(20,38,13),
(21,39,10),
(22,40,18),
(23,42,15),
(24,44,1),
(25,46,17),
(27,51,23);

/*Table structure for table `ref_agama` */

DROP TABLE IF EXISTS `ref_agama`;

CREATE TABLE `ref_agama` (
  `id_agama` int(1) NOT NULL AUTO_INCREMENT,
  `agama` varchar(50) NOT NULL,
  PRIMARY KEY (`id_agama`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `ref_agama` */

insert  into `ref_agama`(`id_agama`,`agama`) values 
(2,'Islam'),
(3,'Kristen'),
(4,'Budha'),
(5,'Hindu'),
(6,'Buda'),
(7,'Konghucu');

/*Table structure for table `ref_aplikasi` */

DROP TABLE IF EXISTS `ref_aplikasi`;

CREATE TABLE `ref_aplikasi` (
  `id_aplikasi` int(1) NOT NULL AUTO_INCREMENT,
  `id_par_aplikasi` int(1) DEFAULT NULL,
  `urut` int(1) NOT NULL,
  `kode_aplikasi` varchar(15) NOT NULL,
  `nama_aplikasi` varchar(50) NOT NULL,
  `deskripsi` varchar(80) DEFAULT NULL,
  `folder` varchar(30) DEFAULT NULL,
  `warna` varchar(7) DEFAULT NULL,
  `aktif` int(1) DEFAULT NULL,
  PRIMARY KEY (`id_aplikasi`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `ref_aplikasi` */

insert  into `ref_aplikasi`(`id_aplikasi`,`id_par_aplikasi`,`urut`,`kode_aplikasi`,`nama_aplikasi`,`deskripsi`,`folder`,`warna`,`aktif`) values 
(1,NULL,1,'stk','SIATIKA','Sistem Informasi TV Info Publikasi & Promosi','siatika','#343166',1);

/*Table structure for table `ref_bidang` */

DROP TABLE IF EXISTS `ref_bidang`;

CREATE TABLE `ref_bidang` (
  `id_bidang` int(11) NOT NULL AUTO_INCREMENT,
  `id_par_bidang` int(11) DEFAULT NULL,
  `id_unit` int(11) NOT NULL,
  `penetapan` date DEFAULT NULL,
  `kode_bidang` varchar(20) DEFAULT NULL,
  `nama_bidang` varchar(255) NOT NULL,
  `urut` int(1) NOT NULL,
  `aktif` int(1) DEFAULT NULL,
  PRIMARY KEY (`id_bidang`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `ref_bidang` */

insert  into `ref_bidang`(`id_bidang`,`id_par_bidang`,`id_unit`,`penetapan`,`kode_bidang`,`nama_bidang`,`urut`,`aktif`) values 
(4,NULL,1,NULL,'PP','Pelayanan Penunjang',1,NULL),
(5,NULL,1,NULL,'PMK','Pelayanan Medis dan Keperawatan',2,NULL);

/*Table structure for table `ref_eselon` */

DROP TABLE IF EXISTS `ref_eselon`;

CREATE TABLE `ref_eselon` (
  `id_eselon` int(1) NOT NULL AUTO_INCREMENT,
  `eselon` varchar(80) NOT NULL,
  `urut` int(1) DEFAULT NULL,
  `struc` int(1) DEFAULT 2,
  PRIMARY KEY (`id_eselon`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

/*Data for the table `ref_eselon` */

insert  into `ref_eselon`(`id_eselon`,`eselon`,`urut`,`struc`) values 
(12,'I.A',2,1),
(13,'I.B',3,1),
(14,'II.A',4,1),
(15,'II.B',5,1),
(16,'III.A',6,1),
(17,'III.B',7,1),
(18,'IV.A',8,1),
(19,'IV.B',9,1),
(20,'V.A',10,1),
(32,'Non Eselon',11,2),
(34,'III.D',1,2);

/*Table structure for table `ref_font` */

DROP TABLE IF EXISTS `ref_font`;

CREATE TABLE `ref_font` (
  `id_font` int(11) NOT NULL AUTO_INCREMENT,
  `font` int(11) NOT NULL,
  PRIMARY KEY (`id_font`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ref_font` */

/*Table structure for table `ref_gol_darah` */

DROP TABLE IF EXISTS `ref_gol_darah`;

CREATE TABLE `ref_gol_darah` (
  `id_gol_darah` int(1) NOT NULL AUTO_INCREMENT,
  `gol_darah` varchar(10) NOT NULL,
  PRIMARY KEY (`id_gol_darah`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `ref_gol_darah` */

insert  into `ref_gol_darah`(`id_gol_darah`,`gol_darah`) values 
(1,'A'),
(2,'AB'),
(3,'O'),
(4,'B+'),
(5,'B-'),
(6,'A+'),
(7,'A-');

/*Table structure for table `ref_golru` */

DROP TABLE IF EXISTS `ref_golru`;

CREATE TABLE `ref_golru` (
  `id_golru` int(1) NOT NULL AUTO_INCREMENT,
  `id_golru_jenis` int(1) DEFAULT NULL,
  `golongan` varchar(20) NOT NULL,
  `pangkat` varchar(50) NOT NULL,
  `urut` int(1) DEFAULT NULL,
  PRIMARY KEY (`id_golru`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

/*Data for the table `ref_golru` */

insert  into `ref_golru`(`id_golru`,`id_golru_jenis`,`golongan`,`pangkat`,`urut`) values 
(1,0,'I/a','Juru Muda',1),
(2,0,'I/b','Juru Muda Tingkat I',2),
(3,0,'I/c','Juru',3),
(4,0,'I/d','Juru Tingkat I',4),
(5,0,'II/a','Pengatur Muda',5),
(6,0,'II/b','Pengatur Muda Tingkat I',6),
(7,0,'II/c','Pengatur',7),
(8,0,'II/d','Pengatur Tingkat I',8),
(9,0,'III/a','Penata Muda',9),
(10,0,'III/b','Penata Muda Tingkat I',10),
(11,0,'III/c','Penata',11),
(12,0,'III/d','Penata Tingkat I',12),
(13,0,'IV/a','Pembina',13),
(14,0,'IV/b','Pembina Tingkat I',14),
(15,0,'IV/c','Pembina Utama Muda',15),
(16,0,'IV/d','Pembina Utama Madya',16),
(17,0,'IV/e','Pembina Utama',17);

/*Table structure for table `ref_jabatan` */

DROP TABLE IF EXISTS `ref_jabatan`;

CREATE TABLE `ref_jabatan` (
  `id_jabatan` int(11) NOT NULL AUTO_INCREMENT,
  `id_bidang` int(11) DEFAULT NULL,
  `id_jab_jenis` int(1) NOT NULL,
  `id_eselon` int(1) NOT NULL,
  `nama_jabatan` varchar(255) NOT NULL,
  `bup` int(1) NOT NULL,
  `stat_jab` int(1) NOT NULL,
  `aktif` int(1) DEFAULT 1,
  PRIMARY KEY (`id_jabatan`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `ref_jabatan` */

insert  into `ref_jabatan`(`id_jabatan`,`id_bidang`,`id_jab_jenis`,`id_eselon`,`nama_jabatan`,`bup`,`stat_jab`,`aktif`) values 
(1,4,1,34,'Kepada Bidang Pelayanan Penunjang',58,1,1),
(3,5,3,32,'Dokter Umum',58,1,1);

/*Table structure for table `ref_jabatan_jenis` */

DROP TABLE IF EXISTS `ref_jabatan_jenis`;

CREATE TABLE `ref_jabatan_jenis` (
  `id_jab_jenis` int(1) NOT NULL AUTO_INCREMENT,
  `jenis_jabatan` varchar(50) NOT NULL,
  PRIMARY KEY (`id_jab_jenis`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `ref_jabatan_jenis` */

insert  into `ref_jabatan_jenis`(`id_jab_jenis`,`jenis_jabatan`) values 
(1,'Jabatan Struktural'),
(2,'Jabatan Fungsional Tertentu'),
(3,'Jabatan Fungsional Umum'),
(4,'Jabatan Rangkap (Struktural dan Fungsional)');

/*Table structure for table `ref_jenis_kelamin` */

DROP TABLE IF EXISTS `ref_jenis_kelamin`;

CREATE TABLE `ref_jenis_kelamin` (
  `id_jeniskelamin` int(1) NOT NULL AUTO_INCREMENT,
  `jenis_kelamin` varchar(20) NOT NULL,
  PRIMARY KEY (`id_jeniskelamin`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `ref_jenis_kelamin` */

insert  into `ref_jenis_kelamin`(`id_jeniskelamin`,`jenis_kelamin`) values 
(1,'LAKI-LAKI'),
(2,'PEREMPUAN');

/*Table structure for table `ref_kategori` */

DROP TABLE IF EXISTS `ref_kategori`;

CREATE TABLE `ref_kategori` (
  `id_kategori` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(250) NOT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `ref_kategori` */

insert  into `ref_kategori`(`id_kategori`,`nama_kategori`) values 
(1,'Umum'),
(2,'Intern');

/*Table structure for table `ref_lokasi` */

DROP TABLE IF EXISTS `ref_lokasi`;

CREATE TABLE `ref_lokasi` (
  `id_lokasi` int(11) NOT NULL AUTO_INCREMENT,
  `lokasi` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_lokasi`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

/*Data for the table `ref_lokasi` */

insert  into `ref_lokasi`(`id_lokasi`,`lokasi`) values 
(2,'Putussibau'),
(3,'Pontianak'),
(4,'Solo'),
(5,'Yogyakarta'),
(6,'kalimantan timur'),
(7,'Pacitan'),
(8,'Jakarta'),
(9,'Balikpapan'),
(12,'Magetan'),
(13,'jaka'),
(14,'pu'),
(15,''),
(16,'Muara Teweh'),
(17,'Meulaboh'),
(18,'Kutai Kartanegara'),
(19,NULL);

/*Table structure for table `ref_penetap` */

DROP TABLE IF EXISTS `ref_penetap`;

CREATE TABLE `ref_penetap` (
  `id_penetap` int(11) NOT NULL AUTO_INCREMENT,
  `penetap` varchar(120) DEFAULT NULL,
  `kop` int(1) DEFAULT NULL,
  PRIMARY KEY (`id_penetap`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `ref_penetap` */

insert  into `ref_penetap`(`id_penetap`,`penetap`,`kop`) values 
(1,'Bupati',NULL),
(2,'Kepala Dinas',NULL),
(3,'SEKRETARIS DAERAH',NULL),
(4,'',NULL),
(5,'GUBERNUR KALIMANTAN TIMUR',NULL),
(6,'0',NULL),
(7,'0',NULL),
(8,'0',NULL),
(9,'0',NULL),
(10,'0',NULL),
(11,'0',NULL);

/*Table structure for table `ref_propinsi` */

DROP TABLE IF EXISTS `ref_propinsi`;

CREATE TABLE `ref_propinsi` (
  `id_propinsi` int(11) NOT NULL AUTO_INCREMENT,
  `kode_propinsi` varchar(20) DEFAULT NULL,
  `propinsi` varchar(128) NOT NULL,
  `ibukota` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id_propinsi`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `ref_propinsi` */

insert  into `ref_propinsi`(`id_propinsi`,`kode_propinsi`,`propinsi`,`ibukota`) values 
(1,NULL,'Yogyakarta',NULL);

/*Table structure for table `ref_role` */

DROP TABLE IF EXISTS `ref_role`;

CREATE TABLE `ref_role` (
  `id_role` int(3) NOT NULL AUTO_INCREMENT,
  `id_aplikasi` int(1) NOT NULL,
  `nama_role` varchar(80) NOT NULL,
  PRIMARY KEY (`id_role`),
  KEY `id_aplikasi` (`id_aplikasi`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

/*Data for the table `ref_role` */

insert  into `ref_role`(`id_role`,`id_aplikasi`,`nama_role`) values 
(1,1,'Admin SIATIKA'),
(6,3,'a'),
(23,1,'Operator SIATIKA');

/*Table structure for table `ref_role_nav` */

DROP TABLE IF EXISTS `ref_role_nav`;

CREATE TABLE `ref_role_nav` (
  `id_role_nav` int(11) NOT NULL AUTO_INCREMENT,
  `id_role` int(11) NOT NULL,
  `id_nav` int(11) NOT NULL,
  PRIMARY KEY (`id_role_nav`)
) ENGINE=InnoDB AUTO_INCREMENT=596 DEFAULT CHARSET=utf8;

/*Data for the table `ref_role_nav` */

insert  into `ref_role_nav`(`id_role_nav`,`id_role`,`id_nav`) values 
(315,6,115),
(316,6,116),
(558,23,99),
(559,23,117),
(560,23,103),
(561,23,106),
(562,23,107),
(563,23,104),
(564,23,119),
(565,23,108),
(566,23,110),
(567,23,109),
(568,23,126),
(569,23,127),
(570,23,128),
(571,1,99),
(572,1,100),
(573,1,101),
(574,1,102),
(575,1,129),
(576,1,118),
(577,1,124),
(578,1,125),
(579,1,120),
(580,1,121),
(581,1,123),
(582,1,130),
(583,1,122),
(584,1,117),
(585,1,103),
(586,1,106),
(587,1,107),
(588,1,104),
(589,1,119),
(590,1,108),
(591,1,110),
(592,1,109),
(593,1,126),
(594,1,127),
(595,1,128);

/*Table structure for table `ref_role_unit` */

DROP TABLE IF EXISTS `ref_role_unit`;

CREATE TABLE `ref_role_unit` (
  `id_role_unit` int(11) NOT NULL AUTO_INCREMENT,
  `id_role` int(3) NOT NULL,
  `id_unit` int(11) NOT NULL,
  PRIMARY KEY (`id_role_unit`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `ref_role_unit` */

insert  into `ref_role_unit`(`id_role_unit`,`id_role`,`id_unit`) values 
(1,6,1),
(2,7,3),
(3,7,2),
(4,7,1);

/*Table structure for table `ref_status_kawin` */

DROP TABLE IF EXISTS `ref_status_kawin`;

CREATE TABLE `ref_status_kawin` (
  `id_statuskawin` int(1) NOT NULL AUTO_INCREMENT,
  `statuskawin` varchar(20) NOT NULL,
  PRIMARY KEY (`id_statuskawin`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `ref_status_kawin` */

insert  into `ref_status_kawin`(`id_statuskawin`,`statuskawin`) values 
(1,'Kawin'),
(2,'Belum Kawin'),
(3,'Lajang'),
(4,'Janda'),
(5,'Duda');

/*Table structure for table `ref_status_pegawai` */

DROP TABLE IF EXISTS `ref_status_pegawai`;

CREATE TABLE `ref_status_pegawai` (
  `id_status_pegawai` int(1) NOT NULL AUTO_INCREMENT,
  `tipe` int(1) NOT NULL,
  `nama_status` varchar(50) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `urut` int(1) DEFAULT NULL,
  PRIMARY KEY (`id_status_pegawai`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `ref_status_pegawai` */

insert  into `ref_status_pegawai`(`id_status_pegawai`,`tipe`,`nama_status`,`keterangan`,`urut`) values 
(1,1,'CPNS',NULL,1),
(2,1,'PNS',NULL,2),
(4,2,'Pensiun',NULL,4),
(6,2,'Mutasi Keluar',NULL,6),
(7,2,'Berhenti',NULL,7),
(9,1,'NON PNS','',0);

/*Table structure for table `ref_tipe_pegawai` */

DROP TABLE IF EXISTS `ref_tipe_pegawai`;

CREATE TABLE `ref_tipe_pegawai` (
  `id_tipe_pegawai` int(11) NOT NULL AUTO_INCREMENT,
  `tipe_pegawai` varchar(64) NOT NULL,
  `jenis` int(1) DEFAULT NULL,
  PRIMARY KEY (`id_tipe_pegawai`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `ref_tipe_pegawai` */

insert  into `ref_tipe_pegawai`(`id_tipe_pegawai`,`tipe_pegawai`,`jenis`) values 
(1,'PNS',1),
(2,'PTT',2);

/*Table structure for table `ref_unit` */

DROP TABLE IF EXISTS `ref_unit`;

CREATE TABLE `ref_unit` (
  `id_unit` int(11) NOT NULL AUTO_INCREMENT,
  `id_par_unit` int(11) DEFAULT NULL,
  `kode_unit` varchar(20) DEFAULT NULL,
  `unit` varchar(255) NOT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `telp` varchar(12) DEFAULT NULL,
  `id_kepala` int(11) DEFAULT NULL,
  `aktif` int(1) DEFAULT NULL,
  `urut` int(1) DEFAULT NULL,
  `bso_uu` text DEFAULT NULL,
  `level_unit` int(11) NOT NULL,
  PRIMARY KEY (`id_unit`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `ref_unit` */

insert  into `ref_unit`(`id_unit`,`id_par_unit`,`kode_unit`,`unit`,`alamat`,`telp`,`id_kepala`,`aktif`,`urut`,`bso_uu`,`level_unit`) values 
(1,NULL,'RSUD','Rumah Sakit Umum Daerah','','',NULL,1,1,NULL,1);

/*Table structure for table `sitika_articles` */

DROP TABLE IF EXISTS `sitika_articles`;

CREATE TABLE `sitika_articles` (
  `id_article` int(11) NOT NULL AUTO_INCREMENT,
  `id_kategori` int(11) DEFAULT NULL,
  `id_cat` varchar(200) DEFAULT NULL,
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `code` int(2) DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `extend` text DEFAULT NULL,
  `permalink` varchar(255) DEFAULT NULL,
  `id_operator` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `tempat` varchar(255) DEFAULT NULL,
  `kontak` varchar(255) DEFAULT NULL,
  `jeda` double DEFAULT NULL,
  `foto` varchar(256) DEFAULT NULL,
  `ket` enum('rencana','berlangsung','selesai') DEFAULT NULL,
  PRIMARY KEY (`id_article`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `sitika_articles` */

insert  into `sitika_articles`(`id_article`,`id_kategori`,`id_cat`,`date_start`,`date_end`,`code`,`title`,`content`,`extend`,`permalink`,`id_operator`,`status`,`tempat`,`kontak`,`jeda`,`foto`,`ket`) values 
(1,1,'N;','2023-12-04 03:58:11',NULL,4,'Pelayanan Poliklinik','<p>Disampaikan kepada masyarakat bahwa hari senin tanggal 4 s/d 5 desember 2023, Pelayanan Poliklinik Jiwa \"TUTUP\". Buka kembali pada hari Rabu, 6 desember 2023.</p>',NULL,'pelayanan_poliklinik',1,1,NULL,NULL,NULL,NULL,NULL),
(2,2,'N;','2023-12-04 04:02:52',NULL,4,'PELAYANAN RAWAT JALAN','<p>PELAYANAN RAWAT JALAN :</p>\r\n<ol>\r\n<li>KLINIK EXECUTIVE/MCU</li>\r\n<li>KLINIK SPESIALIS PENYAKIT DALAM</li>\r\n<li>KLINIK SPESIALIS BEDAH</li>\r\n<li>KLINIK SPESIALIS KANDUNGAN/OBGYN</li>\r\n<li>KLINIK SPESIALIS ANAK</li>\r\n<li>KLINIK SPESIALIS PARU</li>\r\n<li>KLINIK SPESIALIS JIWA</li>\r\n<li>KLINIK SPESIALIS SYARAF</li>\r\n<li>KLINIK SPESIALIS MATA</li>\r\n<li>KLINIK SPESIALIS GIZI KLINIS</li>\r\n<li>KLINIK SPESIALIS GIGI PENYAKIT MULUT</li>\r\n<li>KLINIK SPESIALIS KONSERVASI GIGI</li>\r\n<li>KLINIK SPESIALIS BEDAH MULUT</li>\r\n<li>KLINIK SPESIALIS PERIODENSIA</li>\r\n<li>KLINIK POLI GIGI UMUM</li>\r\n<li>KLINIK GERIATRI (LANSIA)</li>\r\n<li>KLINIK TB DOTS</li>\r\n<li>KLINIK LAKTASI</li>\r\n<li>KLINIK VAKSIN</li>\r\n<li>KLINIK REHABILITASI MEDIK/FISIOTERAPI</li>\r\n<li>KLINIK VCT</li>\r\n<li>UNIT HEMODIALISA</li>\r\n</ol>',NULL,'pelayanan_rawat_jalan',1,1,NULL,NULL,NULL,NULL,NULL),
(3,1,'N;','2023-12-04 04:05:33',NULL,1,'Hak dan Kewajiban Pasien (UU No. 44 Tahun 2009 tentang Rumah Sakit)','<p><strong>Hak Pasien</strong></p>\r\n<ol>\r\n<li>Memperoleh Informasi mengenai tata tertib dan peraturan yang berlaku di rumah sakit.</li>\r\n<li>Memperoleh informasi tentang hak dan kewajiban pasien.</li>\r\n<li>Memperoleh layanan yang manusiawi, adil dan jujur.</li>\r\n<li>Memperoleh layanan medis yang bermutu sesuai dengan standar profesi dan standar operasional.</li>\r\n<li>Memperoleh layanan yang efektif dan efisien sehingga terhindar dari kerugian fisik dan materi.</li>\r\n<li>Mengajukan pengaduan atas kualitas pelayanan yang di dapatkan.</li>\r\n<li>Memilih dokter dan kelas perawatan sesuai dengan keinginannya dan peraturan yang berlaku di rumah sakit.</li>\r\n<li>Meminta konsultasi tentang penyakit yang dideritanya kepada dokter lain yang mempunyai Surat Izin Praktek (SIP) baik didalam maupun diluar rumah sakit.</li>\r\n<li>Mendapatkan privasi dan kerahasiaan penyakit yang diderita termasuk data-data medisnya.</li>\r\n<li>Mendapatkan informasi yang meliputi diagnosis dan tata cara tindakan medis, tujuan tindakan, risikio dan prognosis terhadap tindakan yang dilakukan serta perkiraan biaya pengobatan.</li>\r\n<li>Memberikan persetujuan atau menolak atas tindakan yang akan dilakukan oleh tenaga kesehatan terhadap penyakit yang dideritanya.</li>\r\n<li>Didampingi keluarga dalam keadaan kritis.</li>\r\n<li>Menjalankan Ibadah sesuai agama atau kepercayaan yang dianutnya selama hal itu tidak mengganggu pasien lainnya.</li>\r\n<li>Memperoleh keamanan dan keselamatan dirinya selama dalam perawatan di rumah sakit.</li>\r\n<li>Mengajukan usul, saran, perbaikan atau perlakuan rumah sakit terhadap dirinya.</li>\r\n<li>Menolak pelayanan bimbingan rohani yang tidak sesuai dengan agama dan kepercayaan yang dianutnya.</li>\r\n<li>Menggugat dan menuntut rumah sakit apabila rumah sakit diduga memberikan pelayanan yang tidak sesuai dengan standar baik secara perdata maupun pidana, dan</li>\r\n<li>Mengeluhkan pelayanan rumah sakit yang tidak sesuai dengan standar pelayanan melalui media cetak elektronik sesuai dengan ketentuan perundang-undangan.</li>\r\n</ol>\r\n<p>&nbsp;</p>\r\n<p><strong>Kewajiban Pasien/Keluarga</strong></p>\r\n<p><strong>Peraturan Menteri Kesehatan Republik Indonesia Nomor 69 Tahun 2014</strong></p>\r\n<ol>\r\n<li>Mematuhi peraturan yang berlaku di Rumah Sakit.</li>\r\n<li>Menggunakan fasilitas rumah sakit secara bertanggung jawab.</li>\r\n<li>Menghormati hak-hak pasien lain, pengunjung dan hak tenaga kesehatan serta petugas lainnya yang bekerja di rumah sakit.</li>\r\n<li>Memberikan informasi yang jujur, lengkap dan akurat sesuai kemampuan dan pengetahuannya tentang masalah kesehatan.</li>\r\n<li>Memberikan informasi mengenai kemampuan finansial dan jaminan kesehatan yang di milikinya.</li>\r\n<li>Mematuhi rencana terapi yang direkomendasikan oleh tenaga kesehatan di rumah sakit dan diaetujui oleh pasien yang bersangkutan setelah mendapatkan penjelasan sesuai ketentuan perundang-undangan.</li>\r\n<li>Menerima segala konsekuensi atas keputusan pribadinya untuk menolak rencana terapi yang di rekomendasikan oleh tenaga kesehatan dan / atau tidak mematuhi petunjuk yang di berikan oleh tenaga kesehatan dalam rangka penyembuhan penyakit atau masalah kesehatannya, dan</li>\r\n<li>Memberikan imbalan jasa atas&nbsp; pelayanan yang diterima.</li>\r\n</ol>',NULL,'hak_dan_kewajiban_pasien_uu_no_44_tahun_2009_tentang_rumah_sakit',1,1,NULL,NULL,NULL,NULL,NULL),
(4,2,'N;','2023-12-04 04:06:54',NULL,1,'Maklumat Pelayanan','<p>Sanggup menyelenggarakan pelayanan sesuai dengan standar yang ditetapkan dan apabila dalam penyelenggaraan pelayanan kami yang tidak sesuai dengan standar pelayanan yang telah ditetapkan, kami bersedia menerima sanksi sesuai ketentuan peraturan perundang-undangan yang berlaku.</p>',NULL,'maklumat_pelayanan',1,1,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `sitika_backsound` */

DROP TABLE IF EXISTS `sitika_backsound`;

CREATE TABLE `sitika_backsound` (
  `id_backsound` int(11) NOT NULL AUTO_INCREMENT,
  `backsound` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `urut` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_backsound`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `sitika_backsound` */

insert  into `sitika_backsound`(`id_backsound`,`backsound`,`keterangan`,`status`,`urut`) values 
(1,'audio_20231205_100406.mp3','',2,0);

/*Table structure for table `sitika_categories` */

DROP TABLE IF EXISTS `sitika_categories`;

CREATE TABLE `sitika_categories` (
  `id_cat` int(3) NOT NULL AUTO_INCREMENT,
  `code` int(2) NOT NULL,
  `category` varchar(150) NOT NULL,
  `slug` varchar(50) DEFAULT NULL,
  `id_cat_parent` int(3) DEFAULT NULL,
  `extends_cat` text DEFAULT NULL,
  PRIMARY KEY (`id_cat`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `sitika_categories` */

/*Table structure for table `sitika_foto` */

DROP TABLE IF EXISTS `sitika_foto`;

CREATE TABLE `sitika_foto` (
  `id_foto` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jeda` varchar(15) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `urut` int(2) DEFAULT NULL,
  `posisi` int(1) NOT NULL,
  `tipe` int(1) DEFAULT NULL,
  PRIMARY KEY (`id_foto`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `sitika_foto` */

insert  into `sitika_foto`(`id_foto`,`judul`,`foto`,`keterangan`,`tanggal`,`jeda`,`status`,`urut`,`posisi`,`tipe`) values 
(1,'KEGIATAN PROMKES RSUD MALINAU','foto_20231204_161452.jpeg',NULL,'2023-12-04',NULL,2,NULL,1,1),
(2,'PENYULUHAN DIABETES MELITUS','foto_20231204_161553.jpeg',NULL,'2023-12-04',NULL,2,NULL,2,1),
(3,'dr. Dwi Yuniari, Sp. GK','foto_20231205_095125.jpeg',NULL,'2023-12-05',NULL,2,NULL,1,2),
(4,'dr. Imelda Miami','foto_20231205_095205.jpg',NULL,'2023-12-05',NULL,2,NULL,1,2),
(5,'dr. Renjisa Arwin Maly','foto_20231205_095326.jpeg',NULL,'2023-12-05',NULL,2,NULL,1,2);

/*Table structure for table `sitika_running_text` */

DROP TABLE IF EXISTS `sitika_running_text`;

CREATE TABLE `sitika_running_text` (
  `id_running_text` int(11) NOT NULL AUTO_INCREMENT,
  `teks_bergerak` text DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `urut` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_running_text`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `sitika_running_text` */

insert  into `sitika_running_text`(`id_running_text`,`teks_bergerak`,`status`,`urut`) values 
(1,'Selamat Datang di Rumah Sakit Umum Daerah Malinau',2,0);

/*Table structure for table `sitika_uploads` */

DROP TABLE IF EXISTS `sitika_uploads`;

CREATE TABLE `sitika_uploads` (
  `id_upload` int(11) NOT NULL AUTO_INCREMENT,
  `code` int(2) NOT NULL,
  `id_article` int(11) NOT NULL,
  `id_gallery` int(11) NOT NULL,
  `file_name` text NOT NULL,
  `id_destinasi` int(11) NOT NULL,
  `status` int(3) NOT NULL,
  `aktif` int(1) NOT NULL,
  `id_operator` int(11) NOT NULL,
  `timestamps` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_upload`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `sitika_uploads` */

/*Table structure for table `sitika_video` */

DROP TABLE IF EXISTS `sitika_video`;

CREATE TABLE `sitika_video` (
  `id_video` int(11) NOT NULL AUTO_INCREMENT,
  `video_source` int(11) DEFAULT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `youtube_link` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `jeda` double DEFAULT NULL,
  `vid_youtube` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_video`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `sitika_video` */

insert  into `sitika_video`(`id_video`,`video_source`,`judul`,`video`,`keterangan`,`tanggal`,`youtube_link`,`status`,`foto`,`jeda`,`vid_youtube`) values 
(1,2,'Layanan RSUD Malinau',NULL,NULL,'2023-12-05','https://www.youtube.com/embed/QSN-d77zQm8',2,NULL,NULL,'QSN-d77zQm8');

/*Table structure for table `sitika_widget` */

DROP TABLE IF EXISTS `sitika_widget`;

CREATE TABLE `sitika_widget` (
  `id_widget` int(11) NOT NULL AUTO_INCREMENT,
  `tipe` int(1) NOT NULL,
  `kode` varchar(64) DEFAULT NULL,
  `urut` int(1) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `op` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_widget`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `sitika_widget` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
