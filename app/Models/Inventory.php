<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use SoftDeletes;

    protected $table    = "inventory";
    protected $fillable = ['sku','amount'];

    public static function rules(){
        return [
            'sku'    => ['required','min:5','max:255','exists:products','regex:/^[A-Za-z0-9\-]+$/'],
            'amount' => ['required','min:1','max:99999', 'numeric'],
            'type'   => ['required', 'in:add,remove']
        ];
    }

    public function history(){
        return $this->hasMany(InventoryHistory::class)->orderBy('created_at','DESC');
    }
}
