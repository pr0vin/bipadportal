<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $guarded = [];

    // get the url with $document->url
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }

    public function getNicenameAttribute()
    {
        return $this->name;
    }

    // get the organization document belongs to
    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }

    public function isImage()
    {
        if (!$this->path) {
            return false;
        }
        $imageExtensions = [
            'jpg', 'jpeg',
            'gif', 'png',
            'bmp', 'svg',
            'jpe', 'wbmp'
        ];
        $exploded = explode('.', $this->path);
        $extension = end($exploded);

        return in_array($extension, $imageExtensions);
    }
}
