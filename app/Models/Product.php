<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = ['name','sku','description'];

    public static function get(){
        return Product::select("id","name","sku","description")->with('inventory')->get();
    }

    public static function rules($no_sku = false){
        $rules_array = [
            'name'   => ['required','min:5','max:255'],
            'sku'    => ['required','min:5','max:255','unique:products','regex:/^[A-Za-z0-9\-]+$/'],
            'amount' => ['required','min:0','max:99999', 'numeric'],
        ];

        if($no_sku){
            unset($rules_array["sku"]);
        }

        return $rules_array;
    }

    public static function filterFillableOnly($data){
        $model = new Product();
        $fillables = $model->getFillable();

        foreach($data AS $key => $value){
            if(!in_array(strtolower($key), $fillables)){
                unset($data[$key]);
            }
        }

        return $data;
    }

    public function inventory(){
        return $this->hasOne(Inventory::class, 'sku', 'sku');
    }
}