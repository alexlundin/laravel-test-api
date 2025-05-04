<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionValue extends Model
{
    use HasFactory;

    protected $fillable = ['option_category_id', 'value'];

    public function category()
    {
        return $this->belongsTo(OptionCategory::class, 'option_category_id');
    }
}
