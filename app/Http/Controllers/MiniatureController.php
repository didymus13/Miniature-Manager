<?php

namespace App\Http\Controllers;

use App\Collection;
use App\Http\Requests;
use App\Miniature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MiniatureController extends Controller
{
    public function store(Requests\MiniatureRequest $request)
    {
        $collection = Collection::findBySlugOrFail($request->get('collection'));
        $miniature = new Miniature($request->all());
        $collection->miniatures()->save($miniature);
        return redirect(route('collections.show', $collection->slug));
    }

    public function update(Request $request, $slug)
    {
        $mini = Miniature::findBySlugOrFail($slug);
        if (Gate::denies('edit', $mini)) {
            abort(403);
        }
        $mini->update($request->all());
        return $mini;
    }

    public function destroy($slug)
    {
        $mini = Miniature::findBySlugOrFail($slug);
        if (Gate::denies('delete', $mini)) {
            abort(403);
        }
        $mini->delete();
        return response()->json(['deleted'], 204);
    }
}
