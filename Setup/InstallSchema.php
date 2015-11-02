<?php 
namespace Magento\Avatar\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        $table = $installer->getConnection()
            ->newTable($installer->getTable('customer_entity_avatar'))
            ->addColumn(
                'value_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Avatar ID'
            )
            ->addColumn('customer_id', Table::TYPE_INTEGER, 10, ['nullable' => false,'unsigned'=>true])
            ->addColumn('value', Table::TYPE_TEXT, 255, ['nullable' => true], 'Image Path')            
            ->addIndex($installer->getIdxName('avatar_value', ['value']), ['value'])
            
            ->setComment('Customer Avatars');

        $table->addForeignKey('blah','customer_id','customer_entity','entity_id');

        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }

}
