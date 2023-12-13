<?php
namespace App\Services;

use App\Contracts\ApiReader;
use App\Contracts\Reader;
use Exception;
use Illuminate\Support\Facades\Http;

class ApiReaderService implements Reader, ApiReader
{
    /**
     * @param string $datapath
     * 
     * @return array
     */
    public function read(string $datapath) : array
    {
        return $this->readApi($datapath);
    }

    /**
     * @param string $datapath
     * 
     * @return array
     */
    public function readApi(string $datapath): array
    {
        $result = [];
        $response = Http::get($datapath);
        if (!$response->ok())
            throw new Exception("Htp Bad Request ".$response->status());
        
        $result = json_decode($response->body(), true);
        return $result;
    }
}