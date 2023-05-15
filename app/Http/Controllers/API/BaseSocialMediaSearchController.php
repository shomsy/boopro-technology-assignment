<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\IssueSearchScoreRequest;
use App\Services\Managers\SocialMediaSearchManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceResponse;

abstract class BaseSocialMediaSearchController
{
    private SocialMediaSearchManager $searchManager;

    public function __construct(SocialMediaSearchManager $searchManager)
    {
        $this->searchManager = $searchManager;
    }

    /**
     * @param  IssueSearchScoreRequest  $request
     * @return array
     */
    public function searchForScoreByTerm(IssueSearchScoreRequest $request): array
    {
        $term = $request->validated('term');
        return $this->searchManager->search($term);
    }
}
