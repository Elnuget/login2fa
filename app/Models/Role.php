<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $fillable = ['name', 'guard_name'];
    // Definir la relación con permisos
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }
}
