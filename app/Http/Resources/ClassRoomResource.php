<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassRoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        $response = [
            'id' => $this->id,
            'name' => $this->name,
            'subject' => $this->subject,
            'class_level' => $this->class_level,
            'unique_code' => $this->unique_code,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
        return $response;
    }
}
