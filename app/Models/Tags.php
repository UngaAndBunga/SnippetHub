<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * 
 *
 * @property string $tag_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $id
 * @method static Builder<static>|Tags newModelQuery()
 * @method static Builder<static>|Tags newQuery()
 * @method static Builder<static>|Tags query()
 * @method static Builder<static>|Tags whereCreatedAt($value)
 * @method static Builder<static>|Tags whereId($value)
 * @method static Builder<static>|Tags whereTagName($value)
 * @method static Builder<static>|Tags whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Tags extends MainModel
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'int';

    protected $primaryKey = ['id', 'post_id'];

    protected $table = 'tags';

    protected $fillable = [
        'tag_name',
    ];

    protected function setKeysForSaveQuery($query): Builder
    {
        $keys = $this->getKeyName();
        if (! is_array($keys)) {
            return parent::setKeysForSaveQuery($query);
        }

        foreach ($keys as $keyName) {
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
