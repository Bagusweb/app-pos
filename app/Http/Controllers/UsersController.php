<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Users;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataUser = Users::orderBy('user_id', 'desc')->get();
        return view('users.index', compact('dataUser'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
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
            'name'  => 'required',
            'email' => 'required|unique:tbl_users',
            'password' => 'required|min:8',
            'role' => 'required'
        ]);

        Users::create([
            'name'  => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect(route('user.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
    {
            $dataEdituser = Users::find($id);
            if (!$dataEdituser) {
                return redirect()->route('user.index');
            }
            return view('users.edit', compact('dataEdituser'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validasi data tanpa mewajibkan password
        $this->validate($request, [
            'name'  => 'required',
            'email' => 'required|unique:tbl_users,email,' . $id . ',user_id',
            'password' => 'nullable|min:8', // Password tidak wajib diisi
            'role' => 'required'
        ]);

        // Cari data pengguna berdasarkan ID
        $dataUpdateuser = Users::findOrFail($id);

        // Siapkan array update data pengguna
        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Hanya hash dan update password jika diisi
        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($request->password);
        }

        // Update data pengguna
        $dataUpdateuser->update($updateData);

        return redirect(route('user.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Users::where('user_id', $id)->delete();
        redirect(route('user.index'));
    }
}