<?php

namespace Adyo;

use Adyo\Adyo;

class ClickThroughRate extends ApiResource 
{
    /**
     * The API resource path to append to base url when making requests
     *
     * @var string
     */
    const RESOURCE_PATH = 'analytics/ctr';

    /**
     * Get ctr count with specific params
     *
     * @param array|null $body The params such as filters, aggregations..
     * @return mixed
     */
    public static function get($body = null)
    {   
        $responseBody = self::_staticPost(ClickThroughRate::RESOURCE_PATH, null, $body, false);

        // If aggregated response, map differently that single response
        if (array_key_exists('group_by', $body) && !is_null($body['group_by'])) {
         
            return self::mapToAggregatedResult($responseBody);
        }

        return self::mapToSingleResult($responseBody); 
    }

    /**
     * Maps properties from API to ctr result
     *
     * @param array $body 
     * @return int
     */
    public static function mapToSingleResult($body) 
    {
        $result = 0;

        if (array_key_exists('rate', $body)) {
            $result = $body['rate'];
        }

        return $result;
    }

    /**
     * Maps properties from API array of aggregated counts
     *
     * @param array $body 
     * @return array<stdClass>
     */
    public static function mapToAggregatedResult($body) 
    {
        $results = [];

        foreach ($body as $item) {

            $result = new \stdClass;

            foreach ($item as $key => $value) {
                $result->{$key} = $value;
            } 

            $results[] = $result;
        }

        return $results;
    }
}