<?php

namespace Kraftausdruck\Extensions;

use TractorCow\Robots\Robots;
use SilverStripe\Assets\Folder;
use SilverStripe\ORM\DataExtension;

class RobotsFoldersExtension extends DataExtension
{
    public function updateDisallowedUrls(&$urls)
    {
        if (Robots::config()->disallow_unsearchable) {
            $blockingFolders = Folder::get()->filter(['ShowInSearch' => 0]);
            foreach ($blockingFolders as $folder) {
                $urls[] = '/assets/' . $folder->getFilename();
            }
        }
    }
}
