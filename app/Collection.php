<?php

namespace App;

use Conner\Tagging\Taggable;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use Sluggable, Taggable, SluggableScopeHelpers;

    protected $fillable = ['label', 'description'];

    public static function boot()
    {
        parent::boot();
        Collection::deleting(function($collection) {
            foreach($collection->miniatures as $mini) {
                $mini->delete();
            }
        });
    }

    public function getFeaturedImageAttribute()
    {
        foreach ($this->miniatures()->with('photos')->get() as $mini) {
            foreach($mini->photos as $photo) {
                return $photo;
            }
        };
        return null;
    }

    public function miniatures()
    {
        return $this->hasMany(Miniature::class);
    }

    public function getSizeAttribute()
    {
        return $this->miniatures()->count();
    }

    public function getProgressAttribute()
    {
        return round($this->miniatures->avg('progress'), 0);
    }

    public function getPhotosAttribute()
    {
        $photos = collect([]);
        foreach ($this->miniatures as $mini) {
            $photos = $photos->merge($mini->photos);
        };
        return $photos;
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'label'
            ]
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->morphToMany(Photo::class, 'imageable');
    }

    public function scopeDefaultOrder($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }
}
