<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class UserController extends Controller
{
    public function update(Request $request, $slug)
    {
        $user = User::findBySlugOrFail($slug);
        $this->authorize('edit', $user);
        $user->update($request->all());
        return $user;
    }
}
