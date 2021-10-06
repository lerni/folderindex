<?php

namespace Kraftausdruck\Extensions;

use SilverStripe\Core\Extension;

class FileIndexExtension extends Extension
{
    public function ImageIndex()
    {
        if ($this->owner->parent()->ShowInSearch)
        {
            return true;
        } else {
            return false;
        }
    }
}
