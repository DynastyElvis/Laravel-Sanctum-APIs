<?php

namespace App\Models;
// namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
// {
//     use HasFactory;
// }


{
    protected $fillable = [
        'name', 'image', 'slug'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}



