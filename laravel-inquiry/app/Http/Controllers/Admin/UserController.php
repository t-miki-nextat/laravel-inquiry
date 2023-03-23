<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\IndexGet;
use App\Http\Requests\User\StorePost;
use App\Http\Requests\User\UpdatePut;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    private const PER_PAGE = 10;

    /**
     * Display a listing of the resource.
     * @param IndexGet $request
     * @return View
     */
    public function index(IndexGet $request): View
    {
        if ($request['page'] = null) {
            $page=1;
        } else {
            $page = (int)$request['page'];
        }
        $users = User::query()->orderBy('created_at')->paginate(self::PER_PAGE, ['*'], 'page', $page);
        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * @param StorePost $request
     * @return RedirectResponse
     */
    public function store(StorePost $request): RedirectResponse
    {
        $validated = $request->validated();
        $user = new User();

        $user->fill($validated)->save();
        return redirect()->route('admin.users.index')->with('flash_message', 'ユーザー登録しました');
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
        $validated = $request->validated();
        $user = User::query()->findOrFail($request->id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->fill($validated)->save();


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
