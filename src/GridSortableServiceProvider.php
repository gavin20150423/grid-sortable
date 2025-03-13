<?php

namespace Dcat\Admin\GridSortable;

use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Extend\ServiceProvider;

class GridSortableServiceProvider extends ServiceProvider
{
    protected $name = 'grid-sortable';
    protected $packageName = 'grid-sortable';
    protected $js = [
        'js/sortable2025.js'
    ];

    public function init()
    {
        parent::init();
        $column = '__sortable__';

        Grid::macro('sortable', function ($sortName = 'order') use ($column) {
            /* @var $this Grid */
            $this->tools(new SaveOrderButton($sortName));

            if (!request()->has($sortName)) {
                $this->model()->ordered();
            }

            $this->column($column, ' ')
                ->displayUsing(SortableDisplay::class, [$sortName]);
        });
    }
}