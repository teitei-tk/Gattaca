<?php

namespace Gattaca\UnitTest;

use Gattaca\ControllerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Route;
use PHPUnit\Framework\TestCase;
use Gattaca\RequestDispatcher;

class RequestDispatcherTest extends TestCase
{
    public function testDispatchHandlerAsFunc()
    {
        $request = Request::create("/");

        /** @var Response $result */
        $result = RequestDispatcher::new($request)->addRoute("index", new Route("/", [
            "handler"   =>  function() {
                return "HelloWorld!";
            }
        ]))->run(false);

        $this->assertSame($result->getContent(), "HelloWorld!");
    }

    public function testDispatchHandlerAsClassInterface()
    {
        $klass = new class implements ControllerInterface
        {
            public function dispatchRequest()
            {
                return "HelloWorld!";
            }
        };

        $request = Request::create("/");

         /** @var Response $result */
        $result = RequestDispatcher::new($request)->addRoute("index", new Route("/", [
            "handler"   =>  $klass,
        ]))->run(false);

        $this->assertSame($result->getContent(), "HelloWorld!");
    }
}
