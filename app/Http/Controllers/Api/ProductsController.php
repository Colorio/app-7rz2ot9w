<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    public function index(){
        return Product::get();
    }

    public function show($sku){
        $sku = trim(strval($sku));
        return Product::get()->where('sku',$sku)->first();
    }

    public function store(Request $request){
        $data   = $request->all();
        $amount = intval($data['amount']);

        $validator = Validator::make($data, Product::rules());

        if ($validator->fails()){
            $errors = $validator->errors()->messages();           
            return response()->json([
                "status" => "error",
                "errors" => array_map("json_encode", $errors)
            ]);
        }

        $product_id = Product::create($data)->id;
        Inventory::create(["sku" => $data['sku'], "amount" => $amount])->id;
        
        return response()->json([
            "status"  => "created",
            "product" => Product::get()->find($product_id)
        ]);
    }
    
    public function update(Request $request, $sku){
        $data = $request->all();
        unset($data['sku']);

        if(empty($data)){
            return response()->json([
                "status" => "error",
                "errors" => ["sku" => json_encode(["No product data"])]
            ]);
        }

        $data = Product::filterFillableOnly($data);
        $sku  = trim(strval($sku));

        $product = Product::where("sku", $sku)->first();
        if(!isset($product->id)){
            return response()->json([
                "status" => "error",
                "errors" => ["sku" => json_encode(["Sku not found"])]
            ]);
        }

        $data["updated_at"] = now();
        $update_status = Product::where('sku', $sku)->update($data);
        
        if($update_status == 1){
            return response()->json([
                "status"  => "updated",
                "product" => Product::get()->where("sku", $sku)->first()
            ]);
        }
        
        return response()->json([
            "status" => "error",
            "errors" => ["No updated data"]
        ]);
    }

    public function destroy($sku){
        $product = Product::get()->where("sku", $sku)->first();
        if(!isset($product->id)){
            return response()->json([
                "status" => "error",
                "errors" => ["sku" => json_encode(["Sku not found"])]
            ]);
        }

        $destroyed = $product->delete();

        if($destroyed){
            return response()->json([
                "status"  => "deleted",
                "product" => $product
            ]);
        }
    }
}