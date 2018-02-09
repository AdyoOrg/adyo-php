<?php

namespace Adyo;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

use Adyo\Adyo;
use Adyo\Client as AdyoClient;

class ZoneTest extends TestCase {

    /**
      * Test creating a zone
      *
      * @return void
      */
    public function testCreate()
    {   
        // Setup mock response
        $responseBody = [
            'id'                => 1,
            'publisher_id'      => 1,
            'type'              => 'banner',
            'name'              => 'Banner Zone',
            'is_dynamic_size'   => false,
            'width'             => 200,
            'height'            => 100,
            'created_at'        => '2017-10-04T12:57:18Z',
            'updated_at'        => '2017-10-04T12:57:18Z'
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($responseBody), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);        
        Adyo::setApiKey('keygoeshere');

        // Create the zone object
        $zone = Zone::create([
            'publisher_id'  => 1,
            'type'          => 'banner',
            'name'          => 'Banner Zone',
            'width'         => 200,
            'height'        => 100,
        ]);

        // Assert
        $this->assertInstanceOf(\Adyo\Zone::class, $zone);
        $this->assertSame($zone->id, 1);
        $this->assertSame($zone->publisher_id, 1);
        $this->assertSame($zone->type, 'banner');
        $this->assertSame($zone->name, 'Banner Zone');
        $this->assertFalse($zone->is_dynamic_size);
        $this->assertSame($zone->width, 200);
        $this->assertSame($zone->height, 100);
        $this->assertSame($zone->created_at, '2017-10-04T12:57:18Z');
        $this->assertSame($zone->updated_at, '2017-10-04T12:57:18Z');
    }

    /**
      * Test the retrieval of a zone
      *
      * @return void
      */
    public function testRetrieve()
    {   
        // Setup mock response
        $responseBody = [
            'id'                => 1,
            'publisher_id'      => 1,
            'type'              => 'banner',
            'name'              => 'Banner Zone',
            'is_dynamic_size'   => false,
            'width'             => 200,
            'height'            => 100,
            'created_at'        => '2017-10-04T12:57:18Z',
            'updated_at'        => '2017-10-04T12:57:18Z'
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($responseBody), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);        
        Adyo::setApiKey('keygoeshere');

        // Retrieve the zone object
        $zone = Zone::retrieve(1);

        // Assert
        $this->assertInstanceOf(\Adyo\Zone::class, $zone);
        $this->assertSame($zone->id, 1);
        $this->assertSame($zone->publisher_id, 1);
        $this->assertSame($zone->type, 'banner');
        $this->assertSame($zone->name, 'Banner Zone');
        $this->assertFalse($zone->is_dynamic_size);
        $this->assertSame($zone->width, 200);
        $this->assertSame($zone->height, 100);
        $this->assertSame($zone->created_at, '2017-10-04T12:57:18Z');
        $this->assertSame($zone->updated_at, '2017-10-04T12:57:18Z');
    }

    /**
      * Test the retrieval of multiple zones
      *
      * @return void
      */
    public function testRetrieveAll()
    {   
        // Setup mock response
        $responseBody = [
            'data' => [
                [
                    'id'                => 1,
                    'publisher_id'      => 1,
                    'type'              => 'banner',
                    'name'              => 'Banner Zone',
                    'is_dynamic_size'   => false,
                    'width'             => 200,
                    'height'            => 100,
                    'created_at'        => '2017-10-04T12:57:18Z',
                    'updated_at'        => '2017-10-04T12:57:18Z'
                ],
                [
                    'id'                => 2,
                    'publisher_id'      => 1,
                    'type'              => 'email',
                    'name'              => 'Email Zone',
                    'is_dynamic_size'   => false,
                    'width'             => 300,
                    'height'            => 300,
                    'created_at'        => '2017-10-04T12:57:18Z',
                    'updated_at'        => '2017-10-04T12:57:18Z'
                ]
            ],
            'pagination' => [
                'total'         => 13,
                'count'         => 2,
                'per_page'      => 2,
                'current_page'  => 1,
                'total_pages'   => 7,
                'links' => [
                    'next' => 'http:\/\/api.adyo.co.za\/v1\/zones?page=2'
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

        // Retrieve the zone objects
        $list = Zone::retrieveAll([
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
        $this->assertSame($list->next_url, 'http:\/\/api.adyo.co.za\/v1\/zones?page=2');
        $this->assertNull($list->prev_url);

        $this->assertInstanceOf(\Adyo\Zone::class, $list->objects[0]);
        $this->assertSame($list->objects[0]->id, 1);
        $this->assertSame($list->objects[0]->publisher_id, 1);
        $this->assertSame($list->objects[0]->type, 'banner');
        $this->assertSame($list->objects[0]->name, 'Banner Zone');
        $this->assertFalse($list->objects[0]->is_dynamic_size);
        $this->assertSame($list->objects[0]->width, 200);
        $this->assertSame($list->objects[0]->height, 100);
        $this->assertSame($list->objects[0]->created_at, '2017-10-04T12:57:18Z');
        $this->assertSame($list->objects[0]->updated_at, '2017-10-04T12:57:18Z');

        $this->assertInstanceOf(\Adyo\Zone::class, $list->objects[1]);
        $this->assertSame($list->objects[1]->id, 2);
        $this->assertSame($list->objects[1]->publisher_id, 1);
        $this->assertSame($list->objects[1]->type, 'email');
        $this->assertSame($list->objects[1]->name, 'Email Zone');
        $this->assertFalse($list->objects[1]->is_dynamic_size);
        $this->assertSame($list->objects[1]->width, 300);
        $this->assertSame($list->objects[1]->height, 300);
        $this->assertSame($list->objects[1]->created_at, '2017-10-04T12:57:18Z');
        $this->assertSame($list->objects[1]->updated_at, '2017-10-04T12:57:18Z');
    }

    /**
      * Test updating a zone
      *
      * @return void
      */
    public function testUpdate()
    {
        // Setup mock response
        $responseBody = [
            'id'                => 1,
            'publisher_id'      => 1,
            'type'              => 'banner',
            'name'              => 'Updated Name',
            'is_dynamic_size'   => false,
            'width'             => 150,
            'height'            => 140,
            'created_at'        => '2017-10-04T12:57:18Z',
            'updated_at'        => '2017-10-04T12:57:18Z'
        ];

        $responseBody2 = [
            'id'                => 1,
            'publisher_id'      => 2,
            'type'              => 'banner',
            'name'              => 'Updated Name',
            'is_dynamic_size'   => false,
            'width'             => 120,
            'height'            => 100,
            'created_at'        => '2017-10-04T12:58:18Z',
            'updated_at'        => '2017-10-04T12:58:18Z'
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($responseBody), null),
            new Response(200, [], json_encode($responseBody2), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);        
        Adyo::setApiKey('keygoeshere');

        // Retrieve the zone object to update
        $zone = Zone::retrieve(1);

        // Update
        $zone->name = 'Updated Name';
        $zone->width = 120;
        $zone->height = 100;
        $zone->save();

        // Assert
        $this->assertInstanceOf(\Adyo\Zone::class, $zone);
        $this->assertSame($zone->id, 1);
        $this->assertSame($zone->publisher_id, 2);
        $this->assertSame($zone->type, 'banner');
        $this->assertSame($zone->name, 'Updated Name');
        $this->assertFalse($zone->is_dynamic_size);
        $this->assertSame($zone->width, 120);
        $this->assertSame($zone->height, 100);
        $this->assertSame($zone->created_at, '2017-10-04T12:58:18Z');
        $this->assertSame($zone->updated_at, '2017-10-04T12:58:18Z');
    }

    /**
      * Test deleting a zone
      *
      * @return void
      */
    public function testDelete()
    {
        // Setup mock response
        $responseBody = [
            'id'                => 1,
            'publisher_id'      => 1,
            'type'              => 'banner',
            'name'              => 'Updated Name',
            'is_dynamic_size'   => false,
            'width'             => 150,
            'height'            => 140,
            'created_at'        => '2017-10-04T12:57:18Z',
            'updated_at'        => '2017-10-04T12:57:18Z'
        ];

        $responseBody2 = [
            'id' => 1,
            'deleted' => true
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($responseBody), null),
            new Response(200, [], json_encode($responseBody2), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);        
        Adyo::setApiKey('keygoeshere');

        // Retrieve the zone to delete
        $zone = Zone::retrieve(1);

        // Delete
        $zone->delete();

        // Assert
        $this->assertInstanceOf(\Adyo\Zone::class, $zone);
        $this->assertSame($zone->id, 1);
        $this->assertTrue($zone->isDeleted);
        $this->assertFalse(property_exists($zone, 'publisher_id'));
        $this->assertFalse(property_exists($zone, 'type'));
        $this->assertFalse(property_exists($zone, 'name'));
        $this->assertFalse(property_exists($zone, 'is_dynamic_size'));
        $this->assertFalse(property_exists($zone, 'width'));
        $this->assertFalse(property_exists($zone, 'height'));
        $this->assertFalse(property_exists($zone, 'created_at'));
        $this->assertFalse(property_exists($zone, 'updated_at'));
    }
}