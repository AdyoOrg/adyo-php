<?php

namespace Adyo;

use Adyo\Adyo;

class ZoneGroup extends ApiResource 
{
    /**
     * The API resource path to append to base url when making requests.
     *
     * @var string
     */
    const RESOURCE_PATH = 'zone-groups';

    /**
     * Attributes available on the zone
     *
     * @var array
     */
    protected static $attributes = [
      'id',
      'name',
      'zones',
      'zone_ids',
      'created_at',
      'updated_at',

      // Expanded Objects
      'zones',
    ];

    /**
     * Create a new zone group with the provided properties.
     *
     * @param array|null $body The properties of the zone group
     * @return \Adyo\ZoneGroup $zoneGroup A new zone group object with set properties
     */
    public static function create($body = null)
    {   
        $responseBody = self::_create(ZoneGroup::RESOURCE_PATH, null, $body);

        return self::mapToAttributes($responseBody);
    }

    /**
     * Retrieve a specific zone group.
     *
     * @param int $id The id of the zone group
     * @param array $params Params to include in query
     * @return \Adyo\ZoneGroup $zoneGroup A new zone group object with set properties
     */
    public static function retrieve($id, $params = [])
    {   
        $responseBody = self::_retrieve(ZoneGroup::RESOURCE_PATH . '/' . $id, $params);

        return self::mapToAttributes($responseBody);
    }

    /**
     * Retrieve all zone groups using pagination.
     *
     * @param array $params Params to include in query
     * @return \Adyo\ZoneGroup $zoneGroup A new zone group object with set properties
     */
    public static function retrieveAll($params = [])
    { 
      // Execute
      $responseBody = self::_retrieveAll(ZoneGroup::RESOURCE_PATH, $params);
      
      // Work on response
      $pagination = $responseBody['pagination'];

      // Loop through each response object in data and create zone group objects
      $zoneGroups = [];

      foreach ($responseBody['data'] as $body) {
        $zoneGroups[] = self::mapToAttributes($body);
      }

      // Create new list and add zone groups to list
      $list = new AdyoList($zoneGroups,
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
     * Save (update) the current zone group. 
     *
     * @return void
     */
    public function save() 
    {   
      // Create body using keys required by API
      $body = [];

      foreach (self::$attributes as $attributeName) {
        
        // Ignore expanded resources
        if ($attributeName === 'zones') {
          continue;
        }

        if (property_exists($this, $attributeName)) {
          $body[$attributeName] = $this->{$attributeName};
        }
      }

        // Execute
      $responseBody = self::_update(ZoneGroup::RESOURCE_PATH . '/' . $this->id, null, $body);

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
      self::_delete(ZoneGroup::RESOURCE_PATH . '/' . $this->id);

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
     * Attach zones to the current group zone group by providing zone ids.
     *
     * @param array $zoneIds The ids of the zones you want to attach
     * @return void
     */
    public function attachZones(array $zoneIds = []) 
    {   
      // Create body using keys required by API
      $body = ['zone_ids' => $zoneIds];

        // Execute
      $responseBody = self::_update(ZoneGroup::RESOURCE_PATH . '/' . $this->id . '/attach', null, $body, true);

      // Update local properties to new ones returned by APIs
      $this->updateAttributes($responseBody);
    }

    /**
     * Detach zones from the current group zone group by providing zone ids.
     *
     * @param array $zoneIds The ids of the zones you want to detach
     * @return void
     */
    public function detachZones(array $zoneIds = []) 
    {   
      // Create body using keys required by API
      $body = ['zone_ids' => $zoneIds];

        // Execute
      $responseBody = self::_update(ZoneGroup::RESOURCE_PATH . '/' . $this->id . '/detach', null, $body, true);

      // Update local properties to new ones returned by APIs
      $this->updateAttributes($responseBody);
    }


    /**
     * Maps properties from API to new zone group object attributes.
     *
     * @param array $body 
     * @return Adyo\ZoneGroup
     */
    public static function mapToAttributes($body) 
    {
        $zoneGroup = new ZoneGroup;

        foreach ($body as $key => $value) {

        
        if (in_array($key, self::$attributes)) {

          // All properties must map directly to attributes except for zones, we need to create zone objects
          if ($key === 'zones') {

            $zones = [];

            foreach ($value as $zoneKey => $zoneArray) {

              $zones[] = Zone::mapToAttributes($zoneArray);
            }

            $zoneGroup->zones = $zones;

          } else {

            // Normal key and value
            $zoneGroup->{$key} = $value;
          }
        }
      }

      return $zoneGroup;
    }

    /**
     * Maps properties from API to the current zone group object attributes.
     *
     * @param array $body 
     * @return void
     */
    private function updateAttributes($body) 
    {
        foreach ($body as $key => $value) {

        if (in_array($key, self::$attributes)) {
          
          // All properties must map directly to attributes except for zones, we need to create zone objects
          if ($key === 'zones') {

            $zones = [];

            foreach ($value as $zoneKey => $zoneArray) {

              $zones[] = Zone::mapToAttributes($zoneArray);
            }

            $this->zones = $zones;

          } else {

            // Normal key and value
            $this->{$key} = $value;
          }  
        }
      }
    }
  }