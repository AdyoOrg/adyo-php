<?php

namespace Adyo;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

use Adyo\Adyo;
use Adyo\Client as AdyoClient;

class AdSizeTest extends TestCase {

    /**
      * Test creating an adSize
      *
      * @return void
      */
    public function testCreate()
    {   
        // Setup mock response
        $responseBody = [
            'id'         => 1,
            'name'       => 'Ad Size 1',
            'width'      => 100,
            'height'     => 50,
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

        // Create the adSize object
        $adSize = AdSize::create([
            'name' => 'Ad Size 1',
            'width' => 100,
            'height' => 50,
        ]);

        // Assert
        $this->assertInstanceOf(\Adyo\AdSize::class, $adSize);
        $this->assertSame($adSize->id, 1);
        $this->assertSame($adSize->name, 'Ad Size 1');
        $this->assertSame($adSize->width, 100);
        $this->assertSame($adSize->height, 50);
        $this->assertSame($adSize->created_at, '2017-10-04T12:57:18Z');
        $this->assertSame($adSize->updated_at, '2017-10-04T12:57:18Z');
    }

    /**
      * Test the retrieval of an adSize
      *
      * @return void
      */
    public function testRetrieve()
    {   
        // Setup mock response
        $responseBody = [
            'id'         => 1,
            'name'       => 'Ad Size 1',
            'width'      => 100,
            'height'     => 50,
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

        // Retrieve the adSize object
        $adSize = AdSize::retrieve(1);

        // Assert
        $this->assertInstanceOf(\Adyo\AdSize::class, $adSize);
        $this->assertSame($adSize->id, 1);
        $this->assertSame($adSize->name, 'Ad Size 1');
        $this->assertSame($adSize->width, 100);
        $this->assertSame($adSize->height, 50);
        $this->assertSame($adSize->created_at, '2017-10-04T12:57:18Z');
        $this->assertSame($adSize->updated_at, '2017-10-04T12:57:18Z');
    }

    /**
      * Test the retrieval of multiple adSizes
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
                    'name'       => 'Ad Size 1',
                    'width'      => 100,
                    'height'     => 50,
                    'created_at' => '2017-10-04T12:57:18Z',
                    'updated_at' => '2017-10-04T12:57:18Z'
                ],
                [
                    'id'         => 2,
                    'name'       => 'Ad Size 2',
                    'width'      => 200,
                    'height'     => 100,
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
                    'next' => 'http:\/\/api.adyo.co.za\/v1\/adSizes?page=2'
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

        // Retrieve the adSize object
        $list = AdSize::retrieveAll([
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
        $this->assertSame($list->next_url, 'http:\/\/api.adyo.co.za\/v1\/adSizes?page=2');
        $this->assertNull($list->prev_url);

        $this->assertInstanceOf(\Adyo\AdSize::class, $list->objects[0]);
        $this->assertSame($list->objects[0]->id, 1);
        $this->assertSame($list->objects[0]->name, 'Ad Size 1');
        $this->assertSame($list->objects[0]->width, 100);
        $this->assertSame($list->objects[0]->height, 50);
        $this->assertSame($list->objects[0]->created_at, '2017-10-04T12:57:18Z');
        $this->assertSame($list->objects[0]->updated_at, '2017-10-04T12:57:18Z');

        $this->assertInstanceOf(\Adyo\AdSize::class, $list->objects[1]);
        $this->assertSame($list->objects[1]->id, 2);
        $this->assertSame($list->objects[1]->name, 'Ad Size 2');
        $this->assertSame($list->objects[1]->width, 200);
        $this->assertSame($list->objects[1]->height, 100);
        $this->assertSame($list->objects[1]->created_at, '2017-10-04T12:57:18Z');
        $this->assertSame($list->objects[1]->updated_at, '2017-10-04T12:57:18Z');
    }

    /**
      * Test updating an adSize
      *
      * @return void
      */
    public function testUpdate()
    {
        // Setup mock response
        $responseBody = [
            'id'         => 1,
            'name'       => 'Updated Name',
            'width'      => 100,
            'height'     => 50,
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

        // Create the adSize object to update
        $adSize = new AdSize;
        $adSize->id = 1;
        $adSize->name = 'Updated Name';
        $adSize->width = 100;
        $adSize->height = 50;
        $adSize->created_at = '2017-10-04T12:57:18Z';
        $adSize->updated_at = '2017-10-04T12:57:18Z';

        // Update
        $adSize->save();

        // Assert
        $this->assertInstanceOf(\Adyo\AdSize::class, $adSize);
        $this->assertSame($adSize->id, 1);
        $this->assertSame($adSize->name, 'Updated Name');
        $this->assertSame($adSize->width, 100);
        $this->assertSame($adSize->height, 50);
        $this->assertSame($adSize->created_at, '2017-10-04T12:57:18Z');
        $this->assertSame($adSize->updated_at, '2017-10-04T12:57:18Z');
    }

    /**
      * Test deleting an adSize
      *
      * @return void
      */
    public function testDelete()
    {
        // Setup mock response
        $responseData = [
            'id'      => 1,
            'deleted' => true,
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($responseData), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);        
        Adyo::setApiKey('keygoeshere');

        // Create the adSize object to delete
        $adSize = new AdSize;
        $adSize->id = 1;
        $adSize->name = 'AdSize Name';
        $adSize->height = 100;
        $adSize->width = 50;
        $adSize->created_at = '2017-10-04T12:57:18Z';
        $adSize->updated_at = '2017-10-04T12:57:18Z';

        // Delete
        $adSize->delete();

        // Assert
        $this->assertInstanceOf(\Adyo\AdSize::class, $adSize);
        $this->assertSame($adSize->id, 1);
        $this->assertTrue($adSize->isDeleted);
        $this->assertFalse(property_exists($adSize, 'name'));
        $this->assertFalse(property_exists($adSize, 'width'));
        $this->assertFalse(property_exists($adSize, 'height'));
        $this->assertFalse(property_exists($adSize, 'created_at'));
        $this->assertFalse(property_exists($adSize, 'updated_at'));
    }
}