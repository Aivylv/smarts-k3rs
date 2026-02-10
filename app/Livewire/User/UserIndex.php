<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $editMode = false;
    public $userId = null;

    public $name = '';
    public $email = '';
    public $password = '';
    public $phone = '';
    public $department = '';
    public $role = '';
    public $is_active = true;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'password' => $this->editMode ? 'nullable|min:6' : 'required|min:6',
            'phone' => 'nullable|string|max:20',
            'department' => 'nullable|string|max:100',
            'role' => 'required|exists:roles,name',
        ];
    }

    public function openModal($id = null)
    {
        $this->resetForm();
        if ($id) {
            $this->editMode = true;
            $this->userId = $id;
            $user = User::findOrFail($id);
            $this->name = $user->name;
            $this->email = $user->email;
            $this->phone = $user->phone;
            $this->department = $user->department;
            $this->role = $user->roles->first()?->name;
            $this->is_active = $user->is_active;
        }
        $this->showModal = true;
    }

    public function resetForm()
    {
        $this->editMode = false;
        $this->userId = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->phone = '';
        $this->department = '';
        $this->role = '';
        $this->is_active = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'department' => $this->department,
            'is_active' => $this->is_active,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->editMode) {
            $user = User::findOrFail($this->userId);
            $user->update($data);
            $user->syncRoles([$this->role]);
            session()->flash('message', 'User berhasil diperbarui.');
        } else {
            $user = User::create($data);
            $user->assignRole($this->role);
            session()->flash('message', 'User berhasil ditambahkan.');
        }

        $this->showModal = false;
        $this->resetForm();
    }

    public function render()
    {
        $users = User::with('roles')
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%")->orWhere('email', 'like', "%{$this->search}%"))
            ->orderBy('name')
            ->paginate(10);

        $roles = Role::orderBy('name')->get();

        return view('livewire.user.user-index', [
            'users' => $users,
            'roles' => $roles,
        ])->layout('layouts.app', ['title' => 'Manajemen User']);
    }
}
