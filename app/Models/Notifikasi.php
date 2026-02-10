<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasi';
    protected $primaryKey = 'id_notifikasi';

    protected $fillable = [
        'id_user',
        'judul',
        'pesan',
        'tipe_notifikasi',
        'prioritas',
        'link',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Accessors
    public function getPrioritasBadgeAttribute(): string
    {
        return match($this->prioritas) {
            'high' => 'badge-error',
            'medium' => 'badge-warning',
            'low' => 'badge-info',
            default => 'badge-ghost',
        };
    }

    public function getTipeIconAttribute(): string
    {
        return match($this->tipe_notifikasi) {
            'inspeksi' => 'clipboard-check',
            'maintenance' => 'wrench',
            'expired' => 'exclamation-circle',
            'system' => 'cog',
            default => 'bell',
        };
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeByTipe($query, $tipe)
    {
        return $query->where('tipe_notifikasi', $tipe);
    }

    public function scopeHighPriority($query)
    {
        return $query->where('prioritas', 'high');
    }

    // Methods
    public function markAsRead(): void
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    public static function send(int $userId, string $judul, string $pesan, string $tipe = 'system', string $prioritas = 'medium', ?string $link = null): self
    {
        return self::create([
            'id_user' => $userId,
            'judul' => $judul,
            'pesan' => $pesan,
            'tipe_notifikasi' => $tipe,
            'prioritas' => $prioritas,
            'link' => $link,
        ]);
    }

    public static function sendToAll(string $judul, string $pesan, string $tipe = 'system', string $prioritas = 'medium'): void
    {
        $users = User::all();
        foreach ($users as $user) {
            self::send($user->id, $judul, $pesan, $tipe, $prioritas);
        }
    }
}


