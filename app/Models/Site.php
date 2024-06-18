<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $fillable = ['url', 'name', 'owner_id', 'status'];


    public function links()
    {
        return $this->hasMany(Link::class);
    }
}
