<?php

namespace App\Helpers\Traits;

use Illuminate\Support\Facades\DB;

trait HasCategoryFilters
{
    public function getCategoryFilters($category_id): array
    {
        $filter_groups = [];

        if ($category_id) {
            $ids = \App\Helpers\Category\Category::getIds($category_id) . $category_id;

            $category_filters = DB::table('category_filters')
                ->select(
                    'category_filters.filter_group_id',
                    'filter_groups.title',
                    'filters.id as filter_id',
                    'filters.title as filter_title'
                )
                ->join('filter_groups', 'category_filters.filter_group_id', '=', 'filter_groups.id')
                ->join('filters', 'filters.filter_group_id', '=', 'filter_groups.id')
                ->whereIn('category_filters.category_id', explode(',', $ids))
                ->get();

            foreach ($category_filters as $filter) {
                $filter_groups[$filter->filter_group_id][] = $filter;
            }
        }

        return $filter_groups;
    }

}
