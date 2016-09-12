<?php

namespace Gattaca;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

/**
 * Request Dispatcher Base Interface.
 * @package Gattaca
 */
interface RequestDispatcherInterface
{
    /**
     * @param Request         $request
     * @param RouteCollection $routeCollection
     */
    public function __construct(Request $request, RouteCollection $routeCollection);

    /**
     * Alias __construct method as MethodChain.
     *
     * @param  Request|null         $request         [description]
     * @param  RouteCollection|null $routeCollection [description]
     * @return RequestDispatcherInterface
     */
    public static function new(Request $request = null, RouteCollection $routeCollection = null);

    /**
     * run for request dispatch logic.
     *
     * @param bool $isSendResponse
     * @return Response
     */
    public function run(bool $isSendResponse = true);

    /**
     * @param string $routeName add your route object name,
     * @param Route $route
     */
    public function addRoute(string $routeName, Route $route);
}
