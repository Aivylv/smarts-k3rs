<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lokasi;
use App\Models\Vendor;
use App\Models\Apar;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Vendors
        $vendors = [
            [
                'nama_vendor' => 'PT. Fire Safety Indonesia',
                'alamat' => 'Jl. Industri No. 123, Surabaya',
                'contact_person' => 'Budi Santoso',
                'phone' => '031-1234567',
                'email' => 'sales@firesafety.co.id',
                'is_active' => true,
            ],
            [
                'nama_vendor' => 'CV. Pemadam Jaya',
                'alamat' => 'Jl. Raya Darmo No. 45, Surabaya',
                'contact_person' => 'Ahmad Wijaya',
                'phone' => '031-7654321',
                'email' => 'info@pemadamjaya.com',
                'is_active' => true,
            ],
        ];

        foreach ($vendors as $vendor) {
            Vendor::firstOrCreate(
                ['nama_vendor' => $vendor['nama_vendor']],
                $vendor
            );
        }

        // Create Lokasi
        $lokasis = [
            ['nama_lokasi' => 'ICU Lantai 3', 'gedung' => 'Tower A', 'lantai' => '3', 'ruangan' => 'ICU 301', 'koordinat' => 'A3-ICU-01', 'kategori_risiko' => 'tinggi'],
            ['nama_lokasi' => 'UGD', 'gedung' => 'Tower A', 'lantai' => '1', 'ruangan' => 'UGD', 'koordinat' => 'A1-UGD-01', 'kategori_risiko' => 'tinggi'],
            ['nama_lokasi' => 'Koridor Lt.2', 'gedung' => 'Tower A', 'lantai' => '2', 'ruangan' => 'Koridor Utama', 'koordinat' => 'A2-KOR-01', 'kategori_risiko' => 'sedang'],
            ['nama_lokasi' => 'Lobby Utama', 'gedung' => 'Main Building', 'lantai' => '1', 'ruangan' => 'Lobby', 'koordinat' => 'M1-LOB-01', 'kategori_risiko' => 'sedang'],
            ['nama_lokasi' => 'Laboratorium', 'gedung' => 'Tower B', 'lantai' => '2', 'ruangan' => 'Lab Patologi', 'koordinat' => 'B2-LAB-01', 'kategori_risiko' => 'tinggi'],
            ['nama_lokasi' => 'Radiologi', 'gedung' => 'Tower B', 'lantai' => '1', 'ruangan' => 'Radiologi', 'koordinat' => 'B1-RAD-01', 'kategori_risiko' => 'tinggi'],
            ['nama_lokasi' => 'Farmasi', 'gedung' => 'Main Building', 'lantai' => '1', 'ruangan' => 'Farmasi', 'koordinat' => 'M1-FAR-01', 'kategori_risiko' => 'sedang'],
            ['nama_lokasi' => 'Kantor Administrasi', 'gedung' => 'Main Building', 'lantai' => '2', 'ruangan' => 'Admin', 'koordinat' => 'M2-ADM-01', 'kategori_risiko' => 'rendah'],
            ['nama_lokasi' => 'Ruang Operasi', 'gedung' => 'Tower A', 'lantai' => '4', 'ruangan' => 'OK 401', 'koordinat' => 'A4-OK-01', 'kategori_risiko' => 'tinggi'],
            ['nama_lokasi' => 'Cafetaria', 'gedung' => 'Main Building', 'lantai' => '1', 'ruangan' => 'Cafetaria', 'koordinat' => 'M1-CAF-01', 'kategori_risiko' => 'sedang'],
        ];

        foreach ($lokasis as $lokasi) {
            Lokasi::firstOrCreate(
                ['nama_lokasi' => $lokasi['nama_lokasi']],
                $lokasi
            );
        }

        // Create APAR (only if not already seeded)
        if (Apar::count() > 0) {
            return;
        }

        $aparTypes = ['powder', 'co2', 'foam', 'liquid'];
        $merks = ['YAMATO', 'GUNNEBO', 'CHUBB', 'SERVVO', 'FIRE STOP'];
        $kapasitas = [3.0, 4.5, 6.0, 9.0, 12.0];

        $lokasiIds = Lokasi::pluck('id_lokasi')->toArray();
        $vendorIds = Vendor::pluck('id_vendor')->toArray();

        for ($i = 1; $i <= 25; $i++) {
            $tipe = $aparTypes[array_rand($aparTypes)];
            $tanggalProduksi = now()->subMonths(rand(1, 48));
            $tanggalExpire = $tanggalProduksi->copy()->addYears(5);
            
            // Randomly mark some as expired or needing maintenance
            $status = 'aktif';
            if ($tanggalExpire->isPast()) {
                $status = 'expired';
            } elseif (rand(1, 10) > 8) {
                $status = rand(0, 1) ? 'rusak' : 'maintenance';
            }

            Apar::firstOrCreate(
                ['id_apar' => sprintf("APAR-2024-%04d", $i)],
                [
                    'kode_qr' => 'QR-' . strtoupper(substr(md5("APAR-$i"), 0, 12)),
                    'tipe_apar' => $tipe,
                    'kapasitas' => $kapasitas[array_rand($kapasitas)],
                    'merk' => $merks[array_rand($merks)],
                    'no_seri' => 'SN-' . strtoupper(substr(md5(rand()), 0, 8)),
                    'tanggal_produksi' => $tanggalProduksi,
                    'tanggal_pengisian' => $tanggalProduksi->copy()->addMonths(rand(0, 12)),
                    'tanggal_expire' => $tanggalExpire,
                    'id_lokasi' => $lokasiIds[array_rand($lokasiIds)],
                    'id_vendor' => $vendorIds[array_rand($vendorIds)],
                    'status' => $status,
                ]
            );
        }
    }
}
