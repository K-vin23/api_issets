<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProcessorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'processorId'   => $this->processorId,
            'processor'     => $this->getProcessor() 
        ];
    }
}
