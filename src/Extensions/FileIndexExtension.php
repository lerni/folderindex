<?php

namespace Kraftausdruck\Extensions;

use Psr\Log\LoggerInterface;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Folder;
use SilverStripe\Core\Extension;
use SilverStripe\ORM\DataObject;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Assets\Flysystem\PublicAssetAdapter;

/**
 * @extends Extension<object>
 */
class FileIndexExtension extends Extension
{
    private static int $max_parent_lookup_depth = 10;

    /**
     * Returns Folder-DataObject causing blocking, otherwise false
     *
     * @return Folder|false
     */
    public function NoFileIndex(): Folder|false
    {
        // Check if database is ready before querying
        // See: https://github.com/lerni/folderindex/issues/3
        // See: https://github.com/silverstripe/silverstripe-framework/issues/10332
        if (!DataObject::getSchema()->tablesAreReadyForClass(File::class)) {
            return false;
        }

        $blockingFolders = Folder::get()->filter(['ShowInSearch' => 0]);
        if ($blockingFolders->count()) {

            // query URL doesn't work cause of filesystem abstraction
            // https://github.com/silverstripe/silverstripe-assets/issues/253
            // Folder::get()->filter(['File.FileFilename' => $folderLink])->first();
            // firing up flysystemAssetStore and try to "reverse-lookup" feels to heavy

            // so we iterate up to next parent with ShowInSearch = 0
            $parentIterInstance = $this->owner->parent();
            $counter = 0;

            $max = (int) Config::inst()->get(self::class, 'max_parent_lookup_depth');

            while ($parentIterInstance && $parentIterInstance->ShowInSearch && ($counter < $max)) {
                $parentIterInstance = $parentIterInstance->parent();
                $counter++;
            }

            if ($parentIterInstance && ((int) $parentIterInstance->ID !== 0) && !$parentIterInstance->ShowInSearch) {
                return $parentIterInstance;
            }

            if ($parentIterInstance && $parentIterInstance->ShowInSearch && ($counter >= $max)) {
                $fileId = (int) $this->owner->ID;
                $filename = $this->owner->getFilename();

                Injector::inst()->get(LoggerInterface::class)->warning(
                    "FolderIndex parent lookup reached max depth ({$max}) for file #{$fileId} ({$filename})",
                );
            }
        }

        return false;
    }

    protected function onAfterWrite(): void
    {
        if ($this->owner->isChanged('ShowInSearch')) {
            $assets = new PublicAssetAdapter();
            $assets->flush();
        }
    }
}
