<?php

namespace Tests\Unit;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BrandTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_brand_has_products(): void
    {
        $brand = Brand::factory()->create();

        $this->assertInstanceOf(Collection::class, $brand->products);
    }
}
