# Silverstripe FolderIndex

Silverstripe FolderIndex allows you to manage the visibility of files for search engines on a parent folder basis by utilizing X-Robots header tags such as `noindex`, `nofollow`, `noimageindex`, `noarchive`, and `nosnippet`. By unchecking the `ShowInSearch` option under the `Details` tab of a folder, X-Robots headers will be applied to all files contained within it, including those within sub-folders. If you have `tractorcow/silverstripe-robots` module installed, the "unchecked folders" are also disallowed in `robots.txt`.

The module also introduces `NoFileIndex()` function to `File` class. This can be useful for checking XML sitemaps, schemas etc. And is used in CMS/Assets context to indicate whether a file has X-Robots-Tag headers set through its parent folder or any higher-level ancestor folders. If such headers are set, the function returns the corresponding Folder object that prevents indexing; otherwise, it returns false. This module integrates with Apache `.htaccess` and also proved to work with Litespeed.

## Requirements
- silverstripe/asset-admin: ^1.6

## Installation
[Composer](https://getcomposer.org/) is the recommended method for installing Silverstripe modules.

`composer require lerni/folderindex`

Run `dev/build`

## Getting Started / Usage
- [ ] Uncheck `Indexing child files` checkbox of a folder under `Permissions`, then save the changes and rules will automatically generate in `assets/.htaccess` based on your settings.

![Folder 'ShowInSearch' Checkbox](docs/assets/folder.png?raw=true "Folder 'ShowInSearch' Checkbox")
![File X-Robots Notification](docs/assets/file.png?raw=true "File X-Robots Notification")

Please note this module "overwrites" `SilverStripe/Assets/Flysystem/PublicAssetAdapter_HTAccess.ss` template. If you have a custom template, you need to update it accordingly.

## Credits
Thanks to [@zauberfisch](https://github.com/zauberfisch/) and [@digitall-it](https://github.com/digitall-it/) for their inspiration and the Italian translation.

## ToDo
- [x] Implement a mechanism to write to `assets/.htaccess` directly, rather than relying solely on `dev/build`.
- [x] Address the issue where roles are erroneously assigned to sub-folders that are blocked through parent folders.
- [ ] Provide the ability to configure the X-Robots-Tag settings through the configuration.
- [ ] Display the X-Robots-Tag warning (alert) in the file section, not just in the Details panel.
