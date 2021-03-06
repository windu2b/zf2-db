<?php

/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Db
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: PdoPgsqlTest.php 16086 2009-06-16 05:20:50Z ralph $
 */


/**
 * @see Zend_Db_Table_Select_AbstractTestCase
 */
require_once 'Zend/Db/Table/Select/AbstractTestCase.php';


PHPUnit_Util_Filter::addFileToFilter(__FILE__);


/**
 * @category   Zend
 * @package    Zend_Db
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Db_Table_Select_PdoPgsqlTest extends Zend_Db_Table_Select_AbstractTestCase
{
    /*
    public function getDriver()
    {
        return 'Pdo_Pgsql';
    }
    */

    public function testSelectGroupByExpr()
    {
        $this->markTestSkipped($this->sharedFixture->dbUtility->getDriverName() . ' does not support expressions in GROUP BY');
    }

    public function testSelectGroupByAutoExpr()
    {
        $this->markTestSkipped($this->sharedFixture->dbUtility->getDriverName() . ' does not support expressions in GROUP BY');
    }

    /**
     * Ensures that from() provides expected behavior using schema specification
     *
     * @return void
     */
    public function testSelectFromSchemaSpecified()
    {
        $schema = 'public';
        $table  = 'zf_bugs';

        $sql = $this->sharedFixture->dbAdapter->select()->from($table, '*', $schema);

        $this->assertRegExp("/FROM \"$schema\".\"$table\"/", $sql->__toString());

        $rowset = $this->sharedFixture->dbAdapter->fetchAll($sql);

        $this->assertEquals(4, count($rowset));
    }

    /**
     * Ensures that from() provides expected behavior using schema in the table name
     *
     * @return void
     */
    public function testSelectFromSchemaInName()
    {
        $schema = 'public';
        $table  = 'zf_bugs';

        $name   = "$schema.$table";

        $sql = $this->sharedFixture->dbAdapter->select()->from($name);

        $this->assertRegExp("/FROM \"$schema\".\"$table\"/", $sql->__toString());

        $rowset = $this->sharedFixture->dbAdapter->fetchAll($sql);

        $this->assertEquals(4, count($rowset));
    }

    /**
     * Ensures that from() overrides schema specification with schema in the table name
     *
     * @return void
     */
    public function testSelectFromSchemaInNameOverridesSchemaArgument()
    {
        $schema = 'public';
        $table  = 'zf_bugs';

        $name   = "$schema.$table";

        $sql = $this->sharedFixture->dbAdapter->select()->from($name, '*', 'ignored');

        $this->assertRegExp("/FROM \"$schema\".\"$table\"/", $sql->__toString());

        $rowset = $this->sharedFixture->dbAdapter->fetchAll($sql);

        $this->assertEquals(4, count($rowset));
    }
}
