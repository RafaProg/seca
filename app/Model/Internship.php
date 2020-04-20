<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    protected $fillable = [
        'classroom_id',
        'is_in_internship',
        'first_order'
    ];

    public function classroom()
    {
        return $this->hasOne(Classroom::class);
    }
}
