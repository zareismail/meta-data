<?php

namespace Zareismail\MetaData;
 

trait HasMetadata
{  
	public function metadatas()
	{
		return $this->morphToMany(Metadata::class, 'has_metadata', 'metadatas')
				    ->withPivot('value', 'id', 'order');
	}
}
