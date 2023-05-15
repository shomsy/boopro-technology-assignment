<?php

namespace Tests\Unit\Services;

use App\Models\PopularityScore;
use App\Services\PopularityScoreService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PopularityScoreServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function getScore_returns_score_when_term_and_sourceType_match()
    {
        $term = 'laravel';
        $sourceType = 'github';

        PopularityScore::factory()->create([
            'term' => $term,
            'source_type' => $sourceType,
            'score' => 50,
        ]);

        $popularityScoreService = new PopularityScoreService();
        $score = $popularityScoreService->getScore($term, $sourceType);

        $this->assertEquals(50, $score);
    }

    /** @test */
    public function getScore_returns_null_when_term_or_sourceType_do_not_match()
    {
        $term = 'laravel';
        $sourceType = 'github';

        PopularityScore::factory()->create([
            'term' => $term,
            'source_type' => $sourceType,
            'score' => 50,
        ]);

        $popularityScoreService = new PopularityScoreService();

        // when term does not match
        $score = $popularityScoreService->getScore('symfony', $sourceType);
        $this->assertNull($score);

        // when sourceType does not match
        $score = $popularityScoreService->getScore($term, 'bing');
        $this->assertNull($score);
    }

    /** @test */
    public function saveScore_saves_new_popularity_score()
    {
        $popularityScoreService = new PopularityScoreService();

        $popularityScoreService->saveScore('laravel', 'github', 50, 10, 5);

        $this->assertDatabaseHas('popularity_scores', [
            'term' => 'laravel',
            'source_type' => 'github',
            'score' => 50,
            'positive_count' => 10,
            'negative_count' => 5,
        ]);
    }

    /** @test */
    public function updateScore_updates_existing_popularity_score()
    {
        $term = 'Miki Car';
        $sourceType = 'github';

        $popularityScore = PopularityScore::factory()->create([
            'term' => $term,
            'source_type' => $sourceType,
            'score' => 50,
            'positive_count' => 10,
            'negative_count' => 5,
        ]);

        $popularityScoreService = new PopularityScoreService();

        $popularityScoreService->updateScore(
            $popularityScore['term'],
            $popularityScore['source_type'],
            75,
            $popularityScore['positive_count'],
            $popularityScore['negative_count']);

        $this->assertDatabaseHas('popularity_scores', [
            'id' => $popularityScore->id,
            'term' => $popularityScore['term'],
            'source_type' => $popularityScore['source_type'],
            'score' => 75,
            'positive_count' => $popularityScore['positive_count'],
            'negative_count' => $popularityScore['negative_count']
        ]);
    }
}
