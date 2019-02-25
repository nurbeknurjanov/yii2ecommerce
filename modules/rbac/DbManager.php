<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace rbac;

use Yii;
use yii\caching\Cache;
use yii\db\Connection;
use yii\db\Query;
use yii\db\Expression;
use yii\base\InvalidCallException;
use yii\base\InvalidParamException;
use yii\di\Instance;

/**
 * DbManager represents an authorization manager that stores authorization information in database.
 *
 * The database connection is specified by [[db]]. The database schema could be initialized by applying migration:
 *
 * ```
 * yii migrate --migrationPath=@yii/rbac/migrations/
 * ```
 *
 * If you don't want to use migration and need SQL instead, files for all databases are in migrations directory.
 *
 * You may change the names of the tables used to store the authorization and rule data by setting [[itemTable]],
 * [[itemChildTable]], [[assignmentTable]] and [[ruleTable]].
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @author Alexander Kochetov <creocoder@gmail.com>
 * @since 2.0
 */
class DbManager extends \yii\rbac\DbManager
{

    public function getAllChildrenByRole($roleName)
    {
        $childrenList = $this->getChildrenList();
        $result = [];
        $this->getChildrenRecursive($roleName, $childrenList, $result);
        if (empty($result)) {
            return [];
        }
        $query = (new Query)->from($this->itemTable)->where([
            'name' => array_keys($result),
        ]);
        $permissions = [];
        foreach ($query->all($this->db) as $row) {
            $permissions[$row['name']] = $this->populateItem($row);
        }
        return $permissions;
    }

    protected function getParentRecursive($name, $childrenList, &$result, $direct = false)
    {
        foreach ($childrenList as $parent => $child)
            foreach ($child as $childChild)
                if($name==$childChild){
                    $result[]=$parent;
                    if($direct==true)
                        return false;
                    $this->getParentRecursive($parent, $childrenList, $result);
                }
    }

    public function getAllParentsByRole($roleName)
    {
        $list = $this->getChildrenList();
        $result = [];
        $this->getParentRecursive($roleName, $list, $result);
        if (empty($result)) {
            return [];
        }

        $query = (new Query)->from($this->itemTable)->where([
            'name' => $result,
        ]);
        $permissions = [];
        foreach ($query->all($this->db) as $row) {
            $permissions[$row['name']] = $this->populateItem($row);
        }
        return $permissions;
    }
    public function getDirectParentsByRole($roleName)
    {
        $list = $this->getChildrenList();

        $result = [];
        $this->getParentRecursive($roleName, $list, $result, true);


        if (empty($result)) {
            return [];
        }

        $query = (new Query)->from($this->itemTable)->where([
            'name' => $result,
        ]);
        $permissions = [];
        foreach ($query->all($this->db) as $row) {
            $permissions[$row['name']] = $this->populateItem($row);
        }
        return $permissions;
    }

}
