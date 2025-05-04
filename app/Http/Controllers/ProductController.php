<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\OptionCategory;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->has('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        foreach ($request->all() as $key => $value) {
            if (in_array($key, ['price_min', 'price_max', 'search', 'sort', 'direction', 'page', 'per_page'])) {
                continue;
            }

            $normalizedKey = str_replace('_', ' ', $key);

            $category = OptionCategory::where('name', $normalizedKey)->first();

            if ($category) {
                $values = is_array($value) ? $value : explode(',', $value);

                $normalizedValues = array_map('trim', $values);

                $query->whereHas('options', function ($q) use ($category, $normalizedValues) {
                    $q->where('option_category_id', $category->id)
                        ->whereIn('value', $normalizedValues);
                });
            }
        }

        $sortField = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'desc');

        if (in_array($sortField, ['name', 'price', 'created_at'])) {
            $query->orderBy($sortField, $direction === 'asc' ? 'asc' : 'desc');
        }

        $perPage = $request->input('per_page', 15);

        return ProductResource::collection(
            $query->paginate($perPage)
        );
    }
}
