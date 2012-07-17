-- phpMyAdmin SQL Dump
-- version 2.8.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Dec 16, 2009 at 01:20 AM
-- Server version: 5.0.21
-- PHP Version: 5.1.4
-- 
-- Database: `astaperaga`
-- 
CREATE DATABASE `astaperaga` DEFAULT CHARACTER SET latin1 COLLATE latin1_general_ci;
USE `astaperaga`;

-- --------------------------------------------------------

-- 
-- Table structure for table `alamatpengiriman`
-- 

CREATE TABLE `alamatpengiriman` (
  `idPengiriman` int(11) NOT NULL auto_increment,
  `namaPengiriman` text NOT NULL,
  PRIMARY KEY  (`idPengiriman`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `alamatpengiriman`
-- 

INSERT INTO `alamatpengiriman` VALUES (1, 'idem');
INSERT INTO `alamatpengiriman` VALUES (2, 'lain');

-- --------------------------------------------------------

-- 
-- Table structure for table `bank`
-- 

CREATE TABLE `bank` (
  `idBank` int(11) NOT NULL auto_increment,
  `namaBank` text NOT NULL,
  `noRekBank` text NOT NULL,
  `namaPemilik` text NOT NULL,
  `cabang` text NOT NULL,
  `image` text NOT NULL,
  PRIMARY KEY  (`idBank`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- 
-- Dumping data for table `bank`
-- 

INSERT INTO `bank` VALUES (1, 'BCA', '6760123933', 'A. Roful Hasbi', 'KCP BSD Tangerang', 'bca.jpg');
INSERT INTO `bank` VALUES (2, 'BNI', '0095833714', 'A. Roful Hasbi', 'KCP BSD Tangerang', 'images_019.jpg');

-- --------------------------------------------------------

-- 
-- Table structure for table `berita`
-- 

CREATE TABLE `berita` (
  `idBerita` int(4) NOT NULL auto_increment,
  `judulBerita` text NOT NULL,
  `tgl` date NOT NULL,
  `isiBerita` text NOT NULL,
  `idStatusShow` int(2) NOT NULL,
  `idKategoriBerita` int(2) NOT NULL,
  PRIMARY KEY  (`idBerita`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `berita`
-- 

INSERT INTO `berita` VALUES (2, 'INFO', '2009-02-21', 'Toko Online Kami Siap Melayani Anda', 1, 1);
INSERT INTO `berita` VALUES (4, 'welcom', '2009-02-22', '<p>Selamat Datang di situs Pembelian Online kami Asetech.com. Situs kami menyediakan berbagai alat/media peraga bagi laboratorium Anda.</p>\r\n<p><strong>Toko Online Kami Siap Melayani Anda.<br /></strong></p>', 1, 2);
INSERT INTO `berita` VALUES (6, 'Home', '2009-04-08', '<p><strong><em><span style="font-family: trebuchet ms,geneva;"><span style="color: #3366ff;">Ready to give better services for you<br /></span></span></em></strong></p>', 1, 4);

-- --------------------------------------------------------

-- 
-- Table structure for table `cart`
-- 

CREATE TABLE `cart` (
  `idCart` int(11) NOT NULL auto_increment,
  `idProduk` int(11) NOT NULL,
  `ct_token` text NOT NULL,
  `qty` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  PRIMARY KEY  (`idCart`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=107 ;

-- 
-- Dumping data for table `cart`
-- 

INSERT INTO `cart` VALUES (16, 22, '24Q47TyD4QgtY', 1, '2009-04-27');
INSERT INTO `cart` VALUES (15, 46, '24Q47TyD4QgtY', 1, '2009-04-27');
INSERT INTO `cart` VALUES (20, 46, '973o3DfXyM7uE', 1, '2009-05-03');
INSERT INTO `cart` VALUES (19, 40, '973o3DfXyM7uE', 1, '2009-05-03');
INSERT INTO `cart` VALUES (21, 17, '973o3DfXyM7uE', 1, '2009-05-03');
INSERT INTO `cart` VALUES (22, 28, '403EU3e6RD7QQ', 1, '2009-05-07');
INSERT INTO `cart` VALUES (24, 3, '42jl9AB3qTdkY', 1, '2009-05-08');
INSERT INTO `cart` VALUES (25, 46, '42jl9AB3qTdkY', 1, '2009-05-08');
INSERT INTO `cart` VALUES (41, 82, '0cWwLf0EUhlYQ', 1, '2009-07-05');
INSERT INTO `cart` VALUES (40, 61, '0cWwLf0EUhlYQ', 1, '2009-07-05');
INSERT INTO `cart` VALUES (34, 34, 'fctQLlTNPuZ06', 1, '2009-07-02');
INSERT INTO `cart` VALUES (33, 19, 'fctQLlTNPuZ06', 1, '2009-07-02');
INSERT INTO `cart` VALUES (49, 103, '12tr/y3fm7V4Q', 1, '2009-07-06');
INSERT INTO `cart` VALUES (48, 63, '12tr/y3fm7V4Q', 1, '2009-07-06');
INSERT INTO `cart` VALUES (45, 75, 'baH5FycA66fgw', 1, '2009-07-05');
INSERT INTO `cart` VALUES (50, 54, 'ed.PyzNAYys8c', 1, '2009-07-06');
INSERT INTO `cart` VALUES (55, 103, '57oZNuXexAtUU', 1, '2009-07-15');
INSERT INTO `cart` VALUES (60, 75, 'be/FTU6WVoxM.', 1, '2009-08-07');
INSERT INTO `cart` VALUES (91, 92, '2cCIOfMEgpG3g', 1, '2009-08-27');
INSERT INTO `cart` VALUES (89, 70, 'b0aO4QlgT3cj6', 1, '2009-08-23');

-- --------------------------------------------------------

-- 
-- Table structure for table `detpemesanan`
-- 

CREATE TABLE `detpemesanan` (
  `idDetPemesanan` int(11) NOT NULL auto_increment,
  `noFaktur` varchar(100) NOT NULL,
  `idProduk` int(11) NOT NULL,
  `jumlah` bigint(20) NOT NULL,
  `totalBayar` bigint(20) NOT NULL,
  PRIMARY KEY  (`idDetPemesanan`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=61 ;

-- 
-- Dumping data for table `detpemesanan`
-- 

INSERT INTO `detpemesanan` VALUES (1, '075649831', 19, 1, 600);
INSERT INTO `detpemesanan` VALUES (2, '075649831', 41, 1, 2500);
INSERT INTO `detpemesanan` VALUES (3, '724891036', 42, 1, 90000);
INSERT INTO `detpemesanan` VALUES (4, '724891036', 51, 1, 89000);
INSERT INTO `detpemesanan` VALUES (58, '460281935', 70, 1, 3500000);
INSERT INTO `detpemesanan` VALUES (57, '064723589', 70, 1, 3500000);
INSERT INTO `detpemesanan` VALUES (56, '796835140', 86, 1, 120000);
INSERT INTO `detpemesanan` VALUES (55, '612578430', 88, 1, 300000);
INSERT INTO `detpemesanan` VALUES (9, '578491623', 47, 1, 12000);
INSERT INTO `detpemesanan` VALUES (10, '342108596', 18, 1, 0);
INSERT INTO `detpemesanan` VALUES (11, '150638429', 47, 1, 12000);
INSERT INTO `detpemesanan` VALUES (12, '150638429', 33, 1, 120000);
INSERT INTO `detpemesanan` VALUES (13, '275801369', 17, 1, 120000);
INSERT INTO `detpemesanan` VALUES (14, '819075236', 61, 2, 8000000);
INSERT INTO `detpemesanan` VALUES (15, '819075236', 72, 1, 200000);
INSERT INTO `detpemesanan` VALUES (16, '249617850', 80, 1, 150000);
INSERT INTO `detpemesanan` VALUES (17, '249617850', 92, 1, 400000);
INSERT INTO `detpemesanan` VALUES (18, '249617850', 87, 1, 500000);
INSERT INTO `detpemesanan` VALUES (19, '342601598', 99, 1, 750000);
INSERT INTO `detpemesanan` VALUES (54, '612578430', 70, 1, 3500000);
INSERT INTO `detpemesanan` VALUES (53, '963470251', 79, 1, 150000);
INSERT INTO `detpemesanan` VALUES (22, '567428309', 88, 1, 300000);
INSERT INTO `detpemesanan` VALUES (23, '567428309', 66, 1, 5000000);
INSERT INTO `detpemesanan` VALUES (24, '837256049', 87, 1, 500000);
INSERT INTO `detpemesanan` VALUES (25, '038921456', 76, 1, 1000000);
INSERT INTO `detpemesanan` VALUES (26, '610247935', 75, 2, 200000);
INSERT INTO `detpemesanan` VALUES (27, '063529741', 81, 1, 200000);
INSERT INTO `detpemesanan` VALUES (28, '063529741', 62, 1, 1000000);
INSERT INTO `detpemesanan` VALUES (29, '063529741', 85, 1, 100000);
INSERT INTO `detpemesanan` VALUES (30, '415269830', 92, 3, 1200000);
INSERT INTO `detpemesanan` VALUES (31, '415269830', 70, 1, 3500000);
INSERT INTO `detpemesanan` VALUES (32, '426798305', 76, 1, 1000000);
INSERT INTO `detpemesanan` VALUES (33, '402865391', 76, 5, 5000000);
INSERT INTO `detpemesanan` VALUES (38, '687150293', 88, 1, 300000);
INSERT INTO `detpemesanan` VALUES (37, '687150293', 70, 1, 3500000);
INSERT INTO `detpemesanan` VALUES (36, '936087415', 72, 2, 400000);
INSERT INTO `detpemesanan` VALUES (39, '735906124', 75, 1, 100000);
INSERT INTO `detpemesanan` VALUES (40, '051946372', 87, 1, 500000);
INSERT INTO `detpemesanan` VALUES (41, '240791365', 61, 1, 4000000);
INSERT INTO `detpemesanan` VALUES (42, '240791365', 75, 1, 100000);
INSERT INTO `detpemesanan` VALUES (43, '639051874', 87, 1, 500000);
INSERT INTO `detpemesanan` VALUES (59, '385196724', 61, 1, 4000000);
INSERT INTO `detpemesanan` VALUES (45, '253640178', 74, 17, 17000000);
INSERT INTO `detpemesanan` VALUES (46, '758394261', 65, 1, 500000);
INSERT INTO `detpemesanan` VALUES (47, '601324587', 65, 1, 500000);
INSERT INTO `detpemesanan` VALUES (60, '547302168', 74, 1, 1000000);
INSERT INTO `detpemesanan` VALUES (49, '190876532', 88, 1, 300000);
INSERT INTO `detpemesanan` VALUES (50, '190876532', 70, 1, 3500000);
INSERT INTO `detpemesanan` VALUES (51, '605179438', 70, 1, 3500000);
INSERT INTO `detpemesanan` VALUES (52, '192543867', 87, 1, 500000);

-- --------------------------------------------------------

-- 
-- Table structure for table `hak`
-- 

CREATE TABLE `hak` (
  `idHak` int(11) NOT NULL auto_increment,
  `namaHak` text NOT NULL,
  PRIMARY KEY  (`idHak`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `hak`
-- 

INSERT INTO `hak` VALUES (1, 'admin');
INSERT INTO `hak` VALUES (2, 'pelanggan');

-- --------------------------------------------------------

-- 
-- Table structure for table `kategori`
-- 

CREATE TABLE `kategori` (
  `idKategori` int(11) NOT NULL auto_increment,
  `namaKategori` text NOT NULL,
  PRIMARY KEY  (`idKategori`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- 
-- Dumping data for table `kategori`
-- 

INSERT INTO `kategori` VALUES (13, 'Alat Peraga SD');
INSERT INTO `kategori` VALUES (14, 'Alat Peraga SMP');
INSERT INTO `kategori` VALUES (15, 'Alat Peraga SMA');
INSERT INTO `kategori` VALUES (16, 'Alat Peraga SMK');

-- --------------------------------------------------------

-- 
-- Table structure for table `kategoriberita`
-- 

CREATE TABLE `kategoriberita` (
  `idKategoriBerita` int(2) NOT NULL auto_increment,
  `namaKategoriBerita` text NOT NULL,
  PRIMARY KEY  (`idKategoriBerita`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `kategoriberita`
-- 

INSERT INTO `kategoriberita` VALUES (1, 'headline');
INSERT INTO `kategoriberita` VALUES (2, 'rolling');
INSERT INTO `kategoriberita` VALUES (3, 'news');
INSERT INTO `kategoriberita` VALUES (4, 'home');

-- --------------------------------------------------------

-- 
-- Table structure for table `konfirmasi`
-- 

CREATE TABLE `konfirmasi` (
  `idKonfirmasi` int(11) NOT NULL auto_increment,
  `noFaktur` text NOT NULL,
  `idBank` int(11) NOT NULL,
  `noRekening` text NOT NULL,
  `namaRekening` text NOT NULL,
  `jumlahBayar` bigint(20) NOT NULL,
  `pesan` text NOT NULL,
  `mark` text NOT NULL,
  PRIMARY KEY  (`idKonfirmasi`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

-- 
-- Dumping data for table `konfirmasi`
-- 

INSERT INTO `konfirmasi` VALUES (1, '075649831', 1, '0987654321', 'mian', 12444444, 'ok', 'read');
INSERT INTO `konfirmasi` VALUES (2, ' 	420159837', 3, '2222', 'mian', 23333, '', 'unread');
INSERT INTO `konfirmasi` VALUES (3, '420159837', 3, '77777', 'fahmi', 511443, 'ok', 'read');
INSERT INTO `konfirmasi` VALUES (4, '837256049', 1, '909087666', 'mian', 550938, 'cepet', 'read');
INSERT INTO `konfirmasi` VALUES (5, ' 	687150293', 3, '999', 'mian', 3850781, 'okkkk', 'unread');
INSERT INTO `konfirmasi` VALUES (6, '735906124', 1, '2222222', 'masmian', 9999, 'sip', 'read');
INSERT INTO `konfirmasi` VALUES (7, '837256049', 1, '909087666', 'mian', 22, 'ss', 'read');
INSERT INTO `konfirmasi` VALUES (8, '051946372', 3, '909087666', 'mian', 555, 'sip', 'read');
INSERT INTO `konfirmasi` VALUES (9, '051946372', 3, '77777', 'h', 5, 'r', 'read');
INSERT INTO `konfirmasi` VALUES (10, '240791365', 1, '43564', 'fdg', 546, 'fgfd', 'read');
INSERT INTO `konfirmasi` VALUES (11, '657098423', 3, '44', 'gh', 305142, 'fg', 'read');
INSERT INTO `konfirmasi` VALUES (12, '190876532', 3, '788888888', 'masmian', 3085482, 'capet mas', 'read');
INSERT INTO `konfirmasi` VALUES (13, '605179438', 3, '333333333', 'budi', 3505832, 'fix', 'read');
INSERT INTO `konfirmasi` VALUES (14, '963470251', 3, '444', 'budi', 4400000, 'sip', 'read');
INSERT INTO `konfirmasi` VALUES (15, '612578430', 1, '333333333', 'riadi', 3850190, 'cepat dikirim', 'read');
INSERT INTO `konfirmasi` VALUES (16, '796835140', 2, '333333333', 'riadi', 344444, 'ok', 'read');
INSERT INTO `konfirmasi` VALUES (17, '666', 2, '6666', 'fdddd', 5555, '', 'unread');
INSERT INTO `konfirmasi` VALUES (18, '666', 2, '6666', '6', 4, 'r', 'unread');
INSERT INTO `konfirmasi` VALUES (19, '657098423', 2, '6666', 'gt', 677, '', 'unread');
INSERT INTO `konfirmasi` VALUES (20, '064723589', 2, '4577777994', 'kartono', 3550385, 'barang kami tunggu', 'read');
INSERT INTO `konfirmasi` VALUES (21, '460281935', 1, '5666666666', 'Bu Fitri', 3550976, 'segera ', 'read');

-- --------------------------------------------------------

-- 
-- Table structure for table `network`
-- 

CREATE TABLE `network` (
  `idNetwork` int(2) NOT NULL auto_increment,
  `namaNetwork` text NOT NULL,
  `idStatusShow` int(2) NOT NULL,
  `keteranganNetwork` text NOT NULL,
  `linkNetwork` text NOT NULL,
  PRIMARY KEY  (`idNetwork`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- 
-- Dumping data for table `network`
-- 

INSERT INTO `network` VALUES (8, 'RafaMedicalCenter.com', 1, 'Menjual alat-alat Kesehatan dan Laboratorium', 'http://www.rafamedicalcenter.com/');
INSERT INTO `network` VALUES (9, 'K-EGP.com', 1, 'Konsorsium Edukasi Gerbang Pembelajaran, Pusat Penjualan alat-alat Pendidikan dan Laboratorium, Program DAK 8 SSN ? SBI ? SD ? SLTP ? SMU ? SMK', 'http://www.k-egp.com/');
INSERT INTO `network` VALUES (11, 'Astaperaga.Com', 1, 'Asta', 'http://www.astaperaga.com/');

-- --------------------------------------------------------

-- 
-- Table structure for table `owner`
-- 

CREATE TABLE `owner` (
  `idOwner` int(2) NOT NULL auto_increment,
  `namaOwner` text NOT NULL,
  `emailOwner` text NOT NULL,
  `contactOwner` text NOT NULL,
  `idStatusShow` int(2) NOT NULL,
  PRIMARY KEY  (`idOwner`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `owner`
-- 

INSERT INTO `owner` VALUES (1, 'Masmian', 'mian@yahoo.com', '085691969575', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `pelanggan`
-- 

CREATE TABLE `pelanggan` (
  `idPelanggan` int(11) NOT NULL auto_increment,
  `namaPelanggan` text NOT NULL,
  `alamatPelanggan` text NOT NULL,
  `kota` text NOT NULL,
  `propinsi` text NOT NULL,
  `kodePos` text NOT NULL,
  `email` text NOT NULL,
  `phone` text NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY  (`idPelanggan`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- 
-- Dumping data for table `pelanggan`
-- 

INSERT INTO `pelanggan` VALUES (1, 'Masmian', 'PATI', 'Semarang', 'Jawa Tengah', '12333', 'mian_mas@yahoo.com', '098888888', 32);
INSERT INTO `pelanggan` VALUES (2, 'bagus', 'ciputat', 'tangerang', 'banten', '15419', 'mians_mas@yahoo.com', '09988888', 33);
INSERT INTO `pelanggan` VALUES (3, 'hedgehog', 'singapore', 'ciangmai', 'may', '2111', 'mian007mhd@yahoo.com', '026777777777', 34);
INSERT INTO `pelanggan` VALUES (4, 'arif', 'jl.pesanggrahan 28', 'ciputat', 'banten', '3333', 'arif@yahoo.com', '3333', 35);
INSERT INTO `pelanggan` VALUES (5, 'bagus', 'kajen', 'pati', 'jateng', '444', 'hhhh@yahoo.com', '4444', 36);
INSERT INTO `pelanggan` VALUES (6, 'Riadi', 'Jl. makmur, no.7 Tagerang', 'tangerang', 'banten', '55555', 'riadi@yahoo.com', '65444445', 37);
INSERT INTO `pelanggan` VALUES (7, 'kartono', 'jl.ir.Juanda No.12 Ciputat', 'tangerang', 'banten', '15122', 'kartono@yahoo.com', '9567788', 38);
INSERT INTO `pelanggan` VALUES (8, 'Bu Fitri', 'Jl. Nangka No.1 Depok', 'depok', 'Jawa Barat', 'abcd', 'fitri@yahoo.com', '085666666', 39);

-- --------------------------------------------------------

-- 
-- Table structure for table `pemesanan`
-- 

CREATE TABLE `pemesanan` (
  `noFaktur` varchar(100) NOT NULL,
  `idPelanggan` int(11) NOT NULL,
  `tgl` date NOT NULL,
  `ongkosKirim` bigint(20) NOT NULL,
  `idPengiriman` int(11) NOT NULL,
  `idStatusPesan` int(11) NOT NULL,
  `alamatLain` text NOT NULL,
  `idBank` int(11) NOT NULL,
  `jmlhBayar` bigint(20) NOT NULL,
  PRIMARY KEY  (`noFaktur`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `pemesanan`
-- 

INSERT INTO `pemesanan` VALUES ('075649831', 1, '2009-04-20', 20000, 1, 4, '', 1, 23379);
INSERT INTO `pemesanan` VALUES ('724891036', 2, '2009-04-22', 125000, 1, 4, '', 1, 304351);
INSERT INTO `pemesanan` VALUES ('612578430', 6, '2009-10-16', 50000, 1, 4, '', 1, 3850190);
INSERT INTO `pemesanan` VALUES ('578491623', 1, '2009-05-09', 67888, 1, 4, '', 2, 79950);
INSERT INTO `pemesanan` VALUES ('342108596', 1, '2009-07-02', 0, 1, 1, '', 3, 0);
INSERT INTO `pemesanan` VALUES ('150638429', 4, '2009-07-02', 25000, 1, 4, '', 3, 157245);
INSERT INTO `pemesanan` VALUES ('275801369', 4, '2009-07-02', 20000, 1, 4, '', 2, 140403);
INSERT INTO `pemesanan` VALUES ('819075236', 1, '2009-07-04', 20000, 1, 4, '', 3, 8220250);
INSERT INTO `pemesanan` VALUES ('249617850', 1, '2009-07-05', 50000, 1, 4, '', 3, 1100632);
INSERT INTO `pemesanan` VALUES ('342601598', 1, '2009-07-05', 50000, 1, 4, '', 3, 800756);
INSERT INTO `pemesanan` VALUES ('963470251', 1, '2009-09-07', 5000, 1, 4, '', 3, 155109);
INSERT INTO `pemesanan` VALUES ('567428309', 1, '2009-07-17', 10000, 1, 4, '', 3, 5310739);
INSERT INTO `pemesanan` VALUES ('837256049', 1, '2009-08-19', 50000, 2, 4, 'jl. surabaya', 1, 550938);
INSERT INTO `pemesanan` VALUES ('038921456', 1, '2009-08-19', 0, 1, 1, '', 3, 0);
INSERT INTO `pemesanan` VALUES ('610247935', 1, '2009-08-19', 0, 1, 1, '', 3, 0);
INSERT INTO `pemesanan` VALUES ('063529741', 1, '2009-08-19', 0, 1, 1, '', 3, 0);
INSERT INTO `pemesanan` VALUES ('415269830', 1, '2009-08-19', 20000, 1, 4, '', 3, 4720159);
INSERT INTO `pemesanan` VALUES ('426798305', 1, '2009-08-19', 50000, 1, 2, '', 3, 1050173);
INSERT INTO `pemesanan` VALUES ('402865391', 1, '2009-08-19', 0, 1, 1, '', 3, 0);
INSERT INTO `pemesanan` VALUES ('687150293', 1, '2009-08-21', 50000, 1, 4, '', 3, 3850781);
INSERT INTO `pemesanan` VALUES ('936087415', 1, '2009-08-19', 0, 1, 1, '', 3, 0);
INSERT INTO `pemesanan` VALUES ('735906124', 1, '2009-08-21', 50000, 1, 2, '', 1, 150861);
INSERT INTO `pemesanan` VALUES ('051946372', 1, '2009-08-21', 50000, 1, 2, '', 3, 550643);
INSERT INTO `pemesanan` VALUES ('240791365', 1, '2009-08-21', 50000, 1, 3, '', 3, 4150645);
INSERT INTO `pemesanan` VALUES ('639051874', 1, '2009-08-21', 0, 1, 1, '', 3, 0);
INSERT INTO `pemesanan` VALUES ('796835140', 6, '2009-10-18', 5000, 1, 4, '', 2, 125879);
INSERT INTO `pemesanan` VALUES ('253640178', 1, '2009-08-23', 50000, 1, 2, '', 3, 17050204);
INSERT INTO `pemesanan` VALUES ('758394261', 1, '2009-08-23', 50000, 1, 3, '', 3, 550734);
INSERT INTO `pemesanan` VALUES ('601324587', 1, '2009-08-23', 50000, 1, 3, '', 3, 550806);
INSERT INTO `pemesanan` VALUES ('064723589', 7, '2009-11-14', 50000, 1, 4, '', 2, 3550385);
INSERT INTO `pemesanan` VALUES ('190876532', 1, '2009-08-28', 5000, 1, 3, '', 3, 3805486);
INSERT INTO `pemesanan` VALUES ('605179438', 1, '2009-09-02', 5000, 1, 4, '', 3, 3505832);
INSERT INTO `pemesanan` VALUES ('192543867', 1, '2009-09-02', 0, 1, 1, '', 3, 0);
INSERT INTO `pemesanan` VALUES ('460281935', 8, '2009-12-01', 50000, 1, 4, '', 1, 3550976);
INSERT INTO `pemesanan` VALUES ('385196724', 1, '2009-12-16', 0, 1, 1, '', 2, 0);
INSERT INTO `pemesanan` VALUES ('547302168', 1, '2009-12-16', 0, 1, 1, '', 2, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `pertanyaan`
-- 

CREATE TABLE `pertanyaan` (
  `idPertanyaan` int(11) NOT NULL auto_increment,
  `namaPertanyaan` text NOT NULL,
  PRIMARY KEY  (`idPertanyaan`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `pertanyaan`
-- 

INSERT INTO `pertanyaan` VALUES (1, 'Siapa nama Ibu Anda?');
INSERT INTO `pertanyaan` VALUES (2, 'Apa hewan kesukaan Anda?');
INSERT INTO `pertanyaan` VALUES (3, 'Apa hoby Anda?');
INSERT INTO `pertanyaan` VALUES (4, 'Apa yang Anda paling suka?');

-- --------------------------------------------------------

-- 
-- Table structure for table `perusahaan`
-- 

CREATE TABLE `perusahaan` (
  `idPerusahaan` int(11) NOT NULL auto_increment,
  `namaPerusahaan` text NOT NULL,
  `alamatPerusahaan` text NOT NULL,
  `contactPerusahaan` text NOT NULL,
  `emailPerusahaan` text NOT NULL,
  PRIMARY KEY  (`idPerusahaan`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `perusahaan`
-- 

INSERT INTO `perusahaan` VALUES (1, 'CV. MITRA ASTA PERAGA', '<p>Serpong Town Square Jl. Moh. Tamrin KM-7, Lt. UG Kanto-01, Serpong Tanggerang</p>', '021-91584011 ', 'astaperaga@yahoo.com');

-- --------------------------------------------------------

-- 
-- Table structure for table `posisi`
-- 

CREATE TABLE `posisi` (
  `idPosisi` int(11) NOT NULL auto_increment,
  `namaPosisi` text collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`idPosisi`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `posisi`
-- 

INSERT INTO `posisi` VALUES (1, 'Tentang Kami');
INSERT INTO `posisi` VALUES (2, 'Portofolio');

-- --------------------------------------------------------

-- 
-- Table structure for table `produk`
-- 

CREATE TABLE `produk` (
  `idProduk` int(11) NOT NULL auto_increment,
  `namaProduk` text NOT NULL,
  `hargaProduk` bigint(20) NOT NULL,
  `idKategori` int(11) NOT NULL,
  `stockProduk` int(11) NOT NULL,
  `pathImage` text NOT NULL,
  `idStatusProduk` int(11) NOT NULL,
  `konten` text NOT NULL,
  `idProdusen` int(11) NOT NULL,
  PRIMARY KEY  (`idProduk`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=104 ;

-- 
-- Dumping data for table `produk`
-- 

INSERT INTO `produk` VALUES (61, 'Car Petrol Engines', 4000000, 16, 5, 'etrol.jpg', 3, 'ready', 1);
INSERT INTO `produk` VALUES (62, 'Wind Tunnels', 1000000, 16, 3, 'tunel.jpg', 2, 'ready', 1);
INSERT INTO `produk` VALUES (63, 'Data Logger', 5000000, 16, 5, 'loger.jpeg', 2, 'ready', 1);
INSERT INTO `produk` VALUES (64, 'Nano Measurement', 1500000, 16, 5, 'nano.jpg', 2, 'ready', 1);
INSERT INTO `produk` VALUES (65, 'UTM Machine', 500000, 16, 5, 'utm.jpg', 2, 'ready', 1);
INSERT INTO `produk` VALUES (66, 'Tachometer Analog', 5000000, 16, 3, 'dewe.jpg', 2, 'ready', 1);
INSERT INTO `produk` VALUES (67, 'Motorcycle Electrical System', 2000000, 16, 5, 'mes.jpg', 4, 'ready', 1);
INSERT INTO `produk` VALUES (68, 'Diesel Engine Training', 6000000, 16, 6, 'diesel.jpg', 1, 'ready', 1);
INSERT INTO `produk` VALUES (69, 'Kerangka Badan', 600000, 13, 10, 'kerangka-badan.jpg', 4, 'ready', 1);
INSERT INTO `produk` VALUES (70, 'Mikroskop', 3500000, 13, 7, 'microscope.jpg', 3, 'ready', 1);
INSERT INTO `produk` VALUES (71, 'Mata Manusia', 200000, 13, 12, 'mata.jpg', 2, 'ready', 1);
INSERT INTO `produk` VALUES (72, 'Telingga Manusia', 200000, 13, 0, 'telingga.jpg', 2, 'kosong', 1);
INSERT INTO `produk` VALUES (73, 'Penampang Kulit Manusia', 300000, 13, 12, 'kulit.jpg', 1, 'ready', 1);
INSERT INTO `produk` VALUES (74, 'Mikroslide', 1000000, 13, 5, 'tulang.jpg', 2, 'ready', 1);
INSERT INTO `produk` VALUES (75, 'Higrometer', 100000, 13, 9, 'higrometer.jpg', 3, 'ready', 1);
INSERT INTO `produk` VALUES (76, 'Kerangka Tulang', 1000000, 13, 10, 'kerangka.jpg', 1, 'ready', 1);
INSERT INTO `produk` VALUES (77, 'Perangkat Pembersih Mikroskop', 100000, 13, 12, 'pembersih-mikroskop.jpg', 1, 'ready', 1);
INSERT INTO `produk` VALUES (78, 'Atlas', 100000, 14, 5, 'atlas.jpg', 1, 'ready', 1);
INSERT INTO `produk` VALUES (79, 'Audio Kit', 150000, 14, 5, 'audio.jpg', 2, 'ready', 1);
INSERT INTO `produk` VALUES (80, 'Balance Kit', 150000, 14, 4, 'balance-kit.jpg', 2, 'ready', 1);
INSERT INTO `produk` VALUES (81, 'Fisika Elektro Kit', 200000, 14, 4, 'fisika-elektro-kit.jpg', 2, 'ready', 1);
INSERT INTO `produk` VALUES (82, 'Heat Kit', 80000, 14, 4, 'heat-kit.jpg', 2, 'ready', 1);
INSERT INTO `produk` VALUES (83, 'Light Kit', 150000, 14, 4, 'light-kit.jpg', 2, 'ready', 1);
INSERT INTO `produk` VALUES (84, 'Carta Kimia', 50000, 15, 6, 'carta-kimia.jpg', 2, 'ready', 1);
INSERT INTO `produk` VALUES (85, 'Coal Oil Kit', 100000, 15, 6, 'coal-oil-kit.jpg', 2, 'ready', 1);
INSERT INTO `produk` VALUES (86, 'Destilasi Kit', 120000, 15, 2, 'Destilasi-kit.jpg', 3, 'ready', 1);
INSERT INTO `produk` VALUES (87, 'Elektro dan Magnetik Kit', 500000, 15, 5, 'electricity&mag.kit.jpg', 3, 'ready', 1);
INSERT INTO `produk` VALUES (88, 'Kimia Kit', 300000, 15, 10, 'kimia-kit.jpg', 3, 'ready', 1);
INSERT INTO `produk` VALUES (89, 'Kimia Anorganik Kit', 300000, 15, 6, 'kimia-anorganik-kit.jpg', 1, 'ready', 1);
INSERT INTO `produk` VALUES (90, 'Kimia Organik Kit', 300000, 15, 5, 'kimia-organik-kit.jpg', 1, 'ready', 1);
INSERT INTO `produk` VALUES (91, 'Mekanik Kit', 600000, 15, 6, 'mechanics-kit.jpg', 1, 'ready', 1);
INSERT INTO `produk` VALUES (92, 'Mineral Kit', 400000, 15, 10, 'mineral-kit.jpg', 3, 'ready', 1);
INSERT INTO `produk` VALUES (93, 'Matematika Kit', 500000, 15, 12, 'mtk-kit.jpg', 2, 'ready', 1);
INSERT INTO `produk` VALUES (94, 'Optik Kit', 700000, 15, 4, 'optik-kit.jpg', 2, 'ready', 1);
INSERT INTO `produk` VALUES (95, 'Magnet Kit', 450000, 14, 7, 'magnet-kit.jpg', 1, 'ready', 1);
INSERT INTO `produk` VALUES (96, 'Mekanik Kit', 350000, 14, 4, 'mekanik-kit.jpg', 1, 'ready', 1);
INSERT INTO `produk` VALUES (97, 'Mikroskop Lanjutan', 1500000, 14, 4, 'mikroskop.jpg', 1, 'ready', 1);
INSERT INTO `produk` VALUES (98, 'Mineral Kit', 300000, 14, 3, 'mineral-kit.jpg', 1, 'ready', 1);
INSERT INTO `produk` VALUES (99, 'Optik Kit', 750000, 14, 12, 'optika-kit.jpg', 2, 'ready', 1);
INSERT INTO `produk` VALUES (100, 'Sound Kit', 250000, 14, 4, 'sound-kit.jpg', 1, 'ready', 1);
INSERT INTO `produk` VALUES (101, 'Water Filter Apparatus', 150000, 14, 4, 'water-filter-apparatus.jpg', 1, 'ready', 1);
INSERT INTO `produk` VALUES (102, 'Water Kit', 150000, 14, 3, 'water-kit.jpg', 1, 'ready', 1);
INSERT INTO `produk` VALUES (103, 'Mikroskop Lanjutan 2', 1600000, 15, 3, 'mikroskop.jpg', 2, 'ready', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `produsen`
-- 

CREATE TABLE `produsen` (
  `idProdusen` int(11) NOT NULL auto_increment,
  `namaProdusen` text collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`idProdusen`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `produsen`
-- 

INSERT INTO `produsen` VALUES (1, 'AstaTech');

-- --------------------------------------------------------

-- 
-- Table structure for table `statuspemesanan`
-- 

CREATE TABLE `statuspemesanan` (
  `idStatusPesan` int(11) NOT NULL auto_increment,
  `namaStatusKirim` text NOT NULL,
  PRIMARY KEY  (`idStatusPesan`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `statuspemesanan`
-- 

INSERT INTO `statuspemesanan` VALUES (1, 'pending');
INSERT INTO `statuspemesanan` VALUES (2, 'new');
INSERT INTO `statuspemesanan` VALUES (3, 'paid');
INSERT INTO `statuspemesanan` VALUES (4, 'shipped');

-- --------------------------------------------------------

-- 
-- Table structure for table `statusproduk`
-- 

CREATE TABLE `statusproduk` (
  `idStatusProduk` int(11) NOT NULL auto_increment,
  `namaStatus` text NOT NULL,
  PRIMARY KEY  (`idStatusProduk`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `statusproduk`
-- 

INSERT INTO `statusproduk` VALUES (1, 'umum');
INSERT INTO `statusproduk` VALUES (2, 'baru');
INSERT INTO `statusproduk` VALUES (3, 'unggulan');
INSERT INTO `statusproduk` VALUES (4, 'best seller');

-- --------------------------------------------------------

-- 
-- Table structure for table `statusshow`
-- 

CREATE TABLE `statusshow` (
  `idStatusShow` int(2) NOT NULL auto_increment,
  `namaStatusShow` text NOT NULL,
  PRIMARY KEY  (`idStatusShow`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `statusshow`
-- 

INSERT INTO `statusshow` VALUES (1, 'Ya');
INSERT INTO `statusshow` VALUES (2, 'Tidak');

-- --------------------------------------------------------

-- 
-- Table structure for table `tema`
-- 

CREATE TABLE `tema` (
  `idTema` int(11) NOT NULL auto_increment,
  `bodyTema` text collate latin1_general_ci NOT NULL,
  `backTema` text collate latin1_general_ci NOT NULL,
  `tripTema` text collate latin1_general_ci NOT NULL,
  `tripTextTema` text collate latin1_general_ci NOT NULL,
  `banerTema` text collate latin1_general_ci NOT NULL,
  `banerTripTema` text collate latin1_general_ci NOT NULL,
  `title` text collate latin1_general_ci NOT NULL,
  `rincian` text collate latin1_general_ci NOT NULL,
  `domain` text collate latin1_general_ci NOT NULL,
  `online` varchar(1) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`idTema`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `tema`
-- 

INSERT INTO `tema` VALUES (1, '326bfa', 'b6d742', '018f39', 'ffffff', 'tema_06.gif', 'tema_03.gif', 'Anugerah Semesta Teknologi', 'Menjual Alat-alat Kesehatand', 'ASTAPERAGA.COM', '1');

-- --------------------------------------------------------

-- 
-- Table structure for table `tentangkami`
-- 

CREATE TABLE `tentangkami` (
  `idTentang` int(11) NOT NULL auto_increment,
  `judulKonten` text collate latin1_general_ci NOT NULL,
  `deskripsiKonten` text collate latin1_general_ci NOT NULL,
  `idPosisi` int(11) NOT NULL,
  PRIMARY KEY  (`idTentang`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=8 ;

-- 
-- Dumping data for table `tentangkami`
-- 

INSERT INTO `tentangkami` VALUES (1, 'Selayang Pandang', '<p><span style="font-family: tahoma,arial,helvetica,sans-serif;"><span style="font-size: small;">Di dalam Era Pembangunan Nasional, Pendidikan sangat diperlukan untuk mewujudkan kesejahteraan bangsa. Pendidikan adalah sarana penting dalam pembangunan untuk menciptakan masyarakat yang mempunyai potensi dan kualitas demi kemajuan bangsa.<br /><br /><strong>Mitra Asta Peraga</strong> didirikan dalam rangka ikut berpartisipasi dan membantu program pemerintah dalam terselenggaranya pendidikan yang berkualitas melalui penyediaan sistem dan peralatan pendidikan dengan visi dan misi Sistem Pendidikan Nasional. Sistem dan peralatan yang kami hadirkan terdiri dari alat-alat peraga yang terintegrasi dalam konsep laboratorium sekolah, serta menggunakan teknologi terbaru dengan engine produksi tahun 2000.<br /><br />Dalam penyediaan dan distribusi buku bahan ajar, alat-alat peraga, Trainer Kejuruan dan Laboratorium, <strong>Mitra Asta Peraga</strong> di tunjuk oleh PT. Aneka Ilmu Semarang, PT. Bamboo Media Bali, PT. Panca Anugerah Sakti Jakarta, PT. Metro Data E-Bisnis Jakarta, PT. Balai Pustaka Peraga Jakarta, PT Labtech Penta Internasional Sekupang Batam, PT Winner Tech Malang sebagai agen tunggal untuk mendistribusikan buku bahan ajar, alat-alat Peraga Pendidikan, Alat Trainer Kejuruan, Lab bahasa dan Lab. Multimedia serta peralatan Laboratorium Praktikum. Untuk mengembangkan sayap perusahaan dan untuk menambah melengkapi distribusi alat-alat kesehatan dan laboratorium PT. Tech Comm Hongkong serta Bergof Germany, <strong>Mitra Asta Peraga</strong> juga menjalin kerjasama dan bermitra dengan perusahaan&ndash;perusahaan penyedia (importir) yang menjadi principle manufaktur / keagenan alat-alat peraga dan laboratorium.<br /><br />Dalam kegiatan usaha, kami berupaya sekeras mungkin menangani secara profesional pengadaan alat-alat peraga pendidikan sebagai sarana penunjang pendidikan yang dapat diterapkan di semua jenjang pendidikan, mulai SD, SMP, SMA, dan juga SMK. Dengan dukungan tenaga marketing yang handal, serta inovasi dan pengembangan teknologi yang tiada henti, kami berharap semoga dunia pendidikan bangsa semakin maju dan berkembang.</span></span></p>', 1);
INSERT INTO `tentangkami` VALUES (2, 'Legalitas', '<table style="width: 498px; height: 328px;" border="0" align="left">\r\n<tbody>\r\n<tr>\r\n<td style="width: 140px;" valign="top">Nama Perusahaan</td>\r\n<td>:</td>\r\n<td><strong>CV. MITRA ASTA PERAGA</strong></td>\r\n</tr>\r\n<tr>\r\n<td valign="top">Bidang Usaha</td>\r\n<td valign="top">:</td>\r\n<td valign="top">Pengadaan Buku Bahan ajar, Laboratorium Bahasa/Multi Media Alat Peraga Pendidikan dan Laboratorium Pendidikan, Perdagangan Umum.</td>\r\n</tr>\r\n<tr>\r\n<td>Nama Direktur</td>\r\n<td>:</td>\r\n<td>A. Raful Hasbi, ST</td>\r\n</tr>\r\n<tr>\r\n<td>Alamat Perusahaan</td>\r\n<td>:</td>\r\n<td>Jl. Danau Maninjau No. 9 Kedaton B. Lampung</td>\r\n</tr>\r\n<tr>\r\n<td>Surabaya Office</td>\r\n<td>:</td>\r\n<td>Jl. Taman Klampis Anom Blok G-46, Surabaya</td>\r\n</tr>\r\n<tr>\r\n<td valign="top">Show Room</td>\r\n<td>:</td>\r\n<td>Serpong Town Square Jl. Moh. Tamrin KM-7 Serpong Tanggerang U.G. Kanto-01</td>\r\n</tr>\r\n<tr>\r\n<td>Telephon</td>\r\n<td>:</td>\r\n<td>021-91584011</td>\r\n</tr>\r\n<tr>\r\n<td>Fax</td>\r\n<td>:</td>\r\n<td>021-91584012</td>\r\n</tr>\r\n<tr>\r\n<td>E&ndash;Mail</td>\r\n<td>:</td>\r\n<td>info@astaperaga.com</td>\r\n</tr>\r\n<tr>\r\n<td>Akte Perusahaan</td>\r\n<td>:</td>\r\n<td>Akte Pendirian No. 46 Tanggal 23 Januari 2006</td>\r\n</tr>\r\n<tr>\r\n<td valign="top">NPWP<br /></td>\r\n<td valign="top">:<br /></td>\r\n<td valign="top">02.232.847.0-322.000<br /></td>\r\n</tr>\r\n<tr>\r\n<td valign="top">No. SITU / DOMISILI<br /></td>\r\n<td valign="top">:<br /></td>\r\n<td valign="top">1439/II/KDT/2005<br /></td>\r\n</tr>\r\n<tr>\r\n<td valign="top">Masa Berlaku Ijin Usaha</td>\r\n<td valign="top">:</td>\r\n<td valign="top">9 Juni 2010</td>\r\n</tr>\r\n<tr>\r\n<td valign="top">No. SIUP</td>\r\n<td valign="top">:</td>\r\n<td valign="top">518/510/PK/V/2005</td>\r\n</tr>\r\n<tr>\r\n<td valign="top">Masa Berlaku Ijin Usaha</td>\r\n<td valign="top">:</td>\r\n<td valign="top">30 Mei 2010</td>\r\n</tr>\r\n<tr>\r\n<td valign="top">No. TDP</td>\r\n<td valign="top">:</td>\r\n<td valign="top">070135204482</td>\r\n</tr>\r\n</tbody>\r\n</table>', 1);
INSERT INTO `tentangkami` VALUES (3, 'Tim Kerja', '<p><span style="color: #000000;"> \r\n<table border="0">\r\n<tbody>\r\n<tr>\r\n<td><strong><span style="font-size: small;">Senior Advisor </span></strong></td>\r\n<td><strong><span style="font-size: small;">: </span></strong></td>\r\n<td><strong><span style="font-size: small;">A. Roful Hasbi, ST</span></strong></td>\r\n</tr>\r\n<tr>\r\n<td><strong><span style="font-size: small;">Ketua Tim</span></strong></td>\r\n<td><strong><span style="font-size: small;">:</span></strong></td>\r\n<td><strong><span style="font-size: small;">Ifa Lux Arif, SE</span></strong></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</span></p>\r\n<p style="text-align: left;"><span style="color: #000000;"> \r\n<table border="0">\r\n<tbody>\r\n<tr>\r\n<td><span style="font-size: x-small;"><strong>A. </strong></span></td>\r\n<td><span style="font-size: x-small;"><strong>Div Software</strong></span></td>\r\n</tr>\r\n<tr>\r\n<td><span style="font-size: x-small;">1.</span></td>\r\n<td><span style="font-size: x-small;">Kordinator</span></td>\r\n</tr>\r\n<tr>\r\n<td valign="top"><span style="font-size: x-small;"><br /></span></td>\r\n<td valign="top"><span style="font-size: x-small;">- Nurwahid<br /></span></td>\r\n</tr>\r\n<tr>\r\n<td valign="top">2.<br /></td>\r\n<td valign="top">Anggota<br /></td>\r\n</tr>\r\n<tr>\r\n<td valign="top"><br /></td>\r\n<td valign="top">- Badruz Zaman<br />- Januar Aziz Hakim<br />- Akhmad Aris<br /></td>\r\n</tr>\r\n<tr>\r\n<td valign="top">&nbsp;</td>\r\n<td valign="top">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td valign="top"><strong><span style="font-size: x-small;">B.</span></strong></td>\r\n<td valign="top"><strong><span style="font-size: x-small;">Div. Multimedia</span></strong></td>\r\n</tr>\r\n<tr>\r\n<td valign="top"><span style="font-size: x-small;">1.</span></td>\r\n<td valign="top"><span style="font-size: x-small;">Kordinator</span></td>\r\n</tr>\r\n<tr>\r\n<td valign="top">&nbsp;</td>\r\n<td valign="top"><span style="font-size: x-small;">- Umaruddin</span></td>\r\n</tr>\r\n<tr>\r\n<td valign="top"><span style="font-size: x-small;">2. </span></td>\r\n<td valign="top"><span style="font-size: x-small;">Anggota</span></td>\r\n</tr>\r\n<tr>\r\n<td valign="top">&nbsp;</td>\r\n<td valign="top"><span style="font-size: x-small;">- Adi Purnomo</span></td>\r\n</tr>\r\n<tr>\r\n<td valign="top">&nbsp;</td>\r\n<td valign="top">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td valign="top"><strong><span style="font-size: x-small;">C.</span></strong></td>\r\n<td valign="top"><strong><span style="font-size: x-small;">Div. Alat Peraga</span></strong></td>\r\n</tr>\r\n<tr>\r\n<td valign="top"><span style="font-size: x-small;">1.</span></td>\r\n<td valign="top"><span style="font-size: x-small;">Kordinator</span></td>\r\n</tr>\r\n<tr>\r\n<td valign="top">&nbsp;</td>\r\n<td valign="top"><span style="font-size: x-small;">- Zulkifli</span></td>\r\n</tr>\r\n<tr>\r\n<td valign="top"><span style="font-size: x-small;">2.</span></td>\r\n<td valign="top"><span style="font-size: x-small;">Anggota</span></td>\r\n</tr>\r\n<tr>\r\n<td valign="top">&nbsp;</td>\r\n<td valign="top"><span style="font-size: x-small;">- M. Zakky<br />- Dedy<br />- Deswanto</span></td>\r\n</tr>\r\n<tr>\r\n<td valign="top">&nbsp;</td>\r\n<td valign="top">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td valign="top"><strong><span style="font-size: x-small;">D.</span></strong></td>\r\n<td valign="top"><strong><span style="font-size: x-small;">Div.Promosi</span></strong></td>\r\n</tr>\r\n<tr>\r\n<td valign="top"><span style="font-size: x-small;">1.</span></td>\r\n<td valign="top"><span style="font-size: x-small;">Kordinator</span></td>\r\n</tr>\r\n<tr>\r\n<td valign="top">\r\n<p>&nbsp;</p>\r\n<p>2.</p>\r\n</td>\r\n<td valign="top">\r\n<p><span style="font-size: x-small;">- Noer Yahya</span></p>\r\n<p><span style="font-size: x-small;">Anggota</span></p>\r\n<p><span style="font-size: x-small;">- Umaruddin<br /></span></p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</span></p>', 1);
INSERT INTO `tentangkami` VALUES (4, 'Pengalaman Kerja', '<table style="width: 483px; height: 266px;" border="0">\r\n<tbody>\r\n<tr>\r\n<td valign="top"><span style="font-size: small;">1</span></td>\r\n<td valign="top"><span style="font-size: small;">.</span></td>\r\n<td valign="top"><span style="font-size: small;">Pengadaan 1 Paket Lab. IPA ke PT. Teknik Andalan Aceh</span></td>\r\n</tr>\r\n<tr>\r\n<td><span style="font-size: small;">2</span></td>\r\n<td><span style="font-size: small;">.</span></td>\r\n<td><span style="font-size: small;">Pengadaaan 26 Paket Lab. IPA SLTP ke CV. Tauladan Jawa Tengah</span></td>\r\n</tr>\r\n<tr>\r\n<td valign="top"><span style="font-size: small;">3<br /></span></td>\r\n<td valign="top"><span style="font-size: small;">.<br /></span></td>\r\n<td valign="top"><span style="font-size: small;">Pengadaaan 6 Paket Lab. IPA SLTP Ke PT. Hanin Pekan Baru<br /></span></td>\r\n</tr>\r\n<tr>\r\n<td valign="top"><span style="font-size: small;">4<br /></span></td>\r\n<td valign="top"><span style="font-size: small;">.<br /></span></td>\r\n<td valign="top"><span style="font-size: small;">Pengadaan 1000 Paket Komputer + Printer + CD Interaktif DAK ke Konsorsium Pendidikan Nasional (KPN)<br /></span></td>\r\n</tr>\r\n<tr>\r\n<td valign="top"><span style="font-size: small;">5<br /></span></td>\r\n<td valign="top"><span style="font-size: small;">.<br /></span></td>\r\n<td valign="top"><span style="font-size: small;">Pengadaan Lighting &amp; Play System Theatre LUWES Institut Kesenian Jakarta (IKJ) Tahun 2006<br /></span></td>\r\n</tr>\r\n<tr>\r\n<td valign="top"><span style="font-size: small;">6<br /></span></td>\r\n<td valign="top"><span style="font-size: small;">.<br /></span></td>\r\n<td valign="top"><span style="font-size: small;">Pengadaan Komputer dan Printer Kontrak Dengan Komite Pendidikan Indonesia (KPI) 800 Unit<br /></span></td>\r\n</tr>\r\n<tr>\r\n<td valign="top"><span style="font-size: small;">7<br /></span></td>\r\n<td valign="top"><span style="font-size: small;">.<br /></span></td>\r\n<td valign="top"><span style="font-size: small;">Pengadaan Lab. Multimedia SMK PGRI Jombang<br /></span></td>\r\n</tr>\r\n<tr>\r\n<td valign="top"><span style="font-size: small;">8<br /></span></td>\r\n<td valign="top"><span style="font-size: small;">.<br /></span></td>\r\n<td valign="top"><span style="font-size: small;">Pengadaan 2 Paket Lab. IPA dan Komputer SLTP Sidoarjo<br /></span></td>\r\n</tr>\r\n<tr>\r\n<td valign="top"><span style="font-size: small;">9<br /></span></td>\r\n<td valign="top"><span style="font-size: small;">.<br /></span></td>\r\n<td valign="top"><span style="font-size: small;">Pengadaan 2 Paket Lab. IPA dan Komputer SLTP Lamongan</span></td>\r\n</tr>\r\n</tbody>\r\n</table>', 2);
INSERT INTO `tentangkami` VALUES (5, 'Merek Kami', '<p>Kami mempunyai beberapa BRAND</p>', 2);
INSERT INTO `tentangkami` VALUES (6, 'Mitra Kerjasama', '<p style="text-align: left;"><span style="font-size: small;"><strong>Mitra Asta Peraga</strong> dalam mendistribusikan alat-alat pendidikan dan laboratorium didukung dan bekerjasama dengan beberapa perusahaan produsen alat-alat pendidikan dan laboratorium serta laboratorium bahasa sebagai berikut :</span></p>\r\n<p><span style="font-size: small;"> \r\n<table style="background-color: #00702f; width: 496px; height: 53px;" border="0" cellspacing="1" cellpadding="2">\r\n<tbody>\r\n<tr bgcolor="#00702f">\r\n<td style="width: 8px; color: #ffffff; text-align: center;" align="center" valign="middle"><strong>No.</strong></td>\r\n<td style="width: 160px; color: #ffffff; text-align: center;" align="center" valign="middle"><strong>Nama Perusahaan</strong></td>\r\n<td style="color: #ffffff; text-align: center;" valign="middle"><strong>Alamat</strong></td>\r\n<td style="color: #ffffff; text-align: center;" align="center" valign="middle"><strong>Produk</strong></td>\r\n</tr>\r\n<tr bgcolor="#a7ddbe">\r\n<td valign="top">1</td>\r\n<td valign="top">CV.ANEKA ILMU</td>\r\n<td>Jl.Raya Semarang-Demak Km. 8,5 Semarang</td>\r\n<td valign="top">Buku pelajaran dan perpustakaan</td>\r\n</tr>\r\n<tr bgcolor="#c1e1cf">\r\n<td valign="top">2</td>\r\n<td valign="top">PT.CIPTA PRIMA BUDAYA</td>\r\n<td valign="top">NAIMUN Jakarta Selatan</td>\r\n<td valign="top">Buku  pengayaan dan agama Islam</td>\r\n</tr>\r\n<tr bgcolor="#a7ddbe">\r\n<td valign="top">3</td>\r\n<td valign="top">PT.ADI JAYA SEJAHTRA</td>\r\n<td valign="top">Surabaya Jawa Timur</td>\r\n<td valign="top">Lab. Trainer Kejuruan dan Dicdactic dan Lab Bahasa,Multi Media</td>\r\n</tr>\r\n<tr bgcolor="#c1e1cf">\r\n<td valign="top">4</td>\r\n<td valign="top">PT.BALAI PUSTAKA PERAGA</td>\r\n<td valign="top">Jakarta Pusat</td>\r\n<td valign="top">Alat Peraga Pendidikan</td>\r\n</tr>\r\n<tr bgcolor="#a7ddbe">\r\n<td valign="top">5</td>\r\n<td valign="top">PT.BAMBO MEDIA</td>\r\n<td valign="top">Denpasar - Bali<br /></td>\r\n<td valign="top">Alat Peraga VCD Pendidikan</td>\r\n</tr>\r\n<tr bgcolor="#c1e1cf">\r\n<td valign="top">6</td>\r\n<td valign="top">PT.LABTECH PENTA INTERNATIONAL</td>\r\n<td valign="top">Sekupang Batam</td>\r\n<td valign="top">Alat  Trainer Pendidikan</td>\r\n</tr>\r\n<tr bgcolor="#a7ddbe">\r\n<td valign="top">7</td>\r\n<td valign="top">PT CITRA KARYA INSAN</td>\r\n<td valign="top">Graha Permata Pancoran A-8 Jakarta Selatan</td>\r\n<td valign="top">Alat  Trainer Kejuruan Merk Karya Q dan TQ</td>\r\n</tr>\r\n<tr bgcolor="#c1e1cf">\r\n<td valign="top">8</td>\r\n<td style="width: 200px;" valign="top">PT. METRODATA E-BISNIS</td>\r\n<td valign="top">Wisma Metropolitan 1, lt, 16 Jl.Jenderal Sudirman,Kav.29-31 Jakarta 12920- Indonesia</td>\r\n<td valign="top">Komputer ION dan EPSON [<em>Autorazed Dialer Service</em>]</td>\r\n</tr>\r\n<tr bgcolor="#a7ddbe">\r\n<td valign="top">9</td>\r\n<td valign="top">CV. WARDANA</td>\r\n<td valign="top">Surabaya Jawa Timur</td>\r\n<td valign="top">Alat Pendidikan Dan Laboratorium</td>\r\n</tr>\r\n<tr bgcolor="#c1e1cf">\r\n<td valign="top">10</td>\r\n<td valign="top">BLPT YOGYAKARTA</td>\r\n<td valign="top">DI Yogyakarta</td>\r\n<td valign="top">Pendidikan, Pelatihan, Produksi dan Jasa</td>\r\n</tr>\r\n<tr bgcolor="#a7ddbe">\r\n<td valign="top">11</td>\r\n<td valign="top">PT. WINNER TECH</td>\r\n<td valign="top">Malang Jawa Timur</td>\r\n<td valign="top">Lab. Bahasa</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</span></p>\r\n<p style="text-align: left;"><span style="font-size: small;">Disamping kami sebagai importir dan principle dan distributor, kami juga sebagai pemegang :<br />- <strong>Merk MaenanQ</strong> Education Trainer KID   <br />- <strong>Merk Wayka</strong> Meja Spesialis Lab Bahasa dan Multi Media</span></p>', 2);

-- --------------------------------------------------------

-- 
-- Table structure for table `username`
-- 

CREATE TABLE `username` (
  `idUser` int(11) NOT NULL auto_increment,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `usernameAsal` text NOT NULL,
  `passwordAsal` text NOT NULL,
  `idHak` int(11) NOT NULL,
  `idPertanyaan` int(11) NOT NULL,
  `jawaban` text NOT NULL,
  `lastLogin` text NOT NULL,
  `regDate` date NOT NULL,
  PRIMARY KEY  (`idUser`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

-- 
-- Dumping data for table `username`
-- 

INSERT INTO `username` VALUES (1, '2198ZHchCPvo2', '2198ZHchCPvo2', 'admin', 'admin', 1, 0, '', '', '0000-00-00');
INSERT INTO `username` VALUES (32, 'c0JNlemq6clNc', 'c0JNlemq6clNc', 'mian', 'mian', 2, 1, 'Ainul', '', '2009-04-20');
INSERT INTO `username` VALUES (33, '17T3ZN/5OVZYM', '17T3ZN/5OVZYM', 'bagus', 'bagus', 2, 1, 'ainul', '', '2009-04-22');
INSERT INTO `username` VALUES (34, '489IZ6J71tTEM', '489IZ6J71tTEM', 'hedgehog', 'hedgehog', 2, 1, 'ainul', '', '2009-05-03');
INSERT INTO `username` VALUES (35, '0fW1yeVcUcpFo', '0fW1yeVcUcpFo', 'arif', 'arif', 2, 1, 'ibu', '', '2009-07-02');
INSERT INTO `username` VALUES (36, '18UQrZUIhcIhk', '18UQrZUIhcIhk', 'bagito', 'bagito', 2, 3, 'pingpong', '', '2009-08-20');
INSERT INTO `username` VALUES (37, 'e6TYGIT7yUSLM', 'e6TYGIT7yUSLM', 'riadi', 'riadi', 2, 3, 'musik', '', '2009-10-16');
INSERT INTO `username` VALUES (38, '52.0De7fq2SV6', '52.0De7fq2SV6', 'kartono', 'kartono', 2, 1, 'ainul', '', '2009-11-14');
INSERT INTO `username` VALUES (39, '53eNNFVKoh0Js', '53eNNFVKoh0Js', 'fitri', 'fitri', 2, 3, 'dosen', '', '2009-12-01');
