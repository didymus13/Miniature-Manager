<?php

namespace App\Http\Controllers;

use App\Collection;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    public function index(Request $request)
    {
        $tags = $request->get('tags');
        $collections = $tags ? Collection::withAnyTag($tags)->paginate() : Collection::paginate();
        return view('collection.index', ['collections' => $collections]);
    }

    public function show($slug)
    {
        $collection = Collection::where('slug', $slug)->with('miniatures')->firstOrFail();
        return view('collection.show', ['collection' => $collection]);
    }

    public function create()
    {
        $user = Auth::user();
        return view('collection.create', ['user' => $user]);
    }

    public function store(Requests\CollectionRequest $request)
    {
        $user = Auth::user();
        $collection = new Collection($request->all());
        if ($request->get('tags')) {
            $collection->retag($request->get('tags'));
        }
        $user->collections()->save($collection);
        return redirect(route('collections.show', $collection->slug));
    }

    public function edit($slug)
    {
        $collection = Collection::findBySlugOrFail($slug);
        $this->authorize('edit', $collection);
        return view('collection.edit', ['collection' => $collection]);
    }

    public function update(Request $request, $slug)
    {
        $collection = Collection::findBySlugOrFail($slug);
        $this->authorize('edit', $collection);
        $collection->update($request->all());

        if (isset($request->all()['tags']) && empty($request->get('tags'))) {
            $collection->untag();
        }
        
        if ($request->has('tags')) {
            $collection->retag($request->get('tags'));
        }
        $collection->tags;
        return $collection;
    }

    public function destroy($slug)
    {
        $collection = Collection::findBySlugOrFail($slug);
        $this->authorize('delete', $collection);
        $collection->delete();
        return redirect(route('collections.index'));
    }
}
