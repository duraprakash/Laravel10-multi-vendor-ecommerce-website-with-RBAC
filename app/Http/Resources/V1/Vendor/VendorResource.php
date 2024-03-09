<?php

namespace App\Http\Resources\V1\Vendor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VendorResource extends JsonResource
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
            'user_id' => $this->user_id,
            'vendor_name' => $this->vendor_name,
            'contact_person_name' => $this->contact_person_name,
            'description' => $this->description,
            'verification_status' => $this->verification_status,
            // 'phone_number' => $this->phone_number,
            // 'address' => $this->address,
            // 'role' => $this->role,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
