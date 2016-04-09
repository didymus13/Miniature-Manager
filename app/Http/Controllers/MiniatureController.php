<?php

namespace App\Http\Controllers;

use App\Collection;
use App\Http\Requests;
use App\Miniature;
use App\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

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

    public function uploadPhotos(Request $request, $slug)
    {
        $mini = Miniature::findBySlugOrFail($slug);

        if (Gate::denies('edit', $mini)) {
            abort(403);
        }

        $file = $request->file('file');

        $user = $mini->collection->user;

        $photo = new Photo([
            'caption' => $file->getClientOriginalName(),
        ]);
        $mini->photos()->save($photo);

        $targetPath = $user->slug
            . DIRECTORY_SEPARATOR . $mini->collection->slug
            . DIRECTORY_SEPARATOR . $photo->slug;
        $ext = $file->getClientOriginalExtension();

        $fullImagePath = $targetPath . ".$ext";
        $thumbnailImagePath = $targetPath . "-thumb.$ext";

        $disk = Storage::disk('public');
        $disk->put(
            $fullImagePath,
            file_get_contents($file->getRealPath())
        );

        // Make Thumbnail
        $thumbnail = Image::make($disk->get($fullImagePath));
        $thumbnail->fit(180, 180, function ($constraint) {
            $constraint->upsize();
        });
        $disk->put($thumbnailImagePath, $thumbnail->stream());

        $photo->url = $fullImagePath;
        $photo->thumb_url = $thumbnailImagePath;
        $photo->save();
        return $photo;
    }
}
