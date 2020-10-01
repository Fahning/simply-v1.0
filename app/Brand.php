<?php

namespace App;

use App\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new TenantScope);
    }
    
    protected $fillable = [
        'name',
        'description',
        'image',
        'tenant_id',
        'created_at',
        'updated_at'
    ];
}
