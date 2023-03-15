<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use App\Http\Requests\StoreUserRequest;

class AdminUserController extends Controller
{
    private const PER_PAGE = 10;

    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        $users = User::all();
        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    /**
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        $user = User::query()->findOrFail($id);
        return view('admin.users.edit', ['user' => $user]);
    }


    /**
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(Auth::id())],
        ]);

        $user = User::query()->findOrFail($request->id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        User::query()->findOrFail($id)->delete();
        return redirect()->route('login');
    }
}
