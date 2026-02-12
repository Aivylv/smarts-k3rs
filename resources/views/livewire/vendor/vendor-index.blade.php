<div>
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold">Vendor</h1>
            <p class="text-base-content/60">Kelola data vendor/supplier APAR</p>
        </div>
        <button wire:click="openModal" class="btn btn-primary mt-4 md:mt-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Vendor
        </button>
    </div>

    @if(session()->has('message'))
    <div class="alert alert-success mb-4">{{ session('message') }}</div>
    @endif

    <div class="card bg-base-100 shadow-lg mb-4">
        <div class="card-body py-4">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari vendor..." class="input input-bordered w-full md:w-1/3" />
        </div>
    </div>

    <div class="card bg-base-100 shadow-lg">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Vendor</th>
                            <th>Contact Person</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>APAR</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vendorList as $vendor)
                        <tr class="hover">
                            <td class="font-medium">{{ $vendor->nama_vendor }}</td>
                            <td>{{ $vendor->contact_person }}</td>
                            <td>{{ $vendor->phone }}</td>
                            <td>{{ $vendor->email ?? '-' }}</td>
                            <td class="text-center">{{ $vendor->apar_count }}</td>
                            <td>
                                <span class="badge {{ $vendor->is_active ? 'badge-success' : 'badge-ghost' }} badge-sm">
                                    {{ $vendor->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td>
                                <button wire:click="openModal({{ $vendor->id_vendor }})" class="btn btn-ghost btn-sm btn-square">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button wire:click="delete({{ $vendor->id_vendor }})" wire:confirm="Yakin hapus vendor ini?" class="btn btn-ghost btn-sm btn-square text-error">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center py-8 text-base-content/60">Tidak ada data vendor</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($vendorList->hasPages())
            <div class="p-4 border-t">{{ $vendorList->links() }}</div>
            @endif
        </div>
    </div>

    @if($showModal)
    <div class="modal modal-open">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-4">{{ $editMode ? 'Edit Vendor' : 'Tambah Vendor' }}</h3>
            <form wire:submit.prevent="save" class="space-y-4">
                <div class="form-control">
                    <label class="label"><span class="label-text">Nama Vendor *</span></label>
                    <input type="text" wire:model="nama_vendor" class="input input-bordered w-full" />
                    @error('nama_vendor') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Alamat</span></label>
                    <textarea wire:model="alamat" class="textarea textarea-bordered w-full" rows="2"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text">Contact Person *</span></label>
                        <input type="text" wire:model="contact_person" class="input input-bordered w-full" />
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text">Phone *</span></label>
                        <input type="text" wire:model="phone" class="input input-bordered w-full" />
                    </div>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Email</span></label>
                    <input type="email" wire:model="email" class="input input-bordered w-full" />
                </div>
                <div class="form-control">
                    <label class="label cursor-pointer justify-start gap-4">
                        <input type="checkbox" wire:model="is_active" class="toggle toggle-success" />
                        <span class="label-text">Vendor Aktif</span>
                    </label>
                </div>
                <div class="modal-action">
                    <button type="button" wire:click="$set('showModal', false)" class="btn btn-ghost">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
        <div class="modal-backdrop" wire:click="$set('showModal', false)"></div>
    </div>
    @endif
</div>
