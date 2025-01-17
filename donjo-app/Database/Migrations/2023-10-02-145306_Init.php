<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Init extends Migration
{
    public function up()
    {
        $this->db->query("CREATE TABLE IF NOT EXISTS `analisis_indikator` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `id_master` int(11) NOT NULL,
            `nomor` int(3) NOT NULL,
            `pertanyaan` varchar(400) NOT NULL,
            `id_tipe` tinyint(4) NOT NULL DEFAULT '1',
            `bobot` tinyint(4) NOT NULL DEFAULT '0',
            `act_analisis` tinyint(1) NOT NULL DEFAULT '2',
            `id_kategori` tinyint(4) NOT NULL,
            `is_publik` tinyint(1) NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`),
            KEY `id_master` (`id_master`,`id_tipe`),
            KEY `id_tipe` (`id_tipe`),
            KEY `id_kategori` (`id_kategori`)
           )");

        $this->db->query('CREATE TABLE IF NOT EXISTS `analisis_kategori_indikator` (
            `id` tinyint(4) NOT NULL AUTO_INCREMENT,
            `id_master` tinyint(4) NOT NULL,
            `kategori_kode` varchar(3) NOT NULL,
            `kategori` varchar(50) NOT NULL,
            PRIMARY KEY (`id`),
            KEY `id_master` (`id_master`)
           )');

        $this->db->query('CREATE TABLE IF NOT EXISTS `analisis_klasifikasi` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `id_master` int(11) NOT NULL,
            `nama` varchar(20) NOT NULL,
            `minval` double(5,2) NOT NULL,
            `maxval` double(5,2) NOT NULL,
            PRIMARY KEY (`id`),
            KEY `id_master` (`id_master`)
           )');

        $this->db->query("CREATE TABLE IF NOT EXISTS `analisis_master` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nama` varchar(40) NOT NULL,
            `subjek_tipe` tinyint(4) NOT NULL,
            `lock` tinyint(1) NOT NULL DEFAULT '1',
            `deskripsi` text NOT NULL,
            `kode_analisis` varchar(5) NOT NULL DEFAULT '00000',
            `id_child` smallint(4) NOT NULL,
            `id_kelompok` int(11) NOT NULL,
            `pembagi` varchar(10) NOT NULL DEFAULT '100',
            PRIMARY KEY (`id`)
           )");

        $this->db->query("CREATE TABLE IF NOT EXISTS `analisis_parameter` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `id_indikator` int(11) NOT NULL,
            `kode_jawaban` int(3) NOT NULL,
            `asign` tinyint(1) NOT NULL DEFAULT '0',
            `jawaban` varchar(200) NOT NULL,
            `nilai` tinyint(4) NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`),
            KEY `id_indikator` (`id_indikator`)
           )");

        $this->db->query("CREATE TABLE IF NOT EXISTS `analisis_partisipasi` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `id_subjek` int(11) NOT NULL,
            `id_master` int(11) NOT NULL,
            `id_periode` int(11) NOT NULL,
            `id_klassifikasi` int(11) NOT NULL DEFAULT '1',
            PRIMARY KEY (`id`),
            KEY `id_subjek` (`id_subjek`,`id_master`,`id_periode`,`id_klassifikasi`),
            KEY `id_master` (`id_master`),
            KEY `id_periode` (`id_periode`),
            KEY `id_klassifikasi` (`id_klassifikasi`)
           )");

        $this->db->query("CREATE TABLE IF NOT EXISTS `analisis_periode` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `id_master` int(11) NOT NULL,
            `nama` varchar(50) NOT NULL,
            `id_state` tinyint(4) NOT NULL DEFAULT '1',
            `aktif` tinyint(1) NOT NULL DEFAULT '0',
            `keterangan` varchar(100) NOT NULL,
            `tahun_pelaksanaan` year(4) NOT NULL,
            PRIMARY KEY (`id`),
            KEY `id_master` (`id_master`),
            KEY `id_state` (`id_state`)
           )");

        $this->db->query('CREATE TABLE IF NOT EXISTS `analisis_ref_state` (
            `id` tinyint(4) NOT NULL AUTO_INCREMENT,
            `nama` varchar(40) NOT NULL,
            PRIMARY KEY (`id`)
           )');

        $this->db->query('CREATE TABLE IF NOT EXISTS `analisis_ref_subjek` (
            `id` tinyint(4) NOT NULL AUTO_INCREMENT,
            `subjek` varchar(20) NOT NULL,
            PRIMARY KEY (`id`)
           )');

        $this->db->query('CREATE TABLE IF NOT EXISTS `analisis_respon` (
            `id_indikator` int(11) NOT NULL,
            `id_parameter` int(11) NOT NULL,
            `id_subjek` int(11) NOT NULL,
            `id_periode` int(11) NOT NULL
           )');

        $this->db->query('CREATE TABLE IF NOT EXISTS `analisis_respon_bukti` (
            `id_master` tinyint(4) NOT NULL,
            `id_periode` tinyint(4) NOT NULL,
            `id_subjek` int(11) NOT NULL,
            `pengesahan` varchar(100) NOT NULL,
            `tgl_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
           )');

        $this->db->query('CREATE TABLE IF NOT EXISTS `analisis_respon_hasil` (
            `id_master` tinyint(4) NOT NULL,
            `id_periode` tinyint(4) NOT NULL,
            `id_subjek` int(11) NOT NULL,
            `akumulasi` double(8,3) NOT NULL,
            `tgl_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            UNIQUE KEY `id_master` (`id_master`,`id_periode`,`id_subjek`)
           )');

        $this->db->query('CREATE TABLE IF NOT EXISTS `analisis_tipe_indikator` (
            `id` tinyint(4) NOT NULL AUTO_INCREMENT,
            `tipe` varchar(20) NOT NULL,
            PRIMARY KEY (`id`)
           )');

        $this->db->query("CREATE TABLE IF NOT EXISTS `area` (
            `id` int(4) NOT NULL AUTO_INCREMENT,
            `nama` varchar(50) NOT NULL,
            `path` text NOT NULL,
            `enabled` int(11) NOT NULL DEFAULT '1',
            `ref_polygon` int(9) NOT NULL,
            `foto` varchar(100) NOT NULL,
            `id_cluster` int(11) NOT NULL,
            `desk` text NOT NULL,
            PRIMARY KEY (`id`)
           )");

        $this->db->query("CREATE TABLE IF NOT EXISTS `artikel` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `gambar` varchar(200) NOT NULL,
            `isi` text NOT NULL,
            `enabled` int(2) NOT NULL DEFAULT '1',
            `tgl_upload` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `id_kategori` int(4) NOT NULL,
            `id_user` int(4) NOT NULL,
            `judul` varchar(100) NOT NULL,
            `headline` int(1) NOT NULL DEFAULT '0',
            `gambar1` varchar(200) NOT NULL,
            `gambar2` varchar(200) NOT NULL,
            `gambar3` varchar(200) NOT NULL,
            `dokumen` varchar(400) NOT NULL,
            `link_dokumen` varchar(200) NOT NULL,
            PRIMARY KEY (`id`)
           )");

        $this->db->query('CREATE TABLE IF NOT EXISTS `config` (
            `id` int(5) NOT NULL AUTO_INCREMENT,
            `nama_desa` varchar(100) NOT NULL,
            `kode_desa` varchar(100) NOT NULL,
            `nama_kepala_desa` varchar(100) NOT NULL,
            `nip_kepala_desa` varchar(100) NOT NULL,
            `kode_pos` varchar(6) NOT NULL,
            `nama_kecamatan` varchar(100) NOT NULL,
            `kode_kecamatan` varchar(100) NOT NULL,
            `nama_kepala_camat` varchar(100) NOT NULL,
            `nip_kepala_camat` varchar(100) NOT NULL,
            `nama_kabupaten` varchar(100) NOT NULL,
            `kode_kabupaten` varchar(100) NOT NULL,
            `nama_propinsi` varchar(100) NOT NULL,
            `kode_propinsi` varchar(100) NOT NULL,
            `logo` varchar(100) NOT NULL,
            `lat` varchar(20) NOT NULL,
            `lng` varchar(20) NOT NULL,
            `zoom` tinyint(4) NOT NULL,
            `map_tipe` varchar(20) NOT NULL,
            `path` text NOT NULL,
            `alamat_kantor` varchar(200) DEFAULT NULL,
            `g_analytic` varchar(200) NOT NULL,
            `regid` varchar(60) NOT NULL,
            `macid` varchar(60) NOT NULL,
            `email_desa` varchar(100) NOT NULL,
            `gapi_key` varchar(100) NOT NULL,
            PRIMARY KEY (`id`)
           )');

        $this->db->query("CREATE TABLE IF NOT EXISTS `data_persil` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nik` varchar(64) NOT NULL,
            `nama` varchar(128) NOT NULL COMMENT 'nomer persil',
            `persil_jenis_id` tinyint(2) NOT NULL,
            `id_clusterdesa` varchar(64) NOT NULL,
            `alamat_ext` varchar(64) NOT NULL,
            `luas` decimal(7,2) NOT NULL,
            `kelas` varchar(128) DEFAULT NULL,
            `peta` text,
            `no_sppt_pbb` varchar(128) NOT NULL,
            `persil_peruntukan_id` tinyint(2) NOT NULL,
            `rdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `userID` int(11) NOT NULL,
            PRIMARY KEY (`id`),
            KEY `nik` (`nik`)
           )");

        $this->db->query('CREATE TABLE IF NOT EXISTS `data_persil_jenis` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nama` varchar(128) NOT NULL,
            `ndesc` text NOT NULL,
            PRIMARY KEY (`id`)
           )');

        $this->db->query("CREATE TABLE IF NOT EXISTS `data_persil_log` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `persil_id` int(11) NOT NULL,
            `persil_transaksi_jenis` tinyint(2) NOT NULL,
            `pemilik_lama` varchar(24) NOT NULL,
            `pemilik_baru` varchar(24) NOT NULL,
            `rdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `user_id` int(11) NOT NULL,
            PRIMARY KEY (`id`)
           ) COMMENT='Tabel untuk menyimpan catatan transaksi atas data persil'");

        $this->db->query('CREATE TABLE IF NOT EXISTS `data_persil_peruntukan` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nama` varchar(128) NOT NULL,
            `ndesc` text NOT NULL,
            PRIMARY KEY (`id`)
           )');

        $this->db->query('CREATE TABLE IF NOT EXISTS `detail_log_penduduk` (
            `id` int(10) NOT NULL,
            `nama` varchar(50) NOT NULL
           )');

        $this->db->query("CREATE TABLE IF NOT EXISTS `dokumen` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `id_pend` int(11) NOT NULL DEFAULT '0',
            `satuan` varchar(200) NOT NULL,
            `nama` varchar(50) NOT NULL,
            `enabled` int(2) NOT NULL DEFAULT '1',
            `tgl_upload` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
           )");

        $this->db->query("CREATE TABLE IF NOT EXISTS `gambar_gallery` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `parrent` int(4) NOT NULL,
            `gambar` varchar(200) NOT NULL,
            `nama` varchar(50) NOT NULL,
            `enabled` int(2) NOT NULL DEFAULT '1',
            `tgl_upload` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `tipe` int(4) NOT NULL,
            PRIMARY KEY (`id`),
            KEY `parrent` (`parrent`)
           )");

        $this->db->query("CREATE TABLE IF NOT EXISTS `garis` (
            `id` int(4) NOT NULL AUTO_INCREMENT,
            `nama` varchar(50) NOT NULL,
            `path` text NOT NULL,
            `enabled` int(11) NOT NULL DEFAULT '1',
            `ref_line` int(9) NOT NULL,
            `foto` varchar(100) NOT NULL,
            `desk` text NOT NULL,
            `id_cluster` int(11) NOT NULL,
            PRIMARY KEY (`id`)
           )");

        $this->db->query('CREATE TABLE IF NOT EXISTS `gis_simbol` (
            `simbol` varchar(40) DEFAULT NULL
           )');

        $this->db->query("CREATE TABLE IF NOT EXISTS `inbox` (
            `UpdatedInDB` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `ReceivingDateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `Text` text NOT NULL,
            `SenderNumber` varchar(20) NOT NULL DEFAULT '',
            `Coding` enum('Default_No_Compression','Unicode_No_Compression','8bit','Default_Compression','Unicode_Compression') NOT NULL DEFAULT 'Default_No_Compression',
            `UDH` text NOT NULL,
            `SMSCNumber` varchar(20) NOT NULL DEFAULT '',
            `Class` int(11) NOT NULL DEFAULT '-1',
            `TextDecoded` text NOT NULL,
            `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `RecipientID` text NOT NULL,
            `Processed` enum('false','true') NOT NULL DEFAULT 'false',
            PRIMARY KEY (`ID`)
           )");

        $this->db->query("CREATE TABLE IF NOT EXISTS `kategori` (
            `id` int(5) NOT NULL AUTO_INCREMENT,
            `kategori` varchar(100) NOT NULL,
            `tipe` int(4) NOT NULL DEFAULT '1',
            `urut` tinyint(4) NOT NULL,
            `enabled` tinyint(4) NOT NULL,
            `parrent` tinyint(4) NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`)
           )");

        $this->db->query('CREATE TABLE IF NOT EXISTS `kelompok` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `id_master` int(11) NOT NULL,
            `id_ketua` int(11) NOT NULL,
            `kode` varchar(16) NOT NULL,
            `nama` varchar(50) NOT NULL,
            `keterangan` varchar(100) NOT NULL,
            PRIMARY KEY (`id`),
            KEY `id_ketua` (`id_ketua`),
            KEY `id_master` (`id_master`)
           )');

        $this->db->query('CREATE TABLE IF NOT EXISTS `kelompok_anggota` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `id_kelompok` int(11) NOT NULL,
            `id_penduduk` int(11) NOT NULL,
            `no_anggota` varchar(20) NOT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `id_kelompok` (`id_kelompok`,`id_penduduk`)
           )');

        $this->db->query('CREATE TABLE IF NOT EXISTS `kelompok_master` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `kelompok` varchar(50) NOT NULL,
            `deskripsi` varchar(400) NOT NULL,
            PRIMARY KEY (`id`)
           )');

        $this->db->query("CREATE TABLE IF NOT EXISTS `komentar` (
            `id` int(5) NOT NULL AUTO_INCREMENT,
            `id_artikel` int(7) NOT NULL,
            `owner` varchar(50) NOT NULL,
            `email` varchar(50) NOT NULL,
            `komentar` text NOT NULL,
            `tgl_upload` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `enabled` int(2) NOT NULL DEFAULT '2',
            PRIMARY KEY (`id`)
           )");

        $this->db->query('CREATE TABLE IF NOT EXISTS `kontak` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `id_pend` int(11) DEFAULT NULL,
            `no_hp` varchar(15) DEFAULT NULL,
            PRIMARY KEY (`id`)
           )');

        $this->db->query('CREATE TABLE IF NOT EXISTS `kontak_grup` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nama_grup` varchar(30) NOT NULL,
            `id_kontak` int(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
           )');

        $this->db->query("CREATE TABLE IF NOT EXISTS `line` (
            `id` int(4) NOT NULL AUTO_INCREMENT,
            `nama` varchar(50) NOT NULL,
            `simbol` varchar(50) NOT NULL,
            `color` varchar(10) NOT NULL DEFAULT 'ff0000',
            `tipe` int(4) NOT NULL,
            `parrent` int(4) DEFAULT '1',
            `enabled` int(11) NOT NULL DEFAULT '1',
            PRIMARY KEY (`id`),
            KEY `parrent` (`parrent`)
           )");

        $this->db->query('CREATE TABLE IF NOT EXISTS `log_bulanan` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `pend` int(11) NOT NULL,
            `lk` int(11) NOT NULL,
            `pr` int(11) NOT NULL,
            `kk` int(11) NOT NULL,
            `tgl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
           )');

        $this->db->query('CREATE TABLE IF NOT EXISTS `log_penduduk` (
            `id` int(10) NOT NULL AUTO_INCREMENT,
            `id_pend` int(11) NOT NULL,
            `id_detail` int(4) NOT NULL,
            `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `bulan` varchar(2) NOT NULL,
            `tahun` varchar(4) NOT NULL,
            `tgl_peristiwa` date NOT NULL,
            PRIMARY KEY (`id`)
           )');

        $this->db->query('CREATE TABLE IF NOT EXISTS `log_perubahan_penduduk` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `id_pend` int(11) NOT NULL,
            `id_cluster` varchar(200) NOT NULL,
            `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
           )');

        $this->db->query('CREATE TABLE IF NOT EXISTS `log_surat` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `id_format_surat` int(4) NOT NULL,
            `id_pend` int(11) NOT NULL,
            `id_pamong` int(4) NOT NULL,
            `id_user` int(4) NOT NULL,
            `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `bulan` varchar(2) DEFAULT NULL,
            `tahun` varchar(4) DEFAULT NULL,
            `no_surat` varchar(20) DEFAULT NULL,
            PRIMARY KEY (`id`)
           )');

        $this->db->query("CREATE TABLE IF NOT EXISTS `lokasi` (
            `id` int(4) NOT NULL AUTO_INCREMENT,
            `desk` text NOT NULL,
            `nama` varchar(50) NOT NULL,
            `enabled` int(11) NOT NULL DEFAULT '1',
            `lat` varchar(30) NOT NULL,
            `lng` varchar(30) NOT NULL,
            `ref_point` int(9) NOT NULL,
            `foto` varchar(100) NOT NULL,
            `id_cluster` int(11) NOT NULL,
            PRIMARY KEY (`id`),
            KEY `ref_point` (`ref_point`)
           )");

        $this->db->query('CREATE TABLE IF NOT EXISTS `media_sosial` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `gambar` text NOT NULL,
            `link` text NOT NULL,
            `nama` varchar(100) NOT NULL,
            `enabled` int(11) NOT NULL,
            PRIMARY KEY (`id`)
           )');

        $this->db->query("CREATE TABLE IF NOT EXISTS `menu` (
            `id` int(4) NOT NULL AUTO_INCREMENT,
            `nama` varchar(50) NOT NULL,
            `link` varchar(500) NOT NULL,
            `tipe` int(4) NOT NULL,
            `parrent` int(4) NOT NULL DEFAULT '1',
            `link_tipe` tinyint(1) NOT NULL DEFAULT '0',
            `enabled` int(11) NOT NULL DEFAULT '1',
            PRIMARY KEY (`id`)
           )");

        $this->db->query("CREATE TABLE IF NOT EXISTS `outbox` (
            `UpdatedInDB` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `InsertIntoDB` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `SendingDateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `SendBefore` time NOT NULL DEFAULT '23:59:59',
            `SendAfter` time NOT NULL DEFAULT '00:00:00',
            `Text` text,
            `DestinationNumber` varchar(20) NOT NULL DEFAULT '',
            `Coding` enum('Default_No_Compression','Unicode_No_Compression','8bit','Default_Compression','Unicode_Compression') NOT NULL DEFAULT 'Default_No_Compression',
            `UDH` text,
            `Class` int(11) DEFAULT '-1',
            `TextDecoded` text NOT NULL,
            `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `MultiPart` enum('false','true') DEFAULT 'false',
            `RelativeValidity` int(11) DEFAULT '-1',
            `SenderID` varchar(255) DEFAULT NULL,
            `SendingTimeOut` timestamp NULL DEFAULT '0000-00-00 00:00:00',
            `DeliveryReport` enum('default','yes','no') DEFAULT 'default',
            `CreatorID` text NOT NULL,
            PRIMARY KEY (`ID`),
            KEY `outbox_date` (`SendingDateTime`,`SendingTimeOut`),
            KEY `outbox_sender` (`SenderID`)
           )");

        $this->db->query("CREATE TABLE IF NOT EXISTS `point` (
            `id` int(4) NOT NULL AUTO_INCREMENT,
            `nama` varchar(50) NOT NULL,
            `simbol` varchar(50) NOT NULL,
            `tipe` int(4) NOT NULL,
            `parrent` int(4) NOT NULL DEFAULT '1',
            `enabled` int(11) NOT NULL DEFAULT '1',
            PRIMARY KEY (`id`),
            KEY `parrent` (`parrent`)
           )");

        $this->db->query("CREATE TABLE IF NOT EXISTS `polygon` (
            `id` int(4) NOT NULL AUTO_INCREMENT,
            `nama` varchar(50) NOT NULL,
            `simbol` varchar(50) NOT NULL,
            `color` varchar(10) NOT NULL DEFAULT 'ff0000',
            `tipe` int(4) NOT NULL,
            `parrent` int(4) DEFAULT '1',
            `enabled` int(11) NOT NULL DEFAULT '1',
            PRIMARY KEY (`id`),
            KEY `parrent` (`parrent`)
           )");

        $this->db->query("CREATE TABLE IF NOT EXISTS `program` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nama` varchar(256) NOT NULL,
            `ndesc` text NOT NULL,
            `sasaran` tinyint(1) NOT NULL DEFAULT '0',
            `sdate` datetime NOT NULL,
            `edate` datetime NOT NULL,
            `userID` int(11) NOT NULL,
            `rdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `status` tinyint(1) NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`)
           )");

        $this->db->query('CREATE TABLE IF NOT EXISTS `program_peserta` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `program_id` int(11) NOT NULL,
            `peserta` decimal(18,0) NOT NULL,
            `sasaran` tinyint(1) NOT NULL,
            `userID` int(11) NOT NULL,
            `rdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
           )');

        $this->db->query("CREATE TABLE IF NOT EXISTS `sentitems` (
            `UpdatedInDB` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `InsertIntoDB` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `SendingDateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
            `DeliveryDateTime` timestamp NULL DEFAULT NULL,
            `Text` text NOT NULL,
            `DestinationNumber` varchar(20) NOT NULL DEFAULT '',
            `Coding` enum('Default_No_Compression','Unicode_No_Compression','8bit','Default_Compression','Unicode_Compression') NOT NULL DEFAULT 'Default_No_Compression',
            `UDH` text NOT NULL,
            `SMSCNumber` varchar(20) NOT NULL DEFAULT '',
            `Class` int(11) NOT NULL DEFAULT '-1',
            `TextDecoded` text NOT NULL,
            `ID` int(10) unsigned NOT NULL DEFAULT '0',
            `SenderID` varchar(255) NOT NULL,
            `SequencePosition` int(11) NOT NULL DEFAULT '1',
            `Status` enum('SendingOK','SendingOKNoReport','SendingError','DeliveryOK','DeliveryFailed','DeliveryPending','DeliveryUnknown','Error') NOT NULL DEFAULT 'SendingOK',
            `StatusError` int(11) NOT NULL DEFAULT '-1',
            `TPMR` int(11) NOT NULL DEFAULT '-1',
            `RelativeValidity` int(11) NOT NULL DEFAULT '-1',
            `CreatorID` text NOT NULL,
            PRIMARY KEY (`ID`,`SequencePosition`),
            KEY `sentitems_date` (`DeliveryDateTime`),
            KEY `sentitems_tpmr` (`TPMR`),
            KEY `sentitems_dest` (`DestinationNumber`),
            KEY `sentitems_sender` (`SenderID`)
           )");

        $this->db->query("CREATE TABLE IF NOT EXISTS `setting_modul` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `modul` varchar(50) NOT NULL,
            `url` varchar(50) NOT NULL,
            `aktif` tinyint(1) NOT NULL DEFAULT '0',
            `ikon` varchar(50) NOT NULL,
            `urut` tinyint(4) NOT NULL,
            `level` tinyint(1) NOT NULL DEFAULT '2',
            `hidden` tinyint(1) NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`)
           )");

        $this->db->query('CREATE TABLE IF NOT EXISTS `setting_sms` (
            `autoreply_text` varchar(160) DEFAULT NULL
           )');

        $this->db->query('CREATE TABLE IF NOT EXISTS `sys_traffic` (
            `Tanggal` date NOT NULL,
            `ipAddress` text NOT NULL,
            `Jumlah` int(10) NOT NULL,
            PRIMARY KEY (`Tanggal`)
           )');

        $this->db->query('CREATE TABLE IF NOT EXISTS `tweb_alamat_sekarang` (
            `id` int(11) NOT NULL,
            `jalan` varchar(100) NOT NULL,
            `rt` varchar(100) NOT NULL,
            `rw` varchar(100) NOT NULL,
            `dusun` varchar(100) NOT NULL,
            `desa` varchar(100) NOT NULL,
            `kecamatan` varchar(100) NOT NULL,
            `kabupaten` varchar(100) NOT NULL,
            `provinsi` varchar(100) NOT NULL
           )');

        $this->db->query('CREATE TABLE IF NOT EXISTS `tweb_cacat` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `nama` varchar(100) NOT NULL,
            PRIMARY KEY (`id`)
           )');

        $this->db->query("CREATE TABLE IF NOT EXISTS `tweb_desa_pamong` (
            `pamong_id` int(5) NOT NULL AUTO_INCREMENT,
            `pamong_nama` varchar(100) DEFAULT NULL,
            `pamong_nip` varchar(20) DEFAULT NULL,
            `pamong_nik` varchar(20) DEFAULT NULL,
            `jabatan` varchar(50) DEFAULT '0',
            `pamong_status` varchar(45) DEFAULT NULL,
            `pamong_tgl_terdaftar` date DEFAULT NULL,
            PRIMARY KEY (`pamong_id`)
           )");

        $this->db->query('CREATE TABLE IF NOT EXISTS `tweb_golongan_darah` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nama` varchar(15) DEFAULT NULL,
            PRIMARY KEY (`id`)
           )');

        $this->db->query("CREATE TABLE IF NOT EXISTS `tweb_keluarga` (
            `id` int(10) NOT NULL AUTO_INCREMENT,
            `no_kk` varchar(160) DEFAULT NULL,
            `nik_kepala` varchar(200) DEFAULT NULL,
            `tgl_daftar` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            `kelas_sosial` int(4) DEFAULT NULL,
            `raskin` int(4) NOT NULL DEFAULT '2',
            `id_bedah_rumah` int(2) NOT NULL DEFAULT '2',
            `id_pkh` int(2) NOT NULL DEFAULT '2',
            `id_blt` int(2) NOT NULL DEFAULT '2',
            PRIMARY KEY (`id`),
            UNIQUE KEY `id` (`id`),
            UNIQUE KEY `no_kk` (`no_kk`)
           )");

        $this->db->query("CREATE TABLE IF NOT EXISTS `tweb_penduduk` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nama` varchar(100) NOT NULL,
            `nik` decimal(16,0) NOT NULL,
            `id_kk` int(11) DEFAULT '0',
            `kk_level` tinyint(2) NOT NULL DEFAULT '0',
            `id_rtm` int(11) NOT NULL,
            `rtm_level` int(11) NOT NULL,
            `sex` tinyint(4) unsigned DEFAULT NULL,
            `tempatlahir` varchar(100) NOT NULL,
            `tanggallahir` date NOT NULL,
            `agama_id` int(10) unsigned NOT NULL,
            `pendidikan_kk_id` int(10) unsigned NOT NULL,
            `pendidikan_id` int(10) unsigned NOT NULL,
            `pendidikan_sedang_id` int(10) unsigned NOT NULL,
            `pekerjaan_id` int(10) unsigned NOT NULL,
            `status_kawin` tinyint(4) unsigned NOT NULL,
            `warganegara_id` int(10) unsigned NOT NULL,
            `dokumen_pasport` varchar(45) DEFAULT NULL,
            `dokumen_kitas` varchar(20) DEFAULT NULL,
            `ayah_nik` varchar(16) NOT NULL,
            `ibu_nik` varchar(16) NOT NULL,
            `nama_ayah` varchar(100) NOT NULL,
            `nama_ibu` varchar(100) NOT NULL,
            `foto` varchar(100) NOT NULL,
            `golongan_darah_id` int(11) NOT NULL,
            `id_cluster` int(11) NOT NULL,
            `status` int(10) unsigned DEFAULT NULL,
            `alamat_sebelumnya` varchar(200) NOT NULL,
            `alamat_sekarang` varchar(200) NOT NULL,
            `status_dasar` tinyint(4) NOT NULL DEFAULT '1',
            `hamil` int(1) DEFAULT NULL,
            `cacat_id` int(11) DEFAULT NULL,
            `sakit_menahun_id` int(11) NOT NULL,
            `jamkesmas` int(11) NOT NULL DEFAULT '2',
            `akta_lahir` varchar(40) NOT NULL,
            `akta_perkawinan` varchar(40) NOT NULL,
            `tanggalperkawinan` date NOT NULL,
            `akta_perceraian` varchar(40) NOT NULL,
            `tanggalperceraian` date NOT NULL,
            PRIMARY KEY (`id`)
           )");

        $this->db->query('CREATE TABLE IF NOT EXISTS `tweb_penduduk_agama` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `nama` varchar(100) NOT NULL,
            PRIMARY KEY (`id`)
           )');

        $this->db->query('CREATE TABLE IF NOT EXISTS `tweb_penduduk_hubungan` (
            `id` int(10) NOT NULL AUTO_INCREMENT,
            `nama` varchar(100) NOT NULL,
            PRIMARY KEY (`id`)
           )');

        $this->db->query('CREATE TABLE IF NOT EXISTS `tweb_penduduk_kawin` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `nama` varchar(100) NOT NULL,
            PRIMARY KEY (`id`)
           )');

        $this->db->query('CREATE TABLE IF NOT EXISTS `tweb_penduduk_mandiri` (
            `nik` varchar(20) NOT NULL,
            `pin` varchar(60) NOT NULL,
            `tanggal_buat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `last_login` datetime NOT NULL,
            UNIQUE KEY `nik` (`nik`)
           )');

        $this->db->query('CREATE TABLE IF NOT EXISTS `tweb_penduduk_map` (
            `id` int(11) NOT NULL,
            `lat` varchar(24) NOT NULL,
            `lng` varchar(24) NOT NULL
           )');

        $this->db->query('CREATE TABLE IF NOT EXISTS `tweb_penduduk_pekerjaan` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `nama` varchar(100) DEFAULT NULL,
            PRIMARY KEY (`id`)
           )');

        $this->db->query('CREATE TABLE IF NOT EXISTS `tweb_penduduk_pendidikan` (
            `id` tinyint(3) NOT NULL AUTO_INCREMENT,
            `nama` varchar(50) NOT NULL,
            PRIMARY KEY (`id`)
           )');

        $this->db->query('CREATE TABLE IF NOT EXISTS `tweb_penduduk_pendidikan_kk` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `nama` varchar(50) NOT NULL,
            PRIMARY KEY (`id`)
           )');

        $this->db->query('CREATE TABLE IF NOT EXISTS `tweb_penduduk_sex` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `nama` varchar(15) DEFAULT NULL,
            PRIMARY KEY (`id`)
           )');

        $this->db->query('CREATE TABLE IF NOT EXISTS `tweb_penduduk_status` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `nama` varchar(50) DEFAULT NULL,
            PRIMARY KEY (`id`)
           )');

        $this->db->query('CREATE TABLE IF NOT EXISTS `tweb_penduduk_umur` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nama` varchar(25) DEFAULT NULL,
            `dari` int(11) DEFAULT NULL,
            `sampai` int(11) DEFAULT NULL,
            `status` int(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
           )');

        $this->db->query('CREATE TABLE IF NOT EXISTS `tweb_penduduk_warganegara` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `nama` varchar(25) DEFAULT NULL,
            PRIMARY KEY (`id`)
           )');

        $this->db->query('CREATE TABLE IF NOT EXISTS `tweb_rtm` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nik_kepala` int(11) NOT NULL,
            `no_kk` varchar(20) NOT NULL,
            `tgl_daftar` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `kelas_sosial` int(11) NOT NULL,
            PRIMARY KEY (`id`)
           )');

        $this->db->query('CREATE TABLE IF NOT EXISTS `tweb_rtm_hubungan` (
            `id` tinyint(4) NOT NULL AUTO_INCREMENT,
            `nama` varchar(20) NOT NULL,
            PRIMARY KEY (`id`)
           )');

        $this->db->query('CREATE TABLE IF NOT EXISTS `tweb_sakit_menahun` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nama` varchar(255) NOT NULL,
            PRIMARY KEY (`id`)
           )');

        $this->db->query('CREATE TABLE IF NOT EXISTS `tweb_status_dasar` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `nama` varchar(50) DEFAULT NULL,
            PRIMARY KEY (`id`)
           )');

        $this->db->query('CREATE TABLE IF NOT EXISTS `tweb_surat_atribut` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `id_surat` int(11) NOT NULL,
            `id_tipe` tinyint(4) NOT NULL,
            `nama` varchar(40) NOT NULL,
            `long` tinyint(4) NOT NULL,
            `kode` tinyint(4) NOT NULL,
            PRIMARY KEY (`id`)
           )');

        $this->db->query("CREATE TABLE IF NOT EXISTS `tweb_surat_format` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nama` varchar(100) NOT NULL,
            `url_surat` varchar(100) NOT NULL,
            `kode_surat` varchar(10) NOT NULL,
            `kunci` tinyint(1) NOT NULL DEFAULT '0',
            `favorit` tinyint(1) NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`)
           )");

        $this->db->query("CREATE TABLE IF NOT EXISTS `tweb_wil_clusterdesa` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `rt` varchar(10) NOT NULL DEFAULT '0',
            `rw` varchar(10) NOT NULL DEFAULT '0',
            `dusun` varchar(50) NOT NULL DEFAULT '0',
            `id_kepala` int(11) NOT NULL,
            `lat` varchar(20) NOT NULL,
            `lng` varchar(20) NOT NULL,
            `zoom` int(5) NOT NULL,
            `path` text NOT NULL,
            `map_tipe` varchar(20) NOT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `rt` (`rt`,`rw`,`dusun`),
            KEY `id_kepala` (`id_kepala`)
           )");

        $this->db->query("CREATE TABLE IF NOT EXISTS `user` (
            `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
            `username` varchar(100) NOT NULL,
            `password` varchar(40) NOT NULL,
            `id_grup` int(5) NOT NULL,
            `email` varchar(100) NOT NULL,
            `last_login` datetime NOT NULL,
            `active` tinyint(1) unsigned DEFAULT '0',
            `nama` varchar(50) DEFAULT NULL,
            `company` varchar(100) DEFAULT NULL,
            `phone` varchar(20) DEFAULT NULL,
            `foto` varchar(100) NOT NULL,
            `session` varchar(40) NOT NULL,
            PRIMARY KEY (`id`)
           )");

        $this->db->query('CREATE TABLE IF NOT EXISTS `user_grup` (
            `id` tinyint(4) NOT NULL,
            `nama` varchar(20) NOT NULL,
            PRIMARY KEY (`id`)
           )');

        $seeder = \Config\Database::seeder();
        $seeder->call('Init');
    }

    public function down()
    {
        $this->forge->dropTable('analisis_indikator', true);
        $this->forge->dropTable('analisis_kategori_indikator', true);
        $this->forge->dropTable('analisis_klasifikasi', true);
        $this->forge->dropTable('analisis_master', true);
        $this->forge->dropTable('analisis_parameter', true);
        $this->forge->dropTable('analisis_partisipasi', true);
        $this->forge->dropTable('analisis_periode', true);
        $this->forge->dropTable('analisis_ref_state', true);
        $this->forge->dropTable('analisis_ref_subjek', true);
        $this->forge->dropTable('analisis_respon', true);
        $this->forge->dropTable('analisis_respon_bukti', true);
        $this->forge->dropTable('analisis_respon_hasil', true);
        $this->forge->dropTable('analisis_tipe_indikator', true);
        $this->forge->dropTable('area', true);
        $this->forge->dropTable('artikel', true);
        $this->forge->dropTable('config', true);
        $this->forge->dropTable('data_persil', true);
        $this->forge->dropTable('data_persil_jenis', true);
        $this->forge->dropTable('data_persil_log', true);
        $this->forge->dropTable('data_persil_peruntukan', true);
        $this->forge->dropTable('detail_log_penduduk', true);
        $this->forge->dropTable('dokumen', true);
        $this->forge->dropTable('gambar_gallery', true);
        $this->forge->dropTable('garis', true);
        $this->forge->dropTable('gis_simbol', true);
        $this->forge->dropTable('inbox', true);
        $this->forge->dropTable('kategori', true);
        $this->forge->dropTable('kelompok', true);
        $this->forge->dropTable('kelompok_anggota', true);
        $this->forge->dropTable('kelompok_master', true);
        $this->forge->dropTable('komentar', true);
        $this->forge->dropTable('kontak', true);
        $this->forge->dropTable('kontak_grup', true);
        $this->forge->dropTable('line', true);
        $this->forge->dropTable('log_bulanan', true);
        $this->forge->dropTable('log_penduduk', true);
        $this->forge->dropTable('log_perubahan_penduduk', true);
        $this->forge->dropTable('log_surat', true);
        $this->forge->dropTable('lokasi', true);
        $this->forge->dropTable('media_sosial', true);
        $this->forge->dropTable('menu', true);
        $this->forge->dropTable('outbox', true);
        $this->forge->dropTable('point', true);
        $this->forge->dropTable('polygon', true);
        $this->forge->dropTable('program', true);
        $this->forge->dropTable('program_peserta', true);
        $this->forge->dropTable('sentitems', true);
        $this->forge->dropTable('setting_modul', true);
        $this->forge->dropTable('setting_sms', true);
        $this->forge->dropTable('sys_traffic', true);
        $this->forge->dropTable('tweb_alamat_sekarang', true);
        $this->forge->dropTable('tweb_cacat', true);
        $this->forge->dropTable('tweb_desa_pamong', true);
        $this->forge->dropTable('tweb_golongan_darah', true);
        $this->forge->dropTable('tweb_keluarga', true);
        $this->forge->dropTable('tweb_penduduk', true);
        $this->forge->dropTable('tweb_penduduk_agama', true);
        $this->forge->dropTable('tweb_penduduk_hubungan', true);
        $this->forge->dropTable('tweb_penduduk_kawin', true);
        $this->forge->dropTable('tweb_penduduk_mandiri', true);
        $this->forge->dropTable('tweb_penduduk_map', true);
        $this->forge->dropTable('tweb_penduduk_pekerjaan', true);
        $this->forge->dropTable('tweb_penduduk_pendidikan', true);
        $this->forge->dropTable('tweb_penduduk_pendidikan_kk', true);
        $this->forge->dropTable('tweb_penduduk_sex', true);
        $this->forge->dropTable('tweb_penduduk_status', true);
        $this->forge->dropTable('tweb_penduduk_umur', true);
        $this->forge->dropTable('tweb_penduduk_warganegara', true);
        $this->forge->dropTable('tweb_rtm', true);
        $this->forge->dropTable('tweb_rtm_hubungan', true);
        $this->forge->dropTable('tweb_sakit_menahun', true);
        $this->forge->dropTable('tweb_status_dasar', true);
        $this->forge->dropTable('tweb_surat_atribut', true);
        $this->forge->dropTable('tweb_surat_format', true);
        $this->forge->dropTable('tweb_wil_clusterdesa', true);
        $this->forge->dropTable('user', true);
        $this->forge->dropTable('user_grup', true);
    }
}
