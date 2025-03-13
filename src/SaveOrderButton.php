<?php

namespace Dcat\Admin\GridSortable;

use Dcat\Admin\Admin;
use Dcat\Admin\Grid\Tools\AbstractTool;

class SaveOrderButton extends AbstractTool
{
    protected $sortColumn;

    public function __construct($column)
    {
        $this->sortColumn = $column;
    }

    protected function script()
    {
        $route = admin_base_path('grid-sort');
        $repository = $this->parent->model()->repository();

        // 尝试从 Grid 直接获取模型类名
        $class = get_class($this->parent->model()->getModel());

        // 如果上面获取失败，尝试其他方式
        if (!$class || $class === 'Dcat\Admin\Grid\Model') {
            if (method_exists($repository, 'model')) {
                $class = get_class($repository->model());
            } elseif (property_exists($repository, 'eloquentClass')) {
                $class = $repository->eloquentClass;
            } else {
                throw new \Exception('Unable to determine model class');
            }
        }
        $class = str_replace('\\', '\\\\', $class);

        $script = <<<JS
        $('.grid-save-order-btn').click(function () {
            $.post({
                url: '{$route}',
                data: {
                    _token: Dcat.token,
                    _model: '{$class}',
                    _sort: $(this).data('sort'),
                    _column: '{$this->sortColumn}',
                },
                success: function(data){
                    if (data.status) {
                        Dcat.success(data.message);
                        Dcat.reload();
                    } else {
                        Dcat.error(data.message);
                        Dcat.reload();
                    }
                },
                error: function(data){
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

        $text = admin_trans_label('Save order');

        return <<<HTML
<button type="button" class="btn btn-primary btn-custom grid-save-order-btn" style="margin-left:8px;display:none;">
    <i class="fa fa-save"></i><span class="hidden-xs">&nbsp;&nbsp;{$text}</span>
</button>
HTML;
    }
}
