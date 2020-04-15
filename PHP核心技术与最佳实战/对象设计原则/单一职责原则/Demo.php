<?php
/***
 * 第1步，定义各种数据库持久类，遵循单一职责原则（SRP）
 * 只模拟实现数据库的连接操作
 */
class Mysql{
    public function connect(){
        echo 'connect to mysql';
    }
}

class Sqlite{
    public function connect(){
        echo 'connect to sqlite';
    }
}

class Oracle{
    public function connect(){
        echo 'connect to oracle';
    }
}

/**
 * 第2步，实现可以生产Mysql，Sqlite，Oracle数据持久类的数据库工厂类
 */

class DbFactory{
    /**
     * 【注意】本代码不考虑命名空间问题，只考虑代码实现的核心思想
     * @param $dbClassName 数据库类名
     */
    public static function factory($dbClassName){
        return new $dbClassName();//生产数据库持久类对象，【注意】没有做不存在的异常处理
    }
}

/**
 * 第3步：使用实例
 */
//使用mysql持久类
$mysqlDb = DbFactory::factory('Mysql');
$mysqlDb->connect();
//使用sqlite持久类
$sqlLite = DbFactory::factory('Sqlite');
$sqlLite->connect();
//使用Oracle持久类
$oracleDb = DbFactory::factory('Oracle');
$oracleDb->connect();
