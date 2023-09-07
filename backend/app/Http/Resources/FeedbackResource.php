<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => $this->type,
            'text' => $this->text,
            'device' => $this->device,
            'page' => $this->page,
            'fingerprint' => $this->fingerprint,
            'created_at' => $this->created_at,
        ];
    }
}
