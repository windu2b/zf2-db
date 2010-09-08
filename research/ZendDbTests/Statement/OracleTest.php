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

class Zend_Db_Statement_OracleTest extends Zend_Db_Statement_AbstractTestCase
{

    public function testStatementBindParamByPosition()
    {
        $this->markTestSkipped($this->sharedFixture->dbUtility->getDriverName() . ' does not support bound parameters by position');
    }

    public function testStatementBindValueByPosition()
    {
        $this->markTestSkipped($this->sharedFixture->dbUtility->getDriverName() . ' does not support bound parameters by position');
    }

    public function testStatementErrorCodeKeyViolation()
    {
        $this->markTestIncomplete($this->sharedFixture->dbUtility->getDriverName() . ' does not return error codes correctly.');
    }

    public function testStatementErrorInfoKeyViolation()
    {
        $this->markTestIncomplete($this->sharedFixture->dbUtility->getDriverName() . ' does not return error codes correctly.');
    }

    public function testStatementExecuteWithParams()
    {
        $products = $this->sharedFixture->dbAdapter->quoteIdentifier('zf_products');
        $product_id = $this->sharedFixture->dbAdapter->quoteIdentifier('product_id');
        $product_name = $this->sharedFixture->dbAdapter->quoteIdentifier('product_name');

        $stmt = $this->sharedFixture->dbAdapter->prepare("INSERT INTO $products ($product_id, $product_name) VALUES (:product_id, :product_name)");
        $stmt->execute(array('product_id' => 4, 'product_name' => 'Solaris'));

        $select = $this->sharedFixture->dbAdapter->select()
            ->from('zf_products')
            ->where("$product_id = 4");
        $result = $this->sharedFixture->dbAdapter->fetchAll($select);
        $stmt->closeCursor();

        $this->assertEquals(array(array('product_id'=>4, 'product_name'=>'Solaris')), $result);
    }

    public function testStatementFetchAllStyleBoth()
    {
        $this->markTestIncomplete($this->sharedFixture->dbUtility->getDriverName() . ' driver does not support fetchAll(FETCH_BOTH)');
    }

    public function testStatementGetColumnMeta()
    {
        $this->markTestIncomplete($this->sharedFixture->dbUtility->getDriverName() . ' has not implemented getColumnMeta() yet [ZF-1424]');
    }

    public function testStatementNextRowset()
    {
        $select = $this->sharedFixture->dbAdapter->select()
            ->from('zf_products');
        $stmt = $this->sharedFixture->dbAdapter->prepare($select->__toString());
        try {
            $stmt->nextRowset();
            $this->fail('Expected to catch Zend_Db_Statement_Oracle_Exception');
        } catch (Zend_Exception $e) {
            $this->assertType('Zend_Db_Statement_Oracle_Exception', $e,
                'Expecting object of type Zend_Db_Statement_Oracle_Exception, got '.get_class($e));
            $this->assertEquals('HYC00 Optional feature not implemented', $e->getMessage());
        }
        $stmt->closeCursor();
    }

    /**
     * @group ZF-5927
     */
    public function testStatementReturnNullWithEmptyField()
    {
        $products = $this->sharedFixture->dbAdapter->quoteIdentifier('zf_products');
        $product_id = $this->sharedFixture->dbAdapter->quoteIdentifier('product_id');
        $product_name = $this->sharedFixture->dbAdapter->quoteIdentifier('product_name');

        $stmt = $this->sharedFixture->dbAdapter->prepare("INSERT INTO $products ($product_id, $product_name) VALUES (:product_id, :product_name)");
        $stmt->execute(array('product_id' => 4, 'product_name' => null));

        $select = $this->sharedFixture->dbAdapter->select()
                       ->from('zf_products')
                       ->where("$product_id = 4");

        $result = $this->sharedFixture->dbAdapter->fetchAll($select);
        $this->assertTrue(array_key_exists('product_name', $result[0]), 'fetchAll must return null for empty fields with Oracle');
        $result = $this->sharedFixture->dbAdapter->fetchRow($select);
        $this->assertTrue(array_key_exists('product_name', $result), 'fetchRow must return null for empty fields with Oracle');
    }

    public function testStatementSetFetchModeBoth()
    {
        $this->markTestIncomplete($this->sharedFixture->dbUtility->getDriverName() . ' does not implement FETCH_BOTH correctly.');
    }

    public function getDriver()
    {
        return 'Oracle';
    }
}