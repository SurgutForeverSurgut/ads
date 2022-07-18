<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Ad extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price'
    ];

    protected $dates = [
        'created_at'
    ];

    protected $casts = [
        'created_at' => 'date:Y-m-d'
    ];

    protected $hidden = [
        'updated_at'
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public static function add(Request $request)
    {
        $newAd = Ad::create($request->only(['name', 'description', 'price']));
        foreach($request->images as $link){
            $newAd->images()->save(
                new Image(['link' => $link])
            );
        }

        return $newAd->id;
    }
    
}
