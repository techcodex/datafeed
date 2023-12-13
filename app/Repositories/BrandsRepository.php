<?php
namespace App\Repositories;

use App\Models\Brand;

class BrandsRepository
{
    /**
     * @param array $data
     * 
     * Create new resource in storage 
     * 
     * @return Brand
     */
    public function store(array $data) : Brand
    {
        return Brand::create($data);
    }
    
    /**
     * @param string $name
     * 
     * Find resource by name
     * 
     * @return Brand | null
     */
    public function findByName(string $name) : ?Brand
    {
        return Brand::where('name', $name)->get()->first();
    }

    /**
     * @param string $name
     * 
     * Create or find resource in storage
     * 
     * @return Brand
     */
    public function findOrCreate(string $name) : Brand
    {
        $brand = $this->findByName($name);
        if (!$brand) {
            $brand = $this->store(['name' => $name]);
        }
        return $brand;
    }
}