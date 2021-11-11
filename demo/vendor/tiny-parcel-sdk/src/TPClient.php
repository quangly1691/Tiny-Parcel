<?php

namespace TinyParcel\PhpSdk;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

class TPClient
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var string
     */
    private $secret;

    /**
     * @var array
     */
    private $headers;

    /**
     * Constructor of TPClient
     *
     * @param array $args
     */
    public function __construct(array $args)
    {
        $this->baseUrl = $args['base_url'];
        $this->secret = $args['secret'];

        $this->headers = [
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer {$this->secret}"
        ];

        if (isset($args['headers'])) {
            $this->headers = array_merge($this->headers, $args['headers']);
        }

        $this->client = new Client();
    }

    /**
     * Create a parcel
     *
     * @param array $args
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createParcel(array $args): string
    {
        try {
            $body = json_encode(
                [
                    'name' => $args['name'],
                    'weight' => $args['weight'],
                    'volume' => $args['volume'],
                    'value' => $args['value']
                ]
            );
            $response = $this->client->post(
                $this->baseUrl . '/parcels',
                [
                    'headers' => $this->headers,
                    'body' => $body
                ]
            );
        } catch (BadResponseException $exception) {
            return $exception->getResponse()->getBody()->getContents();
        }

        return $response->getBody()->getContents();
    }

    /**
     * Update a parcel
     *
     * @param int $id
     * @param array $args
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateParcel(int $id, array $args): string
    {
        try {
            $body = json_encode(
                [
                    'name' => $args['name'],
                    'weight' => $args['weight'],
                    'volume' => $args['volume'],
                    'value' => $args['value']
                ]
            );
            $response = $this->client->put(
                $this->baseUrl . '/parcels/' . $id,
                [
                    'headers' => $this->headers,
                    'body' => $body
                ]
            );
        } catch (BadResponseException $exception) {
            return $exception->getResponse()->getBody()->getContents();
        }

        return $response->getBody()->getContents();
    }

    /**
     * Get parcel
     *
     * @param int $id
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getParcel(int $id): string
    {
        try {
            $response = $this->client->get(
                $this->baseUrl . '/parcels/' . $id,
                [
                    'headers' => $this->headers,
                ]
            );
        } catch (BadResponseException $exception) {
            return $exception->getResponse()->getBody()->getContents();
        }

        return $response->getBody()->getContents();
    }

    /**
     * Delete parcel
     *
     * @param int $id
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteParcel(int $id): string
    {
        try {
            $response = $this->client->delete(
                $this->baseUrl . '/parcels/' . $id,
                [
                    'headers' => $this->headers,
                ]
            );
        } catch (BadResponseException $exception) {
            return $exception->getResponse()->getBody()->getContents();
        }

        return $response->getBody()->getContents();
    }

    /**
     * Get delivery price
     *
     * @param array $ids
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getDeliveryPrice(array $ids): string
    {
        $ids = implode(',', $ids);
        try {
            $response = $this->client->get(
                $this->baseUrl . '/prices',
                [
                    'headers' => $this->headers,
                    'query' => [
                        'parcelIds' => $ids
                    ]
                ]
            );
        } catch (BadResponseException $exception) {
            return $exception->getResponse()->getBody()->getContents();
        }

        return $response->getBody()->getContents();
    }


}