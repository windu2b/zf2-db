<?php

namespace Zend\Db\Adapter\Driver\Mysqli;
use Zend\Db\Adapter;


class Connection implements Adapter\DriverConnection
{
	/**
	 * @var \Zend\Db\Adapter\Driver\AbstractDriver
	 */
	protected $driver = null;
	
	protected $connectionParams = array();
	
	/**
	 * @var \mysqli
	 */
    protected $resource = null;

    protected $inTransaction = false;
    
    protected $openMysqliResultSets = array();
    
    public function __construct(Adapter\AbstractDriver $driver, array $connectionParameters)
    {
        $this->driver = $driver;
        $this->connectionParams = $connectionParameters;
    }
    
    public function getConnectionParams()
    {
        return $this->connectionParams;
    }
    
    public function getDefaultCatalog()
    {
        return null;
    }
    
    public function getDefaultSchema()
    {
        if (!$this->isConnected()) {
            $this->connect();
        }
        
        $result = $this->resource->query('SELECT DATABASE()');
        $r = $result->fetch_row();
        return $r[0];
    }
    
    /**
     * @return \Mysqli
     */
    public function getResource()
    {
    	return $this->resource;
    }
    
    public function connect()
    {
        if ($this->resource) {
            return;
        }

        $host = $username = $password = $dbname = $port = $socket = null;
        foreach (array('host', 'username', 'password', 'dbname', 'port', 'socket') as $c) {
        	if (isset($this->connectionParams[$c])) {
                switch ($c) {
                    case 'port': 
                        $this->connectionParams[$c] = (int) $this->connectionParams[$c];
                    default:
                        $$c = $this->connectionParams[$c];
                }
        	}
        }
        
        $this->resource = new \Mysqli($host, $username, $password, $dbname, $port, $socket);

        if ($this->resource->connect_error) {
            throw new \Exception('Connect Error (' . $this->resource->connect_errno . ') ' . $this->resource->connect_error);
        }

        if (!empty($this->connectionParams['charset'])) {
            $this->resource->set_charset($this->resource, $this->connectionParams['charset']);
        }

    }
    
    public function isConnected()
    {
    	return ($this->resource instanceof Mysqli);
    }
    
    public function disconnect()
    {
        $this->resource->close();
    	unset($this->resource);
    }
    
    public function beginTransaction()
    {
        $this->resource->autocommit(false);
        $this->inTransaction = true;
    }
    
    public function commit()
    {
        if (!$this->resource) {
            $this->connect();
        }
        
        $this->resource->commit();
        
        $this->inTransaction = false;
    }
    
    public function rollback()
    {
        if (!$this->resource) {
            throw new \Exception('Must be connected before you can rollback.');
        }
        
        if (!$this->_inCommit) {
            throw new \Exception('Must call commit() before you can rollback.');
        }
        
        $this->resource->rollback();
        return $this;
    }
    
    
    public function execute($sql)
    {
    	if (!$this->isConnected()) {
    		$this->connect();
    	}
    	
    	$resultClass = $this->driver->getResultClass();
    	
    	$returnValue = $this->resource->query($sql);
    	
    	// if the returnValue is something other than a mysqli_result, bypass wrapping it
    	if ($returnValue instanceof \mysqli_result) {
            $this->openMysqliResultSets[] = $result = new $resultClass($this->driver, array(), $returnValue);
            return $result;
    	} elseif ($returnValue === false) {
    	    throw new \Zend\Db\Adapter\Exception\InvalidQueryException($this->resource->error);
    	}
    	
        return $returnValue;
    }
    
    public function prepare($sql)
    {
        if (!$this->isConnected()) {
            $this->connect();
        }
        
        $statementClass = $this->driver->getStatementClass();
        
        $mysqliStatement = $this->resource->prepare($sql);
        if ($mysqliStatement === false) {
            throw new \Exception($this->resource->error);
        }
        
        $statement = new $statementClass($this->driver, array(), $mysqliStatement);
        $statement->setSql($sql);
        
        return $statement;
    }

}
    