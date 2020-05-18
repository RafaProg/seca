<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Release extends Model
{
    protected $fillable = [
        'id',
        'classroom_id',
        'release_order'
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
