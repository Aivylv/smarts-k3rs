<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
// use OwenIt\Auditing\Contracts\Auditable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable // // implements Auditable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasApiTokens;
    // use \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'department',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Relationships
    public function inspeksi()
    {
        return $this->hasMany(Inspeksi::class, 'id_user');
    }

    public function maintenanceAsTechnician()
    {
        return $this->hasMany(Maintenance::class, 'teknisi_id');
    }

    public function maintenanceAsSupervisor()
    {
        return $this->hasMany(Maintenance::class, 'supervisor_id');
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'id_user');
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'id_user');
    }

    public function unreadNotifikasi()
    {
        return $this->notifikasi()->unread();
    }

    public function training()
    {
        return $this->belongsToMany(Training::class, 'training_user', 'id_user', 'id_training')
            ->withPivot(['kehadiran', 'nilai', 'sertifikat_path', 'catatan'])
            ->withTimestamps();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByDepartment($query, $department)
    {
        return $query->where('department', $department);
    }

    // Accessors
    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->name);
        $initials = '';
        foreach (array_slice($words, 0, 2) as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }
        return $initials;
    }

    // Methods
    public function getUnreadNotificationCount(): int
    {
        return $this->notifikasi()->unread()->count();
    }
}


