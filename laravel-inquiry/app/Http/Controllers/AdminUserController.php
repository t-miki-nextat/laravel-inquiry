<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\User\StorePost;
use App\Http\Requests\User\UpdatePut;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    private const PER_PAGE = 10;

    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        $users = User::query()->orderBy('id')->paginate(self::PER_PAGE, ['*'], 'page', '1');
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
    public function edit(int $id): View
    {
        $user = User::query()->findOrFail($id);
        return view('admin.users.edit', ['user' => $user]);
    }


    /**
     * @param UpdatePut $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UpdatePut $request, User $user): RedirectResponse
    {
        $user = User::query()->findOrFail($request->id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        return redirect()->route('admin.users.index')->with('flash_message', '更新しました');
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        User::query()->findOrFail($id)->delete();
        return redirect()->route('admin.users.index');
    }
}
