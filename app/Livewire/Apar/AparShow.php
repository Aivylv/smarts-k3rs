<?php

namespace App\Livewire\Apar;

use Livewire\Component;
use App\Models\Apar;

class AparShow extends Component
{
    public Apar $apar;
    public $showQrModal = false;

    public function mount($id)
    {
        $this->apar = Apar::with(['lokasi', 'vendor', 'inspeksi' => function($q) {
            $q->latest()->limit(5);
        }, 'maintenance' => function($q) {
            $q->latest()->limit(5);
        }])->findOrFail($id);
    }

    public function downloadQr()
    {
        // Generate QR code and return download
        $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
            ->size(300)
            ->margin(2)
            ->generate(route('apar.show', $this->apar->id_apar));
        
        return response()->streamDownload(function () use ($qrCode) {
            echo $qrCode;
        }, 'qr-' . $this->apar->id_apar . '.png', ['Content-Type' => 'image/png']);
    }

    public function printQr()
    {
        $this->dispatch('printQr');
    }

    public function render()
    {
        return view('livewire.apar.apar-show')
            ->layout('layouts.app', ['title' => 'Detail APAR - ' . $this->apar->id_apar]);
    }
}
