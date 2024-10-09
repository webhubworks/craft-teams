<?php

namespace webhubworks\teams\elements\db;

use craft\elements\db\ElementQuery;

/**
 * Team query
 */
class TeamQuery extends ElementQuery
{
    protected function beforePrepare(): bool
    {
        // JOIN our `products` table:
        $this->joinElementTable('teams');

        return parent::beforePrepare();
    }
}
