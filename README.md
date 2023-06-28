# Silverstripe FolderIndex
Silverstripe FolderIndex lets you manage the visibility of files for Search Engines on a parent folder basis, by setting X-Robots header-tags `noindex`, `nofollow`, `noimageindex`, `noarchive`, `nosnippet`. By unchecking `ShowInSearch` under `Details` of a folder, headers will be set on all files contained, including files in sub-folders. If `gorriecoe/silverstripe-robots` is installed, "unchecked folders" are also disallowed per `robots.txt`.

The module also adds `NoFileIndex()` to `File`. This can be used for checking in xml-sitemap, schema etc. and is used in CMS/Assets to indicate, if a file has X-Robots-Tag headers set per parent Folder or parent/parent/etc. If headers are set, it return the Folder-Object that blocks indexing, otherwise false. So far this module just integrates with Apache `.htaccess`.

## Requirements
- silverstripe/asset-admin: ^1.6 (just tested with that)

## Installation
[Composer](https://getcomposer.org/) is the recommended way installing Silverstripe modules.

`composer require lerni/folderindex`

Run `dev/build`

## Getting started / Usage
- [ ] Uncheck the `Indexing child files` CheckBox of a folder under `Permissions`, save and rules in `assets/.htaccess` 'll be created accordingly.

![Folder 'ShowInSearch' Checkbox](docs/assets/folder.png?raw=true "Folder 'ShowInSearch' Checkbox")
![File X-Robots Notification](docs/assets/file.png?raw=true "File X-Robots Notification")

This module "overwrites" `SilverStripe/Assets/Flysystem/PublicAssetAdapter_HTAccess.ss`

## Credits
Thanks to [@zauberfisch](https://github.com/zauberfisch/) & [@digitall-it](https://github.com/digitall-it/) for inspiration and the Italian translation.

## ToDo
- [x] Hook-in to write `assets/.htaccess` rather than just rely on `dev/build`?
- [x] roles are falsely also set for sub-folders, which are blocked through parents
- [ ] show X-Robots-Tag alert-warning also in file section rather than just in the Details panel?
