<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request $request
   * @return array
   */
  public function toArray($request)
  {
    return [
      'clientId' => $this->client_id,
      'email' => $this->email,
      'firstName' => $this->first_name,
    ];
  }
}
