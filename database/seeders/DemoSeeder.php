<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run()
    {
        // USER
        DB::table('user')->insert([
        [ 'id_user' => 1,
            'nama' => 'Super Admin',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => 'superadmin',
        ],
        [
        'id_user' => 2,
        'nama' => 'Petugas',
        'username' => 'petugas',
        'password' => Hash::make('petugas123'),
        'role' => 'petugas',
        ],

        ]);


        // BIDANG
        DB::table('bidang_pegawai')->insert([
            'id_bidang' => 1,
            'sub_bidang' => 'Bendahara',
            'bidang' => 'Bendahara',
        ]);

        // RUANGAN
        DB::table('ruangan')->insert([
            'id_ruangan' => 1,
            'nama_ruangan' => 'RUANG SKPD TP',
        ]);

        // SARANA
        DB::table('data_sarana')->insert([
            'id_sarana' => 1,
            'nama_sarana' => 'Kursi',
            'jenis_sarana' => 'non-elektronik',
            'jumlah' => 30,
            'id_ruangan' => 1,
        ]);

        // GAMBAR
        DB::table('gambar_ruangan')->insert([
            'id_gambar' => 1,
            'id_ruangan' => 1,
            'nama_file' => 'ruang_skpd_tp_1.jpg',
        ]);

        // FAQ
        DB::table('faq')->insert([
            'id' => 1,
            'pertanyaan' => 'Bagaimana cara membatalkan peminjaman?',
            'jawaban' => 'Pembatalan dapat dilakukan melalui sistem sebelum jadwal berlangsung.',
        ]);

        // TRANSAKSI
        DB::table('transaksi')->insert([
            'id_peminjaman' => 1,
            'waktu_mulai' => '2026-01-10 09:00:00',
            'waktu_selesai' => '2026-01-10 11:00:00',
            'acara' => 'Rapat Koordinasi',
            'catatan' => 'Koordinasi internal',
            'status_peminjaman' => 'Disetujui',
            'jumlah_peserta' => 15,
            'id_bidang' => 1,
            'id_ruangan' => 1,
            'id_user' => 1,
            'no_wa' => '0892311111',
        ]);
    }
}