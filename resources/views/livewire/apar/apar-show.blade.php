<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold">Detail APAR</h1>
            <p class="text-base-content/60">{{ $apar->id_apar }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('apar.edit', $apar->id_apar) }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
            <a href="{{ route('apar.index') }}" class="btn btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Info Card -->
            <div class="card bg-base-100 shadow-lg">
                <div class="card-body">
                    <h3 class="font-semibold text-lg mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Informasi APAR
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-base-content/60">ID APAR</p>
                                <p class="font-mono font-semibold text-lg">{{ $apar->id_apar }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-base-content/60">Tipe</p>
                                <p class="badge badge-primary">{{ $apar->tipe_apar_label ?? $apar->tipe_apar }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-base-content/60">Merk</p>
                                <p class="font-medium">{{ $apar->merk ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-base-content/60">Model</p>
                                <p class="font-medium">{{ $apar->model ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-base-content/60">Kapasitas</p>
                                <p class="font-medium">{{ $apar->kapasitas }} Kg</p>
                            </div>
                            <div>
                                <p class="text-sm text-base-content/60">Status</p>
                                <span class="badge {{ $apar->status === 'aktif' ? 'badge-success' : ($apar->status === 'rusak' ? 'badge-error' : 'badge-warning') }}">
                                    {{ ucfirst($apar->status) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-sm text-base-content/60">Tanggal Pembelian</p>
                                <p class="font-medium">{{ $apar->tanggal_pembelian?->format('d/m/Y') ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-base-content/60">Tanggal Expire</p>
                                <p class="font-medium {{ $apar->is_expired ? 'text-error' : '' }}">
                                    {{ $apar->tanggal_expire?->format('d/m/Y') ?? '-' }}
                                    @if($apar->is_expired)
                                    <span class="badge badge-error badge-sm ml-2">Expired</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Location & Vendor -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="card bg-base-100 shadow-lg">
                    <div class="card-body">
                        <h3 class="font-semibold text-lg mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Lokasi
                        </h3>
                        @if($apar->lokasi)
                        <div class="space-y-2">
                            <p class="font-medium">{{ $apar->lokasi->nama_lokasi }}</p>
                            <p class="text-sm text-base-content/60">{{ $apar->lokasi->gedung ?? '' }} {{ $apar->lokasi->lantai ? '- Lantai ' . $apar->lokasi->lantai : '' }}</p>
                            <p class="text-sm text-base-content/60">{{ $apar->lokasi->ruangan ?? '' }}</p>
                        </div>
                        @else
                        <p class="text-base-content/60">Tidak ada data lokasi</p>
                        @endif
                    </div>
                </div>

                <div class="card bg-base-100 shadow-lg">
                    <div class="card-body">
                        <h3 class="font-semibold text-lg mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Vendor
                        </h3>
                        @if($apar->vendor)
                        <div class="space-y-2">
                            <p class="font-medium">{{ $apar->vendor->nama_vendor }}</p>
                            <p class="text-sm text-base-content/60">{{ $apar->vendor->telepon ?? '' }}</p>
                            <p class="text-sm text-base-content/60">{{ $apar->vendor->email ?? '' }}</p>
                        </div>
                        @else
                        <p class="text-base-content/60">Tidak ada data vendor</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recent Inspections -->
            <div class="card bg-base-100 shadow-lg">
                <div class="card-body">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-lg flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                            Riwayat Inspeksi
                        </h3>
                        <a href="{{ route('inspeksi.create.apar', $apar->id_apar) }}" class="btn btn-sm btn-primary">
                            + Inspeksi Baru
                        </a>
                    </div>
                    @if($apar->inspeksi->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Inspektor</th>
                                    <th>Status</th>
                                    <th>Pressure</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($apar->inspeksi as $inspeksi)
                                <tr>
                                    <td>{{ $inspeksi->tanggal_inspeksi?->format('d/m/Y') ?? '-' }}</td>
                                    <td>{{ $inspeksi->user?->name ?? '-' }}</td>
                                    <td>
                                        <span class="badge badge-sm {{ $inspeksi->status === 'baik' ? 'badge-success' : 'badge-warning' }}">
                                            {{ ucfirst($inspeksi->status ?? 'N/A') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="w-3 h-3 rounded-full inline-block bg-{{ $inspeksi->kondisi_pressure === 'hijau' ? 'success' : ($inspeksi->kondisi_pressure === 'kuning' ? 'warning' : 'error') }}"></span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-center text-base-content/60 py-4">Belum ada inspeksi</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- QR Code -->
            <div class="card bg-base-100 shadow-lg">
                <div class="card-body items-center text-center">
                    <h3 class="font-semibold text-lg mb-4">QR Code</h3>
                    <div class="bg-white p-4 rounded-xl shadow-inner" id="qr-container">
                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(180)->generate(route('apar.show', $apar->id_apar)) !!}
                    </div>
                    <p class="text-xs text-base-content/60 mt-2">{{ $apar->id_apar }}</p>
                    <div class="flex gap-2 mt-4 w-full">
                        <button onclick="printQr()" class="btn btn-primary flex-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Print
                        </button>
                        <a href="{{ route('apar.qr.download', $apar->id_apar) }}" class="btn btn-secondary flex-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Download
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card bg-gradient-to-br from-primary to-secondary text-white shadow-lg">
                <div class="card-body">
                    <h3 class="font-semibold text-lg mb-4">Aksi Cepat</h3>
                    <div class="space-y-2">
                        <a href="{{ route('inspeksi.create.apar', $apar->id_apar) }}" class="btn btn-ghost bg-white/10 w-full justify-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Buat Inspeksi
                        </a>
                        <a href="{{ route('maintenance.index') }}?apar={{ $apar->id_apar }}" class="btn btn-ghost bg-white/10 w-full justify-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Buat Work Order
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function printQr() {
            const qrContainer = document.getElementById('qr-container');
            const printWindow = window.open('', '', 'width=400,height=500');
            printWindow.document.write(`
                <html>
                <head>
                    <title>QR Code - {{ $apar->id_apar }}</title>
                    <style>
                        body { 
                            display: flex; 
                            flex-direction: column;
                            align-items: center; 
                            justify-content: center; 
                            height: 100vh; 
                            margin: 0;
                            font-family: Arial, sans-serif;
                        }
                        .qr-wrapper {
                            text-align: center;
                            padding: 20px;
                            border: 2px solid #333;
                            border-radius: 10px;
                        }
                        h2 { margin: 0 0 10px; font-size: 18px; }
                        p { margin: 10px 0 0; font-size: 14px; color: #666; }
                    </style>
                </head>
                <body>
                    <div class="qr-wrapper">
                        <h2>APAR - {{ $apar->id_apar }}</h2>
                        ${qrContainer.innerHTML}
                        <p>{{ $apar->lokasi?->nama_lokasi ?? 'SMART K3' }}</p>
                    </div>
                </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        }
    </script>
</div>
