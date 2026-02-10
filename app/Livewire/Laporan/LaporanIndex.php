<?php

namespace App\Livewire\Laporan;

use Livewire\Component;
use App\Models\Laporan;
use App\Models\Apar;
use App\Models\Inspeksi;

class LaporanIndex extends Component
{
    public $selectedMonth;
    public $selectedYear;

    public function mount()
    {
        $this->selectedMonth = now()->month;
        $this->selectedYear = now()->year;
    }

    public function generateReport()
    {
        Laporan::generateMonthlyReport($this->selectedMonth, $this->selectedYear);
        session()->flash('message', 'Laporan berhasil di-generate.');
    }

    public function render()
    {
        // Current stats
        $totalApar = Apar::count();
        $aparByStatus = [
            'aktif' => Apar::where('status', 'aktif')->count(),
            'rusak' => Apar::where('status', 'rusak')->count(),
            'expired' => Apar::where('status', 'expired')->count(),
            'maintenance' => Apar::where('status', 'maintenance')->count(),
        ];

        $inspeksiThisMonth = Inspeksi::whereMonth('tanggal_inspeksi', now()->month)
            ->whereYear('tanggal_inspeksi', now()->year)->count();

        $complianceRate = $totalApar > 0 ? round(($inspeksiThisMonth / $totalApar) * 100, 1) : 0;

        $laporanList = Laporan::orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->take(12)
            ->get();

        return view('livewire.laporan.laporan-index', [
            'totalApar' => $totalApar,
            'aparByStatus' => $aparByStatus,
            'inspeksiThisMonth' => $inspeksiThisMonth,
            'complianceRate' => $complianceRate,
            'laporanList' => $laporanList,
        ])->layout('layouts.app', ['title' => 'Laporan']);
    }
}
