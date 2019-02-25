<?php
/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace extended\helpers;


use Yii;

class MenuTree extends Tree
{

    /**
     * @var string
     */
    public $childrenOutAttribute = 'items'; //children

    /**
     * @var string
     */
    public $labelOutAttribute = 'label'; //title


    /**
     * Добавляет в массив дополнительные элементы
     * @param $node
     * @return array
     */
    protected function addItem($node)
    {
        $node = $this->renameTitle($node); //переименование элемента массива
        $node = $this->visible($node); //видимость элементов меню
        $node = $this->makeActive($node); //выделение активного пункта меню

        return $node;
    }


    /**
     * Переименовываем элемент "name" в "label" (создаем label, удаляем name)
     * требуется для yii\widgets\Menu
     * @param $node
     * @return array
     */
    protected function renameTitle($node)
    {
        $newNode = [
            $this->labelOutAttribute => $node[$this->labelAttribute],
        ];

        return array_merge($node, $newNode);
    }


    /**
     * Видимость пункта меню (visible = false - скрыть элемент)
     * @param $node
     * @return array
     */
    protected function visible($node)
    {
        return $node;
        $newNode = [];

        //Гость
        if (Yii::$app->user->isGuest) {

            //Действие logout по-умолчанию проверяется на метод POST.
            //При использовании подкорректировать VerbFilter в контроллере (удалить это действие или добавить GET).
            if (/*$node['url'] === '/logout'*/1) {
                $newNode = [
                    'visible' => true,
                ];
            }

            //Авторизованный пользователь
        } else {
            if (/*$node['url'] === '/login' || $node['url'] === '/signup'*/1) {
                $newNode = [
                    'visible' => true,
                ];
            }
        }

        return array_merge($node, $newNode);
    }



    /**
     * Добавляет элемент "active" в массив с url соответствующим текущему запросу
     * для назначения отдельного класса активному пункту меню
     *
     * @param $node
     * @return array
     */
    private function makeActive($node)
    {
        return $node;
        //URL без хоста, слэша спереди и параметров запроса
        $path = Yii::$app->request->getPathInfo();

        //считается, что поле url в БД содержит слэш спереди, например "/about"
        if(/*'/' . $path === $node['url']*/1){
            $newNode = [
                //'active' => true,
            ];
            return array_merge($node, $newNode);
        }

        return $node;
    }



    public function treeMobile(array $collection)
    {

        $trees = []; // Дерево

        if (count($collection) > 0) {

            //Добавляем свои элементы
            foreach ($collection as &$col) {
                $col = $this->addItem($col);
            }

            // Узел. Используется для создания иерархии
            $stack = array();

            foreach ($collection as $node) {
                $item = $node;

                $title = lcfirst(strip_tags($node['oldTitle']));
                //$title = lcfirst(strip_tags($node['title']));
                $item[$this->childrenOutAttribute] = $node['isLeaf'] ? [] : array(
                    [
                        'label'=>Yii::t('db_category', 'All in '.$title),
                        'url'=>$node['data-url'],
                        'linkOptions'=>[
                            'class'=>'all_link',
                            'data-back-label'=>Yii::t('db_category', 'Back to '.$title)
                            //'data-back-label'=>Yii::t('frontend', 'Back to '.$title)
                        ],
                    ]
                );

                // Количество элементов узла
                $l = count($stack);

                // Проверка имеем ли мы дело с разными уровнями
                while($l > 0 && $stack[$l - 1][$this->depthAttribute] >= $item[$this->depthAttribute]) {
                    array_pop($stack);
                    $l--;
                }

                // Если это корень
                if ($l == 0) {
                    // Создание корневого элемента
                    $i = count($trees);
                    $trees[$i] = $item;
                    $stack[] = &$trees[$i];
                } else {
                    // Добавление элемента в родительский
                    $i = count($stack[$l - 1][$this->childrenOutAttribute]);
                    $stack[$l - 1][$this->childrenOutAttribute][$i] = $item;
                    $stack[] = &$stack[$l - 1][$this->childrenOutAttribute][$i];
                }
            }
        }

        return $trees;
    }

}
