<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'guard_name',
        'description',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
