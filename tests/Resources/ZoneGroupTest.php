<?php

namespace Adyo;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

use Adyo\Adyo;
use Adyo\Client as AdyoClient;

class ZoneGroupTest extends TestCase {

    /**
      * Test creating a zone group
      *
      * @return void
      */
    public function testCreate()
    {   
        // Setup mock response
        $responseBody = [
            'id'    => 1,
            'name'  => 'Zone Group',
            'zones' => [
                [
                    'id'                => 1,
                    'publisher_id'      => 1,
                    'type'              => 'banner',
                    'name'              => 'Zone 1',
                    'is_dynamic_size'   => false,
                    'width'             => 100,
                    'height'            => 100,
                    'created_at'        => '2017-10-03T06:17:44Z',
                    'updated_at'        => '2017-10-03T06:17:44Z',
                ],
                [
                    'id'                => 2,
                    'publisher_id'      => 1,
                    'type'              => 'banner',
                    'name'              => 'Zone 2',
                    'is_dynamic_size'   => true,
                    'created_at'        => '2017-10-10T06:17:44Z',
                    'updated_at'        => '2017-10-10T06:17:44Z',
                ]
            ],
            'created_at' => '2017-10-02T06:17:44Z',
            'updated_at' => '2017-10-02T06:17:44Z',
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($responseBody), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);        
        Adyo::setApiKey('keygoeshere');

        // Create the zone group object
        $zoneGroup = ZoneGroup::create([
            'name'          => 'Zone Group',
            'zone_ids'      => [1, 2],
        ]);

        // Assert
        $this->assertInstanceOf(\Adyo\ZoneGroup::class, $zoneGroup);
        $this->assertSame($zoneGroup->id, 1);
        $this->assertSame($zoneGroup->name, 'Zone Group');
        $this->assertTrue(is_array($zoneGroup->zones));
        $this->assertSame(count($zoneGroup->zones), 2);
        
        $this->assertInstanceOf(\Adyo\Zone::class, $zoneGroup->zones[0]);
        $this->assertSame($zoneGroup->zones[0]->id, 1);
        $this->assertSame($zoneGroup->zones[0]->publisher_id, 1);
        $this->assertSame($zoneGroup->zones[0]->type, 'banner');
        $this->assertSame($zoneGroup->zones[0]->name, 'Zone 1');
        $this->assertSame($zoneGroup->zones[0]->is_dynamic_size, false);
        $this->assertSame($zoneGroup->zones[0]->width, 100);
        $this->assertSame($zoneGroup->zones[0]->height, 100);
        $this->assertSame($zoneGroup->zones[0]->created_at, '2017-10-03T06:17:44Z');
        $this->assertSame($zoneGroup->zones[0]->updated_at, '2017-10-03T06:17:44Z');

        $this->assertInstanceOf(\Adyo\Zone::class, $zoneGroup->zones[1]);
        $this->assertSame($zoneGroup->zones[1]->id, 2);
        $this->assertSame($zoneGroup->zones[1]->publisher_id, 1);
        $this->assertSame($zoneGroup->zones[1]->type, 'banner');
        $this->assertSame($zoneGroup->zones[1]->name, 'Zone 2');
        $this->assertSame($zoneGroup->zones[1]->is_dynamic_size, true);
        $this->assertSame($zoneGroup->zones[1]->created_at, '2017-10-10T06:17:44Z');
        $this->assertSame($zoneGroup->zones[1]->updated_at, '2017-10-10T06:17:44Z');
        
        $this->assertSame($zoneGroup->created_at, '2017-10-02T06:17:44Z');
        $this->assertSame($zoneGroup->updated_at, '2017-10-02T06:17:44Z');
    }

    /**
      * Test the retrieval of a zone group
      *
      * @return void
      */
    public function testRetrieve()
    {   
        // Setup mock response
        $responseBody = [
            'id'    => 1,
            'name'  => 'Zone Group',
            'zones' => [
                [
                    'id'                => 1,
                    'publisher_id'      => 1,
                    'type'              => 'banner',
                    'name'              => 'Zone 1',
                    'is_dynamic_size'   => false,
                    'width'             => 100,
                    'height'            => 100,
                    'created_at'        => '2017-10-03T06:17:44Z',
                    'updated_at'        => '2017-10-03T06:17:44Z',
                ],
                [
                    'id'                => 2,
                    'publisher_id'      => 1,
                    'type'              => 'banner',
                    'name'              => 'Zone 2',
                    'is_dynamic_size'   => true,
                    'created_at'        => '2017-10-10T06:17:44Z',
                    'updated_at'        => '2017-10-10T06:17:44Z',
                ]
            ],
            'created_at' => '2017-10-02T06:17:44Z',
            'updated_at' => '2017-10-02T06:17:44Z',
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($responseBody), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);        
        Adyo::setApiKey('keygoeshere');

        // Retrieve the zoneGroup object
        $zoneGroup = ZoneGroup::retrieve(1);

        // Assert
        $this->assertInstanceOf(\Adyo\ZoneGroup::class, $zoneGroup);
        $this->assertSame($zoneGroup->id, 1);
        $this->assertSame($zoneGroup->name, 'Zone Group');
        $this->assertTrue(is_array($zoneGroup->zones));
        $this->assertSame(count($zoneGroup->zones), 2);
        
        $this->assertInstanceOf(\Adyo\Zone::class, $zoneGroup->zones[0]);
        $this->assertSame($zoneGroup->zones[0]->id, 1);
        $this->assertSame($zoneGroup->zones[0]->publisher_id, 1);
        $this->assertSame($zoneGroup->zones[0]->type, 'banner');
        $this->assertSame($zoneGroup->zones[0]->name, 'Zone 1');
        $this->assertSame($zoneGroup->zones[0]->is_dynamic_size, false);
        $this->assertSame($zoneGroup->zones[0]->width, 100);
        $this->assertSame($zoneGroup->zones[0]->height, 100);
        $this->assertSame($zoneGroup->zones[0]->created_at, '2017-10-03T06:17:44Z');
        $this->assertSame($zoneGroup->zones[0]->updated_at, '2017-10-03T06:17:44Z');

        $this->assertInstanceOf(\Adyo\Zone::class, $zoneGroup->zones[1]);
        $this->assertSame($zoneGroup->zones[1]->id, 2);
        $this->assertSame($zoneGroup->zones[1]->publisher_id, 1);
        $this->assertSame($zoneGroup->zones[1]->type, 'banner');
        $this->assertSame($zoneGroup->zones[1]->name, 'Zone 2');
        $this->assertSame($zoneGroup->zones[1]->is_dynamic_size, true);
        $this->assertSame($zoneGroup->zones[1]->created_at, '2017-10-10T06:17:44Z');
        $this->assertSame($zoneGroup->zones[1]->updated_at, '2017-10-10T06:17:44Z');
        
        $this->assertSame($zoneGroup->created_at, '2017-10-02T06:17:44Z');
        $this->assertSame($zoneGroup->updated_at, '2017-10-02T06:17:44Z');
    }

    /**
      * Test the retrieval of multiple zone groups
      *
      * @return void
      */
    public function testRetrieveAll()
    {   
        // Setup mock response
        $responseBody = [
            'data' => [
                [
                    'id'    => 1,
                    'name'  => 'Zone Group 1',
                    'zones' => [
                        [
                            'id'                => 1,
                            'publisher_id'      => 1,
                            'type'              => 'banner',
                            'name'              => 'Zone 1',
                            'is_dynamic_size'   => false,
                            'width'             => 100,
                            'height'            => 100,
                            'created_at'        => '2017-10-03T05:17:44Z',
                            'updated_at'        => '2017-10-03T05:17:44Z',
                        ],
                        [
                            'id'                => 2,
                            'publisher_id'      => 1,
                            'type'              => 'banner',
                            'name'              => 'Zone 2',
                            'is_dynamic_size'   => true,
                            'created_at'        => '2017-10-10T06:17:44Z',
                            'updated_at'        => '2017-10-10T06:17:44Z',
                        ]
                    ],
                    'created_at' => '2017-10-02T06:17:44Z',
                    'updated_at' => '2017-10-02T06:17:44Z',
                ],
                [
                    'id'    => 2,
                    'name'  => 'Zone Group 2',
                    'zones' => [
                        [
                            'id'                => 3,
                            'publisher_id'      => 2,
                            'type'              => 'banner',
                            'name'              => 'Zone 3',
                            'is_dynamic_size'   => false,
                            'width'             => 300,
                            'height'            => 300,
                            'created_at'        => '2017-10-03T06:18:44Z',
                            'updated_at'        => '2017-10-03T06:18:44Z',
                        ]
                    ],
                    'created_at' => '2017-10-01T06:17:44Z',
                    'updated_at' => '2017-10-01T06:17:44Z',
                ]
            ],
            'pagination' => [
                'total'         => 13,
                'count'         => 2,
                'per_page'      => 2,
                'current_page'  => 1,
                'total_pages'   => 7,
                'links' => [
                    'next' => 'http:\/\/api.adyo.co.za\/v1\/zone-groups?page=2'
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

        // Retrieve the zone group objects
        $list = ZoneGroup::retrieveAll([
            'page'      => 1,
            'perPage'   => 2,
            'sort'      => 'name,-updated_at',
        ]);

        // Assert
        $this->assertInstanceOf(\Adyo\AdyoList::class, $list);
        $this->assertSame(count($list->objects), 2);
        $this->assertSame($list->total, 13);
        $this->assertSame($list->count, 2);
        $this->assertSame($list->per_page, 2);
        $this->assertSame($list->current_page, 1);
        $this->assertSame($list->total_pages, 7);
        $this->assertSame($list->next_url, 'http:\/\/api.adyo.co.za\/v1\/zone-groups?page=2');
        $this->assertNull($list->prev_url);

        // Object 1
        $this->assertInstanceOf(\Adyo\ZoneGroup::class, $list->objects[0]);
        $this->assertSame($list->objects[0]->id, 1);
        $this->assertSame($list->objects[0]->name, 'Zone Group 1');
        $this->assertTrue(is_array($list->objects[0]->zones));
        $this->assertSame(count($list->objects[0]->zones), 2);
        $this->assertSame($list->objects[0]->created_at, '2017-10-02T06:17:44Z');
        $this->assertSame($list->objects[0]->updated_at, '2017-10-02T06:17:44Z');

        $this->assertInstanceOf(\Adyo\Zone::class, $list->objects[0]->zones[0]);
        $this->assertSame($list->objects[0]->zones[0]->id, 1);
        $this->assertSame($list->objects[0]->zones[0]->publisher_id, 1);
        $this->assertSame($list->objects[0]->zones[0]->type, 'banner');
        $this->assertSame($list->objects[0]->zones[0]->name, 'Zone 1');
        $this->assertSame($list->objects[0]->zones[0]->is_dynamic_size, false);
        $this->assertSame($list->objects[0]->zones[0]->width, 100);
        $this->assertSame($list->objects[0]->zones[0]->height, 100);
        $this->assertSame($list->objects[0]->zones[0]->created_at, '2017-10-03T05:17:44Z');
        $this->assertSame($list->objects[0]->zones[0]->updated_at, '2017-10-03T05:17:44Z');

        $this->assertInstanceOf(\Adyo\Zone::class, $list->objects[0]->zones[1]);
        $this->assertSame($list->objects[0]->zones[1]->id, 2);
        $this->assertSame($list->objects[0]->zones[1]->publisher_id, 1);
        $this->assertSame($list->objects[0]->zones[1]->type, 'banner');
        $this->assertSame($list->objects[0]->zones[1]->name, 'Zone 2');
        $this->assertSame($list->objects[0]->zones[1]->is_dynamic_size, true);
        $this->assertSame($list->objects[0]->zones[1]->created_at, '2017-10-10T06:17:44Z');
        $this->assertSame($list->objects[0]->zones[1]->updated_at, '2017-10-10T06:17:44Z');

        // Object 2
        $this->assertInstanceOf(\Adyo\ZoneGroup::class, $list->objects[1]);
        $this->assertSame($list->objects[1]->id, 2);
        $this->assertSame($list->objects[1]->name, 'Zone Group 2');
        $this->assertTrue(is_array($list->objects[1]->zones));
        $this->assertSame(count($list->objects[1]->zones), 1);
        $this->assertSame($list->objects[1]->created_at, '2017-10-01T06:17:44Z');
        $this->assertSame($list->objects[1]->updated_at, '2017-10-01T06:17:44Z');

        $this->assertInstanceOf(\Adyo\Zone::class, $list->objects[1]->zones[0]);
        $this->assertSame($list->objects[1]->zones[0]->id, 3);
        $this->assertSame($list->objects[1]->zones[0]->publisher_id, 2);
        $this->assertSame($list->objects[1]->zones[0]->type, 'banner');
        $this->assertSame($list->objects[1]->zones[0]->name, 'Zone 3');
        $this->assertSame($list->objects[1]->zones[0]->is_dynamic_size, false);
        $this->assertSame($list->objects[1]->zones[0]->width, 300);
        $this->assertSame($list->objects[1]->zones[0]->height, 300);
        $this->assertSame($list->objects[1]->zones[0]->created_at, '2017-10-03T06:18:44Z');
        $this->assertSame($list->objects[1]->zones[0]->updated_at, '2017-10-03T06:18:44Z');  
    }

    /**
      * Test updating a zone group
      *
      * @return void
      */
    public function testUpdate()
    {
        // Setup mock response
        $responseBody = [
            'id'    => 1,
            'name'  => 'Zone Group',
            'zones' => [
                [   
                    'id'                => 1,
                    'publisher_id'      => 1,
                    'type'              => 'banner',
                    'name'              => 'Zone 1',
                    'is_dynamic_size'   => false,
                    'width'             => 100,
                    'height'            => 100,
                    'created_at'        => '2017-10-03T06:17:44Z',
                    'updated_at'        => '2017-10-03T06:17:44Z',
                ],
                [
                    'id'                => 2,
                    'publisher_id'      => 1,
                    'type'              => 'banner',
                    'name'              => 'Zone 2',
                    'is_dynamic_size'   => true,
                    'created_at'        => '2017-10-10T06:17:44Z',
                    'updated_at'        => '2017-10-10T06:17:44Z',
                ]
            ],
            'created_at' => '2017-10-02T06:17:44Z',
            'updated_at' => '2017-10-02T06:17:44Z',
        ];

        $responseBody2 = [
            'id'    => 1,
            'name'  => 'Updated Name',
            'zones' => [
                [
                    'id'                => 1,
                    'publisher_id'      => 1,
                    'type'              => 'banner',
                    'name'              => 'Zone 1',
                    'is_dynamic_size'   => false,
                    'width'             => 100,
                    'height'            => 100,
                    'created_at'        => '2017-10-03T06:17:44Z',
                    'updated_at'        => '2017-10-03T06:17:44Z',
                ]
            ],
            'created_at' => '2017-10-02T06:17:44Z',
            'updated_at' => '2017-10-02T06:17:45Z',
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($responseBody), null),
            new Response(200, [], json_encode($responseBody2), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);        
        Adyo::setApiKey('keygoeshere');

        // Retrieve the zone group object to update
        $zoneGroup = ZoneGroup::retrieve(1);

        // Update
        $zoneGroup->name = 'Updated Name';
        $zoneGroup->zone_ids = [1];
        $zoneGroup->save();

        // Assert
        $this->assertInstanceOf(\Adyo\ZoneGroup::class, $zoneGroup);
        $this->assertSame($zoneGroup->id, 1);
        $this->assertSame($zoneGroup->name, 'Updated Name');
        $this->assertTrue(is_array($zoneGroup->zones));
        $this->assertSame(count($zoneGroup->zones), 1);
        
        $this->assertInstanceOf(\Adyo\Zone::class, $zoneGroup->zones[0]);
        $this->assertSame($zoneGroup->zones[0]->id, 1);
        $this->assertSame($zoneGroup->zones[0]->publisher_id, 1);
        $this->assertSame($zoneGroup->zones[0]->type, 'banner');
        $this->assertSame($zoneGroup->zones[0]->name, 'Zone 1');
        $this->assertSame($zoneGroup->zones[0]->is_dynamic_size, false);
        $this->assertSame($zoneGroup->zones[0]->width, 100);
        $this->assertSame($zoneGroup->zones[0]->height, 100);
        $this->assertSame($zoneGroup->zones[0]->created_at, '2017-10-03T06:17:44Z');
        $this->assertSame($zoneGroup->zones[0]->updated_at, '2017-10-03T06:17:44Z');

        $this->assertSame($zoneGroup->created_at, '2017-10-02T06:17:44Z');
        $this->assertSame($zoneGroup->updated_at, '2017-10-02T06:17:45Z');
    }

    /**
      * Test deleting a zone group
      *
      * @return void
      */
    public function testDelete()
    {
        // Setup mock response
        $responseBody = [
            'id'    => 1,
            'name'  => 'Zone Group',
            'zones' => [
                [
                    'id'                => 1,
                    'publisher_id'      => 1,
                    'type'              => 'banner',
                    'name'              => 'Zone 1',
                    'is_dynamic_size'   => false,
                    'width'             => 100,
                    'height'            => 100,
                    'created_at'        => '2017-10-03T06:17:44Z',
                    'updated_at'        => '2017-10-03T06:17:44Z',
                ],
                [
                    'id'                => 2,
                    'publisher_id'      => 1,
                    'type'              => 'banner',
                    'name'              => 'Zone 2',
                    'is_dynamic_size'   => true,
                    'created_at'        => '2017-10-10T06:17:44Z',
                    'updated_at'        => '2017-10-10T06:17:44Z',
                ]
            ],
            'created_at' => '2017-10-02T06:17:44Z',
            'updated_at' => '2017-10-02T06:17:44Z',
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

        // Retrieve the zone group to delete
        $zoneGroup = ZoneGroup::retrieve(1);

        // Delete
        $zoneGroup->delete();

        // Assert
        $this->assertInstanceOf(\Adyo\ZoneGroup::class, $zoneGroup);
        $this->assertSame($zoneGroup->id, 1);
        $this->assertTrue($zoneGroup->isDeleted);
        $this->assertFalse(property_exists($zoneGroup, 'name'));
        $this->assertFalse(property_exists($zoneGroup, 'zones'));
    }

    /**
      * Test attaching zones to a zone group
      *
      * @return void
      */
    public function testAttachZones()
    {
        // Setup mock response
        $responseBody = [
            'id'    => 1,
            'name'  => 'Zone Group',
            'zones' => [
                [   
                    'id'                => 1,
                    'publisher_id'      => 1,
                    'type'              => 'banner',
                    'name'              => 'Zone 1',
                    'is_dynamic_size'   => false,
                    'width'             => 100,
                    'height'            => 100,
                    'created_at'        => '2017-10-03T06:17:44Z',
                    'updated_at'        => '2017-10-03T06:17:44Z',
                ]
            ],
            'created_at' => '2017-10-02T06:17:44Z',
            'updated_at' => '2017-10-02T06:17:44Z',
        ];

        $responseBody2 = [
            'id'    => 1,
            'name'  => 'Zone Group',
            'zones' => [
                [   
                    'id'                => 1,
                    'publisher_id'      => 1,
                    'type'              => 'banner',
                    'name'              => 'Zone 1',
                    'is_dynamic_size'   => false,
                    'width'             => 100,
                    'height'            => 100,
                    'created_at'        => '2017-10-03T06:17:44Z',
                    'updated_at'        => '2017-10-03T06:17:44Z',
                ],
                [
                    'id'                => 2,
                    'publisher_id'      => 1,
                    'type'              => 'banner',
                    'name'              => 'Zone 2',
                    'is_dynamic_size'   => true,
                    'created_at'        => '2017-10-10T06:17:44Z',
                    'updated_at'        => '2017-10-10T06:17:44Z',
                ]
            ],
            'created_at' => '2017-10-02T06:17:44Z',
            'updated_at' => '2017-10-02T06:17:45Z',
        ];


        $mock = new MockHandler([
            new Response(200, [], json_encode($responseBody), null),
            new Response(200, [], json_encode($responseBody2), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);        
        Adyo::setApiKey('keygoeshere');

        // Retrieve the zone group object to update
        $zoneGroup = ZoneGroup::retrieve(1);

        // Attach
        $zoneGroup->attachZones([2]);

        // Assert
        $this->assertInstanceOf(\Adyo\ZoneGroup::class, $zoneGroup);
        $this->assertSame($zoneGroup->id, 1);
        $this->assertSame($zoneGroup->name, 'Zone Group');
        $this->assertTrue(is_array($zoneGroup->zones));
        $this->assertSame(count($zoneGroup->zones), 2);
        
        // Zone 1
        $this->assertInstanceOf(\Adyo\Zone::class, $zoneGroup->zones[0]);
        $this->assertSame($zoneGroup->zones[0]->id, 1);
        $this->assertSame($zoneGroup->zones[0]->publisher_id, 1);
        $this->assertSame($zoneGroup->zones[0]->type, 'banner');
        $this->assertSame($zoneGroup->zones[0]->name, 'Zone 1');
        $this->assertSame($zoneGroup->zones[0]->is_dynamic_size, false);
        $this->assertSame($zoneGroup->zones[0]->width, 100);
        $this->assertSame($zoneGroup->zones[0]->height, 100);
        $this->assertSame($zoneGroup->zones[0]->created_at, '2017-10-03T06:17:44Z');
        $this->assertSame($zoneGroup->zones[0]->updated_at, '2017-10-03T06:17:44Z');

        // Zone 2
        $this->assertInstanceOf(\Adyo\Zone::class, $zoneGroup->zones[1]);
        $this->assertSame($zoneGroup->zones[1]->id, 2);
        $this->assertSame($zoneGroup->zones[1]->publisher_id, 1);
        $this->assertSame($zoneGroup->zones[1]->type, 'banner');
        $this->assertSame($zoneGroup->zones[1]->name, 'Zone 2');
        $this->assertSame($zoneGroup->zones[1]->is_dynamic_size, true);
        $this->assertSame($zoneGroup->zones[1]->created_at, '2017-10-10T06:17:44Z');
        $this->assertSame($zoneGroup->zones[1]->updated_at, '2017-10-10T06:17:44Z');

        $this->assertSame($zoneGroup->created_at, '2017-10-02T06:17:44Z');
        $this->assertSame($zoneGroup->updated_at, '2017-10-02T06:17:45Z');
    }

    /**
      * Test detaching zones from a zone group
      *
      * @return void
      */
    public function testDetachZones()
    {
        // Setup mock response
        $responseBody = [
            'id'    => 1,
            'name'  => 'Zone Group',
            'zones' => [
                [   
                    'id'                => 1,
                    'publisher_id'      => 1,
                    'type'              => 'banner',
                    'name'              => 'Zone 1',
                    'is_dynamic_size'   => false,
                    'width'             => 100,
                    'height'            => 100,
                    'created_at'        => '2017-10-03T06:17:44Z',
                    'updated_at'        => '2017-10-03T06:17:44Z',
                ],
                [
                    'id'                => 2,
                    'publisher_id'      => 1,
                    'type'              => 'banner',
                    'name'              => 'Zone 2',
                    'is_dynamic_size'   => true,
                    'created_at'        => '2017-10-10T06:17:44Z',
                    'updated_at'        => '2017-10-10T06:17:44Z',
                ]
            ],
            'created_at' => '2017-10-02T06:17:44Z',
            'updated_at' => '2017-10-02T06:17:44Z',
        ];

        $responseBody2 = [
            'id'    => 1,
            'name'  => 'Zone Group',
            'zones' => [
                [   
                    'id'                => 1,
                    'publisher_id'      => 1,
                    'type'              => 'banner',
                    'name'              => 'Zone 1',
                    'is_dynamic_size'   => false,
                    'width'             => 100,
                    'height'            => 100,
                    'created_at'        => '2017-10-03T06:17:44Z',
                    'updated_at'        => '2017-10-03T06:17:44Z',
                ]
            ],
            'created_at' => '2017-10-02T06:17:44Z',
            'updated_at' => '2017-10-02T06:17:45Z',
        ];


        $mock = new MockHandler([
            new Response(200, [], json_encode($responseBody), null),
            new Response(200, [], json_encode($responseBody2), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);        
        Adyo::setApiKey('keygoeshere');

        // Retrieve the zone group object to update
        $zoneGroup = ZoneGroup::retrieve(1);

        // Attach
        $zoneGroup->detachZones([2]);

        // Assert
        $this->assertInstanceOf(\Adyo\ZoneGroup::class, $zoneGroup);
        $this->assertSame($zoneGroup->id, 1);
        $this->assertSame($zoneGroup->name, 'Zone Group');
        $this->assertTrue(is_array($zoneGroup->zones));
        $this->assertSame(count($zoneGroup->zones), 1);
        
        // Zone 1
        $this->assertInstanceOf(\Adyo\Zone::class, $zoneGroup->zones[0]);
        $this->assertSame($zoneGroup->zones[0]->id, 1);
        $this->assertSame($zoneGroup->zones[0]->publisher_id, 1);
        $this->assertSame($zoneGroup->zones[0]->type, 'banner');
        $this->assertSame($zoneGroup->zones[0]->name, 'Zone 1');
        $this->assertSame($zoneGroup->zones[0]->is_dynamic_size, false);
        $this->assertSame($zoneGroup->zones[0]->width, 100);
        $this->assertSame($zoneGroup->zones[0]->height, 100);
        $this->assertSame($zoneGroup->zones[0]->created_at, '2017-10-03T06:17:44Z');
        $this->assertSame($zoneGroup->zones[0]->updated_at, '2017-10-03T06:17:44Z');

        $this->assertSame($zoneGroup->created_at, '2017-10-02T06:17:44Z');
        $this->assertSame($zoneGroup->updated_at, '2017-10-02T06:17:45Z');
    }
}