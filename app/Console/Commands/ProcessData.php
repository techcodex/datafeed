<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Services\ApiReaderService;
use App\Services\DataParserService;
use App\Services\FileReaderService;
use App\Services\ProductService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ProcessData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This comamnd process data of different data source and store the data in database';

    public function __construct(private DataParserService $dataParserService,
    private ProductService $productService
    )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->line("** Select Data Source... **");
        $this->line("1. Data File (xml, csv, json, etc..)");
        $this->line("2. API ");
        $this->line("3. Database ");

        $datasource = $this->ask("Enter your Choice");
        $datapath = $this->ask("Enter source path");
        if (empty($datasource)) {$this->error("Missing Data Source"); return 0;}
        if (empty($datapath)) { $this->error("Missing File Path"); return 0; }

        $results = [];
        try {
            switch ($datasource) {
                case 1:
                    $results = $this->dataParserService->handle(new FileReaderService(), $datapath);
                    break;
                // case 2:
                //     $results = $this->dataParserService->handle(new ApiReaderService(), $datapath);
                //     break;
                // case 3:
                    // Add more configurations here for different data source.... eg. Database
                    // break;
                default:
                    $this->error("Invalid Data source");
                    Log::error("Invalid Data source ".$datasource);
            }
            
            // Store result in storage
            $this->info("Processing data");
            $newly_created_records = $this->productService->processProductData($results);
            $this->info("Number of records stored: ".$newly_created_records);
            $this->info("Data processed successfully!");
            Log::info("Data job completed successfully");

        } catch (Exception $ex) {
            Log::error($ex->getMessage().' '.$ex->getLine().' '.$ex->getFile());
            $this->error($ex->getMessage());
        }
        
    }
}
