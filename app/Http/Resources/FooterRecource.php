<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FooterRecource extends JsonResource
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
            'column_1_heading_1'    => $this->column_1_heading_1,
            'column_1_field_1'      => $this->column_1_field_1,
            'column_1_field_2'      => $this->column_1_field_2,
            'column_1_field_3'      => $this->column_1_field_3,
            'column_1_field_4'      => $this->column_1_field_4,
            'column_2_heading_1'    => $this->column_2_heading_1,
            'column_2_field_1'      => $this->column_2_field_1,
            'column_2_field_2'      => $this->column_2_field_2,
            'column_2_field_3'      => $this->column_2_field_3,
            'column_3_heading_1'    => $this->column_3_heading_1,
            'column_3_field_1'      => $this->column_3_field_1,
            'column_3_field_2'      => $this->column_3_field_2,
            'column_3_field_3'      => $this->column_3_field_3,
        ];
    }
}
