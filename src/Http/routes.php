<?php
/*
 * @Author: ivan@pupupula.com
 * @Date: 2023-04-04 11:40:58
 * @LastEditors: ivan@pupupula.com
 * @LastEditTime: 2023-04-06 19:12:39
 * @Description: 
 */

use Ivan\DragSortable\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::post('extension/grid-drag-sortable', Controllers\DragSortableController::class.'@sort');