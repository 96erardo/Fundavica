<?php

namespace App\QueryFilters;

use Cerbero\QueryFilters\QueryFilters;
use App\Models\Post;

class FiltersPost extends QueryFilters
{
    protected $implicitFilters = [
        'content',
    ];

    public function page ($page) {

        if( !empty($page) ) {
            
            $posts = Post::count();
            $page -= 1;
            $pages = ceil( $posts/10 );
            
            if ($page > $pages || $page < 0) {
                $offset = 0;
            } else {
                $offset = $page * 10;
            }
    
            $this->query->offset($offset)->limit(10);
        
        } else {
            
            $this->query->limit(10);
        }        
    }

    public function content () {
        $this->query->addSelect('contenido');
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

            if (in_array('comments', $relatedResources)) {
                
                $include['comments'] = function ($query) {
                    $query->where('respuesta_id', null)->limit(10);
                };
            }

            $this->query->with($include);
        }
    }
}
