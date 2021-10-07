<?php

namespace Kraftausdruck\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;

class IndexFormFileExtension extends Extension
{
    public function updateFormFields(FieldList $fields, $controller, $formName, $context)
    {
        $editorTab = $fields->findTab('Editor.Details');
        $record = isset($context['Record']) ? $context['Record'] : null;
        if ($editorTab && $record->NonFileIndex()) {
            $message = _t('Kraftausdruck\Extensions\IndexFormFileExtension.NoindexNotification', 'Indexing disabled per parent folder ({parent})!', ['parent' => $record->Parent()->Title]);
            $NoIndexNotificationField = LiteralField::create('X-Robots-Tag', '<p class="alert alert-warning">' . $message . '</p>');
            $fields->insertBefore('Title', $NoIndexNotificationField);
        }
    }
}
