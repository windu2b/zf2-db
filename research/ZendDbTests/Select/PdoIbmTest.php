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
 * @version    $Id: PdoIbmTest.php 16269 2009-06-24 13:38:15Z ralph $
 */


/**
 * @see Zend_Db_Select_AbstractTestCase
 */
require_once 'Zend/Db/Select/AbstractTestCase.php';


PHPUnit_Util_Filter::addFileToFilter(__FILE__);


/**
 * @category   Zend
 * @package    Zend_Db
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Db_Select_PdoIbmTest extends Zend_Db_Select_AbstractTestCase
{

    public function testSelectGroupByExpr()
    {
       $server = $this->sharedFixture->dbUtility->getServer();

        if ($server == 'IDS') {
            $this->markTestIncomplete('IDS does not support this SQL syntax');
        } else {
            parent::testSelectGroupByExpr();
        }
    }

    public function testSelectGroupByAutoExpr()
    {
       $server = $this->sharedFixture->dbUtility->getServer();

        if ($server == 'IDS') {
            $this->markTestIncomplete('IDS does not support this SQL syntax');
        } else {
            parent::testSelectGroupByAutoExpr();
        }
    }

    public function testSelectJoinCross()
    {
        $this->markTestSkipped($this->sharedFixture->dbUtility->getDriverName() . ' adapter support for CROSS JOIN not yet available');
    }
}
