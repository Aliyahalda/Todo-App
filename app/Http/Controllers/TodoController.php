<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function login()
    {
        return view('dashboard.login');
    }

    public function todo()
    {
        
        $todos = Todo::all();

        return view('index', compact('todos'));
    }

    public function register()
    {
        return view('dashboard.register');
    } 

    public function inputRegister(Request $request)
    {
        // testing hasil input
        // dd($request->all());
        // validasi atau aturan value column pada db
        $request->validate([
            'email' => 'required',
            'name' => 'required|min:4|max:50',
            'username' => 'required|min:4|max:8',
            'password' => 'required',
        ]);
        // tambah data ke db bagian table users
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        // apabila berhasil, bkl diarahin ke hlmn login dengan pesan success
        return redirect('/')->with('success', 'berhasil membuat akun!');
    }

    public function auth(Request $request)
    {
        $request->validate([
            'username' => 'required|exists:users,username',
            'password' => 'required',
        ],[
            'username.exists' => "This username doesn't exists"
        ]);

        $user = $request->only('username', 'password');
        if (Auth::attempt($user)) {
            return redirect()->route('todo.index');
        } else {
            // dd('salah');
            return redirect('/')->with('fail', "Gagal login, periksa dan coba lagi!");
        }
    }

    public function logout()
    {
        // menghapus history login
        Auth::logout();
        // mengarahkan ke halaman login lagi
        return redirect('/');
    }

    public function index()
    {
        //menampilkan halaman awal, semua data
        // ambil data dari table todos dengan model todo
        // filter data dari database -> where('colom', 'perbandingan', 'value')
        // get()->ambil data
        // filter data table todos yang isi colum user_id nya sama dengan data history login bagian id 

        $todos = Todo::where('user_id', '=', Auth::user()->id)->get();
        // Kirim data yang sudah diambil ke file blade/ ke fila yang menampilkan halaman
        return view('dashboard.index', compact('todos'));

        
    }

    public function complated()
    {
        return view('dashboard.complated');
    }
    public function updateComplated($id)
    {
        //cari data yang mau di ubah statusnya jadi 'complated' dan colum 'done_time' yang tadinya null, diisi dengan tanggal (tgl ketika data todo di ubah statusnya)
        //karena status boolean, san 0 itu untuk kondisi todo on-progress, jdi i nya untuk kondisi todo complated
        Todo::where('id', '=', $id)->update([
            'status' => 1, 
            'done_time' => \Carbon\Carbon::now(),
        ]);
        return redirect()->back()->with('done', "Todo telah selesai di kerjakan!");
    }
    public function create()
    {
        //menampilkan halaman input form tambah data
        return view('dashboard.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //mengirim data ke database (data baru) / menambahkan data baru ke db
       $request->validate([
            'title' => 'required|min:3',
            'date' => 'required',
            'description' => 'required|min:5',

       ]);

       Todo::create([
        'title' => $request->title,
        'date' =>$request->date,
        'description' =>$request->description,
        'user_id' => Auth::user()->id,
        'status' => 0,

       ]);

       return redirect('/')-> with('successAdd', 'Berhasil menambahkan Task!');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        //menampilkan satu data
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit($id)

    {
        $todo = Todo::where('id', $id)->first();
        return view('dashboard.edit', compact('todo'));
        
        //menampilkan form edit data

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo, $id)
    {
        $request->validate([
            'title' => 'required',
            'date' => 'required',
            'description' => 'required',
        ]);
        //cari baris data yang punya id sama dengan data id yang dikirimkan ke parameter route 
        //kalau udah ketemu, update column-column datanya
        Todo::where('id' , $id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'user_id' => Auth::user()->id,
            'status' => 0,
        ]);
        //kalau sudah berhasil halaman bakal di redirect ulang ke halaman awal todo dengan pesan pemberitahuan
        return redirect('/todo')->with('success', 'Data todo berhasil diperbaharui');
    }
        //mengubah data di database
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //menghapus data di database
        //filter / cari data yang mau di hapus, baru jalankan perintah hapusnya
        Todo::where('id', '=',$id)->delete();
        //kalau udah, balik lagi ke halaman awalnya dengan pemberitahuan
        return redirect()->back()->with('delete', 'Berhasil menghapus data todo!');

    }
}
