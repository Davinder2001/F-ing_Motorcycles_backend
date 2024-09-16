<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvestorPageResource extends JsonResource
{
    protected $baseUrl;
    protected $imgUrl;

    /**
     * Create a new instance of the resource.
     */
    public function __construct($resource)
    {
        parent::__construct($resource); // Be sure to call the parent constructor
        $this->baseUrl = config('app.api_url');
        $this->imgUrl = config('app.img_url'); // Assuming img_url is set in the .env
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'image' => $this->image ? $this->imgUrl . '/' . $this->image : null, // prepend the image URL if image exists
            'field1' => $this->field1,
            'field2' => $this->field2,
            'field3' => $this->field3,
            'field4' => $this->field4,
            'field5' => $this->field5,
            'field6' => $this->field6,
            'field7' => $this->field7,
            'field8' => $this->field8,
            'field9' => $this->field9,
            'field10' => $this->field10,
        ];
    }
}
