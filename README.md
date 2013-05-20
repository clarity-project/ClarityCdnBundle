ClarityCdnBundle
================

Put this in your configuration file

``` yaml
clarity_cdn:
    default_storage: "image"
    schemas:
        local: "Clarity\CdnBundle\Filemanager\Storage\\Local\Cdn"
    storages:
        image:
            schema: "local"
            upload_path: "%kernel.root_dir%/../web/uploads"
            upload_url: "http://your-site-name.net/uploads"
```
