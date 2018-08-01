<?php

namespace App\Formatters;

use Illuminate\Database\Eloquent\Collection;
use App\Formatters\Resource;

class Resources {
    
    public static function format (Collection $collection, $namespace) {

        $format = json_decode(json_encode($namespace::$apiFormat), false);
        $record = [];        
        $json = [];

        foreach ($collection as $resource) {

            $record['data']['type'] = $format->data->type;

            if (is_array($format->data->id)) {
                
                foreach ($format->data->id as $key => $primaries) {                    
                    $record['data']['id'][$key] = $primaries; 
                }

            } else {
                $record['data']['id'] = $resource->{$format->data->id};
            }

            foreach ($format->data->attributes as $key => $field) {
                $record['data']['attributes'][$key] = $resource->$field;
            }

            foreach ($format->data->relationships as $key => $field) {
                $record['data']['relationships'][$key]['type'] = $key;
                $record['data']['relationships'][$key]['id'] = $resource->$field;
            }

            $record['included'] = [];

            foreach ($format->include as $relation => $name) {
                
                if ($resource->relationLoaded($relation)) {
                    $related = $resource->getRelation($relation);
                
                    if (get_class($related) == 'Illuminate\Database\Eloquent\Collection') {
                        $included = self::include($related, $name);

                        foreach ($included as $resource) {
                            $record['included'][] = $resource;
                        }

                    } else {
                        $record['included'][] = Resource::include($related, $name);
                    }
                }
            }

            $json[] = $record;       
        }

        return $json;
    }

    public static function include (Collection $collection, $namespace) {
        $format = json_decode(json_encode($namespace::$apiFormat), false);
        $record = [];        
        $json = [];

        foreach ($collection as $resource) {

            $record['type'] = $format->data->type;

            if (is_array($format->data->id)) {
                
                foreach ($format->data->id as $key => $primaries) {                    
                    $record['id'][$key] = $primaries; 
                }

            } else {
                $record['id'] = $resource->{$format->data->id};
            }

            foreach ($format->data->attributes as $key => $field) {
                $record['attributes'][$key] = $resource->$field;
            }

            foreach ($format->data->relationships as $key => $field) {
                $record['relationships'][$key]['type'] = $key;
                $record['relationships'][$key]['id'] = $resource->$field;
            }

            $record['included'] = [];

            foreach ($format->include as $relation => $name) {
                
                if ($resource->relationLoaded($relation)) {
                    $record['included'][] = Resource::include($resource->getRelation($relation), $name);
                }
            }

            $json[] = $record;         
        }

        return $json;
    }
}

?>