<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'link'
    ];

    protected $hidden = [
        'id',
        'ad_id',
        'created_at',
        'updated_at'
    ];

    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }
}
