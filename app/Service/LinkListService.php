<?php
namespace Service;

use App\Orm\LinkList;

/**
 * Class LisksService
 * @package Service
 */
class LinkListService
{
    /** @var LinkList  */
    private $linkList;

    /**
     * LisksService constructor.
     * @param LinkList $linkList
     */
    public function __construct(LinkList $linkList)
    {
        $this->linkList = $linkList;
    }

    /**
     *
     * @return mixed
     */
    public function get()
    {
        return $this->linkList->order_by()->all();
    }
}
