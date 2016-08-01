<?php

namespace App\Http\Controllers;

use App\Collection;
use App\Http\Requests;
use App\Miniature;
use App\Photo;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Storage;
use Intervention\Image\Facades\Image;

class MiniatureController extends Controller
{
    public function show($slug)
    {
        $mini = Miniature::findBySlugOrFail($slug);
        return view('miniature.show', ['miniature' => $mini]);
    }

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

    public function uploadPhotos(Request $request, $slug)
    {
        $mini = Miniature::findBySlugOrFail($slug);

        if (Gate::denies('edit', $mini)) {
            abort(403);
        }

        $file = $request->file('file');
        $user = $mini->collection->user;

        $photo = new Photo([
            'title' => $file->getClientOriginalName()
        ]);
        $photo->slug = SlugService::createSlug(Photo::class, 'slug', $file->getClientOriginalName());
        $targetPath = $user->slug
            . DIRECTORY_SEPARATOR . $mini->collection->slug
            . DIRECTORY_SEPARATOR . $photo->slug . '-' . uniqid();
        $ext = $file->getClientOriginalExtension();
        $fullImagePath = $targetPath . ".$ext";
        $thumbnailImagePath = $targetPath . "-thumb.$ext";
        $photo->url = $fullImagePath;
        $photo->thumb_url = $thumbnailImagePath;

        $mini->photos()->save($photo);


        $disk = Storage::disk('s3-public');

        // Make Image
        $image = Image::make($file->getRealPath());
        // prevent possible upsizing
        $image->resize(null, 1080, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->resize(1080, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        $disk->put($fullImagePath, $image->stream()->__toString(), 'public');

        // Make Thumbnail
        $image->fit(360, 360, function ($constraint) {
            $constraint->upsize();
        });
        $disk->put($thumbnailImagePath, $image->stream()->__toString(), 'public');

        $photo->url = $fullImagePath;
        $photo->thumb_url = $thumbnailImagePath;
        $photo->save();
        return $photo;
    }
}
