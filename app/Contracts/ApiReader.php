<?php
namespace App\Contracts;

interface ApiReader
{
    public function readApi(string $datapath) : array;
}