<?php

namespace App;

use App\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Model;

class SellsProduct extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new TenantScope);
    }

    protected $fillable = [
        'id',
        'sells_id',
        'product_id',
        'quantity',
        'discount',
        'tenant_id',
        'created_at',
        'updated_at'
    ];

    public function produto()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
