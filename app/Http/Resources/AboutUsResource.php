<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AboutUsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'seoTitle' => $this->seoTitle, // Include SEO fields
            'seoDescription' => $this->seoDescription,
            'seoHostUrl' => $this->seoHostUrl
        ];
    }
}
