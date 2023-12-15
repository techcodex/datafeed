<?php
namespace App\Services;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\BrandsRepository;
use App\Repositories\CategoriesRepository;
use App\Repositories\ProductsRepository;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class ProductService
{
    /**
     * @param CategoriesRepository $categoriesRepository
     * @param BrandsRepository $brandsRepository
     * @param ProductsRepository $productsRepository
     */
    public function __construct(
        private CategoriesRepository $categoriesRepository,
        private BrandsRepository $brandsRepository,
        private ProductsRepository $productsRepository
    )
    {   }
    /**
     * @param array $results
     * 
     * @return int
     */
    public function processProductData(array $results) : int
    {
        $new_records_count = 0;
        foreach ($results as $result) {
            extract($result);
            $data = [];
            $data['entity_id'] = $entity_id ? $entity_id : '';
            $data['sku'] = $sku ? $sku : '';
            $data['name'] = $name ? $name : '';
            $data['description'] = $description ? $description : '';
            $data['shortdesc'] = $shortdesc ? $shortdesc : '';
            $data['price'] = $price ? $price : 0;
            $data['link'] = $link ? $link : '';
            $data['image'] = $image ? $image : '';
            $data['rating'] = $Rating ? $Rating : null;
            $data['caffeine_type'] = $CaffeineType ? $CaffeineType : '';
            $data['count'] = $Count ? $Count : 0;
            $data['flavored'] = $Flavored ? ($Flavored == 'Yes' ? Product::IS_FLAVOURED_YES : Product::IS_FLAVOURED_NO) : null;
            $data['seasonal'] = $Seasonal ? ($Seasonal == 'No' ? Product::IS_SEASONAL_NO : Product::IS_SEASONAL_YES) : null;
            $data['instock'] = $Instock ? ($Instock == 'Yes' ? Product::IS_INSTOCK_YES : Product::IS_INSTOCK_NO) : null;
            $data['facebook'] = $Facebook ? (int) $Facebook : null;
            $data['is_k_cup'] = $IsKCup ? ($IsKCup == Product::NO ? Product::IS_K_CUP_NO : Product::IS_K_CUP_YES) : null;

            // Create or find category in storage
            if ($CategoryName) {
                $category = $this->categoriesRepository->findOrCreate($CategoryName);
                $data['category_id'] = $category->id;
            } else {
                Log::info("Product entity id $entity_id doesn't have Category");
            }

            // Create or find new brand in storage
            if ($Brand) {
                $brand = $this->brandsRepository->findOrCreate($Brand);
                $data['brand_id'] = $brand->id;
            } else {
                Log::info("Product entity id $entity_id doesn't have Brand");
            }

            // update of store product record in storage
            try {
                $product = $this->productsRepository->store($data);
                if ($product->wasRecentlyCreated) {
                    $new_records_count += 1;
                }
            } catch (Exception $ex) {
                throw new Exception($ex->getMessage());
            }
        }
        Log::info("Products ".count($results)." processed successfully");
        Log::info("Number of products stored: ".$new_records_count);
        return $new_records_count;
    }
}