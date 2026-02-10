<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Apar;
use App\Models\Inspeksi;
use App\Models\Maintenance;
use App\Models\Lokasi;

class Dashboard extends Component
{
    public $totalApar;
    public $aparAktif;
    public $aparRusak;
    public $aparExpired;
    public $aparMaintenance;
    public $inspeksiBulanIni;
    public $maintenancePending;
    public $complianceRate;
    public $recentInspeksi;
    public $upcomingMaintenance;
    public $aparByStatus;
    public $aparByTipe;
    public $expiringApar;

    public function mount()
    {
        $this->loadStatistics();
        $this->loadRecentData();
        $this->loadChartData();
    }

    public function loadStatistics()
    {
        $this->totalApar = Apar::count();
        $this->aparAktif = Apar::where('status', 'aktif')->count();
        $this->aparRusak = Apar::where('status', 'rusak')->count();
        $this->aparExpired = Apar::where('status', 'expired')->count();
        $this->aparMaintenance = Apar::where('status', 'maintenance')->count();

        $this->inspeksiBulanIni = Inspeksi::whereMonth('tanggal_inspeksi', now()->month)
            ->whereYear('tanggal_inspeksi', now()->year)
            ->count();

        $this->maintenancePending = Maintenance::whereIn('status', ['pending', 'in_progress'])->count();

        // Calculate compliance rate
        $this->complianceRate = $this->totalApar > 0 
            ? round(($this->inspeksiBulanIni / $this->totalApar) * 100, 1) 
            : 0;
    }

    public function loadRecentData()
    {
        $this->recentInspeksi = Inspeksi::with(['apar.lokasi', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $this->upcomingMaintenance = Maintenance::with(['apar.lokasi', 'teknisi'])
            ->whereIn('status', ['pending', 'in_progress'])
            ->orderBy('scheduled_date', 'asc')
            ->take(5)
            ->get();

        $this->expiringApar = Apar::with('lokasi')
            ->where('status', 'aktif')
            ->whereBetween('tanggal_expire', [now(), now()->addDays(30)])
            ->orderBy('tanggal_expire', 'asc')
            ->take(5)
            ->get();
    }

    public function loadChartData()
    {
        $this->aparByStatus = [
            ['status' => 'Aktif', 'count' => $this->aparAktif, 'color' => '#22c55e'],
            ['status' => 'Rusak', 'count' => $this->aparRusak, 'color' => '#ef4444'],
            ['status' => 'Expired', 'count' => $this->aparExpired, 'color' => '#f59e0b'],
            ['status' => 'Maintenance', 'count' => $this->aparMaintenance, 'color' => '#3b82f6'],
        ];

        $this->aparByTipe = Apar::selectRaw('tipe_apar, COUNT(*) as count')
            ->groupBy('tipe_apar')
            ->get()
            ->map(function ($item) {
                return [
                    'tipe' => strtoupper($item->tipe_apar),
                    'count' => $item->count,
                ];
            })
            ->toArray();
    }

    public function render()
    {
        return view('livewire.dashboard')
            ->layout('layouts.app', ['title' => 'Dashboard']);
    }
}
