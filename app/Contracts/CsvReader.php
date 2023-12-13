<?php
namespace App\Contracts;

interface CsvReader
{
    public function readCsv(string $datapath) : array;
}