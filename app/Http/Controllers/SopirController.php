<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Sopir;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class SopirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sopir = Sopir::query()->when(Request::input('search'), function($qeury,$search){
            return $qeury->where('nama', 'like', '%'. $search .'%')
                ->orWhere('nik', 'like',  '%'. $search .'%')
                ->orWhere('no_hp', 'like',  '%'. $search .'%')
                ->orWhere('alamat', 'like',  '%'. $search .'%');
        })->orderBy('id', 'desc')->paginate(10);
        return Inertia::render('Sopir/Sopir',[
            'sopir'=> $sopir,
            'filter'=> Request::all('search'),
            'can'=> [
                'create'=> Auth::user()->can('mobil create'),
                'edit'=> Auth::user()->can('mobil edit'),
                'show'=> Auth::user()->can('mobil show'),
                'delete'=> Auth::user()->can('mobil delete'),
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
        return Inertia::render('Sopir/FormSupir', [
            'sopir'=> null,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        Sopir::create(
            Request::validate([
                'nama' => ['required', 'string'],
                'nik' => ['required', 'numeric'],
                'alamat' => ['required', 'string'],
                'no_hp' => ['required', 'numeric'],
            ])
        );
        return Redirect::route('Sopir.index')->with('success', 'Berhasil Di Tambah!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sopir  $sopir
     * @return \Illuminate\Http\Response
     */
    public function show(Sopir $sopir)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sopir  $sopir
     * @return \Illuminate\Http\Response
     */
    public function edit(Sopir $sopir,$id)
    {
        return Inertia::render('Sopir/FormSupir', [
            'sopir'=> $sopir->find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sopir  $sopir
     * @return \Illuminate\Http\Response
     */
    public function update(Sopir $sopir,$id)
    {
        $sopir->find($id)->update(
            Request::validate([
                'nama' => ['required', 'string'],
                'nik' => ['required', 'numeric'],
                'alamat' => ['required', 'string'],
                'no_hp' => ['required', 'numeric'],
            ])
        );
        return Redirect::route('Sopir.index')->with('success', 'Berhasil Di Edit!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sopir  $sopir
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sopir $sopir,$id)
    {
        $sopir->find($id)->delete();
        return Redirect::route('Sopir.index')->with('success', 'Berhasil Di Hapus!!');
    }
}
