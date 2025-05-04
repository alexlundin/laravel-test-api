<?php

namespace Tests\Feature;

use App\Models\OptionCategory;
use App\Models\OptionValue;
use App\Models\Product;
use App\Models\ProductOption;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductFilterTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_can_get_all_products()
    {
        $response = $this->getJson('/api/products');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'price',
                    'options',
                ],
            ],
            'links',
            'meta',
        ]);
    }

    public function test_can_filter_products_by_price_range()
    {
        $minPrice = 1000;
        $maxPrice = 2000;

        $response = $this->getJson("/api/products?price_min={$minPrice}&price_max={$maxPrice}");

        $response->assertStatus(200);

        $products = $response->json('data');
        foreach ($products as $product) {
            $this->assertGreaterThanOrEqual($minPrice, $product['price']);
            $this->assertLessThanOrEqual($maxPrice, $product['price']);
        }
    }

    public function test_can_search_products_by_name()
    {
        $uniqueId = uniqid();
        $productName = "Люстра Тестовая {$uniqueId}";

        $product = Product::create([
            'name' => $productName,
            'description' => "Описание тестовой люстры {$uniqueId}",
            'price' => 1500,
            'quantity' => 10,
        ]);

        $this->assertNotNull($product);
        $this->assertEquals($productName, $product->name);

        $response = $this->getJson('/api/products');
        $response->assertStatus(200);

        $searchResponse = $this->getJson('/api/products?search='.urlencode($uniqueId));
        $searchResponse->assertStatus(200);

        $searchResponse->assertJsonStructure([
            'data',
            'links',
            'meta',
        ]);

        $this->assertTrue(
            $searchResponse->json('meta.total') > 0,
            'Поиск не нашел созданный продукт'
        );
    }

    public function test_can_sort_products_by_price()
    {
        $response = $this->getJson('/api/products?sort=price&direction=asc');

        $response->assertStatus(200);

        $products = $response->json('data');
        $this->assertNotEmpty($products);

        $prices = array_column($products, 'price');
        $sortedPrices = $prices;
        sort($sortedPrices);

        $this->assertEquals($sortedPrices, $prices);
    }

    public function test_can_filter_products_by_option()
    {
        $category = OptionCategory::firstOrCreate(['name' => 'Страна']);
        $optionValue = OptionValue::firstOrCreate([
            'option_category_id' => $category->id,
            'value' => 'Италия',
        ]);

        $product = Product::first();
        if (! $product) {
            $product = Product::create([
                'name' => 'Тестовый продукт',
                'description' => 'Описание тестового продукта',
                'price' => 1500,
            ]);
        }

        ProductOption::firstOrCreate([
            'product_id' => $product->id,
            'option_value_id' => $optionValue->id,
        ]);

        $response = $this->getJson('/api/products?страна=Италия');

        $response->assertStatus(200);

        $products = $response->json('data');
        $this->assertNotEmpty($products);

        $productId = $products[0]['id'];

        $hasOption = ProductOption::where('product_id', $productId)
            ->whereHas('optionValue', function ($query) use ($optionValue) {
                $query->where('id', $optionValue->id);
            })
            ->exists();

        $this->assertTrue($hasOption);
    }

    public function test_can_filter_products_by_multiple_options()
    {
        $countryCategory = OptionCategory::firstOrCreate(['name' => 'Страна']);
        $italyValue = OptionValue::firstOrCreate([
            'option_category_id' => $countryCategory->id,
            'value' => 'Италия',
        ]);
        $chinaValue = OptionValue::firstOrCreate([
            'option_category_id' => $countryCategory->id,
            'value' => 'Китай',
        ]);

        $materialCategory = OptionCategory::firstOrCreate(['name' => 'Материал']);
        $metalValue = OptionValue::firstOrCreate([
            'option_category_id' => $materialCategory->id,
            'value' => 'Металл',
        ]);

        $product = Product::first();
        if (! $product) {
            $product = Product::create([
                'name' => 'Тестовый продукт',
                'description' => 'Описание тестового продукта',
                'price' => 1500,
            ]);
        }

        ProductOption::firstOrCreate([
            'product_id' => $product->id,
            'option_value_id' => $italyValue->id,
        ]);

        ProductOption::firstOrCreate([
            'product_id' => $product->id,
            'option_value_id' => $metalValue->id,
        ]);

        $response = $this->getJson('/api/products?страна=Италия,Китай&материал=Металл');

        $response->assertStatus(200);

        $products = $response->json('data');
        $this->assertNotEmpty($products);

        $productId = $products[0]['id'];

        $hasCountryOption = ProductOption::where('product_id', $productId)
            ->whereHas('optionValue', function ($query) {
                $query->whereHas('category', function ($q) {
                    $q->where('name', 'Страна');
                })
                    ->whereIn('value', ['Италия', 'Китай']);
            })
            ->exists();

        $hasMaterialOption = ProductOption::where('product_id', $productId)
            ->whereHas('optionValue', function ($query) {
                $query->whereHas('category', function ($q) {
                    $q->where('name', 'Материал');
                })
                    ->where('value', 'Металл');
            })
            ->exists();

        $this->assertTrue($hasCountryOption);
        $this->assertTrue($hasMaterialOption);
    }

    public function test_can_paginate_products()
    {
        $perPage = 5;
        $page = 2;

        $response = $this->getJson("/api/products?per_page={$perPage}&page={$page}");

        $response->assertStatus(200);
        $response->assertJsonCount($perPage, 'data');
        $response->assertJsonPath('meta.current_page', $page);
        $response->assertJsonPath('meta.per_page', $perPage);
    }

    public function test_can_combine_all_filters()
    {
        $response = $this->getJson('/api/products?price_min=1000&price_max=2000&страна=Италия&цвет_арматуры=Золотой&sort=price&direction=desc&page=1&per_page=10');

        $response->assertStatus(200);

        $products = $response->json('data');

        if (! empty($products)) {
            foreach ($products as $product) {
                $this->assertGreaterThanOrEqual(1000, $product['price']);
                $this->assertLessThanOrEqual(2000, $product['price']);
            }

            $prices = array_column($products, 'price');
            $sortedPrices = $prices;
            rsort($sortedPrices);

            $this->assertEquals($sortedPrices, $prices);
        }
    }
}
