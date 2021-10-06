# Silverstripe FolderIndex - POC
Silverstripe FolderIndex let you manage the visibility of files on folder basis. If you uncheck `ShowInSearch` on a folder, all contained files 'll have `noindex`, `nofollow` added in the header. There is also `ImageIndex()` in `File` to check visibility - can be used say for xml-sitemap or schema and is also used to indicate if a file as this headers set per parent Folder in `Details`. So far it just integrates with Apache `.htaccess`.

See also: Google will stop supporting noindex directive in robots.txt
https://developers.google.com/search/blog/2019/07/rep-id

## Requirements
- silverstripe/asset-admin: ^1.6

## Installation
[Composer](https://getcomposer.org/) is the recommended way installing Silverstripe modules.

`composer require lerni/folderindex`

Run `dev/build`

## Getting started / Usage
[ ] Uncheck the `Indexing child files` CheckBox of a folder under `Permissions`, next time `.htaccess` in assets is build, it creates rules accordingly. AFAIK `assets/.htaccess` is just build on `dev/build` - so after setting it, you also need to build :(
