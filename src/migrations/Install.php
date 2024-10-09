<?php

namespace webhubworks\teams\migrations;

use Craft;
use craft\db\Migration;

/**
 * Install migration.
 */
class Install extends Migration
{
    public static string $teamsTableName = '{{%teams_teams}}';

    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        $this->createTable(self::$teamsTableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'dateCreated' => $this->dateTime()->notNull(),
            'dateUpdated' => $this->dateTime()->notNull(),
            'uid' => $this->uid(),
        ]);

        $this->addForeignKey(
            null,
            self::$teamsTableName,
            'id',
            '{{%elements}}',
            'id',
            'CASCADE',
            null
        );

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown(): bool
    {
        $this->dropTableIfExists(self::$teamsTableName);

        return true;
    }
}
