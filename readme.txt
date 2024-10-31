=== Post Images Gallery ===
Contributors: gerbenvandijk
Tags: post, images, gallery
Requires at least: unknown
Tested up to: 2.8.6
Stable tag: 1.7

== Description ==

This plugin creates a widget that shows a gallery of all the images in a post.

== Installation ==
1. Download the plugin.
1. Upload it to /wp-content/plugins.
1. Activate it in the administration area of your wordpress blog.
1. Put it in a widget ready theme in the administration area of your wordpress blog.
1. Make sure to fill in the widget title and the thumbnail width an height there too, else it will not show a title and it will show the images in original size.
1. If you don't have a widget ready theme, you can use &lt;?php postimg_widget($args) ?&gt; in your theme file. I'm working on detecting if the widget is in a widget-ready theme and add some styles to the non-widget theme then.
1. To Do: Add support for all the mayor javascript frameworks (i.e. prototype, mootools).

== Screenshots ==

1. Frontend
2. Backend

== Changelog ==

= 1.7 =
* Fixed typo in directory structure

= 1.6 =
* Small bugfix

= 1.5 =
* Fixed a minor bug

= 1.4 =
* Fixed a minor bug

= 1.3 =
* Added the option to use the widget with a non-widget ready theme

= 1.2 =
* Fixed some more minor bugs

= 1.1 =
* Fixed some minor bugs

= 1.0 =
* Launch of the plugin