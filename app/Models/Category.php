<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='categories';
    protected $date=['created_at','updated_at','deleted_at'];
    protected $fillable=[
        'parent_id',
        'name',
        'description'
    ];
}
