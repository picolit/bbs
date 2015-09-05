<?php namespace App\Orm;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Photo
 * @package App\Orm
 */
class Photo extends Model
{
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo('App\Orm\Article');
    }
}
