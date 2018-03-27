<?php

namespace Adyo;

use Adyo\Adyo;

class Campaign extends ApiResource 
{
    /**
     * The API resource path to append to base url when making requests.
     *
     * @var string
     */
    const RESOURCE_PATH = 'campaigns';

    /**
     * Attributes available on the campaign
     *
     * @var array
     */
    protected static $attributes = [
      'id',
      'advertiser_id',
      'name',
      'created_at',
      'updated_at',

      // Counters
      'lifetime_impressions', 
      'monthly_impressions', 
      'daily_impressions', 
      'hourly_impressions', 
      'unique_lifetime_impressions', 
      'unique_monthly_impressions', 
      'unique_daily_impressions', 
      'unique_hourly_impressions', 
      'lifetime_clicks', 
      'monthly_clicks', 
      'daily_clicks', 
      'hourly_clicks', 
      'unique_lifetime_clicks', 
      'unique_monthly_clicks', 
      'unique_daily_clicks', 
      'unique_hourly_clicks',  
      'lifetime_ctr', 
      'monthly_ctr', 
      'daily_ctr', 
      'hourly_ctr', 
      'unique_lifetime_ctr', 
      'unique_monthly_ctr', 
      'unique_daily_ctr', 
      'unique_hourly_ctr',

      // Expanded Objects
      'advertiser',
    ];

    /**
     * Create a new campaign with the provided properties.
     *
     * @param array|null $body The properties of the campaign
     * @return Adyo\Campaign $campaign A new campaign object with set properties
     */
    public static function create($body = null)
    { 
      $responseBody = self::_create(Campaign::RESOURCE_PATH, null, $body);

      return self::mapToAttributes($responseBody);
    }

    /**
     * Retrieve a specific campaign.
     *
     * @param int $id The id of the campaign.
     * @param array $params Params to include in query
     * @return Adyo\Campaign $campaign A new campaign object with set properties
     */
    public static function retrieve($id, $params = [])
    { 
      $responseBody = self::_retrieve(Campaign::RESOURCE_PATH . '/' . $id, $params);

      return self::mapToAttributes($responseBody);
    }

    /**
     * Retrieve all campaigns using pagination.
     *
     * @param array $params Params to include in query
     * @return Adyo\Campaign $campaign A new campaign object with set properties
     */
    public static function retrieveAll($params = [])
    { 

      // Execute
      $responseBody = self::_retrieveAll(Campaign::RESOURCE_PATH, $params);
      
      // Work on response
      $pagination = $responseBody['pagination'];

      // Loop through each response object in data and create campaign objects
      $campaigns = [];

      foreach ($responseBody['data'] as $body) {
        $campaigns[] = self::mapToAttributes($body);
      }

      // Create new list and add campaigns to list
      $list = new AdyoList($campaigns,
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
     * Save (update) the current campaign. 
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

      // Execute
      $responseBody = self::_update(Campaign::RESOURCE_PATH . '/' . $this->id, null, $body);

      // Update local properties to new ones returned by APIs
      $this->updateAttributes($responseBody);
    }

    /**
     * Deletes the current campaign.
     *
     * @return void
     */
    public function delete()
    {   
      // Execute
      self::_delete(Campaign::RESOURCE_PATH . '/' . $this->id);

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
     * Maps properties from API to new campaign object attributes
     *
     * @param array $body 
     * @return Adyo\Campaign
     */
    public static function mapToAttributes($body) 
    {
      $campaign = new Campaign;

      foreach ($body as $key => $value) {

        if ($key === 'advertiser') {
          $campaign->{$key} = Advertiser::mapToAttributes($value);
        } else if (in_array($key, self::$attributes)) {
          $campaign->{$key} = $value;
        }
      }

      return $campaign;
    }

    /**
     * Maps properties from API to the current campaign object attributes
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