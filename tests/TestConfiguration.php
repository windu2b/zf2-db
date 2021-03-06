<?php


/**
 * Zend_Db_Adapter_Pdo_Mysql and Zend_Db_Adapter_Mysqli
 *
 * There are separate properties to enable tests for the PDO_MYSQL adapter and
 * the native Mysqli adapters, but the other properties are shared between the
 * two MySQL-related Zend_Db adapters.
 */
define('TESTS_ZEND_DB_ADAPTER_MYSQL_PREFERRED', 'Mysqli');
define('TESTS_ZEND_DB_ADAPTER_PDOMYSQL_ENABLED', false);
define('TESTS_ZEND_DB_ADAPTER_MYSQLI_ENABLED',  true);

define('TESTS_ZEND_DB_ADAPTER_MYSQL_HOSTNAME', '127.0.0.1');
define('TESTS_ZEND_DB_ADAPTER_MYSQL_USERNAME', 'developer');
define('TESTS_ZEND_DB_ADAPTER_MYSQL_PASSWORD', 'developer');
define('TESTS_ZEND_DB_ADAPTER_MYSQL_DATABASE', 'zend_test');
define('TESTS_ZEND_DB_ADAPTER_MYSQL_PORT', 3306);

/**
 * Zend_Db_Adapter_Pdo_Sqlite
 *
 * Username and password are irrelevant for SQLite.
 */
define('TESTS_ZEND_DB_ADAPTER_PDO_SQLITE_ENABLED',  false);
define('TESTS_ZEND_DB_ADAPTER_PDO_SQLITE_DATABASE', ':memory:');

/**
 * Zend_Db_Adapter_Pdo_Mssql
 *
 * Note that you need to patch your ntwdblib.dll, the one that
 * comes with PHP does not work.  See user comments at
 * http://us2.php.net/manual/en/ref.mssql.php
 */
define('TESTS_ZEND_DB_ADAPTER_PDO_MSSQL_ENABLED',  false);
define('TESTS_ZEND_DB_ADAPTER_PDO_MSSQL_HOSTNAME', '127.0.0.1');
define('TESTS_ZEND_DB_ADAPTER_PDO_MSSQL_USERNAME', null);
define('TESTS_ZEND_DB_ADAPTER_PDO_MSSQL_PASSWORD', null);
define('TESTS_ZEND_DB_ADAPTER_PDO_MSSQL_DATABASE', 'test');

/**
 * Zend_Db_Adapter_Pdo_Pgsql
 */
define('TESTS_ZEND_DB_ADAPTER_PDO_PGSQL_ENABLED',  false);
define('TESTS_ZEND_DB_ADAPTER_PDO_PGSQL_HOSTNAME', '127.0.0.1');
define('TESTS_ZEND_DB_ADAPTER_PDO_PGSQL_USERNAME', null);
define('TESTS_ZEND_DB_ADAPTER_PDO_PGSQL_PASSWORD', null);
define('TESTS_ZEND_DB_ADAPTER_PDO_PGSQL_DATABASE', 'postgres');

/**
 * Zend_Db_Adapter_Oracle and Zend_Db_Adapter_Pdo_Oci
 *
 * There are separate properties to enable tests for the PDO_OCI adapter and
 * the native Oracle adapter, but the other properties are shared between the
 * two Oracle-related Zend_Db adapters.
 */
define('TESTS_ZEND_DB_ADAPTER_PDO_OCI_ENABLED',  false);
define('TESTS_ZEND_DB_ADAPTER_ORACLE_ENABLED',  false);
define('TESTS_ZEND_DB_ADAPTER_ORACLE_HOSTNAME', '127.0.0.1');
define('TESTS_ZEND_DB_ADAPTER_ORACLE_USERNAME', null);
define('TESTS_ZEND_DB_ADAPTER_ORACLE_PASSWORD', null);
define('TESTS_ZEND_DB_ADAPTER_ORACLE_SID',      'xe');

/**
 * Zend_Db_Adapter_Db2 and Zend_Db_Adapter_Pdo_Ibm
 * There are separate properties to enable tests for the PDO_IBM adapter and
 * the native DB2 adapter, but the other properties are shared between the
 * two related Zend_Db adapters.
 */
define('TESTS_ZEND_DB_ADAPTER_PDO_IBM_ENABLED',  false);
define('TESTS_ZEND_DB_ADAPTER_DB2_ENABLED',  false);
define('TESTS_ZEND_DB_ADAPTER_DB2_HOSTNAME', '127.0.0.1');
define('TESTS_ZEND_DB_ADAPTER_DB2_PORT', 50000);
define('TESTS_ZEND_DB_ADAPTER_DB2_USERNAME', null);
define('TESTS_ZEND_DB_ADAPTER_DB2_PASSWORD', null);
define('TESTS_ZEND_DB_ADAPTER_DB2_DATABASE', 'sample');

/**
 * Zend_Db_Adapter_Sqlsrv
 * Note: Make sure that you create the "test" database and set a
 * username and password
 *
 */
define('TESTS_ZEND_DB_ADAPTER_SQLSRV_ENABLED',  false);
define('TESTS_ZEND_DB_ADAPTER_SQLSRV_HOSTNAME', 'localhost\SQLEXPRESS');
define('TESTS_ZEND_DB_ADAPTER_SQLSRV_USERNAME', null);
define('TESTS_ZEND_DB_ADAPTER_SQLSRV_PASSWORD', null);
define('TESTS_ZEND_DB_ADAPTER_SQLSRV_DATABASE', 'test');

/**
 * PHPUnit Code Coverage / Test Report
 */
define('TESTS_GENERATE_REPORT', false);
define('TESTS_GENERATE_REPORT_TARGET', '/path/to/target');
