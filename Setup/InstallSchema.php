<?php
/**
 * Created by PhpStorm.
 * User: vietdung
 * Date: 27/02/2019
 * Time: 11:23
 */

namespace Vietdung\Blogg\Setup;


use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
  public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
  {
      $setup->startSetup();
      $conn = $setup->getConnection();
      $tableName = $setup->getTable('blogg');
      if (!$conn->isTableExists($tableName)) {
          $table = $conn->newTable($tableName)
              ->addColumn(
                  "id",
                  Table::TYPE_INTEGER,
                  null,
                  [
                      "primary" => true,
                      "identity" => true,
                      "unsigned" => true,
                      "nullable" => false
                  ]
              )->addColumn(
                  "store_id",
                  Table::TYPE_INTEGER,
                  null,
                  [
                      "nullable" => false,
                  ]
              )->addColumn(
                  "title",
                  Table::TYPE_TEXT,
                  72,
                  [
                      "nullable" => false,
                  ]
              )->addColumn(
                  "description",
                  Table::TYPE_TEXT,
                  255,
                  [
                      "nullable" => true,
                  ]
              )->addColumn(
                  "content",
                  Table::TYPE_TEXT,
                  255,
                  [
                      "nullable" => false,
                  ]
              )->addColumn(
                  "image",
                  Table::TYPE_TEXT,
                  255,
                  [
                      "nullable" => true,
                  ]
              )->addColumn(
                  "slug",
                  Table::TYPE_TEXT,
                  255,
                  [
                      "nullable" => false,
                      "unique" => true
                  ]
              )->addColumn(
                  "start_date",
                  Table::TYPE_TIMESTAMP,
                  null,
                  [
                      "nullable" => true,
                  ]
              )->addColumn(
                  "end_date",
                  Table::TYPE_TIMESTAMP,
                  null,
                  [
                      "nullable" => true,
                  ]
              )->addColumn(
                  "create_at",
                  Table::TYPE_TIMESTAMP,
                  null,
                  [
                      'nullable' => false,
                      'default' => Table::TIMESTAMP_INIT,
                  ],
                  'Blog Creation Time'
              )->addColumn(
                  "updated_at",
                  Table::TYPE_TIMESTAMP,
                  null,
                  [
                      'nullable' => false,
                      'default' => Table::TIMESTAMP_INIT_UPDATE,
                  ],
                  'Blog Update Time'
              )->setOption("charset", "utf8");

          $conn->createTable($table);
      }
      $setup->endSetup();
  }
}