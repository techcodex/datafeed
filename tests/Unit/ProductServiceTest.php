<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Services\ApiReaderService;
use App\Services\FileReaderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Mockery;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    use RefreshDatabase;
    
    private $fileReaderService;
    private $productService;
    private $apiReaderService;
    
    public function setUp(): void
    {
        parent::setUp();
        $this->fileReaderService = Mockery::mock(FileReaderService::class);
        $this->apiReaderService = Mockery::mock(ApiReaderService::class);
        $this->productService = App::make('App\Services\ProductService');
    }
    /**
     *
     */
    public function test_file_data_is_stored_in_database(): void
    {
        $mock_file_content = $this->getMockContent();
        $this->fileReaderService->shouldReceive('read')
                                ->with('mocked_file.xml')
                                ->andReturn($mock_file_content);
        $result = $this->fileReaderService->read('mocked_file.xml');
        
        $this->productService->processProductData($result);

        $products = Product::all(); 
        $this->assertEquals($products->count(),1);
    }

    public function test_api_data_is_stored_in_database()
    {
        $mock_file_content = $this->getMockContent();

        $this->apiReaderService->shouldReceive('readApi')
                                ->with('https:://www.example.com/products')
                                ->andReturn($mock_file_content);
        $result = $this->apiReaderService->readApi('https:://www.example.com/products');

        $this->productService->processProductData($result);

        $products = Product::all(); 
        $this->assertEquals($products->count(),1);
        
    }

    public function getMockContent()
    {
        return [
            [
                'entity_id' => 123,
                'sku' => '123sku',
                'name' => 'product',
                'description' => 'description',
                'shortdesc' => 'short description',
                'price' => 12.12,
                'link' => 'www.test.com',
                'image' => 'www.test.com/image.png',
                'Rating' => 1,
                'CaffeineType' => 'Caffinated',
                'Count' => 1,
                'Flavored' => 'Yes',
                'Seasonal' => 'No',
                'Instock' => 'Yes',
                'Facebook' => 1,
                'IsKCup' => 0,
                'CategoryName' => 'Category',
                'Brand' => 'Brand'
            ],
        ];
    }

    public function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }
}
