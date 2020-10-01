<?php

namespace App;

use App\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new TenantScope);
    }
    protected $fillable = [
        'id',
        'name',
        'description',
        'image',
        'tenant_id',
        'created_at',
        'updated_at'
    ];

    public function produtos() {
        return $this->hasMany(Product::class);
    }
}
