-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 10 Jan 2026 pada 06.12
-- Versi server: 8.4.3
-- Versi PHP: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `peminjaman_ruangan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bidang_pegawai`
--

CREATE TABLE `bidang_pegawai` (
  `id_bidang` int NOT NULL,
  `sub_bidang` varchar(100) NOT NULL,
  `bidang` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `bidang_pegawai`
--

INSERT INTO `bidang_pegawai` (`id_bidang`, `sub_bidang`, `bidang`) VALUES
(1, 'Sekretaris', 'Sekretariat'),
(2, 'Kasubag Umpeg', 'Sekretariat'),
(3, 'Kasubag Keuangan (Purna)', 'Sekretariat'),
(4, 'Kasubag Program', 'Sekretariat');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_sarana`
--

CREATE TABLE `data_sarana` (
  `id_sarana` int NOT NULL,
  `nama_sarana` varchar(100) NOT NULL,
  `jenis_sarana` enum('elektronik','non-elektronik') NOT NULL,
  `jumlah` int NOT NULL,
  `id_ruangan` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `data_sarana`
--

INSERT INTO `data_sarana` (`id_sarana`, `nama_sarana`, `jenis_sarana`, `jumlah`, `id_ruangan`) VALUES
(1, 'AC', 'elektronik', 1, 1),
(2, 'Sound System', 'elektronik', 3, 1),
(3, 'Kursi', 'non-elektronik', 50, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ruangan`
--

CREATE TABLE `ruangan` (
  `id_ruangan` int NOT NULL,
  `nama_ruangan` varchar(100) NOT NULL,
  `gambar_ruangan` varchar(255) DEFAULT NULL,
  `ketersediaan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `ruangan`
--

INSERT INTO `ruangan` (`id_ruangan`, `nama_ruangan`, `gambar_ruangan`, `ketersediaan`) VALUES
(1, 'Ruang Rapat A', NULL, 'Tersedia'),
(2, 'Ruang Rapat B', NULL, 'Tersedia'),
(3, 'Aula Utama', NULL, 'Tidak Tersedia');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_peminjaman` int NOT NULL,
  `waktu_mulai` datetime DEFAULT NULL,
  `waktu_selesai` datetime DEFAULT NULL,
  `acara` varchar(100) NOT NULL,
  `catatan` varchar(100) NOT NULL,
  `status_peminjaman` enum('Menunggu','Disetujui','Ditolak','Dibatalkan') NOT NULL,
  `jumlah_peserta` int NOT NULL,
  `id_bidang` int NOT NULL,
  `id_ruangan` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `no_wa` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_peminjaman`, `waktu_mulai`, `waktu_selesai`, `acara`, `catatan`, `status_peminjaman`, `jumlah_peserta`, `id_bidang`, `id_ruangan`, `id_user`, `no_wa`) VALUES
(1, '2026-01-10 09:00:00', '2026-01-10 11:00:00', 'Rapat Koordinasi Sekretariat', 'Koordinasi administrasi internal', 'Menunggu', 15, 1, 1, 1, '0892311111'),
(2, '2026-01-12 13:00:00', '2026-01-12 15:00:00', 'Rapat Umum Kepegawaian', 'Pembahasan data kepegawaian', 'Disetujui', 20, 2, 2, 2, '0872366757'),
(3, '2026-01-15 08:00:00', '2026-01-15 10:00:00', 'Rapat Evaluasi Anggaran', 'Evaluasi anggaran', 'Menunggu', 10, 3, 1, 1, '082893497'),
(4, '2026-01-18 09:00:00', '2026-01-18 11:00:00', 'Rapat Perencanaan Program', 'Perencanaan program', 'Disetujui', 25, 4, 3, 2, '0897346345');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('superadmin','petugas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama`, `username`, `password`, `role`) VALUES
(1, 'Petugas Utama', 'petugas', '$2y$12$f8ZPSGNhdQpa8FrYhrSy0.N6ikgZ7836wSQiPSYqvMuL1DDRR2Qku', 'petugas'),
(2, 'Super Admin', 'admin', '$2y$12$Hq7pXvQ4C079q7HRldyQfO0y5o7YsWmU5SyTLLPm9wlRICCbO/eie', 'superadmin');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bidang_pegawai`
--
ALTER TABLE `bidang_pegawai`
  ADD PRIMARY KEY (`id_bidang`);

--
-- Indeks untuk tabel `data_sarana`
--
ALTER TABLE `data_sarana`
  ADD PRIMARY KEY (`id_sarana`),
  ADD KEY `id_ruangan` (`id_ruangan`);

--
-- Indeks untuk tabel `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id_ruangan`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `id_bidang` (`id_bidang`),
  ADD KEY `id_ruangan` (`id_ruangan`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `data_sarana`
--
ALTER TABLE `data_sarana`
  MODIFY `id_sarana` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `data_sarana`
--
ALTER TABLE `data_sarana`
  ADD CONSTRAINT `fk_sarana_ruangan` FOREIGN KEY (`id_ruangan`) REFERENCES `ruangan` (`id_ruangan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `fk_transaksi_bidang` FOREIGN KEY (`id_bidang`) REFERENCES `bidang_pegawai` (`id_bidang`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_transaksi_ruangan` FOREIGN KEY (`id_ruangan`) REFERENCES `ruangan` (`id_ruangan`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_transaksi_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
