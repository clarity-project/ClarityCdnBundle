ClarityCdnBundle
================

Put this in your configuration file

``` yaml
clarity_cdn:
    default: "image"
    storage:
        image:
            scheme: "local"
            path: "%kernel.root_dir%/../web/images"
            url: "http://example-site.com/images"
```
