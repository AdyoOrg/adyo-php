<?php

namespace Adyo;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

use Adyo\Adyo;
use Adyo\Client as AdyoClient;

class PublisherTest extends TestCase {

    /**
      * Test creating a publisher
      *
      * @return void
      */
    public function testCreate()
    {   
        // Setup mock response
        $responseBody = [
            'id'         => 1,
            'name'       => 'The Publisher',
            'created_at' => '2017-10-04T12:57:18Z',
            'updated_at' => '2017-10-04T12:57:18Z'
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($responseBody), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);        
        Adyo::setApiKey('keygoeshere');

        // Create the publisher object
        $publisher = Publisher::create(['name' => 'The publisher']);

        // Assert
        $this->assertInstanceOf(\Adyo\Publisher::class, $publisher);
        $this->assertSame($publisher->id, 1);
        $this->assertSame($publisher->name, 'The Publisher');
        $this->assertSame($publisher->created_at, '2017-10-04T12:57:18Z');
        $this->assertSame($publisher->updated_at, '2017-10-04T12:57:18Z');
    }

    /**
      * Test the retrieval of a publisher
      *
      * @return void
      */
    public function testRetrieve()
    {   
        // Setup mock response
        $responseBody = [
            'id'         => 1,
            'name'       => 'The Publisher',
            'created_at' => '2017-10-04T12:57:18Z',
            'updated_at' => '2017-10-04T12:57:18Z'
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($responseBody), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);        
        Adyo::setApiKey('keygoeshere');

        // Retrieve the publisher object
        $publisher = Publisher::retrieve(1);

        // Assert
        $this->assertInstanceOf(\Adyo\Publisher::class, $publisher);
        $this->assertSame($publisher->id, 1);
        $this->assertSame($publisher->name, 'The Publisher');
        $this->assertSame($publisher->created_at, '2017-10-04T12:57:18Z');
        $this->assertSame($publisher->updated_at, '2017-10-04T12:57:18Z');
    }

    /**
      * Test the retrieval of multiple publishers
      *
      * @return void
      */
    public function testRetrieveAll()
    {   
        // Setup mock response
        $responseBody = [
            'data' => [
                [
                    'id'         => 1,
                    'name'       => 'The Publisher',
                    'created_at' => '2017-10-04T12:57:18Z',
                    'updated_at' => '2017-10-04T12:57:18Z'
                ],
                [
                    'id'         => 2,
                    'name'       => 'The Publisher 2',
                    'created_at' => '2017-10-04T12:57:18Z',
                    'updated_at' => '2017-10-04T12:57:18Z'
                ]
            ],
            'pagination' => [
                'total'         => 13,
                'count'         => 2,
                'per_page'      => 2,
                'current_page'  => 1,
                'total_pages'   => 7,
                'links' => [
                    'next' => 'http:\/\/api.adyo.co.za\/v1\/publishers?page=2'
                ]
            ]
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($responseBody), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);        
        Adyo::setApiKey('keygoeshere');

        // Retrieve the publisher objects
        $list = Publisher::retrieveAll([
            'page'      => 1,
            'perPage'   => 2,
            'sort'      => 'name,-updated_at',
        ]);

        // // Assert
        $this->assertInstanceOf(\Adyo\AdyoList::class, $list);
        $this->assertSame(count($list->objects), 2);
        $this->assertSame($list->total, 13);
        $this->assertSame($list->count, 2);
        $this->assertSame($list->per_page, 2);
        $this->assertSame($list->current_page, 1);
        $this->assertSame($list->total_pages, 7);
        $this->assertSame($list->next_url, 'http:\/\/api.adyo.co.za\/v1\/publishers?page=2');
        $this->assertNull($list->prev_url);

        $this->assertInstanceOf(\Adyo\Publisher::class, $list->objects[0]);
        $this->assertSame($list->objects[0]->id, 1);
        $this->assertSame($list->objects[0]->name, 'The Publisher');
        $this->assertSame($list->objects[0]->created_at, '2017-10-04T12:57:18Z');
        $this->assertSame($list->objects[0]->updated_at, '2017-10-04T12:57:18Z');

        $this->assertInstanceOf(\Adyo\Publisher::class, $list->objects[1]);
        $this->assertSame($list->objects[1]->id, 2);
        $this->assertSame($list->objects[1]->name, 'The Publisher 2');
        $this->assertSame($list->objects[1]->created_at, '2017-10-04T12:57:18Z');
        $this->assertSame($list->objects[1]->updated_at, '2017-10-04T12:57:18Z');
    }

    /**
      * Test updating a publisher
      *
      * @return void
      */
    public function testUpdate()
    {
        // Setup mock responses
        $responseBody = [
            'id' => 1,
            'name' => 'Publisher 1',
            'created_at' => '2017-10-04T12:57:18Z',
            'updated_at' => '2017-10-04T12:57:18Z'
        ];

        $responseBody2 = [
            'id' => 1,
            'name' => 'Updated Name',
            'created_at' => '2017-10-04T12:58:18Z',
            'updated_at' => '2017-10-04T12:58:18Z'
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($responseBody), null),
            new Response(200, [], json_encode($responseBody2), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);        
        Adyo::setApiKey('keygoeshere');

        // Create the publisher object to update
        $publisher = Publisher::retrieve(1);

        // Update
        $publisher->name = 'Updated Name';
        $publisher->save();

        // Assert
        $this->assertInstanceOf(\Adyo\Publisher::class, $publisher);
        $this->assertSame($publisher->id, 1);
        $this->assertSame($publisher->name, 'Updated Name');
        $this->assertSame($publisher->created_at, '2017-10-04T12:58:18Z');
        $this->assertSame($publisher->updated_at, '2017-10-04T12:58:18Z');
    }

    /**
      * Test deleting a publisher
      *
      * @return void
      */
    public function testDelete()
    {
        // Setup mock responses
        $responseBody = [
            'id' => 1,
            'name' => 'Publisher 1',
            'created_at' => '2017-10-04T12:57:18Z',
            'updated_at' => '2017-10-04T12:57:18Z'
        ];

        $responseBody2 = [
            'id' => 1,
            'deleted' => true,
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($responseBody), null),
            new Response(200, [], json_encode($responseBody2), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);        
        Adyo::setApiKey('keygoeshere');

        // Retrieve the publisher to delete
        $publisher = Publisher::retrieve(1);

        // Delete
        $publisher->delete();

        // Assert
        $this->assertInstanceOf(\Adyo\Publisher::class, $publisher);
        $this->assertSame($publisher->id, 1);
        $this->assertTrue($publisher->isDeleted);
        $this->assertFalse(property_exists($publisher, 'name'));
        $this->assertFalse(property_exists($publisher, 'created_at'));
        $this->assertFalse(property_exists($publisher, 'updated_at'));
    }
}