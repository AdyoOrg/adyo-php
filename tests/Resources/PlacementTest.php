<?php

namespace Adyo;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

use Adyo\Adyo;
use Adyo\Client as AdyoClient;

class PlacementTest extends TestCase {

    /**
      * Test creating a placement
      *
      * @return void
      */
    public function testCreate()
    {   
        // Setup mock response
        $responseBody = [
            'id'                        => 1,
            'campaign_id'               => 1,
            'priority_id'               => 1,
            'creative_ids'              => [1],
            'name'                      => 'The Placement',
            'enabled'                   => true,
            'html_target'               => '_blank',
            'app_target'                => 'default',
            'delivery_method'           => 'default',
            'lifetime_dates_enabled'    => true,
            'lifetime_start'            => '2017-10-02T12:04:34Z',
            'lifetime_end'              => '2017-10-02T14:51:14Z',
            'lifetime_quota_enabled'    => true,
            'lifetime_quota_amount'     => 32,
            'lifetime_quota_type'       => 'views',
            'under_delivery_behaviour'  => 'endOnDate',
            'pricing_enabled'           => true,
            'pricing_method'            => 'rate',
            'rate_cpm'                  => 1.25,
            'rate_cpc'                  => 2.22,
            'rate_cpa'                  => 3.33,
            'fixed_cost'                => null,
            'publisher_payout_ratio'    => null,
            'per_user_limit_enabled'    => true,
            'per_user_limit_amount'     => 2000,
            'per_user_limit_type'       => 'views',
            'per_user_limit_period'     => 'hour',
            'frequency_limit_enabled'   => true,
            'frequency_limit_amount'    => 30000,
            'frequency_limit_type'      => 'views',
            'frequency_limit_period'    => 'day',
            'keywords'                  => 'audi,bmw,cars,-train',
            'keyword_match_method'      => 'preferred',
            'zone_ids'                  => [99],
            'zone_group_ids'            => [21],
            'zone_all_ids'              => [1, 99],
            'created_at'                => '2017-10-02T12:04:36Z',
            'updated_at'                => '2017-10-02T12:04:36Z'
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($responseBody), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);        
        Adyo::setApiKey('keygoeshere');

        // Create the placement object
        $placement = Placement::create([
            'campaign_id'               => 1,
            'priority_id'               => 1,
            'creative_ids'              => [1],
            'name'                      => 'The Placement',
            'enabled'                   => true,
            'html_target'               => '_blank',
            'app_target'                => 'default',
            'delivery_method'           => 'default',
            'lifetime_dates_enabled'    => true,
            'lifetime_start'            => '2017-10-02T12:04:34Z',
            'lifetime_end'              => '2017-10-02T14:51:14Z',
            'lifetime_quota_enabled'    => true,
            'lifetime_quota_amount'     => 32,
            'lifetime_quota_type'       => 'views',
            'under_delivery_behaviour'  => 'endOnDate',
            'pricing_enabled'           => true,
            'pricing_method'            => 'rate',
            'rate_cpm'                  => 1.25,
            'rate_cpc'                  => 2.22,
            'rate_cpa'                  => 3.33,
            'publisher_payout_ratio'    => null,
            'per_user_limit_enabled'    => true,
            'per_user_limit_amount'     => 2000,
            'per_user_limit_type'       => 'views',
            'per_user_limit_period'     => 'hour',
            'frequency_limit_enabled'   => true,
            'frequency_limit_amount'    => 30000,
            'frequency_limit_type'      => 'views',
            'frequency_limit_period'    => 'day',
            'keywords'                  => 'audi,bmw,cars,-train',
            'keyword_match_method'      => 'preferred',
            'zone_ids'                  => [99],
            'zone_group_ids'            => [21]
        ]);

        // Assert
        $this->assertInstanceOf(\Adyo\Placement::class, $placement);
        $this->assertSame($placement->id, 1);
        $this->assertSame($placement->campaign_id, 1);
        $this->assertSame($placement->priority_id, 1);
        $this->assertSame($placement->creative_ids[0], 1);
        $this->assertSame($placement->name, 'The Placement');
        $this->assertTrue($placement->enabled);
        $this->assertSame($placement->html_target, '_blank');
        $this->assertSame($placement->app_target, 'default');
        $this->assertSame($placement->delivery_method, 'default');
        $this->assertTrue($placement->lifetime_dates_enabled);
        $this->assertSame($placement->lifetime_start, '2017-10-02T12:04:34Z');
        $this->assertSame($placement->lifetime_end, '2017-10-02T14:51:14Z');
        $this->assertTrue($placement->lifetime_quota_enabled);
        $this->assertSame($placement->lifetime_quota_amount, 32);
        $this->assertSame($placement->lifetime_quota_type, 'views');
        $this->assertSame($placement->under_delivery_behaviour, 'endOnDate');
        $this->assertTrue($placement->pricing_enabled);
        $this->assertSame($placement->pricing_method, 'rate');
        $this->assertSame($placement->rate_cpm, 1.25);
        $this->assertSame($placement->rate_cpc, 2.22);
        $this->assertSame($placement->rate_cpa, 3.33);
        $this->assertNull($placement->publisher_payout_ratio);
        $this->assertTrue($placement->per_user_limit_enabled);
        $this->assertSame($placement->per_user_limit_amount, 2000);
        $this->assertSame($placement->per_user_limit_type, 'views');
        $this->assertSame($placement->per_user_limit_period, 'hour');
        $this->assertTrue($placement->frequency_limit_enabled);
        $this->assertSame($placement->frequency_limit_amount, 30000);
        $this->assertSame($placement->frequency_limit_type, 'views');
        $this->assertSame($placement->frequency_limit_period, 'day');
        $this->assertSame($placement->keywords, 'audi,bmw,cars,-train');
        $this->assertSame($placement->keyword_match_method, 'preferred');
        $this->assertTrue(is_array($placement->zone_ids));
        $this->assertSame(count($placement->zone_ids), 1);
        $this->assertSame($placement->zone_ids[0], 99);
        $this->assertTrue(is_array($placement->zone_group_ids));
        $this->assertSame(count($placement->zone_group_ids), 1);
        $this->assertSame($placement->zone_group_ids[0], 21);
        $this->assertTrue(is_array($placement->zone_all_ids));
        $this->assertSame(count($placement->zone_all_ids), 2);
        $this->assertSame($placement->zone_all_ids[0], 1);
        $this->assertSame($placement->zone_all_ids[1], 99);
        $this->assertSame($placement->created_at, '2017-10-02T12:04:36Z');
        $this->assertSame($placement->updated_at, '2017-10-02T12:04:36Z');
    }

    /**
      * Test the retrieval of a placement
      *
      * @return void
      */
    public function testRetrieve()
    {   
        // Setup mock response
        $responseBody = [
            'id'                        => 1,
            'campaign_id'               => 1,
            'priority_id'               => 1,
            'creative_ids'              => [1],
            'name'                      => 'The Placement',
            'enabled'                   => false,
            'html_target'               => '_blank',
            'app_target'                => 'default',
            'delivery_method'           => 'default',
            'lifetime_dates_enabled'    => true,
            'lifetime_start'            => '2017-10-02T12:04:34Z',
            'lifetime_end'              => '2017-10-02T14:51:14Z',
            'lifetime_quota_enabled'    => true,
            'lifetime_quota_amount'     => 32,
            'lifetime_quota_type'       => 'views',
            'under_delivery_behaviour'  => 'endOnDate',
            'pricing_enabled'           => true,
            'pricing_method'            => 'fixed',
            'rate_cpm'                  => null,
            'rate_cpc'                  => null,
            'rate_cpa'                  => null,
            'fixed_cost'                => 5000.50,
            'publisher_payout_ratio'    => null,
            'per_user_limit_enabled'    => true,
            'per_user_limit_amount'     => 2000,
            'per_user_limit_type'       => 'views',
            'per_user_limit_period'     => 'hour',
            'frequency_limit_enabled'   => true,
            'frequency_limit_amount'    => 30000,
            'frequency_limit_type'      => 'clicks',
            'frequency_limit_period'    => 'day',
            'keywords'                  => 'audi,bmw,cars,-train',
            'keyword_match_method'      => 'required',
            'zone_ids'                  => [99],
            'zone_group_ids'            => [21],
            'zone_all_ids'              => [1, 99],
            'created_at'                => '2017-10-02T12:04:36Z',
            'updated_at'                => '2017-10-02T12:04:36Z'
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($responseBody), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);        
        Adyo::setApiKey('keygoeshere');

        // Retrieve the placement object
        $placement = Placement::retrieve(1);

        // Assert
        $this->assertInstanceOf(\Adyo\Placement::class, $placement);
        $this->assertSame($placement->id, 1);
        $this->assertSame($placement->campaign_id, 1);
        $this->assertSame($placement->priority_id, 1);
        $this->assertSame($placement->creative_ids[0], 1);
        $this->assertSame($placement->name, 'The Placement');
        $this->assertFalse($placement->enabled);
        $this->assertSame($placement->html_target, '_blank');
        $this->assertSame($placement->app_target, 'default');
        $this->assertSame($placement->delivery_method, 'default');
        $this->assertTrue($placement->lifetime_dates_enabled);
        $this->assertSame($placement->lifetime_start, '2017-10-02T12:04:34Z');
        $this->assertSame($placement->lifetime_end, '2017-10-02T14:51:14Z');
        $this->assertTrue($placement->lifetime_quota_enabled);
        $this->assertSame($placement->lifetime_quota_amount, 32);
        $this->assertSame($placement->lifetime_quota_type, 'views');
        $this->assertSame($placement->under_delivery_behaviour, 'endOnDate');
        $this->assertTrue($placement->pricing_enabled);
        $this->assertSame($placement->pricing_method, 'fixed');
        $this->assertSame($placement->fixed_cost, 5000.50);
        $this->assertNull($placement->publisher_payout_ratio);
        $this->assertTrue($placement->per_user_limit_enabled);
        $this->assertSame($placement->per_user_limit_amount, 2000);
        $this->assertSame($placement->per_user_limit_type, 'views');
        $this->assertSame($placement->per_user_limit_period, 'hour');
        $this->assertTrue($placement->frequency_limit_enabled);
        $this->assertSame($placement->frequency_limit_amount, 30000);
        $this->assertSame($placement->frequency_limit_type, 'clicks');
        $this->assertSame($placement->frequency_limit_period, 'day');
        $this->assertSame($placement->keywords, 'audi,bmw,cars,-train');
        $this->assertSame($placement->keyword_match_method, 'required');
        $this->assertTrue(is_array($placement->zone_ids));
        $this->assertSame(count($placement->zone_ids), 1);
        $this->assertSame($placement->zone_ids[0], 99);
        $this->assertTrue(is_array($placement->zone_group_ids));
        $this->assertSame(count($placement->zone_group_ids), 1);
        $this->assertSame($placement->zone_group_ids[0], 21);
        $this->assertTrue(is_array($placement->zone_all_ids));
        $this->assertSame(count($placement->zone_all_ids), 2);
        $this->assertSame($placement->zone_all_ids[0], 1);
        $this->assertSame($placement->zone_all_ids[1], 99);
        $this->assertSame($placement->created_at, '2017-10-02T12:04:36Z');
        $this->assertSame($placement->updated_at, '2017-10-02T12:04:36Z');
    }

    /**
      * Test the retrieval of multiple placements
      *
      * @return void
      */
    public function testRetrieveAll()
    {   
        // Setup mock response
        $responseBody = [
            'data' => [
                [
                    'id'                        => 1,
                    'campaign_id'               => 1,
                    'priority_id'               => 1,
                    'creative_ids'              => [1],
                    'name'                      => 'The Placement',
                    'enabled'                   => true,
                    'html_target'               => '_blank',
                    'app_target'                => 'default',
                    'delivery_method'           => 'default',
                    'lifetime_dates_enabled'    => true,
                    'lifetime_start'            => '2017-10-02T12:04:34Z',
                    'lifetime_end'              => '2017-10-02T14:51:14Z',
                    'lifetime_quota_enabled'    => true,
                    'lifetime_quota_amount'     => 32,
                    'lifetime_quota_type'       => 'views',
                    'under_delivery_behaviour'  => 'endOnDate',
                    'pricing_enabled'           => true,
                    'pricing_method'            => 'rate',
                    'rate_cpm'                  => 1.25,
                    'rate_cpc'                  => 2.22,
                    'rate_cpa'                  => 3.33,
                    'fixed_cost'                => null,
                    'publisher_payout_ratio'    => null,
                    'per_user_limit_enabled'    => true,
                    'per_user_limit_amount'     => 2000,
                    'per_user_limit_type'       => 'views',
                    'per_user_limit_period'     => 'hour',
                    'frequency_limit_enabled'   => true,
                    'frequency_limit_amount'    => 30000,
                    'frequency_limit_type'      => 'views',
                    'frequency_limit_period'    => 'day',
                    'keywords'                  => 'audi,bmw,cars,-train',
                    'keyword_match_method'      => 'preferred',
                    'zone_ids'                  => [99],
                    'zone_group_ids'            => [21],
                    'zone_all_ids'              => [1, 99],
                    'created_at'                => '2017-10-02T12:04:36Z',
                    'updated_at'                => '2017-10-02T12:04:36Z'
                ],
                [
                    'id'                        => 2,
                    'campaign_id'               => 2,
                    'priority_id'               => 2,
                    'creative_ids'              => [2],
                    'name'                      => 'The Placement',
                    'enabled'                   => false,
                    'html_target'               => '_blank',
                    'app_target'                => 'default',
                    'delivery_method'           => 'default',
                    'lifetime_dates_enabled'    => true,
                    'lifetime_start'            => '2017-10-02T12:04:34Z',
                    'lifetime_end'              => '2017-10-02T14:51:14Z',
                    'lifetime_quota_enabled'    => true,
                    'lifetime_quota_amount'     => 32,
                    'lifetime_quota_type'       => 'views',
                    'under_delivery_behaviour'  => 'endOnDate',
                    'pricing_enabled'           => true,
                    'pricing_method'            => 'fixed',
                    'rate_cpm'                  => null,
                    'rate_cpc'                  => null,
                    'rate_cpa'                  => null,
                    'fixed_cost'                => 5000.50,
                    'publisher_payout_ratio'    => null,
                    'per_user_limit_enabled'    => true,
                    'per_user_limit_amount'     => 2000,
                    'per_user_limit_type'       => 'views',
                    'per_user_limit_period'     => 'hour',
                    'frequency_limit_enabled'   => true,
                    'frequency_limit_amount'    => 30000,
                    'frequency_limit_type'      => 'clicks',
                    'frequency_limit_period'    => 'day',
                    'keywords'                  => 'audi,bmw,cars,-train',
                    'keyword_match_method'      => 'required',
                    'zone_ids'                  => [99],
                    'zone_group_ids'            => [21],
                    'zone_all_ids'              => [1, 99],
                    'created_at'                => '2017-10-02T11:04:36Z',
                    'updated_at'                => '2017-10-02T11:04:36Z'
                ]
            ],
            'pagination' => [
                'total'         => 13,
                'count'         => 2,
                'per_page'      => 2,
                'current_page'  => 1,
                'total_pages'   => 7,
                'links' => [
                    'next' => 'http:\/\/api.adyo.co.za\/v1\/placements?page=2'
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

        // Retrieve the placement objects
        $list = Placement::retrieveAll([
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
        $this->assertSame($list->next_url, 'http:\/\/api.adyo.co.za\/v1\/placements?page=2');
        $this->assertNull($list->prev_url);

        // First Object
        $this->assertInstanceOf(\Adyo\Placement::class, $list->objects[0]);
        $this->assertSame($list->objects[0]->id, 1);
        $this->assertSame($list->objects[0]->campaign_id, 1);
        $this->assertSame($list->objects[0]->priority_id, 1);
        $this->assertSame($list->objects[0]->creative_ids[0], 1);
        $this->assertSame($list->objects[0]->name, 'The Placement');
        $this->assertTrue($list->objects[0]->enabled);
        $this->assertSame($list->objects[0]->html_target, '_blank');
        $this->assertSame($list->objects[0]->app_target, 'default');
        $this->assertSame($list->objects[0]->delivery_method, 'default');
        $this->assertTrue($list->objects[0]->lifetime_dates_enabled);
        $this->assertSame($list->objects[0]->lifetime_start, '2017-10-02T12:04:34Z');
        $this->assertSame($list->objects[0]->lifetime_end, '2017-10-02T14:51:14Z');
        $this->assertTrue($list->objects[0]->lifetime_quota_enabled);
        $this->assertSame($list->objects[0]->lifetime_quota_amount, 32);
        $this->assertSame($list->objects[0]->lifetime_quota_type, 'views');
        $this->assertSame($list->objects[0]->under_delivery_behaviour, 'endOnDate');
        $this->assertTrue($list->objects[0]->pricing_enabled);
        $this->assertSame($list->objects[0]->pricing_method, 'rate');
        $this->assertSame($list->objects[0]->rate_cpm, 1.25);
        $this->assertSame($list->objects[0]->rate_cpc, 2.22);
        $this->assertSame($list->objects[0]->rate_cpa, 3.33);
        $this->assertNull($list->objects[0]->publisher_payout_ratio);
        $this->assertTrue($list->objects[0]->per_user_limit_enabled);
        $this->assertSame($list->objects[0]->per_user_limit_amount, 2000);
        $this->assertSame($list->objects[0]->per_user_limit_type, 'views');
        $this->assertSame($list->objects[0]->per_user_limit_period, 'hour');
        $this->assertTrue($list->objects[0]->frequency_limit_enabled);
        $this->assertSame($list->objects[0]->frequency_limit_amount, 30000);
        $this->assertSame($list->objects[0]->frequency_limit_type, 'views');
        $this->assertSame($list->objects[0]->frequency_limit_period, 'day');
        $this->assertSame($list->objects[0]->keywords, 'audi,bmw,cars,-train');
        $this->assertSame($list->objects[0]->keyword_match_method, 'preferred');
        $this->assertTrue(is_array($list->objects[0]->zone_ids));
        $this->assertSame(count($list->objects[0]->zone_ids), 1);
        $this->assertSame($list->objects[0]->zone_ids[0], 99);
        $this->assertTrue(is_array($list->objects[0]->zone_group_ids));
        $this->assertSame(count($list->objects[0]->zone_group_ids), 1);
        $this->assertSame($list->objects[0]->zone_group_ids[0], 21);
        $this->assertTrue(is_array($list->objects[0]->zone_all_ids));
        $this->assertSame(count($list->objects[0]->zone_all_ids), 2);
        $this->assertSame($list->objects[0]->zone_all_ids[0], 1);
        $this->assertSame($list->objects[0]->zone_all_ids[1], 99);
        $this->assertSame($list->objects[0]->created_at, '2017-10-02T12:04:36Z');
        $this->assertSame($list->objects[0]->updated_at, '2017-10-02T12:04:36Z');

        // Second Object
        $this->assertInstanceOf(\Adyo\Placement::class, $list->objects[1]);
        $this->assertSame($list->objects[1]->id, 2);
        $this->assertSame($list->objects[1]->campaign_id, 2);
        $this->assertSame($list->objects[1]->priority_id, 2);
        $this->assertSame($list->objects[1]->creative_ids[0], 2);
        $this->assertSame($list->objects[1]->name, 'The Placement');
        $this->assertFalse($list->objects[1]->enabled);
        $this->assertSame($list->objects[1]->html_target, '_blank');
        $this->assertSame($list->objects[1]->app_target, 'default');
        $this->assertSame($list->objects[1]->delivery_method, 'default');
        $this->assertTrue($list->objects[1]->lifetime_dates_enabled);
        $this->assertSame($list->objects[1]->lifetime_start, '2017-10-02T12:04:34Z');
        $this->assertSame($list->objects[1]->lifetime_end, '2017-10-02T14:51:14Z');
        $this->assertTrue($list->objects[1]->lifetime_quota_enabled);
        $this->assertSame($list->objects[1]->lifetime_quota_amount, 32);
        $this->assertSame($list->objects[1]->lifetime_quota_type, 'views');
        $this->assertSame($list->objects[1]->under_delivery_behaviour, 'endOnDate');
        $this->assertTrue($list->objects[1]->pricing_enabled);
        $this->assertSame($list->objects[1]->pricing_method, 'fixed');
        $this->assertSame($list->objects[1]->fixed_cost, 5000.50);
        $this->assertNull($list->objects[1]->publisher_payout_ratio);
        $this->assertTrue($list->objects[1]->per_user_limit_enabled);
        $this->assertSame($list->objects[1]->per_user_limit_amount, 2000);
        $this->assertSame($list->objects[1]->per_user_limit_type, 'views');
        $this->assertSame($list->objects[1]->per_user_limit_period, 'hour');
        $this->assertTrue($list->objects[1]->frequency_limit_enabled);
        $this->assertSame($list->objects[1]->frequency_limit_amount, 30000);
        $this->assertSame($list->objects[1]->frequency_limit_type, 'clicks');
        $this->assertSame($list->objects[1]->frequency_limit_period, 'day');
        $this->assertSame($list->objects[1]->keywords, 'audi,bmw,cars,-train');
        $this->assertSame($list->objects[1]->keyword_match_method, 'required');
        $this->assertTrue(is_array($list->objects[1]->zone_ids));
        $this->assertSame(count($list->objects[1]->zone_ids), 1);
        $this->assertSame($list->objects[1]->zone_ids[0], 99);
        $this->assertTrue(is_array($list->objects[1]->zone_group_ids));
        $this->assertSame(count($list->objects[1]->zone_group_ids), 1);
        $this->assertSame($list->objects[1]->zone_group_ids[0], 21);
        $this->assertTrue(is_array($list->objects[1]->zone_all_ids));
        $this->assertSame(count($list->objects[1]->zone_all_ids), 2);
        $this->assertSame($list->objects[1]->zone_all_ids[0], 1);
        $this->assertSame($list->objects[1]->zone_all_ids[1], 99);
        $this->assertSame($list->objects[1]->created_at, '2017-10-02T11:04:36Z');
        $this->assertSame($list->objects[1]->updated_at, '2017-10-02T11:04:36Z');
    }

    /**
      * Test updating a placement
      *
      * @return void
      */
    public function testUpdate()
    {
        // Setup mock responses
        $responseBody = [
            'id'                        => 1,
            'campaign_id'               => 1,
            'priority_id'               => 1,
            'creative_ids'              => [1],
            'name'                      => 'The Placement',
            'enabled'                   => true,
            'html_target'               => '_blank',
            'app_target'                => 'default',
            'delivery_method'           => 'default',
            'lifetime_dates_enabled'    => true,
            'lifetime_start'            => '2017-10-02T12:04:34Z',
            'lifetime_end'              => '2017-10-02T14:51:14Z',
            'lifetime_quota_enabled'    => true,
            'lifetime_quota_amount'     => 32,
            'lifetime_quota_type'       => 'views',
            'under_delivery_behaviour'  => 'endOnDate',
            'pricing_enabled'           => true,
            'pricing_method'            => 'rate',
            'rate_cpm'                  => 1.25,
            'rate_cpc'                  => 2.22,
            'rate_cpa'                  => 3.33,
            'fixed_cost'                => null,
            'publisher_payout_ratio'    => null,
            'per_user_limit_enabled'    => true,
            'per_user_limit_amount'     => 2000,
            'per_user_limit_type'       => 'views',
            'per_user_limit_period'     => 'hour',
            'frequency_limit_enabled'   => true,
            'frequency_limit_amount'    => 30000,
            'frequency_limit_type'      => 'views',
            'frequency_limit_period'    => 'day',
            'keywords'                  => 'audi,bmw,cars,-train',
            'keyword_match_method'      => 'preferred',
            'zone_ids'                  => [99],
            'zone_group_ids'            => [21],
            'zone_all_ids'              => [1, 99],
            'created_at'                => '2017-10-02T12:04:36Z',
            'updated_at'                => '2017-10-02T12:04:36Z'
        ];

        $responseBody2 = [
            'id'                        => 1,
            'campaign_id'               => 1,
            'priority_id'               => 1,
            'creative_ids'              => [1],
            'name'                      => 'Updated Name',
            'enabled'                   => false,
            'html_target'               => '_parent',
            'app_target'                => 'inside',
            'delivery_method'           => 'default',
            'lifetime_dates_enabled'    => false,
            'lifetime_start'            => null,
            'lifetime_end'              => null,
            'lifetime_quota_enabled'    => false,
            'lifetime_quota_amount'     => null,
            'lifetime_quota_type'       => null,
            'under_delivery_behaviour'  => 'endOnDate',
            'pricing_enabled'           => true,
            'pricing_method'            => 'fixed',
            'rate_cpm'                  => null,
            'rate_cpc'                  => null,
            'rate_cpa'                  => null,
            'fixed_cost'                => 4000.50,
            'publisher_payout_ratio'    => 50,
            'per_user_limit_enabled'    => false,
            'per_user_limit_amount'     => null,
            'per_user_limit_type'       => null,
            'per_user_limit_period'     => null,
            'frequency_limit_enabled'   => true,
            'frequency_limit_amount'    => 25000,
            'frequency_limit_type'      => 'views',
            'frequency_limit_period'    => 'day',
            'keywords'                  => 'audi,bmw,car',
            'keyword_match_method'      => 'required',
            'zone_ids'                  => [99],
            'zone_group_ids'            => [21],
            'zone_all_ids'              => [1, 99],
            'created_at'                => '2017-10-02T12:04:36Z',
            'updated_at'                => '2017-10-02T12:04:37Z'
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($responseBody), null),
            new Response(200, [], json_encode($responseBody2), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);        
        Adyo::setApiKey('keygoeshere');

        // Retreive a placement object to update
        $placement = Placement::retrieve(1);

        // Update
        $placement->name = 'Updated Name';
        $placement->enabled = false;
        $placement->html_target = '_parent';
        $placement->app_target = 'inside';
        $placement->lifetime_quota_enabled = false;
        $placement->pricing_method = 'fixed';
        $placement->fixed_cost = 4000.50;
        $placement->publisher_payout_ratio = 50;
        $placement->per_user_limit_enabled = false;
        $placement->frequency_limit_amount = 25000;
        $placement->frequncy_limit_period = 'day';
        $placement->keywords = 'audi,bmw,car';
        $placement->keyword_match_method = 'required';

        $placement->save();

        // Assert
        $this->assertInstanceOf(\Adyo\Placement::class, $placement);
        $this->assertSame($placement->id, 1);
        $this->assertSame($placement->campaign_id, 1);
        $this->assertSame($placement->priority_id, 1);
        $this->assertSame($placement->creative_ids, [1]);
        $this->assertSame($placement->name, 'Updated Name');
        $this->assertFalse($placement->enabled);
        $this->assertSame($placement->html_target, '_parent');
        $this->assertSame($placement->app_target, 'inside');
        $this->assertSame($placement->delivery_method, 'default');
        $this->assertFalse($placement->lifetime_dates_enabled);
        $this->assertNull($placement->lifetime_start);
        $this->assertNull($placement->lifetime_end);
        $this->assertFalse($placement->lifetime_quota_enabled);
        $this->assertNull($placement->lifetime_quota_amount);
        $this->assertNull($placement->lifetime_quota_type);
        $this->assertSame($placement->under_delivery_behaviour, 'endOnDate');
        $this->assertTrue($placement->pricing_enabled);
        $this->assertSame($placement->pricing_method, 'fixed');
        $this->assertSame($placement->fixed_cost, 4000.50);
        $this->assertNull($placement->rate_cpm);
        $this->assertNull($placement->rate_cpc);
        $this->assertNull($placement->rate_cpa);
        $this->assertSame($placement->publisher_payout_ratio, 50);
        $this->assertFalse($placement->per_user_limit_enabled);
        $this->assertNull($placement->per_user_limit_amount);
        $this->assertNull($placement->per_user_limit_type);
        $this->assertNull($placement->per_user_limit_period);
        $this->assertTrue($placement->frequency_limit_enabled);
        $this->assertSame($placement->frequency_limit_amount, 25000);
        $this->assertSame($placement->frequency_limit_type, 'views');
        $this->assertSame($placement->frequency_limit_period, 'day');
        $this->assertSame($placement->keywords, 'audi,bmw,car');
        $this->assertSame($placement->keyword_match_method, 'required');
        $this->assertTrue(is_array($placement->zone_ids));
        $this->assertSame(count($placement->zone_ids), 1);
        $this->assertSame($placement->zone_ids[0], 99);
        $this->assertTrue(is_array($placement->zone_group_ids));
        $this->assertSame(count($placement->zone_group_ids), 1);
        $this->assertSame($placement->zone_group_ids[0], 21);
        $this->assertTrue(is_array($placement->zone_all_ids));
        $this->assertSame(count($placement->zone_all_ids), 2);
        $this->assertSame($placement->zone_all_ids[0], 1);
        $this->assertSame($placement->zone_all_ids[1], 99);
        $this->assertSame($placement->created_at, '2017-10-02T12:04:36Z');
        $this->assertSame($placement->updated_at, '2017-10-02T12:04:37Z');
    }

    /**
      * Test deleting a placement
      *
      * @return void
      */
    public function testDelete()
    {
        // Setup mock responses
        $responseBody = [
            'id'                        => 1,
            'campaign_id'               => 1,
            'priority_id'               => 1,
            'creative_ids'              => [1],
            'name'                      => 'The Placement',
            'enabled'                   => true,
            'html_target'               => '_blank',
            'app_target'                => 'default',
            'delivery_method'           => 'default',
            'lifetime_dates_enabled'    => true,
            'lifetime_start'            => '2017-10-02T12:04:34Z',
            'lifetime_end'              => '2017-10-02T14:51:14Z',
            'lifetime_quota_enabled'    => true,
            'lifetime_quota_amount'     => 32,
            'lifetime_quota_type'       => 'views',
            'under_delivery_behaviour'  => 'endOnDate',
            'pricing_enabled'           => true,
            'pricing_method'            => 'rate',
            'rate_cpm'                  => 1.25,
            'rate_cpc'                  => 2.22,
            'rate_cpa'                  => 3.33,
            'fixed_cost'                => null,
            'publisher_payout_ratio'    => null,
            'per_user_limit_enabled'    => true,
            'per_user_limit_amount'     => 2000,
            'per_user_limit_type'       => 'views',
            'per_user_limit_period'     => 'hour',
            'frequency_limit_enabled'   => true,
            'frequency_limit_amount'    => 30000,
            'frequency_limit_type'      => 'views',
            'frequency_limit_period'    => 'day',
            'keywords'                  => 'audi,bmw,cars,-train',
            'keyword_match_method'      => 'preferred',
            'zone_ids'                  => [99],
            'zone_group_ids'            => [21],
            'zone_all_ids'              => [1, 99],
            'created_at'                => '2017-10-02T12:04:36Z',
            'updated_at'                => '2017-10-02T12:04:36Z'
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

        // Retrieve the placement to delete
        $placement = Placement::retrieve(1);

        // Delete
        $placement->delete();

        // Assert
        $this->assertInstanceOf(\Adyo\Placement::class, $placement);
        $this->assertSame($placement->id, 1);
        $this->assertTrue($placement->isDeleted);
        $this->assertFalse(property_exists($placement, 'campaign_id'));
        $this->assertFalse(property_exists($placement, 'priority_id'));
        $this->assertFalse(property_exists($placement, 'creative_ids'));
        $this->assertFalse(property_exists($placement, 'name'));
        $this->assertFalse(property_exists($placement, 'enabled'));
        $this->assertFalse(property_exists($placement, 'html_target'));
        $this->assertFalse(property_exists($placement, 'app_target'));
        $this->assertFalse(property_exists($placement, 'delivery_method'));
        $this->assertFalse(property_exists($placement, 'lifetime_dates_enabled'));
        $this->assertFalse(property_exists($placement, 'lifetime_start'));
        $this->assertFalse(property_exists($placement, 'lifetime_end'));
        $this->assertFalse(property_exists($placement, 'lifetime_quota_enabled'));
        $this->assertFalse(property_exists($placement, 'lifetime_quota_amount'));
        $this->assertFalse(property_exists($placement, 'lifetime_quota_type'));
        $this->assertFalse(property_exists($placement, 'under_delivery_behaviour'));
        $this->assertFalse(property_exists($placement, 'pricing_enabled'));
        $this->assertFalse(property_exists($placement, 'pricing_method'));
        $this->assertFalse(property_exists($placement, 'fixed_cost'));
        $this->assertFalse(property_exists($placement, 'rate_cpm'));
        $this->assertFalse(property_exists($placement, 'rate_cpc'));
        $this->assertFalse(property_exists($placement, 'rate_cpa'));
        $this->assertFalse(property_exists($placement, 'publisher_payout_ratio'));
        $this->assertFalse(property_exists($placement, 'per_user_limit_enabled'));
        $this->assertFalse(property_exists($placement, 'per_user_limit_type'));
        $this->assertFalse(property_exists($placement, 'per_user_limit_period'));
        $this->assertFalse(property_exists($placement, 'per_user_limit_period'));
        $this->assertFalse(property_exists($placement, 'frequency_limit_enabled'));
        $this->assertFalse(property_exists($placement, 'frequency_limit_amount'));
        $this->assertFalse(property_exists($placement, 'frequency_limit_type'));
        $this->assertFalse(property_exists($placement, 'frequency_limit_period'));
        $this->assertFalse(property_exists($placement, 'keywords'));
        $this->assertFalse(property_exists($placement, 'keyword_match_method'));
        $this->assertFalse(property_exists($placement, 'zone_ids'));
        $this->assertFalse(property_exists($placement, 'zone_group_ids'));
        $this->assertFalse(property_exists($placement, 'zone_all_ids'));
        $this->assertFalse(property_exists($placement, 'created_at'));
        $this->assertFalse(property_exists($placement, 'updated_at'));
    }
}