<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //posts tábla létrehozása, paraméterek a migration fájlban

    // Table name
    public $table = 'posts';
    // Primary key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
