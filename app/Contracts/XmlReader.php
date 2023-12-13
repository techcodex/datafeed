<?php
namespace App\Contracts;

interface XmlReader
{
    public function readXml(string $datapath) : array;
}