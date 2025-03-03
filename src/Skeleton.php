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
    public const IDENTIFIER = 'skeleton';

    public const BASE_URI = 'https://api.example.com';

    private ClientInterface $client;

    public function __construct(private readonly string $apiKey, ClientInterface|null $client = null)
    {
        $this->client = $client ?? GuzzleFactory::make(['base_uri' => self::BASE_URI]);
    }

    public function find(string $identifier, array $parameters = []): TrackingDetails
    {
        $response = $this->client->request('GET', '/tracking', [
            RequestOptions::HEADERS => $this->getHeaders(),
            RequestOptions::QUERY => array_merge(['id' => $identifier], $parameters),
        ]);

        /** @var array{tracking_number: string, status?: string, estimated_delivery?: string} $json */
        $json = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        // ...

        return new TrackingDetails(
            identifier: $json['tracking_number'],
            status: $this->mapStatus($json['status'] ?? 'unknown'),
            summary: 'Package status is: '.$this->mapStatus($json['status'] ?? 'unknown')->description(),
            estimatedDelivery: new DateTimeImmutable($json['estimated_delivery'] ?? 'now'),
            events: [],
            raw: $json,
        );
    }

    private function mapStatus(string $status): Status
    {
        return match ($status) {
            'transit' => Status::In_Transit,
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
