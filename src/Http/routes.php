<?php
/*
 * @Author: ivan@pupupula.com
 * @Date: 2023-04-04 11:40:58
 * @LastEditors: ivan@pupupula.com
 * @LastEditTime: 2023-04-04 11:55:55
 * @Description: 
 */

use Ivan\DragSortable\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::post('ivan-drag-sortable', Controllers\DragSortableController::class.'@sort');