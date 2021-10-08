<?php

namespace Kraftausdruck\Extensions;

use SilverStripe\Assets\Folder;
use SilverStripe\Core\Extension;
use SilverStripe\Assets\Flysystem\PublicAssetAdapter;

class FileIndexExtension extends Extension
{
    // returns Folder-DataObject causing blocking it, otherwise false
    public function NonFileIndex()
    {
        $blockingFolders = Folder::get()->filter(['ShowInSearch' => 0]);
        $blockingFoldersArr = [];
        foreach ($blockingFolders as $bf) {
            array_push($blockingFoldersArr, $bf->getFilename());
        }
        // explode to compare to just fist folder
        $parentFolderLink = $this->owner->parent()->getFilename();
        $parentFolderLinkArr = explode('/', $parentFolderLink);
        $firstParentFolderLinkDirectory = $parentFolderLinkArr[0] . '/';

        // get all keys from a array that start with a certain string
        // https://stackoverflow.com/questions/4979238/how-to-get-all-keys-from-a-array-that-start-with-a-certain-string
        $shouldBlock = [];
        foreach ($blockingFoldersArr as $key => $value) {
            if (strpos($value, $firstParentFolderLinkDirectory) === 0) {
                $shouldBlock[$key] = $value;
            }
        }

        if (count($shouldBlock)) {
            // should return smallest string - top most
            // usort($shouldBlock, function ($a, $b) {
            //     return strlen($a) < strlen($b);
            // });
            // $folderLink = reset($shouldBlock);

            // query URL doesn't work cause of filesystem abstraction
            // https://github.com/silverstripe/silverstripe-assets/issues/253
            // Folder::get()->filter(['File.FileFilename' => $folderLink])->first();
            // firing up flysystemAssetStore and try to "reverse-lookup" feels to heavy

            // so we iterate up to next parent with ShowInSearch = 0
            $parentIterInstance = $this->owner->parent();
            while($parentIterInstance->ShowInSearch) {
                $parentIterInstance = $parentIterInstance->parent();
            }
            return $parentIterInstance;

        } else {
            return false;
        }
    }

    public function onAfterWrite()
    {
        if ($this->owner->isChanged('ShowInSearch')) {
            $assets = new PublicAssetAdapter;
            $assets->flush();
        }
    }
}
