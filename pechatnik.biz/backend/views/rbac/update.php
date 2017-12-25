<?php
$this->title = 'Изменить роль';
$this->params['breadcrumbs'][] = ['label' => 'Роли пользователей', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parts-create">

    <?= $this->render('_form', [
        'role'=>$role, 'roles'=>$roles, 'children'=>$children, //'perm'=>$perm
    ]) ?>

</div>

