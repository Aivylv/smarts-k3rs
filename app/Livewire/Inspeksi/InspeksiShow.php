<?php

namespace App\Livewire\Inspeksi;

use Livewire\Component;
use App\Models\Inspeksi;

class InspeksiShow extends Component
{
    public $inspeksi;

    public function mount($id)
    {
        $this->inspeksi = Inspeksi::with(['apar.lokasi', 'user'])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.inspeksi.inspeksi-show')
            ->layout('layouts.app', ['title' => 'Detail Inspeksi']);
    }
}