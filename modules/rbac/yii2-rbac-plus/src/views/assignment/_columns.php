<?php

use yii\helpers\Url;
$rolesValues = (new \user\models\User())->rolesValues;

$columns = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => Yii::$app->getModule('rbac')->userModelIdField,
        'label' => "User ID",
    ],
    /*[
        'class' => '\kartik\grid\DataColumn',
        'attribute' => Yii::$app->getModule('rbac')->userModelLoginField,
    ],*/
    /*[
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'username',
    ],*/
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'name',
    ],
    /*[
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'email',
    ],*/
    [
        'label' => 'Roles',
        'content' => function($model) use ($rolesValues) {
            $authManager = Yii::$app->authManager;
            $idField = Yii::$app->getModule('rbac')->userModelIdField;
            $roles = [];
            foreach ($authManager->getRolesByUser($model->{$idField}) as $role) {
               $roles[] = $rolesValues[$role->name];
            }
            if(count($roles)==0){
                return null;
            }else{
                return implode(",", $roles);
            }
        },
    ],
];


$extraColums = \Yii::$app->getModule('rbac')->userModelExtraDataColumls;
if ($extraColums !== null) {
    // If extra colums exist merge and return 
    $columns = array_merge($columns, $extraColums);
}
$columns[] = [
    'class' => 'kartik\grid\ActionColumn',
    'template' => '{update}',
    'header' => Yii::t('rbac', 'Assignment'),
    'dropdown' => false,
    'vAlign' => 'middle',
    'urlCreator' => function($action, $model, $key, $index) {
        return Url::to(['assignment', 'id' => $key]);
    },
            'updateOptions' => ['role' => 'modal-remote', 'title' => Yii::t('rbac', 'Update'), 'data-toggle' => 'tooltip'],
        ];
        return $columns;


        