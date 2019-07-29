<?php

namespace Adyo;

class ApiResource
{
    /**
      * Create a new API object
      *
      * @param string|null $urlPath The path to append to the base URL
      * @param array|null $queryParams Query string parameters to append to URL
      * @param array|null $body Body to convert to JSON string for request
      * @param bool $multipart Whether to use multipart/form-data for the creation (E.g uploading files)
      * @param bool $isAnalytics Whether we should use Analytics API endpoint
      * @return array The response array from the request
      */
    protected static function _create($urlPath = null, $queryParams = null, $body = null, $multipart = false, $isAnalytics = false)
    { 
        return self::_staticPost($urlPath, $queryParams, $body, $multipart, $isAnalytics);
    }

    /**
      * Retreive an API object
      *
      * @param string|null $urlPath The path to append to the base URL
      * @param array|null $queryParams Query string parameters to append to URL
      * @param bool $isAnalytics Whether we should use Analytics API endpoint
      * @return array The response array from the request
      */
    protected static function _retrieve($urlPath = null, $queryParams = null, $isAnalytics = false)
    {
        return self::_staticGet($urlPath, $queryParams, $isAnalytics);
    }

    /**
      * Retreive a list API objects
      *
      * @param string|null $urlPath The path to append to the base URL
      * @param array|null $queryParams Query string parameters to append to URL
      * @param bool $isAnalytics Whether we should use Analytics API endpoint
      * @return array The response array from the request
      */
    protected static function _retrieveAll($urlPath = null, $queryParams = null, $isAnalytics = false)
    {
        return self::_staticGet($urlPath, $queryParams, $isAnalytics);
    }

    /**
      * Update (save) an API Object
      *
      * @param string|null $urlPath The path to append to the base URL
      * @param array|null $queryParams Query string parameters to append to URL
      * @param array|null $body Body of of the request
      * @param bool $usePost Whether to rather user a POST method instead of PUT for updates.
      * @param bool $multipart Whether to use multipart/form-data for the creation (E.g uploading files)
      * @param bool $isAnalytics Whether we should use Analytics API endpoint
      * @return array The response array from the request
      */
    protected static function _update($urlPath = null, $queryParams = null, $body = null, $usePost = false, $multipart = false, $isAnalytics = false)
    { 
        if ($usePost) {
          return self::_staticPost($urlPath, $queryParams, $body, $multipart, $isAnalytics);
        }

        return self::_staticPut($urlPath, $queryParams, $body, $multipart, $isAnalytics);
    }

    /**
      * Delete an API Object
      *
      * @param string|null $urlPath The path to append to the base URL
      * @param array|null $queryParams Query string parameters to append to URL
      * @param bool $isAnalytics Whether we should use Analytics API endpoint
      * @return array The response array from the request
      */
    protected static function _delete($urlPath = null, $queryParams = null, $isAnalytics = false)
    {
        return self::_staticDelete($urlPath, $queryParams, $isAnalytics);
    }

    /**
      * Sends a GET request using our client class
      *
      * @param string|null $urlPath The path to append to the base URL
      * @param array|null $queryParams Query string parameters to append to URL
      * @param bool $isAnalytics Whether we should use Analytics API endpoint
      * @return array The response array from the request
      */
    protected static function _staticGet($urlPath = null, $queryParams = null, $isAnalytics = false) {

        $client = self::getClientInstance($isAnalytics);
        
        return $client->request('GET', $urlPath, $queryParams);
    } 

    /**
      * Sends a POST request using our client class
      *
      * @param string|null $urlPath The path to append to the base URL
      * @param array|null $queryParams Query string parameters to append to URL
      * @param array|null $body The array body which is converted to JSON
      * @param bool $multipart Whether to use multipart/form-data for the POST (E.g uploading files)
      * @param bool $isAnalytics Whether we should use Analytics API endpoint
      * @return array The response array from the request
      */
    protected static function _staticPost($urlPath = null, $queryParams = null, $body = null, $multipart, $isAnalytics = false) {

        $client = self::getClientInstance($isAnalytics);
        
        if ($multipart) {

          // Setup multipart body
          $multipartBody = [];

          foreach ($body as $key => $value) {

            $contents = null;

            // Check for file
            if ($key === 'file') {
              $contents = fopen($value, 'r');
            } else {
              $contents = $value;
            }

            $multipartBody[] = [
              'name'      => $key,
              'contents'  => $contents
            ];
          }

          return $client->request('POST', $urlPath, $queryParams, $multipartBody, true);
        }

        return $client->request('POST', $urlPath, $queryParams, $body, false);
    } 

    /**
      * Sends a PUT request using our client class
      *
      * @param string|null $urlPath The path to append to the base URL
      * @param array|null $queryParams Query string parameters to append to URL
      * @param array|null $body The array body which is converted to JSON
      * @param bool $isAnalytics Whether we should use Analytics API endpoint
      * @return array The response array from the request
      */
    protected static function _staticPut($urlPath = null, $queryParams = null, $body = null, $isAnalytics = false) {

        $client = self::getClientInstance($isAnalytics);
        
        return $client->request('PUT', $urlPath, $queryParams, $body);
    }  

    /**
      * Sends a DELETE request using our client class
      *
      * @param string|null $urlPath The path to append to the base URL
      * @param array|null $queryParams Query string parameters to append to URL
      * @param bool $isAnalytics Whether we should use Analytics API endpoint
      * @return array The response array from the request
      */
    protected static function _staticDelete($urlPath = null, $queryParams = null, $isAnalytics = false) {

        $client = self::getClientInstance($isAnalytics);
        
        return $client->request('DELETE', $urlPath, $queryParams);
    } 

    /**
      * Returns a new instance of our API Client with the latest config
      *
      * @param bool $isAnalytics | Whether to create client pointing to Analytics API
      * @return Adyo\Client
      */
    private static function getClientInstance(bool $isAnalytics = false) {

        if ($isAnalytics === true) {

          return new Client(Adyo::$apiKey, Adyo::$analyticsApiVersion, Adyo::$analyticsApiBase);
        }

        return new Client(Adyo::$apiKey, Adyo::$apiVersion, Adyo::$apiBase);
    }
}