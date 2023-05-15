<?php

namespace App\Contracts;

interface PopularityScoreServiceInterface
{
    /**
     * @param string $term
     * @param string $sourceType
     * @return int|null
     */
    public function getScore(string $term, string $sourceType): int|null;

    /**
     * @param string $term
     * @param string $sourceType
     * @param int $score
     * @param int $positiveCount
     * @param int $negativeCount
     * @return void
     */
    public function updateScore(string $term, string $sourceType, int $score, int $positiveCount, int $negativeCount): void;

    /**
     * @param string $term
     * @param string $sourceType
     * @param int $score
     * @param int $positiveCount
     * @param int $negativeCount
     * @return void
     */
    public function saveScore(string $term, string $sourceType, int $score, int $positiveCount, int $negativeCount): void;
}
