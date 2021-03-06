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
 * @version    $Id: AbstractTestCase.php 16086 2009-06-16 05:20:50Z ralph $
 */


/**
 * @see Zend_Db_TestCase
 */
require_once 'Zend/Db/TestSuite/AbstractTestCase.php';


PHPUnit_Util_Filter::addFileToFilter(__FILE__);


/**
 * @category   Zend
 * @package    Zend_Db
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
abstract class Zend_Db_Profiler_AbstractTestCase extends Zend_Db_TestSuite_AbstractTestCase
{

    public function setUp()
    {
        parent::setUp();
        $this->sharedFixture->dbAdapter->getProfiler()->setEnabled(true);
    }

    public function tearDown()
    {
        $this->sharedFixture->dbAdapter->getProfiler()->setEnabled(false);
        parent::tearDown();
    }

    public function testProfilerPreparedStatement()
    {
        $bug_id = $this->sharedFixture->dbAdapter->quoteIdentifier('bug_id', true);

        // prepare a query
        $select = $this->sharedFixture->dbAdapter->select()
            ->from('zf_bugs')
            ->where("$bug_id = 2");
        $stmt = $this->sharedFixture->dbAdapter->prepare($select->__toString());

        // execute query a first time
        $stmt->execute();
        $results = $stmt->fetchAll();
        $this->assertType('array', $results);
        $this->assertEquals(2, $results[0]['bug_id']);

        // analyze query profiles
        $profiles = $this->sharedFixture->dbAdapter->getProfiler()->getQueryProfiles();
        $this->assertType('array', $profiles);
        $this->assertEquals(1, count($profiles), 'Expected to find 1 profile');
        $qp = $profiles[0];
        $this->assertType('Zend_Db_Profiler_Query', $qp);

        // execute query a second time
        $stmt->execute();
        $results = $stmt->fetchAll();
        $this->assertType('array', $results);
        $this->assertEquals(2, $results[0]['bug_id']);

        // analyze query profiles
        $profiles = $this->sharedFixture->dbAdapter->getProfiler()->getQueryProfiles();
        $this->assertType('array', $profiles);
        $this->assertEquals(2, count($profiles), 'Expected to find 2 profiles');
        $qp = $profiles[1];
        $this->assertType('Zend_Db_Profiler_Query', $qp);

        $this->assertNotSame($profiles[0], $profiles[1]);
        $this->assertEquals($profiles[0]->getQuery(), $profiles[1]->getQuery());
    }

    public function testProfilerPreparedStatementWithParams()
    {
        $bug_id = $this->sharedFixture->dbAdapter->quoteIdentifier('bug_id', true);
        $bug_status = $this->sharedFixture->dbAdapter->quoteIdentifier('bug_status', true);

        // prepare a query
        $select = $this->sharedFixture->dbAdapter->select()
            ->from('zf_bugs')
            ->where("$bug_id = ? AND $bug_status = ?");
        $stmt = $this->sharedFixture->dbAdapter->prepare($select->__toString());

        // execute query a first time
        $stmt->execute(array(2, 'VERIFIED'));
        $results = $stmt->fetchAll();
        $this->assertType('array', $results);
        $this->assertEquals(2, $results[0]['bug_id']);

        // analyze query profiles
        $profiles = $this->sharedFixture->dbAdapter->getProfiler()->getQueryProfiles();
        $this->assertType('array', $profiles);
        $this->assertEquals(1, count($profiles), 'Expected to find 1 profile');
        $qp = $profiles[0];
        $this->assertType('Zend_Db_Profiler_Query', $qp);

        // analyze query in the profile
        $sql = $qp->getQuery();
        $this->assertContains(" = ?", $sql);
        $params = $qp->getQueryParams();
        $this->assertType('array', $params);
        $this->assertEquals(array(1 => 2, 2 => 'VERIFIED'), $params);

        // execute query a second time
        $stmt->execute(array(3, 'FIXED'));
        $results = $stmt->fetchAll();
        $this->assertType('array', $results);
        $this->assertEquals(3, $results[0]['bug_id']);

        // analyze query profiles
        $profiles = $this->sharedFixture->dbAdapter->getProfiler()->getQueryProfiles();
        $this->assertType('array', $profiles);
        $this->assertEquals(2, count($profiles), 'Expected to find 2 profiles');
        $qp = $profiles[1];
        $this->assertType('Zend_Db_Profiler_Query', $qp);
        $this->assertNotSame($profiles[0], $profiles[1]);
        $this->assertEquals($profiles[0]->getQuery(), $profiles[1]->getQuery());

        // analyze query in the profile
        $sql = $qp->getQuery();
        $this->assertContains(" = ?", $sql);
        $params = $qp->getQueryParams();
        $this->assertType('array', $params);
        $this->assertEquals(array(1 => 3, 2 => 'FIXED'), $params);

        $this->assertNotSame($profiles[0], $profiles[1]);
        $this->assertEquals($profiles[0]->getQuery(), $profiles[1]->getQuery());
    }

    public function testProfilerPreparedStatementWithBoundParams()
    {
        $bug_id = $this->sharedFixture->dbAdapter->quoteIdentifier('bug_id', true);
        $bug_status = $this->sharedFixture->dbAdapter->quoteIdentifier('bug_status', true);

        // prepare a query
        $select = $this->sharedFixture->dbAdapter->select()
            ->from('zf_bugs')
            ->where("$bug_id = ? AND $bug_status = ?");
        $stmt = $this->sharedFixture->dbAdapter->prepare($select->__toString());

        // execute query a first time
        $id = 1;
        $status = 'NEW';
        $this->assertTrue($stmt->bindParam(1, $id));
        $this->assertTrue($stmt->bindParam(2, $status));
        $id = 2;
        $status = 'VERIFIED';
        $stmt->execute();
        $results = $stmt->fetchAll();
        $this->assertType('array', $results);
        $this->assertEquals(2, $results[0]['bug_id']);

        // analyze query profiles
        $profiles = $this->sharedFixture->dbAdapter->getProfiler()->getQueryProfiles();
        $this->assertType('array', $profiles, 'Expected array, got '.gettype($profiles));
        $this->assertEquals(1, count($profiles), 'Expected to find 1 profile');
        $qp = $profiles[0];
        $this->assertType('Zend_Db_Profiler_Query', $qp);

        // analyze query in the profile
        $sql = $qp->getQuery();
        $this->assertContains(" = ?", $sql);
        $params = $qp->getQueryParams();
        $this->assertType('array', $params);
        $this->assertEquals(array(1 => 2, 2 => 'VERIFIED'), $params);

        // execute query a second time
        $id = 3;
        $status = 'FIXED';
        $stmt->execute();
        $results = $stmt->fetchAll();
        $this->assertType('array', $results);
        $this->assertEquals(3, $results[0]['bug_id']);

        // analyze query profiles
        $profiles = $this->sharedFixture->dbAdapter->getProfiler()->getQueryProfiles();
        $this->assertType('array', $profiles, 'Expected array, got '.gettype($profiles));
        $this->assertEquals(2, count($profiles), 'Expected to find 2 profiles');
        $qp = $profiles[1];
        $this->assertType('Zend_Db_Profiler_Query', $qp);

        // analyze query in the profile
        $sql = $qp->getQuery();
        $this->assertContains(" = ?", $sql);
        $params = $qp->getQueryParams();
        $this->assertType('array', $params);
        $this->assertEquals(array(1 => 3, 2 => 'FIXED'), $params);
    }

    /**
     * Ensures that setFilterQueryType() actually filters
     *
     * @return void
     */
    protected function _testProfilerSetFilterQueryTypeCommon($queryType)
    {
        $bugs = $this->sharedFixture->dbAdapter->quoteIdentifier('zf_bugs', true);
        $bug_status = $this->sharedFixture->dbAdapter->quoteIdentifier('bug_status', true);

        $prof = $this->sharedFixture->dbAdapter->getProfiler();
        $prof->setEnabled(true);

        $this->assertSame($prof->setFilterQueryType($queryType), $prof);
        $this->assertEquals($queryType, $prof->getFilterQueryType());

        $this->sharedFixture->dbAdapter->query("SELECT * FROM $bugs");
        $this->sharedFixture->dbAdapter->query("INSERT INTO $bugs ($bug_status) VALUES (?)", array('NEW'));
        $this->sharedFixture->dbAdapter->query("DELETE FROM $bugs");
        $this->sharedFixture->dbAdapter->query("UPDATE $bugs SET $bug_status = ?", array('FIXED'));

        $qps = $prof->getQueryProfiles();
        $this->assertType('array', $qps, 'Expecting some query profiles, got none');
        foreach ($qps as $qp) {
            $qtype = $qp->getQueryType();
            $this->assertEquals($queryType, $qtype,
                "Found query type $qtype, which should have been filtered out");
        }

        $prof->setEnabled(false);
    }

    public function testProfilerSetFilterQueryTypeInsert()
    {
        $this->_testProfilerSetFilterQueryTypeCommon(Zend_Db_Profiler::INSERT);
    }

    public function testProfilerSetFilterQueryTypeUpdate()
    {
        $this->_testProfilerSetFilterQueryTypeCommon(Zend_Db_Profiler::UPDATE);
    }

    public function testProfilerSetFilterQueryTypeDelete()
    {
        $this->_testProfilerSetFilterQueryTypeCommon(Zend_Db_Profiler::DELETE);
    }

    public function testProfilerSetFilterQueryTypeSelect()
    {
        $this->_testProfilerSetFilterQueryTypeCommon(Zend_Db_Profiler::SELECT);
    }


}
