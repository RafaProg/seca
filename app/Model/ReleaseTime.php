<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ReleaseTime extends Model
{
    protected $table = 'release_times';

    protected $fillable = ['release_time', 'release_in_sequence'];
}
