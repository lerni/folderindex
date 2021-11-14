<?php

namespace Kraftausdruck\Extensions;

use SilverStripe\Assets\Folder;
use SilverStripe\View\TemplateGlobalProvider;

class FolderIndexTemplateUtils implements TemplateGlobalProvider {

    private static $utility_functions = [
        'KraftausdruckFolderIndex'
    ];

    public static function get_template_global_variables() {
        return static::$utility_functions;
    }

    public static function KraftausdruckFolderIndex() {
        $blockingFolders = Folder::get()->filter(['ShowInSearch' => 0]);
        $blockingFoldersArr = [];
        foreach ($blockingFolders as $bf) {
            $blockingFoldersArr[$bf->ID] = $bf->getFilename();
        }

        $topBlockingFoldersArr = [];
        $shouldBlock = [];
        foreach ($blockingFoldersArr as $key => $bf) {
            unset($blockingFoldersArr[$key]);
            foreach ($blockingFoldersArr as $key => $value) {
                if (strpos($value, $bf) === 0) {
                    array_push($shouldBlock, $key);
                }
            }
        }
        if(count($shouldBlock)) {
            $blockingFolders = $blockingFolders->exclude(['ID' => $shouldBlock]);
        }

        return $blockingFolders;
    }
}
