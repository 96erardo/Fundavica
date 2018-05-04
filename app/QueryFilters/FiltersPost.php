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
}
