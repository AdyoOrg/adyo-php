<?php

namespace Adyo;

use Adyo\Adyo;

class Priority extends ApiResource 
{
    /**
     * The API resource path to append to base url when making requests.
     *
     * @var string
     */
    const RESOURCE_PATH = 'priorities';

    /**
     * Attributes available on the priority
     *
     * @var array
     */
    protected static $attributes = [
      'id',
      'name',
      'weight',
      'created_at',
      'updated_at',
    ];

    /**
     * Create a new priority with the provided properties.
     *
     * @param array|null $body The properties of the priority
     * @return Adyo\Priority $priority A new priority object with set properties
     */
    public static function create($body = null)
    { 
      $responseBody = self::_create(Priority::RESOURCE_PATH, null, $body);

      return self::mapToAttributes($responseBody);
    }

    /**
     * Retrieve a specific priority.
     *
     * @param int $id The id of the priority.
     * @param array $params Params to include in query
     * @return Adyo\Priority $priority A new priority object with set properties
     */
    public static function retrieve($id, $params = [])
    { 
      $responseBody = self::_retrieve(Priority::RESOURCE_PATH . '/' . $id, $params);

      return self::mapToAttributes($responseBody);
    }

    /**
     * Retrieve all priorities using pagination.
     *
     * @param array $params Params to include in query
     * @return Adyo\Priority $priority A new priority object with set properties
     */
    public static function retrieveAll($params = [])
    { 
      // Execute
      $responseBody = self::_retrieveAll(Priority::RESOURCE_PATH, $params);
      
      // Work on response
      $pagination = $responseBody['pagination'];

      // Loop through each response object in data and create priority objects
      $priorities = [];

      foreach ($responseBody['data'] as $body) {
        $priorities[] = self::mapToAttributes($body);
      }

      // Create new list and add priorities to list
      $list = new AdyoList($priorities,
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
     * Save (update) the current priority. 
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
      $responseBody = self::_update(Priority::RESOURCE_PATH . '/' . $this->id, null, $body);

        // Update local properties to new ones returned by APIs
      $this->updateAttributes($responseBody);
    }

    /**
     * Deletes the current priority.
     *
     * @return void
     */
    public function delete()
    {   
        // Execute
      self::_delete(Priority::RESOURCE_PATH . '/' . $this->id);

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
     * Maps properties from API to new priority object attributes
     *
     * @param array $body 
     * @return Adyo\Priority
     */
    public static function mapToAttributes($body) 
    {
      $priority = new Priority;

      foreach ($body as $key => $value) {

        if (in_array($key, self::$attributes)) {
          $priority->{$key} = $value;
        }
      }

      return $priority;
    }

    /**
     * Maps properties from API to the current priority object attributes
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