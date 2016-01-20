<?php

$installer = $this;

$installer->startSetup();


$installer->getConnection()->addColumn(
    $installer->getTable('helpclient'), 'short_description', 'varchar(255)'
);

$installer->endSetup();