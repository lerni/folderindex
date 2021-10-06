<?php

namespace Kraftausdruck\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;

class IndexFormFileExtension extends Extension
{
    public function updateFormFields(FieldList $fields)
    {
        $editorTab = $fields->findTab('Editor.Details');
        // how to get the record?
        // if ($editorTab && !$this->owner->record->ImageIndex())
        if ($editorTab)
        {
            $message = _t('Kraftausdruck\Extensions\IndexFormFileExtension.NoindexNotification', 'Indexing disabled per parent folder!');
            $NoIndexNotificationField = LiteralField::create('NoParent', '<p class="alert alert-warning">'. $message .'</p>');
            $fields->insertBefore('Title', $NoIndexNotificationField);
        }
    }
}
