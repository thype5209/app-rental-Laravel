<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Mobil;
use App\Models\Sewa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request as FacadesRequest;

class MobilController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:mobil list', ['only' => ['index', 'show']]);
        $this->middleware('can:mobil create', ['only' => ['create', 'store']]);
        $this->middleware('can:mobil edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:mobil delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FacadesRequest $request)
    {
        return Inertia::render('Mobil/Mobil', [
            'TabStatus' => FacadesRequest::input('status', '0'),
            'filter' => FacadesRequest::all('search'),
            'mobil' => Mobil::query()
                ->orderBy("unit")
                ->filter(FacadesRequest::only('search', 'status'))
                ->when(FacadesRequest::input('search'), function ($qeury, $search) {
                    return $qeury->where('unit', 'like', '%' . $search . '%')
                        ->orWhere('nopol', 'like', '%' . $search . '%')
                        ->orWhere('spesifikasi', 'like', '%' . $search . '%');
                })
                ->paginate(10),
            'can' => [
                'list' => Auth::user()->can('mobil list'),
                'create' => Auth::user()->can('mobil create'),
                'edit' => Auth::user()->can('mobil edit'),
                'delete' => Auth::user()->can('mobil delete'),
            ]

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Mobil/FormMobil');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'unit' => ['required', 'string'],
            'harga' => ['required', 'numeric'],
            'nopol' => ['required', 'string'],
        ]);
        $nama1 = "fotoMobil/" . $request->unit . '-' . $request->foto1->getClientOriginalName();
        $nama2 = "fotoMobil/" . $request->unit . '-' . $request->foto2->getClientOriginalName();
        $nama3 = "fotoMobil/" . $request->unit . '-' . $request->foto3->getClientOriginalName();
        $nama4 = "fotoMobil/" . $request->unit . '-' . $request->foto4->getClientOriginalName();

        $request->foto1->storeAs('public', $nama1);
        $request->foto2->storeAs('public', $nama2);
        $request->foto3->storeAs('public', $nama3);
        $request->foto4->storeAs('public', $nama4);
        Mobil::create([
            'unit' => $request->unit,
            'harga' => $request->harga,
            'nopol' => $request->nopol,
            'tahun' => $request->tahun,
            'spesifikasi' => $request->spesifikasi,
            'foto1' => $nama1,
            'foto2' => $nama2,
            'foto3' => $nama3,
            'foto4' => $nama4,
            'status' => '2'
        ]);

        return Redirect::route('Mobil.index')->with('success', 'Berhasil Di Tambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mobil  $mobil
     * @return \Illuminate\Http\Response
     */
    public function show(Mobil $mobil, $id)
    {

        return Inertia::render('Mobil/Show', [
            'mobil' => $mobil->find($id),
            'id' => $id,
        ]);
    }


    /**
     * riwayat
     *  Tampilan riwayat Mobil
     * @param  mixed $mobil
     * @param  mixed $id
     * @return void
     */
    public function riwayat(Mobil $mobil, $id)
    {
        return Inertia::render('Mobil/RiwayatMobil', [
            'riwayat' => Sewa::whereHas('mobil',function($query)use($id){
                $query->where('id', $id);
            })
            ->with(['waktusewa', 'mobil','user','pengguna'])
            ->where('status', '=', 'Selesai')
            ->paginate(10),
            'id' => $id,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mobil  $mobil
     * @return \Illuminate\Http\Response
     */
    public function edit(Mobil $mobil, $id)
    {
        $data = $mobil->find($id);
        return Inertia::render('Mobil/EditMobil', [
            'mobil' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mobil  $mobil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mobil $mobil, $id)
    {
        $this->validate($request, [
            'unit' => ['required', 'string'],
            'harga' => ['required', 'numeric'],
            'nopol' => ['required', 'string'],
        ]);
        $file1 = $request->file('foto1');
        $file2 = $request->file('foto2');
        $file3 = $request->file('foto3');
        $file4 = $request->file('foto4');
        $mobil = $mobil->find($request->id);

        $nama = array($mobil->foto1, $mobil->foto2, $mobil->foto3, $mobil->foto4);
        $collectFoto = [$file1, $file2, $file3, $file4];
        for ($i = 0; $i < count($collectFoto); $i++) {
            if ($collectFoto[$i] != null) {
                $nama[] = $request->unit . '-' . $collectFoto[$i]->getClientOriginalName();
                if (Storage::disk('public/mobil')->exists($nama[$i])) {
                    Storage::disk('public/mobil')->delete($nama[$i]);
                    Storage::put('public/fotoMobil/' . $nama[$i]);
                }
            }
        }
        Mobil::find($request->id)->update([
            'unit' => $request->unit,
            'harga' => $request->harga,
            'nopol' => $request->nopol,
            'tahun' => $request->tahun,
            'spesifikasi' => $request->spesifikasi,
            'foto1' => $nama[0],
            'foto2' => $nama[1],
            'foto3' => $nama[2],
            'foto4' => $nama[3],
            'status' => '1'
        ]);
        return Redirect::route('Mobil.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mobil  $mobil
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mobil $mobil, $id)
    {

        $mobil = $mobil->find($id);
        $nama = array($mobil->foto1, $mobil->foto2, $mobil->foto3, $mobil->foto4);
        for ($i = 0; $i < count($nama); $i++) {
            if ($nama[$i] != null) {
                if (Storage::disk('public')->exists($nama[$i])) {
                    Storage::disk('public')->delete($nama[$i]);
                }
            }
        }
        $mobil->find($id)->delete();
    }
    public function StatusUpdate(Mobil $mobil, $id, Request $request)
    {
        $mobil->find($id)->update([
            'status' => $request->status,
        ]);
    }

    public function StatusModal()
    {
        return Inertia::dialog('Mobil/status');
    }
    public function GetIDMobil($id)
    {
        $mobil = Mobil::find($id);

        return response()->json($mobil);
    }
}
