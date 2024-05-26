-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Bulan Mei 2024 pada 07.18
-- Versi server: 10.4.14-MariaDB
-- Versi PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `angkutan_spksmart`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alternatif`
--

CREATE TABLE `alternatif` (
  `id_alternatif` int(5) NOT NULL,
  `kode_alternatif` varchar(10) NOT NULL,
  `nama_alternatif` varchar(50) NOT NULL,
  `nilai_alternatif` double NOT NULL,
  `keterangan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `alternatif`
--

INSERT INTO `alternatif` (`id_alternatif`, `kode_alternatif`, `nama_alternatif`, `nilai_alternatif`, `keterangan`) VALUES
(29, 'A1', 'BA 9432 LQ', 80, 'Layak'),
(30, 'A2', 'BA 9935 LG', 97.5, 'Layak'),
(31, 'A3', 'BA 8022 LA', 97.5, 'Layak'),
(32, 'A4', 'BA 9484 LV', 71.666666666667, 'Layak'),
(33, 'A5', 'BA 7946 LU', 77.5, 'Layak'),
(34, 'A6', 'BA 1785 LV', 76.666666666667, 'Layak'),
(35, 'A7', 'BA 9866 LQ', 80, 'Layak'),
(36, 'A8', 'BA 9915 LE', 62.5, 'Tidak Layak'),
(37, 'A9', 'BA 7934 LU', 85, 'Layak'),
(38, 'A10', 'BA 8530 LA', 50.833333333333, 'Tidak Layak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` int(5) NOT NULL,
  `kode_kriteria` varchar(10) NOT NULL,
  `nama_kriteria` varchar(50) NOT NULL,
  `bobot_kriteria` double NOT NULL,
  `min` int(5) NOT NULL,
  `max` int(5) NOT NULL,
  `normalisasi` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `kode_kriteria`, `nama_kriteria`, `bobot_kriteria`, `min`, `max`, `normalisasi`) VALUES
(1, 'K1', 'Kincup Roda Depan', 5, 50, 100, 0.05),
(2, 'K2', 'Kekuatan Pancar Lampu', 15, 50, 100, 0.15),
(8, 'K3', 'Arah Pancar Lampu', 5, 50, 100, 0.05),
(9, 'K4', 'Efesiensi Rem Utama', 25, 25, 100, 0.25),
(10, 'K5', 'Efesiensi Rem Parkir', 10, 25, 100, 0.1),
(11, 'K6', 'Akurasi Penunjuk Kecepatan', 5, 50, 100, 0.05),
(12, 'K7', 'Emisi Gas Buang', 20, 25, 100, 0.2),
(13, 'K8', 'Suara Klakson', 5, 50, 100, 0.05),
(16, 'K9', 'Kondisi Komponen Fisik', 10, 25, 100, 0.1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilaian`
--

CREATE TABLE `penilaian` (
  `id_penilaian` int(5) NOT NULL,
  `id_alternatif` int(5) NOT NULL,
  `id_kriteria` int(5) NOT NULL,
  `id_subkriteria` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `penilaian`
--

INSERT INTO `penilaian` (`id_penilaian`, `id_alternatif`, `id_kriteria`, `id_subkriteria`) VALUES
(296, 29, 1, 3),
(297, 29, 2, 6),
(298, 29, 8, 18),
(299, 29, 9, 21),
(300, 29, 10, 24),
(301, 29, 11, 27),
(302, 29, 12, 32),
(303, 29, 13, 33),
(304, 29, 16, 40),
(311, 30, 1, 3),
(312, 30, 2, 6),
(313, 30, 8, 19),
(314, 30, 9, 21),
(315, 30, 10, 24),
(316, 30, 11, 27),
(317, 30, 12, 30),
(318, 30, 13, 33),
(319, 30, 16, 40),
(326, 31, 1, 3),
(327, 31, 2, 6),
(328, 31, 8, 18),
(329, 31, 9, 21),
(330, 31, 10, 24),
(331, 31, 11, 28),
(332, 31, 12, 30),
(333, 31, 13, 33),
(334, 31, 16, 40),
(341, 32, 1, 4),
(342, 32, 2, 6),
(343, 32, 8, 19),
(344, 32, 9, 21),
(345, 32, 10, 24),
(346, 32, 11, 27),
(347, 32, 12, 32),
(348, 32, 13, 33),
(349, 32, 16, 41),
(356, 33, 1, 3),
(357, 33, 2, 8),
(358, 33, 8, 18),
(359, 33, 9, 21),
(360, 33, 10, 24),
(361, 33, 11, 28),
(362, 33, 12, 30),
(363, 33, 13, 35),
(364, 33, 16, 40),
(371, 34, 1, 3),
(372, 34, 2, 6),
(373, 34, 8, 18),
(374, 34, 9, 21),
(375, 34, 10, 24),
(376, 34, 11, 27),
(377, 34, 12, 32),
(378, 34, 13, 33),
(379, 34, 16, 41),
(386, 35, 1, 4),
(387, 35, 2, 8),
(388, 35, 8, 18),
(389, 35, 9, 21),
(390, 35, 10, 24),
(391, 35, 11, 28),
(392, 35, 12, 30),
(393, 35, 13, 33),
(394, 35, 16, 40),
(401, 36, 1, 3),
(402, 36, 2, 8),
(403, 36, 8, 19),
(404, 36, 9, 21),
(405, 36, 10, 24),
(406, 36, 11, 27),
(407, 36, 12, 32),
(408, 36, 13, 33),
(409, 36, 16, 40),
(416, 37, 1, 3),
(417, 37, 2, 8),
(418, 37, 8, 18),
(419, 37, 9, 21),
(420, 37, 10, 24),
(421, 37, 11, 27),
(422, 37, 12, 30),
(423, 37, 13, 33),
(424, 37, 16, 40),
(431, 38, 1, 3),
(432, 38, 2, 8),
(433, 38, 8, 18),
(434, 38, 9, 21),
(435, 38, 10, 24),
(436, 38, 11, 28),
(437, 38, 12, 32),
(438, 38, 13, 35),
(439, 38, 16, 42);

-- --------------------------------------------------------

--
-- Struktur dari tabel `perhitungan`
--

CREATE TABLE `perhitungan` (
  `id_perhitungan` int(5) NOT NULL,
  `id_alternatif` int(5) NOT NULL,
  `id_kriteria` int(5) NOT NULL,
  `nilai_alternatif_per_kriteria` int(10) NOT NULL,
  `nilai_utility` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `perhitungan`
--

INSERT INTO `perhitungan` (`id_perhitungan`, `id_alternatif`, `id_kriteria`, `nilai_alternatif_per_kriteria`, `nilai_utility`) VALUES
(508, 29, 1, 100, 100),
(509, 29, 2, 100, 100),
(510, 29, 8, 100, 100),
(511, 29, 9, 100, 100),
(512, 29, 10, 100, 100),
(513, 29, 11, 100, 100),
(514, 29, 12, 25, 0),
(515, 29, 13, 100, 100),
(516, 29, 16, 100, 100),
(523, 30, 1, 100, 100),
(524, 30, 2, 100, 100),
(525, 30, 8, 75, 50),
(526, 30, 9, 100, 100),
(527, 30, 10, 100, 100),
(528, 30, 11, 100, 100),
(529, 30, 12, 100, 100),
(530, 30, 13, 100, 100),
(531, 30, 16, 100, 100),
(538, 31, 1, 100, 100),
(539, 31, 2, 100, 100),
(540, 31, 8, 100, 100),
(541, 31, 9, 100, 100),
(542, 31, 10, 100, 100),
(543, 31, 11, 75, 50),
(544, 31, 12, 100, 100),
(545, 31, 13, 100, 100),
(546, 31, 16, 100, 100),
(553, 32, 1, 75, 50),
(554, 32, 2, 100, 100),
(555, 32, 8, 75, 50),
(556, 32, 9, 100, 100),
(557, 32, 10, 100, 100),
(558, 32, 11, 100, 100),
(559, 32, 12, 25, 0),
(560, 32, 13, 100, 100),
(561, 32, 16, 75, 66.666666666667),
(568, 33, 1, 100, 100),
(569, 33, 2, 50, 0),
(570, 33, 8, 100, 100),
(571, 33, 9, 100, 100),
(572, 33, 10, 100, 100),
(573, 33, 11, 75, 50),
(574, 33, 12, 100, 100),
(575, 33, 13, 50, 0),
(576, 33, 16, 100, 100),
(583, 34, 1, 100, 100),
(584, 34, 2, 100, 100),
(585, 34, 8, 100, 100),
(586, 34, 9, 100, 100),
(587, 34, 10, 100, 100),
(588, 34, 11, 100, 100),
(589, 34, 12, 25, 0),
(590, 34, 13, 100, 100),
(591, 34, 16, 75, 66.666666666667),
(598, 35, 1, 75, 50),
(599, 35, 2, 50, 0),
(600, 35, 8, 100, 100),
(601, 35, 9, 100, 100),
(602, 35, 10, 100, 100),
(603, 35, 11, 75, 50),
(604, 35, 12, 100, 100),
(605, 35, 13, 100, 100),
(606, 35, 16, 100, 100),
(613, 36, 1, 100, 100),
(614, 36, 2, 50, 0),
(615, 36, 8, 75, 50),
(616, 36, 9, 100, 100),
(617, 36, 10, 100, 100),
(618, 36, 11, 100, 100),
(619, 36, 12, 25, 0),
(620, 36, 13, 100, 100),
(621, 36, 16, 100, 100),
(628, 37, 1, 100, 100),
(629, 37, 2, 50, 0),
(630, 37, 8, 100, 100),
(631, 37, 9, 100, 100),
(632, 37, 10, 100, 100),
(633, 37, 11, 100, 100),
(634, 37, 12, 100, 100),
(635, 37, 13, 100, 100),
(636, 37, 16, 100, 100),
(643, 38, 1, 100, 100),
(644, 38, 2, 50, 0),
(645, 38, 8, 100, 100),
(646, 38, 9, 100, 100),
(647, 38, 10, 100, 100),
(648, 38, 11, 75, 50),
(649, 38, 12, 25, 0),
(650, 38, 13, 50, 0),
(651, 38, 16, 50, 33.333333333333);

-- --------------------------------------------------------

--
-- Struktur dari tabel `subkriteria`
--

CREATE TABLE `subkriteria` (
  `id_subkriteria` int(5) NOT NULL,
  `id_kriteria` int(5) NOT NULL,
  `kode_subkriteria` varchar(10) NOT NULL,
  `nama_subkriteria` varchar(100) NOT NULL,
  `nilai_subkriteria` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `subkriteria`
--

INSERT INTO `subkriteria` (`id_subkriteria`, `id_kriteria`, `kode_subkriteria`, `nama_subkriteria`, `nilai_subkriteria`) VALUES
(3, 1, 'KR1', 'Kurang dari +-3mm', 100),
(4, 1, 'KR2', 'Antara +-3mm sampai +-5mm', 75),
(5, 1, 'KR3', 'Lebih dari +-5mm', 50),
(6, 2, 'KL1', 'Lebih dari 12000 CD', 100),
(8, 2, 'KL2', 'Kurang dari 12000 CD', 50),
(18, 8, 'AL1', 'Kedua lampu aman', 100),
(19, 8, 'AL2', 'Salah satu lampu aman', 75),
(20, 8, 'AL3', 'Kedua lampu tidak aman', 50),
(21, 9, 'RU1', 'Lebih dari 60%', 100),
(23, 9, 'RU2', 'Kurang dari 60%', 25),
(24, 10, 'RP1', 'Lebih dari 16%', 100),
(26, 10, 'RP2', 'Kurang dari 16%', 25),
(27, 11, 'PK1', 'Sesuai antara alat uji dengan alat penunjuk kecepatan', 100),
(28, 11, 'PK2', 'Angka pada penunjuk kecepatan kurang 10% atau lebih 15% dari angka alat uji', 75),
(29, 11, 'PK3', 'Tidak sesuai antara alat uji dengan alat penunjuk kecepatan', 50),
(30, 12, 'EG1', 'Kadar asap kurang dari batas kadar semestinya', 100),
(32, 12, 'EG2', 'Kadar asap lebih dari batas kadar semestinya', 25),
(33, 13, 'SK1', 'Tingkat suara klakson antara 90dB sampai 118 dB', 100),
(35, 13, 'SK2', 'Tingkat suara klakson kurang dari 90 dB atau lebih dari 118 dB', 50),
(40, 16, 'KF1', 'Semua komponen fisik dalam keadaan baik', 100),
(41, 16, 'KF2', 'Lebih banyak komponen fisik dalam keadaan baik', 75),
(42, 16, 'KF3', 'Lebih banyak komponen fisik dalam keadaan buruk', 50),
(43, 16, 'KF4', 'Semua komponen dalam keadaan buruk ', 25);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(5) NOT NULL,
  `nama_petugas` varchar(100) NOT NULL,
  `level` enum('admin','petugas') NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama_petugas`, `level`, `username`, `password`) VALUES
(13, 'Doyok', 'admin', 'admin', 'admin'),
(14, 'Fio', 'petugas', 'petugas', 'petugas');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id_alternatif`);

--
-- Indeks untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indeks untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id_penilaian`),
  ADD KEY `id_alternatif` (`id_alternatif`),
  ADD KEY `id_kriteria` (`id_kriteria`),
  ADD KEY `id_subkriteria` (`id_subkriteria`);

--
-- Indeks untuk tabel `perhitungan`
--
ALTER TABLE `perhitungan`
  ADD PRIMARY KEY (`id_perhitungan`),
  ADD KEY `id_alternatif` (`id_alternatif`),
  ADD KEY `id_kriteria` (`id_kriteria`);

--
-- Indeks untuk tabel `subkriteria`
--
ALTER TABLE `subkriteria`
  ADD PRIMARY KEY (`id_subkriteria`),
  ADD KEY `id_kriteria` (`id_kriteria`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `alternatif`
--
ALTER TABLE `alternatif`
  MODIFY `id_alternatif` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id_penilaian` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=601;

--
-- AUTO_INCREMENT untuk tabel `perhitungan`
--
ALTER TABLE `perhitungan`
  MODIFY `id_perhitungan` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=880;

--
-- AUTO_INCREMENT untuk tabel `subkriteria`
--
ALTER TABLE `subkriteria`
  MODIFY `id_subkriteria` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  ADD CONSTRAINT `penilaian_ibfk_2` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`),
  ADD CONSTRAINT `penilaian_ibfk_4` FOREIGN KEY (`id_alternatif`) REFERENCES `alternatif` (`id_alternatif`);

--
-- Ketidakleluasaan untuk tabel `perhitungan`
--
ALTER TABLE `perhitungan`
  ADD CONSTRAINT `perhitungan_ibfk_2` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`),
  ADD CONSTRAINT `perhitungan_ibfk_3` FOREIGN KEY (`id_alternatif`) REFERENCES `alternatif` (`id_alternatif`);

--
-- Ketidakleluasaan untuk tabel `subkriteria`
--
ALTER TABLE `subkriteria`
  ADD CONSTRAINT `subkriteria_ibfk_1` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
