<?php
/*
 * @Author: ivan@pupupula.com
 * @Date: 2023-04-04 11:23:57
 * @LastEditors: ivan@pupupula.com
 * @LastEditTime: 2023-04-06 19:12:18
 * @Description: 
 */

namespace Ivan\DragSortable;

use Dcat\Admin\Admin;
use Dcat\Admin\Grid\Tools\AbstractTool;

class SaveOrderButton extends AbstractTool
{
    protected $sortColumn;

    protected $sortBy;

    public function __construct($column = 'order', $sortBy = 'asc')
    {
        $this->sortColumn = $column;

        $this->sortBy = $sortBy;
    }

    protected function script()
    {
        $route = admin_base_path('extension/grid-drag-sortable');
        $model = $this->parent->model()->repository()->model();
        $class = get_class($model);
        $class = str_replace('\\', '\\\\', $class);
        
        $script = <<<JS

$('.grid-save-order-btn').click(function () {

    $('.grid-save-order-btn').buttonLoading();

    $.ajax({
        method: 'POST',
        url: '{$route}',
        data: {
            _token: Dcat.token,
            _model: '{$class}',
            _sort: $(this).data('sort'),
            _sortBy: '{$this->sortBy}',
            _column: '{$this->sortColumn}',
        }
    }).done(function(data){

        $('.grid-save-order-btn').buttonLoading(false);

        if (data.status) {
            Dcat.success(data.message);
            Dcat.reload();
        } else {
            Dcat.error(data.message);
        }
        
    });
});

JS;
        Admin::script($script);
    }

    public function render()
    {
        $this->script();

        $text = admin_trans_label('Save Order');

        return <<<HTML
<button type="button" class="btn btn-white grid-save-order-btn" style="margin-left:0px;display:none;">
    <i class="feather icon-refresh-cw"></i><span class="hidden-xs">&nbsp;&nbsp;{$text}</span>
</button>
HTML;
    }
}
