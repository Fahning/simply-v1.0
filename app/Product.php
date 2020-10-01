<?php

namespace App;

use App\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new TenantScope);
    }

    protected $fillable = [
        'code',
        'price',
        'image',
        'name',
        'stock',
        'manufacturing_date',
        'shelflife_date',
        'tenant_id',
        'brand_id',
        'model_id',
        'category_id',
        'created_at',
        'updated_at'
    ];

    public function vendas()
    {
        return $this->hasMany(Sells::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function model()
    {
        return $this->belongsTo(Models::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }


}
