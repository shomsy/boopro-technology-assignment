<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Request;

class IssueSearchScore extends \App\Http\Resources\V1\IssueSearchScore
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $resourceData = $this->checkForResultsAndReturn();

        if (empty($resourceData)) {
            return [];
        }

        return [
            'type' => 'issues',
            'attributes' => $resourceData
        ];
    }
}
