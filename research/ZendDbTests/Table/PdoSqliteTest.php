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
 * @version    $Id: PdoSqliteTest.php 16086 2009-06-16 05:20:50Z ralph $
 */


/**
 * @see Zend_Db_Table_AbstractTestCase
 */
require_once 'Zend/Db/Table/AbstractTestCase.php';


PHPUnit_Util_Filter::addFileToFilter(__FILE__);


/**
 * @category   Zend
 * @package    Zend_Db
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Db_Table_PdoSqliteTest extends Zend_Db_Table_AbstractTestCase 
{

    public function testTableInsertSequence()
    {
        $this->markTestSkipped($this->sharedFixture->dbUtility->getDriverName().' does not support sequences.');
    }

    public function testDbTableSchemaSpecified()
    {
        $this->markTestSkipped($this->sharedFixture->dbUtility->getDriverName() . ' does not support qualified table names');
    }

    public function getDriver()
    {
        return 'Pdo_Sqlite';
    }

}
