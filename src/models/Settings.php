<?php

namespace webhubworks\teams\models;

use Craft;
use craft\base\Model;

/**
 * Teams settings
 */
class Settings extends Model
{
    public string $teamLabelSingular = 'Team';
    public string $teamLabelPlural = 'Teams';

    public bool $isMultiMembershipAllowed = true;

    public function rules(): array
    {
        return [
            [['isMultiMembershipAllowed'], 'boolean'],
            [['teamLabelSingular', 'teamLabelPlural'], 'string'],
        ];
    }
}
