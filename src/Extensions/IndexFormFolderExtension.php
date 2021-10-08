<?php

namespace Kraftausdruck\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\CheckboxField;

class IndexFormFolderExtension extends Extension
{
    // public function updateForm(Form &$form)
    public function updateFormFields(FieldList $fields)
    {
        // $fields = $form->Fields();
        $ShowInSearchField = CheckboxField::create('ShowInSearch', _t('Kraftausdruck\Extensions\IndexFormFileExtension.ShowInSearch', 'Indexing child files'));

        $permissionTab = $fields->findTab('Editor.Permissions');
        if ($permissionTab) {
            $fields->insertAfter('EditorGroups', $ShowInSearchField);
        }
    }
}
