/**
 * Created by Nurbek on 2/9/15.
 */
/**
 * Yii GridView widget.
 *
 * This is the JavaScript widget used by the yii\grid\GridView widget.
 *
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
(function ($) {

    $.fn.yiiGridView = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.yiiGridView');
            return false;
        }
    };

    var defaults = {
        filterUrl: undefined,
        filterSelector: undefined
    };

    var gridData = {};

    var gridEvents = {
        /**
         * beforeFilter event is triggered before filtering the grid.
         * The signature of the event handler should be:
         *     function (event)
         * where
         *  - event: an Event object.
         *
         * If the handler returns a boolean false, it will stop filter form submission after this event. As
         * a result, afterFilter event will not be triggered.
         */
        beforeFilter: 'beforeFilter',
        /**
         * afterFilter event is triggered after filtering the grid and filtered results are fetched.
         * The signature of the event handler should be:
         *     function (event)
         * where
         *  - event: an Event object.
         */
        afterFilter: 'afterFilter'
    };

    var methods = {
        init: function (options) {
            return this.each(function () {
                var $e = $(this);
                var settings = $.extend({}, defaults, options || {});
                var id = $e.attr('id');
                if (gridData[id] === undefined) {
                    gridData[id] = {};
                }

                gridData[id] = $.extend(gridData[id], {settings: settings});

                var enterPressed = false;
                $(document).off('change.yiiGridView keydown.yiiGridView', settings.filterSelector)
                    .on('change.yiiGridView keydown.yiiGridView', settings.filterSelector, function (event) {
                        if (event.type === 'keydown') {
                            if (event.keyCode !== 13) {
                                return; // only react to enter key
                            } else {
                                enterPressed = true;
                            }
                        } else {
                            // prevent processing for both keydown and change events
                            if (enterPressed) {
                                enterPressed = false;
                                return;
                            }
                        }

                        methods.applyFilter.apply($e);

                        return false;
                    });
            });
        },


        applyFilter: function () {
            var $grid = $(this), event;
            var settings = gridData[$grid.prop('id')].settings;
            var data = {};

            $.each(
                $(settings.filterSelector).not('input:hidden').filter(function(){ return $(this).val() && $(this).attr('name');  }),
                function (key, $element) {
                    $element = $($element);

                    if($element.attr('type')=='checkbox'){
                        var arrayValue = $form.find('[name="'+$element.attr('name')+'"]:checked').map(function(){
                            return $(this).val();
                        }).get();

                        if(arrayValue.length>0){
                            data[$element.attr('name')] = arrayValue;
                            //data[$element.attr('name')] = arrayValue.join(",");
                        }

                    }else if($element.attr('type')=='radio'){
                        if($form.find('[name="'+$element.attr('name')+'"]:checked').length)
                            data[$element.attr('name')] = $form.find('[name="'+$element.attr('name')+'"]:checked').val();
                    }else if($element.prop('tagName')=='SELECT' && $element.prop('multiple')){
                        if($element.val() && $.isArray($element.val()) && $element.val().length>0)
                            data[$element.attr('name')] = $element.val();//this is array value
                    }
                    else
                        data[$element.attr('name')] = $element.val();
                });

            //другие гет переменные не относящиеся к модели
            if(settings.filterUrl.slice(-1)=='?')
                settings.filterUrl = settings.filterUrl.slice(0, -1);
            $.each(yii.getQueryParams(settings.filterUrl), function (name, value) {
                if(value && name){
                    if(!$('.grid-view .filters [name="'+name+'"]').length)
                        data[name] = value;
                }
            });



            var pos = settings.filterUrl.indexOf('?');

            var url = pos < 0 ? settings.filterUrl : settings.filterUrl.substring(0, pos);
            $grid.find('form.gridview-filter-form').remove();
            var $form = $('<form action="' + url + '" method="get" class="gridview-filter-form" style="display:none" data-pjax></form>');
            var $gridParentForm=$grid.parents('form');
            if($gridParentForm.length)
                $gridParentForm.after($form);
            else
                $form.appendTo($grid);


            $.each(data, function (name, value) {
                if($.isArray(data[name]))
                    $.each(data[name], function(key, val){
                        $form.append($('<input type="hidden" name="t" value="" />').attr('name', name).val(val));
                    });
                else
                    $form.append($('<input type="hidden" name="t" value="" />').attr('name', name).val(value));
            });



            event = $.Event(gridEvents.beforeFilter);
            $grid.trigger(event);
            if (event.result === false) {
                return;
            }


            $form.submit();
            $grid.trigger(gridEvents.afterFilter);
            return false;
        },

        setSelectionColumn: function (options) {
            var $grid = $(this);
            var id = $(this).attr('id');
            if (gridData[id] === undefined) {
                gridData[id] = {};
            }
            gridData[id].selectionColumn = options.name;
            if (!options.multiple || !options.checkAll) {
                return;
            }
            var checkAll = "#" + id + " input[name='" + options.checkAll + "']";
            var inputs = options.class ? "input." + options.class : "input[name='" + options.name + "']";
            var inputsEnabled = "#" + id + " " + inputs + ":enabled";
            $(document).off('click.yiiGridView', checkAll).on('click.yiiGridView', checkAll, function () {
                $grid.find(inputs + ":enabled").prop('checked', this.checked);
            });
            $(document).off('click.yiiGridView', inputsEnabled).on('click.yiiGridView', inputsEnabled, function () {
                var all = $grid.find(inputs).length == $grid.find(inputs + ":checked").length;
                $grid.find("input[name='" + options.checkAll + "']").prop('checked', all);
            });
        },

        getSelectedRows: function () {
            var $grid = $(this);
            var data = gridData[$grid.attr('id')];
            var keys = [];
            if (data.selectionColumn) {
                $grid.find("input[name='" + data.selectionColumn + "']:checked").each(function () {
                    keys.push($(this).parent().closest('tr').data('key'));
                });
            }
            return keys;
        },

        destroy: function () {
            return this.each(function () {
                $(window).unbind('.yiiGridView');
                $(this).removeData('yiiGridView');
            });
        },

        data: function () {
            var id = $(this).prop('id');
            return gridData[id];
        }
    };
})(window.jQuery);


function filterParameters($form)
{
    var data = {};
    var arrayData = {};
    $.each(
        $form.find('input, select, textarea').not('input:hidden').filter(function(){
            return $(this).val() && $(this).attr('name') && !$(this).prop("disabled");  })
        ,
        function (key, $element) {
            $element = $($element);
            /*alert(
             'tagName='+$element.prop('tagName')+
             '   name='+$element.prop('name')+
             '   value='+$element.val()
             );*/
            if($element.attr('type')=='checkbox'){

                var arrayValue = $form.find('[name="'+$element.attr('name')+'"]:checked').map(function(){
                    return $(this).val();
                }).get();

                if(arrayValue.length>0){
                    //data[$element.attr('name')] = arrayValue;
                    data[str_replace('[]','',$element.attr('name'))] = arrayValue.join("-");
                }

            }else if($element.attr('type')=='radio'){
                if($form.find('[name="'+$element.attr('name')+'"]:checked').length)
                    data[$element.attr('name')] = $form.find('[name="'+$element.attr('name')+'"]:checked').val();
            }else if($element.prop('tagName')=='SELECT' && $element.prop('multiple')){
                if($element.val() && $.isArray($element.val()) && $element.val().length>0)
                    data[$element.attr('name')] = $element.val();//this is array value
            }
            else
                data[$element.attr('name')] = $element.val();
        });

    //другие гет переменные не относящиеся к модели
    $.each(yii.getQueryParams(window.location.href), function (name, value) {
        if(value && name){
            if(!$form.find('[name="'+name+'"]').length && !(name in data) && !$form.find('[name="'+name+'[]"]').length)
                data[name] = value;
        }
    });

    delete data['searchForm'];
    if(countProperties(data)>0 || countProperties(arrayData)>0)
        data['searchForm']=1;

    return data;
}


var $form;
$form = $('.advancedSearch form');
$('.advancedSearchButton').click(function(){
    $('.advancedSearch').toggle();
});

if($form && $form.length)
    $form.submit(function(){
        var $form = $(this);
        var data = filterParameters($form);

        var action = $(this).attr('action');

        /*
        data = $.map(data, function (value, key) {
            return key+'='+value;
        });
        arrayData = $.map(arrayData, function (value, key) {
            value = $.map(value, function (subValue, subKey) {
                return key+'='+subValue;
            });
            return value;
        });
        data = $.merge(data, arrayData);
        var dataUrl = data.join('&');
        */
        var dataUrl = $.param(data);

        //if(data.length>0)
        if(countProperties(data))
            action+='?'+dataUrl;
        window.location.href=action;
        return false;
    });

