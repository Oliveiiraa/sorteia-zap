<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'name',
        'draw_id',
        'number',
        'image',
        'contact_id',
        'number_draw',
        'service_id'
    ];

    public function winners()
    {
        return $this->belongsTo('App\Models\Winner');
    }

    public function draws()
    {
        return $this->belongsTo('App\Models\Draw');
    }
}
