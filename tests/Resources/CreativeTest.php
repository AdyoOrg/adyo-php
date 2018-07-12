<?php

namespace Adyo;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

use Adyo\Adyo;
use Adyo\Client as AdyoClient;

class CreativeTest extends TestCase {

    /**
      * Test creating an image creative
      *
      * @return void
      */
    public function testCreateImage()
    {   
        // Setup mock response
        $responseBody = [
            'id'                    => 1,
            'advertiser_id'         => 1,
            'type'                  => 'image',
            'name'                  => 'Image Creative',
            'description'           => 'Description of creative.',
            'url'                   => 'http://www.adyo.co.za/test.png',
            'alt_text'              => null,
            'third_party_pixel_url' => 'http://www.adyo.co.za/pixel.jpg',
            'width'                 => 100,
            'height'                => 58,
            'created_at'            => '2017-10-04T12:57:18Z',
            'updated_at'            => '2017-10-04T12:57:18Z'
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($responseBody), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);        
        Adyo::setApiKey('keygoeshere');

        // Create the creative object
        $creative = Creative::create([
            'advertiser_id'         => 1,
            'type'                  => 'image',
            'name'                  => 'Image Creative',
            'description'           => 'Description of creative.',
            'third_party_pixel_url' => 'http://www.adyo.co.za/pixel.jpg',
            'file'                  => 'tests/test.png',
        ]);

        // Assert
        $this->assertInstanceOf(\Adyo\Creative::class, $creative);
        $this->assertSame($creative->id, 1);
        $this->assertSame($creative->advertiser_id, 1);
        $this->assertSame($creative->type, 'image');
        $this->assertSame($creative->name, 'Image Creative');
        $this->assertSame($creative->description, 'Description of creative.');
        $this->assertSame($creative->url, 'http://www.adyo.co.za/test.png');
        $this->assertSame($creative->third_party_pixel_url, 'http://www.adyo.co.za/pixel.jpg');
        $this->assertSame($creative->width, 100);
        $this->assertSame($creative->height, 58);
        $this->assertSame($creative->created_at, '2017-10-04T12:57:18Z');
        $this->assertSame($creative->updated_at, '2017-10-04T12:57:18Z');
    }

    /**
      * Test creating a video creative
      *
      * @return void
      */
    public function testCreateVideo()
    {   
        // Setup mock response
        $responseBody = [
            'id'                    => 1,
            'advertiser_id'         => 1,
            'type'                  => 'video',
            'name'                  => 'Video Creative',
            'description'           => 'Description of creative.',
            'url'                   => 'http://www.adyo.co.za/test.mp4',
            'alt_text'              => null,
            'third_party_pixel_url' => 'http://www.adyo.co.za/pixel.jpg',
            'width'                 => 560,
            'height'                => 320,
            'video_frame_rate'      => 30,
            'video_duration'        => 5,
            'created_at'            => '2017-10-04T12:57:18Z',
            'updated_at'            => '2017-10-04T12:57:18Z'
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($responseBody), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);        
        Adyo::setApiKey('keygoeshere');

        // Create the creative object
        $creative = Creative::create([
            'advertiser_id'         => 1,
            'type'                  => 'video',
            'name'                  => 'Video Creative',
            'description'           => 'Description of creative.',
            'third_party_pixel_url' => 'http://www.adyo.co.za/pixel.jpg',
            'file'                  => 'tests/test.mp4',
        ]);

        // Assert
        $this->assertInstanceOf(\Adyo\Creative::class, $creative);
        $this->assertSame($creative->id, 1);
        $this->assertSame($creative->advertiser_id, 1);
        $this->assertSame($creative->type, 'video');
        $this->assertSame($creative->name, 'Video Creative');
        $this->assertSame($creative->description, 'Description of creative.');
        $this->assertSame($creative->url, 'http://www.adyo.co.za/test.mp4');
        $this->assertSame($creative->third_party_pixel_url, 'http://www.adyo.co.za/pixel.jpg');
        $this->assertSame($creative->width, 560);
        $this->assertSame($creative->height, 320);
        $this->assertSame($creative->video_frame_rate, 30);
        $this->assertSame($creative->video_duration, 5);
        $this->assertSame($creative->created_at, '2017-10-04T12:57:18Z');
        $this->assertSame($creative->updated_at, '2017-10-04T12:57:18Z');
    }

    /**
      * Test creating a rich media creative
      *
      * @return void
      */
    public function testCreateRichMedia()
    {   
        // Setup mock response
        $responseBody = [
            'id'                    => 1,
            'advertiser_id'         => 1,
            'type'                  => 'rich-media',
            'name'                  => 'Rich Media Creative',
            'description'           => 'Description of creative.',
            'url'                   => 'http://www.adyo.co.za/test.zip',
            'alt_text'              => null,
            'third_party_pixel_url' => 'http://www.adyo.co.za/pixel.jpg',
            'created_at'            => '2017-10-04T12:57:18Z',
            'updated_at'            => '2017-10-04T12:57:18Z'
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($responseBody), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);        
        Adyo::setApiKey('keygoeshere');

        // Create the creative object
        $creative = Creative::create([
            'advertiser_id'         => 1,
            'type'                  => 'rich-media',
            'name'                  => 'Rich Media Creative',
            'description'           => 'Description of creative.',
            'third_party_pixel_url' => 'http://www.adyo.co.za/pixel.jpg',
            'file'                  => 'tests/test.zip',
        ]);

        // Assert
        $this->assertInstanceOf(\Adyo\Creative::class, $creative);
        $this->assertSame($creative->id, 1);
        $this->assertSame($creative->advertiser_id, 1);
        $this->assertSame($creative->type, 'rich-media');
        $this->assertSame($creative->name, 'Rich Media Creative');
        $this->assertSame($creative->description, 'Description of creative.');
        $this->assertSame($creative->url, 'http://www.adyo.co.za/test.zip');
        $this->assertSame($creative->third_party_pixel_url, 'http://www.adyo.co.za/pixel.jpg');
        $this->assertSame($creative->created_at, '2017-10-04T12:57:18Z');
        $this->assertSame($creative->updated_at, '2017-10-04T12:57:18Z');
    }

    /**
      * Test creating a text creative
      *
      * @return void
      */
    public function testCreateText()
    {   
        // Setup mock response
        $responseBody = [
            'id'                    => 1,
            'advertiser_id'         => 1,
            'type'                  => 'text',
            'name'                  => 'Text Creative',
            'description'           => 'Description of creative.',
            'url'                   => null,
            'alt_text'              => null,
            'title'                 => 'Title Text',
            'body'                  => 'Body text.',
            'third_party_pixel_url' => 'http://www.adyo.co.za/pixel.jpg',
            'created_at'            => '2017-10-04T12:57:18Z',
            'updated_at'            => '2017-10-04T12:57:18Z'
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($responseBody), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);        
        Adyo::setApiKey('keygoeshere');

        // Create the creative object
        $creative = Creative::create([
            'advertiser_id'         => 1,
            'type'                  => 'text',
            'name'                  => 'Text Creative',
            'description'           => 'Description of creative.',
            'title'                 => 'Title Text',
            'body'                  => 'Body text.',
            'third_party_pixel_url' => 'http://www.adyo.co.za/pixel.jpg',
        ]);

        // Assert
        $this->assertInstanceOf(\Adyo\Creative::class, $creative);
        $this->assertSame($creative->id, 1);
        $this->assertSame($creative->advertiser_id, 1);
        $this->assertSame($creative->type, 'text');
        $this->assertSame($creative->name, 'Text Creative');
        $this->assertSame($creative->description, 'Description of creative.');
        $this->assertNull($creative->url);
        $this->assertSame($creative->third_party_pixel_url, 'http://www.adyo.co.za/pixel.jpg');
        $this->assertSame($creative->title, 'Title Text');
        $this->assertSame($creative->body, 'Body text.');
        $this->assertSame($creative->created_at, '2017-10-04T12:57:18Z');
        $this->assertSame($creative->updated_at, '2017-10-04T12:57:18Z');
    }

    /**
      * Test creating a tag creative
      *
      * @return void
      */
    public function testCreateTag()
    {   
        // Setup mock response
        $responseBody = [
            'id'                    => 1,
            'advertiser_id'         => 1,
            'type'                  => 'tag',
            'name'                  => 'Tag Creative',
            'description'           => 'Description of creative.',
            'url'                   => null,
            'alt_text'              => null,
            'html'                  => '<p>The Tag<p>',
            'tag_domain'            => 'http://www.adyo.co.za',
            'third_party_pixel_url' => 'http://www.adyo.co.za/pixel.jpg',
            'created_at'            => '2017-10-04T12:57:18Z',
            'updated_at'            => '2017-10-04T12:57:18Z'
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($responseBody), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);        
        Adyo::setApiKey('keygoeshere');

        // Create the creative object
        $creative = Creative::create([
            'advertiser_id'         => 1,
            'type'                  => 'tag',
            'name'                  => 'Tag Creative',
            'description'           => 'Description of creative.',
            'html'                  => '<p>The Tag<p>',
            'tag_domain'            => 'http://www.adyo.co.za',
            'third_party_pixel_url' => 'http://www.adyo.co.za/pixel.jpg',
        ]);

        // Assert
        $this->assertInstanceOf(\Adyo\Creative::class, $creative);
        $this->assertSame($creative->id, 1);
        $this->assertSame($creative->advertiser_id, 1);
        $this->assertSame($creative->type, 'tag');
        $this->assertSame($creative->name, 'Tag Creative');
        $this->assertSame($creative->description, 'Description of creative.');
        $this->assertNull($creative->url);
        $this->assertSame($creative->third_party_pixel_url, 'http://www.adyo.co.za/pixel.jpg');
        $this->assertSame($creative->html, '<p>The Tag<p>');
        $this->assertSame($creative->tag_domain, 'http://www.adyo.co.za');
        $this->assertSame($creative->created_at, '2017-10-04T12:57:18Z');
        $this->assertSame($creative->updated_at, '2017-10-04T12:57:18Z');
    }

    /**
      * Test the retrieval of a creative
      *
      * @return void
      */
    public function testRetrieve()
    {   
        // Setup mock response
        $responseBody = [
            'id'                    => 1,
            'advertiser_id'         => 1,
            'type'                  => 'image',
            'name'                  => 'Image Creative',
            'description'           => 'Description of creative.',
            'url'                   => 'http://www.adyo.co.za/test.png',
            'alt_text'              => null,
            'third_party_pixel_url' => 'http://www.adyo.co.za/pixel.jpg',
            'width'                 => 100,
            'height'                => 58,
            'created_at'            => '2017-10-04T12:57:18Z',
            'updated_at'            => '2017-10-04T12:57:18Z'
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($responseBody), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);        
        Adyo::setApiKey('keygoeshere');

        // Retrieve the creative object
        $creative = Creative::retrieve(1);

        // Assert
        $this->assertInstanceOf(\Adyo\Creative::class, $creative);
        $this->assertSame($creative->id, 1);
        $this->assertSame($creative->advertiser_id, 1);
        $this->assertSame($creative->type, 'image');
        $this->assertSame($creative->name, 'Image Creative');
        $this->assertSame($creative->description, 'Description of creative.');
        $this->assertSame($creative->url, 'http://www.adyo.co.za/test.png');
        $this->assertSame($creative->third_party_pixel_url, 'http://www.adyo.co.za/pixel.jpg');
        $this->assertSame($creative->width, 100);
        $this->assertSame($creative->height, 58);
        $this->assertSame($creative->created_at, '2017-10-04T12:57:18Z');
        $this->assertSame($creative->updated_at, '2017-10-04T12:57:18Z');
    }

    /**
      * Test the retrieval of multiple creatives
      *
      * @return void
      */
    public function testRetrieveAll()
    {   
        // Setup mock response
        $responseBody = [
            'data' => [
                [
                    'id'                    => 1,
                    'advertiser_id'         => 1,
                    'type'                  => 'image',
                    'name'                  => 'Image Creative',
                    'description'           => 'Description of creative.',
                    'url'                   => 'http://www.adyo.co.za/test.png',
                    'alt_text'              => null,
                    'third_party_pixel_url' => 'http://www.adyo.co.za/pixel.jpg',
                    'width'                 => 100,
                    'height'                => 58,
                    'created_at'            => '2017-10-04T12:57:18Z',
                    'updated_at'            => '2017-10-04T12:57:18Z'
                ],
                [
                    'id'                    => 2,
                    'advertiser_id'         => 1,
                    'type'                  => 'video',
                    'name'                  => 'Video Creative',
                    'description'           => 'Description of creative.',
                    'url'                   => 'http://www.adyo.co.za/test.mp4',
                    'alt_text'              => null,
                    'third_party_pixel_url' => 'http://www.adyo.co.za/pixel.jpg',
                    'width'                 => 560,
                    'height'                => 320,
                    'video_frame_rate'      => 30,
                    'video_duration'        => 5,
                    'created_at'            => '2017-10-04T12:58:18Z',
                    'updated_at'            => '2017-10-04T12:58:18Z'
                ]
            ],
            'pagination' => [
                'total'         => 13,
                'count'         => 2,
                'per_page'      => 2,
                'current_page'  => 1,
                'total_pages'   => 7,
                'links' => [
                    'next' => 'http:\/\/api.adyo.co.za\/v1\/creatives?page=2'
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

        // Retrieve the creative object
        $list = Creative::retrieveAll([
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
        $this->assertSame($list->next_url, 'http:\/\/api.adyo.co.za\/v1\/creatives?page=2');
        $this->assertNull($list->prev_url);

        $this->assertInstanceOf(\Adyo\Creative::class, $list->objects[0]);
        $this->assertSame($list->objects[0]->id, 1);
        $this->assertSame($list->objects[0]->advertiser_id, 1);
        $this->assertSame($list->objects[0]->type, 'image');
        $this->assertSame($list->objects[0]->name, 'Image Creative');
        $this->assertSame($list->objects[0]->description, 'Description of creative.');
        $this->assertSame($list->objects[0]->url, 'http://www.adyo.co.za/test.png');
        $this->assertSame($list->objects[0]->third_party_pixel_url, 'http://www.adyo.co.za/pixel.jpg');
        $this->assertSame($list->objects[0]->width, 100);
        $this->assertSame($list->objects[0]->height, 58);
        $this->assertSame($list->objects[0]->created_at, '2017-10-04T12:57:18Z');
        $this->assertSame($list->objects[0]->updated_at, '2017-10-04T12:57:18Z');

        $this->assertInstanceOf(\Adyo\Creative::class, $list->objects[1]);
        $this->assertSame($list->objects[1]->id, 2);
        $this->assertSame($list->objects[1]->advertiser_id, 1);
        $this->assertSame($list->objects[1]->type, 'video');
        $this->assertSame($list->objects[1]->name, 'Video Creative');
        $this->assertSame($list->objects[1]->description, 'Description of creative.');
        $this->assertSame($list->objects[1]->url, 'http://www.adyo.co.za/test.mp4');
        $this->assertSame($list->objects[1]->third_party_pixel_url, 'http://www.adyo.co.za/pixel.jpg');
        $this->assertSame($list->objects[1]->width, 560);
        $this->assertSame($list->objects[1]->height, 320);
        $this->assertSame($list->objects[1]->video_frame_rate, 30);
        $this->assertSame($list->objects[1]->video_duration, 5);
        $this->assertSame($list->objects[1]->created_at, '2017-10-04T12:58:18Z');
        $this->assertSame($list->objects[1]->updated_at, '2017-10-04T12:58:18Z');
    }

    /**
      * Test updating an creative
      *
      * @return void
      */
    public function testUpdate()
    {
        // Setup mock responses
        $responseBody = [
            'id'                    => 1,
            'advertiser_id'         => 1,
            'type'                  => 'image',
            'name'                  => 'Image Creative',
            'description'           => 'Description of creative.',
            'url'                   => 'http://www.adyo.co.za/test.png',
            'alt_text'              => null,
            'third_party_pixel_url' => 'http://www.adyo.co.za/pixel.jpg',
            'width'                 => 100,
            'height'                => 58,
            'created_at'            => '2017-10-04T12:57:18Z',
            'updated_at'            => '2017-10-04T12:57:18Z'
        ];

        $responseBody2 = [
            'id'                    => 1,
            'advertiser_id'         => 1,
            'type'                  => 'image',
            'name'                  => 'Updated Name',
            'description'           => 'Updated description.',
            'url'                   => 'http://www.adyo.co.za/test2.png',
            'alt_text'              => null,
            'third_party_pixel_url' => 'http://www.adyo.co.za/pixel.jpg',
            'width'                 => 50,
            'height'                => 29,
            'created_at'            => '2017-10-04T12:58:18Z',
            'updated_at'            => '2017-10-04T12:58:18Z'
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($responseBody), null),
            new Response(200, [], json_encode($responseBody2), null),
        ]);

        $handler = HandlerStack::create($mock);

        // Set static http client with mock handler
        AdyoClient::$httpClient = new GuzzleClient(['handler' => $handler]);        
        Adyo::setApiKey('keygoeshere');

        // Retreive an creative object to update
        $creative = Creative::retrieve(1);

        // Update
        $creative->name = 'Updated Name';
        $creative->description = 'Updated description.';
        $creative->file = 'tests/test2.png';
        $creative->save();

        // Assert
        $this->assertInstanceOf(\Adyo\Creative::class, $creative);
        $this->assertSame($creative->id, 1);
        $this->assertSame($creative->advertiser_id, 1);
        $this->assertSame($creative->type, 'image');
        $this->assertSame($creative->name, 'Updated Name');
        $this->assertSame($creative->description, 'Updated description.');
        $this->assertSame($creative->url, 'http://www.adyo.co.za/test2.png');
        $this->assertSame($creative->third_party_pixel_url, 'http://www.adyo.co.za/pixel.jpg');
        $this->assertSame($creative->width, 50);
        $this->assertSame($creative->height, 29);
        $this->assertSame($creative->created_at, '2017-10-04T12:58:18Z');
        $this->assertSame($creative->updated_at, '2017-10-04T12:58:18Z');
    }

    /**
      * Test deleting an creative
      *
      * @return void
      */
    public function testDelete()
    {
        // Setup mock response
        $responseBody = [
            'id'                    => 1,
            'advertiser_id'         => 1,
            'type'                  => 'image',
            'name'                  => 'Image Creative',
            'description'           => 'Description of creative.',
            'url'                   => 'http://www.adyo.co.za/test.png',
            'alt_text'              => null,
            'third_party_pixel_url' => 'http://www.adyo.co.za/pixel.jpg',
            'width'                 => 100,
            'height'                => 58,
            'created_at'            => '2017-10-04T12:57:18Z',
            'updated_at'            => '2017-10-04T12:57:18Z'
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

        // Retrieve an creative to delete
        $creative = Creative::retrieve(1);

        // Delete
        $creative->delete();

        // Assert
        $this->assertInstanceOf(\Adyo\Creative::class, $creative);
        $this->assertSame($creative->id, 1);
        $this->assertTrue($creative->isDeleted);
        $this->assertFalse(property_exists($creative, 'advertiser_id'));
        $this->assertFalse(property_exists($creative, 'type'));
        $this->assertFalse(property_exists($creative, 'name'));
        $this->assertFalse(property_exists($creative, 'description'));
        $this->assertFalse(property_exists($creative, 'url'));
        $this->assertFalse(property_exists($creative, 'alt_text'));
        $this->assertFalse(property_exists($creative, 'third_party_pixel_url'));
        $this->assertFalse(property_exists($creative, 'width'));
        $this->assertFalse(property_exists($creative, 'height'));
        $this->assertFalse(property_exists($creative, 'created_at'));
        $this->assertFalse(property_exists($creative, 'updated_at'));
    }
}