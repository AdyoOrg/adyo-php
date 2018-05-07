<?php

namespace Adyo;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

use Adyo\Adyo;
use Adyo\Client as AdyoClient;

class ClickUserCountTest extends TestCase {

    /**
      * Test receiving a single click user count (no aggregations)
      *
      * @return void
      */
    public function testGetSingle()
    {   
        // Setup mock response
        $responseBody = [
            'count' => 100,
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($responseBody), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);        
        Adyo::setApiKey('keygoeshere');

        // Get the click user count
        $count = ClickUserCount::get([
            'campaign_ids' => [1, 2, 3],
            'advertiser_ids' => [1, 2, 3],
            'placement_ids' => [1, 2, 3],
            'is_desktop' => true,
            'is_windows' => false,
        ]);

        // Assert
        $this->assertTrue(is_int($count));
        $this->assertSame($count, 100);
    }

    /**
      * Test receiving an aggregated click user count
      *
      * @return void
      */
    public function testGetAggregated()
    {   
        // Setup mock response
        $responseBody = [
            [
                'placement_id' => 1,
                'count' => 10,
            ],
            [
                'placement_id' => 2,
                'count' => 20,
            ],
            [
                'placement_id' => 3,
                'count' => 30,
            ],
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($responseBody), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);        
        Adyo::setApiKey('keygoeshere');

        // Get the click user count
        $counts = ClickUserCount::get([
            'campaign_ids' => [1, 2, 3],
            'advertiser_ids' => [1, 2, 3],
            'placement_ids' => [1, 2, 3],
            'is_desktop' => true,
            'is_windows' => false,
            'group_by' => 'placement_id',
        ]);

        // Assert
        $this->assertTrue(is_array($counts));
        $this->assertSame($counts[0]->placement_id, 1);
        $this->assertSame($counts[0]->count, 10);
        $this->assertSame($counts[1]->placement_id, 2);
        $this->assertSame($counts[1]->count, 20);
        $this->assertSame($counts[2]->placement_id, 3);
        $this->assertSame($counts[2]->count, 30);
    }
}