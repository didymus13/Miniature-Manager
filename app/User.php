<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App
 * json_data schema:
 *  - avatar: url
 *  - cover: url
 *  - tagline : string
 *  - bio: text
 *  - social: [facebook: url, twitter: url, website: url, etc..]
 */
class User extends Authenticatable
{
    use Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'json_data'
    ];
    protected $casts = [
        'json_data' => 'object'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function collections()
    {
        return $this->hasMany(Collection::class);
    }
}
