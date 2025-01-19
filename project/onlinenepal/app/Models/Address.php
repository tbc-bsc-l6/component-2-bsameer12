<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses'; // Specify table name if it doesn't follow convention

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'zip',
        'province',
        'city',
        'address',
        'locality',
        'landmark',
        'district',
        'is_default',
        'country',
    ];

    protected $attributes = [
        'is_default' => 0, // Default value for 'is_default'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
