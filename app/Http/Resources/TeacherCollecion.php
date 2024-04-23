<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherCollecion extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $classroomData = ClassroomCollection::collection($this->classrooms)->map(function ($item, $key) {
            return collect($item)->only(['id', 'name']);
        });

        return [
            'id' => $this->id,
            'name' => $this->name,
            'gender' => $this->gender,
            'phone_number' => $this->phone_number ?? '',
            'subject' => $this->subject,
            'classrooms' => $classroomData
        ];
    }
}
