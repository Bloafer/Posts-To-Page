=== Posts to Page ===
Contributors: Bloafer
Plugin Name: Posts to Page
Plugin URI: http://studio.bloafer.com/wordpress-plugins/posts-to-page/
Description: Posts to page, shortcode [posts-to-page].
Version: 1.5
Author: Kerry James
Author URI: http://studio.bloafer.com/
Donate link: http://studio.bloafer.com/wordpress-plugins/posts-to-page/
Tags: shortcode, pages, posts, custom post types, CMS
Requires at least: 3.0
Tested up to: 3.5.1
Stable tag: 3.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin adds a shortcode [posts-to-page] to WP allowing you to easily add one or more posts into any page.

== Description ==

This plugin adds a shortcode [posts-to-page] to WP allowing you to easily add one or more posts into any page.

Supports categories, tags, custom post types, custom taxonomies and more.

This plugin is perfect for those who use WordPress as a CMS.

If you need help with this plugin please visit http://studio.bloafer.com/wordpress-plugins/posts-to-page/

If you find a bug or wish to give us feedback and contribute to this plugin on its [GitHub page](https://github.com/Bloafer/Posts-To-Page)

== Installation ==

You can install from within WordPress using the Plugin/Add New feature, or if you wish to manually install:

1. Download the plugin.
2. Upload the entire `posts-to-page` directory to your plugins folder (/wp-content/plugins/)
3. Activate the plugin from the plugin page in your WordPress Dashboard
4. Start embedding posts in whatever pages you like using the shortcode [posts-to-page].

== Common Usage ==

Show top 10 posts in "Uncategorized" category, without images and comma seperated category and tag list
[posts-to-page limit=10 category=uncategorized tag_categories_wrap="div" sep_categories=", " tag_tags_wrap="div" sep_tags=", " show_image=false]


Show top 10 posts with bullet pointed categories and tags
[posts-to-page limit=10 tag_categories_wrap="ul" tag_categories="li" tag_tags_wrap="ul" tag_tags="li"]

Image gallery type posts, this will produce a list of image linked posts with images sized to 300x300
[posts-to-page show_title=false show_date=false show_author=false show_content=false show_categories=false show_tags=false image_size="300x300"]

== Frequently Asked Questions ==

= How do I limit the results? =

You need to use the variable "limit", only available in version 0.2 and above ([posts-to-page cat_id=1 limit=3])

= I want to split the content early, how? =

You need to use the variable "split_point", only available in version 0.3 and above ([posts-to-page cat_id=1 split_point="&lt;!--split--&gt;"])

= I want to split on the more point, how would I do this? =

You need to use the variable "split_more", only available in version 1.2 and above ([posts-to-page cat_id=1 split_more="true"])

= I have installed the plugin but it is only showing me the shortcode? =

Make sure you have activated the plugin.

= How do I get rid of the titles? =

You need to use the variable "show_title", this has been available since version 0.1 but not documented ([posts-to-page cat_id=1 show_title=false])

= How do I show the date? =

You need to use the variable "show_date" ([posts-to-page cat_id=1 show_date=true])

= How do I show only the titles? =

You need to use a two variables, "show_title" and "show_content" ([posts-to-page cat_id=1 show_title=true show_content=false])

= How do I show the author? =

You need to use the variable "show_author" ([posts-to-page cat_id=1 show_author=true])

= How do I link the title to the post? =

You need to use the variable "link_title" ([posts-to-page cat_id=1 link_title=true])

= How do I show other post types? =

You need to use the variable "type" ([posts-to-page cat_id=1 type=gallery])

= How do I display the content before the title =

You need to use the "display_sequence" variable ([posts-to-page cat_id=1 display_sequence=title,date,author,content])

= I have read all of these, but need more help =

Please visit http://studio.bloafer.com/wordpress-plugins/posts-to-page/ you can find in-depth tutorials.

== Changelog ==

= 1.5 =
This update adds a massive amount of functionality to improve your Posts to Page life

* The "category" variable accepts taxonomy and slug selection for example [posts-to-page category=category/uncategorized]
* The "category" variable now accepts slugs for example [posts-to-page category=uncategorized]
* The variable "cat_ID" has now been changed to "category" to keep in line with future development, "cat_id" and "category" are interchangable to prevent legacy problems
* Added "show_categories" variable
* Added "show_tags" variable
* Added "show_image" variable
* Added "link_categories" variable
* Added "link_tags" variable
* Added "link_image" variable
* Added "category" variable
* Added "orderby" variable
* Added "order" variable
* Added "offset" variable
* Added "image_size" variable
* Added "suppress_filters" variable
* Added "class_categories" variable
* Added "class_categories_wrap" variable
* Added "class_tags" variable
* Added "class_tags_wrap" variable
* Added "class_wrap" variable
* Added "class_image" variable
* Added "tag_categories" variable
* Added "tag_categories_wrap" variable
* Added "tag_tags" variable
* Added "tag_tags_wrap" variable
* Added "tag_wrap" variable
* Added "tag_image" variable
* Added "sep_categories" variable
* Added "sep_tags" variable
* Added "pre_categories" variable
* Added "pre_tags" variable

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
* cat_id now defaults to "1" if not specified.
* cat_id is now validated.
* FAQ's updated.

= 0.2 =
* Added limit variable.

= 0.1 =
* Initial release.

