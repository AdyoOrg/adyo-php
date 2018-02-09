<?php

namespace Adyo;

use Adyo\Adyo;

class AdSize extends ApiResource 
{
    /**
     * The API resource path to append to base url when making requests.
     *
     * @var string
     */
    const RESOURCE_PATH = 'ad-sizes';

    /**
     * Attributes available on the ad size
     *
     * @var array
     */
    protected static $attributes = [
      'id',
      'name',
      'width',
      'height',
      'created_at',
      'updated_at'
    ];

    /**
     * Create a new ad size with the provided properties.
     *
     * @param array|null $body The properties of the ad size
     * @return \Adyo\AdSize $adSize A new ad size object with set properties
     */
    public static function create($body = null)
    {   
        $responseBody = self::_create(AdSize::RESOURCE_PATH, null, $body);

        return self::mapToAttributes($responseBody);
    }

    /**
     * Retrieve a specific ad size.
     *
     * @param int $id The id of the ad size.
     * @param array $params Params to include in query
     * @return \Adyo\AdSize $adSize A new ad size object with set properties
     */
    public static function retrieve($id, $params = [])
    {   
        $responseBody = self::_retrieve(AdSize::RESOURCE_PATH . '/' . $id, $params);

        return self::mapToAttributes($responseBody);
    }

    /**
     * Retrieve all ad sizes using pagination.
     *
     * @param array $params Params to include in query
     * @return \Adyo\AdSize $adSize A new ad sizes object with set properties
     */
    public static function retrieveAll($params = [])
    { 
      // Execute
      $responseBody = self::_retrieveAll(AdSize::RESOURCE_PATH, $params);
      
      // Work on response
      $pagination = $responseBody['pagination'];

      // Loop through each response object in data and create ad size objects
      $adSizes = [];

      foreach ($responseBody['data'] as $body) {
        $adSizes[] = self::mapToAttributes($body);
      }

      // Create new list and add ad sizes to list
      $list = new AdyoList($adSizes,
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
     * Save (update) the current ad size. 
     *
     * @return void
     */
    public function save() 
    {   
        // Create body using keys required by API
      $body = [];

      foreach (self::$attributes as $attributeName) {
        
        if (property_exists($this, $attributeName)) {
          $body[$attributeName] = $this->{$attributeName};
        }
      }

        // Execute
      $responseBody = self::_update(AdSize::RESOURCE_PATH . '/' . $this->id, null, $body);

        // Update local properties to new ones returned by APIs
      $this->updateAttributes($responseBody);
    }

    /**
     * Deletes the current ad size.
     *
     * @return void
     */
    public function delete()
    {   
        // Execute
      self::_delete(AdSize::RESOURCE_PATH . '/' . $this->id);

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
     * Maps properties from API to new ad size object attributes
     *
     * @param array $body 
     * @return Adyo\AdSize
     */
    public static function mapToAttributes($body) 
    {
        $adSize = new AdSize;

        foreach ($body as $key => $value) {

        if (in_array($key, self::$attributes)) {
          $adSize->{$key} = $value;
        }
      }

      return $adSize;
    }

    /**
     * Maps properties from API to the current ad size object attributes
     *
     * @param array $body 
     * @return void
     */
    private function updateAttributes($body) 
    {
        foreach ($body as $key => $value) {

        if (in_array($key, self::$attributes)) {
          $this->{$key} = $value;
        }
      }
    }
  }