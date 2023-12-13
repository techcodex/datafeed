<?php
namespace App\Contracts;

interface Reader
{
    public function read(string $datapath) : array;
}