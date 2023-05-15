<?php

namespace App\Contracts;

interface SearchServiceInterface
{
    /**
     * @param string $term
     * @return array
     */
    public function search(string $term): array;

    /**
     * @param string $apiUrl
     * @return void
     */
    public function setAPIUrl(string $apiUrl): void;

    /**
     * @return string
     */
    public function getAPIUrl(): string;

    /**
     * @param string $providerName
     * @return void
     */
    public function setProviderName(string $providerName): void;

    /**
     * @return string
     */
    public function getProviderName(): string;
}
