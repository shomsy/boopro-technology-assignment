<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IssueSearchScore extends JsonResource
{
    public static $wrap = false;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->checkForResultsAndReturn();
    }

    /**
     * @return array|null
     */
    protected function checkForResultsAndReturn(): array|null
    {
        if (empty($this->resource['results'])) {
            return [];
        }

        $resource = $this->resource['results'];

         return [
            'term' => $resource['term'],
            'score' => $resource['score'],
        ];
    }
}
