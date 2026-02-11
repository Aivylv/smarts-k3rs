<div>
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Inspeksi APAR</h1>
            <p class="text-base-content/60">Kelola inspeksi bulanan APAR</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('inspeksi.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                Inspeksi Baru
            </a>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="stat bg-base-100 rounded-xl shadow">
            <div class="stat-figure text-info">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
            </div>
            <div class="stat-title">Inspeksi Bulan Ini</div>
            <div class="stat-value text-info">{{ $totalThisMonth }}</div>
        </div>
        <div class="stat bg-base-100 rounded-xl shadow">
            <div class="stat-figure text-warning">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div class="stat-title">Perlu Inspeksi</div>
            <div class="stat-value text-warning">{{ $aparNeedInspection }}</div>
            <div class="stat-desc">APAR belum diinspeksi bulan ini</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card bg-base-100 shadow-lg mb-6">
        <div class="card-body py-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="form-control">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari APAR atau Lokasi..." class="input input-bordered w-full" />
                </div>
                <div class="form-control">
                    <select wire:model.live="filterStatus" class="select select-bordered w-full">
                        <option value="">Semua Status</option>
                        <option value="baik">Baik</option>
                        <option value="kurang">Kurang</option>
                        <option value="rusak">Rusak</option>
                    </select>
                </div>
                <div class="form-control">
                    <select wire:model.live="filterMonth" class="select select-bordered w-full">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}">{{ DateTime::createFromFormat('!m', $m)->format('F') }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-control">
                    <select wire:model.live="filterYear" class="select select-bordered w-full">
                        @foreach(range(now()->year, now()->year - 2) as $y)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
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
                            <th>APAR</th>
                            <th>Lokasi</th>
                            <th>Tanggal</th>
                            <th>Inspector</th>
                            <th>Pressure</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inspeksiList as $inspeksi)
                        <tr class="hover">
                            <td class="font-mono font-medium">{{ $inspeksi->apar->id_apar }}</td>
                            <td>{{ $inspeksi->apar->lokasi->nama_lokasi ?? '-' }}</td>
                            <td>{{ $inspeksi->tanggal_inspeksi->format('d/m/Y') }}</td>
                            <td>{{ $inspeksi->user->name }}</td>
                            <td class="text-center">
                                <span class="pressure-indicator pressure-{{ $inspeksi->pressure_status }}"></span>
                            </td>
                            <td>
                                <span class="badge {{ $inspeksi->overall_status_badge }} badge-sm">
                                    {{ ucfirst($inspeksi->overall_status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('inspeksi.show', $inspeksi->id_inspeksi) }}" class="btn btn-ghost btn-sm btn-square">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-10 text-base-content/60">
                                Tidak ada data inspeksi
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($inspeksiList->hasPages())
            <div class="p-4 border-t">
                {{ $inspeksiList->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
