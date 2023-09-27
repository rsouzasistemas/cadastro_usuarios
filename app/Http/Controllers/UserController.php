<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('userPhones')->paginate();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!User::create($request->all())) {
            return redirect()->route('users.create')->with('alert-danger', 'O registro não foi efetuado!');
        }

        return redirect()->route('users.index')->with('alert-success', 'Registro efetuado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!$user = User::where('id', $id)->with('userPhones')->first()) {
            return redirect()->route('users.index')->with('alert-danger', 'Registro não localizado!');
        }

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!$user = User::where('id', $id)->with('userPhones')->first()) {
            return redirect()->route('users.index')->with('alert-danger', 'Registro não localizado!');
        }

        $data = $request->all();
        $data['password'] = $user->password;

        if (!$user->update($data)) {
            return redirect()->route('users.edit', $id)->with('alert-danger', 'Não foi possível atualizar o registro!');
        }

        return redirect()->route('users.index')->with('alert-success', 'Registro atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!$user = User::where('id', $id)->with('userPhones')->first()) {
            return redirect()->route('users.index')->with('alert-danger', 'Registro não localizado!');
        }

        if (!$user->delete($id)) {
            return redirect()->route('users.index')->with('alert-danger', 'Não foi possível apagar o registro!');
        }

        return redirect()->route('users.index')->with('alert-success', 'Registro apagado com sucesso!');
    }
}
