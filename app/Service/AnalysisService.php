<?php namespace App\Service;

use App\Orm\Analysis;
use Illuminate\Support\Facades\DB;

/**
 * Class AnalysisService
 * @package App\Service
 */
class AnalysisService
{
    /** @var Analysis */
    protected $analysis;

    private $date;

    /**
     * Constructor
     * @param Analysis $analysis
     */
    public function __construct(Analysis $analysis)
    {
        $this->analysis = $analysis;
        $this->date = date('Ymd');
        $this->existRecord();
    }

    /**
     * page_viewインクリメント
     */
    public function pageViewIncrement()
    {
        DB::update('update analyses set page_view = page_view + 1, updated_at = now() where date = ?', [$this->date]);
    }

    /**
     * new_postインクリメント
     */
    public function newPostIncrement()
    {
        DB::update('update analyses set new_post = new_post + 1, updated_at = now() where date = ?', [$this->date]);
    }

    /**
     * レコード作成処理
     */
    private function existRecord()
    {
        $analysis = $this->analysis->where('date', $this->date)->first();
        if (empty($analysis)) {
            $analysis = $this->analysis->newInstance();
            $analysis->date = $this->date;
            $analysis->save();
        }

    }
}