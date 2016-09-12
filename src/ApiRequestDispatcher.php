<?php

namespace Gattaca;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Route;

class ApiRequestDispatcher extends RequestDispatcher
{
    /**
     * @param bool $isSendResponse
     * @return JsonResponse
     */
    public function run(bool $isSendResponse = true)
    {
        $result = parent::run(false);

        $statusCode = null;
        $content = null;
        $headers = [];
        if ($result instanceof Response) {
            $content = $result->getContent();
            $statusCode = $result->getStatusCode();
            $headers = $result->headers->all();
        } else {
            $content = $result;
            $statusCode = 200;
        }

        $jsonResult = new JsonResponse($content, $statusCode, $headers);
        if ($isSendResponse === false) {
            return $jsonResult;
        }

        return $jsonResult->send();
    }
}
