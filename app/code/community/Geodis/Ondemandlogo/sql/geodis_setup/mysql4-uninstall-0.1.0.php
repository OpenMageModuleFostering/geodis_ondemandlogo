<?php
$installer = $this;

$installer->startSetup();

$installer->run("
DROP TABLE IF EXISTS {$this->getTable('geodis_ondemandlogo')};
DELETE FROM {$this->getTable('core/config_data')} WHERE path like 'geodis%';
DELETE FROM {$this->getTable('core/resource')} WHERE code like 'geodis_setup';
");

$installer->endSetup();
