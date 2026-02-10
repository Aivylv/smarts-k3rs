<?php

namespace App\Livewire\Apar;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Apar;
use App\Models\Lokasi;
use App\Models\Vendor;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AparForm extends Component
{
    use WithFileUploads;

    public $mode = 'create'; // create or edit
    public $aparId = null;

    // Form fields
    public $id_apar;
    public $kode_qr;
    public $tipe_apar = 'powder';
    public $kapasitas = 6;
    public $merk;
    public $no_seri;
    public $tanggal_produksi;
    public $tanggal_pengisian;
    public $tanggal_expire;
    public $id_lokasi;
    public $id_vendor;
    public $status = 'aktif';
    public $foto;
    public $existingFoto;

    protected function rules()
    {
        return [
            'id_apar' => 'required|string|max:50|unique:apar,id_apar,' . $this->aparId . ',id_apar',
            'tipe_apar' => 'required|in:powder,co2,foam,liquid',
            'kapasitas' => 'required|numeric|min:0.1|max:100',
            'merk' => 'required|string|max:100',
            'no_seri' => 'nullable|string|max:100',
            'tanggal_produksi' => 'required|date',
            'tanggal_pengisian' => 'nullable|date',
            'tanggal_expire' => 'required|date|after:tanggal_produksi',
            'id_lokasi' => 'required|exists:lokasi,id_lokasi',
            'id_vendor' => 'nullable|exists:vendor,id_vendor',
            'status' => 'required|in:aktif,rusak,expired,maintenance,disposed',
            'foto' => 'nullable|image|max:2048',
        ];
    }

    public function mount($id = null)
    {
        if ($id) {
            $this->mode = 'edit';
            $this->aparId = $id;
            $this->loadApar($id);
        } else {
            $this->mode = 'create';
            $this->id_apar = Apar::generateId();
            $this->kode_qr = Apar::generateQrCode($this->id_apar);
            $this->tanggal_produksi = now()->format('Y-m-d');
            $this->tanggal_expire = now()->addYears(5)->format('Y-m-d');
        }
    }

    public function loadApar($id)
    {
        $apar = Apar::findOrFail($id);
        
        $this->id_apar = $apar->id_apar;
        $this->kode_qr = $apar->kode_qr;
        $this->tipe_apar = $apar->tipe_apar;
        $this->kapasitas = $apar->kapasitas;
        $this->merk = $apar->merk;
        $this->no_seri = $apar->no_seri;
        $this->tanggal_produksi = $apar->tanggal_produksi->format('Y-m-d');
        $this->tanggal_pengisian = $apar->tanggal_pengisian?->format('Y-m-d');
        $this->tanggal_expire = $apar->tanggal_expire->format('Y-m-d');
        $this->id_lokasi = $apar->id_lokasi;
        $this->id_vendor = $apar->id_vendor;
        $this->status = $apar->status;
        $this->existingFoto = $apar->foto;
    }

    public function generateNewId()
    {
        $this->id_apar = Apar::generateId();
        $this->kode_qr = Apar::generateQrCode($this->id_apar);
    }

    public function updatedTanggalProduksi($value)
    {
        if ($value && $this->mode === 'create') {
            $this->tanggal_expire = date('Y-m-d', strtotime($value . ' +5 years'));
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'id_apar' => $this->id_apar,
            'kode_qr' => $this->kode_qr ?? Apar::generateQrCode($this->id_apar),
            'tipe_apar' => $this->tipe_apar,
            'kapasitas' => $this->kapasitas,
            'merk' => $this->merk,
            'no_seri' => $this->no_seri,
            'tanggal_produksi' => $this->tanggal_produksi,
            'tanggal_pengisian' => $this->tanggal_pengisian,
            'tanggal_expire' => $this->tanggal_expire,
            'id_lokasi' => $this->id_lokasi,
            'id_vendor' => $this->id_vendor ?: null,
            'status' => $this->status,
        ];

        // Handle foto upload
        if ($this->foto) {
            $filename = $this->id_apar . '_' . time() . '.' . $this->foto->getClientOriginalExtension();
            $this->foto->storeAs('apar', $filename, 'public');
            $data['foto'] = 'apar/' . $filename;
        }

        if ($this->mode === 'edit') {
            $apar = Apar::findOrFail($this->aparId);
            $apar->update($data);
            session()->flash('message', 'APAR berhasil diperbarui.');
        } else {
            Apar::create($data);
            session()->flash('message', 'APAR berhasil ditambahkan.');
        }

        return redirect()->route('apar.index');
    }

    public function render()
    {
        $lokasiList = Lokasi::orderBy('nama_lokasi')->get();
        $vendorList = Vendor::where('is_active', true)->orderBy('nama_vendor')->get();

        return view('livewire.apar.apar-form', [
            'lokasiList' => $lokasiList,
            'vendorList' => $vendorList,
        ])->layout('layouts.app', [
            'title' => $this->mode === 'create' ? 'Tambah APAR' : 'Edit APAR'
        ]);
    }
}
