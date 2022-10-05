<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use ParcelTrap\Contracts\Factory;
use ParcelTrap\DTOs\TrackingDetails;
use ParcelTrap\Enums\Status;
use ParcelTrap\ParcelTrap;
use ParcelTrap\Skeleton\Skeleton;

it('can add the Skeleton driver to ParcelTrap', function () {
    /** @var ParcelTrap $client */
    $client = $this->app->make(Factory::class);

    $client->extend('skeleton_other', fn () => new Skeleton(
        apiKey: 'abcdefg'
    ));

    expect($client)->driver(Skeleton::IDENTIFIER)->toBeInstanceOf(Skeleton::class)
        ->and($client)->driver('skeleton_other')->toBeInstanceOf(Skeleton::class);
});

it('can retrieve the Skeleton driver from ParcelTrap', function () {
    expect($this->app->make(Factory::class)->driver(Skeleton::IDENTIFIER))->toBeInstanceOf(Skeleton::class);
});

it('can call `find` on the Skeleton driver', function () {
    $trackingDetails = [
        'tracking_number' => 'ABCDEFG12345',
        'status' => 'transit',
        'estimated_delivery' => '2022-01-01T00:00:00+00:00',
    ];

    $httpMockHandler = new MockHandler([
        new Response(200, ['Content-Type' => 'application/json'], json_encode($trackingDetails)),
    ]);

    $handlerStack = HandlerStack::create($httpMockHandler);

    $httpClient = new Client([
        'handler' => $handlerStack,
    ]);

    $this->app->make(Factory::class)->extend(Skeleton::IDENTIFIER, fn () => new Skeleton(
        apiKey: 'abcdefg',
        client: $httpClient,
    ));

    expect($this->app->make(Factory::class)->driver('skeleton')->find('ABCDEFG12345'))
        ->toBeInstanceOf(TrackingDetails::class)
        ->identifier->toBe('ABCDEFG12345')
        ->status->toBe(Status::In_Transit)
        ->status->description()->toBe('In Transit')
        ->summary->toBe('Package status is: In Transit')
        ->estimatedDelivery->toEqual(new DateTimeImmutable('2022-01-01T00:00:00+00:00'))
        ->raw->toBe($trackingDetails);
});
