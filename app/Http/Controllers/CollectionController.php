<?php

namespace App\Http\Controllers;

use App\Collection;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    public function index()
    {
        return view('collection.index', ['collections' => Collection::paginate()]);
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
        $user->collections()->save($collection);
        return redirect(route('collections.show', $collection->slug));
    }

    public function edit($slug)
    {
        $collection = Collection::findBySlugOrFail($slug);
        $this->authorize('edit', $collection);
        return view('collection.edit', ['collection' => $collection]);
    }

    public function update(Requests\CollectionRequest $request, $slug)
    {
        $collection = Collection::findBySlugOrFail($slug);
        $this->authorize('edit', $collection);
        $collection->update($request->all());
        return redirect(route('collections.show', $collection->slug));
    }

    public function destroy($slug)
    {
        $collection = Collection::findBySlugOrFail($slug);
        $this->authorize('delete', $collection);
        $collection->delete();
        return redirect(route('collections.index'));
    }
}
