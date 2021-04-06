<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    protected $hidden = [
        'questions',
    ];

    public function questions()
    {
        return $this->hasMany('App\Models\Question');
    }
}
