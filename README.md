# Silverstripe FolderIndex - POC
Silverstripe FolderIndex let you manage visibility of files for Search Engines on parent folder basis, by setting X-Robots-Tag `noindex`, `nofollow`, `noimageindex`, `noarchive`, `nosnippet` in the header. By uncheck `ShowInSearch` under `Details` of a folder, the header 'll be set on all files contained, inclusive files in sub-folders.

The module also adds `NonFileIndex()` to `File`. This can be used for checking in xml-sitemap, schema etc. and is used in CMS/Assets to indicate, if a file has X-Robots-Tag headers set per parent Folder or Parten/Parent/etc. If headers are set, it return the Folder-Object that blocks indexing, otherwise false. So far this module just integrates with Apache `.htaccess`.

Google will stop supporting noindex directive in `robots.txt`. This module aims to give some control in that area.
https://developers.google.com/search/blog/2019/07/rep-id

## Requirements
- silverstripe/asset-admin: ^1.6 (just tested with that)

## Installation
[Composer](https://getcomposer.org/) is the recommended way installing Silverstripe modules.

`composer require lerni/folderindex`

Run `dev/build`

## Getting started / Usage
[ ] Uncheck the `Indexing child files` CheckBox of a folder under `Permissions`, next time `assets/.htaccess` is build, it creates rules accordingly. AFAIK it so far just writs to the file on `dev/build` (todododd?). So this means, ***you have to `dev/build` after changing this setting*** :(

## Credits
Thanks to [@digitall-it](https://github.com/digitall-it/) for inspiration and the italian translation.

## ToDo
- [x] Hook-in to write `assets/.htaccess` rather than just `dev/build`?
- [ ] roles are falsely also set for sub-folders which are blocked trough parents
- [ ] show X-Robots-Tag alert-waring also in file section rather than just in the Details panel
