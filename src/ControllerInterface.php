<?php

namespace Gattaca;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface ControllerInterface
{
    /**
     * @param  Request $reuest
     * @return Response|mixed
     */
    public function dispatchRequest(Request $reuest);
}
