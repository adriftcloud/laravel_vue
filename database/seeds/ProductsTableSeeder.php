<?php

use Illuminate\Database\Seeder;
use App\Model\Products;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Products::truncate();

        foreach (range(10, 60) as $i) {
            Products::create([
                'item_code' => 'PDT-1000' . $i,
                'description' => 'Name of Product ' . $i,
                'unit_price' => mt_rand(100, 1000)
            ]);
        }

    }
}
