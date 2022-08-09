<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'price', 'image', 'description'
    ];

    public function scopeFilter($query, array $filter)
    {
        if($filter['search'] ?? false){
            $query->where('name','like','%'.request('search').'%')
                ->orWhere('price','like','%'.request('search').'%')
                ->orWhere('description','like','%'.request('search').'%');
        }
    }
}
