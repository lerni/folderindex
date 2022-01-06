<?php

namespace Kraftausdruck\Extensions;

use SilverStripe\Assets\Folder;
use SilverStripe\Core\Extension;
use SilverStripe\Assets\Flysystem\PublicAssetAdapter;

class FileIndexExtension extends Extension
{
    // returns Folder-DataObject causing blocking, otherwise false
    public function NoFileIndex()
    {
        $blockingFolders = Folder::get()->filter(['ShowInSearch' => 0]);
        if ($blockingFolders->count()) {

            // query URL doesn't work cause of filesystem abstraction
            // https://github.com/silverstripe/silverstripe-assets/issues/253
            // Folder::get()->filter(['File.FileFilename' => $folderLink])->first();
            // firing up flysystemAssetStore and try to "reverse-lookup" feels to heavy

            // so we iterate up to next parent with ShowInSearch = 0
            $parentIterInstance = $this->owner->parent();
            $counter = 0;
            $max = 10;
            while($parentIterInstance->ShowInSearch and ($counter < $max)) {
                $parentIterInstance = $parentIterInstance->parent();
                $counter++;
            }
            if ($parentIterInstance->ID != 0) {
                return $parentIterInstance;
            }

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
