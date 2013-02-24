=== Posts to Page ===
Contributors: Bloafer
Plugin Name: Posts to Page
Plugin URI: http://studio.bloafer.com/wordpress-plugins/posts-to-page/
Description: Posts to page, shortcode [posts-to-page].
Version: 1.4
Author: Kerry James
Author URI: http://studio.bloafer.com/
Donate link: http://studio.bloafer.com/wordpress-plugins/posts-to-page/
Tags: CMS, posts
Requires at least: 3.1.3
Tested up to: 3.5.1
Stable tag: 3.1.3

This plugin adds a shortcode [posts-to-page] to WP allowing you to place your posts into a page.

== Description ==
This plugin adds a shortcode [posts-to-page] to WP allowing you to place your posts into a page.

This plugin is perfect for those who use WordPress as a CMS.

if you need help with this plugin please visit http://studio.bloafer.com/wordpress-plugins/posts-to-page/

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload 'posts-to-pages' to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place [posts-to-page] in your page to display posts, eg. [posts-to-page cat_ID=1 limit=5]

== Frequently Asked Questions ==

= How do I limit the results? =

You need to use the variable "limit", only available in version 0.2 and above ([posts-to-page cat_ID=1 limit=3])

= I want to split the content early, how? =

You need to use the variable "split_point", only available in version 0.3 and above ([posts-to-page cat_ID=1 split_point="&lt;!--split--&gt;"])

= I want to split on the more point, how would I do this? =

You need to use the variable "split_more", only available in version 1.2 and above ([posts-to-page cat_ID=1 split_more="true"])

= I have installed the plugin but it is only showing me the shortcode? =

Make sure you have activated the plugin.

= How do I get rid of the titles? =

You need to use the variable "show_title", this has been available since version 0.1 but not documented ([posts-to-page cat_ID=1 show_title=false])

= How do I show the date? =

You need to use the variable "show_date" ([posts-to-page cat_ID=1 show_date=true])

= How do I show only the titles? =

You need to use a two variables, "show_title" and "show_content" ([posts-to-page cat_ID=1 show_title=true show_content=false])

= How do I show the author? =

You need to use the variable "show_author" ([posts-to-page cat_ID=1 show_author=true])

= How do I link the title to the post? =

You need to use the variable "link_title" ([posts-to-page cat_ID=1 link_title=true])

= How do I show other post types? =

You need to use the variable "type" ([posts-to-page cat_ID=1 type=gallery])

= How do I display the content before the title =

You need to use the "display_sequence" variable ([posts-to-page cat_ID=1 display_sequence=title,date,author,content])

= I have read all of these, but need more help =

Please visit http://studio.bloafer.com/wordpress-plugins/posts-to-page/ you can find in-depth tutorials.

== Changelog ==
= 1.4 =
* A long due overhaul to the post-to-page plugin
* Changed all true/false flags to be set to true
* Added display_sequence, which allows you to re arrange the sequence of items displayed
* Added "class_title" variable
* Added "class_date" variable
* Added "class_author" variable
* Added "class_content" variable
* Added "tag_title" variable
* Added "tag_date" variable
* Added "tag_author" variable
* Added "tag_content" variable

= 1.3 =
* Fixed date problem.

= 1.2 =
* Added split_more variable.

= 1.1 =
* Updated the way arguments are called.

= 1.0 =
* Added type variable.

= 0.9 =
* Fixed the date variable.
* Added show_author variable.

= 0.8 =
* Updated content display to use filters, makes things work as they should.
* Added link_title variable.

= 0.7 =
* Major rewrite to fix legacy issues.

= 0.6 =
* Added show_content variable.
* Fixed a misplaced tag.
* Fixed some class variables.

= 0.5 =
* Added show_date variable.

= 0.4 =
* Show title problem fixed.

= 0.3 =
* Added split_point variable.
* cat_ID now defaults to "1" if not specified.
* cat_ID is now validated.
* FAQ's updated.

= 0.2 =
* Added limit variable.

= 0.1 =
* Initial release.

