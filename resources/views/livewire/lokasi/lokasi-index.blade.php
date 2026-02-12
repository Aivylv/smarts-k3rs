<div>
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold">Lokasi APAR</h1>
            <p class="text-base-content/60">Kelola lokasi penempatan APAR</p>
        </div>
        <button wire:click="openModal" class="btn btn-primary mt-4 md:mt-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Lokasi
        </button>
    </div>

    @if(session()->has('message'))
    <div class="alert alert-success mb-4">{{ session('message') }}</div>
    @endif
    @if(session()->has('error'))
    <div class="alert alert-error mb-4">{{ session('error') }}</div>
    @endif

    <div class="card bg-base-100 shadow-lg mb-4">
        <div class="card-body py-4">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari lokasi..." class="input input-bordered w-full md:w-1/3" />
        </div>
    </div>

    <div class="card bg-base-100 shadow-lg">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Lokasi</th>
                            <th>Gedung</th>
                            <th>Lantai</th>
                            <th>Ruangan</th>
                            <th>Risiko</th>
                            <th>Jumlah APAR</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lokasiList as $lokasi)
                        <tr class="hover">
                            <td class="font-medium">{{ $lokasi->nama_lokasi }}</td>
                            <td>{{ $lokasi->gedung }}</td>
                            <td class="text-center">{{ $lokasi->lantai }}</td>
                            <td>{{ $lokasi->ruangan }}</td>
                            <td>
                                <span @class([
                                    'badge badge-sm',
                                    'badge-error' => $lokasi->kategori_risiko === 'tinggi',
                                    'badge-warning' => $lokasi->kategori_risiko === 'sedang',
                                    'badge-success' => $lokasi->kategori_risiko === 'rendah',
                                ])>
                                    {{ ucfirst($lokasi->kategori_risiko) }}
                                </span>
                            </td>
                            <td class="text-center">{{ $lokasi->apar_count }}</td>
                            <td>
                                <button wire:click="openModal({{ $lokasi->id_lokasi }})" class="btn btn-ghost btn-sm btn-square">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button wire:click="delete({{ $lokasi->id_lokasi }})" wire:confirm="Yakin hapus lokasi ini?" class="btn btn-ghost btn-sm btn-square text-error">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center py-8 text-base-content/60">Tidak ada data lokasi</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($lokasiList->hasPages())
            <div class="p-4 border-t">{{ $lokasiList->links() }}</div>
            @endif
        </div>
    </div>

    <!-- Modal -->
    @if($showModal)
    <div class="modal modal-open">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-4">{{ $editMode ? 'Edit Lokasi' : 'Tambah Lokasi' }}</h3>
            <form wire:submit.prevent="save" class="space-y-4">
                <div class="form-control">
                    <label class="label"><span class="label-text">Nama Lokasi *</span></label>
                    <input type="text" wire:model="nama_lokasi" class="input input-bordered w-full @error('nama_lokasi') input-error @enderror" />
                    @error('nama_lokasi') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text">Gedung *</span></label>
                        <input type="text" wire:model="gedung" class="input input-bordered w-full" />
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text">Lantai *</span></label>
                        <input type="text" wire:model="lantai" class="input input-bordered w-full" />
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text">Ruangan *</span></label>
                        <input type="text" wire:model="ruangan" class="input input-bordered w-full" />
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text">Koordinat</span></label>
                        <input type="text" wire:model="koordinat" placeholder="A1-ICU-01" class="input input-bordered w-full" />
                    </div>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Kategori Risiko</span></label>
                    <select wire:model="kategori_risiko" class="select select-bordered w-full">
                        <option value="rendah">Rendah</option>
                        <option value="sedang">Sedang</option>
                        <option value="tinggi">Tinggi</option>
                    </select>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Deskripsi</span></label>
                    <textarea wire:model="deskripsi" class="textarea textarea-bordered w-full" rows="2"></textarea>
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
