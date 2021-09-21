<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{
    protected $table = 'cluster';

    protected $fillable = ['nama_cluster'];

    public function warga() {
        return $this->hasMany('App\Warga', 'id_cluster');
    }
}
