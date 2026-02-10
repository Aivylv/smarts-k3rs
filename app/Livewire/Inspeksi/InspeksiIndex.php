<?php

namespace App\Livewire\Inspeksi;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Inspeksi;
use App\Models\Apar;

class InspeksiIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';
    public $filterMonth = '';
    public $filterYear = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'filterStatus' => ['except' => ''],
    ];

    public function mount()
    {
        $this->filterMonth = now()->month;
        $this->filterYear = now()->year;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Inspeksi::with(['apar.lokasi', 'user'])
            ->orderBy('tanggal_inspeksi', 'desc');

        if ($this->search) {
            $query->whereHas('apar', function ($q) {
                $q->where('id_apar', 'like', "%{$this->search}%")
                  ->orWhereHas('lokasi', function ($lq) {
                      $lq->where('nama_lokasi', 'like', "%{$this->search}%");
                  });
            });
        }

        if ($this->filterStatus) {
            $query->where('overall_status', $this->filterStatus);
        }

        if ($this->filterMonth && $this->filterYear) {
            $query->whereMonth('tanggal_inspeksi', $this->filterMonth)
                  ->whereYear('tanggal_inspeksi', $this->filterYear);
        }

        $inspeksiList = $query->paginate(10);

        // Stats
        $totalThisMonth = Inspeksi::whereMonth('tanggal_inspeksi', now()->month)
            ->whereYear('tanggal_inspeksi', now()->year)->count();
        $aparNeedInspection = Apar::needsInspection()->count();

        return view('livewire.inspeksi.inspeksi-index', [
            'inspeksiList' => $inspeksiList,
            'totalThisMonth' => $totalThisMonth,
            'aparNeedInspection' => $aparNeedInspection,
        ])->layout('layouts.app', ['title' => 'Inspeksi']);
    }
}
