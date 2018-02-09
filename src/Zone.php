<?php

namespace Adyo;

use Adyo\Adyo;

class Zone extends ApiResource 
{
    /**
     * The API resource path to append to base url when making requests.
     *
     * @var string
     */
    const RESOURCE_PATH = 'zones';

    /**
     * Attributes available on the zone
     *
     * @var array
     */
    protected static $attributes = [
      'id',
      'publisher_id',
      'type',
      'name',
      'is_dynamic_size',
      'width',
      'height',
      'refresh_rate',
      'created_at',
      'updated_at',

      // Expanded objects
      'publisher'
    ];

    /**
     * Create a new zone with the provided properties.
     *
     * @param array|null $body The properties of the zone
     * @return Adyo\Zone $zone A new zone object with set properties
     */
    public static function create($body = null)
    {   
        $responseBody = self::_create(Zone::RESOURCE_PATH, null, $body);

        return self::mapToAttributes($responseBody);
    }

    /**
     * Retrieve a specific zone.
     *
     * @param int $id The id of the zone.
     * @param array $params Params to include in query
     * @return Adyo\Zone $zone A new zone object with set properties
     */
    public static function retrieve($id, $params = [])
    {   
        $responseBody = self::_retrieve(Zone::RESOURCE_PATH . '/' . $id, $params);

        return self::mapToAttributes($responseBody);
    }

    /**
     * Retrieve all zones using pagination.
     *
     * @param array $params Params to include in query
     */
    public static function retrieveAll($params = [])
    { 

      // Execute
      $responseBody = self::_retrieveAll(Zone::RESOURCE_PATH, $params);
      
      // Work on response
      $pagination = $responseBody['pagination'];

      // Loop through each response object in data and create zone objects
      $zones = [];

      foreach ($responseBody['data'] as $body) {
        $zones[] = self::mapToAttributes($body);
      }

      // Create new list and add zones to list
      $list = new AdyoList($zones,
                           $pagination['total'],
                           $pagination['count'],
                           $pagination['per_page'],
                           $pagination['current_page'],
                           $pagination['total_pages'],
                           array_key_exists('next', $pagination['links']) ? $pagination['links']['next'] : null,
                           array_key_exists('prev', $pagination['links']) ? $pagination['links']['prev'] : null);

      return $list;
    }

    /**
     * Save (update) the current zone. 
     *
     * @return void
     */
    public function save() 
    {   
        // Create body using keys required by API
      $body = [];

      foreach (self::$attributes as $attributeName) {
        
        // Ignore expanded resources
        if ($attributeName === 'publisher') {
          continue;
        }

        if (property_exists($this, $attributeName)) {
          $body[$attributeName] = $this->{$attributeName};
        }
      }

        // Execute
      $responseBody = self::_update(Zone::RESOURCE_PATH . '/' . $this->id, null, $body);

        // Update local properties to new ones returned by APIs
      $this->updateAttributes($responseBody);
    }

    /**
     * Deletes the current zone.
     *
     * @return void
     */
    public function delete()
    {   
        // Execute
      self::_delete(Zone::RESOURCE_PATH . '/' . $this->id);

        // Set property to deleted
      $this->isDeleted = true;

        // Unset all other properties (except id)
      foreach (self::$attributes as $attributeName) {
        
        if ($attributeName === 'id') {
         continue;
       }

       unset($this->{$attributeName});
     }
   }

    /**
     * Maps properties from API to new zone object attributes
     *
     * @param array $body 
     * @return Adyo\Zone
     */
    public static function mapToAttributes($body) 
    {
      $zone = new Zone;

      foreach ($body as $key => $value) {

        if ($key === 'publisher') {
          $zone->{$key} = Publisher::mapToAttributes($value);
        } else if (in_array($key, self::$attributes)) {
          $zone->{$key} = $value;
        }
      }

      return $zone;
    }

    /**
     * Maps properties from API to the current zone object attributes
     *
     * @param array $body 
     * @return void
     */
    private function updateAttributes($body) 
    {
        foreach ($body as $key => $value) {

        if ($key === 'publisher') {
          $this->{$key} = Publisher::mapToAttributes($value);
        } else if (in_array($key, self::$attributes)) {
          $this->{$key} = $value;
        }
      }
    }
  }