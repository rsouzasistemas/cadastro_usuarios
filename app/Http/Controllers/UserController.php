<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Models\UserPhone;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = (new User)->listUsers();
        return view('users.index', compact('users'));
    }

    public function show_phones($id)
    {
        $userPhones = UserPhone::where('user_id', $id)->select('phone_number')->get()->toArray();
        return response()->json($userPhones);
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
    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();
        $createReturn = (new User)->createUser($data);

        return redirect()->route($createReturn['routeReturn'])->with($createReturn['alert'], $createReturn['msg']);
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
    public function update(UserUpdateRequest $request, string $id)
    {
        if (!$user = User::where('id', $id)->with('userPhones')->first()) {
            return redirect()->route('users.index')->with('alert-danger', 'Registro não localizado!');
        }

        $data = $request->validated();

        if ($data['password']) {
            $data['password'] = bcrypt($data['password']);
        } else {
            $data['password'] = $user->password;
        }

        $updateReturn = (new User)->updateUser($data, $user);

        $returnId = null;
        if ($updateReturn['alert'] == 'alert-danger') {
            $returnId = $id;
        }

        return redirect()->route($updateReturn['routeReturn'], $returnId)
            ->with($updateReturn['alert'], $updateReturn['msg']);
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
