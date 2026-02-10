<?php

namespace App\Livewire\Vendor;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Vendor;

class VendorIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $editMode = false;
    public $vendorId = null;

    public $nama_vendor = '';
    public $alamat = '';
    public $contact_person = '';
    public $phone = '';
    public $email = '';
    public $is_active = true;

    protected $rules = [
        'nama_vendor' => 'required|string|max:100',
        'alamat' => 'nullable|string',
        'contact_person' => 'required|string|max:100',
        'phone' => 'required|string|max:20',
        'email' => 'nullable|email|max:100',
    ];

    public function openModal($id = null)
    {
        $this->resetForm();
        if ($id) {
            $this->editMode = true;
            $this->vendorId = $id;
            $vendor = Vendor::findOrFail($id);
            $this->nama_vendor = $vendor->nama_vendor;
            $this->alamat = $vendor->alamat;
            $this->contact_person = $vendor->contact_person;
            $this->phone = $vendor->phone;
            $this->email = $vendor->email;
            $this->is_active = $vendor->is_active;
        }
        $this->showModal = true;
    }

    public function resetForm()
    {
        $this->editMode = false;
        $this->vendorId = null;
        $this->nama_vendor = '';
        $this->alamat = '';
        $this->contact_person = '';
        $this->phone = '';
        $this->email = '';
        $this->is_active = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'nama_vendor' => $this->nama_vendor,
            'alamat' => $this->alamat,
            'contact_person' => $this->contact_person,
            'phone' => $this->phone,
            'email' => $this->email,
            'is_active' => $this->is_active,
        ];

        if ($this->editMode) {
            Vendor::findOrFail($this->vendorId)->update($data);
            session()->flash('message', 'Vendor berhasil diperbarui.');
        } else {
            Vendor::create($data);
            session()->flash('message', 'Vendor berhasil ditambahkan.');
        }

        $this->showModal = false;
        $this->resetForm();
    }

    public function delete($id)
    {
        Vendor::findOrFail($id)->delete();
        session()->flash('message', 'Vendor berhasil dihapus.');
    }

    public function render()
    {
        $vendorList = Vendor::withCount('apar')
            ->when($this->search, fn($q) => $q->where('nama_vendor', 'like', "%{$this->search}%"))
            ->orderBy('nama_vendor')
            ->paginate(10);

        return view('livewire.vendor.vendor-index', [
            'vendorList' => $vendorList,
        ])->layout('layouts.app', ['title' => 'Vendor']);
    }
}
