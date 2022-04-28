<?php
namespace App\Services;

use App\Models\Property;
use App\Models\SearchProfile;

class MatchService
{

    public function getMatched($propertyId)
    {
        //getting the property with th given id
        $property = Property::findOrFail($propertyId);

        //initializing search profile array
        $searchProfiles = array();
        //getting all search profile that matches the given property and performing necessary calculations
        SearchProfile::where("property_type_id", $property->property_type_id)->chunk(100, function ($profiles) use (&$property, &$searchProfiles) {
            foreach ($profiles as $profile) {
                $this->matchPropertyToProfile($property, $profile);
                $profile->score = $profile->strictMatchesCount + $profile->looseMatchesCount;
                $searchProfiles[] = $profile;
            }

        });
        return $searchProfiles;
    }
    private function matchPropertyToProfile($property, $profile)
    {
        $strictMatchesCount = 0;
        $looseMatchesCount = 0;
        $matchesCount = 0;
        $property_fields = (json_decode($property->fields, true));
        $search_fields = (json_decode($profile->search_fields, true));

        foreach ($search_fields as $key => $value) {
            if (in_array($key, array_keys($property_fields))) {
                $field = $property_fields[$key];

                if (!empty($value)) {

                    if ($this->looseMatches($field, $value)) {
                        $looseMatchesCount++;
                    }

                    if ($this->strictMatches($field, $value)) {
                        $strictMatchesCount++;
                    }

                }
                $matchesCount++;

            }
        }

        $profile->matchesCount = $matchesCount;
        $profile->looseMatchesCount = $looseMatchesCount;
        $profile->strictMatchesCount = $strictMatchesCount;

    }

    private function strictMatches($field, $value): bool
    {

        if (is_array($value) && count($value) == 2) {

            $first_search_key = empty($value[0]) ? 0 : (float) $value[0];
            $second_search_key = empty($value[1]) ? 0 : (float) $value[1];

            if ($first_search_key == 0 && $second_search_key == 0) {
                return false;
            }

            if ($this->matched($field, $first_search_key, $second_search_key)) {
                return true;
            }
        } else {

            if ($field == $value) {
                return true;
            }

        }

        return false;
    }

    private function looseMatches($field, $value): bool
    {
        if (is_array($value) && count($value) == 2) {

            $first_search_key = is_null($value[0]) ? 0 : (float) $value[0];
            $second_search_key = is_null($value[1]) ? 0 : (float) $value[1];
            if ($first_search_key == 0 && $second_search_key == 0) {
                return false;
            }

            $loose_first_key = $first_search_key - ((25 / 100) * $first_search_key);
            $loose_second_key = $second_search_key + ((25 / 100) * $second_search_key);

            if ($this->matched($field, $loose_first_key, $loose_second_key)) {
                return true;
            }

        } else {
            //  if it matches directly
            if (preg_match("/\b$field\b/", (string) $value)) {
                return true;
            }
        }

        return false;
    }

    private function matched($value, $first_key, $second_key): bool
    {
        if (($value >= $first_key) && ($value <= $second_key)) {
            return true;
        }

        return false;
    }
}
