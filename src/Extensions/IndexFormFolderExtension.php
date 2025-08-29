<?php

namespace Kraftausdruck\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\CheckboxField;

class IndexFormFolderExtension extends Extension
{
    protected function updateFormFields(FieldList $fields, $controller, $formName, $context): void
    {
        // $fields = $form->Fields();
        $ShowInSearchField = CheckboxField::create('ShowInSearch', _t('Kraftausdruck\Extensions\IndexFormFileExtension.ShowInSearch', 'Indexing child files'));

        $record = isset($context['Record']) ? $context['Record'] : null;
        if (!$record) {
            // make sure default value true is respected
            $ShowInSearchField->setValue('true');
        }
        $permissionTab = $fields->findTab('Editor.Permissions');
        if ($permissionTab) {
            $fields->insertAfter('EditorGroups', $ShowInSearchField);
        }
    }
}
