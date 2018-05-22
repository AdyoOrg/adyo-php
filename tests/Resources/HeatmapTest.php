<?php

namespace Adyo;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

use Adyo\Adyo;
use Adyo\Client as AdyoClient;

class HeatmapTest extends TestCase {

    /**
      * Test receiving a heatmap
      *
      * @return void
      */
    public function testGet()
    {   
        // Setup mock response
        $responseBody =  [
            'bounding_box' => [
                'min_lat' => -26.230900017544627,
                'min_lon' => -122.05740004777908,
                'max_lat' => 37.41919999010861,
                'max_lon' => 28.058299999684095
            ],
            'items' => [
                [
                    'count'     => 22256,
                    'geo_hash'  => '9q9hy',
                    'lat'       => 37.41919999010861,
                    'lon'       => -122.05740004777908
                ],
                [
                    'count'     => 5904,
                    'geo_hash'  => 'ke7fy',
                    'lat'       => -26.230900017544627,
                    'lon'       => 28.058299999684095
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

        // Get the impression count
        $result = Heatmap::get([
            'event_type'    => 'impression',
            'campaign_ids'  => [1, 2, 3],
            'placement_ids' => [1, 2, 3],
            'is_desktop'    => true,
            'is_windows'    => false,
        ]);

        // Assert
        $this->assertSame($result->bounding_box->min_lat, -26.230900017544627);
        $this->assertSame($result->bounding_box->min_lon, -122.05740004777908);
        $this->assertSame($result->bounding_box->max_lat, 37.41919999010861);
        $this->assertSame($result->bounding_box->max_lon, 28.058299999684095);

        $this->assertSame($result->items[0]->count, 22256);
        $this->assertSame($result->items[0]->geo_hash, '9q9hy');
        $this->assertSame($result->items[0]->lat, 37.41919999010861);
        $this->assertSame($result->items[0]->lon, -122.05740004777908);

        $this->assertSame($result->items[1]->count, 5904);
        $this->assertSame($result->items[1]->geo_hash, 'ke7fy');
        $this->assertSame($result->items[1]->lat, -26.230900017544627);
        $this->assertSame($result->items[1]->lon, 28.058299999684095);
    }
}