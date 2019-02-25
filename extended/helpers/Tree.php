<?php
/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace extended\helpers;



class Tree
{
    /**
     * @var string
     */
    public $leftAttribute = 'lft';

    /**
     * @var string
     */
    public $depthAttribute = 'depth';

    /**
     * @var string
     */
    public $labelAttribute = 'label';

    /**
     * @var string
     */
    public $childrenOutAttribute = 'children';



    /**
     * Построение дерева Nested Sets в виде массива
     *
     * @param array $collection Массив строк из БД
     * @return array
     */
    public function tree(array $collection)
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
                $item[$this->childrenOutAttribute] = array();

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


    /**
     * Добавляет в массив дополнительные элементы
     * @param $node array Текущий элемент массива (строка из БД)
     * @return array
     */
    protected function addItem($node)
    {
        $newNode = [];
        return array_merge($node, $newNode);
    }

}
