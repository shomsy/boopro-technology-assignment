<?php

namespace App\Services;

use App\Contracts\SearchServiceInterface;

class TwitterAPI implements SearchServiceInterface
{

    /**
     * @inheritDoc
     */
    public function search(string $term): array
    {
        // TODO: Implement search() method.
        return [];
    }

    public function setAPIUrl(string $apiUrl): void
    {
        // TODO: Implement setAPIUrl() method.
    }

    public function getAPIUrl(): string
    {
        // TODO: Implement getAPIUrl() method.
        return  '';
    }

    public function setProviderName(string $providerName): void
    {
        // TODO: Implement setProviderName() method.
    }

    public function getProviderName(): string
    {
        // TODO: Implement getProviderName() method.
        return '';
    }
}
