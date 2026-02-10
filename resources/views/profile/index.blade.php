<x-layouts.app title="Profil Saya">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold">Profil Saya</h1>
                <p class="text-base-content/60">Kelola informasi profil Anda</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Profile Card -->
            <div class="lg:col-span-1">
                <div class="card bg-gradient-to-br from-primary to-secondary text-white shadow-xl">
                    <div class="card-body items-center text-center">
                        <div class="avatar placeholder mb-4">
                            <div class="bg-white/20 text-white rounded-full w-24 ring ring-white/30 ring-offset-2 ring-offset-primary">
                                <span class="text-3xl font-bold">{{ substr(auth()->user()->name, 0, 2) }}</span>
                            </div>
                        </div>
                        <h2 class="card-title text-xl">{{ auth()->user()->name }}</h2>
                        <p class="opacity-80">{{ auth()->user()->email }}</p>
                        <div class="flex gap-2 mt-3 flex-wrap justify-center">
                            @foreach(auth()->user()->roles ?? [] as $role)
                            <span class="badge bg-white/20 border-0">{{ $role->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="card bg-base-100 shadow-lg mt-4">
                    <div class="card-body">
                        <h3 class="font-semibold mb-3">Statistik</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-base-content/60">Inspeksi Bulan Ini</span>
                                <span class="badge badge-primary">{{ \App\Models\Inspeksi::where('id_user', auth()->id())->whereMonth('created_at', now()->month)->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-base-content/60">Total Inspeksi</span>
                                <span class="badge badge-secondary">{{ \App\Models\Inspeksi::where('id_user', auth()->id())->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Details -->
            <div class="lg:col-span-2 space-y-6">
                <div class="card bg-base-100 shadow-lg">
                    <div class="card-body">
                        <h3 class="font-semibold text-lg mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Informasi Pribadi
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-base-200/50 rounded-xl p-4">
                                <p class="text-sm text-base-content/60 mb-1">Nama Lengkap</p>
                                <p class="font-medium">{{ auth()->user()->name }}</p>
                            </div>
                            <div class="bg-base-200/50 rounded-xl p-4">
                                <p class="text-sm text-base-content/60 mb-1">Email</p>
                                <p class="font-medium">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="bg-base-200/50 rounded-xl p-4">
                                <p class="text-sm text-base-content/60 mb-1">Department</p>
                                <p class="font-medium">{{ auth()->user()->department ?? '-' }}</p>
                            </div>
                            <div class="bg-base-200/50 rounded-xl p-4">
                                <p class="text-sm text-base-content/60 mb-1">Telepon</p>
                                <p class="font-medium">{{ auth()->user()->phone ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card bg-base-100 shadow-lg">
                    <div class="card-body">
                        <h3 class="font-semibold text-lg mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Status Akun
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-base-200/50 rounded-xl p-4">
                                <p class="text-sm text-base-content/60 mb-1">Status</p>
                                <span class="badge {{ auth()->user()->is_active ? 'badge-success' : 'badge-error' }} badge-lg">
                                    {{ auth()->user()->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </div>
                            <div class="bg-base-200/50 rounded-xl p-4">
                                <p class="text-sm text-base-content/60 mb-1">Bergabung Sejak</p>
                                <p class="font-medium">{{ auth()->user()->created_at->format('d F Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
