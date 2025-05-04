<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function values()
    {
        return $this->hasMany(OptionValue::class, 'option_category_id');
    }
}
