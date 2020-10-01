<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\TenantScope;

class Sells extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new TenantScope);
    }

    protected $fillable = [
        'id',
        'total_price',
        'discount',
        'tenant_id',
        'created_at',
        'updated_at'
    ];

    public function produtos()
    {
        return $this->hasMany(SellsProduct::class);
    }
}
