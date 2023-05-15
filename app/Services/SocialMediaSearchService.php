<?php

namespace App\Services;

use App\Contracts\SearchServiceInterface;

class SocialMediaSearchService
{
    private SearchServiceInterface $api;

    public function __construct(SearchServiceInterface $api)
    {
        $this->api = $api;
    }

    /**
     * @param  string  $term
     * @return array
     */
    public function search(string $term): array
    {
        return $this->api->search($term);
    }
}
