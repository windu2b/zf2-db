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

require_once 'Zend/Db/Table/Select/AbstractTestCase.php';

PHPUnit_Util_Filter::addFileToFilter(__FILE__);

class Zend_Db_Table_Select_Db2Test extends Zend_Db_Table_Select_AbstractTestCase
{

    /**
     * ZF-5234: this test must be done on string field
     */
    protected function _selectColumnWithColonQuotedParameter ()
    {
        $product_name = $this->sharedFixture->dbAdapter->quoteIdentifier('product_name');

        $select = $this->sharedFixture->dbAdapter->select()
                            ->from('zf_products')
                            ->where($product_name . ' = ?', "as'as:x");
        return $select;
    }
    
    public function testSelectJoinCross()
    {
        $this->markTestSkipped($this->sharedFixture->dbUtility->getDriverName() . ' does not support CROSS JOIN');
    }

    public function testSelectQueryWithBinds()
    {
        $this->markTestSkipped($this->sharedFixture->dbUtility->getDriverName() . ' does not support named bound parameters');
    }
    
    
    public function getDriver()
    {
        return 'Db2';
    }

}
