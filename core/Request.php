<?php

namespace App\Core;

use Symfony\Component\HttpFoundation\Request AS Requests;
use Symfony\Component\HttpFoundation\Response;

class Request
{
    public $request;

    function __construct()
    {
        $this->request = Requests::createFromGlobals();
    }

    /**
     * Fetch the request URI.
     *
     * @return string
     */
    public function uri()
    {
        return $this->request->getPathInfo();
    }

    /**
     * Fetch the request method.
     *
     * @return string
     */
    public function method()
    {
       return $this->request->getMethod();
    }

    /**
     * Fetch the request method.
     *
     * @return string
     */
    public function AllRequestDataWithHeader()
    {
        return $this->request;
    }


}
