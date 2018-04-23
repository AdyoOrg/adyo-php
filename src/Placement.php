<?php

namespace Adyo;

use Adyo\Adyo;

class Placement extends ApiResource 
{
    /**
     * The API resource path to append to base url when making requests.
     *
     * @var string
     */
    const RESOURCE_PATH = 'placements';

    /**
     * Attributes available on the placement
     *
     * @var array
     */
    protected static $attributes = [
      'id',
      'campaign_id',
      'priority_id',
      'creative_ids',
      'name',
      'enabled',
      'html_target',
      'app_target',
      'delivery_method',
      'lifetime_dates_enabled',
      'lifetime_start',
      'lifetime_end',
      'lifetime_quota_enabled',
      'lifetime_quota_amount',
      'lifetime_quota_type',
      'under_delivery_behaviour',
      'pricing_enabled',
      'pricing_method',
      'rate_cpm',
      'rate_cpc',
      'rate_cpa',
      'fixed_cost',
      'publisher_payout_ratio',
      'per_user_limit_enabled',
      'per_user_limit_amount',
      'per_user_limit_type',
      'per_user_limit_period',
      'frequency_limit_enabled',
      'frequency_limit_amount',
      'frequency_limit_type',
      'frequency_limit_period',
      'keywords',
      'keyword_match_method',
      'zone_ids',
      'zone_group_ids',
      'zone_all_ids',
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
      'campaign',
      'priority',
      'creatives',
      'zones',
      'zone_groups',
    ];

    /**
     * Create a new placement with the provided properties.
     *
     * @param array|null $body The properties of the placement
     * @return Adyo\Placement $placement A new placement object with set properties
     */
    public static function create($body = null)
    { 
      $responseBody = self::_create(Placement::RESOURCE_PATH, null, $body);

      return self::mapToAttributes($responseBody);
    }

    /**
     * Retrieve a specific placement.
     *
     * @param int $id The id of the placement.
     * @param array $params Params to include in query
     * @return Adyo\Placement $placement A new placement object with set properties
     */
    public static function retrieve($id, $params = [])
    { 
      $responseBody = self::_retrieve(Placement::RESOURCE_PATH . '/' . $id, $params);

      return self::mapToAttributes($responseBody);
    }

    /**
     * Retrieve all placements using pagination.
     *
     * @param array $params Params to include in query
     * @return Adyo\Placement $placement A new placement object with set properties
     */
    public static function retrieveAll($params = [])
    { 
      // Execute
      $responseBody = self::_retrieveAll(Placement::RESOURCE_PATH, $params);
      
      // Work on response
      $pagination = $responseBody['pagination'];

      // Loop through each response object in data and create placement objects
      $placements = [];

      foreach ($responseBody['data'] as $body) {
        $placements[] = self::mapToAttributes($body);
      }

      // Create new list and add placements to list
      $list = new AdyoList($placements,
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
     * Save (update) the current placement. 
     *
     * @return void
     */
    public function save() 
    { 

      // Create body using keys required by API
      $body = [];

      // Loop through all attributes and save
      foreach (self::$attributes as $attributeName) {

        // Ignore expanded attributes
        if (in_array($attributeName, ['campaign', 'priority', 'creatives', 'zones', 'zone_groups'])) {
          continue;
        }

        if (property_exists($this, $attributeName)) {
          $body[$attributeName] = $this->{$attributeName};
        }
      }
      
      // Execute
      $responseBody = self::_update(Placement::RESOURCE_PATH . '/' . $this->id, null, $body);

      // Update local properties to new ones returned by APIs
      $this->updateAttributes($responseBody);
    }

    /**
     * Deletes the current placement.
     *
     * @return void
     */
    public function delete()
    {   

      // Execute
      self::_delete(Placement::RESOURCE_PATH . '/' . $this->id);

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
     * Maps properties from API to new placement object attributes
     *
     * @param array $body 
     * @return Adyo\Placement
     */
    public static function mapToAttributes($body) 
    {
      $placement = new Placement;

      foreach ($body as $key => $value) {

        if ($key === 'campaign') {
        
          $placement->{$key} = Campaign::mapToAttributes($value);
        
        } else if ($key === 'priority') {
        
          $placement->{$key} = Priority::mapToAttributes($value);
        
        } else if ($key === 'creatives') {
          
          $creatives = [];

          foreach ($value as $creativeValue) {
            $creatives[] = Creative::mapToAttributes($creativeValue);
          }

          $placement->{$key} = $creatives;

        } else if ($key === 'zones') {
          
          $zones = [];

          foreach ($value as $zoneValue) {
            $zones[] = Zone::mapToAttributes($zoneValue);
          }

          $placement->{$key} = $zones;

        } else if ($key === 'zone_groups') {
          
          $zoneGroups = [];

          foreach ($value as $zoneGroupValue) {
            $zoneGroups[] = ZoneGroup::mapToAttributes($zoneGroupValue);
          }

          $placement->{$key} = $zoneGroups;

        } else if (in_array($key, self::$attributes)) {
          $placement->{$key} = $value;
        }
      }
      
      return $placement;
    }

    /**
     * Maps properties from API to the current placement object attributes
     *
     * @param array $body 
     * @return void
     */
    private function updateAttributes($body) 
    {
      foreach ($body as $key => $value) {

        if ($key === 'campaign') {
        
          $this->{$key} = Campaign::mapToAttributes($value);
        
        } else if ($key === 'priority') {
        
          $this->{$key} = Priority::mapToAttributes($value);
        
        } else if ($key === 'creatives') {
          
          $creatives = [];

          foreach ($value as $creativeValue) {
            $creatives[] = Creative::mapToAttributes($creativeValue);
          }

          $this->{$key} = $creatives;

        } else if ($key === 'zones') {
          
          $zones = [];

          foreach ($value as $zoneValue) {
            $zones[] = Zone::mapToAttributes($zoneValue);
          }

          $this->{$key} = $zones;

        } else if ($key === 'zone_groups') {
          
          $zoneGroups = [];

          foreach ($value as $zoneGroupValue) {
            $zoneGroups[] = ZoneGroup::mapToAttributes($zoneGroupValue);
          }

          $this->{$key} = $zoneGroups;

        } else if (in_array($key, self::$attributes)) {
          $this->{$key} = $value;
        }
      }
    }
}