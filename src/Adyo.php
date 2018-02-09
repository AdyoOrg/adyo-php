<?php

namespace Adyo;

class Adyo {

    /**
     * The Adyo API key to use for requests.
     *
     * @var string|null
     */
    public static $apiKey;

    /**
     * The version of the Adyo API to use for requests.
     *
     * @var string
     */
    public static $apiVersion = 'v1';

    /**
     * The base URL for the Adyo API.
     *
     * @var string
     */
    public static $apiBase = 'https://api.adyo.co.za';

    /**
     * Set the API key to be used for requests.
     *
     * @param string $apiKey
     *
     * @return void
     */
    public static function setApiKey($apiKey)
    {
        self::$apiKey = $apiKey;
    }

    /**
     * Get the API key used for requests.
     * 
     * @return string
     */
    public static function getApiKey()
    {
        return self::$apiKey;
    }

    /**
     * Get the API version used for requests.
     *
     * @return string 
     */
    public static function getApiVersion()
    {
        return self::$apiVersion;
    }

    /**
     * Set the API version to use for requests. 
     *
     * @param string $apiVersion 
     *
     * @return void
     */
    public static function setApiVersion($apiVersion)
    {
        self::$apiVersion = $apiVersion;
    }
}