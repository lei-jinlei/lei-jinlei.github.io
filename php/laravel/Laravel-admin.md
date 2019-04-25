# Laravel-admin

### 隐藏按钮
Form
```
    // 表单bottom
    $form->disableReset();
    $form->disableEditingCheck();
    $form->disableViewCheck();
    
    // 表单右上角
    $form->tools(function (Form\Tools $tools) {
        $tools->disableDelete();
        $tools->disableView();
    });

```

Grid
```
    // 表单右上角
    $grid->disableExport();
    $grid->disableCreation();
    
    // 操作按钮
    $grid->actions(function (Grid\Displayers\Actions $actions) {
        $actions->disableDelete();
        $actions->disableEdit();
        $resDemand = Demand::find($actions->getKey());
        $edit_html='';
        //通过
        if($resDemand->status==1){
            $edit_html.="<span class='mb-5'><a class='grid-row-pass' title='通过' data-id='{$actions->getKey()}'><i class='glyphicon glyphicon-ok'></i></a></span>";

        $actions->append($edit_html);
    });
    
    // 批量操作
    $grid->tools(function (Grid\Tools $tools) {
        $tools->batch(function (Grid\Tools\BatchActions $actions) {
            $actions->disableDelete();
        });
    });
    
```
Show
```
    //表单右上角
    $show->panel()->tools(function ($tools){
        $tools->disableDelete();
        $tools->disableEdit();
    });

```