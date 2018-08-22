<?php

namespace App\Formatters;

use Illuminate\Database\Eloquent\Model;
use App\Formatters\Resources;

class Resource {

    public static function format (Model $resource, $namespace) {
        
        $format = json_decode(json_encode($namespace::$apiFormat), false);
        $record = [];        
        $json = [];

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

        foreach ($format->include as $relation => $name) {                            
            
            if ($resource->relationLoaded($relation)) {
                $related = $resource->getRelation($relation);
                
                if (get_class($related) == 'Illuminate\Database\Eloquent\Collection') {
                    $included = Resources::include($related, $name);

                    foreach ($included as $resource) {
                        $record['included'][] = $resource;
                    }

                } else {
                    $record['included'][] = self::include($related, $name);
                }
            }
        }      

        return $record;
    }

    public static function include (Model $resource, $namespace) {
        $format = json_decode(json_encode($namespace::$apiFormat), false);
        $record = [];        
        $json = [];

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

        foreach ($format->include as $relation => $name) {
                
            if ($resource->relationLoaded($relation)) {
                $record['included'][] = self::include($resource->getRelation($relation), $name);
            }
        }      

        return $record;
    }
}

?>