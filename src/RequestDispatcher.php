<?php

namespace Gattaca;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class RequestDispatcher implements RequestDispatcherInterface
{
    /**
     * @var string ControllerInterface Path
     */
    const CONTROLLER_INTERFACE_NAMESPACE_PATH = "Gattaca\\ControllerInterface";

    /**
     * @var int
     */
    const HANDLER_NOT_IMPLEMENTED_ERROR_CODE = 1001;

    /**
     * @var int
     */
    const HANDLER_INVALID_ERROR_CODE = 1002;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var RouteCollection
     */
    protected $routeCollection;

    /**
     * @var Response
     */
    protected $notFoundResponse;

    /**
     * @var Response
     */
    protected $errorResponse;

    /**
     * @param Request         $request
     * @param RouteCollection $routeCollection
     */
    public function __construct(Request $request, RouteCollection $routeCollection)
    {
        $this->request = $request;
        $this->routeCollection = $routeCollection;
    }

    /**
     * @param  Request         $request
     * @param  RouteCollection $routeCollection
     * @return RequestDispatcherInterface
     */
    public static function new(Request $request = null, RouteCollection $routeCollection = null)
    {
        if (empty($request)) {
            $request = Request::createFromGlobals();
        }

        if (empty($routeCollection)) {
            $routeCollection = new RouteCollection();
        }

        return new static($request, $routeCollection);
    }

    /**
     * @param string $routeName
     * @param Route $route
     * @return RequestDispatcherInterface
     */
    public function addRoute(string $routeName, Route $route)
    {
        $this->routeCollection->add($routeName, $route);
        return $this;
    }

    /**
     * @param bool $isSendResponse
     * @throws ResourceNotFoundException
     * @throws \RuntimeException
     * @return Response
     */
    public function run(bool $isSendResponse = true)
    {
        $context = new RequestContext();
        $context->fromRequest($this->request);
        $matcher = new UrlMatcher($this->routeCollection, $context);

        $attr = $matcher->match($this->request->getPathInfo());
        if (! isset($attr['handler'])) {
            throw new \RuntimeException("handler is not implemented.", self::HANDLER_NOT_IMPLEMENTED_ERROR_CODE);
        }

        /** @var ControllerInterface $handler */
        $handler = null;
        if (is_subclass_of($attr['handler'], self::CONTROLLER_INTERFACE_NAMESPACE_PATH)) {
            $handler = $attr['handler'];

        } else if (is_subclass_of($attr['handler'], self::CONTROLLER_INTERFACE_NAMESPACE_PATH)) {
            $handler = new $attr['handler'];

        }

        $result = null;
        if (is_subclass_of($handler, self::CONTROLLER_INTERFACE_NAMESPACE_PATH)) {
            $result = $handler->dispatchRequest();

        } else if (is_callable($attr['handler'])) {
            $result = $attr['handler']();
        }

        if (empty($result)) {
            throw new \RuntimeException("handler is invalid. requirements func or interface implemented class", self::HANDLER_INVALID_ERROR_CODE);
        }

        if (! $result instanceof Response && (method_exists($result, "__toString") || is_string($result))) {
            $result = new Response($result, 200);
        }


        if ($isSendResponse === false || ! $result instanceof Response) {
            return $result;
        }

        return $result->send();
    }

    /**
     * @return RouteCollection
     */
    public function getRouteCollection()
    {
        return $this->routeCollection;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }
}
