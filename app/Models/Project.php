<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'link',
        'slug',
        'github_link',
        'status',
    ];
public function getRouteKeyName()
{
    return 'slug';
}
}