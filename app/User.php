<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Cviebrock\EloquentSluggable;

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
class User extends Authenticatable implements EloquentSluggable\SluggableInterface
{
    use EloquentSluggable\SluggableTrait;

    protected $sluggable = [
        'build_from' => 'name',
        'save_to' => 'slug'
    ];
    
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

    public function collections()
    {
        return $this->hasMany(Collection::class);
    }
}
