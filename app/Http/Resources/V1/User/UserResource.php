<?php

namespace App\Http\Resources\V1\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            // 'profile_image' => $this->profile_image,
            // 'profile_image' => asset('storage/' . $this->profile_image), // Assuming images are stored in the storage folder
            'profile_image' => asset('upload/user_images/' . $this->profile_image), // Assuming images are stored in the storage folder
            // 'phone_number' => $this->phone_number,
            // 'address' => $this->address,
            // 'role' => $this->role,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
