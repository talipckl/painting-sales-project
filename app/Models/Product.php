<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='products';
    protected $date=['created_at','deleted_at','updated_at'];
    protected $fillable=[
        'supplier_id',
        'category_id',
        'title',
        'description',
        'quantity',
        'frame_size',
        'price',
        'discount',
        'user_id'
    ];
    public function supplier(){
        return $this->belongsTo(Supplier::class,'supplier_id','id');
    }
    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function image(){
        return $this->hasMany(Image::class,'product_id');
    }
}
