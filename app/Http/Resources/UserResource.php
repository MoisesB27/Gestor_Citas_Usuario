<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'       => $this->id,
            'username' => $this->username,
            'email'    => $this->email,
            'status'   => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            // Puedes agregar más campos o relaciones según necesites
        ];
    }
}
