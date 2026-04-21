<?php

namespace Kraftausdruck\Extensions;

use SilverStripe\Assets\Folder;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;

class IndexFormFileExtension extends Extension
{
    protected function updateFormFields(FieldList $fields, $controller, $formName, $context): void
    {
        $editorTab = $fields->findTab('Editor.Details');
        $record = isset($context['Record']) ? $context['Record'] : null;

        if (!$editorTab || !$record) {
            return;
        }

        $noFileIndex = $record->NoFileIndex();
        if ($noFileIndex instanceof Folder) {
            $message = _t('Kraftausdruck\Extensions\IndexFormFileExtension.NoindexNotification', 'Indexing disabled per parent folder ({parent})!', ['parent' => $noFileIndex->Title]);
            $NoIndexNotificationField = LiteralField::create('X-Robots-Tag', '<p class="alert alert-warning">' . $message . '</p>');
            $fields->insertBefore('Title', $NoIndexNotificationField);
        }
    }
}
