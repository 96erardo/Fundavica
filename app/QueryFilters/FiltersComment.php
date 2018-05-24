<?php

namespace App\QueryFilters;

use Cerbero\QueryFilters\QueryFilters;

class FiltersComment extends QueryFilters
{
    public function include ($include) {
        
        if (!empty($include)) {

            $relatedResources = explode(',', $include);
            $include = [];

            if (in_array('user', $relatedResources)) {
                
                $include['user'] = function ($query) {
                    $query->select('id', 'nombre', 'usuario', 'role_id', 'estado_id')
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
