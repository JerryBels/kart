<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class ProductService
{
    public static int $numberOfExistingProducts = 100;

    /**
     * @throws Exception
     */
    public static function getRandomProduct(array $except = []): object
    {
        $randomProductId = static::randomAvailableId($except);

        $response = Http::get('https://dummyjson.com/products/' . $randomProductId);

        return $response->object();
    }

    /**
     * @throws Exception
     */
    private static function randomAvailableId(array $except = []): int
    {
        if (count($except) >= static::$numberOfExistingProducts) {
            throw new Exception("There are no more products to choose from.");
        }

        // When lots of products have already been added, take the first one that is not in the list
        if(count($except) >= 20) {
            $productId = 0;
            for ($i = 1; $i <= static::$numberOfExistingProducts; $i++) {
                if (!in_array($i, $except)) {
                    $productId = $i;
                    break;
                }
            }
            if ($productId === 0) {
                throw new Exception("There are no more products to choose from. How did you even get here?");
            }
        } else {
            $productId = random_int(1, static::$numberOfExistingProducts);

            if (in_array($productId, $except)) {
                return static::randomAvailableId($except);
            }
        }

        return $productId;
    }
}
