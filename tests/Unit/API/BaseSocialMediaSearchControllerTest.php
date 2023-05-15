<?php

namespace Tests\Unit\API;

use App\Http\Controllers\API\BaseSocialMediaSearchController;
use App\Http\Requests\IssueSearchScoreRequest;
use App\Services\Managers\SocialMediaSearchManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BaseSocialMediaSearchControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testSearchForScoreByTerm()
    {
        // Mock the dependencies
        $searchManager = $this->mock(SocialMediaSearchManager::class);
        $request = $this->mock(IssueSearchScoreRequest::class);

        // Set up expectations
        $term = $this->faker->word;
        $validatedData = $term;
        $request->expects('validated')->andReturns($validatedData);
        $searchManager->expects('search')->with($term)->andReturns(['result1', 'result2']);

        // Create an instance of the controller
        $controller = new class($searchManager) extends BaseSocialMediaSearchController {
            public function __invoke(IssueSearchScoreRequest $request)
            {
                return $this->searchForScoreByTerm($request);
            }
        };

        // Call the searchForScoreByTerm method
        $result = $controller->__invoke($request);

        // Assert the result
        $this->assertEquals(['result1', 'result2'], $result);
    }
}
