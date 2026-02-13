<?php

namespace App\Http\Resources;

use App\Models\UserType;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'balance' => $this->balance,
            'name' => $this->name,
            'email' => $this->email,
            'company_name' => $this->company_name,
            'customer_type' => UserType::find($this->customer_type_id)->name,
            'phone' => $this->phone,
            'user_type' => $this->user_type,
            'avatar' => $this->avatar ? api_asset($this->avatar) : '',
        ];
    }
}