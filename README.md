Breadcrumbs
===========

Breadcrumbs based on custom menu's. Made for WordPress.

**This plugin requires TrendPress.**

### Installation
If you're using Composer to manage WordPress, add this plugin to your project's dependencies. Run:
```
composer require trendwerk/breadcrumbs <version>
```

Or manually add it to your `composer.json`:
```
"require": {
	"trendwerk/breadcrumbs": "<version>"
},
```

### Usage

```
tp_breadcrumbs( $separator = '>', $menu = 'mainnav' );
```

**$separator**
The character that separates two crumbs.

**$menu**
Menu on which the breadcrumbs structure should be based.
