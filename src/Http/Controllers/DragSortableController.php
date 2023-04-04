<?php
/*
 * @Author: ivan@pupupula.com
 * @Date: 2023-04-04 11:18:23
 * @LastEditors: ivan@pupupula.com
 * @LastEditTime: 2023-04-04 11:25:15
 * @Description: 
 */

namespace Ivan\DragSortable\Http\Controllers;

use Dcat\Admin\Form;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DragSortableController extends Controller
{
    public function sort(Request $request)
    {
        $status = true;
        $column = $request->get('_column');
        $message = trans('admin.save_succeeded');
        $repository = $request->get('_model');

        $sorts = $request->get('_sort');
        $sorts = collect($sorts)
            ->pluck('key')
            ->combine(
                collect($sorts)->pluck('sort')->sort()
            );

        try {
            $sorts->each(function ($v, $k) use ($repository, $column) {
                $form = new Form(new $repository);

                $form->text($column);

                $form->update($k, [$column => $v]);
            });
        } catch (\Exception $exception) {
            $status  = false;
            $message = $exception->getMessage();
        }

        return response()->json(compact('status', 'message'));
    }
}