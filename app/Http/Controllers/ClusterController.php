<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClusterRequest;
use App\Cluster;
use Session;

class ClusterController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $cluster_list = Cluster::all();
        return view('cluster/index', compact('cluster_list'));
    }

    public function create() {
        return view('cluster.create');
    }

    public function store(ClusterRequest $request) {
        Cluster::create($request->all());
        Session::flash('flash_message', 'Data cluster berhasil disimpan.');
        return redirect('cluster');
    }

    public function edit(Cluster $cluster) {
        return view('cluster.edit', compact('cluster'));
    }

    public function update(Cluster $cluster, ClusterRequest $request) {
        $cluster->update($request->all());
        Session::flash('flash_message', 'Data cluster berhasil diupdate.');
        return redirect('cluster');
    }

    public function destroy(Cluster $cluster) {
        $cluster->delete();
        Session::flash('flash_message', 'Data cluster berhasil dihapus.');
        Session::flash('penting', true);
        return redirect('cluster');
    }
}
