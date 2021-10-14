<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * @param User $user
     * @return ViewFactory|View
     */
    public function show(User $user)
    {
        /** @var User $loggedInUser */
        $loggedInUser = Auth::user();
        $canUpdate = $loggedInUser->can('update', $user);
        $headerMessage = $canUpdate ? 'マイページ' : $user->name . 'さんのページ';

        return view('user.show', compact('user', 'canUpdate', 'headerMessage'));
    }

    /**
     * @param User $user
     * @return ViewFactory|View
     */
    public function edit(User $user)
    {
        // 更新可能なユーザーかどうかの認証を行う(権限のない場合は403を返す)
        $this->authorize('update', $user);

        return view('user.edit', compact('user'));
    }

    /**
     * @param UpdateRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, User $user)
    {
        DB::transaction(function () use ($request, $user) {
            $user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
            ]);
        });

        $request->session()->flash('status', 'プロフィールを更新しました');

        return redirect()->route('user.edit', ['user' => $user]);
    }
}
