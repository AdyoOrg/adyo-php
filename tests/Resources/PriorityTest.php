<?php

namespace Adyo;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

use Adyo\Adyo;
use Adyo\Client as AdyoClient;

class PriorityTest extends TestCase {

    /**
      * Test creating a priority
      *
      * @return void
      */
    public function testCreate()
    {   
        // Setup mock response
        $responseBody = [
            'id'         => 1,
            'name'       => 'Priority 1',
            'weight'     => 10,
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

        // Create the priority object
        $priority = Priority::create(['name' => 'The priority']);

        // Assert
        $this->assertInstanceOf(\Adyo\Priority::class, $priority);
        $this->assertSame($priority->id, 1);
        $this->assertSame($priority->name, 'Priority 1');
        $this->assertSame($priority->weight, 10);
        $this->assertSame($priority->created_at, '2017-10-04T12:57:18Z');
        $this->assertSame($priority->updated_at, '2017-10-04T12:57:18Z');
    }

    /**
      * Test the retrieval of a priority
      *
      * @return void
      */
    public function testRetrieve()
    {   
        // Setup mock response
        $responseBody = [
            'id'         => 1,
            'name'       => 'Priority 1',
            'weight'     => 10,
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

        // Retrieve the priority object
        $priority = Priority::retrieve(1);

        // Assert
        $this->assertInstanceOf(\Adyo\Priority::class, $priority);
        $this->assertSame($priority->id, 1);
        $this->assertSame($priority->name, 'Priority 1');
        $this->assertSame($priority->weight, 10);
        $this->assertSame($priority->created_at, '2017-10-04T12:57:18Z');
        $this->assertSame($priority->updated_at, '2017-10-04T12:57:18Z');
    }

    /**
      * Test the retrieval of multiple priorities
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
                    'name'       => 'Priority 1',
                    'weight'     => 10,
                    'created_at' => '2017-10-04T12:57:18Z',
                    'updated_at' => '2017-10-04T12:57:18Z'
                ],
                [
                    'id'         => 2,
                    'name'       => 'Priority 2',
                    'weight'     => 20,
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
                    'next' => 'http:\/\/api.adyo.co.za\/v1\/priorities?page=2'
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

        // Retrieve the priority objects
        $list = Priority::retrieveAll([
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
        $this->assertSame($list->next_url, 'http:\/\/api.adyo.co.za\/v1\/priorities?page=2');
        $this->assertNull($list->prev_url);

        $this->assertInstanceOf(\Adyo\Priority::class, $list->objects[0]);
        $this->assertSame($list->objects[0]->id, 1);
        $this->assertSame($list->objects[0]->name, 'Priority 1');
        $this->assertSame($list->objects[0]->weight, 10);
        $this->assertSame($list->objects[0]->created_at, '2017-10-04T12:57:18Z');
        $this->assertSame($list->objects[0]->updated_at, '2017-10-04T12:57:18Z');

        $this->assertInstanceOf(\Adyo\Priority::class, $list->objects[1]);
        $this->assertSame($list->objects[1]->id, 2);
        $this->assertSame($list->objects[1]->name, 'Priority 2');
        $this->assertSame($list->objects[1]->weight, 20);
        $this->assertSame($list->objects[1]->created_at, '2017-10-04T12:57:18Z');
        $this->assertSame($list->objects[1]->updated_at, '2017-10-04T12:57:18Z');
    }

    /**
      * Test updating a priority
      *
      * @return void
      */
    public function testUpdate()
    {
        // Setup mock response
        $responseBody = [
            'id'         => 1,
            'name'       => 'Priority 1',
            'weight'     => 10,
            'created_at' => '2017-10-04T12:57:18Z',
            'updated_at' => '2017-10-04T12:57:18Z'
        ];

        $responseBody2 = [
            'id'         => 1,
            'name'       => 'Updated Name',
            'weight'     => 20,
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

        // Retrieve the priority object to update
        $priority = Priority::retrieve(1);

        // Update
        $priority->name = 'Updated Name';
        $priority->weight = 20;
        $priority->save();

        // Assert
        $this->assertInstanceOf(\Adyo\Priority::class, $priority);
        $this->assertSame($priority->id, 1);
        $this->assertSame($priority->name, 'Updated Name');
        $this->assertSame($priority->weight, 20);
        $this->assertSame($priority->created_at, '2017-10-04T12:58:18Z');
        $this->assertSame($priority->updated_at, '2017-10-04T12:58:18Z');
    }

    /**
      * Test deleting a priority
      *
      * @return void
      */
    public function testDelete()
    {
        // Setup mock responses
        $responseBody = [
            'id'         => 1,
            'name'       => 'Priority 1',
            'weight'     => 10,
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

        // Retrieve the priority object to delete
        $priority = Priority::retrieve(1);

        // Delete
        $priority->delete();

        // Assert
        $this->assertInstanceOf(\Adyo\Priority::class, $priority);
        $this->assertSame($priority->id, 1);
        $this->assertTrue($priority->isDeleted);
        $this->assertFalse(property_exists($priority, 'name'));
        $this->assertFalse(property_exists($priority, 'weight'));
        $this->assertFalse(property_exists($priority, 'created_at'));
        $this->assertFalse(property_exists($priority, 'updated_at'));
    }
}