<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $fillable = [
        'name',
        'colocation_id',
    ];
    
    public function colocation(){
        return $this->belongsTo(colocation::class);
    }

    public function depenses(){
        return $this->hasMany(depense::class);
    }
}
