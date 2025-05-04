<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'option_value_id'];

    protected $primaryKey = ['product_id', 'option_value_id'];

    public $incrementing = false;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function optionValue()
    {
        return $this->belongsTo(OptionValue::class);
    }
}
