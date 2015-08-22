<?php

namespace Olyckne\Pug;

use Exception;
use GuzzleHttp\ClientInterface;

class Pug
{

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * baseUrl to the pugme api
     *
     * @var string
     */
    private $baseUrl = "http://pugme.herokuapp.com/";

    /**
     *
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * send a request to pugme api
     *
     * @param sring $url
     * @return mixed
     * @throws PugNotFoundException
     */
    private function sendRequest($url)
    {
        try {
            $response = $this->client->get($this->baseUrl . $url);
            $pug = json_decode($response->getBody(), true);
        } catch (Exception $e) {
            throw new PugNotFoundException;
        }
        return $pug;
    }

    /**
     * Gets a link to a pug
     *
     * @return string
     */
    public function random()
    {
        return $this->get();
    }

    /**
     *
     * Gets a link to a pug
     *
     * @return string
     * @throws PugNotFoundException
     */
    public function get()
    {
        $pug = $this->sendRequest('random');
        return isset($pug['pug']) ? $pug['pug'] : '';
    }


    /**
     * Get multiple links to pugs
     *
     * @param int $count
     * @return string
     * @throws PugNotFoundException
     */
    public function bomb($count=5)
    {
        $pug = $this->sendRequest('bomb?count='.$count);
        return isset($pug['pugs']) ? $pug['pugs'] : '';
    }
}
