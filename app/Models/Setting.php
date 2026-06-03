<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'site_name',
        'hero_title',
        'hero_subtitle',
        'email',
        'github_url',
        'linkedin_url',
        'resume',
        'profile_photo',
    ];

    public static function instance(): self
    {
        return self::firstOrCreate(['id' => 1], [
            'site_name'    => 'Kushal.dev',
            'hero_title'   => 'Kushal Ghimire',
            'hero_subtitle'=> 'Frontend Developer · Backend Specialist · Vibe Coder',
            'email'        => 'kushal.upr@gmail.com',
            'github_url'   => 'https://github.com/Ghimire-Kushal',
            'linkedin_url' => 'https://www.linkedin.com/in/kushal-ghimire-9448093b1/',
        ]);
    }
}
