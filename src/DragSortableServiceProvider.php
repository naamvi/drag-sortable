<?php
/*
 * @Author: ivan@pupupula.com
 * @Date: 2023-04-04 11:18:23
 * @LastEditors: ivan@pupupula.com
 * @LastEditTime: 2023-04-04 17:43:30
 * @Description: 
 */

namespace Ivan\DragSortable;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Grid;

class DragSortableServiceProvider extends ServiceProvider
{
    protected $js = [
        'js/sortable.min.js',
    ];
	
    protected $column = '__sortable__';

    public function register()
    {
        //
    }

    public function init()
    {
        parent::init();

        $column = $this->column;

        Grid::macro('sortable', function ($sortName = null, $sortBy = 'asc') use ($column) {
            if ($sortName === null) {
                $sortName = $this->model()->repository()->model()->determineOrderColumnName();
            }

            /* @var $this Grid */
            $this->tools(new SaveOrderButton($sortName, $sortBy));

            if (!request()->has($sortName)) {
                $this->model()->ordered();
            }

            $this->column($column, ' ')
                ->displayUsing(SortableDisplay::class, [$sortName]);
        });
    }
}
