<?php

namespace Kraftausdruck\Extensions;

use TractorCow\Robots\Robots;
use SilverStripe\Assets\Folder;
use SilverStripe\Core\Extension;

class RobotsFoldersExtension extends Extension
{
    protected function updateDisallowedUrls(&$urls): void
    {
        if (Robots::config()->disallow_unsearchable) {
            $blockingFolders = Folder::get()->filter(['ShowInSearch' => 0]);
            foreach ($blockingFolders as $folder) {
                $urls[] = '/assets/' . $folder->getFilename();
            }
        }
    }
}
