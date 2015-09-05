<?php namespace App\Orm;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

/**
 * Class Article
 * @package App\Orm
 */
class Article extends Model
{
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photos()
    {
        return $this->hasMany('App\Orm\Photo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function nices()
    {
        return $this->hasMany('App\Orm\Nice');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function interests()
    {
        return $this->belongsToMany('App\Orm\Interest');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function selfJoin()
    {
        return $this->hasMany('App\Orm\Article', 'res_id');
    }

    /**
     * @param Builder $query
     * @param array $conditions
     * @return mixed
     */
    public function scopeSearch(Builder $query, array $conditions)
    {
        // 都道府県
        if (isset($conditions['prefectures']) and $conditions['prefectures'] !== '0') {
            $query->where('prefectures', $conditions['prefectures']);
        }

        // 地域
//        if ($conditions['area'] and $conditions['area'] !== '0') {
//            $query->where('area', $conditions['area']);
//        }

        $hasInterests = false;
        $interests = Interest::all();
        $keys = array_keys($conditions);

        foreach ($interests as $row) {
            if (in_array($row->name_tag, $keys)) {
                $hasInterests = true;
                break;
            }
        }

        if ($hasInterests) {
            $query->whereHas('interests', function ($query) use ($conditions, $interests, $keys) {
                foreach ($interests as $row) {
                    if (in_array($row->name_tag, $keys)) {
                        $query->where('interests.id', $conditions[$row->name_tag]);
                    }
                }
            });
        }

        return $query;
    }

    /**
     * @param Builder $query
     * @return mixed
     */
    public function scopeSort(Builder $query)
    {
        return $query->orderBy('updated_at', 'desc');
    }
}
