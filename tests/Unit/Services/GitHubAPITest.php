<?php

namespace Tests\Unit\Services;

use App\Services\GitHubAPI;
use Illuminate\Support\Facades\Facade;
use Tests\TestCase;

class GitHubAPITest extends TestCase
{
    private GitHubAPI $gitHubAPI;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        Facade::setFacadeApplication(app());
        $this->gitHubAPI = new GitHubAPI();
    }

    public function testSearchReturnsArray()
    {
        $result = $this->gitHubAPI->search('test');

        $this->assertIsArray($result);
    }

    public function testSearchReturnsPositiveAndNegativeResults()
    {
        $result = $this->gitHubAPI->search('test');

        $this->assertArrayHasKey('positiveResults', $result);
        $this->assertArrayHasKey('negativeResults', $result);
    }

    public function testSearchReturnsProviderName()
    {
        $result = $this->gitHubAPI->search('test');

        $this->assertArrayHasKey('provider', $result);
        $this->assertEquals('github', $result['provider']);
    }
}

