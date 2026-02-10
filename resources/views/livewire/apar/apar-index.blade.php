<div>
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Data APAR</h1>
            <p class="text-base-content/60">Kelola inventori Alat Pemadam Api Ringan</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('apar.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah APAR
            </a>
        </div>
    </div>

    <!-- Flash Message -->
    @if(session()->has('message'))
    <div class="alert alert-success mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>{{ session('message') }}</span>
    </div>
    @endif

    <!-- Filters -->
    <div class="card bg-base-100 shadow-lg mb-6">
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Cari</span>
                    </label>
                    <input type="text" 
                           wire:model.live.debounce.300ms="search" 
                           placeholder="Kode, Merk, Lokasi..." 
                           class="input input-bordered w-full" />
                </div>

                <!-- Status Filter -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Status</span>
                    </label>
                    <select wire:model.live="filterStatus" class="select select-bordered w-full">
                        <option value="">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="rusak">Rusak</option>
                        <option value="expired">Expired</option>
                        <option value="maintenance">Maintenance</option>
                        <option value="disposed">Disposed</option>
                    </select>
                </div>

                <!-- Tipe Filter -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Tipe</span>
                    </label>
                    <select wire:model.live="filterTipe" class="select select-bordered w-full">
                        <option value="">Semua Tipe</option>
                        <option value="powder">Powder</option>
                        <option value="co2">CO2</option>
                        <option value="foam">Foam</option>
                        <option value="liquid">Liquid</option>
                    </select>
                </div>

                <!-- Lokasi Filter -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Lokasi</span>
                    </label>
                    <select wire:model.live="filterLokasi" class="select select-bordered w-full">
                        <option value="">Semua Lokasi</option>
                        @foreach($lokasiList as $lokasi)
                            <option value="{{ $lokasi->id_lokasi }}">{{ $lokasi->nama_lokasi }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card bg-base-100 shadow-lg">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th wire:click="sortBy('id_apar')" class="cursor-pointer hover:bg-base-200">
                                <div class="flex items-center gap-2">
                                    Kode APAR
                                    @if($sortField === 'id_apar')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" />
                                        </svg>
                                    @endif
                                </div>
                            </th>
                            <th>Tipe / Kapasitas</th>
                            <th>Merk</th>
                            <th>Lokasi</th>
                            <th wire:click="sortBy('tanggal_expire')" class="cursor-pointer hover:bg-base-200">
                                <div class="flex items-center gap-2">
                                    Expired
                                    @if($sortField === 'tanggal_expire')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" />
                                        </svg>
                                    @endif
                                </div>
                            </th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($aparList as $apar)
                        <tr class="hover">
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-bold font-mono">{{ $apar->id_apar }}</div>
                                        <div class="text-xs text-base-content/60">{{ $apar->no_seri ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-outline">{{ strtoupper($apar->tipe_apar) }}</span>
                                <div class="text-sm text-base-content/60">{{ $apar->kapasitas }} kg</div>
                            </td>
                            <td>{{ $apar->merk }}</td>
                            <td>
                                <div class="font-medium">{{ $apar->lokasi->nama_lokasi ?? '-' }}</div>
                                <div class="text-xs text-base-content/60">{{ $apar->lokasi->gedung ?? '' }} - {{ $apar->lokasi->ruangan ?? '' }}</div>
                            </td>
                            <td>
                                <div @class([
                                    'font-medium',
                                    'text-error' => $apar->is_expired || $apar->days_until_expire < 0,
                                    'text-warning' => !$apar->is_expired && $apar->days_until_expire <= 30 && $apar->days_until_expire >= 0,
                                ])>
                                    {{ $apar->tanggal_expire->format('d/m/Y') }}
                                </div>
                                @if($apar->is_expired)
                                    <div class="text-xs text-error">Sudah expired</div>
                                @elseif($apar->days_until_expire <= 30)
                                    <div class="text-xs text-warning">{{ $apar->days_until_expire }} hari lagi</div>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $apar->status_badge_class }}">
                                    {{ ucfirst($apar->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('apar.show', $apar->id_apar) }}" class="btn btn-ghost btn-sm btn-square" title="Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('apar.edit', $apar->id_apar) }}" class="btn btn-ghost btn-sm btn-square" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <button wire:click="confirmDelete('{{ $apar->id_apar }}')" class="btn btn-ghost btn-sm btn-square text-error" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-10">
                                <div class="text-base-content/60">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <p class="text-lg font-medium">Tidak ada data APAR</p>
                                    <p class="text-sm">Silakan tambahkan APAR baru atau ubah filter pencarian</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($aparList->hasPages())
            <div class="p-4 border-t border-base-300">
                {{ $aparList->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Delete Modal -->
    @if($showDeleteModal)
    <div class="modal modal-open">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Konfirmasi Hapus</h3>
            <p class="py-4">Apakah Anda yakin ingin menghapus APAR <strong>{{ $deleteId }}</strong>? Data yang sudah dihapus tidak dapat dikembalikan.</p>
            <div class="modal-action">
                <button wire:click="$set('showDeleteModal', false)" class="btn btn-ghost">Batal</button>
                <button wire:click="delete" class="btn btn-error">Hapus</button>
            </div>
        </div>
        <div class="modal-backdrop" wire:click="$set('showDeleteModal', false)"></div>
    </div>
    @endif
</div>
