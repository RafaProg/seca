<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = [
        'id',
        'classroom',
        'first_order'
    ];

    public function internship()
    {
        return $this->hasOne(Internship::class);
    }
}
