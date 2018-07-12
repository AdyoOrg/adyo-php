<?php

namespace Adyo;

use Adyo\Adyo;

class Creative extends ApiResource 
{
    /**
     * The API resource path to append to base url when making requests.
     *
     * @var string
     */
    const RESOURCE_PATH = 'creatives';

    /**
     * Attributes available on the creative
     *
     * @var array
     */
    protected static $attributes = [
      'id',
      'advertiser_id',
      'type',
      'name',
      'description',
      'url',
      'destination_url',
      'alt_text',
      'third_party_pixel_url',
      'width',
      'height',

      // Video Specific
      'video_frame_rate',
      'video_duration',

      // Text Specific
      'title',
      'body',

      // Tag Specific
      'html',
      'tag_domain',

      'created_at',
      'updated_at',

      // Expanded Objects
      'advertiser',
    ];

    /**
     * Create a new creative with the provided properties.
     *
     * @param array|null $body The properties of the creative
     * @return Adyo\Creative $creative A new creative object with set properties
     */
    public static function create($body = null)
    {   
        $responseBody = self::_create(Creative::RESOURCE_PATH, null, $body, true);

        return self::mapToAttributes($responseBody);
    }

    /**
     * Retrieve a specific creative.
     *
     * @param int $id The id of the creative.
     * @param array $params Params to include in query
     * @return Adyo\Creative $creative A new creative object with set properties
     */
    public static function retrieve($id, $params = [])
    {   
        $responseBody = self::_retrieve(Creative::RESOURCE_PATH . '/' . $id, $params);

        return self::mapToAttributes($responseBody);
    }

    /**
     * Retrieve all creatives using pagination.
     *
     * @param int $page The page offset to use
     * @param array $params Params to include in query
     * @return Adyo\Creative $creative A new creative object with set properties
     */
    public static function retrieveAll($params = [])
    { 
      // Execute
      $responseBody = self::_retrieveAll(Creative::RESOURCE_PATH, $params);
      
      // Work on response
      $pagination = $responseBody['pagination'];

      // Loop through each response object in data and create creative objects
      $creatives = [];

      foreach ($responseBody['data'] as $body) {
        $creatives[] = self::mapToAttributes($body);
      }

      // Create new list and add creatives to list
      $list = new AdyoList($creatives,
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
     * Save (update) the current creative. 
     *
     * @return void
     */
    public function save() 
    {   
      // Create body using keys required by API
      $body = [];

      foreach (self::$attributes as $attributeName) {

        // Ignore advertiser
        if ($attributeName === 'advertiser') {
          continue;
        }

        if (property_exists($this, $attributeName)) {
          $body[$attributeName] = $this->{$attributeName};
        }
      }

      // Check for 'file' attribute
      if (property_exists($this, 'file')) {
        $body['file'] = $this->file;
      }

      // Execute
      $responseBody = self::_update(Creative::RESOURCE_PATH . '/' . $this->id, null, $body, true, true);

      // Update local properties to new ones returned by APIs
      $this->updateAttributes($responseBody);
    }

    /**
     * Deletes the current creative.
     *
     * @return void
     */
    public function delete()
    {   
        // Execute
      self::_delete(Creative::RESOURCE_PATH . '/' . $this->id);

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
     * Maps properties from API to new creative object attributes
     *
     * @param array $body 
     * @return Adyo\Creative
     */
    public static function mapToAttributes($body) 
    {
        $creative = new Creative;

        foreach ($body as $key => $value) {

          if ($key === 'advertiser') {
            $creative->{$key} = Advertiser::mapToAttributes($value);
          } else if (in_array($key, self::$attributes)) {
            $creative->{$key} = $value;
          }
        }

      return $creative;
    }

    /**
     * Maps properties from API to the current creative object attributes
     *
     * @param array $body 
     * @return void
     */
    private function updateAttributes($body) 
    {
        foreach ($body as $key => $value) {

        if ($key === 'advertiser') {
          $this->{$key} = Advertiser::mapToAttributes($value);
        } else if (in_array($key, self::$attributes)) {
          $this->{$key} = $value;
        }
      }
    }
  }