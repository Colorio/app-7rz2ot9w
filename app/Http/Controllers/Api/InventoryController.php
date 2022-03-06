<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    public static function maintenance(Request $request){
        $data = $request->all();

        if(empty($data)){
            return response()->json([
                "status" => "error",
                "errors" => ["sku" => json_encode(["No inventory data"])]
            ]);
        }

        $validator = Validator::make($data, Inventory::rules());

        if ($validator->fails()){
            $errors = $validator->errors()->messages();           
            return response()->json([
                "status" => "error",
                "errors" => array_map("json_encode", $errors)
            ]);
        }

        $data["amount"] = abs($data["amount"]);
        $data["amount"] *= $data["type"] == "add" ? 1 : -1;

        $inventory = Inventory::where("sku", $data["sku"])->first();
        $inventory->amount = self::limitValues(($inventory->amount + $data['amount']), 0, 99999);
        $inventory->save();

        return response()->json([
            "status" => "updated",
            "product" => $inventory
        ]);
    }
    
    public static function setAmount(Request $request){
        $data = $request->all();

        if(empty($data)){
            return response()->json([
                "status" => "error",
                "errors" => ["sku" => json_encode(["No inventory data"])]
            ]);
        }
        
        $data['type'] = "add"; //just to pass validation 
        $validator = Validator::make($data, Inventory::rules());

        if ($validator->fails()){
            $errors = $validator->errors()->messages();           
            return response()->json([
                "status" => "error",
                "errors" => array_map("json_encode", $errors)
            ]);
        }  

        $inventory = Inventory::where("sku", $data["sku"])->first();
        $data["amount"] = abs($data["amount"]);

        $request["amount"] = abs($data["amount"] - $inventory->amount);
        $request["type"]   = $data["amount"] > $inventory->amount ? "add" : "remove";

        if($request["amount"] == 0){
            return response()->json([
                "status" => "error",
                "errors" => ["amount" => json_encode(["This amount is already {$inventory->amount}"])]
            ]);
        }
        
        return self::maintenance($request);
    }

    static function limitValues($value, $min, $max){
        $new_value = $value;
        $new_value = $value < $min ? $min : $new_value;
        $new_value = $value > $max ? $max : $new_value;

        return $new_value;
    }
}
