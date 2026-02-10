<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Lokasi extends Model // implements Auditable
{
    use HasFactory;
    // use \OwenIt\Auditing\Auditable;

    protected $table = 'lokasi';
    protected $primaryKey = 'id_lokasi';

    protected $fillable = [
        'nama_lokasi',
        'gedung',
        'lantai',
        'ruangan',
        'koordinat',
        'kategori_risiko',
        'deskripsi',
    ];

    protected $casts = [
        'kategori_risiko' => 'string',
    ];

    // Relationships
    public function apar()
    {
        return $this->hasMany(Apar::class, 'id_lokasi', 'id_lokasi');
    }

    // Accessors
    public function getFullLokasiAttribute(): string
    {
        return "{$this->gedung} - Lt. {$this->lantai} - {$this->ruangan}";
    }

    // Scopes
    public function scopeByGedung($query, $gedung)
    {
        return $query->where('gedung', $gedung);
    }

    public function scopeRisikoTinggi($query)
    {
        return $query->where('kategori_risiko', 'tinggi');
    }
}


