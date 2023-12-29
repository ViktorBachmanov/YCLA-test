<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Relations\HasOne;


class Product extends Model
{
    use HasFactory;

    /**
     * Get the options associated with the product.
     */
    public function options(): HasOne
    {
        return $this->hasOne(Option::class);
    }

    public static function getFilteredProducts(string|null $nameFilter): Builder
    {
        return Product::when($nameFilter, function (Builder $query, string $nameFilter) {
            $query->where('name', 'like', "%{$nameFilter}%");
        })->with(['options']);
    }
}
