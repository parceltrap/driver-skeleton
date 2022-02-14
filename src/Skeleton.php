<?php

declare(strict_types=1);

namespace ParcelTrap\Skeleton;

use DateTimeImmutable;
use GrahamCampbell\GuzzleFactory\GuzzleFactory;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use ParcelTrap\Contracts\Driver;
use ParcelTrap\DTOs\TrackingDetails;
use ParcelTrap\Enums\Status;

class Skeleton implements Driver
{
    public const BASE_URI = 'https://api.example.com';
    private ClientInterface $client;

    private function __construct(private string $apiKey, ?ClientInterface $client = null)
    {
        $this->client = $client ?? GuzzleFactory::make(['base_uri' => self::BASE_URI]);
    }

    /** @param array{api_key: string} $config */
    public static function make(array $config, ?ClientInterface $client = null): self
    {
        return new self(
            apiKey: $config['api_key'],
            client: $client,
        );
    }

    public function find(string $identifier, array $parameters = []): TrackingDetails
    {
        $request = $this->client->request('GET', '/tracking', [
            RequestOptions::HEADERS => $this->getHeaders(),
            RequestOptions::QUERY => array_merge(['id' => $identifier], $parameters),
        ]);

        /** @var array $json */
        $json = json_decode($request->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        // ...

        return new TrackingDetails(
            identifier: $identifier,
            status: $this->mapStatus($json['status'] ?? 'unknown'),
            summary: 'Package status is: '.$this->mapStatus($json['status'] ?? 'unknown')->description(),
            estimatedDelivery: new DateTimeImmutable($json['status'] ?? 'now'),
            events: [],
            raw: [],
        );
    }

    private function mapStatus(string $status): Status
    {
        return match ($status) {
            default => Status::Unknown,
        };
    }

    /**
     * @param  array<string, mixed>  $headers
     * @return array<string, mixed>
     */
    private function getHeaders(array $headers = []): array
    {
        return array_merge([
            'Authorization' => "Bearer {$this->apiKey}",
            'Accept' => 'application/json',
        ], $headers);
    }
}
