<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.user.index', [
            'users' => User::orderBy('id', 'DESC')->get(),
        ]);
    }

    public function changePassword($id)
    {
        $arr['user'] = DB::table('users')->where('id', $id)->first();
        return view('admin.user.reset-password')->with($arr);
    }

    public function changePasswordSave(Request $request)
    {

        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // dd($request->userID);
        $password = Hash::make($request->password);


        $affected = DB::table('users')
            ->where('id', $request->userID)
            ->update(['password' => $password]);

        return redirect('user');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $arr['user'] = DB::table('users')->where('id', $id)->first();
        return view('admin.user.edit')->with($arr);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        $user->position = $request->position;
        $user->save();
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (Gate::denies('director-only')) {
            return redirect()->route('user.index');
        }
        $user->delete();

        return redirect()->route('user.index');
    }
}
