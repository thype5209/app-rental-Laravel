<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetPengguna()
    {
        $pengguna = Pengguna::all();
        return response()->json($pengguna);
    }
    public function index()
    {
        $pengguna = Pengguna::all();
        return Inertia::render('Pengguna/Pengguna', [
            'pengguna' => $pengguna
        ]);
    }
    public function cariNIK()
    {
        $pengguna = Pengguna::where('nik', 'like', '%' .  FacadesRequest::input('search') . '%')->get();
        return json_encode($pengguna);
    }
    public function GetID($id)
    {
        $pengguna = Pengguna::with('sewa', 'sewa.waktusewa')->whereHas('sewa', function ($query) {
            $query->whereIn('status', ['Sewa', 'Belum Dibayar', 'Telat']);
        })->get();
        if ($pengguna->count() > 0) {
            $resp = Pengguna::with('sewa', 'sewa.waktusewa')->whereHas('sewa', function ($query) {
                $query->whereIn('status', ['Sewa', 'Belum Dibayar', 'Telat']);
            })->find($id);
            $code = true;
        } else {
            $resp = Pengguna::with('sewa', 'sewa.waktusewa')->find($id);
            $code = false;
        }
        $data = [
            'query' => $resp,
            'status' => $code,
        ];
        return json_encode($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pengguna  $pengguna
     * @return \Illuminate\Http\Response
     */
    public function show(Pengguna $pengguna)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pengguna  $pengguna
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengguna $pengguna)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pengguna  $pengguna
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pengguna $pengguna)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pengguna  $pengguna
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengguna $pengguna)
    {
        //
    }
}
