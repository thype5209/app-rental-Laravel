<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\Sewa;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetAllUser()
    {
        $user = User::all();
        return $user;
    }

    public function Dashboard(){
        $carbon = Carbon::now()->format('m');
        $tgl_bsok = Carbon::now()->addDay('+1')->format('Y-m-d');
        $sewa = Sewa::whereMonth('created_at', $carbon)->get();
        $sewa_telat = Sewa::with(['waktusewa','pengguna','sopir'])->whereHas('waktusewa', function($query)use($tgl_bsok){
            $query->whereDate('tgl_kembali', $tgl_bsok);
        })->get();
        return Inertia::render('Dashboard',[
            'penyewa'=> $sewa->count(),
            'totalPendapatan'=> Sewa::where('status','=','Selesai')->sum('total'),
            'mobilSewa'=> Mobil::where('status', '=', '1')->count(),
            'SewaTelat'=> Sewa::where('status', '=', 'Telat')->get(),
            'mobil'=> Mobil::paginate(10),
            'sewaTerbaru'=> Sewa::with(['pengguna','waktusewa'])->orderBy('id', 'desc')->where('status', '=', 'Sewa')->paginate(5),
            'sewatelat'=> $sewa_telat,
        ]);
    }
    public function index()
    {
        return Inertia::render('User/Index', [
            'user' => User::with(['roles'])
                ->where('id', "!=",'1')
                ->paginate(10),
            'can' => [
                'create' => Auth::user()->can('user create'),
                'edit' => Auth::user()->can('user edit'),
                'delete' => Auth::user()->can('user delete'),
            ]
        ]);
    }
    public function create()
    {
        return Inertia::render('User/Form', [
            'can' => [
                'create' => Auth::user()->can('user create'),
                'edit' => Auth::user()->can('user edit'),
                'delete' => Auth::user()->can('user delete'),
            ],
            'role'=> Role::query()->orderBy('name', 'asc')->get(),
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
        Request::validate([
            'nama' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role'=> 'required'
        ]);
        $user = User::create([
            'name' => Request::input('nama'),
            'email' => Request::input('email'),
            'password' => bcrypt(Request::input('password')),
        ]);
        $user->assignRole(['name'=>Request::input('role')]);

        return Redirect::route('User.index')->with('success', ' Berhasil Di Tambah!!!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }
    public function edit(User $user, $id)
    {
        return Inertia::render('User/Form', [
            'user'=> $user->with(['roles'])->find($id),
            'can' => [
                'create' => Auth::user()->can('user create'),
                'edit' => Auth::user()->can('user edit'),
                'delete' => Auth::user()->can('user delete'),
            ],
            'role'=> Role::query()->orderBy('name', 'asc')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, $id)
    {
        Request::validate([
            'nama' => 'required|string',
            'email' => 'required|email|exists:users,email',
            'password' => 'nullable',
            'role'=> 'required'
        ]);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        // DB::table('model_has_roles')->create([
        //     'model_id'=> $id,
        // ]);
        $user->find($id)->update([
            'name' => Request::input('nama'),
            'email' => Request::input('email'),
            'password' => bcrypt(Request::input('password')) ?? null,
        ]);
        $user->find($id)->assignRole(['name'=>Request::input('role')]);

        return Redirect::route('User.index')->with('success', ' Berhasil Di Edit!!!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
