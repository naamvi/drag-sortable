<?php
/*
 * @Author: ivan@pupupula.com
 * @Date: 2023-04-04 11:23:57
 * @LastEditors: ivan@pupupula.com
 * @LastEditTime: 2023-04-04 17:43:46
 * @Description: 
 */

namespace Ivan\DragSortable;

use Dcat\Admin\Admin;
use Dcat\Admin\Grid\Displayers\AbstractDisplayer;

class SortableDisplay extends AbstractDisplayer
{
    protected static $js = [
        '@naamvi.drag-sortable',
    ];

    protected function script()
    {
        $id = $this->grid->getTableId();

        $script = <<<JS
new Sortable($("#{$id} tbody")[0], {
    handle: '.grid-sortable-handle', // handle's class
    animation: 150,
    onUpdate: function () {
        var sorts = [], tb = $('#{$id}');
        tb.find('.grid-sortable-handle').each(function () {
            sorts.push($(this).data());
        });
        tb.closest('.row').first().find('.grid-save-order-btn').data('sort', sorts).show();
    },
});
JS;

        Admin::script($script);
    }

    protected function getRowSort($sortName)
    {
        return $this->row->{$sortName};
    }

    public function display($sortName = null)
    {
        $this->script();

        $key  = $this->getKey();
        $sort = $this->getRowSort($sortName);

        return <<<HTML
<a class="grid-sortable-handle" style="font-size:16px;cursor:move;white-space:nowrap;" data-key="{$key}" data-sort="{$sort}">
   <i class="feather icon-copy"></i>
</a>
HTML;
    }
}
