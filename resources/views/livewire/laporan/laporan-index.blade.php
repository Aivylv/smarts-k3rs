<div>
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold">Laporan</h1>
            <p class="text-base-content/60">Statistik dan laporan bulanan APAR</p>
        </div>
    </div>

    @if(session()->has('message'))
    <div class="alert alert-success mb-4">{{ session('message') }}</div>
    @endif

    <!-- Summary Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="stat bg-base-100 rounded-xl shadow">
            <div class="stat-title">Total APAR</div>
            <div class="stat-value">{{ $totalApar }}</div>
        </div>
        <div class="stat bg-success/10 rounded-xl">
            <div class="stat-title">Aktif</div>
            <div class="stat-value text-success">{{ $aparByStatus['aktif'] }}</div>
        </div>
        <div class="stat bg-error/10 rounded-xl">
            <div class="stat-title">Rusak</div>
            <div class="stat-value text-error">{{ $aparByStatus['rusak'] }}</div>
        </div>
        <div class="stat bg-warning/10 rounded-xl">
            <div class="stat-title">Expired</div>
            <div class="stat-value text-warning">{{ $aparByStatus['expired'] }}</div>
        </div>
    </div>

    <!-- Compliance Rate -->
    <div class="card bg-base-100 shadow-lg mb-6">
        <div class="card-body">
            <h3 class="card-title">Compliance Rate Bulan Ini</h3>
            <div class="flex items-center gap-4">
                <div class="radial-progress text-primary" style="--value:{{ $complianceRate }}; --size:8rem;">
                    {{ $complianceRate }}%
                </div>
                <div>
                    <p class="text-lg font-medium">{{ $inspeksiThisMonth }} / {{ $totalApar }} APAR</p>
                    <p class="text-base-content/60">sudah diinspeksi bulan ini</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Generate Report -->
    <div class="card bg-base-100 shadow-lg mb-6">
        <div class="card-body">
            <h3 class="card-title">Generate Laporan Bulanan</h3>
            <div class="flex flex-wrap gap-4 items-end">
                <div class="form-control">
                    <label class="label"><span class="label-text">Bulan</span></label>
                    <select wire:model="selectedMonth" class="select select-bordered">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}">{{ DateTime::createFromFormat('!m', $m)->format('F') }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Tahun</span></label>
                    <select wire:model="selectedYear" class="select select-bordered">
                        @foreach(range(now()->year, now()->year - 2) as $y)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <button wire:click="generateReport" class="btn btn-primary">
                    Generate Laporan
                </button>
            </div>
        </div>
    </div>

    <!-- History -->
    <div class="card bg-base-100 shadow-lg">
        <div class="card-body">
            <h3 class="card-title">Riwayat Laporan</h3>
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Periode</th>
                            <th>Total APAR</th>
                            <th>Inspeksi</th>
                            <th>Compliance</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporanList as $lap)
                        <tr>
                            <td class="font-medium">{{ $lap->periode }}</td>
                            <td>{{ $lap->total_apar }}</td>
                            <td>{{ $lap->total_inspeksi }}</td>
                            <td>{{ $lap->compliance_rate }}%</td>
                            <td><span class="badge badge-sm {{ $lap->status_laporan === 'published' ? 'badge-success' : 'badge-ghost' }}">{{ ucfirst($lap->status_laporan) }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-8 text-base-content/60">Belum ada laporan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
