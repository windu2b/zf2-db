<?php

namespace Zend\Db\Adapter\Platform;

class Sql92 implements \Zend\Db\Adapter\Platform\Platform
{
    public function getName()
    {
        return 'Sql92';
    }
    
    public function getQuoteIdentifierSymbol()
    {
        return '"';
    }
    
    public function quoteIdentifier($identifier)
    {
        $qis = $this->getQuoteIdentifierSymbol();
        return $qis . str_replace($qis, '\\' . $qis, $identifier) . $qis;
    }
    
    public function getQuoteValueSymbol()
    {
        return '\'';
    }
    
    public function quoteValue($value)
    {
        $qvs = $this->getQuoteValueSymbol();
        return $qvs . str_replace($qvs, '\\' . $qvs, $value) . $qvs;
    }
}
