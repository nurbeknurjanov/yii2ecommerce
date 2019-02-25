<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use user\models\User;

$rules = Yii::$app->authManager->getRules();
$rulesNames = array_keys($rules);
$rulesDatas = array_merge(['' => Yii::t('rbac', '(not use)')], array_combine($rulesNames, $rulesNames));

$user = new User;
$authManager = Yii::$app->authManager;
$permissions = $authManager->getPermissions();
$roles = $authManager->getRoles();










$allParents = [];
if(isset($_GET['name']))
{
    $currentRole = $_GET['name'];
    unset($roles[$currentRole]);
    //$allChilds = Yii::$app->authManager->getAllChildrenByRole($currentRole);

    $allParents = $authManager->getAllParentsByRole($currentRole);

    foreach ($allParents as $role)
        unset($roles[$role->name]);
}


?>

<div class="auth-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'ruleName')->dropDownList($rulesDatas) ?>

    <div class="form-group field-role-permissions">
        <label class="control-label" for="role-permissions">Child roles</label>
        <input type="hidden" name="Role[permissions]" value="">
        <div id="role-permissions">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <td style="width:1px"></td>
                    <td style="width:1px"><b>Name</b></td>
                    <td><b>Description</b></td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($roles as $role): ?>
                    <tr>
                        <td>
                            <input
                                <?= isset($currentRole) && $authManager->hasChild($authManager->getRole($currentRole), $role) ? "checked":"" ?>
                                type="checkbox"
                                name="Role[childRoles][]"
                                class="roleH"
                                data-id="<?=$role->name;?>"
                                data-parent_id="<?php
                                if($authManager->getAllParentsByRole($role->name))
                                    echo implode(',', array_keys($authManager->getAllParentsByRole($role->name)));
                                ?>"



                                value="<?= $role->name ?>"

                                >

                        </td>
                        <td><?= isset($user->rolesValues[$role->name]) ? $user->rolesValues[$role->name]:$role->name; ?></td>
                        <td><?= $role->description ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="help-block"></div>
    </div>

    <?php

    if(isset($_GET['name'])){
        ?>
        <div class="form-group field-role-permissions">
            <label class="control-label" for="role-permissions">Permissions</label>
            <input type="hidden" name="Role[permissions]" value="">
            <div id="role-permissions">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <td style="width:1px"></td>
                        <td style="width:1px"><b>Name</b></td>
                        <td><b>Description</b></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($permissions as $permission): ?>
                        <tr>
                            <td>
                                <input
                                    class="roleH"
                                    data-id="<?=$permission->name;?>"
                                    data-parent_id="<?php
                                    if($authManager->getAllParentsByRole($permission->name))
                                        echo implode(',', array_keys($authManager->getAllParentsByRole($permission->name)));
                                    ?>"




                                    <?= in_array($permission->name, $model->permissions) ? "checked":"" ?> type="checkbox" name="Role[permissions][]" value="<?= $permission->name ?>">
                            </td>
                            <td><?= $permission->name ?></td>
                            <td><?= $permission->description ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="help-block"></div>
        </div>
        <?php
    }
    ?>


    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('rbac', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>


</div>

    <script>
        done = [];
        clicked = false;
        $('.roleH').each(function(){
            child($(this));
        });
    </script>