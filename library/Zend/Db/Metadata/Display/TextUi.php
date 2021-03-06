<?php

namespace Zend\Db\Metadata\Display;

class TextUi
{
    
    protected $camelCaseFilter = null;
    
    /**
     * @var \Zend\Db\Metadata\Metadata
     */
    //protected $metadata;
    
    public function __construct($options = array())
    {
        /*
        if (isset($options['metadata'])) {
            $this->setMetadata($options['metadata']);
        }
        */
    }
    
    
    
    public function render(\Zend\Db\Metadata\Metadata $metadata)
    {
        $output = '';
        $output .= $this->renderTables($metadata->getTableCollection());
        return $output;
    }
    
    public function renderTables(\Zend\Db\Metadata\TableCollection $tableCollection)
    {
        $output = '';
        foreach ($tableCollection as $tableMetadata) {
            $output .= $this->renderTable($tableMetadata); 
        }
        return $output;
    }
    
    public function renderTable(\Zend\Db\Metadata\Table $table)
    {
        $output = '';
        $output .= 'The \'' . $table->getName() . "' Table\n";
        $output .= $this->renderColumns($table->getColumnCollection()) . "\n";
        $output .= $this->renderConstraints($table->getConstraintCollection()) . "\n\n";
        return $output;
    }
    
    public function renderColumns(\Zend\Db\Metadata\ColumnCollection $columnCollection)
    {
        $columnAttributes = array(
            array('name', 'Name', 12),
            array('ordinalPosition', "Oridinal\nPosition", 10),
            array('columnDefault', "Column\nDefault", 8),
            array('isNullable', "Is\nNullable", 9),
            array('dataType', "Data\nType", 8),
            array('characterMaximumLength', "Chr. Max\nLength", 10),
            array('characterOctetLength', "Chr. Octet\nLength", 11),
            array('numericPrecision', "Num\nPrecision", 10),
            array('numericScale', "Num\nScale", 6),
            array('characterSetName', "Charset\nName", 8),
            array('collationName', "Collation\nName", 12),
            );
        
        $rows = $rowWidths = array();
        // make header
        foreach ($columnAttributes as $cAttrIndex => $cAttrData) {
            list($cAttrName, $cAttrDisplayName, $cAttrDefaultLength) = $cAttrData;
            $row[$cAttrIndex] = $cAttrDisplayName;
            $rowWidths[$cAttrIndex] = $cAttrDefaultLength; // default width
        }
        
        $rows[] = $row;
        
        foreach ($columnCollection as $columnMetadata) {
            $row = array();
            foreach ($columnAttributes as $cAttrIndex => $cAttrData) {
                list($cAttrName, $cAttrDisplayName, $cAttrDefaultLength) = $cAttrData;
                $value = $columnMetadata->{'get' . $cAttrName}();
                if (strlen($value) > $rowWidths[$cAttrIndex]) {
                    $rowWidths[$cAttrIndex] = strlen($value);
                }
                $row[$cAttrIndex] = (string) $value;
            }
            $rows[] = $row;
        }
        
        $table = new \Zend\Text\Table\Table(array(
            'columnWidths' => $rowWidths,
            'decorator' => 'ascii'
            ));
        foreach ($rows as $row) {
            $table->appendRow($row);
        }
        
        return 'Columns' . PHP_EOL . $table->render();
    }
    
    public function renderConstraints(\Zend\Db\Metadata\ConstraintCollection $constraints)
    {
        $rows = array();
        foreach ($constraints as $constraint) {
            $row = array();
            $row[] = $constraint->getName();
            $row[] = $constraint->getType();
            $rows[] = $row;
        }
        
        $table = new \Zend\Text\Table\Table(array(
            'columnWidths' => array(25, 25),
            'decorator' => 'ascii'
            ));
        foreach ($rows as $row) {
            $table->appendRow($row);
        }
        
        return 'Constraints: ' . PHP_EOL . $table->render();
    }
    
}