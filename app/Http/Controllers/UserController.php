<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\User;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use SluggableScopeHelpers;

    public function update(Request $request, $slug)
    {
        $user = User::findBySlugOrFail($slug);
        $this->authorize('edit', $user);
        $user->update($request->all());
        return $user;
    }
}
