<?php
namespace App\Services;

use App\Contracts\CsvReader;
use App\Contracts\Reader;
use App\Contracts\XmlReader;
use Exception;
use Illuminate\Support\Facades\File;
use League\Csv\Reader as CReader;

class FileReaderService implements Reader, XmlReader, CsvReader
{
    /**
     * @param string $datapath
     * 
     * @return array
     */
    public function read(string $datapath) : array
    {
        $results = [];
        if (!$this->doesFileExist($datapath))
            throw new Exception("Data file not found");

        $file_extension = $this->getFileExtension($datapath);
        switch ($file_extension) {
            case "xml":
                $results = $this->isValidXml($datapath) ? $this->readXml($datapath) : throw new Exception("Xml file is not valid");;
                break;
                
            // case "csv":
                // $results = $this->readCsv($datapath);
                // break;

            // Add more file extension logic here... eg. JSON, EXCEL...
            default:
                throw new Exception("Extension not supported");
        }
        return $results;

    }

    /**
     * @param string $datapath 
     * 
     * Process XML file
     * 
     * @return array
     */
    public function readXml(string $datapath) : array
    {
        libxml_use_internal_errors(true);
        $items = simplexml_load_file($datapath, 'SimpleXMLElement', LIBXML_NOCDATA);
        $data = json_encode($items);
        $result = json_decode($data, true);
        return $result ? $result['item'] : [];
    }

    /**
     * @param string $datapath
     * 
     * Process CSV file
     * 
     * @return array
     */
    public function readCsv(string $datapath) : array
    {
        $results = [];
        $csv = CReader::createFromPath($datapath);
        $csv->setHeaderOffset(0);
        foreach ($csv->getRecords() as $record) {
            $results[] = $record;
        }
        return $results;
    }

    /**
     * @param string $file_path
     * 
     * Check if the file exist in storage or not
     * 
     * @return bool
     */
     public function doesFileExist(string $file_path) : bool
     {
         return File::exists($file_path);
     }
 
     /**
      * @param string $file_path
      * 
      * Get File extension
      * 
      * @return string 
      */
     public function getFileExtension(string $file_path) : string
     {
         return pathinfo($file_path, PATHINFO_EXTENSION);
     }

     /**
      * @param string $datapath
      *
      * Check if xml file is valid or not
      *
      * @return bool 
      */
     public function isValidXml(string $datapath) : bool
     {
        libxml_use_internal_errors(true);
        $items = simplexml_load_file($datapath, 'SimpleXMLElement', LIBXML_NOCDATA);
        return $items ? true : false;
     }
}