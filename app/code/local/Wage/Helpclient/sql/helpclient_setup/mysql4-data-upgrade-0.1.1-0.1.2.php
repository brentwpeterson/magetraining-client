<?php

$installer = $this;

$installer->startSetup();


$installer->getConnection()->changeColumn(
    $installer->getTable('helpclient'), 'short_description', 'help_module_description', 'varchar(255)'
);

$installer->endSetup();