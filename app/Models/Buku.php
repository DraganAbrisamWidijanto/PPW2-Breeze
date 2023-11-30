<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';
    protected $fillable = [
        'judul',
        'penulis',
        'harga',
        'tgl_terbit',
        'filename',
        'filepath',
        'buku_seo'
    ];
    protected $dates = ['tgl_terbit'];

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }

    public function photos()
    {
        return $this->hasMany('App\Models\Buku', 'id', 'id');
    }
    
    public function getAvgRatingAttribute()
{
    $totalRating = $this->rating_1 + $this->rating_2 + $this->rating_3 + $this->rating_4 + $this->rating_5;
    $jumlahRating = $this->rating_1 + $this->rating_2 + $this->rating_3 + $this->rating_4 + $this->rating_5;

    return ($jumlahRating > 0) ? $totalRating / $jumlahRating : 0;
}
}
