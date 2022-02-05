-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 05 Şub 2022, 16:15:10
-- Sunucu sürümü: 8.0.17
-- PHP Sürümü: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `siparis`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `anliksiparis`
--

CREATE TABLE `anliksiparis` (
  `id` int(11) NOT NULL,
  `masaid` int(11) NOT NULL,
  `garsonid` int(11) NOT NULL,
  `urunid` int(11) NOT NULL,
  `urunad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `urunfiyat` float NOT NULL,
  `adet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `anliksiparis`
--

INSERT INTO `anliksiparis` (`id`, `masaid`, `garsonid`, `urunid`, `urunad`, `urunfiyat`, `adet`) VALUES
(142, 4, 1, 33, 'Coca Cola Zero', 6, 1),
(143, 4, 1, 22, 'Big Whooper', 38, 1),
(144, 9, 1, 9, 'Klasik Serpme', 45, 1),
(145, 9, 1, 10, 'Özel Tabak', 30, 3);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `doluluk`
--

CREATE TABLE `doluluk` (
  `id` int(11) NOT NULL,
  `bos` int(11) NOT NULL DEFAULT '0',
  `dolu` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `doluluk`
--

INSERT INTO `doluluk` (`id`, `bos`, `dolu`) VALUES
(1, 12, 2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `garson`
--

CREATE TABLE `garson` (
  `id` int(11) NOT NULL,
  `ad` varchar(25) COLLATE utf8_turkish_ci NOT NULL,
  `sifre` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `durum` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `garson`
--

INSERT INTO `garson` (`id`, `ad`, `sifre`, `durum`) VALUES
(1, 'bahadır', '10', 1),
(2, 'ahmet', '10', 0),
(3, 'mehmet', '10', 0),
(4, 'hasan', '10', 0),
(5, 'ayşe', '10', 0),
(6, 'fatma', '10', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `gecicigarson`
--

CREATE TABLE `gecicigarson` (
  `id` int(11) NOT NULL,
  `garsonid` int(11) NOT NULL,
  `garsonad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `adet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `gecicigarson`
--

INSERT INTO `gecicigarson` (`id`, `garsonid`, `garsonad`, `adet`) VALUES
(1, 1, 'bahadır', 30),
(2, 3, 'mehmet', 27),
(3, 2, 'ahmet', 30),
(4, 4, 'hasan', 23),
(5, 5, 'ayşe', 21);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `gecicimasa`
--

CREATE TABLE `gecicimasa` (
  `id` int(11) NOT NULL,
  `masaid` int(11) NOT NULL,
  `masaad` varchar(20) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `hasilat` float NOT NULL,
  `adet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `gecicimasa`
--

INSERT INTO `gecicimasa` (`id`, `masaid`, `masaad`, `hasilat`, `adet`) VALUES
(1, 9, 'MS-9', 2, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `geciciurun`
--

CREATE TABLE `geciciurun` (
  `id` int(11) NOT NULL,
  `urunid` int(11) NOT NULL,
  `urunad` varchar(20) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `hasilat` float NOT NULL,
  `adet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `geciciurun`
--

INSERT INTO `geciciurun` (`id`, `urunid`, `urunad`, `hasilat`, `adet`) VALUES
(1, 2, 'Çay', 2, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `kategori`
--

INSERT INTO `kategori` (`id`, `ad`) VALUES
(1, 'Sıcak İçecekler'),
(2, 'Soğuk İçecekler'),
(3, 'Tatlılar'),
(4, 'Pizzalar'),
(5, 'Kahvaltı'),
(6, 'Tostlar '),
(7, 'Burgerler'),
(8, 'Salatalar'),
(9, 'Ana Yemekler '),
(10, 'Makarnalar'),
(11, 'Alkollü İçecekler'),
(13, 'Nargileler'),
(14, 'Omletler');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `masalar`
--

CREATE TABLE `masalar` (
  `id` int(11) NOT NULL,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `masalar`
--

INSERT INTO `masalar` (`id`, `ad`) VALUES
(1, 'MS-1'),
(2, 'MS-2'),
(3, 'MS-3'),
(4, 'MS-4'),
(5, 'MS-5'),
(6, 'MS-6'),
(7, 'MS-7'),
(8, 'MS-8'),
(9, 'MS-9'),
(10, 'MS-10'),
(11, 'MS-11'),
(12, 'MS-12'),
(13, 'MS-13'),
(14, 'MS-14');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `rapor`
--

CREATE TABLE `rapor` (
  `id` int(11) NOT NULL,
  `masaid` int(11) NOT NULL,
  `garsonid` int(11) NOT NULL,
  `urunid` int(11) NOT NULL,
  `urunad` varchar(20) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `urunfiyat` float NOT NULL,
  `adet` int(11) NOT NULL,
  `tarih` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `rapor`
--

INSERT INTO `rapor` (`id`, `masaid`, `garsonid`, `urunid`, `urunad`, `urunfiyat`, `adet`, `tarih`) VALUES
(19, 9, 1, 4, 'Kahve', 8, 5, '2022-01-03'),
(20, 9, 2, 1, 'Kola', 5, 2, '2022-01-03'),
(21, 9, 3, 5, 'Künefe', 8, 1, '2022-01-03'),
(22, 9, 4, 17, 'Bol Malzemeli', 45, 1, '2022-01-03'),
(23, 9, 5, 4, 'Kahve', 8, 44, '2022-01-02'),
(24, 9, 6, 26, 'Izgara', 52, 3, '2022-01-03'),
(25, 9, 1, 20, 'Vegan ', 38, 2, '2022-01-03'),
(26, 9, 2, 8, 'Özel Soslu', 35, 10, '2022-01-03'),
(27, 8, 3, 13, 'Sucuklu', 20, 3, '2022-01-03'),
(28, 8, 4, 14, 'Ayran', 3, 11, '2022-01-03'),
(29, 8, 5, 6, 'Bardak Çay', 4, 2, '2022-01-03'),
(30, 10, 6, 7, 'Fincan Çay', 8, 2, '2022-01-03'),
(31, 10, 1, 2, 'Çay', 2, 1, '2022-01-03'),
(32, 13, 2, 4, 'Kahve', 8, 4, '2022-01-03'),
(33, 14, 3, 4, 'Kahve', 8, 10, '2022-01-03'),
(34, 14, 4, 2, 'Çay', 2, 4, '2022-01-03'),
(35, 8, 5, 7, 'Fincan Çay', 8, 2, '2022-01-03'),
(36, 10, 6, 5, 'Künefe', 8, 1, '2022-01-03'),
(37, 9, 1, 4, 'Kahve', 8, 7, '2022-01-03'),
(38, 9, 2, 2, 'Çay', 2, 1, '2022-01-03'),
(39, 13, 3, 14, 'Ayran', 3, 2, '2022-01-03'),
(40, 10, 4, 1, 'Kola', 5, 13, '2022-01-03'),
(41, 14, 5, 8, 'Özel Soslu', 35, 7, '2022-01-03'),
(42, 4, 6, 4, 'Kahve', 8, 1, '2022-01-03'),
(43, 1, 1, 16, 'Latte', 20, 3, '2022-01-05'),
(44, 1, 3, 5, 'Künefe', 8, 3, '2022-01-05'),
(45, 8, 3, 12, 'Kaşarlı ', 15, 3, '2022-01-05'),
(46, 9, 1, 18, 'Margarita', 25, 3, '2022-01-05'),
(47, 9, 2, 19, 'Ton Balıklı', 52, 1, '2022-01-05'),
(48, 11, 3, 23, 'Sezar', 20, 2, '2022-01-05'),
(49, 11, 3, 24, 'Ton Balıklı', 30, 3, '2022-01-05'),
(50, 1, 2, 12, 'Kaşarlı ', 15, 3, '2022-01-05'),
(51, 1, 1, 24, 'Ton Balıklı', 30, 2, '2022-01-05'),
(52, 1, 2, 3, 'Hamburger', 35, 4, '2022-01-05'),
(53, 1, 4, 22, 'Big Whooper', 38, 10, '2022-01-05'),
(54, 2, 1, 7, 'Fincan Çay', 10, 2, '2022-01-06'),
(55, 2, 2, 32, 'Votka', 35, 2, '2022-01-06'),
(56, 2, 3, 30, 'Elma Nane', 35, 9, '2022-01-06'),
(57, 1, 2, 15, 'Salep', 8, 3, '2022-01-06'),
(58, 1, 1, 21, 'Cheeseburger', 28, 3, '2022-01-06'),
(59, 1, 5, 26, 'Izgara', 52, 10, '2022-01-06'),
(60, 3, 4, 18, 'Margarita', 25, 3, '2022-01-06'),
(61, 3, 5, 13, 'Sucuklu', 20, 3, '2022-01-06'),
(62, 3, 1, 31, 'Bira', 25, 9, '2022-01-06'),
(63, 9, 2, 26, 'Izgara', 52, 8, '2022-01-06'),
(64, 9, 3, 31, 'Bira', 25, 7, '2022-01-06'),
(65, 9, 1, 8, 'Özel Soslu', 35, 7, '2022-01-06'),
(66, 10, 4, 29, 'Fındıklı Latte', 25, 10, '2022-01-06'),
(67, 10, 2, 9, 'Klasik Serpme', 45, 9, '2022-01-06'),
(68, 10, 5, 21, 'Cheeseburger', 28, 8, '2022-01-06'),
(104, 9, 1, 2, 'Çay', 2, 1, '2022-02-03');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urunler`
--

CREATE TABLE `urunler` (
  `id` int(11) NOT NULL,
  `katid` int(11) NOT NULL,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `fiyat` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `urunler`
--

INSERT INTO `urunler` (`id`, `katid`, `ad`, `fiyat`) VALUES
(2, 1, 'Çay', 2),
(3, 7, 'Hamburger', 35),
(4, 1, 'Kahve', 8),
(5, 3, 'Künefe', 8),
(7, 1, 'Fincan Çay', 10),
(8, 10, 'Özel Soslu', 35),
(9, 5, 'Klasik Serpme', 45),
(10, 5, 'Özel Tabak', 30),
(11, 6, 'Karışık', 25),
(12, 6, 'Kaşarlı ', 15),
(13, 6, 'Sucuklu', 20),
(15, 1, 'Salep', 8),
(16, 1, 'Latte', 20),
(17, 4, 'Bol Malzemeli', 45),
(18, 4, 'Margarita', 25),
(19, 4, 'Ton Balıklı', 52),
(20, 4, 'Vegan ', 38),
(21, 7, 'Cheeseburger', 28),
(22, 7, 'Big Whooper', 38),
(23, 8, 'Sezar', 20),
(24, 8, 'Ton Balıklı', 30),
(25, 9, 'Kebab', 42),
(26, 9, 'Izgara', 52),
(28, 2, 'Acılı Ayran', 10),
(29, 1, 'Fındıklı Latte', 25),
(30, 13, 'Elma Nane', 35),
(31, 11, 'Bira', 25),
(32, 11, 'Votka', 35),
(33, 2, 'Coca Cola Zero', 6),
(34, 2, 'Kola', 5),
(35, 11, 'Cin Tonik', 50);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yonetim`
--

CREATE TABLE `yonetim` (
  `id` int(11) NOT NULL,
  `kulad` varchar(40) COLLATE utf8_turkish_ci NOT NULL,
  `sifre` varchar(40) COLLATE utf8_turkish_ci NOT NULL,
  `yetki` int(11) NOT NULL DEFAULT '0',
  `aktif` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `yonetim`
--

INSERT INTO `yonetim` (`id`, `kulad`, `sifre`, `yetki`, `aktif`) VALUES
(1, 'Bahadır Önal', '97e44c6222aa49fbf435d64c1210bf46', 1, 0),
(2, 'ahmet mehmet', '97e44c6222aa49fbf435d64c1210bf46', 0, 0);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `anliksiparis`
--
ALTER TABLE `anliksiparis`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `doluluk`
--
ALTER TABLE `doluluk`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `garson`
--
ALTER TABLE `garson`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `gecicigarson`
--
ALTER TABLE `gecicigarson`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `gecicimasa`
--
ALTER TABLE `gecicimasa`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `geciciurun`
--
ALTER TABLE `geciciurun`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `masalar`
--
ALTER TABLE `masalar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `rapor`
--
ALTER TABLE `rapor`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `urunler`
--
ALTER TABLE `urunler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `yonetim`
--
ALTER TABLE `yonetim`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `anliksiparis`
--
ALTER TABLE `anliksiparis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- Tablo için AUTO_INCREMENT değeri `doluluk`
--
ALTER TABLE `doluluk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `garson`
--
ALTER TABLE `garson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Tablo için AUTO_INCREMENT değeri `gecicigarson`
--
ALTER TABLE `gecicigarson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `gecicimasa`
--
ALTER TABLE `gecicimasa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `geciciurun`
--
ALTER TABLE `geciciurun`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Tablo için AUTO_INCREMENT değeri `masalar`
--
ALTER TABLE `masalar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Tablo için AUTO_INCREMENT değeri `rapor`
--
ALTER TABLE `rapor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- Tablo için AUTO_INCREMENT değeri `urunler`
--
ALTER TABLE `urunler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Tablo için AUTO_INCREMENT değeri `yonetim`
--
ALTER TABLE `yonetim`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
