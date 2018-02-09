<?php

namespace Adyo;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Exception\ClientException as GuzzleClientException;
use GuzzleHttp\Exception\ServerException as GuzzleServerException;

class Client {

    /**
     * Guzzle Http client.
     *
     * @var GuzzleHttp\HttpClient
     */
    public static $httpClient;

    /**
     * The API Key to use for all requests.
     *
     * @var string
     */
    private $apiKey;

    /**
     * The version of the Adyo API to use for requests.
     *
     * @var string
     */ 
    private $apiVersion;
 
    /**
     * The base url for Adyo API to use for requests.
     *
     * @var string
     */ 
    private $apiBase;

    /**
     * Creates a new client.
     *
     * @param string $apiKey The API Key to use for all requests.
     * @param string $apiVersion The version of the Adyo API to use for requests. (v1,v2 etc).
     * @param string $apiBase The base url for Adyo API to use for requests.
     */
    public function __construct($apiKey, $apiVersion, $apiBase)
    {
        
        $this->apiKey = $apiKey;
        
        if (!$apiVersion) {
            $apiVersion = Adyo::$apiVersion;
        }

        $this->apiVersion = $apiVersion;
        
        if (!$apiBase) {
            $apiBase = Adyo::$apiBase;
        }

        $this->apiBase = $apiBase;
    }

    /**
     * Executes a request using our HTTP client with the provided arguments.
     *
     * @param string $method The HTTP Method to use.
     * @param string $urlPath The path to append to the API base
     * @param array $queryParams Query string params to append to URL
     * @param string $body The body to send with the request
     * @param bool $multipart Whether to use multipart/form-data for the request (E.g uploading files)
     * @return GuzzleHttp\Psr7\Response
     * @throws Adyo\Exception\ApiException
     * @throws Adyo\Exception\UnauthorizedException
     */
    public function request($method, $urlPath = '', $queryParams = null, $body = null, $multipart = false)
    {   
        // Check if API Key is set
         if (!$this->apiKey) {
            $message = 'No API key provided. (HINT: set your API key using "Adyo::setApiKey({API_KEY})".';
        
            throw new Exception\UnauthorizedException($message);
        }

        // Build our full url for the request
        $fullUrl = $this->buildUrl($urlPath, $queryParams);
        
        // Setup required headers
        $headers['X-Adyo-ApiKey'] = $this->apiKey;
        $headers['Accept'] = 'application/json';

        $encodedBody = null;

        // Execute
        try {

            // Setup request
            $request = null;

            // Check if multipart or not
            if ($multipart) {

                if (!empty($body)) {
                    
                    // Create stream
                    $multipart = new MultipartStream($body);
                }

                $request = new Request($method, $fullUrl, $headers, $multipart);

            } else {

                if (!empty($body)) {
                    $headers['Content-Type'] = 'application/json';
                    $encodedBody = json_encode($body);
                }

                $request = new Request($method, $fullUrl, $headers, $encodedBody);   
            }
            
            $response = $this->httpClient()->send($request);

            return $this->handleResponse($response);

        } catch (GuzzleClientException $e) {
            $response = $e->getResponse();

            $this->handleErrorResponse($response);
        } catch (GuzzleServerException $e) {

            // Server related exception
            $message = $e->getMessage();
            $response = $e->getResponse();
            $message = $e->getMessage();
            $statusCode = 500;
            
            if ($response) {
                $statusCode = $response->getStatusCode();
            }

            throw new Exception\ApiException($e->getMessage(), $statusCode, $message);
        }
    }

    /**
     * Handles a response by JSON decoding the body.
     *
     * @param GuzzleHttp\Psr7\Response The response object
     * @return array
     * @throws Adyo\Exception\ApiException
     */
    private function handleResponse($response)
    {
        // Get response data
        $statusCode = $response->getStatusCode();
        $body = $response->getBody();
        $headers = $response->getHeaders();

        // Check for JSON error
        $decodedBody = json_decode($body, true);
        $jsonError = json_last_error();

        if ($decodedBody === null && $jsonError !== JSON_ERROR_NONE) {
        
            $message = "Invalid response body from API: $jsonError "
              . "(HTTP response code: $statusCode)";
        
            throw new Exception\ApiException($message, $statusCode, $body);
        }
          
        return $decodedBody;
    }

    /**
     * Handles an error response by JSON decoding the body and throwing specific exception.
     *
     * @param GuzzleHttp\Psr7\Response The response object
     * @return void
     * @throws Adyo\Exception\ApiException
     * @throws Adyo\Exception\BadRequestException
     * @throws Adyo\Exception\UnauthorizedException
     * @throws Adyo\Exception\NotFoundException
     * @throws Adyo\Exception\MethodNotAllowedException
     * @throws Adyo\Exception\RateLimitException
     */
    private function handleErrorResponse($response)
    {
        // Get response data
        $statusCode = $response->getStatusCode();
        $body = $response->getBody();
        $headers = $response->getHeaders();

        // Check for JSON error
        $decodedBody = json_decode($body, true);
        $jsonError = json_last_error();

        if ($decodedBody === null && $jsonError !== JSON_ERROR_NONE) {
        
            $message = "Invalid response body from API: $jsonError "
              . "(HTTP response code: $statusCode)";
        
            throw new Exception\ApiException($message, $statusCode, $body);
        }

        // Get error message (Can either be single string or array of strings)
        $message = null;

        if (isset($decodedBody['error'])) {

            $message = $decodedBody['error'];

        } else if (isset($decodedBody['errors']) && is_array($decodedBody['errors'])) {

            $message = implode('.', $decodedBody['errors']);
        }

        // Handle case by case on status code
        switch ($statusCode) {
            case 400:
                throw new Exception\BadRequestException($message, $statusCode, $body, $response, $headers);
            case 401:
                throw new Exception\UnauthorizedException($message, $statusCode, $body, $response, $headers);
            case 404:
                throw new Exception\NotFoundException($message, $statusCode, $body, $response, $headers);
            case 405:
                throw new Exception\MethodNotAllowedException($message, $statusCode, $body, $response, $headers);
            case 429:
                throw new Exception\RateLimitException($message, $statusCode, $body, $response, $headers);
            default:
                throw new Exception\ApiException($message, $statusCode, $body, $response, $headers);
        }
    }

    /**
     * Builds a full URL for a request by appending the provided path + params to the current URL base + version.
     *
     * @param string $urlPath The url path to append
     * @param array $queryParams The query params to append
     * @return string
     */
    private function buildUrl($urlPath, $queryParams = null) {

        $queryString = !is_null($queryParams) ? '?' . http_build_query($queryParams) : '';

        return $this->apiBase . '/' . $this->apiVersion . '/' . $urlPath . $queryString;
    }

    /**
     * Static method to set a new Guzzle HTTP client if required (normally used to mock responses in testing).
     *
     * @param GuzzleHttp\Client $client The Guzzle client to set
     * @return void
     */
    public static function setHttpClient($client)
    {
        self::$httpClient = $client;
    }

    /**
     * Static method to retrieve the current Guzzle HTTP client being used (normally used to mock responses in testing).
     *
     * @return GuzzleHttp\Client
     */
    private function httpClient()
    {
        if (!self::$httpClient) {
            self::$httpClient = new HttpClient;
        }

        return self::$httpClient;
    }
}