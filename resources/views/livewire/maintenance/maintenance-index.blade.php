<div>
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold">Work Order Maintenance</h1>
            <p class="text-base-content/60">Kelola work order pemeliharaan APAR</p>
        </div>
        <button wire:click="openModal" class="btn btn-primary mt-4 md:mt-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Buat Work Order
        </button>
    </div>

    @if(session('message'))
    <div class="alert alert-success mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>{{ session('message') }}</span>
    </div>
    @endif

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="stat bg-warning/10 rounded-xl">
            <div class="stat-title">Pending</div>
            <div class="stat-value text-warning">{{ $stats['pending'] }}</div>
        </div>
        <div class="stat bg-info/10 rounded-xl">
            <div class="stat-title">In Progress</div>
            <div class="stat-value text-info">{{ $stats['in_progress'] }}</div>
        </div>
        <div class="stat bg-success/10 rounded-xl">
            <div class="stat-title">Completed</div>
            <div class="stat-value text-success">{{ $stats['completed'] }}</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card bg-base-100 shadow-lg mb-4">
        <div class="card-body py-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari WO atau APAR..." class="input input-bordered w-full" />
                <select wire:model.live="filterStatus" class="select select-bordered w-full">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
                <select wire:model.live="filterType" class="select select-bordered w-full">
                    <option value="">Semua Tipe</option>
                    <option value="ringan">Ringan</option>
                    <option value="sedang">Sedang</option>
                    <option value="berat">Berat</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card bg-base-100 shadow-lg">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No. WO</th>
                            <th>APAR</th>
                            <th>Tipe</th>
                            <th>Teknisi</th>
                            <th>Jadwal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($maintenanceList as $wo)
                        <tr class="hover">
                            <td class="font-mono">{{ $wo->wo_number }}</td>
                            <td>
                                <div class="font-medium">{{ $wo->apar->id_apar ?? '-' }}</div>
                                <div class="text-xs text-base-content/60">{{ $wo->apar->lokasi->nama_lokasi ?? '-' }}</div>
                            </td>
                            <td><span class="badge badge-outline badge-sm">{{ ucfirst($wo->maintenance_type) }}</span></td>
                            <td>{{ $wo->teknisi->name ?? 'Belum assign' }}</td>
                            <td>{{ $wo->scheduled_date?->format('d/m/Y') ?? '-' }}</td>
                            <td><span class="badge {{ $wo->status_badge ?? 'badge-info' }} badge-sm">{{ ucfirst(str_replace('_', ' ', $wo->status)) }}</span></td>
                            <td>
                                <button class="btn btn-ghost btn-sm btn-square">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center py-8 text-base-content/60">Tidak ada data work order</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($maintenanceList->hasPages())
            <div class="p-4 border-t">{{ $maintenanceList->links() }}</div>
            @endif
        </div>
    </div>

    <!-- Create Modal -->
    @if($showModal)
    <div class="modal modal-open">
        <div class="modal-box max-w-2xl">
            <h3 class="font-bold text-lg mb-4">Buat Work Order Baru</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control md:col-span-2">
                    <label class="label"><span class="label-text">APAR *</span></label>
                    <select wire:model="id_apar" class="select select-bordered w-full">
                        <option value="">Pilih APAR...</option>
                        @foreach($aparList as $apar)
                        <option value="{{ $apar->id_apar }}">{{ $apar->id_apar }} - {{ $apar->lokasi->nama_lokasi ?? '-' }}</option>
                        @endforeach
                    </select>
                    @error('id_apar') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text">Tipe Maintenance *</span></label>
                    <select wire:model="maintenance_type" class="select select-bordered w-full">
                        <option value="ringan">Ringan</option>
                        <option value="sedang">Sedang</option>
                        <option value="berat">Berat</option>
                    </select>
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text">Prioritas</span></label>
                    <select wire:model="priority" class="select select-bordered w-full">
                        <option value="low">Low</option>
                        <option value="normal">Normal</option>
                        <option value="high">High</option>
                        <option value="urgent">Urgent</option>
                    </select>
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text">Tanggal Jadwal *</span></label>
                    <input type="date" wire:model="scheduled_date" class="input input-bordered w-full" />
                    @error('scheduled_date') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text">Assign Teknisi</span></label>
                    <select wire:model="assigned_to" class="select select-bordered w-full">
                        <option value="">Belum di-assign</option>
                        @foreach($teknisiList as $teknisi)
                        <option value="{{ $teknisi->id }}">{{ $teknisi->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-control md:col-span-2">
                    <label class="label"><span class="label-text">Deskripsi *</span></label>
                    <textarea wire:model="description" class="textarea textarea-bordered h-24" placeholder="Jelaskan pekerjaan yang perlu dilakukan..."></textarea>
                    @error('description') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="modal-action">
                <button wire:click="closeModal" class="btn btn-ghost">Batal</button>
                <button wire:click="save" class="btn btn-primary">
                    <span wire:loading.remove wire:target="save">Simpan</span>
                    <span wire:loading wire:target="save" class="loading loading-spinner loading-sm"></span>
                </button>
            </div>
        </div>
        <div class="modal-backdrop" wire:click="closeModal"></div>
    </div>
    @endif
</div>
