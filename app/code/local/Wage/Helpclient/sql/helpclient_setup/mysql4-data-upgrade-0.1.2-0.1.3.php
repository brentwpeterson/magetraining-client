<?php

$installer = $this;

$installer->startSetup();

$table = $installer->getTable('helpclient/helpclient');

$installer->getConnection()
    ->addColumn($table,
        'status',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'length' => 12,
            'nullable' => false,
            'default' => 0,
            'comment' => 'Status'
        )
    ); 

$installer->endSetup();
