<?php

namespace Adyo;

use Adyo\Adyo;

class Heatmap extends ApiResource 
{
    /**
     * The API resource path to append to base url when making requests
     *
     * @var string
     */
    const RESOURCE_PATH = 'heatmap';

    /**
     * Get heatmap with specific params
     *
     * @param array|null $body The params such as filters, aggregations..
     * @return mixed
     */
    public static function get($body = null)
    {   
        $responseBody = self::_staticPost(Heatmap::RESOURCE_PATH, null, $body, false, true);

        // Map response
        return self::mapResult($responseBody);   
    }

    /**
     * Maps properties from API to result object
     *
     * @param array $body 
     * @return array<stdClass>
     */
    public static function mapResult($body) 
    {
        $result = new \stdClass;

        // Bounding box item
        $boundingBox = new \stdClass;
       
        foreach ($body['bounding_box'] as $key => $value) {
            $boundingBox->{$key} = $value;
        } 

        $result->bounding_box = $boundingBox;
       
        // Individual point items
        $items = [];

        foreach ($body['items'] as $item) {

            $itemObj = new \stdClass;

            foreach ($item as $key => $value) {
                $itemObj->{$key} = $value;
            } 

            $items[] = $itemObj;
        }
       
        $result->items = $items;

        return $result;
    }
}