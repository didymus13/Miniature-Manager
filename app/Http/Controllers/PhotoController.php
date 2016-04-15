<?php

namespace App\Http\Controllers;

use App\Photo;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Gate;

class PhotoController extends Controller
{
    public function destroy($id)
    {
        $photo = Photo::where('id', $id)->firstOrFail();

        if (Gate::denies('delete', $photo)) {
            abort(403);
        }

        $photo->delete();
        return response()->json(['deleted'], 204);
    }

    public function show($id)
    {
        $photo = Photo::find($id)->with('imageable')->firstOrFail();
        return view('photo.show', ['photo' => $photo]);
    }
}
