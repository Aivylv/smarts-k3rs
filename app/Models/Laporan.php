<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';
    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'id_user',
        'bulan',
        'tahun',
        'total_apar',
        'total_inspeksi',
        'apar_baik',
        'apar_rusak',
        'apar_expired',
        'apar_maintenance',
        'compliance_rate',
        'file_path',
        'status_laporan',
    ];

    protected $casts = [
        'compliance_rate' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Accessors
    public function getPeriodeAttribute(): string
    {
        $bulanNama = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        return $bulanNama[$this->bulan] . ' ' . $this->tahun;
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status_laporan', 'published');
    }

    public function scopeByPeriode($query, $bulan, $tahun)
    {
        return $query->where('bulan', $bulan)->where('tahun', $tahun);
    }

    // Methods
    public static function generateMonthlyReport(int $bulan, int $tahun): self
    {
        $totalApar = Apar::count();
        $aparBaik = Apar::where('status', 'aktif')->count();
        $aparRusak = Apar::where('status', 'rusak')->count();
        $aparExpired = Apar::where('status', 'expired')->count();
        $aparMaintenance = Apar::where('status', 'maintenance')->count();
        
        $totalInspeksi = Inspeksi::whereMonth('tanggal_inspeksi', $bulan)
            ->whereYear('tanggal_inspeksi', $tahun)
            ->count();

        $complianceRate = $totalApar > 0 
            ? round(($totalInspeksi / $totalApar) * 100, 2) 
            : 0;

        return self::updateOrCreate(
            ['bulan' => $bulan, 'tahun' => $tahun],
            [
                'id_user' => auth()->id(),
                'total_apar' => $totalApar,
                'total_inspeksi' => $totalInspeksi,
                'apar_baik' => $aparBaik,
                'apar_rusak' => $aparRusak,
                'apar_expired' => $aparExpired,
                'apar_maintenance' => $aparMaintenance,
                'compliance_rate' => $complianceRate,
            ]
        );
    }
}


