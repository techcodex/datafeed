<?php
namespace App\Repositories;

use App\Models\Product;

class ProductsRepository
{
    /**
     * @param array $data
     * 
     * Create new resource in storage
     * 
     * @return Product
     */
    public function store(array $data) : Product
    {
        return Product::updateOrCreate([
                'entity_id' => $data['entity_id']
            ],$data);
    }
}