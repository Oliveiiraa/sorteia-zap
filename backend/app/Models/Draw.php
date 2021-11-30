<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Draw extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'draws';

    protected $fillable = [
        'name',
        'service_id',
        'date_draw',
        'finish',
        'name_service',
        'qr_code_image'
    ];

    public function awards()
    {
        return $this->hasMany('App\Models\Award');
    }

    public function customers()
    {
        return $this->hasMany('App\Models\Customer');
    }

    public function winners()
    {
        return $this->hasMany('App\Models\Winner');
    }
}
