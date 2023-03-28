<?php
declare(strict_types = 1);

namespace App\Model\Api;

/**
 * 书籍分类
 */
class StoreBookCategory extends \App\Model\Common\StoreBookCategory
{
    protected $appends = [
        "children",
    ];

    public function getChildrenAttribute()
    {
        $items = self::query()->where([
            ["parent_uuid", "=", $this->getAttribute("uuid")],
            ["is_show", "=", 1]
        ])->orderBy("orders")->get(["title", "uuid"]);
        if (!empty($items)) {
            $items     = $items->toArray();
            $bookModel = new StoreBookContent();
            foreach ($items as $key => $value) {
                $items[$key]["children"] = $bookModel::query()
                    ->where([
                        ["store_book_category_uuid", "=", $value["uuid"]],
                    ])->orderByDesc("orders")->get(["uuid", "title"]);
            }
        } else {
            $items["children"] = [];
        }
        return $items;
    }
}