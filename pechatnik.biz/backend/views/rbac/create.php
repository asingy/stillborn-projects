<?php
$this->title = 'Создать роль';
$this->params['breadcrumbs'][] = ['label' => 'Роли поьзователей', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parts-create">

    <?= $this->render('_form', [
        'role'=>$role, 'roles'=>$roles, 'children'=>$children
    ]) ?>

</div>

