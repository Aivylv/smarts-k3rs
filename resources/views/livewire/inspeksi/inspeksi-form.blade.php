<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold">Form Inspeksi APAR</h1>
            <p class="text-base-content/60">Isi checklist inspeksi bulanan</p>
        </div>
        <a href="{{ route('inspeksi.index') }}" class="btn btn-ghost">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2 space-y-6">
            <!-- APAR Selection -->
            <div class="card bg-base-100 shadow-lg">
                <div class="card-body">
                    <h3 class="font-semibold text-lg mb-4">Pilih APAR</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text">APAR *</span></label>
                            <select wire:model.live="aparId" class="select select-bordered w-full">
                                <option value="">Pilih APAR...</option>
                                @foreach($aparList as $apar)
                                    <option value="{{ $apar->id_apar }}">
                                        {{ $apar->id_apar }} - {{ $apar->lokasi->nama_lokasi ?? '-' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('aparId') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Tanggal Inspeksi *</span></label>
                            <input type="date" wire:model="tanggal_inspeksi" class="input input-bordered w-full" />
                            @error('tanggal_inspeksi') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Checklist -->
            <div class="card bg-base-100 shadow-lg">
                <div class="card-body">
                    <h3 class="font-semibold text-lg mb-4">Checklist Inspeksi</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Kondisi Tabung -->
                        <div class="checklist-item cursor-pointer {{ $kondisi_tabung ? 'checked' : 'unchecked' }}" wire:click="$toggle('kondisi_tabung')">
                            <input type="checkbox" wire:model="kondisi_tabung" class="checkbox checkbox-success" onclick="event.stopPropagation()" />
                            <div>
                                <p class="font-medium">Kondisi Tabung</p>
                                <p class="text-xs text-base-content/60">Tidak berkarat, penyok, atau bocor</p>
                            </div>
                        </div>

                        <!-- Kondisi Selang -->
                        <div class="checklist-item cursor-pointer {{ $kondisi_selang ? 'checked' : 'unchecked' }}" wire:click="$toggle('kondisi_selang')">
                            <input type="checkbox" wire:model="kondisi_selang" class="checkbox checkbox-success" onclick="event.stopPropagation()" />
                            <div>
                                <p class="font-medium">Kondisi Selang</p>
                                <p class="text-xs text-base-content/60">Tidak retak, sobek, atau tersumbat</p>
                            </div>
                        </div>

                        <!-- Kondisi Pin -->
                        <div class="checklist-item cursor-pointer {{ $kondisi_pin ? 'checked' : 'unchecked' }}" wire:click="$toggle('kondisi_pin')">
                            <input type="checkbox" wire:model="kondisi_pin" class="checkbox checkbox-success" onclick="event.stopPropagation()" />
                            <div>
                                <p class="font-medium">Kondisi Pin Pengaman</p>
                                <p class="text-xs text-base-content/60">Pin terpasang dengan benar</p>
                            </div>
                        </div>

                        <!-- Kondisi Segel -->
                        <div class="checklist-item cursor-pointer {{ $kondisi_segel ? 'checked' : 'unchecked' }}" wire:click="$toggle('kondisi_segel')">
                            <input type="checkbox" wire:model="kondisi_segel" class="checkbox checkbox-success" onclick="event.stopPropagation()" />
                            <div>
                                <p class="font-medium">Kondisi Segel</p>
                                <p class="text-xs text-base-content/60">Segel masih utuh</p>
                            </div>
                        </div>

                        <!-- Kondisi Nozzle -->
                        <div class="checklist-item cursor-pointer {{ $kondisi_nozzle ? 'checked' : 'unchecked' }}" wire:click="$toggle('kondisi_nozzle')">
                            <input type="checkbox" wire:model="kondisi_nozzle" class="checkbox checkbox-success" onclick="event.stopPropagation()" />
                            <div>
                                <p class="font-medium">Kondisi Nozzle</p>
                                <p class="text-xs text-base-content/60">Tidak tersumbat atau rusak</p>
                            </div>
                        </div>

                        <!-- Kondisi Label -->
                        <div class="checklist-item cursor-pointer {{ $kondisi_label ? 'checked' : 'unchecked' }}" wire:click="$toggle('kondisi_label')">
                            <input type="checkbox" wire:model="kondisi_label" class="checkbox checkbox-success" onclick="event.stopPropagation()" />
                            <div>
                                <p class="font-medium">Label Terbaca</p>
                                <p class="text-xs text-base-content/60">Instruksi penggunaan terbaca jelas</p>
                            </div>
                        </div>

                        <!-- Kondisi Mounting -->
                        <div class="checklist-item cursor-pointer {{ $kondisi_mounting ? 'checked' : 'unchecked' }}" wire:click="$toggle('kondisi_mounting')">
                            <input type="checkbox" wire:model="kondisi_mounting" class="checkbox checkbox-success" onclick="event.stopPropagation()" />
                            <div>
                                <p class="font-medium">Mounting Bracket</p>
                                <p class="text-xs text-base-content/60">Bracket terpasang kuat</p>
                            </div>
                        </div>

                        <!-- Aksesibilitas -->
                        <div class="checklist-item cursor-pointer {{ $aksesibilitas ? 'checked' : 'unchecked' }}" wire:click="$toggle('aksesibilitas')">
                            <input type="checkbox" wire:model="aksesibilitas" class="checkbox checkbox-success" onclick="event.stopPropagation()" />
                            <div>
                                <p class="font-medium">Aksesibilitas</p>
                                <p class="text-xs text-base-content/60">Mudah dijangkau, tidak terhalang</p>
                            </div>
                        </div>

                        <!-- Signage -->
                        <div class="checklist-item cursor-pointer {{ $signage ? 'checked' : 'unchecked' }}" wire:click="$toggle('signage')">
                            <input type="checkbox" wire:model="signage" class="checkbox checkbox-success" onclick="event.stopPropagation()" />
                            <div>
                                <p class="font-medium">Signage</p>
                                <p class="text-xs text-base-content/60">Tanda lokasi APAR terlihat jelas</p>
                            </div>
                        </div>
                    </div>

                    <!-- Pressure Gauge -->
                    <div class="mt-6 p-4 bg-base-200/50 rounded-2xl">
                        <p class="font-medium text-base mb-3">Kondisi Pressure Gauge *</p>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <div class="p-4 rounded-xl cursor-pointer transition-all duration-200 {{ $kondisi_pressure === 'hijau' ? 'bg-success/20 ring-2 ring-success' : 'bg-base-100 hover:bg-base-200' }}" 
                                 wire:click="$set('kondisi_pressure', 'hijau')">
                                <div class="flex items-center gap-3">
                                    <div class="w-5 h-5 rounded-full bg-success flex items-center justify-center">
                                        @if($kondisi_pressure === 'hijau')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                        </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-medium">Hijau</p>
                                        <p class="text-xs text-base-content/60">Normal</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 rounded-xl cursor-pointer transition-all duration-200 {{ $kondisi_pressure === 'kuning' ? 'bg-warning/20 ring-2 ring-warning' : 'bg-base-100 hover:bg-base-200' }}"
                                 wire:click="$set('kondisi_pressure', 'kuning')">
                                <div class="flex items-center gap-3">
                                    <div class="w-5 h-5 rounded-full bg-warning flex items-center justify-center">
                                        @if($kondisi_pressure === 'kuning')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                        </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-medium">Kuning</p>
                                        <p class="text-xs text-base-content/60">Perlu Perhatian</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 rounded-xl cursor-pointer transition-all duration-200 {{ $kondisi_pressure === 'merah' ? 'bg-error/20 ring-2 ring-error' : 'bg-base-100 hover:bg-base-200' }}"
                                 wire:click="$set('kondisi_pressure', 'merah')">
                                <div class="flex items-center gap-3">
                                    <div class="w-5 h-5 rounded-full bg-error flex items-center justify-center">
                                        @if($kondisi_pressure === 'merah')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                        </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-medium">Merah</p>
                                        <p class="text-xs text-base-content/60">Kritis</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="card bg-base-100 shadow-lg">
                <div class="card-body">
                    <h3 class="font-semibold text-lg mb-4">Catatan & Rekomendasi</h3>
                    
                    <div class="form-control mb-4">
                        <label class="label"><span class="label-text">Catatan</span></label>
                        <textarea wire:model="catatan" class="textarea textarea-bordered h-24" placeholder="Catatan tambahan hasil inspeksi..."></textarea>
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text">Rekomendasi</span></label>
                        <textarea wire:model="rekomendasi" class="textarea textarea-bordered h-24" placeholder="Rekomendasi tindak lanjut jika ada..."></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Selected APAR Info -->
            @if($selectedApar)
            <div class="card bg-base-100 shadow-lg">
                <div class="card-body">
                    <h3 class="font-semibold text-lg mb-4">Info APAR</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-base-content/60">ID APAR:</span>
                            <span class="font-mono font-medium">{{ $selectedApar->id_apar }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-base-content/60">Tipe:</span>
                            <span class="badge badge-outline">{{ $selectedApar->tipe_apar_label }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-base-content/60">Merk:</span>
                            <span>{{ $selectedApar->merk }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-base-content/60">Kapasitas:</span>
                            <span>{{ $selectedApar->kapasitas }} Kg</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-base-content/60">Lokasi:</span>
                            <span>{{ $selectedApar->lokasi->nama_lokasi ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-base-content/60">Status:</span>
                            <span class="badge {{ $selectedApar->status_badge_class ?? 'badge-info' }} badge-sm">{{ $selectedApar->status }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-base-content/60">Expire:</span>
                            <span class="{{ $selectedApar->is_expired ? 'text-error' : '' }}">{{ $selectedApar->tanggal_expire?->format('d/m/Y') ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Checklist Summary -->
            <div class="card bg-base-100 shadow-lg">
                <div class="card-body">
                    <h3 class="font-semibold text-lg mb-4">Ringkasan</h3>
                    @php
                        $checklistItems = [
                            $kondisi_tabung, $kondisi_selang, $kondisi_pin, $kondisi_segel,
                            $kondisi_nozzle, $kondisi_label, $kondisi_mounting, $aksesibilitas, $signage
                        ];
                        $passed = collect($checklistItems)->filter()->count();
                        $total = count($checklistItems);
                        $percentage = $total > 0 ? round(($passed / $total) * 100) : 0;
                    @endphp
                    <div class="text-center mb-4">
                        <div class="radial-progress text-{{ $percentage >= 80 ? 'success' : ($percentage >= 50 ? 'warning' : 'error') }}" style="--value:{{ $percentage }}; --size:6rem;">
                            {{ $percentage }}%
                        </div>
                    </div>
                    <p class="text-center text-sm text-base-content/60">
                        {{ $passed }}/{{ $total }} checklist terpenuhi
                    </p>
                    <div class="mt-3 flex items-center justify-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-{{ $kondisi_pressure === 'hijau' ? 'success' : ($kondisi_pressure === 'kuning' ? 'warning' : 'error') }}"></span>
                        <span class="text-sm">Pressure: {{ ucfirst($kondisi_pressure) }}</span>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="card bg-gradient-to-br from-primary to-secondary text-white shadow-2xl overflow-hidden">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">Simpan Inspeksi</h3>
                            <p class="text-sm opacity-80">Data akan tersimpan</p>
                        </div>
                    </div>
                    <p class="text-sm opacity-70 mb-4">Pastikan semua data sudah benar sebelum menyimpan.</p>
                    <button wire:click="save" class="btn btn-lg w-full bg-white text-primary hover:bg-white/90 border-0 shadow-lg" wire:loading.attr="disabled">
                        <span wire:loading.remove class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="font-semibold">Simpan Inspeksi</span>
                        </span>
                        <span wire:loading class="flex items-center gap-2">
                            <span class="loading loading-spinner"></span>
                            Menyimpan...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
