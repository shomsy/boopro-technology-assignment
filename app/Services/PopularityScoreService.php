<?php

namespace App\Services;

use App\Contracts\PopularityScoreServiceInterface;
use App\Models\PopularityScore;

class PopularityScoreService implements PopularityScoreServiceInterface
{
    /**
     * @param  string  $term
     * @param  string  $sourceType
     * @return int|null
     */
    public function getScore(string $term, string $sourceType): int|null
    {
        return PopularityScore::query()
            ->where('term', '=', $term)
            ->where('source_type', '=', $sourceType)
            ->first()
            ?->score;
    }

    /**
     * @param  string  $term
     * @param  string  $sourceType
     * @param  int  $score
     * @param  int  $positiveCount
     * @param  int  $negativeCount
     * @return void
     */
    public function updateScore(
        string $term,
        string $sourceType,
        int $score,
        int $positiveCount,
        int $negativeCount
    ): void {
        PopularityScore::query()
            ->where('term', '=', $term)
            ->where('source_type', '=', $sourceType)
            ->update(compact('score'));
    }

    /**
     * @param  string  $term
     * @param  string  $sourceType
     * @param  int  $score
     * @param  int  $positiveCount
     * @param  int  $negativeCount
     * @return void
     */
    public function saveScore(
        string $term,
        string $sourceType,
        int $score,
        int $positiveCount,
        int $negativeCount
    ): void {
        PopularityScore::query()->create([
            'term' => $term,
            'source_type' => $sourceType,
            'score' => $score,
            'positive_count' => $positiveCount,
            'negative_count' => $negativeCount
        ]);
    }
}
