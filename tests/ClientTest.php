<?php

namespace Adyo;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

use Adyo\Client as AdyoClient;

class ClientTest extends TestCase {

    /**
     * Test client catching no API key provided
     *
     * @return void
     */
    public function testNoApiKey()
    { 
        // Execute
        $client = new Client(null, Adyo::$apiVersion, Adyo::$apiBase);
        
        try {
            $client->request('GET', '', $queryParams = null, $body = null);

            // Didn't catch
            $this->fail('\Adyo\Exception\UnauthorizedException did not throw.');
        
        } catch(Exception\UnauthorizedException $e) {

            // Just pass
            $this->assertTrue(true);

        } catch (\Exception $e) {

            $this->fail('Wrong exception fired: ' . get_class($e));
        }
    }

    /**
     * Test client catching bad request exceptions
     *
     * @return void
     */
    public function testBadRequestException()
    { 
        // Setup mock response
        $responseBody = [
           'error' => 'Bad Request'
        ];

        $mock = new MockHandler([
            new Response(400, [], json_encode($responseBody), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);

        // Set API Key
        Adyo::setApiKey('keygoeshere');

        // Execute
        $client = new Client(Adyo::$apiKey, Adyo::$apiVersion, Adyo::$apiBase);
        
        try {
            $client->request('GET', '', $queryParams = null, $body = null);

            // Didn't catch
            $this->fail('\Adyo\Exception\BadRequestException did not throw.');
        
        } catch(Exception\BadRequestException $e) {

            $this->assertSame($e->getMessage(), 'Bad Request');
        } catch (\Exception $e) {

            $this->fail('Wrong exception fired: ' . get_class($e));
        }
    }

    /**
     * Test client catching not found exceptions
     *
     * @return void
     */
    public function testNotFoundException()
    { 
        // Setup mock response
        $responseBody = [
           'error' => 'Not Found'
        ];

        $mock = new MockHandler([
            new Response(404, [], json_encode($responseBody), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);

        // Set API Key
        Adyo::setApiKey('keygoeshere');

        // Execute
        $client = new Client(Adyo::$apiKey, Adyo::$apiVersion, Adyo::$apiBase);
        
        try {
            $client->request('GET', '', $queryParams = null, $body = null);

            // Didn't catch
            $this->fail('\Adyo\Exception\NotFoundException did not throw.');
        
        } catch(Exception\NotFoundException $e) {

            $this->assertSame($e->getMessage(), 'Not Found');
        } catch (\Exception $e) {

            $this->fail('Wrong exception fired: ' . get_class($e));
        }
    }

    /**
     * Test client catching method not allowed exceptions
     *
     * @return void
     */
    public function testMethodNotAllowed()
    { 
        // Setup mock response
        $responseBody = [
           'error' => 'Method Not Allowed'
        ];

        $mock = new MockHandler([
            new Response(405, [], json_encode($responseBody), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);

        // Set API Key
        Adyo::setApiKey('keygoeshere');

        // Execute
        $client = new Client(Adyo::$apiKey, Adyo::$apiVersion, Adyo::$apiBase);
        
        try {
            $client->request('GET', '', $queryParams = null, $body = null);

            // Didn't catch
            $this->fail('\Adyo\Exception\MethodNotAllowedException did not throw.');
        
        } catch(Exception\MethodNotAllowedException $e) {

            $this->assertSame($e->getMessage(), 'Method Not Allowed');
        } catch (\Exception $e) {

            $this->fail('Wrong exception fired: ' . get_class($e));
        }
    }

    /**
     * Test client catching rate limit exceptions
     *
     * @return void
     */
    public function testRateLimitException()
    { 
        // Setup mock response
        $responseBody = [
           'error' => 'Rate Limited'
        ];

        $mock = new MockHandler([
            new Response(429, [], json_encode($responseBody), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);

        // Set API Key
        Adyo::setApiKey('keygoeshere');

        // Execute
        $client = new Client(Adyo::$apiKey, Adyo::$apiVersion, Adyo::$apiBase);
        
        try {
            $client->request('GET', '', $queryParams = null, $body = null);

            // Didn't catch
            $this->fail('\Adyo\Exception\RateLimitException did not throw.');
        
        } catch(Exception\RateLimitException $e) {

            $this->assertSame($e->getMessage(), 'Rate Limited');
        } catch (\Exception $e) {

            $this->fail('Wrong exception fired: ' . get_class($e));
        }
    }

    /**
     * Test client catching unauthorized exceptions
     *
     * @return void
     */
    public function testUnauthorizedException()
    { 
        // Setup mock response
        $responseBody = [
           'error' => 'Unauthorized'
        ];

        $mock = new MockHandler([
            new Response(401, [], json_encode($responseBody), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);

        // Set API Key
        Adyo::setApiKey('keygoeshere');

        // Execute
        $client = new Client(Adyo::$apiKey, Adyo::$apiVersion, Adyo::$apiBase);
        
        try {
            $client->request('GET', '', $queryParams = null, $body = null);

            // Didn't catch
            $this->fail('\Adyo\Exception\UnauthorizedException did not throw.');
        
        } catch(Exception\UnauthorizedException $e) {

            $this->assertSame($e->getMessage(), 'Unauthorized');
        } catch (\Exception $e) {

            $this->fail('Wrong exception fired: ' . get_class($e));
        }
    }

    /**
     * Test client catching server 5xx exceptions
     *
     * @return void
     */
    public function testServerException()
    { 
        // Setup mock responses
        $mock = new MockHandler(
            [
                new Response(500, [], null, null), // Internal Server Error
                new Response(501, [], null, null), // Not Implemented
                new Response(502, [], null, null), // Bad Gateway
                new Response(503, [], null, null), // Service Unavailable
                new Response(504, [], null, null), // Gateway Timeout
                new Response(505, [], null, null), // HTTP Version Not Supported
                new Response(511, [], null, null), // Network Authentication Failed
                new Response(598, [], null, null), // Network Read Timeout Error
                new Response(599, [], null, null), // Network Connect Timeout Error
            ]
        );

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);

        // Set API Key
        Adyo::setApiKey('keygoeshere');

        // Execute
        $client = new Client(Adyo::$apiKey, Adyo::$apiVersion, Adyo::$apiBase);
        
        // Test 500
        try {
            $client->request('GET', '', $queryParams = null, $body = null);
            
            $this->fail('\Adyo\Exception\ApiException did not throw.'); // Didn't catch
        } catch(Exception\ApiException $e) {
            $this->assertSame($e->getHttpStatusCode(), 500);
        } catch (\Exception $e) {
            $this->fail('Wrong exception fired: ' . get_class($e));
        }

        // Test 501
        try {
            $client->request('GET', '', $queryParams = null, $body = null);
            
            $this->fail('\Adyo\Exception\ApiException did not throw.'); // Didn't catch
        } catch(Exception\ApiException $e) {
            $this->assertSame($e->getHttpStatusCode(), 501);
        } catch (\Exception $e) {
            $this->fail('Wrong exception fired: ' . get_class($e));
        }

        // Test 502
        try {
            $client->request('GET', '', $queryParams = null, $body = null);
            
            $this->fail('\Adyo\Exception\ApiException did not throw.'); // Didn't catch
        } catch(Exception\ApiException $e) {
            $this->assertSame($e->getHttpStatusCode(), 502);
        } catch (\Exception $e) {
            $this->fail('Wrong exception fired: ' . get_class($e));
        }

        // Test 503
        try {
            $client->request('GET', '', $queryParams = null, $body = null);
            
            $this->fail('\Adyo\Exception\ApiException did not throw.'); // Didn't catch
        } catch(Exception\ApiException $e) {
            $this->assertSame($e->getHttpStatusCode(), 503);
        } catch (\Exception $e) {
            $this->fail('Wrong exception fired: ' . get_class($e));
        }

        // Test 504
        try {
            $client->request('GET', '', $queryParams = null, $body = null);
            
            $this->fail('\Adyo\Exception\ApiException did not throw.'); // Didn't catch
        } catch(Exception\ApiException $e) {
            $this->assertSame($e->getHttpStatusCode(), 504);
        } catch (\Exception $e) {
            $this->fail('Wrong exception fired: ' . get_class($e));
        }

        // Test 505
        try {
            $client->request('GET', '', $queryParams = null, $body = null);
            
            $this->fail('\Adyo\Exception\ApiException did not throw.'); // Didn't catch
        } catch(Exception\ApiException $e) {
            $this->assertSame($e->getHttpStatusCode(), 505);
        } catch (\Exception $e) {
            $this->fail('Wrong exception fired: ' . get_class($e));
        }

        // Test 511
        try {
            $client->request('GET', '', $queryParams = null, $body = null);
            
            $this->fail('\Adyo\Exception\ApiException did not throw.'); // Didn't catch
        } catch(Exception\ApiException $e) {
            $this->assertSame($e->getHttpStatusCode(), 511);
        } catch (\Exception $e) {
            $this->fail('Wrong exception fired: ' . get_class($e));
        }

        // Test 598
        try {
            $client->request('GET', '', $queryParams = null, $body = null);
            
            $this->fail('\Adyo\Exception\ApiException did not throw.'); // Didn't catch
        } catch(Exception\ApiException $e) {
            $this->assertSame($e->getHttpStatusCode(), 598);
        } catch (\Exception $e) {
            $this->fail('Wrong exception fired: ' . get_class($e));
        }

        // Test 599
        try {
            $client->request('GET', '', $queryParams = null, $body = null);
            
            $this->fail('\Adyo\Exception\ApiException did not throw.'); // Didn't catch
        } catch(Exception\ApiException $e) {
            $this->assertSame($e->getHttpStatusCode(), 599);
        } catch (\Exception $e) {
            $this->fail('Wrong exception fired: ' . get_class($e));
        }
    }
}