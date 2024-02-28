# Silverstripe FolderIndex

Silverstripe FolderIndex allows you to manage visibility of files for search engines on a parent folder basis by utilizing X-Robots header tags such as `noindex`, `nofollow`, `noimageindex`, `noarchive`, and `nosnippet`. By unchecking the `ShowInSearch` option in the `Details` tab of a folder, X-Robots headers will be applied to all files contained within, including those in sub-folders. If you have `tractorcow/silverstripe-robots` module installed, "unchecked folders" are also disallowed in `robots.txt`.

The module introduces `NoFileIndex()` function to `File`. This can be useful if for example an image should be included in a XML sitemaps, schemas etc. And is used in CMS/Assets context to indicate whether a file has X-Robots-Tag headers set through its parent folder or any higher-level ancestor/folder. If set, the function returns the corresponding folder that prevents indexing; otherwise, it returns false. This module integrates with Apache `.htaccess` and also proved to work with Litespeed.

## Requirements
- silverstripe/asset-admin: ^1 | ^2

## Installation
[Composer](https://getcomposer.org/) is the recommended method for installing Silverstripe modules.

`composer require lerni/folderindex`

Run `dev/build`

## Getting Started / Usage
- [ ] Uncheck `Indexing child files` checkbox of a folder under `Permissions`, save and rules will automatically generate in `assets/.htaccess`.

![Folder 'ShowInSearch' Checkbox](docs/assets/folder.png?raw=true "Folder 'ShowInSearch' Checkbox")
![File X-Robots Notification](docs/assets/file.png?raw=true "File X-Robots Notification")

Please note this module "overwrites" `SilverStripe/Assets/Flysystem/PublicAssetAdapter_HTAccess.ss` template.

## Credits
Thanks to [@zauberfisch](https://github.com/zauberfisch/) and [@digitall-it](https://github.com/digitall-it/) for inspiration and translation.

## ToDo
- [x] Implement a mechanism to write to `assets/.htaccess` directly, rather than relying solely on `dev/build`.
- [x] Address issue where roles are erroneously assigned to sub-folders that are blocked through parent folders.
- [ ] Provide ability to configure X-Robots-Tag settings through yml-config.
- [ ] Display X-Robots-Tag warning (alert) in the file section, not just in the Details panel.
