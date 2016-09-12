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
            "handler"   =>  function(Request $request) {
                return "HelloWorld!";
            }
        ]))->run(false);

        $this->assertSame($result->getContent(), "HelloWorld!");
    }

    public function testDispatchHandlerAsClassInterface()
    {
        $klass = new class implements ControllerInterface
        {
            public function dispatchRequest(Request $request)
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

    public function testDispatcherHandlerNotImplemented()
    {
        $request = Request::create("/");

        try {
            RequestDispatcher::new($request)->addRoute("index", new Route("/"))->run(false);

            $this->fail();
        } catch (\RuntimeException $e) {
            $this->assertSame($e->getCode(), RequestDispatcher::HANDLER_NOT_IMPLEMENTED_ERROR_CODE);
        }
    }

    public function testDispatcherHandlerInvalided()
    {
         $request = Request::create("/");

        try {
            RequestDispatcher::new($request)->addRoute("index", new Route("/", [
                "handler"   =>  0,
            ]))->run(false);

            $this->fail();
        } catch (\RuntimeException $e) {
            $this->assertSame($e->getCode(), RequestDispatcher::HANDLER_INVALID_ERROR_CODE);
        }
    }
}
