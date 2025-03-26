<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            //"instructor_id" => $this->instructor_id,
            "id"=> $this->id,
            "title"=> $this->title,
            "description"=> $this->description,
            "image_path" => $this->image_path,
            "price" => number_format($this->price, 2,
             ",", "."),
            "discount" => $this->discount,
            "is_active" => $this->is_active,
            "created_at" => $this->created_at->format("d/m/Y"),
            "updated_at" => $this->updated_at->format("d/m/Y"),
        ];
    }
}
