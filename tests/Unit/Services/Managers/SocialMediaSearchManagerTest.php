<?php

namespace Tests\Unit\Services\Managers;

use App\Services\Managers\SocialMediaSearchManager;
use App\Services\SocialMediaSearchService;
use App\Services\WordPopularity;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;

class SocialMediaSearchManagerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /** @var WordPopularity|MockInterface|null */
    private WordPopularity|LegacyMockInterface|MockInterface $wordPopularityService;

    /** @var SocialMediaSearchService|MockInterface|null */
    private LegacyMockInterface|MockInterface|SocialMediaSearchService $socialMediaSearchService;

    /** @var SocialMediaSearchManager|null */
    private SocialMediaSearchManager|null $socialMediaSearchManager;

    protected function setUp(): void
    {
        $this->wordPopularityService = \Mockery::mock(WordPopularity::class);
        $this->socialMediaSearchService = \Mockery::mock(SocialMediaSearchService::class);

        $this->socialMediaSearchManager = new SocialMediaSearchManager(
            $this->wordPopularityService,
            $this->socialMediaSearchService
        );
    }

    public function testSearch()
    {
        $term = 'good';
        $searchResult = [
            "positiveResults" => [
                "total_count" => 14805,
                "incomplete_results" => false,
                "items" => []
            ],
            "negativeResults" => [
                "total_count" => 41625,
                "incomplete_results" => false,
                "items" => []
            ],
            "provider" => "github"
        ];

        $expectedResult = [
            'term' => $term,
            'score' => 2,
        ];

        $this->socialMediaSearchService
            ->allows('search')
            ->with($term)
            ->andReturns($expectedResult);

        $this->wordPopularityService
            ->allows('getTheScore')
            ->with($searchResult)
            ->andReturns($expectedResult['score']);

        $result = $this->socialMediaSearchManager->search($term);

        self::assertEquals($expectedResult, $result);
    }

    /**
     * @throws ReflectionException
     */
    public function testSearchByTerm()
    {
        $term = 'good';
        $searchResult = [
            "positiveResults" => [
                "total_count" => 14805,
                "incomplete_results" => false,
                "items" => []
            ],
            "negativeResults" => [
                "total_count" => 41625,
                "incomplete_results" => false,
                "items" => []
            ],
            "provider" => "github"
        ];

        $this->socialMediaSearchService
            ->expects('search')
            ->with($term)
            ->andReturns($searchResult);

        $result = $this->invokePrivateMethod('searchByTerm', $term);

        self::assertEquals($searchResult, $result);
    }

    /**
     * @throws ReflectionException
     */
    public function testGetTheResultScore()
    {
        $searchResult = [
            "positiveResults" => [
                "total_count" => 14805,
                "incomplete_results" => false,
                "items" => []
            ],
            "negativeResults" => [
                "total_count" => 41625,
                "incomplete_results" => false,
                "items" => []
            ],
            "provider" => "github"
        ];

        $this->wordPopularityService
            ->expects('getTheScore')
            ->with($searchResult)
            ->andReturns(2);

        $result = $this->invokePrivateMethod('getTheResultScore', $searchResult);
        self::assertEquals(2, $result);
    }

    /**
     * @param string $methodName
     * @param mixed ...$args
     * @return mixed
     * @throws ReflectionException
     */
    private function invokePrivateMethod(string $methodName, ...$args)
    {
        $reflectionClass = new ReflectionClass($this->socialMediaSearchManager);
        $reflectionMethod = $reflectionClass->getMethod($methodName);

        return $reflectionMethod->invokeArgs($this->socialMediaSearchManager, $args);
    }
}
