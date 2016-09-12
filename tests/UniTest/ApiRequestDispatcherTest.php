<?php

namespace Gattaca\UnitTest;

use Gattaca\ApiRequestDispatcher;

use Gattaca\ControllerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Route;

class ApiRequestDispatcherTest extends TestCase
{
    public function testApiDispatcherHandlerAsFunc()
    {
        $request = Request::create("/");

        /** @var JsonResponse $result */
        $result = ApiRequestDispatcher::new($request)->addRoute("index", new Route("/", [
            "handler"   =>  function(Request $request) {
                return "HelloWorld!";
            }
        ]))->run(false);

        $checkResponseVariable = json_encode("HelloWorld!");
        $this->assertSame($result->getContent(), $checkResponseVariable);
    }

    public function testApiDispatcherHandlerAsClass()
    {
        $klass = new class implements ControllerInterface
        {
            public function dispatchRequest(Request $request)
            {
                return "HelloWorld!";
            }
        };


        $request = Request::create("/");

        /** @var JsonResponse $result */
        $result = ApiRequestDispatcher::new($request)->addRoute("index", new Route("/", [
            "handler"   =>  $klass,
        ]))->run(false);

        $checkResponseVariable = json_encode("HelloWorld!");
        $this->assertSame($result->getContent(), $checkResponseVariable);
    }
}
