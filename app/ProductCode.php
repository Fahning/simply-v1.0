<?php

namespace App;

use App\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Model;

class ProductCode extends Model
{
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new TenantScope);
    }

    protected $fillable = [
        'id',
        'tenant_id'
    ];
}
