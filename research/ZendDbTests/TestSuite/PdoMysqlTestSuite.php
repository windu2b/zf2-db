<?php

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'Zend_Db_TestSuite_PdoMysqlTestSuite::main');
}

require_once dirname(__FILE__) . '/AbstractTestSuite.php';

class Zend_Db_TestSuite_PdoMysqlTestSuite extends Zend_Db_TestSuite_AbstractTestSuite
{
    
    public static function main()
    {
        parent::_mainRunner(__CLASS__, (isset($_SERVER['argv'][1])) ? $_SERVER['argv'][1] : null);
    }
    
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite();
        $suite->addTestSuite(new self());
        return $suite;
    }
    
    public function getDriverName()
    {
        return 'Pdo_Mysql';
    }
    
}

if (PHPUnit_MAIN_METHOD == 'Zend_Db_TestSuite_PdoMysqlTestSuite::main') {
    Zend_Db_TestSuite_PdoMysqlTestSuite::main();
}
