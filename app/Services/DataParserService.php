<?php
namespace App\Services;

use App\Contracts\Reader;
use Exception;

class DataParserService
{
    /**
     * @param Reader $reader
     * @param string $datasource
     * 
     * @return array
     */
    public function handle(Reader $reader, string $datasource) :array
    {
        try {
            return $reader->read($datasource);
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }
}