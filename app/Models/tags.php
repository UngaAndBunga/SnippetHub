<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tags extends Model
{
    use HasFactory;

    public $incrementing = false;

    // Set the primary key type to integer
    protected $keyType = 'int';

    // Define the primary key as an array for composite keys
    protected $primaryKey = ['id', 'post_id'];

    // Indicate that the primary keys are not auto-incrementing
   

    // Optional: Define the table if it's not the pluralized form of the model name
    protected $table = 'tags';

    // Define the attributes that are mass assignable
    protected $fillable = [
        
        'tag_name',
        
    ];
    
    /**
     * Get the post that owns the tag.
     */
  
    
    
    
    
     public function postsTags() {
        return $this->hasMany('App\Models\post_tags');
    }
    // Override the setKeysForSaveQuery method to handle composite keys
    protected function setKeysForSaveQuery($query)
    {
        $keys = $this->getKeyName();
        if(!is_array($keys)) {
            return parent::setKeysForSaveQuery($query);
        }

        foreach($keys as $keyName) {
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    // Method to get the key for the save query
    protected function getKeyForSaveQuery($keyName = null)
    {
        if (is_null($keyName)) {
            $keyName = $this->getKeyName();
        }

        return $this->original[$keyName] ?? $this->getAttribute($keyName);
    }
}
