<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = [
        'id',
        'classroom'
    ];

    public function internship()
    {
        return $this->hasOne(Internship::class);
    }

    public function release()
    {
        return $this->hasOne(Release::class);
    }
}
