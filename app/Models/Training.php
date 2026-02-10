<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $table = 'training';
    protected $primaryKey = 'id_training';

    protected $fillable = [
        'nama_training',
        'tanggal_training',
        'tempat',
        'instruktur',
        'materi',
    ];

    protected $casts = [
        'tanggal_training' => 'date',
    ];

    // Relationships
    public function users()
    {
        return $this->belongsToMany(User::class, 'training_user', 'id_training', 'id_user')
            ->withPivot(['kehadiran', 'nilai', 'sertifikat_path', 'catatan'])
            ->withTimestamps();
    }

    // Accessors
    public function getParticipantCountAttribute(): int
    {
        return $this->users()->count();
    }

    public function getAttendanceCountAttribute(): int
    {
        return $this->users()->wherePivot('kehadiran', true)->count();
    }

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('tanggal_training', '>=', now());
    }

    public function scopePast($query)
    {
        return $query->where('tanggal_training', '<', now());
    }
}


