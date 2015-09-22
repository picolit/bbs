<?php namespace App\Orm;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

/**
 * Class Article
 * @package App\Orm
 */
class Article extends Model
{
    use SoftDeletes;

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
        return $this->hasMany('App\Orm\Article', 'res_id')->orderBy('updated_at', 'desc');
    }

    /**
     * @param Builder $query
     * @param array $conditions
     * @return mixed
     */
    public function scopeSearch(Builder $query, array $conditions)
    {
        // 見た目
        if (isset($conditions['sex_s']) and $conditions['sex_s'] !== '0') {
            $query->where('sex', $conditions['sex_s']);
        }

        // 年代
        if (isset($conditions['age_s']) and $conditions['age_s'] !== '0') {
            $query->where('age', $conditions['age_s']);
        }

        // 都道府県
        if (isset($conditions['prefectures_s']) and $conditions['prefectures_s'] !== '0') {
            $query->where('prefectures', $conditions['prefectures_s']);
        }

        // 地域
        if (isset($conditions['area_s']) and $conditions['area_s'] !== '0') {
            $areas = config::get('const.area_prefectures');
            $areaPrefectures = $areas[$conditions['area_s']];
            $query->whereIn('prefectures', $areaPrefectures);
        }

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
                $interestCondition = [];
                foreach ($interests as $row) {
                    if (in_array($row->name_tag, $keys)) {
                        $interestCondition[] = $row->id;
                    }
                }
                $query->whereIn('interests.id', $interestCondition);
            });
        }

        $query->where('res_id', 0);

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
