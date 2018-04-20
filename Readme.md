# NewCity Custom WYSIWYG Tools - Wordpress Plugin

This is a custom Wordpress plugin that adds custom toolbars to the Wordpress WYSIWYG editor interface.
It was developed at NewCity, and depends in part on the [NewCity Custom Shortcodes](https://github.com/newcity/newcity-wp-shortcodes) Wordpress plugin.

## Theme customization

Your theme may override some settings added by this plugin using configuration file `wysiwyg-config.json` in the root of the active theme. This file may define the custom stylesheet used by TinyMCE (relative to the theme root) and provide the `styles_format` configuration for the format dropdown. For example:

```json
{
    "css": "css/wysiwyg.css",
    "style_formats": [
        {
            "title": "Button link",
            "selector": "a",
            "classes": "button"
        },
        {
            "title": "Go link",
            "selector": "a",
            "classes": "go"
        },
        {
            "title": "Intro paragraph",
            "selector": "p",
            "classes": "intro"
        }
    ]
}
```

If this configuration is not present, the plugin will supply its defaults.