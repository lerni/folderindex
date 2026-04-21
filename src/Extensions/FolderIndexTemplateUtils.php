<?php

namespace Kraftausdruck\Extensions;

use SilverStripe\Assets\File;
use SilverStripe\Assets\Folder;
use SilverStripe\ORM\DataObject;
use SilverStripe\Model\List\ArrayList;
use SilverStripe\View\TemplateGlobalProvider;

class FolderIndexTemplateUtils implements TemplateGlobalProvider
{
    private static $utility_functions = [
        'KraftausdruckFolderIndex',
    ];

    public static function get_template_global_variables()
    {
        return static::$utility_functions;
    }

    public static function KraftausdruckFolderIndex()
    {
        // Avoid querying assets tables while db:build --flush is still creating columns.
        if (!DataObject::getSchema()->tablesAreReadyForClass(File::class)) {
            return new ArrayList([]);
        }

        $blockingFolders = Folder::get()->filter(['ShowInSearch' => 0]);
        $blockingFoldersArr = [];
        foreach ($blockingFolders as $bf) {
            $blockingFoldersArr[$bf->ID] = $bf->getFilename();
        }

        $subBlockingFoldersArr = [];
        foreach ($blockingFoldersArr as $key => $bf) {
            unset($blockingFoldersArr[$key]);
            foreach ($blockingFoldersArr as $key => $value) {
                if (strpos($value, $bf) === 0) {
                    array_push($subBlockingFoldersArr, $key);
                }
            }
        }
        if (count($subBlockingFoldersArr)) {
            $blockingFolders = $blockingFolders->exclude(['ID' => $subBlockingFoldersArr]);
        }

        return $blockingFolders;
    }
}
