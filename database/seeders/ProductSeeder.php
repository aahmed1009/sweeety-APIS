<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Import the DB facade
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Directory where images are stored
        $imageDirectory = storage_path('app/public/products/sweets');

        // Get all image files
        $imageFiles = glob($imageDirectory . '/*.{jpg,jpeg,png}', GLOB_BRACE);

        // Prepare product data
        foreach ($imageFiles as $imageFile) {
            $imageName = basename($imageFile);
            $imagePath = 'products/sweets/' . $imageName;

            // Check if the product already exists in the database by image path
            $productExists = DB::table('products')->where('image', $imagePath)->exists();

            if (!$productExists) {
                $product = [
                    'name' => pathinfo($imageName, PATHINFO_FILENAME),
                    'description' => 'Description for ' . pathinfo($imageName, PATHINFO_FILENAME),
                    'price' => mt_rand(100, 500) / 100,  // Random price for illustration
                    'QuantityAvailable' => mt_rand(50, 200),  // Random quantity
                    'CategoryID' => rand(1, 2),  // Random category ID between 1 and 2
                    'AdminID' => 1,  // Ensure this ID exists
                    'IsCustomizable' => false,
                    'HasNutritionalInfo' => true,
                    'image' => $imagePath,  // Image path
                    'vendor' => 'Vendor for ' . pathinfo($imageName, PATHINFO_FILENAME),
                    'is_deleted' => false,
                ];

                // Insert the product into the database
                DB::table('products')->insert($product);
            }
        }
    }
}