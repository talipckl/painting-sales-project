<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use function Symfony\Component\Translation\t;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'supplier'=>[
                'id'=>$this->supplier?->id,
                'name'=>$this->supplier?->name,
            ],
            'category'=>[
                'id'=>$this->category?->id,
                'name'=>$this->category?->name,
            ],
            'title'=>$this->title,
            'description'=>$this->description,
            'quantity'=>$this->quantity,
            'price'=>$this->price,
            'discount'=>$this->discount,
            'user_id'=>$this->user_id,
            'images'=>ImageResource::collection($this->image)
        ];
    }
}
