<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    use HasFactory;

    protected $fillable = [
        'userId',
        'preferenceId'
    ];

    protected $table = 'preferences';

    // Define any other model properties and methods as needed

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
