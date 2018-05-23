<?php

namespace App\QueryFilters;

use Cerbero\QueryFilters\QueryFilters;
use App\Models\Post;

class FiltersPost extends QueryFilters
{
    public function page ($page) {

        if( !empty($page) ) {
            
            $posts = Post::count();
            $pages = ceil( $posts/16 );
            
            if ($page > $pages || $page < 0) {
                $offset = 0;
            } else {
                $offset = $page * 16;
            }
    
            $this->query->offset($offset)->limit(16);
        
        } else {
            
            $this->query->limit(16);
        }        
    }

    public function include ($include) {
        
        if (!empty($include)) {

            $relatedResources = explode(',', $include);
            $include = [];

            if (in_array('user', $relatedResources)) {
                
                $include['user'] = function ($query) {
                    $query->select('id', 'nombre', 'apellido', 'correo', 'usuario', 'role_id', 'estado_id')
                        ->with(['role', 'status']);
                };
            }

            if (in_array('status', $relatedResources)) {

                $include['status'] = function ($query) {
                    $query->select('id', 'nombre_visible');
                };
            }

            if (in_array('category', $relatedResources)) {

                $include['category'] = function ($query) {
                    $query->select('id', 'nombre');
                };
            }

            $this->query->with($include);
        }
    }
}
