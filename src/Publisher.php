<?php

namespace Adyo;

use Adyo\Adyo;

class Publisher extends ApiResource 
{
    /**
     * The API resource path to append to base url when making requests.
     *
     * @var string
     */
    const RESOURCE_PATH = 'publishers';

    /**
     * Attributes available on the publisher
     *
     * @var array
     */
    protected static $attributes = [
      'id',
      'name',
      'created_at',
      'updated_at',
    ];

    /**
     * Create a new publisher with the provided properties.
     *
     * @param array|null $body The properties of the publisher
     * @return Adyo\Publisher $publisher A new publisher object with set properties
     */
    public static function create($body = null)
    {   
        $responseBody = self::_create(Publisher::RESOURCE_PATH, null, $body);

        return self::mapToAttributes($responseBody);
    }

    /**
     * Retrieve a specific publisher.
     *
     * @param int $id The id of the publisher.
     * @param array $params Params to include in query
     * @return Adyo\Publisher $publisher A new publisher object with set properties
     */
    public static function retrieve($id, $params = [])
    {   
        $responseBody = self::_retrieve(Publisher::RESOURCE_PATH . '/' . $id, $params);

        return self::mapToAttributes($responseBody);
    }

    /**
     * Retrieve all publishers using pagination.
     *
     * @param array $params Params to include in query
     * @return Adyo\Publisher $publisher A new publisher object with set properties
     */
    public static function retrieveAll($params = [])
    { 

      // Execute
      $responseBody = self::_retrieveAll(Publisher::RESOURCE_PATH, $params);
      
      // Work on response
      $pagination = $responseBody['pagination'];

      // Loop through each response object in data and create publisher objects
      $publishers = [];

      foreach ($responseBody['data'] as $body) {
        $publishers[] = self::mapToAttributes($body);
      }

      // Create new list and add publishers to list
      $list = new AdyoList($publishers,
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
     * Save (update) the current publisher. 
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
      $responseBody = self::_update(Publisher::RESOURCE_PATH . '/' . $this->id, null, $body);

        // Update local properties to new ones returned by APIs
      $this->updateAttributes($responseBody);
    }

    /**
     * Deletes the current publisher.
     *
     * @return void
     */
    public function delete()
    {   
        // Execute
      self::_delete(Publisher::RESOURCE_PATH . '/' . $this->id);

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
     * Maps properties from API to new publisher object attributes
     *
     * @param array $body 
     * @return Adyo\Publisher
     */
    public static function mapToAttributes($body) 
    {
        $publisher = new Publisher;

        foreach ($body as $key => $value) {

        if (in_array($key, self::$attributes)) {
          $publisher->{$key} = $value;
        }
      }

      return $publisher;
    }

    /**
     * Maps properties from API to the current publisher object attributes
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