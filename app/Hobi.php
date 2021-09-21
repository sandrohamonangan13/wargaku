<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hobi extends Model
{
    protected $table = 'hobi';

    protected $fillable = ['nama_hobi'];
    
    public function warga() {
        return $this->belongsToMany('App\Warga', 'hobi_warga', 'id_hobi', 'id_warga');
    }
}
