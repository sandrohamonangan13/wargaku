<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    protected $table = 'warga';

    protected $fillable = [
        'nik',
        'nama_warga',
        'tanggal_lahir',
        'jenis_kelamin',
        'id_cluster',
        'foto'
    ];

    protected $dates = ['tanggal_lahir'];

    // Relasi warga - Hobi
    public function hobi() {
        return $this->belongsToMany('App\Hobi', 'hobi_warga', 'id_warga', 'id_hobi')->withTimeStamps();
    }


    // Relasi warga - cluster
    public function cluster() {
        return $this->belongsTo('App\Cluster', 'id_cluster');
    }


    // Relasi warga - Telepon
    public function telepon() {
        return $this->hasOne('App\Telepon', 'id_warga');
    }


    // Accessor
    public function getNamaWargaAttribute($nama_warga) {
        return ucwords($nama_warga);
    }


    // Mutator
    public function setNamaWargaAttribute($nama_warga) {
        $this->attributes['nama_warga'] = strtolower($nama_warga);
    }


    // Accessor
    public function getHobiWargaAttribute() {
        return $this->hobi->pluck('id')->toArray();
    }

    // Scope cluster
    public function scopeCluster($query, $id_cluster) {
        return $query->where('id_cluster', $id_cluster);
    }

    // Scope Jenis Kelamin
    public function scopeJenisKelamin($query, $jenis_kelamin) {
        return $query->where('jenis_kelamin', $jenis_kelamin);
    }

}
