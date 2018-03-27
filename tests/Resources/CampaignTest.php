<?php

namespace Adyo;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

use Adyo\Adyo;
use Adyo\Client as AdyoClient;

class CampaignTest extends TestCase {

    /**
      * Test creating a campaign
      *
      * @return void
      */
    public function testCreate()
    {   
        // Setup mock response
        $responseBody = [
            'id'                            => 1,
            'advertiser_id'                 => 1,
            'name'                          => 'The Campaign',
            'lifetime_impressions'          => 1, 
            'monthly_impressions'           => 1, 
            'daily_impressions'             => 1, 
            'hourly_impressions'            => 1, 
            'unique_lifetime_impressions'   => 1, 
            'unique_monthly_impressions'    => 1, 
            'unique_daily_impressions'      => 1, 
            'unique_hourly_impressions'     => 1, 
            'lifetime_clicks'               => 1, 
            'monthly_clicks'                => 1, 
            'daily_clicks'                  => 1, 
            'hourly_clicks'                 => 1, 
            'unique_lifetime_clicks'        => 1, 
            'unique_monthly_clicks'         => 1, 
            'unique_daily_clicks'           => 1, 
            'unique_hourly_clicks'          => 1,  
            'lifetime_ctr'                  => 100, 
            'monthly_ctr'                   => 100, 
            'daily_ctr'                     => 100, 
            'hourly_ctr'                    => 100, 
            'unique_lifetime_ctr'           => 100, 
            'unique_monthly_ctr'            => 100, 
            'unique_daily_ctr'              => 100, 
            'unique_hourly_ctr'             => 100,
            'created_at'                    => '2017-10-04T12:57:18Z',
            'updated_at'                    => '2017-10-04T12:57:18Z'
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($responseBody), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);        
        Adyo::setApiKey('keygoeshere');

        // Create the campaign object
        $campaign = Campaign::create(['advertiser_id' => 1, 'name' => 'The campaign']);

        // Assert
        $this->assertInstanceOf(\Adyo\Campaign::class, $campaign);
        $this->assertSame($campaign->id, 1);
        $this->assertSame($campaign->advertiser_id, 1);
        $this->assertSame($campaign->name, 'The Campaign');
        $this->assertSame($campaign->lifetime_impressions, 1); 
        $this->assertSame($campaign->monthly_impressions, 1); 
        $this->assertSame($campaign->daily_impressions, 1); 
        $this->assertSame($campaign->hourly_impressions, 1); 
        $this->assertSame($campaign->unique_lifetime_impressions, 1); 
        $this->assertSame($campaign->unique_monthly_impressions, 1); 
        $this->assertSame($campaign->unique_daily_impressions, 1); 
        $this->assertSame($campaign->unique_hourly_impressions, 1); 
        $this->assertSame($campaign->lifetime_clicks, 1); 
        $this->assertSame($campaign->monthly_clicks, 1); 
        $this->assertSame($campaign->daily_clicks, 1); 
        $this->assertSame($campaign->hourly_clicks, 1); 
        $this->assertSame($campaign->unique_lifetime_clicks, 1); 
        $this->assertSame($campaign->unique_monthly_clicks, 1); 
        $this->assertSame($campaign->unique_daily_clicks, 1); 
        $this->assertSame($campaign->unique_hourly_clicks, 1); 
        $this->assertSame($campaign->lifetime_ctr, 100); 
        $this->assertSame($campaign->monthly_ctr, 100); 
        $this->assertSame($campaign->daily_ctr, 100); 
        $this->assertSame($campaign->hourly_ctr, 100); 
        $this->assertSame($campaign->unique_lifetime_ctr, 100); 
        $this->assertSame($campaign->unique_monthly_ctr, 100); 
        $this->assertSame($campaign->unique_daily_ctr, 100); 
        $this->assertSame($campaign->unique_hourly_ctr, 100);
        $this->assertSame($campaign->created_at, '2017-10-04T12:57:18Z');
        $this->assertSame($campaign->updated_at, '2017-10-04T12:57:18Z');
    }

    /**
      * Test the retrieval of a campaign
      *
      * @return void
      */
    public function testRetrieve()
    {   
        // Setup mock response
        $responseBody = [
            'id'                            => 1,
            'advertiser_id'                 => 1,
            'name'                          => 'The Campaign',
            'lifetime_impressions'          => 1, 
            'monthly_impressions'           => 1, 
            'daily_impressions'             => 1, 
            'hourly_impressions'            => 1, 
            'unique_lifetime_impressions'   => 1, 
            'unique_monthly_impressions'    => 1, 
            'unique_daily_impressions'      => 1, 
            'unique_hourly_impressions'     => 1, 
            'lifetime_clicks'               => 1, 
            'monthly_clicks'                => 1, 
            'daily_clicks'                  => 1, 
            'hourly_clicks'                 => 1, 
            'unique_lifetime_clicks'        => 1, 
            'unique_monthly_clicks'         => 1, 
            'unique_daily_clicks'           => 1, 
            'unique_hourly_clicks'          => 1,  
            'lifetime_ctr'                  => 100, 
            'monthly_ctr'                   => 100, 
            'daily_ctr'                     => 100, 
            'hourly_ctr'                    => 100, 
            'unique_lifetime_ctr'           => 100, 
            'unique_monthly_ctr'            => 100, 
            'unique_daily_ctr'              => 100, 
            'unique_hourly_ctr'             => 100,
            'created_at'                    => '2017-10-04T12:57:18Z',
            'updated_at'                    => '2017-10-04T12:57:18Z'
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($responseBody), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);        
        Adyo::setApiKey('keygoeshere');

        // Retrieve the campaign object
        $campaign = Campaign::retrieve(1);

        // Assert
        $this->assertInstanceOf(\Adyo\Campaign::class, $campaign);
        $this->assertSame($campaign->id, 1);
        $this->assertSame($campaign->advertiser_id, 1);
        $this->assertSame($campaign->name, 'The Campaign');
        $this->assertSame($campaign->lifetime_impressions, 1); 
        $this->assertSame($campaign->monthly_impressions, 1); 
        $this->assertSame($campaign->daily_impressions, 1); 
        $this->assertSame($campaign->hourly_impressions, 1); 
        $this->assertSame($campaign->unique_lifetime_impressions, 1); 
        $this->assertSame($campaign->unique_monthly_impressions, 1); 
        $this->assertSame($campaign->unique_daily_impressions, 1); 
        $this->assertSame($campaign->unique_hourly_impressions, 1); 
        $this->assertSame($campaign->lifetime_clicks, 1); 
        $this->assertSame($campaign->monthly_clicks, 1); 
        $this->assertSame($campaign->daily_clicks, 1); 
        $this->assertSame($campaign->hourly_clicks, 1); 
        $this->assertSame($campaign->unique_lifetime_clicks, 1); 
        $this->assertSame($campaign->unique_monthly_clicks, 1); 
        $this->assertSame($campaign->unique_daily_clicks, 1); 
        $this->assertSame($campaign->unique_hourly_clicks, 1); 
        $this->assertSame($campaign->lifetime_ctr, 100); 
        $this->assertSame($campaign->monthly_ctr, 100); 
        $this->assertSame($campaign->daily_ctr, 100); 
        $this->assertSame($campaign->hourly_ctr, 100); 
        $this->assertSame($campaign->unique_lifetime_ctr, 100); 
        $this->assertSame($campaign->unique_monthly_ctr, 100); 
        $this->assertSame($campaign->unique_daily_ctr, 100); 
        $this->assertSame($campaign->unique_hourly_ctr, 100);
        $this->assertSame($campaign->created_at, '2017-10-04T12:57:18Z');
        $this->assertSame($campaign->updated_at, '2017-10-04T12:57:18Z');
    }

    /**
      * Test the retrieval of multiple campaigns
      *
      * @return void
      */
    public function testRetrieveAll()
    {   
        // Setup mock response
        $responseBody = [
            'data' => [
                [
                    'id'                            => 1,
                    'advertiser_id'                 => 1,
                    'name'                          => 'The Campaign',
                    'lifetime_impressions'          => 1, 
                    'monthly_impressions'           => 1, 
                    'daily_impressions'             => 1, 
                    'hourly_impressions'            => 1, 
                    'unique_lifetime_impressions'   => 1, 
                    'unique_monthly_impressions'    => 1, 
                    'unique_daily_impressions'      => 1, 
                    'unique_hourly_impressions'     => 1, 
                    'lifetime_clicks'               => 1, 
                    'monthly_clicks'                => 1, 
                    'daily_clicks'                  => 1, 
                    'hourly_clicks'                 => 1, 
                    'unique_lifetime_clicks'        => 1, 
                    'unique_monthly_clicks'         => 1, 
                    'unique_daily_clicks'           => 1, 
                    'unique_hourly_clicks'          => 1,  
                    'lifetime_ctr'                  => 100, 
                    'monthly_ctr'                   => 100, 
                    'daily_ctr'                     => 100, 
                    'hourly_ctr'                    => 100, 
                    'unique_lifetime_ctr'           => 100, 
                    'unique_monthly_ctr'            => 100, 
                    'unique_daily_ctr'              => 100, 
                    'unique_hourly_ctr'             => 100,
                    'created_at'                    => '2017-10-04T12:57:18Z',
                    'updated_at'                    => '2017-10-04T12:57:18Z'
                ],
                [
                    'id'                            => 2,
                    'advertiser_id'                 => 1,
                    'lifetime_impressions'          => 1, 
                    'monthly_impressions'           => 1, 
                    'daily_impressions'             => 1, 
                    'hourly_impressions'            => 1, 
                    'unique_lifetime_impressions'   => 1, 
                    'unique_monthly_impressions'    => 1, 
                    'unique_daily_impressions'      => 1, 
                    'unique_hourly_impressions'     => 1, 
                    'lifetime_clicks'               => 1, 
                    'monthly_clicks'                => 1, 
                    'daily_clicks'                  => 1, 
                    'hourly_clicks'                 => 1, 
                    'unique_lifetime_clicks'        => 1, 
                    'unique_monthly_clicks'         => 1, 
                    'unique_daily_clicks'           => 1, 
                    'unique_hourly_clicks'          => 1,  
                    'lifetime_ctr'                  => 100, 
                    'monthly_ctr'                   => 100, 
                    'daily_ctr'                     => 100, 
                    'hourly_ctr'                    => 100, 
                    'unique_lifetime_ctr'           => 100, 
                    'unique_monthly_ctr'            => 100, 
                    'unique_daily_ctr'              => 100, 
                    'unique_hourly_ctr'             => 100,
                    'name'                          => 'The Campaign 2',
                    'created_at'                    => '2017-10-04T12:57:18Z',
                    'updated_at'                    => '2017-10-04T12:57:18Z'
                ]
            ],
            'pagination' => [
                'total'         => 13,
                'count'         => 2,
                'per_page'      => 2,
                'current_page'  => 1,
                'total_pages'   => 7,
                'links' => [
                    'next' => 'http:\/\/api.adyo.co.za\/v1\/campaigns?page=2'
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

        // Retrieve the campaign objects
        $list = Campaign::retrieveAll([
            'page'      => 1,
            'perPage'   => 2,
            'sort'      => 'name,-updated_at',
            'ids'       => '1,2',
        ]);

        // // Assert
        $this->assertInstanceOf(\Adyo\AdyoList::class, $list);
        $this->assertSame(count($list->objects), 2);
        $this->assertSame($list->total, 13);
        $this->assertSame($list->count, 2);
        $this->assertSame($list->per_page, 2);
        $this->assertSame($list->current_page, 1);
        $this->assertSame($list->total_pages, 7);
        $this->assertSame($list->next_url, 'http:\/\/api.adyo.co.za\/v1\/campaigns?page=2');
        $this->assertNull($list->prev_url);

        $this->assertInstanceOf(\Adyo\Campaign::class, $list->objects[0]);
        $this->assertSame($list->objects[0]->id, 1);
        $this->assertSame($list->objects[0]->advertiser_id, 1);
        $this->assertSame($list->objects[0]->name, 'The Campaign');
        $this->assertSame($list->objects[0]->lifetime_impressions, 1); 
        $this->assertSame($list->objects[0]->monthly_impressions, 1); 
        $this->assertSame($list->objects[0]->daily_impressions, 1); 
        $this->assertSame($list->objects[0]->hourly_impressions, 1); 
        $this->assertSame($list->objects[0]->unique_lifetime_impressions, 1); 
        $this->assertSame($list->objects[0]->unique_monthly_impressions, 1); 
        $this->assertSame($list->objects[0]->unique_daily_impressions, 1); 
        $this->assertSame($list->objects[0]->unique_hourly_impressions, 1); 
        $this->assertSame($list->objects[0]->lifetime_clicks, 1); 
        $this->assertSame($list->objects[0]->monthly_clicks, 1); 
        $this->assertSame($list->objects[0]->daily_clicks, 1); 
        $this->assertSame($list->objects[0]->hourly_clicks, 1); 
        $this->assertSame($list->objects[0]->unique_lifetime_clicks, 1); 
        $this->assertSame($list->objects[0]->unique_monthly_clicks, 1); 
        $this->assertSame($list->objects[0]->unique_daily_clicks, 1); 
        $this->assertSame($list->objects[0]->unique_hourly_clicks, 1); 
        $this->assertSame($list->objects[0]->lifetime_ctr, 100); 
        $this->assertSame($list->objects[0]->monthly_ctr, 100); 
        $this->assertSame($list->objects[0]->daily_ctr, 100); 
        $this->assertSame($list->objects[0]->hourly_ctr, 100); 
        $this->assertSame($list->objects[0]->unique_lifetime_ctr, 100); 
        $this->assertSame($list->objects[0]->unique_monthly_ctr, 100); 
        $this->assertSame($list->objects[0]->unique_daily_ctr, 100); 
        $this->assertSame($list->objects[0]->unique_hourly_ctr, 100);
        $this->assertSame($list->objects[0]->created_at, '2017-10-04T12:57:18Z');
        $this->assertSame($list->objects[0]->updated_at, '2017-10-04T12:57:18Z');

        $this->assertInstanceOf(\Adyo\Campaign::class, $list->objects[1]);
        $this->assertSame($list->objects[1]->id, 2);
        $this->assertSame($list->objects[0]->advertiser_id, 1);
        $this->assertSame($list->objects[1]->name, 'The Campaign 2');
        $this->assertSame($list->objects[1]->lifetime_impressions, 1); 
        $this->assertSame($list->objects[1]->monthly_impressions, 1); 
        $this->assertSame($list->objects[1]->daily_impressions, 1); 
        $this->assertSame($list->objects[1]->hourly_impressions, 1); 
        $this->assertSame($list->objects[1]->unique_lifetime_impressions, 1); 
        $this->assertSame($list->objects[1]->unique_monthly_impressions, 1); 
        $this->assertSame($list->objects[1]->unique_daily_impressions, 1); 
        $this->assertSame($list->objects[1]->unique_hourly_impressions, 1); 
        $this->assertSame($list->objects[1]->lifetime_clicks, 1); 
        $this->assertSame($list->objects[1]->monthly_clicks, 1); 
        $this->assertSame($list->objects[1]->daily_clicks, 1); 
        $this->assertSame($list->objects[1]->hourly_clicks, 1); 
        $this->assertSame($list->objects[1]->unique_lifetime_clicks, 1); 
        $this->assertSame($list->objects[1]->unique_monthly_clicks, 1); 
        $this->assertSame($list->objects[1]->unique_daily_clicks, 1); 
        $this->assertSame($list->objects[1]->unique_hourly_clicks, 1); 
        $this->assertSame($list->objects[1]->lifetime_ctr, 100); 
        $this->assertSame($list->objects[1]->monthly_ctr, 100); 
        $this->assertSame($list->objects[1]->daily_ctr, 100); 
        $this->assertSame($list->objects[1]->hourly_ctr, 100); 
        $this->assertSame($list->objects[1]->unique_lifetime_ctr, 100); 
        $this->assertSame($list->objects[1]->unique_monthly_ctr, 100); 
        $this->assertSame($list->objects[1]->unique_daily_ctr, 100); 
        $this->assertSame($list->objects[1]->unique_hourly_ctr, 100);
        $this->assertSame($list->objects[1]->created_at, '2017-10-04T12:57:18Z');
        $this->assertSame($list->objects[1]->updated_at, '2017-10-04T12:57:18Z');
    }

    /**
      * Test updating a campaign
      *
      * @return void
      */
    public function testUpdate()
    {
        // Setup mock responses
        $responseBody = [
            'id'                            => 1,
            'advertiser_id'                 => 1,
            'name'                          => 'Campaign Name',
            'lifetime_impressions'          => 1, 
            'monthly_impressions'           => 1, 
            'daily_impressions'             => 1, 
            'hourly_impressions'            => 1, 
            'unique_lifetime_impressions'   => 1, 
            'unique_monthly_impressions'    => 1, 
            'unique_daily_impressions'      => 1, 
            'unique_hourly_impressions'     => 1, 
            'lifetime_clicks'               => 1, 
            'monthly_clicks'                => 1, 
            'daily_clicks'                  => 1, 
            'hourly_clicks'                 => 1, 
            'unique_lifetime_clicks'        => 1, 
            'unique_monthly_clicks'         => 1, 
            'unique_daily_clicks'           => 1, 
            'unique_hourly_clicks'          => 1,  
            'lifetime_ctr'                  => 100, 
            'monthly_ctr'                   => 100, 
            'daily_ctr'                     => 100, 
            'hourly_ctr'                    => 100, 
            'unique_lifetime_ctr'           => 100, 
            'unique_monthly_ctr'            => 100, 
            'unique_daily_ctr'              => 100, 
            'unique_hourly_ctr'             => 100,
            'created_at'                    => '2017-10-04T12:57:18Z',
            'updated_at'                    => '2017-10-04T12:57:18Z'
        ];

        $responseBody2 = [
            'id'                            => 1,
            'advertiser_id'                 => 1,
            'name'                          => 'Updated Name',
            'lifetime_impressions'          => 1, 
            'monthly_impressions'           => 1, 
            'daily_impressions'             => 1, 
            'hourly_impressions'            => 1, 
            'unique_lifetime_impressions'   => 1, 
            'unique_monthly_impressions'    => 1, 
            'unique_daily_impressions'      => 1, 
            'unique_hourly_impressions'     => 1, 
            'lifetime_clicks'               => 1, 
            'monthly_clicks'                => 1, 
            'daily_clicks'                  => 1, 
            'hourly_clicks'                 => 1, 
            'unique_lifetime_clicks'        => 1, 
            'unique_monthly_clicks'         => 1, 
            'unique_daily_clicks'           => 1, 
            'unique_hourly_clicks'          => 1,  
            'lifetime_ctr'                  => 100, 
            'monthly_ctr'                   => 100, 
            'daily_ctr'                     => 100, 
            'hourly_ctr'                    => 100, 
            'unique_lifetime_ctr'           => 100, 
            'unique_monthly_ctr'            => 100, 
            'unique_daily_ctr'              => 100, 
            'unique_hourly_ctr'             => 100,
            'created_at'                    => '2017-10-04T12:58:18Z',
            'updated_at'                    => '2017-10-04T12:58:18Z'
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($responseBody), null),
            new Response(200, [], json_encode($responseBody2), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);        
        Adyo::setApiKey('keygoeshere');

        // Retreive a campaign object to update
        $campaign = Campaign::retrieve(1);

        // Update
        $campaign->name = 'Updated Name';
        $campaign->save();

        // Assert
        $this->assertInstanceOf(\Adyo\Campaign::class, $campaign);
        $this->assertSame($campaign->id, 1);
        $this->assertSame($campaign->advertiser_id, 1);
        $this->assertSame($campaign->name, 'Updated Name');
        $this->assertSame($campaign->lifetime_impressions, 1); 
        $this->assertSame($campaign->monthly_impressions, 1); 
        $this->assertSame($campaign->daily_impressions, 1); 
        $this->assertSame($campaign->hourly_impressions, 1); 
        $this->assertSame($campaign->unique_lifetime_impressions, 1); 
        $this->assertSame($campaign->unique_monthly_impressions, 1); 
        $this->assertSame($campaign->unique_daily_impressions, 1); 
        $this->assertSame($campaign->unique_hourly_impressions, 1); 
        $this->assertSame($campaign->lifetime_clicks, 1); 
        $this->assertSame($campaign->monthly_clicks, 1); 
        $this->assertSame($campaign->daily_clicks, 1); 
        $this->assertSame($campaign->hourly_clicks, 1); 
        $this->assertSame($campaign->unique_lifetime_clicks, 1); 
        $this->assertSame($campaign->unique_monthly_clicks, 1); 
        $this->assertSame($campaign->unique_daily_clicks, 1); 
        $this->assertSame($campaign->unique_hourly_clicks, 1); 
        $this->assertSame($campaign->lifetime_ctr, 100); 
        $this->assertSame($campaign->monthly_ctr, 100); 
        $this->assertSame($campaign->daily_ctr, 100); 
        $this->assertSame($campaign->hourly_ctr, 100); 
        $this->assertSame($campaign->unique_lifetime_ctr, 100); 
        $this->assertSame($campaign->unique_monthly_ctr, 100); 
        $this->assertSame($campaign->unique_daily_ctr, 100); 
        $this->assertSame($campaign->unique_hourly_ctr, 100);
        $this->assertSame($campaign->created_at, '2017-10-04T12:58:18Z');
        $this->assertSame($campaign->updated_at, '2017-10-04T12:58:18Z');
    }

    /**
      * Test deleting a campaign
      *
      * @return void
      */
    public function testDelete()
    {
        // Setup mock responses
        $responseBody = [
            'id'                            => 1,
            'advertiser_id'                 => 1,
            'name'                          => 'Campaign Name',
            'lifetime_impressions'          => 1, 
            'monthly_impressions'           => 1, 
            'daily_impressions'             => 1, 
            'hourly_impressions'            => 1, 
            'unique_lifetime_impressions'   => 1, 
            'unique_monthly_impressions'    => 1, 
            'unique_daily_impressions'      => 1, 
            'unique_hourly_impressions'     => 1, 
            'lifetime_clicks'               => 1, 
            'monthly_clicks'                => 1, 
            'daily_clicks'                  => 1, 
            'hourly_clicks'                 => 1, 
            'unique_lifetime_clicks'        => 1, 
            'unique_monthly_clicks'         => 1, 
            'unique_daily_clicks'           => 1, 
            'unique_hourly_clicks'          => 1,  
            'lifetime_ctr'                  => 100, 
            'monthly_ctr'                   => 100, 
            'daily_ctr'                     => 100, 
            'hourly_ctr'                    => 100, 
            'unique_lifetime_ctr'           => 100, 
            'unique_monthly_ctr'            => 100, 
            'unique_daily_ctr'              => 100, 
            'unique_hourly_ctr'             => 100,
            'created_at'                    => '2017-10-04T12:57:18Z',
            'updated_at'                    => '2017-10-04T12:57:18Z'
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

        // Retrieve the campaign to delete
        $campaign = Campaign::retrieve(1);

        // Delete
        $campaign->delete();

        // Assert
        $this->assertInstanceOf(\Adyo\Campaign::class, $campaign);
        $this->assertSame($campaign->id, 1);
        $this->assertTrue($campaign->isDeleted);
        $this->assertFalse(property_exists($campaign, 'advertiser_id'));
        $this->assertFalse(property_exists($campaign, 'name'));
        $this->assertFalse(property_exists($campaign, 'lifetime_impressions')); 
        $this->assertFalse(property_exists($campaign, 'monthly_impressions')); 
        $this->assertFalse(property_exists($campaign, 'daily_impressions')); 
        $this->assertFalse(property_exists($campaign, 'hourly_impressions')); 
        $this->assertFalse(property_exists($campaign, 'unique_lifetime_impressions')); 
        $this->assertFalse(property_exists($campaign, 'unique_monthly_impressions')); 
        $this->assertFalse(property_exists($campaign, 'unique_daily_impressions')); 
        $this->assertFalse(property_exists($campaign, 'unique_hourly_impressions')); 
        $this->assertFalse(property_exists($campaign, 'lifetime_clicks')); 
        $this->assertFalse(property_exists($campaign, 'monthly_clicks')); 
        $this->assertFalse(property_exists($campaign, 'daily_clicks')); 
        $this->assertFalse(property_exists($campaign, 'hourly_clicks')); 
        $this->assertFalse(property_exists($campaign, 'unique_lifetime_clicks')); 
        $this->assertFalse(property_exists($campaign, 'unique_monthly_clicks')); 
        $this->assertFalse(property_exists($campaign, 'unique_daily_clicks')); 
        $this->assertFalse(property_exists($campaign, 'unique_hourly_clicks')); 
        $this->assertFalse(property_exists($campaign, 'lifetime_ctr')); 
        $this->assertFalse(property_exists($campaign, 'monthly_ctr')); 
        $this->assertFalse(property_exists($campaign, 'daily_ctr')); 
        $this->assertFalse(property_exists($campaign, 'hourly_ctr')); 
        $this->assertFalse(property_exists($campaign, 'unique_lifetime_ctr')); 
        $this->assertFalse(property_exists($campaign, 'unique_monthly_ctr')); 
        $this->assertFalse(property_exists($campaign, 'unique_daily_ctr')); 
        $this->assertFalse(property_exists($campaign, 'unique_hourly_ctr'));
        $this->assertFalse(property_exists($campaign, 'created_at'));
        $this->assertFalse(property_exists($campaign, 'updated_at'));
    }
}