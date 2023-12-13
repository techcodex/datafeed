<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Services\DataParserService;
use App\Services\FileReaderService;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Mockery;
use Tests\TestCase;

class ProcessDataCommandTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function test_datasource_is_empty(): void
    {
        $this->artisan("process:data")
            ->expectsQuestion("Enter your Choice", '')
            ->expectsQuestion("Enter source path", '')
            ->expectsOutput('Missing Data Source')
            ->assertExitCode(0);
    }

    public function test_datapath_is_empty(): void
    {
        $this->artisan("process:data")
            ->expectsQuestion("Enter your Choice", '1')
            ->expectsQuestion("Enter source path", '')
            ->expectsOutput('Missing File Path')
            ->assertExitCode(0);
    }

    public function test_datasource_is_invalid(): void
    {
        $this->artisan("process:data")
            ->expectsQuestion("Enter your Choice", 10)
            ->expectsQuestion("Enter source path", 'test.xml')
            ->expectsOutput('Invalid Data source')
            ->assertExitCode(0);
    }

    public function test_data_file_not_found(): void
    {
        $filepath = 'C:\laragon\www\datafeed\storage\app\public\xml\product.xml';
        $this->artisan("process:data")
            ->expectsQuestion("Enter your Choice", 1)
            ->expectsQuestion("Enter source path", $filepath)
            ->expectsOutput('Data file not found')
            ->assertExitCode(0);
    }

    public function test_data_source_extension_not_supported(): void
    {
        $filepath = 'C:\laragon\www\datafeed\storage\app\public\xml\feed.json';
        $this->artisan("process:data")
            ->expectsQuestion("Enter your Choice", 1)
            ->expectsQuestion("Enter source path", $filepath)
            ->expectsOutput('Extension not supported')
            ->assertExitCode(0);
    }

    public function test_invalid_xml_file()
    {
        $filepath = 'C:\laragon\www\datafeed\storage\app\public\xml\invalid.xml';
        $this->artisan("process:data")
            ->expectsQuestion("Enter your Choice", 1)
            ->expectsQuestion("Enter source path", $filepath)
            ->expectsOutput('Xml file is not valid')
            ->assertExitCode(0);
    }

    public function test_data_file_processed_successfuly()
    {
        $filepath = 'data.xml';
        $mock_file_content = [
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
                'CategoryName' => 'Drinking',
                'Brand' => 'Pepsi'
            ],
        ];
        $this->mock(DataParserService::class, function($mock) use ($mock_file_content) {
            $mock->shouldReceive('handle')->andReturn($mock_file_content);
        });

        $this->artisan("process:data")
            ->expectsQuestion("Enter your Choice", 1)
            ->expectsQuestion("Enter source path", $filepath)
            ->expectsOutput('Data processed successfully!')
            ->assertExitCode(0);
    }
}
