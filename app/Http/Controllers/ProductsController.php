<?php

namespace App\Http\Controllers;

use App\Model\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function search()
    {
        $results = Products::orderBy('item_code')
            ->when(request('q'), function ($query) {
                $query->where('item_code', 'like', '%' . request('q') . '%')
                    ->orWhere('description', 'like', '%' . request('q') . '%');
            })
            ->limit(6)
            ->get();

        return response()->json(['results' => $results]);

    }
}
