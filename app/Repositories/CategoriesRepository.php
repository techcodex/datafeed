<?php
namespace App\Repositories;

use App\Models\Category;

class CategoriesRepository
{
    /**
     * @param array $data
     * 
     * Create new resource in storage
     * 
     * @return Category
     */
    public function store(array $data) : Category
    {
        return Category::create($data);
    }
    
    /**
     * @param string $name
     * 
     * Find resource by name
     * 
     * @return Category | null
     */
    public function findByName(string $name) : ?Category
    {
        return Category::where('name', $name)->get()->first();
    }

    /**
     * @param string $name
     * 
     * Find or create new resource in storage
     * 
     * @return Category
     */
    public function findOrCreate(string $name) : Category
    {
        $category = $this->findByName($name);
        if (!$category) {
            $category = $this->store(['name' => $name]);
        }
        return $category;
    }
}