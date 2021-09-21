<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Warga;
use App\Telepon;
use App\Cluster;
use App\Hobi;
use App\Http\Requests\WargaRequest;
use Storage;
use Session;


class WargaController extends Controller
{
    public function __construct() {
        $this->middleware('auth', ['except' => [
            'index', 'show', 'cari'
        ]]);
    }

    /*
    | -------------------------------------------------------------------------------------------------------
    | INDEX
    | -------------------------------------------------------------------------------------------------------
    */
    public function index() {
        $warga_list = Warga::paginate(5);
        $jumlah_warga = Warga::count();
        return view('warga.index', compact('warga_list', 'jumlah_warga'));
    }


    /*
    | -------------------------------------------------------------------------------------------------------
    | SHOW DETAIL
    | -------------------------------------------------------------------------------------------------------
    */
    public function show(Warga $warga) {
        return view('warga.show', compact('warga'));
    }


    /*
    | -------------------------------------------------------------------------------------------------------
    | CREATE
    | -------------------------------------------------------------------------------------------------------
    */
    public function create() {
        return view('warga.create');
    }


    /*
    | -------------------------------------------------------------------------------------------------------
    | EDIT
    | -------------------------------------------------------------------------------------------------------
    */
    public function edit(Warga $warga) {
        if (!empty($warga->telepon->nomor_telepon)) {
            $warga->nomor_telepon = $warga->telepon->nomor_telepon;
        }

        return view('warga.edit', compact('warga'));
    }


    /*
    | -------------------------------------------------------------------------------------------------------
    | CREATE
    | -------------------------------------------------------------------------------------------------------
    */
    public function store(WargaRequest $request) {
        $input = $request->all();

        // Upload foto.
        if ($request->hasFile('foto')) {
            $input['foto'] = $this->uploadFoto($request);
        }

        // Insert warga.
        $warga = Warga::create($input);

        // Insert Telepon.
        if ($request->filled('nomor_telepon')) {
            $this->insertTelepon($warga, $request);
        }

        // Insert Hobi.
        $warga->hobi()->attach($request->input('hobi_warga'));

        // Flass message.
        Session::flash('flash_message', 'Data warga berhasil disimpan.');

        return redirect('warga');
    }


    /*
    | -------------------------------------------------------------------------------------------------------
    | UPDATE
    | -------------------------------------------------------------------------------------------------------
    */
    public function update(Warga $warga, WargaRequest $request) {
        $input = $request->all();

        // Update foto.
        if ($request->hasFile('foto')) {
            $input['foto'] = $this->updateFoto($warga, $request);
        }

        // Update warga.
        $warga->update($input);

        // Update telepon.
        $this->updateTelepon($warga, $request);

        // Update hobi.
        $warga->hobi()->sync($request->input('hobi_warga'));

        // Flash message.
        Session::flash('flash_message', 'Data warga berhasil diupdate.');

        return redirect('warga');
    }


    /*
    | -------------------------------------------------------------------------------------------------------
    | DESTROY / DELETE
    | -------------------------------------------------------------------------------------------------------
    */
    public function destroy(Warga $warga) {
        // Hapus foto kalau ada.
        $this->hapusFoto($warga);

        $warga->delete();

        // Flash message.
        Session::flash('flash_message', 'Data warga berhasil dihapus.');
        Session::flash('penting', true);

        return redirect('warga');
    }


    /*
    | -------------------------------------------------------------------------------------------------------
    | CARI
    | -------------------------------------------------------------------------------------------------------
    */
    public function cari(Request $request) {
        $kata_kunci = trim($request->input('kata_kunci'));

        if (! empty($kata_kunci)) {
            $jenis_kelamin = $request->input('jenis_kelamin');
            $id_cluster = $request->input('id_cluster');

            // Query
            $query = Warga::where('nama_warga', 'LIKE', '%' . $kata_kunci . '%');
            (! empty($jenis_kelamin)) ? $query->JenisKelamin($jenis_kelamin) : '';
            (! empty($id_cluster)) ? $query->cluster($id_cluster) : '';

            $warga_list = $query->paginate(2);

            // URL Links pagination
            $pagination = (! empty($jenis_kelamin)) ? $warga_list->appends(['jenis_kelamin' => $jenis_kelamin]) : '';
            $pagination = (! empty($id_cluster)) ? $pagination = $warga_list->appends(['id_cluster' => $id_cluster]) : '';
            $pagination = $warga_list->appends(['kata_kunci' => $kata_kunci]);

            $jumlah_warga = $warga_list->total();
            return view('warga.index', compact('warga_list', 'kata_kunci', 'pagination', 'jumlah_warga', 'id_cluster', 'jenis_kelamin'));
        }

        return redirect('warga');
    }


    /*
    | -------------------------------------------------------------------------------------------------------
    | INSERT TELEPON
    | -------------------------------------------------------------------------------------------------------
    */
    private function insertTelepon(Warga $warga, WargaRequest $request) {
        $telepon = new Telepon;
        $telepon->nomor_telepon = $request->input('nomor_telepon');
        $warga->telepon()->save($telepon);
    }


    /*
    | -------------------------------------------------------------------------------------------------------
    | UPDATE TELEPON
    | -------------------------------------------------------------------------------------------------------
    */
    private function updateTelepon(Warga $warga, WargaRequest $request) {
        if ($warga->telepon) {
            // Jika telp diisi, update.
            if ($request->filled('nomor_telepon')) {
                $telepon = $warga->telepon;
                $telepon->nomor_telepon = $request->input('nomor_telepon');
                $warga->telepon()->save($telepon);
            }
            // Jika telp tidak diisi, hapus.
            else {
                $warga->telepon()->delete();
            }
        }
        // Buat entry baru, jika sebelumnya tidak ada no telp.
        else {
            if ($request->filled('nomor_telepon')) {
                $telepon = new Telepon;
                $telepon->nomor_telepon = $request->input('nomor_telepon');
                $warga->telepon()->save($telepon);
            }
        }
    }


    /*
    | -------------------------------------------------------------------------------------------------------
    | UPLOAD FOTO
    | -------------------------------------------------------------------------------------------------------
    */
    private function uploadFoto(WargaRequest $request) {
        $foto = $request->file('foto');
        $ext  = $foto->getClientOriginalExtension();

        if ($request->file('foto')->isValid()) {
            $foto_name   = date('YmdHis'). ".$ext";
            $request->file('foto')->move('fotoupload', $foto_name);
            return $foto_name;
        }
        return false;
    }

    /*
    | -------------------------------------------------------------------------------------------------------
    | UPDATE FOTO
    | -------------------------------------------------------------------------------------------------------
    */
    private function updateFoto(Warga $warga, WargaRequest $request) {
        // Jika user mengisi foto.
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada foto baru.
            $exist = Storage::disk('foto')->exists($warga->foto);
            if (isset($warga->foto) && $exist) {
                $delete = Storage::disk('foto')->delete($warga->foto);
            }

            // Upload foto baru.
            $foto = $request->file('foto');
            $ext  = $foto->getClientOriginalExtension();
            if ($request->file('foto')->isValid()) {
                $foto_name   = date('YmdHis'). ".$ext";
                $upload_path = 'fotoupload';
                $request->file('foto')->move($upload_path, $foto_name);
                return $foto_name;
            }
        }
    }


    /*
    | -------------------------------------------------------------------------------------------------------
    | HAPUS FOTO
    | -------------------------------------------------------------------------------------------------------
    */
    private function hapusFoto(Warga $warga) {
        $is_foto_exist = Storage::disk('foto')->exists($warga->foto);

        if ($is_foto_exist) {
            Storage::disk('foto')->delete($warga->foto);
        }
    }


    /*
    | -------------------------------------------------------------------------------------------------------
    | DATE MUTATOR
    | -------------------------------------------------------------------------------------------------------
    */
    public function dateMutator() {
        $warga = Warga::findOrFail(1);
        $nama = $warga->nama_warga;
        $tanggal_lahir = $warga->tanggal_lahir->format('d-m-Y');
        $ulang_tahun = $warga->tanggal_lahir->addYears(30)->format('d-m-Y');
        return "Warga <strong>{$nama}</strong> lahir pada <strong>{$tanggal_lahir}</strong>.<br>
                Ulang tahun ke-30 akan jatuh pada <strong>{$ulang_tahun}</strong>.";
    }

}