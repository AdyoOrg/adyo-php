<?php

namespace Adyo\Exception;

use Exception;

abstract class BaseException extends Exception
{   

    /**
     * Base exception constructor
     *
     * @param string $message The exception message
     * @param int $httpStatusCode The HTTP status code
     * @param string $httpBody The HTTP body
     * @param array $httpHeaders The HTTP headers
     * @return void
     */
    public function __construct($message,
                                $httpStatusCode = null,
                                $httpBody = null,
                                $httpHeaders = null) {
        
        parent::__construct($message);
        
        $this->httpStatusCode = $httpStatusCode;
        $this->httpBody = $httpBody;
        $this->httpHeaders = $httpHeaders;
    }

    /**
      * Get the HTTP status code of the exception
      *
      * @return int
      */
    public function getHttpStatusCode()
    {
        return $this->httpStatusCode;
    }
    
    /**
      * Get the HTTP body of the exception
      *
      * @return string
      */
    public function getHttpBody()
    {
        return $this->httpBody;
    }
    
    /**
      * Get the HTTP headers of the exception
      *
      * @return array
      */
    public function getHttpHeaders()
    {
        return $this->httpHeaders;
    }
}