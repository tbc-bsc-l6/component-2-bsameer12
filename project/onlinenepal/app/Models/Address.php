<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;
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
        'country',
        'isdefault'
    ];

    protected $attributes = [
        'isdefault' => 0, // Default value for 'is_default'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
