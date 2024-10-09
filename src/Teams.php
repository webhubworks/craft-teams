<?php

namespace webhubworks\teams;

use Craft;
use craft\base\Model;
use craft\base\Plugin;
use craft\events\PluginEvent;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterUrlRulesEvent;
use craft\helpers\Json;
use craft\services\Elements;
use craft\services\Plugins;
use craft\web\UrlManager;
use webhubworks\teams\elements\Team;
use webhubworks\teams\models\Settings;
use yii\base\Event;

/**
 * Teams plugin
 *
 * @method static Teams getInstance()
 * @method Settings getSettings()
 * @author webhubworks <support@webhub.de>
 * @copyright webhubworks
 * @license https://craftcms.github.io/license/ Craft License
 */
class Teams extends Plugin
{
    public string $schemaVersion = '1.0.0';
    public bool $hasCpSettings = true;

    public static function config(): array
    {
        return [
            'components' => [
                // Define component configs here...
            ],
        ];
    }

    public function init(): void
    {
        parent::init();

        $this->attachEventHandlers();

        // Any code that creates an element query or loads Twig should be deferred until
        // after Craft is fully initialized, to avoid conflicts with other plugins/modules
        Craft::$app->onInit(function() {
            // ...
        });
    }

    protected function createSettingsModel(): ?Model
    {
        return Craft::createObject(Settings::class);
    }

    protected function settingsHtml(): ?string
    {
        return Craft::$app->view->renderTemplate('craft-teams/_settings.twig', [
            'plugin' => $this,
            'settings' => $this->getSettings(),
        ]);
    }

    private function attachEventHandlers(): void
    {
        // Register event handlers here ...
        // (see https://craftcms.com/docs/5.x/extend/events.html to get started)
        Event::on(Elements::class, Elements::EVENT_REGISTER_ELEMENT_TYPES, function (RegisterComponentTypesEvent $event) {
            $event->types[] = Team::class;
        });
        Event::on(UrlManager::class, UrlManager::EVENT_REGISTER_CP_URL_RULES, function (RegisterUrlRulesEvent $event) {
            $event->rules['teams'] = ['template' => 'craft-teams/teams/_index.twig'];
            $event->rules['teams/<elementId:\\d+>'] = 'elements/edit';
        });
        \craft\base\Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_SAVE_PLUGIN_SETTINGS,
            function (PluginEvent $event) {
                if ($event->plugin->handle !== $this->handle) {
                    return;
                }
                $fieldLayout = Craft::$app->getFields()->assembleLayoutFromPost('settings');
                $fieldLayout->type = Team::class;
                Craft::$app->getFields()->saveLayout($fieldLayout);
            }
        );
    }
}
