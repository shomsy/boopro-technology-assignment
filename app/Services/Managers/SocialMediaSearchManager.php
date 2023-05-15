<?php

namespace App\Services\Managers;

use App\Services\SocialMediaSearchService;
use App\Services\WordPopularity;

/**
 * @property SocialMediaSearchService $socialMediaSearchService
 */
class SocialMediaSearchManager
{
    private WordPopularity $wordPopularityService;
    private SocialMediaSearchService $socialMediaSearchService;

    /**
     * @param  WordPopularity  $wordPopularityService
     * @param  SocialMediaSearchService  $socialMediaSearchService
     */
    public function __construct(
        WordPopularity $wordPopularityService,
        SocialMediaSearchService $socialMediaSearchService
    ) {
        $this->wordPopularityService = $wordPopularityService;
        $this->socialMediaSearchService = $socialMediaSearchService;
    }

    /**
     * @param  string  $term
     * @return array
     */
    public function search(string $term): array
    {
        $searchResult = $this->searchByTerm($term);
        $searchResult['term'] = $term;
        $score = $this->getTheResultScore($searchResult);

        return compact('term', 'score');
    }

    /**
     * @param  string  $term
     * @return array
     */
    private function searchByTerm(string $term): array
    {
        return $this->socialMediaSearchService->search($term);
    }

    /**
     * @param  array  $result
     * @return int
     */
    private function getTheResultScore(array $result): int
    {
        return $this->wordPopularityService->getTheScore($result);
    }
}
