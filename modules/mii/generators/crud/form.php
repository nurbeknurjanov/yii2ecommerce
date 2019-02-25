<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator mii\generators\crud\Generator */

echo $form->field($generator, 'is_module')->checkbox();
echo $form->field($generator, 'modelClass');
echo $form->field($generator, 'searchModelClass');
echo $form->field($generator, 'controllerClass');
echo $form->field($generator, 'viewPath');
echo $form->field($generator, 'baseControllerClass');
echo $form->field($generator, 'indexWidgetType')->dropDownList([
    'grid' => 'GridView',
    'list' => 'ListView',
]);
echo $form->field($generator, 'enableI18N')->checkbox();
echo $form->field($generator, 'messageCategory');

ob_start();
?>
    <script>
        function ucfirst( str ) {	// Make a string&#039;s first character uppercase
            //
            // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)

            var f = str.charAt(0).toUpperCase();
            return f + str.substr(1, str.length-1);
        }
        function ucfirst( str ) {	// Make a string&#039;s first character uppercase
            //
            // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)

            var f = str.charAt(0).toUpperCase();
            return f + str.substr(1, str.length-1);
        }

        $('#generator-is_module').click(function(){
            if($(this).prop('checked')){
                $('#generator-modelclass').val('common\\models\\');
            }else {
                $('#generator-modelclass').val('');
            }
        });

        $('#generator-modelclass').keyup(function(){
            var model = $(this).val();
            model = model.split('\\');
            if(model.length){
                model = model[model.length-1];
            }

            if($('#generator-is_module').prop('checked')){
                //$('#generator-modelclass').val('modules\\'+model.toLowerCase()+'\\models\\'+ucfirst(model));
                $('#generator-searchmodelclass').val(model.toLowerCase()+'\\models\\search\\'+ucfirst(model)+'Search');
                $('#generator-controllerclass').val(model.toLowerCase()+'\\controllers\\'+ucfirst(model)+'Controller');
            }else {
                //$('#generator-modelclass').val('modules\\'+model.toLowerCase()+'\\models\\'+ucfirst(model));
                $('#generator-searchmodelclass').val('common\\models\\search\\'+ucfirst(model)+'Search');
                $('#generator-controllerclass').val('frontend\\controllers\\'+ucfirst(model)+'Controller');
            }

        });
    </script>
<?php
$content = ob_get_contents();
$content = strip_tags($content, 'script');
ob_end_clean();

$javascript = <<<javascript
    $content
javascript;
$this->registerJs($javascript);
?>