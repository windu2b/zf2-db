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
 */

require_once 'Zend/Db/Statement/AbstractTestCase.php';

PHPUnit_Util_Filter::addFileToFilter(__FILE__);

class Zend_Db_Statement_Db2Test extends Zend_Db_Statement_AbstractTestCase
{

    public function testStatementErrorCodeKeyViolation()
    {
        $this->markTestIncomplete($this->sharedFixture->dbUtility->getDriverName() . ' does not return error codes correctly.');
    }

    public function testStatementErrorInfoKeyViolation()
    {
        $this->markTestIncomplete($this->sharedFixture->dbUtility->getDriverName() . ' does not return error codes correctly.');
    }

    public function testStatementColumnCountForSelect()
    {
        $select = $this->sharedFixture->dbAdapter->select()
            ->from('zf_products');

        $stmt = $this->sharedFixture->dbAdapter->prepare($select->__toString());

        $n = $stmt->columnCount();
        // DB2 returns the column count once the query has been prepared
        // while PDO returns it only after it has been executed
        $this->assertEquals(2, $n);

        $stmt->execute();

        $n = $stmt->columnCount();
        $stmt->closeCursor();

        $this->assertType('integer', $n);
        $this->assertEquals(2, $n);
    }

    public function testStatementBindParamByPosition()
    {
        $this->markTestIncomplete($this->sharedFixture->dbUtility->getDriverName() . ' is having trouble with binding params');
    }

    public function testStatementBindParamByName()
    {
        $products = $this->sharedFixture->dbAdapter->quoteIdentifier('zf_products');
        $product_id = $this->sharedFixture->dbAdapter->quoteIdentifier('product_id');
        $product_name = $this->sharedFixture->dbAdapter->quoteIdentifier('product_name');

        $productIdValue   = 4;
        $productNameValue = 'AmigaOS';

        try {
            $stmt = $this->sharedFixture->dbAdapter->prepare("INSERT INTO $products ($product_id, $product_name) VALUES (:id, :name)");
            // test with colon prefix
            $this->assertTrue($stmt->bindParam(':id', $productIdValue), 'Expected bindParam(\':id\') to return true');
            // test with no colon prefix
            $this->assertTrue($stmt->bindParam('name', $productNameValue), 'Expected bindParam(\'name\') to return true');
            $this->fail('Expected to catch Zend_Db_Statement_Exception');
        } catch (Zend_Exception $e) {
            $this->assertType('Zend_Db_Statement_Exception', $e,
                'Expecting object of type Zend_Db_Statement_Exception, got '.get_class($e));
            $this->assertEquals("Invalid bind-variable name ':id'", $e->getMessage());
        }
    }

    public function testStatementBindValueByPosition()
    {
        $this->markTestIncomplete($this->sharedFixture->dbUtility->getDriverName() . ' is having trouble with binding params');
    }

    public function testStatementBindValueByName()
    {
        $products = $this->sharedFixture->dbAdapter->quoteIdentifier('zf_products');
        $product_id = $this->sharedFixture->dbAdapter->quoteIdentifier('product_id');
        $product_name = $this->sharedFixture->dbAdapter->quoteIdentifier('product_name');

        $productIdValue   = 4;
        $productNameValue = 'AmigaOS';

        try {
            $stmt = $this->sharedFixture->dbAdapter->prepare("INSERT INTO $products ($product_id, $product_name) VALUES (:id, :name)");
            // test with colon prefix
            $this->assertTrue($stmt->bindParam(':id', $productIdValue), 'Expected bindParam(\':id\') to return true');
            // test with no colon prefix
            $this->assertTrue($stmt->bindParam('name', $productNameValue), 'Expected bindParam(\'name\') to return true');
            $this->fail('Expected to catch Zend_Db_Statement_Exception');
        } catch (Zend_Exception $e) {
            $this->assertType('Zend_Db_Statement_Exception', $e,
                'Expecting object of type Zend_Db_Statement_Exception, got '.get_class($e));
            $this->assertEquals("Invalid bind-variable name ':id'", $e->getMessage());
        }
    }

    public function testStatementGetColumnMeta()
    {
        $this->markTestIncomplete($this->sharedFixture->dbUtility->getDriverName() . ' has not implemented getColumnMeta() yet [ZF-1424]');
    }

    public function getDriver()
    {
        return 'Db2';
    }

}
