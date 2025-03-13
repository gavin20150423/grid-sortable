<?php

namespace Dcat\Admin\GridSortable\Http\Controllers;

use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class GridSortableController extends Controller
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
            $models = $repository::find($sorts->keys());
            foreach ($models as $model) {
                $column = data_get($model->sortable, 'order_column_name', 'order_column');
                $model->{$column} = $sorts->get($model->getKey());
                $model->save();
            }
        } catch (\Exception $exception) {
            $status  = false;
            $message = $exception->getMessage();
        }

        return response()->json(compact('status', 'message'));
    }
}