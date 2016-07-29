<?php

namespace App\Http\Controllers;

use App\Collection;
use App\Events\CollectionViewed;
use App\Http\Requests;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class CollectionController extends Controller
{
    use SluggableScopeHelpers;
    
    /**
     * Get list of collections.
     * @param Request $request &tags to filter by tag slug
     * @return mixed
     */
    public function index(Request $request)
    {
        $tags = $request->get('tags');
        $collections = Collection::defaultOrder();
        if ($tags) {
            $collections = $collections->withAnyTag($tags);
        }
        return view('collection.index', ['collections' => $collections->paginate()]);
    }

    /**
     * Show a single collection
     * @param $slug
     * @return mixed
     */
    public function show($slug)
    {
        $collection = Collection::where('slug', $slug)->with('miniatures')->firstOrFail();
        Event::fire(new CollectionViewed($collection));
        return view('collection.show', ['collection' => $collection]);
    }

    /**
     * Displays the collection creation form
     * @return mixed
     */
    public function create()
    {
        $user = Auth::user();
        return view('collection.create', ['user' => $user]);
    }

    /**
     * Saves a new Collection to the database
     * @param Requests\CollectionRequest $request
     * @return mixed
     */
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

    /**
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update(Request $request, $slug)
    {
        $collection = Collection::findBySlugOrFail($slug);
        $this->authorize('edit', $collection);
        $collection->update($request->all());

        $this->handleTagChanges($request, $collection);
        return $collection;
    }

    /**
     * @param Request $request
     * @param $collection
     */
    protected function handleTagChanges(Request $request, $collection)
    {
        if (isset($request->all()['tags']) && empty($request->get('tags'))) {
            $collection->untag();
        }

        if ($request->has('tags')) {
            $collection->retag($request->get('tags'));
        }
        $collection->tags;
    }

    /**
     * Deltes a collection and related items from the database
     * @param $slug
     * @return mixed
     * @throws \Exception
     */
    public function destroy($slug)
    {
        $collection = Collection::findBySlugOrFail($slug);
        $this->authorize('delete', $collection);
        $collection->delete();
        return redirect(route('collections.index'));
    }
}
