<?php

namespace Tests\Unit\API\V1;

use App\Http\Controllers\API\V1\SocialMediaSearchController;
use App\Http\Requests\IssueSearchScoreRequest;
use App\Http\Resources\V1\IssueSearchScore;
use App\Services\Managers\SocialMediaSearchManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Tests\TestCase;

class SocialMediaSearchControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker, MockeryPHPUnitIntegration;

    public function testSearch()
    {
        // Mock the dependencies
        $searchManager = $this->mock(SocialMediaSearchManager::class);
        $request = $this->mock(IssueSearchScoreRequest::class);

        // Set up expectations
        $term = 'search term';
        $request->expects('validated')->andReturns($term);
        $results = ['result1', 'result2'];
        $searchManager->expects('search')->with($term)->andReturns($results);

        // Create an instance of the controller
        $controller = new SocialMediaSearchController($searchManager);

        // Call the search method
        $result = $controller->search($request);

        // Assert the result
        $this->assertInstanceOf(IssueSearchScore::class, $result);
        $this->assertEquals($results, $result->resource['results']);
    }

}
