<?php

namespace App\Livewire\Inspeksi;

use Livewire\Component;
use App\Models\Inspeksi;
use App\Models\Apar;
use Illuminate\Support\Facades\Auth;

class InspeksiForm extends Component
{
    public $aparId = '';
    public $tanggal_inspeksi;
    
    // Checklist items
    public $kondisi_tabung = true;
    public $kondisi_selang = true;
    public $kondisi_pin = true;
    public $kondisi_segel = true;
    public $kondisi_nozzle = true;
    public $kondisi_label = true;
    public $kondisi_mounting = true;
    public $kondisi_pressure = 'hijau';
    public $aksesibilitas = true;
    public $signage = true;
    
    public $catatan = '';
    public $rekomendasi = ''; 
    public $aparList = [];
    public $selectedApar = null;

    protected $rules = [
        'aparId' => 'required|exists:apar,id_apar',
        'tanggal_inspeksi' => 'required|date',
        'kondisi_tabung' => 'boolean',
        'kondisi_selang' => 'boolean',
        'kondisi_pin' => 'boolean',
        'kondisi_segel' => 'boolean',
        'kondisi_nozzle' => 'boolean',
        'kondisi_label' => 'boolean',
        'kondisi_mounting' => 'boolean',
        'kondisi_pressure' => 'required|in:hijau,kuning,merah',
        'aksesibilitas' => 'boolean',
        'signage' => 'boolean',
    ];

    public function mount($apar = null)
    {
        $this->tanggal_inspeksi = now()->format('Y-m-d');
        $this->aparList = Apar::with('lokasi')->orderBy('id_apar')->get();
        
        if ($apar) {
            $this->aparId = $apar;
            $this->loadApar();
        }
    }

    public function updatedAparId()
    {
        $this->loadApar();
    }

    public function loadApar()
    {
        if ($this->aparId) {
            $this->selectedApar = Apar::with('lokasi', 'vendor')->find($this->aparId);
        }
    }

    public function save()
    {
        $this->validate();

        $inspeksi = Inspeksi::create([
            'id_apar' => $this->aparId,
            'id_user' => Auth::id(),
            'tanggal_inspeksi' => $this->tanggal_inspeksi,
            'kondisi_tabung' => $this->kondisi_tabung,
            'kondisi_selang' => $this->kondisi_selang,
            'kondisi_pin' => $this->kondisi_pin,
            'kondisi_segel' => $this->kondisi_segel,
            'kondisi_nozzle' => $this->kondisi_nozzle,
            'kondisi_label' => $this->kondisi_label,
            'kondisi_mounting' => $this->kondisi_mounting,
            'kondisi_pressure' => $this->kondisi_pressure,
            'aksesibilitas' => $this->aksesibilitas,
            'signage' => $this->signage,
            'catatan' => $this->catatan,
            'rekomendasi' => $this->rekomendasi,
        ]);

        session()->flash('message', 'Inspeksi berhasil disimpan.');
        return redirect()->route('inspeksi.index');
    }

    public function render()
    {
        return view('livewire.inspeksi.inspeksi-form')
            ->layout('layouts.app', ['title' => 'Form Inspeksi']);
    }
}
