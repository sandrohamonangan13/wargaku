<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telepon extends Model
{
    protected $table = 'telepon';
    protected $primaryKey = 'id_warga';
    protected $fillable = ['id_warga', 'nomor_telepon'];

    public function warga() {
        return $this->belongsTo('App\Warga', 'id_warga');
    }
}
