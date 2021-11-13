<?php


namespace paymentCms\component;


use database;

/**
 * Created by Yeganehha .
 * User: Erfan Ebrahimi (http://ErfanEbrahimi.ir)
 * Date: 4/7/2019
 * Time: 8:14 PM
 * project : paymentCMS
 * virsion : 0.0.0.1
 * update Time : 4/7/2019 - 8:14 PM
 * Discription of this Page :
 */


if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');


abstract class model
{

    protected $modelName;
    /* @var database $db */
    protected static $db = null;
    protected static $dbTemp = null;
    protected static $transactionCounter = 0;

    public function __construct($searchVariable = null, $searchWhereClaus = '___MODEL_ID_GENERATOR___')
    {
        $this->modelName = get_called_class();
        if (strings::strhas($this->modelName, '\\')) {
            $tempModelName = explode('\\', $this->modelName);
            $this->modelName = end($tempModelName);
        }
        if ($searchVariable != null and get_called_class() != 'model') {
            if ($searchWhereClaus == '___MODEL_ID_GENERATOR___') {
                $primaryKey = $this->getPrimaryKey();
                if (is_array($primaryKey) and is_array($searchVariable)) {
                    $searchWhereClaus = ' ( ' . implode(' = ? and ', $primaryKey) . ' = ? )';
                } elseif (is_array($primaryKey) and !is_array($searchVariable)) {
                    $searchWhereClaus = $this->getPrimaryKey()[0] . ' = ? ';
                } else {
                    $searchWhereClaus = $this->getPrimaryKey() . ' = ? ';
                }
            }
            if (is_array($searchVariable))
                self::$db->where($searchWhereClaus, $searchVariable);
            else
                self::$db->where($searchWhereClaus, [$searchVariable]);
            $result = self::$db->getOne($this->modelName);
            if ($result != null)
                $this->setFromArray($result);
        }
        return $this->returning();
    }


    public static function __init()
    {
        if (self::$db == null) {
            $configDataBase = include payment_path . 'core' . DIRECTORY_SEPARATOR . 'config.php';
            if ($configDataBase === false)
                return;
            self::$db = new database($configDataBase['_dbHost'], $configDataBase['_dbUsername'], $configDataBase['_dbPassword'], $configDataBase['_dbName']);
            self::$db->setPrefix($configDataBase['_dbTableStartWith']);
        }
    }

    /**
     * @return database
     */
    public static function db()
    {
        return self::$db;
    }

    public static function transaction()
    {
        if (self::$transactionCounter >= 0)
            self::$transactionCounter++;
        else {
            self::$transactionCounter = 1;
            self::$db->startTransaction();
        }
    }

    public static function commit()
    {
        self::$transactionCounter--;
        if (self::$transactionCounter == 0) {
            self::$db->commit();
        }
    }

    public static function rollback()
    {
        self::$transactionCounter = 0;
        self::$db->rollback();
    }

    public static function queryUnprepared($query)
    {
        return self::$db->queryUnprepared($query);
    }
    public static function queryUnpreparedWithWhere($query,$searchVariable = null, $searchWhereClaus = null)
    {
        if ($searchWhereClaus != null) {
            $query .= " WHERE " . implode(' and ' , $searchWhereClaus);
        }
        return self::$db->queryUnpreparedWithWhere($query,$searchVariable);
    }

    public static function tableExist($table)
    {
        return self::$db->tableExists($table);
    }

    public static function rawQuery($query)
    {
        return self::$db->rawQuery($query);
    }

    public static function debugQuery($end = false)
    {
        show(self::db()->getLastError(), false);
        show(self::db()->getLastQuery(), $end);
    }

    public static function getLastQuery()
    {
        return self::db()->getLastQuery();
    }

    public static function startSubQuery($subQueryAlias = "")
    {
        $dbTemp = self::$dbTemp = self::$db;
        self::$db = $dbTemp::subQuery($subQueryAlias);
    }

    public static function finishSubQuery()
    {
        $dbTemp = self::$db;
        self::$db = self::$dbTemp;
        return $dbTemp;
    }

    /**
     * @param database $db
     */
    public static function setDb($db)
    {
        self::$db = $db;
    }


    public function deleteOnFullQuery($searchVariable, $searchWhereClaus)
    {
        if ($searchWhereClaus != null) {
            if (is_array($searchVariable)) {
                self::$db->where($searchWhereClaus, $searchVariable);
            } else {
                self::$db->where($searchWhereClaus, [$searchVariable]);
            }
        }
        $results = self::db()->delete($this->modelName);
        return $this->returning($results);
    }

    public function updateOnFullQuery($dataUpdate, $searchVariable, $searchWhereClaus)
    {
        if ($searchWhereClaus != null) {
            if (is_array($searchVariable)) {
                self::$db->where($searchWhereClaus, $searchVariable);
            } else {
                self::$db->where($searchWhereClaus, [$searchVariable]);
            }
        }
        if (self::$db->update($this->modelName, $dataUpdate))
            return $this->returning();
        return $this->returning(null, false, $this->modelName . '2');
    }

    /**
     * @param        $searchVariable
     * @param        $searchWhereClaus
     * @param null $tableName
     * @param string $fields
     * @param null $orderBy
     * @param null $limit
     * @param null $groupBy
     *
     * @return bool|null|array
     *
     */
    public function search($searchVariable, $searchWhereClaus, $tableName = null, $fields = '*', $orderBy = null, $limit = null, $groupBy = null)
    {
        if ($searchWhereClaus != null) {
            if (is_array($searchVariable)) {
                self::$db->where($searchWhereClaus, $searchVariable);
            } else {
                self::$db->where($searchWhereClaus, [$searchVariable]);
            }
        }
        if ($tableName == null) {
            $tableName = $this->modelName;
        }
        if ($orderBy != null and isset($orderBy['column'])) {
            self::$db->orderBy($orderBy['column'], $orderBy['type']);
        }
        if ($orderBy != null and isset($orderBy[0]['column'])) {
            for ($indexOrder = 0; $indexOrder < count($orderBy); $indexOrder++)
                if (isset($orderBy[$indexOrder]['column']))
                    self::$db->orderBy($orderBy[$indexOrder]['column'], $orderBy[$indexOrder]['type']);
        }
        if ($groupBy != null) {
            self::$db->groupBy($groupBy);
        }
        $results = self::$db->get($tableName, $limit, $fields);
        return $this->returning($results);
    }


    public static function join($table, $condition = null, $joinOn = "LEFT")
    {
        self::$db->join($table, $condition, $joinOn);
    }

    public static function insert($table, $data)
    {
        return self::$db->insert($table, $data);
    }

    public static function update($table, $data, $variable, $value)
    {
        self::$db->where($variable, $value);
        return self::$db->update($table, $data);
    }

    public static function joinOrWhere($table, $condition, $conditionValue)
    {
        self::$db->joinOrWhere($table, $condition, $conditionValue);
    }

    public static function joinWhere($table, $condition, $conditionValue)
    {
        self::$db->joinWhere($table, $condition, $conditionValue);
    }


    public static function searching($searchVariable, $searchWhereClaus, $tableName, $fields = '*', $orderBy = null, $limit = null)
    {
        if ($searchWhereClaus != null) {
            if (is_array($searchVariable)) {
                self::$db->where($searchWhereClaus, $searchVariable);
            } else {
                self::$db->where($searchWhereClaus, [$searchVariable]);
            }
        }
        if ($orderBy != null and isset($orderBy['column'])) {
            self::$db->orderBy($orderBy['column'], $orderBy['type']);
        }
        if ($orderBy != null and isset($orderBy[0]['column'])) {
            for ($indexOrder = 0; $indexOrder < count($orderBy); $indexOrder++)
                if (isset($orderBy[$indexOrder]['column']))
                    self::$db->orderBy($orderBy[$indexOrder]['column'], $orderBy[$indexOrder]['type']);
        }
        $results = self::$db->get($tableName, $limit, $fields);
        return $results;
    }

    protected function returning($return = null, $status = true, $errorNumber = "service0", $massagesParams = null)
    {
        if ($return == null)
            return $status;
        else
            return $return;

    }


    public function insertToDataBase()
    {
        $data = $this->returnAsArray();
        $primaryKey = $this->getPrimaryKeyShouldNotInsertOrUpdate();
        if ($primaryKey != null) {
            if (is_array($primaryKey)) {
                $ID = null;
                for ($i = 0; $i < count($primaryKey); $i++) {
                    if (substr($primaryKey[$i], 0, 3) == 'ID:') {
                        $ID = $i;
                        $primaryKey[$i] = str_replace('ID:', '', $primaryKey[$ID]);
                    }
                    unset($data[$primaryKey[$i]]);
                }
                if ($ID !== null) {
                    $primaryKey = $primaryKey[$ID];
                }
            } else {
                unset($data[$primaryKey]);
            }
        }
        $id = self::$db->insert($this->modelName, $data);
        if ($id) {
            if ($primaryKey != null) {
                $data[$primaryKey] = $id;
                $this->setFromArray($data);
            }
            return $this->returning($id);
        }
        return $this->returning(null, false, $this->modelName . '3');
    }


    public function upDateDataBase()
    {
        $data = $this->returnAsArray();
        $primaryKey = $this->getPrimaryKeyShouldNotInsertOrUpdate();
        if ($primaryKey != null) {
            if (is_array($primaryKey)) {
                $ID = null;
                for ($i = 0; $i < count($primaryKey); $i++) {
                    if (strings::strhas('ID:', $primaryKey[$i])) {
                        $ID = $i;
                        $primaryKey[$i] = str_replace('ID:', '', $primaryKey[$ID]);
                    }
                    unset($data[$primaryKey[$i]]);
                }
                if ($ID != null)
                    $primaryKey = $primaryKey[$ID];
            } else
                unset($data[$primaryKey]);
        }
        $this->makePrimaryDBSearch();
        if (self::$db->update($this->modelName, $data))
            return $this->returning();
        return $this->returning(null, false, $this->modelName . '2');
    }


    public function deleteFromDataBase()
    {
        $this->makePrimaryDBSearch();
        if (self::$db->delete($this->modelName))
            return $this->returning();
        return $this->returning(null, false, $this->modelName . '1');
    }

    private function makePrimaryDBSearch()
    {
        $data = $this->returnAsArray();
        $primaryKey = $this->getPrimaryKey();
        if (is_array($primaryKey)) {
            foreach ($primaryKey as $value) {
                self::$db->where($value, $data[$value]);
            }
        } else
            self::$db->where($primaryKey, $data[$primaryKey]);
    }

    abstract function setFromArray($result);

    abstract function getPrimaryKey();

    abstract function getPrimaryKeyShouldNotInsertOrUpdate();

    abstract function returnAsArray();
}