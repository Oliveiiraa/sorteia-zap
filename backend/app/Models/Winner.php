<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Winner extends Model
{
    use HasFactory;

    protected $table = 'winners';

    protected $fillable = [
        'customer_id',
        'award_id',
        'draw_id'
    ];

    public function awards()
    {
        return $this->belongsTo('App\Models\Award');
    }

    public function customers()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function draws()
    {
        return $this->belongsTo('App\Models\Draw');
    }
}
