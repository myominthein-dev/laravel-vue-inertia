<?php

namespace App\Models;

use App\Policies\CategoryPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    protected $fillable = ['name'];

    public function courses () {
        return $this->hasMany(Course::class);
    }
}
