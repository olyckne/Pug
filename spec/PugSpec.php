<?php

namespace spec\Olyckne\Pug;

use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Subscriber\History;
use GuzzleHttp\Subscriber\Mock;
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
     * GuzzleHttp\Subscriber\Mock
     */
    protected $mock;
    /**
     * GuzzleHttp\Subscriber\History
     */
    protected $history;

    function let()
    {
        $this->client = new Client;
        $this->mock = new Mock;
        $this->history = new History;

        $this->client->getEmitter()->attach($this->mock);
        $this->client->getEmitter()->attach($this->history);
        $this->beConstructedWith($this->client);
    }

    private function setupResponse(array $data = [], $code = 200, array $headers = [])
    {
        $body = Stream::factory(json_encode($data));
        $this->mock->addResponse(new Response($code, $headers, $body));
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
