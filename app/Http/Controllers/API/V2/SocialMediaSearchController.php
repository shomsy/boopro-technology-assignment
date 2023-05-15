<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Controllers\API\BaseSocialMediaSearchController;
use App\Http\Requests\IssueSearchScoreRequest;
use App\Http\Resources\V2\IssueSearchScore;

class SocialMediaSearchController extends BaseSocialMediaSearchController
{
    /**
     * @param  IssueSearchScoreRequest  $request
     * @return IssueSearchScore
     */
    public function search(IssueSearchScoreRequest $request): IssueSearchScore
    {
        $results = parent::searchForScoreByTerm($request);

        return new IssueSearchScore(compact('results'));
    }
}
