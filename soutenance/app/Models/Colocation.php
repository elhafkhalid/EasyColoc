<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colocation extends Model
{
    protected $fillable = [
        'name',
        'owner_id',
        'status'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'memberships')
            ->withPivot('role', 'join_at', 'left_at');
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function depenses()
    {
        return $this->hasMany(Depense::class);
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }
}
