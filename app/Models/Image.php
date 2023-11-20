<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='product_images';
    protected $date=['created_at','deleted_at','updated_at'];
    protected $fillable=[
        'supplier_id',
        'product_id',
        'name'
    ];
    public function supplier(){
        return $this->belongsTo(Supplier::class,'supplier_id','id');
    }
    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
