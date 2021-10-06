<?php

namespace Kraftausdruck\Extensions;

use SilverStripe\Assets\Folder;
use SilverStripe\Core\Extension;

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
        $parentFolderLink = $this->owner->parent()->getFilename();

        // get all keys from a array that start with a certain string
        // https://stackoverflow.com/questions/4979238/how-to-get-all-keys-from-a-array-that-start-with-a-certain-string
        $shouldBlock = [];
        foreach ($blockingFoldersArr as $key => $value) {
            if (strpos($value, $parentFolderLink) === 0) {
                $shouldBlock[$key] = $value;
            }
        }

        if (count($shouldBlock))
        {
            // should return smallest string - top most
            usort($shouldBlock, function ($a, $b) {
                return strlen($a) < strlen($b);
            });
            $folderLink = reset($shouldBlock);
            $cause = Folder::get()->filter(['File.FileFilename' => $folderLink])->first();
            return $cause;
        } else {
            return false;
        }
    }
}
