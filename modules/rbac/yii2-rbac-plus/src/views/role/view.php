<?php

use johnitvn\rbacplus\models\Role;

$permissions = Role::getPermistions($model->name);
$first = '';
$rows = [];
foreach ($permissions as $permission) {
    if (empty($first)) {
        $first = $permission->name;
    } else {
        $rows[] = '<tr><td>' . $permission->name . '</td></tr>';
    }
}

$roles = [];
$tmp = Yii::$app->authManager->getAllChildrenByRole($model->name);
foreach ($tmp as $role) {
    if($role->type == \yii\rbac\Item::TYPE_ROLE)
        $roles[]=$role;
}

$firstRole = '';
$roleRows = [];
foreach ($roles as $role) {
    if (empty($firstRole)) {
        $firstRole = $role->name;
    } else {
        $roleRows[] = '<tr><td>' . $role->name . '</td></tr>';
    }
}

if(!Yii::$app->request->isAjax){
    $this->title = $model->name;
    $this->params['breadcrumbs'][] = ['label' => Yii::t('rbac', 'Roles Manager'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
    echo \yii\bootstrap\Html::tag('h1', $this->title);
}


?>
<div class="permistion-item-view">
    <table class="table table-striped table-bordered detail-view">
        <tbody>
            <tr><th><?= $model->attributeLabels()['name'] ?></th><td><?= $model->name ?></td></tr>
            <tr><th><?= $model->attributeLabels()['description'] ?></th><td><?= $model->description ?></td></tr>
            <tr><th><?= $model->attributeLabels()['ruleName'] ?></th><td><?= $model->ruleName == null ? '<span class="text-danger">' . Yii::t('rbac', '(not use)') . '</span>' : $model->ruleName ?></td></tr>
            <tr>
                <th rowspan="<?= count($roles) ?>" ><?= 'Child roles' ?></th>
                <td><?= $firstRole ?></td>
            </tr>
            <?= implode("", $roleRows) ?>

            <tr>
                <th rowspan="<?= count($permissions) ?>" ><?= $model->attributeLabels()['permissions'] ?></th>
                <td><?= $first ?></td>
            </tr>
            <?= implode("", $rows) ?>
    </table>
</div>
