<?php

namespace App\Services;


class WordPopularity
{
    private PopularityScoreService $popularityScoreService;

    /**
     * @param PopularityScoreService $popularityScoreService
     */
    public function __construct(PopularityScoreService $popularityScoreService)
    {
        $this->popularityScoreService = $popularityScoreService;
    }

    /**
     * @param array $searchResult
     * @return int
     */
    public function getTheScore(array $searchResult): int
    {
        ['positiveResults' => $positiveResults, 'negativeResults' => $negativeResults, 'provider' => $provider, 'term' => $term] = $searchResult;

        $positiveResultsCount = $positiveResults->total_count ?? 0;
        $negativeResultsCount = $negativeResults->total_count ?? 0;
        $totalResultsCount = $positiveResultsCount + $negativeResults->total_count;

        $existingScore = $this->checkForScore($term, $provider);

        if (! $existingScore) {
            $apiScore = $this->calculateScore($totalResultsCount, $positiveResultsCount);
            $this->saveScore($term, $provider, $apiScore, $positiveResultsCount, $negativeResultsCount);

            return $apiScore;
        }

        return $existingScore;
    }

    /**
     * @param string $term
     * @param string $source_type
     * @return int|null
     */
    private function checkForScore(string $term, string $source_type): int|null
    {
        return $this->popularityScoreService->getScore($term, $source_type);
    }

    /**
     * @param string $term
     * @param string $source_type
     * @param int $apiScore
     * @param int $positiveResultsCount
     * @param int $negativeResultsCount
     * @return void
     */
    private function saveScore(string $term, string $source_type, int $apiScore, int $positiveResultsCount, int $negativeResultsCount): void
    {
        $this->popularityScoreService->saveScore($term, $source_type, $apiScore, $positiveResultsCount, $negativeResultsCount);
    }

    /**
     * @param int $totalResults
     * @param int $positiveResults
     * @return int
     */
    private function calculateScore(int $totalResults, int $positiveResults): int
    {
        if ($totalResults == 0) {
            return 0;
        }

        $calculation = $positiveResults / $totalResults * 10;
        $score = round($calculation, 1);

        return max(0, $score);
    }
}

