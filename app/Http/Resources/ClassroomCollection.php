<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassroomCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $studentData = StudentCollection::collection($this->students)->map(function ($item, $key) {
            return collect($item)->except('classroom');
        });

        return [
            'id' => $this->id,
            'name' => $this->name,
            'students' => $studentData
        ];
    }
}
