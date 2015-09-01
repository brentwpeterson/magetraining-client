<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('helpclient')};
CREATE TABLE {$this->getTable('helpclient')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `product_id` int(11) unsigned NOT NULL,
	  `name` varchar(255) NOT NULL default '',
	  `type` varchar(255) NOT NULL default '',
	  `product_url` varchar(255) NOT NULL default '',
	  `locale_code` varchar(255) NOT NULL default 'en_US',
	  `front_module` varchar(255) NOT NULL default 'Mage_Adminhtml',
	  `controller_name` varchar(255) NOT NULL default '',
	  `action_name` varchar(255) NOT NULL default '',
	  `suffix` varchar(255) NOT NULL default '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- DROP TABLE IF EXISTS {$this->getTable('helpclient_video')};
CREATE TABLE {$this->getTable('helpclient_video')} (
	  `id` int(11) unsigned NOT NULL,
	  `url` varchar(255) NOT NULL default '',
	  `width` varchar(255) NOT NULL default '',
	  `height` varchar(255) NOT NULL default '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert  into {$this->getTable('helpclient_video')} (`id`,`url`,`width`,`height`) values ('1','','','');

    ");

$installer->endSetup(); 