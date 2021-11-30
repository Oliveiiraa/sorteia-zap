<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    use HasFactory;

    protected $table = 'awards';

    protected $fillable = [
        'name',
        'description',
        'image',
        'draw_id',
        'finish'
    ];

    public function draw()
    {
        return $this->belongsTo('App\Models\Draw');
    }

    public function winners()
    {
        return $this->belongsTo('App\Models\Winner');
    }
}
