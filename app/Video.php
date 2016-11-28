<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Video extends Model
{
    protected $fillable = [
        'filename'
    ];

    public function getUrlAttribute()
    {
        return Storage::url($this->filename);
    }
}
