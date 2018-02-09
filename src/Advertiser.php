<?php

namespace Adyo;

use Adyo\Adyo;

class Advertiser extends ApiResource 
{
    /**
     * The API resource path to append to base url when making requests.
     *
     * @var string
     */
    const RESOURCE_PATH = 'advertisers';

    /**
     * Attributes available on the advertiser
     *
     * @var array
     */
    protected static $attributes = [
      'id',
      'name',
      'created_at',
      'updated_at'
    ];

    /**
     * Create a new advertiser with the provided properties.
     *
     * @param array|null $body The properties of the advertiser
     * @return Adyo\Advertiser $advertiser A new advertiser object with set properties
     */
    public static function create($body = null)
    {	
    	$responseBody = self::_create(Advertiser::RESOURCE_PATH, null, $body);

    	return self::mapToAttributes($responseBody);
    }

    /**
     * Retrieve a specific advertiser.
     *
     * @param int $id The id of the advertiser.
     * @param array $params Params to include in query
     * @return Adyo\Advertiser $advertiser A new advertiser object with set properties
     */
    public static function retrieve($id, $params = [])
    {	
    	$responseBody = self::_retrieve(Advertiser::RESOURCE_PATH . '/' . $id, $params);

    	return self::mapToAttributes($responseBody);
    }

    /**
     * Retrieve all advertisers using pagination.
     *
     * @param array $params Params to include in query
     * @return Adyo\Advertiser $advertiser A new advertiser object with set properties
     */
    public static function retrieveAll($params = [])
    { 
      
      // Execute
      $responseBody = self::_retrieveAll(Advertiser::RESOURCE_PATH, $params);
      
      // Work on response
      $pagination = $responseBody['pagination'];

      // Loop through each response object in data and create advertiser objects
      $advertisers = [];

      foreach ($responseBody['data'] as $body) {
        $advertisers[] = self::mapToAttributes($body);
      }

      // Create new list and add advertisers to list
      $list = new AdyoList($advertisers,
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
     * Save (update) the current advertiser. 
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
      $responseBody = self::_update(Advertiser::RESOURCE_PATH . '/' . $this->id, null, $body);

        // Update local properties to new ones returned by APIs
      $this->updateAttributes($responseBody);
    }

    /**
     * Deletes the current advertiser.
     *
     * @return void
     */
    public function delete()
    {   
        // Execute
      self::_delete(Advertiser::RESOURCE_PATH . '/' . $this->id);

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
     * Maps properties from API to new advertiser object attributes
     *
     * @param array $body 
     * @return Adyo\Advertiser
     */
    public static function mapToAttributes($body) 
    {
    	$advertiser = new Advertiser;

    	foreach ($body as $key => $value) {

        if (in_array($key, self::$attributes)) {
          $advertiser->{$key} = $value;
        }
      }

      return $advertiser;
    }

    /**
     * Maps properties from API to the current advertiser object attributes
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