
<div align="center">

# DCAT-ADMIN GRID-SORTABLE 拖曳排序

</div>


<h3>适用于dcat-admin 2.x版本。</h3>

<h4>背景</h4>
<div>由于原插件是1.x版本的。2.x版本的这个插件，原作者貌似没有维护升级，正好我的一个项目使用了，有拖曳排序的需求，所以就动手撸了一个。</div>

<h4>安装</h4>
<div>
<ul>
    <li>下载zip压缩包，打开扩展管理页面，点击本地安装按钮选择提交上传安装包</li>
    <li>点击更新至1.0.0版本</li>
    <li>启动插件</li>

    需要使用拖曳排序的Model中增加:
    
    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    在对应的grid中增加:
    $grid->sortable();

    注意：
    数据库中的排序字段，需要初始化为不相同的数值，否则拖曳无效。可以参考sql语句(以tablename为表名,order为排序字段举例)
    SET @row_number = 0;
    UPDATE tablename 
    SET `order` = (@row_number:=@row_number + 1);
</ul>
</div>
<div>这样就大功告成了~</div>

<div>有问题可以联系我，QQ：215543942，或者提交issue</div>






