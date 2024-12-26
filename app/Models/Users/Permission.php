<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'name',
        'description',
        'resource_type',
        'resource_id'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
