<?php

namespace webhubworks\teams\elements\conditions;

use Craft;
use craft\elements\conditions\ElementCondition;

/**
 * Team condition
 */
class TeamCondition extends ElementCondition
{
    protected function selectableConditionRules(): array
    {
        return array_merge(parent::conditionRuleTypes(), [
            // ...
        ]);
    }
}
