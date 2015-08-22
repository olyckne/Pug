<?php

namespace spec\Olyckne\Pug;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Olyckne\Pug\PugNotFoundException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PugSpec extends ObjectBehavior
{
    /**
     * GuzzleHttp\Client
     */
    protected $client;

    /**
     * GuzzleHttp\Handler\MockHandler
     */
    protected $mock;


    function let()
    {
        $this->mock = new MockHandler;
        $handler = HandlerStack::create($this->mock);

        $this->client = new Client(['handler' => $handler]);

        $this->beConstructedWith($this->client);
    }

    private function setupResponse(array $data = [], $code = 200, array $headers = [])
    {
        $body = json_encode($data);
        $this->mock->append(new Response($code, $headers, $body));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Olyckne\Pug\Pug');
    }

    function it_should_get_link_to_a_pug()
    {
        $this->setupResponse(['pug' => 'http://example.com/pug.jpg']);
        $this->random()->shouldReturn('http://example.com/pug.jpg');
    }

    function it_should_squawk_when_not_finding_a_pug()
    {
        $this->setupResponse([], 404);
        $this->shouldThrow(new PugNotFoundException)->duringGet();
    }

    function it_should_get_multiple_pugs()
    {
        $this->setupResponse(['pugs' => [
            'http://example.com/pug1.jpg',
            'http://example.com/pug2.jpg',
        ]]);

        $this->bomb()->shouldReturn([
            'http://example.com/pug1.jpg',
            'http://example.com/pug2.jpg'
        ]);
    }

}
