<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\JenisTiket;
use App\Models\BundlingTiket;
use App\Models\Informasi;
use App\Models\JadwalKunjungan;
use App\Models\KesanPengunjung;
use App\Models\Reservasi;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── USERS ──────────────────────────────────────────────
        $admin = User::updateOrCreate(['email' => 'admin@mleb.id'], [
            'name'     => 'Administrator MLEB',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
            'phone'    => '02187793000',
        ]);

        $pengunjung = User::updateOrCreate(['email' => 'budi@example.com'], [
            'name'     => 'Budi Santoso',
            'password' => Hash::make('password'),
            'role'     => 'pengunjung',
            'phone'    => '081234567890',
            'address'  => 'Jakarta Selatan',
        ]);

        // ── JENIS TIKET ────────────────────────────────────────
        $tiket = [
            ['kode'=>'ME','nama'=>'Museum Explore','deskripsi'=>'Jelajahi seluruh koleksi museum listrik dan energi dari zaman ke zaman. Cocok untuk semua kalangan.','harga_weekday'=>20000,'harga_weekend'=>25000,'ikon'=>'🏛️','urutan'=>1],
            ['kode'=>'5D','nama'=>'5D Theatre','deskripsi'=>'Rasakan pengalaman sinema 5 dimensi yang mendebarkan tentang dunia energi masa depan.','harga_weekday'=>30000,'harga_weekend'=>40000,'ikon'=>'🎬','urutan'=>2],
            ['kode'=>'VR','nama'=>'Virtual Reality','deskripsi'=>'Wisata virtual ke pembangkit listrik tenaga surya, angin, dan air menggunakan teknologi VR terkini.','harga_weekday'=>15000,'harga_weekend'=>15000,'ikon'=>'🥽','urutan'=>3],
            ['kode'=>'KP','nama'=>'Kids Playground','deskripsi'=>'Area bermain edukatif khusus anak-anak dengan permainan bertema energi yang menyenangkan.','harga_weekday'=>15000,'harga_weekend'=>15000,'ikon'=>'🎠','urutan'=>4],
            ['kode'=>'PB','nama'=>'Photo Box','deskripsi'=>'Abadikan momen bersama di photo box dengan latar belakang tema energi dan teknologi futuristik.','harga_weekday'=>35000,'harga_weekend'=>35000,'ikon'=>'📸','urutan'=>5],
            ['kode'=>'EG','nama'=>'Energy Guide','deskripsi'=>'Tur dipandu oleh pemandu berpengalaman yang akan menjelaskan secara detail setiap koleksi museum.','harga_weekday'=>50000,'harga_weekend'=>50000,'ikon'=>'🎙️','urutan'=>6],
        ];

        $tiketModels = [];
        foreach ($tiket as $t) {
            $tiketModels[$t['kode']] = JenisTiket::updateOrCreate(
                ['kode' => $t['kode']],
                array_merge($t, ['is_active' => true])
            );
        }

        // ── BUNDLING TIKET ─────────────────────────────────────
        $bundling1 = BundlingTiket::updateOrCreate(['nama' => 'Bundling 1'], [
            'deskripsi'       => 'Museum Explore + 5D Theatre. Paket terbaik untuk menikmati koleksi museum sekaligus pengalaman sinema 5D yang seru!',
            'harga_weekday'   => 45000,
            'harga_weekend'   => 55000,
            'badge_label'     => 'Paling Diminati',
            'is_active'       => true,
            'urutan'          => 1,
        ]);
        $bundling1->jenisTiket()->sync([
            $tiketModels['ME']->id,
            $tiketModels['5D']->id,
        ]);

        $bundling2 = BundlingTiket::updateOrCreate(['nama' => 'Bundling 2'], [
            'deskripsi'       => 'Museum Explore + 5D Theatre + VR / Kids Playground. Pilih antara VR atau Kids Playground sesuai usia pengunjung.',
            'harga_weekday'   => 60000,
            'harga_weekend'   => 70000,
            'badge_label'     => 'Hemat 10%',
            'is_active'       => true,
            'urutan'          => 2,
        ]);
        $bundling2->jenisTiket()->sync([
            $tiketModels['ME']->id,
            $tiketModels['5D']->id,
            $tiketModels['VR']->id,
            $tiketModels['KP']->id,
        ]);

        $bundling3 = BundlingTiket::updateOrCreate(['nama' => 'Bundling 3'], [
            'deskripsi'       => 'Museum Explore + 5D Theatre + VR + Kids Playground. Paket lengkap untuk pengalaman museum yang tak terlupakan!',
            'harga_weekday'   => 70000,
            'harga_weekend'   => 80000,
            'badge_label'     => 'Paket Lengkap',
            'is_active'       => true,
            'urutan'          => 3,
        ]);
        $bundling3->jenisTiket()->sync([
            $tiketModels['ME']->id,
            $tiketModels['5D']->id,
            $tiketModels['VR']->id,
            $tiketModels['KP']->id,
        ]);

        // ── JADWAL KUNJUNGAN ───────────────────────────────────
        $sesi = [
            ['nama_sesi'=>'Sesi Pagi',  'jam_mulai'=>'09:00','jam_selesai'=>'11:00','kuota_weekday'=>50,'kuota_weekend'=>80,'urutan'=>1],
            ['nama_sesi'=>'Sesi Siang', 'jam_mulai'=>'11:00','jam_selesai'=>'13:00','kuota_weekday'=>50,'kuota_weekend'=>80,'urutan'=>2],
            ['nama_sesi'=>'Sesi Sore',  'jam_mulai'=>'13:00','jam_selesai'=>'15:00','kuota_weekday'=>50,'kuota_weekend'=>80,'urutan'=>3],
            ['nama_sesi'=>'Sesi Sore 2','jam_mulai'=>'15:00','jam_selesai'=>'17:00','kuota_weekday'=>40,'kuota_weekend'=>60,'urutan'=>4],
        ];
        foreach ($sesi as $s) {
            JadwalKunjungan::updateOrCreate(['nama_sesi' => $s['nama_sesi']], array_merge($s, ['is_active' => true]));
        }

        // ── INFORMASI MUSEUM ───────────────────────────────────
        $infos = [
            ['judul'=>'Sejarah Museum','deskripsi'=>'Museum Listrik dan Energi Baru (MLEB) didirikan pada tahun 1997 sebagai pusat edukasi dan rekreasi yang menampilkan perkembangan teknologi kelistrikan dan energi baru terbarukan di Indonesia. Berlokasi di Taman Mini Indonesia Indah (TMII), museum ini telah menjadi salah satu destinasi wisata edukasi terpopuler yang dikunjungi ribuan pengunjung setiap tahunnya.','urutan'=>1],
            ['judul'=>'Koleksi Unggulan','deskripsi'=>'Museum memiliki lebih dari 200 koleksi unggulan mencakup peralatan pembangkit listrik dari masa ke masa, model turbin angin dan panel surya, replika pembangkit listrik tenaga air, serta berbagai perangkat elektronik bersejarah. Setiap koleksi dilengkapi penjelasan interaktif yang informatif.','urutan'=>2],
            ['judul'=>'Jam Operasional & Lokasi','deskripsi'=>'Museum buka setiap Selasa–Minggu pukul 09.00–17.00 WIB (tutup setiap Senin dan hari libur nasional tertentu). Berlokasi di kawasan Taman Mini Indonesia Indah (TMII), Jakarta Timur. Mudah dijangkau dengan kendaraan pribadi maupun transportasi umum.','urutan'=>3],
        ];
        foreach ($infos as $info) {
            Informasi::updateOrCreate(['judul' => $info['judul']], array_merge($info, ['is_active' => true, 'gambar' => null]));
        }

        // ── KESAN PENGUNJUNG (sample) ──────────────────────────
        $kesanData = [
            ['nama'=>'Rina S.','rating'=>5,'pesan'=>'Pengalaman luar biasa! Anak-anak sangat senang terutama di area 5D Theatre. Pemandu sangat ramah dan informatif.'],
            ['nama'=>'Pak Dodi','rating'=>5,'pesan'=>'Koleksinya lengkap dan sangat edukatif. Kami dari rombongan sekolah dan semua murid sangat antusias mengikuti tur.'],
            ['nama'=>'Keluarga Hendra','rating'=>4,'pesan'=>'Tempatnya bersih dan nyaman. Area Kids Playground sangat disukai si kecil. Pasti akan kembali lagi!'],
            ['nama'=>'Maya Putri','rating'=>5,'pesan'=>'Photo Box-nya keren banget! Hasilnya bagus dan jadi kenang-kenangan yang indah. Harganya juga terjangkau.'],
            ['nama'=>'Bu Siti','rating'=>4,'pesan'=>'Sistem reservasi online memudahkan kami yang datang dari luar kota. Terima kasih MLEB atas pelayanannya.'],
        ];

        foreach ($kesanData as $k) {
            KesanPengunjung::create([
                'user_id'     => $pengunjung->id,
                'reservasi_id'=> null,
                'nama_tampil' => $k['nama'],
                'rating'      => $k['rating'],
                'pesan'       => $k['pesan'],
                'is_visible'  => true,
            ]);
        }
    }
}
