<?php

namespace Zareismail\MetaData;

use Illuminate\Database\Eloquent\Model;

class Metadata extends Model
{  
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'json',
        'resource' => 'json',
    ]; 
}
