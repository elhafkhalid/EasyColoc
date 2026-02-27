<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class depense extends Model
{
    protected $fillable = [
        'colocation_id',
        'titre',
        'amount',
        'date',
        'category_id',
        'payeur_id',
    ];
    
    public function colocation()
    {
        return $this->belongsTo(colocation::class);
    }

    public function category()
    {
        return $this->belongsTo(category::class);
    }

    public function payeur()
    {
        return $this->belongsTo(user::class, 'payeur_id');
    }

    public function createBy()
    {
        return $this->belongsTo(user::class, 'created_id');
    }
}
