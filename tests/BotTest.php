<?php

namespace seregazhuk\tests;

use Mockery;
use ReflectionClass;
use PHPUnit_Framework_TestCase;
use seregazhuk\PinterestBot\Api\CurlAdapter;
use seregazhuk\PinterestBot\Api\ProvidersContainer;
use seregazhuk\PinterestBot\Api\Request;
use seregazhuk\PinterestBot\Bot;
use seregazhuk\PinterestBot\Api\Response;
use seregazhuk\PinterestBot\Factories\PinterestBot;
use seregazhuk\tests\helpers\ReflectionHelper;

class BotTest extends PHPUnit_Framework_TestCase
{
    use ReflectionHelper;

    /**
     * @var Bot
     */
    protected $bot;

    protected function setUp()
    {
        $this->bot = PinterestBot::create();
        $this->reflection = new ReflectionClass($this->bot);
        $this->setReflectedObject($this->bot);
    }

    protected function tearDown()
    {
        Mockery::close();
        $this->bot = null;
        $this->reflection = null;
    }

    /** @test */
    public function getLastResponseError()
    {
        $error = 'expected_error';
        $mock = Mockery::mock(Response::class)->shouldReceive('getLastError')->andReturn($error)->getMock();

        $request = new Request(new CurlAdapter());
        $providersContainer = new ProvidersContainer($request, $mock);

        $bot = new Bot($providersContainer);

        $this->assertEquals($error, $bot->getLastError());
    }

}
