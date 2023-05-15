<?php

namespace Tests\Unit\API\V2;

use App\Http\Controllers\API\V2\SocialMediaSearchController;
use App\Http\Resources\V2\IssueSearchScore;
use App\Services\Managers\SocialMediaSearchManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\MockObject\Exception;
use Tests\TestCase;

class SocialMediaSearchControllerTestOld extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @throws Exception
     */
    public function testSearchWithResults()
    {
        // Create a mock of the parent class (V1 controller)
        $parentController = \Mockery::mock(\App\Http\Controllers\API\V1\SocialMediaSearchController::class);

        // Set up the response from the parent controller
        $response = new Response(['results' => ['result1', 'result2']]);
        $parentController->allows('search')->andReturns($response);
        $searchManager = $this->createMock(SocialMediaSearchManager::class);

        // Create an instance of the V2 controller and inject the parent controller mock
        $controller = new SocialMediaSearchController($searchManager);

        // Create a mock request
        $request = \Mockery::mock(Request::class);
        $request->allows('get')->with('term')->andReturns('php');

        // Call the search method
        $result = $controller->search($request);

        // Assert that the result is an instance of IssueSearchScore
        $this->assertInstanceOf(IssueSearchScore::class, $result);
    }

    /**
     * @throws Exception
     */
    public function testSearchWithNoResults()
    {
        // Create a mock of the parent class (V1 controller)
        $parentController = \Mockery::mock(\App\Http\Controllers\API\V1\SocialMediaSearchController::class);

        // Set up the response from the parent controller
        $response = new Response([]);
        $parentController->allows('search')->andReturns($response);
        $searchManager = $this->createMock(SocialMediaSearchManager::class);

        // Create an instance of the V2 controller and inject the parent controller mock
        $controller = new SocialMediaSearchController($searchManager);

        // Create a mock request
        $request = \Mockery::mock(Request::class);
        $request->allows('get')->with('term')->andReturns('php');

        // Call the search method
        $result = $controller->search($request);

        // Assert that the result is an instance of IssueSearchScore
        $this->assertInstanceOf(IssueSearchScore::class, $result);

        // Assert that the result is null
        $this->assertEmpty($result->resource);
    }
}

