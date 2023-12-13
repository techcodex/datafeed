<?php

namespace Tests\Unit;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_category_has_products(): void
    {
        $category = Category::factory()->create();

        $this->assertInstanceOf(Collection::class, $category->products);
    }
}
