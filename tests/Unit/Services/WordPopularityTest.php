<?php

namespace Tests\Unit\Services;

use App\Services\PopularityScoreService;
use App\Services\WordPopularity;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;

class WordPopularityTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @var PopularityScoreService|LegacyMockInterface|MockInterface|null
     */
    private LegacyMockInterface|MockInterface|PopularityScoreService|null $popularityScoreService;

    /**
     * @var WordPopularity|null
     */
    private WordPopularity|null $wordPopularity;

    protected function setUp(): void
    {
        $this->popularityScoreService = \Mockery::mock(PopularityScoreService::class);

        $this->wordPopularity = new WordPopularity($this->popularityScoreService);
    }

    public function testGetTheScoreWithNoExistingScore()
    {
        $searchResult = [
            'positiveResults' => (object)['total_count' => 20],
            'negativeResults' => (object)['total_count' => 10],
            'provider' => 'google',
            'term' => 'test'
        ];

        $this->popularityScoreService->allows('getScore')
            ->with('test', 'google')
            ->andReturnNull();

        $this->popularityScoreService->allows('saveScore')
            ->with('test', 'google', 6, 20, 10);

        $result = $this->wordPopularity->getTheScore($searchResult);

        $this->assertEquals(6, $result);
    }

    public function testGetTheScoreWithExistingScore()
    {
        $searchResult = [
            'positiveResults' => (object)['total_count' => 20],
            'negativeResults' => (object)['total_count' => 10],
            'provider' => 'google',
            'term' => 'test'
        ];

        $this->popularityScoreService->allows('getScore')
            ->with('test', 'google')
            ->andReturns(8);

        $result = $this->wordPopularity->getTheScore($searchResult);

        $this->assertEquals(8, $result);
    }

    /**
     * @throws ReflectionException
     */
    public function testCalculateScoreWithNoResults()
    {
        $score = $this->invokePrivateMethod('calculateScore',0, 0);

        $this->assertEquals(0, $score);
    }

    /**
     * @throws ReflectionException
     */
    public function testCalculateScoreWithResults()
    {
        $score = $this->invokePrivateMethod('calculateScore', 30, 10);

        $this->assertEquals(3, $score);
    }

    /**
     * @param string $methodName
     * @param mixed ...$args
     * @return mixed
     * @throws ReflectionException
     */
    private function invokePrivateMethod(string $methodName, ...$args)
    {
        $reflectionClass = new ReflectionClass($this->wordPopularity);
        $reflectionMethod = $reflectionClass->getMethod($methodName);

        return $reflectionMethod->invokeArgs($this->wordPopularity, $args);
    }
}
