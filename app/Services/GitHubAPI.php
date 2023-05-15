<?php

namespace App\Services;

use App\Contracts\SearchServiceInterface;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;

readonly class GitHubAPI implements SearchServiceInterface
{
    const API_URL = 'https://api.github.com/search/issues?q={query}';
    const PROVIDER_NAME = 'github';
    private string $apiUrl;
    private string $providerName;

    /**
     * Configuration constructor.
     */
    public function __construct()
    {
        $this->setProviderName(self::PROVIDER_NAME);
        $this->setAPIUrl(self::API_URL);
    }

    /**
     * @param  string  $providerName
     * @return void
     */
    public function setProviderName(string $providerName): void
    {
        $this->providerName = $providerName;
    }

    /**
     * @param  string  $apiUrl
     * @return void
     */
    public function setAPIUrl(string $apiUrl): void
    {
        $this->apiUrl = $apiUrl;
    }

    /**
     * @return string
     */
    public function getProviderName(): string
    {
        return $this->providerName;
    }

    /**
     * @return string
     */
    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    /**
     * @param  string  $term
     * @return array
     */
    public function search(string $term): array
    {
        return $this->searchGitHubIssues($term);
    }

    /**
     * @param  string  $term
     * @return array
     */
    private function searchGitHubIssues(string $term): array
    {
        $positiveQuery = str_replace('{query}', "$term rocks", $this->getApiUrl());
        $negativeQuery = str_replace('{query}', "$term sucks", $this->getApiUrl());

        $responses = Http::pool(static fn(Pool $pool) => [
            $pool->as('positive_results')->get($positiveQuery)->then(static fn() => $positiveQuery),
            $pool->as('negative_results')->get($negativeQuery)->then(static fn() => $negativeQuery),
        ]);

        $positiveResults = json_decode($responses['positive_results']);
        $negativeResults = json_decode($responses['negative_results']);
        $provider = $this->getProviderName();

        return compact('positiveResults', 'negativeResults', 'provider');
    }
}
