<div>
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold">Manajemen User</h1>
            <p class="text-base-content/60">Kelola akun pengguna sistem</p>
        </div>
        <button wire:click="openModal" class="btn btn-primary mt-4 md:mt-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah User
        </button>
    </div>

    @if(session()->has('message'))
    <div class="alert alert-success mb-4">{{ session('message') }}</div>
    @endif

    <div class="card bg-base-100 shadow-lg mb-4">
        <div class="card-body py-4">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari user..." class="input input-bordered w-full md:w-1/3" />
        </div>
    </div>

    <div class="card bg-base-100 shadow-lg">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Department</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr class="hover">
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar placeholder">
                                        <div class="bg-primary text-primary-content rounded-full w-10">
                                            <span>{{ $user->initials }}</span>
                                        </div>
                                    </div>
                                    <div class="font-medium">{{ $user->name }}</div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->department ?? '-' }}</td>
                            <td>
                                <span class="badge badge-outline badge-sm">{{ $user->roles->first()?->name ?? '-' }}</span>
                            </td>
                            <td>
                                <span class="badge {{ $user->is_active ? 'badge-success' : 'badge-ghost' }} badge-sm">
                                    {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td>
                                <button wire:click="openModal({{ $user->id }})" class="btn btn-ghost btn-sm btn-square">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center py-8 text-base-content/60">Tidak ada data user</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($users->hasPages())
            <div class="p-4 border-t">{{ $users->links() }}</div>
            @endif
        </div>
    </div>

    @if($showModal)
    <div class="modal modal-open">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-4">{{ $editMode ? 'Edit User' : 'Tambah User' }}</h3>
            <form wire:submit.prevent="save" class="space-y-4">
                <div class="form-control">
                    <label class="label"><span class="label-text">Nama *</span></label>
                    <input type="text" wire:model="name" class="input input-bordered w-full" />
                    @error('name') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Email *</span></label>
                    <input type="email" wire:model="email" class="input input-bordered w-full" />
                    @error('email') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Password {{ $editMode ? '(kosongkan jika tidak diubah)' : '*' }}</span></label>
                    <input type="password" wire:model="password" class="input input-bordered w-full" />
                    @error('password') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text">Phone</span></label>
                        <input type="text" wire:model="phone" class="input input-bordered w-full" />
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text">Department</span></label>
                        <input type="text" wire:model="department" class="input input-bordered w-full" />
                    </div>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Role *</span></label>
                    <select wire:model="role" class="select select-bordered w-full">
                        <option value="">Pilih Role</option>
                        @foreach($roles as $r)
                            <option value="{{ $r->name }}">{{ ucfirst($r->name) }}</option>
                        @endforeach
                    </select>
                    @error('role') <span class="label-text-alt text-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-control">
                    <label class="label cursor-pointer justify-start gap-4">
                        <input type="checkbox" wire:model="is_active" class="toggle toggle-success" />
                        <span class="label-text">User Aktif</span>
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
