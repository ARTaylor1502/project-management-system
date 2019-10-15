<?php

namespace App\Http\Controllers\API;

use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function search() {
        $queryString = Input::get('queryString');
        $products =  DB::table('products')->where('name', 'LIKE', "{$queryString}%")->get();

        return response()->json($products);
    }

    public function categories() {
        $categories =  DB::table('product_categories')->get();

        return response()->json($categories);
    }

    public function cost_types() {
        $cost_types =  DB::table('cost_types')->get();

        return response()->json($cost_types);
    }

    public function store(Request $request) {
        $validator = Validator::make(
            $request->all(), [
            'category_id'               => 'required|exists:product_categories,id',
            'name'                      => 'required|max:255',
            'quantity_total'            => 'required|integer',
            'quantity_available'        => 'required|integer',
            'cost'                      => 'required|regex:/^\d*(\.\d{1,2})?$/',
            'cost_type_id'              => 'required|exists:cost_types,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'error',
                'errors'    =>  $validator->errors()
            ], 201);
        }

        Product::create($request->all());

        return response()->json([
            'status' => 'success',
            'message'    => 'Product successfully created',
        ], 201);
    }
}
