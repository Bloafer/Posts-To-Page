<?php
/*
Plugin Name: Posts to Page
Plugin URI: http://studio.bloafer.com/wordpress-plugins/posts-to-page/
Description: Posts to page, shortcode [posts-to-page]. Usage [posts-to-page cat_id=1]
Version: 1.7
Author: Kerry James
Author URI: http://studio.bloafer.com/
*/
if (!function_exists('add_action')){
    die('You are trying to access this file in a manner not allowed.');
}

function post_to_page_shortcode_handler( $args, $content = null ){
    if(is_feed()){
        return '';
    }
    /* Set Defaults */
    $boolFlags = array(
        "show_title"                => true,
        "show_date"                 => true,
        "show_author"               => true,
        "show_content"              => true,
        "show_categories"           => true,
        "show_tags"                 => true,
        "show_image"                => true,
        "show_readmore"             => true,
        "show_comment_count"        => true,
        "show_custom"               => true,
        "show_separator"            => true,
        "link_title"                => true,
        "link_categories"           => true,
        "link_tags"                 => true,
        "link_image"                => true,
        "split_more"                => true,
    );
    $dataFlags = array(
        "type"                      => "post",
        "split_point"               => "<!--more-->",
        "limit"                     => false,
        "cat_id"                    => false,
        "category"                  => false,
        "not_in_category"           => false,
        "specific_id"               => false,
        "orderby"                   => false,
        "order"                     => false,
        "offset"                    => false,
        "image_size"                => false,
        "suppress_filters"          => false,
        "display_sequence"          => "title,date,author,content",
        "display_sequence_custom"   => false,
        "show_custom_key"           => false,
        "use_template_file"         => false,
        "class_title"               => "post-to-page-title",
        "class_date"                => "post-to-page-date",
        "class_author"              => "post-to-page-author",
        "class_content"             => "post-to-page-content",
        "class_categories"          => "post-to-page-categories",
        "class_categories_wrap"     => "post-to-page-categories-wrapper",
        "class_tags"                => "post-to-page-tags",
        "class_tags_wrap"           => "post-to-page-tags-wrapper",
        "class_wrap"                => "post-to-page-wrapper",
        "class_image"               => "post-to-page-image",
        "class_readmore"            => "post-to-page-readmore",
        "class_comment_count"       => "post-to-page-comment-count",
        "class_separator"           => "post-to-page-separator",
        "class_custom_value"        => "post-to-page-custom-value",
        "class_custom_key"          => "post-to-page-custom-key",
        "tag_title"                 => "h2",
        "tag_date"                  => "span",
        "tag_author"                => "span",
        "tag_content"               => "div",
        "tag_categories"            => "span",
        "tag_categories_wrap"       => false,
        "tag_tags"                  => "span",
        "tag_tags_wrap"             => false,
        "tag_wrap"                  => false,
        "tag_image"                 => "span",
        "tag_readmore"              => "span",
        "tag_comment_count"         => "span",
        "tag_separator"             => "hr",
        "tag_custom_value"          => "span",
        "tag_custom_key"            => "span",
        "sep_categories"            => false,
        "sep_tags"                  => false,
        "sep_custom_key_value"      => " : ",
        "sep_custom_value"          => ", ",
        "pre_categories"            => "Posted in: ",
        "pre_tags"                  => "Tagged in: ",
        "text_readmore"             => "Read more...",
        "text_comment_count_single" => "? comment",
        "text_comment_count_plural" => "? comments",
        "debug"                     => false,
    );

    $sct = array("area", "base", "basefont", "br", "hr", "input", "img", "link", "meta");
    $displaySequence = explode(",", $dataFlags["display_sequence"]);

    /* Copy out all variables */
    foreach($boolFlags as $argumentFlag=>$value){
        if(isset($args[$argumentFlag])){
            if(trim(strtolower($args[$argumentFlag]))=="false"){
                $boolFlags[$argumentFlag] = false;
            }
        }
        /* If a "show_" variable is used add it to the "display_sequence" array */
        if(substr($argumentFlag, 0, 5)=="show_"){
            if(!in_array(substr($argumentFlag, 5), $displaySequence)){
                $displaySequence[] = substr($argumentFlag, 5);
            }
        }
    }

    foreach($dataFlags as $argumentFlag=>$value){
        if(isset($args[$argumentFlag])){
            if(trim(strtolower($args[$argumentFlag]))=="false"){
                $dataFlags[$argumentFlag] = false;
            }
        }
        if(isset($args[$argumentFlag])){
            $dataFlags[$argumentFlag] = $args[$argumentFlag];
        }
    }

    $debug = $dataFlags["debug"]?true:false;

    if($debug && (isset($_GET["ptp"]["debug"]) || isset($_GET["ptp"]["settings"]))){
        if($_GET["ptp"]["debug"]=="ds"){
            die("<pre>Display Sequence" . PHP_EOL . print_r($displaySequence, true) . "</pre>");
        }
        if(isset($_GET["ptp"]["settings"])){
            $debugSettings = json_decode($_GET["ptp"]["settings"], true);
            if(isset($debugSettings["bf"])){
                foreach($debugSettings["bf"] as $k=>$v){
                    $boolFlags[$k] = $v;
                }
            }
            if(isset($debugSettings["df"])){
                foreach($debugSettings["df"] as $k=>$v){
                    $dataFlags[$k] = $v;
                }
            }
        }
    }

    /* Start processing */
    if($dataFlags["cat_id"] || $dataFlags["category"]){
        $categoryVar = $dataFlags["category"]?$dataFlags["category"]:$dataFlags["cat_id"];
        $categories = explode(",", $categoryVar);
        if($debug && (isset($_GET["ptp"]["debug"]) || isset($_GET["ptp"]["settings"]))){
            if($_GET["ptp"]["debug"]=="ct"){
                die("<pre>Categories" . PHP_EOL . print_r($categories, true) . "</pre>");
            }
        }
        foreach($categories as $categoryRoute){
            $categoryRoute = trim($categoryRoute, "/");
            $taxonomy = "category";
            if(is_numeric($categoryRoute)){
                $post_args['tax_query'][] = array(
                    'taxonomy' => $taxonomy,
                    'field' => 'id',
                    'terms' => $categoryRoute
                );
            }else{
                if(strstr($categoryRoute, "/")){
                    $catParts = explode("/", $categoryRoute);
                    if(count($catParts)==2){
                        $taxonomy = $catParts[0];
                        $categoryRoute = $catParts[1];
                    }
                }
                $post_args['tax_query'][] = array(
                    'taxonomy' => $taxonomy,
                    'field' => 'slug',
                    'terms' => $categoryRoute
                );
            }
        }
        if(count($post_args['tax_query'])>=2){
            $post_args['tax_query']['relation'] = 'OR';
        }
    }
    if($dataFlags["not_in_category"]){
        $notInCategoryVar = $dataFlags["not_in_category"];
        $notCategories = explode(",", $notInCategoryVar);
        if($debug && (isset($_GET["ptp"]["debug"]) || isset($_GET["ptp"]["settings"]))){
            if($_GET["ptp"]["debug"]=="nc"){
                die("<pre>Not Categories" . PHP_EOL . print_r($notCategories, true) . "</pre>");
            }
        }
        foreach($notCategories as $notCategoryRoute){
            $notCategoryRoute = trim($notCategoryRoute, "/");
            $taxonomy = "category";
            if(is_numeric($notCategoryRoute)){
                $post_args['tax_query'][] = array(
                    'taxonomy' => $taxonomy,
                    'field' => 'id',
                    'terms' => $notCategoryRoute,
                    'operator' => 'NOT IN'
                );
            }else{
                if(strstr($notCategoryRoute, "/")){
                    $catParts = explode("/", $notCategoryRoute);
                    if(count($catParts)==2){
                        $taxonomy = $catParts[0];
                        $notCategoryRoute = $catParts[1];
                    }
                }
                $post_args['tax_query'][] = array(
                    'taxonomy' => $taxonomy,
                    'field' => 'slug',
                    'terms' => $notCategoryRoute,
                    'operator' => 'NOT IN'
                );
            }
        }
        if(count($post_args['tax_query'])>=2){
            $post_args['tax_query']['relation'] = 'AND';
        }
    }

    $post_args['post_type']     = $dataFlags["type"];

    if($dataFlags["limit"]){
        $post_args["numberposts"] = $dataFlags["limit"];
    }
    if($dataFlags["orderby"]){
        $post_args["orderby"] = $dataFlags["orderby"];
    }
    if($dataFlags["order"]){
        $post_args["order"] = $dataFlags["order"];
    }
    if($dataFlags["offset"]){
        $post_args["offset"] = $dataFlags["offset"];
    }
    if($dataFlags["suppress_filters"]){
        $post_args["suppress_filters"] = $dataFlags["suppress_filters"];
    }
    if($dataFlags["specific_id"]){
        $specificIds = explode(",", $dataFlags["specific_id"]);
        $docIds = array();
        foreach($specificIds as $specificId){
            $specificId = trim($specificId);
            if(is_numeric($specificId)){
                $docIds[] = $specificId;
            }
        }
        if(count($docIds)>=1){
            $post_args["post__in"] = $docIds;
        }
    }

    if($debug && isset($_GET["ptp"]["debug"])){
        if($_GET["ptp"]["debug"]=="pa"){
            die("<pre>Post Args" . PHP_EOL . print_r($post_args, true) . "</pre>");
        }
        if($_GET["ptp"]["debug"]=="df"){
            die("<pre>Data Flags" . PHP_EOL . print_r($dataFlags, true) . "</pre>");
        }
        if($_GET["ptp"]["debug"]=="bf"){
            die("<pre>Bool Flags" . PHP_EOL . print_r($boolFlags, true) . "</pre>");
        }
        if($_GET["ptp"]["debug"]=="ss"){
            $o = "[posts-to-page ";
            foreach($args as $k=>$v){ $o .= $k . '="' . $v . '" ';}
            $o = trim($o) . "]";
            die("<pre>Show shortcode" . PHP_EOL . $o . "</pre>");
        }
    }

    $html = '';

    if($dataFlags["use_template_file"]){
        $templateDirectory = get_template_directory();
        $templateFile = $templateDirectory . DIRECTORY_SEPARATOR . $dataFlags["use_template_file"] . ".php";
        if(file_exists($templateFile)){
            $my_query = new WP_Query($post_args);
            while ($my_query->have_posts()){
                $my_query->the_post();
                get_template_part($dataFlags["use_template_file"]);
            }
        }
    }else{
        $displayposts = get_posts($post_args);

        if($debug && isset($_GET["ptp"]["debug"])){
            if($_GET["ptp"]["debug"]=="dp"){
                die("<pre>Display posts" . PHP_EOL . print_r($displayposts, true) . "</pre>");
            }
        }
        foreach($displayposts as $post){
            if($dataFlags["tag_wrap"]){
                $html .= '<' . $dataFlags["tag_wrap"] . ' class="' . $dataFlags["class_wrap"] . '">' . PHP_EOL;
            }
            foreach($displaySequence as $displaySequenceItem){
                if($displaySequenceItem=="title"){
                    if($boolFlags["show_title"]){
                        $html .= '<' . $dataFlags["tag_title"] . ' class="' . $dataFlags["class_title"] . '">';
                        if($boolFlags["link_title"]){ $html .= '<a href="' . get_permalink($post->ID) . '">'; }
                        $html .= $post->post_title;
                        if($boolFlags["link_title"]){ $html .= '</a>'; }
                        $html .= '</' . $dataFlags["tag_title"] . '>' . PHP_EOL;
                    }
                }
                if($displaySequenceItem=="date"){
                    if($boolFlags["show_date"]){
                        $html .= '<' . $dataFlags["tag_date"] . ' class="' . $dataFlags["class_date"] . '">' . apply_filters('get_the_date', $post->post_date) . '</' . $dataFlags["tag_date"] . '>' . PHP_EOL;
                    }
                }
                if($displaySequenceItem=="author"){
                    if($boolFlags["show_author"]){
                        $html .= '<' . $dataFlags["tag_author"] . ' class="' . $dataFlags["class_author"] . '">' . get_the_author_meta( "user_nicename", $post->post_author ) . '</' . $dataFlags["tag_author"] . '>' . PHP_EOL;
                    }
                }
                if($displaySequenceItem=="content"){
                    if($boolFlags["show_content"]){
                        $html .= '<' . $dataFlags["tag_content"] . ' class="' . $dataFlags["class_content"] . '">' . PHP_EOL;
                        $originalContent = $post->post_content;
                        if($boolFlags["split_more"]){
                            if(strstr($originalContent, $dataFlags["split_point"])){
                                $parts = explode($dataFlags["split_point"], $originalContent);
                                $html .= $parts[0];
                            }else{
                                if($dataFlags["suppress_filters"]){
                                    $html .= $originalContent;
                                }else{
                                    $html .= apply_filters('the_content', $originalContent);
                                }
                            }
                        }else{
                            if($dataFlags["suppress_filters"]){
                                $html .= $originalContent;
                            }else{
                                $html .= apply_filters('the_content', $originalContent);
                            }
                        }
                        $html .= '</' . $dataFlags["tag_content"] . '>' . PHP_EOL;
                    }
                }
                if($displaySequenceItem=="readmore"){
                    if($boolFlags["show_readmore"]){
                        $html .= '<' . $dataFlags["tag_readmore"] . ' class="' . $dataFlags["class_readmore"] . '">';
                        $html .= '<a href="' . get_permalink($post->ID) . '">';
                        $html .= $dataFlags["text_readmore"];
                        $html .= '</a>';
                        $html .= '</' . $dataFlags["tag_readmore"] . '>' . PHP_EOL;
                    }
                }
                if($displaySequenceItem=="categories"){
                    if($boolFlags["show_categories"]){
                        $categories = get_the_category($post->ID);
                        if($categories){
                            $catCount = 0;
                            if($dataFlags["pre_categories"]){
                                $html .= $dataFlags["pre_categories"];
                            }
                            if($dataFlags["tag_categories_wrap"]){
                                $html .= '<' . $dataFlags["tag_categories_wrap"] . ' class="' . $dataFlags["class_categories_wrap"] . '">';
                            }
                            foreach($categories as $category){
                                $html .= '<' . $dataFlags["tag_categories"] . ' class="' . $dataFlags["class_categories"] . '">';
                                if($boolFlags["link_categories"]){
                                    $html .= '<a href="' . get_category_link($category->term_id ) . '">';
                                }
                                $html .= apply_filters('get_the_date', $category->cat_name);
                                if($boolFlags["link_categories"]){ $html .= '</a>'; }
                                $html .=  '</' . $dataFlags["tag_categories"] . '>';
                                if($dataFlags["sep_categories"]){
                                    $catCount++;
                                    if($catCount!=count($categories)){
                                        $html .= $dataFlags["sep_categories"];
                                    }
                                }
                            }
                            if($dataFlags["tag_categories_wrap"]){
                                $html .= '</' . $dataFlags["tag_categories_wrap"] . '>';
                            }
                        }
                    }
                }
                if($displaySequenceItem=="tags"){
                    if($boolFlags["show_tags"]){
                        $tags = get_the_tags($post->ID);
                        if($tags){
                            $catCount = 0;
                            if($dataFlags["pre_tags"]){
                                $html .= $dataFlags["pre_tags"];
                            }
                            if($dataFlags["tag_tags_wrap"]){
                                $html .= '<' . $dataFlags["tag_tags_wrap"] . ' class="' . $dataFlags["class_tags_wrap"] . '">';
                            }
                            foreach($tags as $tag){
                                $html .= '<' . $dataFlags["tag_tags"] . ' class="' . $dataFlags["class_tags"] . '">';
                                if($boolFlags["link_tags"]){
                                    $html .= '<a href="' . get_tag_link($tag->term_id ) . '">';
                                }
                                $html .= apply_filters('get_the_date', $tag->name);
                                if($boolFlags["link_tags"]){ $html .= '</a>'; }
                                $html .=  '</' . $dataFlags["tag_tags"] . '>';
                                if($dataFlags["sep_tags"]){
                                    $catCount++;
                                    if($catCount!=count($tags)){
                                        $html .= $dataFlags["sep_tags"];
                                    }
                                }
                            }
                            if($dataFlags["tag_tags_wrap"]){
                                $html .= '</' . $dataFlags["tag_tags_wrap"] . '>';
                            }
                        }
                    }
                }
                if($displaySequenceItem=="image"){
                    if($boolFlags["show_image"]){
                        if(function_exists("get_the_post_thumbnail")){
                            $imageSizes = false;
                            if($dataFlags["image_size"]){
                                $testImageSizes = explode("x", strtolower($dataFlags["image_size"]));
                                if(count($testImageSizes)==2){
                                    $imageSizes = $testImageSizes;
                                }
                            }
                            $html .= '<' . $dataFlags["tag_image"] . ' class="' . $dataFlags["class_image"] . '">';
                            if($boolFlags["link_image"]){ $html .= '<a href="' . get_permalink($post->ID) . '">'; }
                            if($imageSizes){
                                $html .= get_the_post_thumbnail($post->ID, $imageSizes);
                            }else{
                                $html .= get_the_post_thumbnail($post->ID);
                            }
                            if($boolFlags["link_image"]){ $html .= '</a>'; }
                            $html .= '</' . $dataFlags["tag_image"] . '>' . PHP_EOL;
                        }
                    }
                }
                if($displaySequenceItem=="comment_count"){
                    if($boolFlags["show_comment_count"]){
                        $html .= '<' . $dataFlags["tag_comment_count"] . ' class="' . $dataFlags["class_comment_count"] . '">';
                        $commentCount = get_comments_number($post->ID);
                        if($commentCount==1){
                            $html .= str_replace("?", $commentCount, $dataFlags["text_comment_count_single"]);
                        }else{
                            $html .= str_replace("?", $commentCount, $dataFlags["text_comment_count_plural"]);
                        }

                        $html .= '</' . $dataFlags["tag_comment_count"] . '>' . PHP_EOL;
                    }
                }
                if($displaySequenceItem=="separator"){
                    if($boolFlags["show_separator"]){
                        $html .= '<' . $dataFlags["tag_separator"] . ' class="' . $dataFlags["class_separator"] . '"';
                        if(in_array($dataFlags["tag_separator"], $sct)){
                            $html .= ' />';
                        }else{
                            $html .= '></' . $dataFlags["tag_separator"] . '>';
                        }
                        $html .= PHP_EOL;
                    }
                }
                if($displaySequenceItem=="custom"){
                    if($boolFlags["show_custom"] && $dataFlags["display_sequence_custom"]){
                        $customDisplaySequence = explode(",", $dataFlags["display_sequence_custom"]);
                        $currentPostCustom = get_post_custom($post->ID);
                        foreach($customDisplaySequence as $customDisplaySequenceItem){
                            if(isset($currentPostCustom[$customDisplaySequenceItem])){
                                $niceKeyClass = sanitize_title_with_dashes($dataFlags["class_custom_key"] . " " . trim($customDisplaySequenceItem));
                                $niceValueClass = sanitize_title_with_dashes($dataFlags["class_custom_value"] . " " . trim($customDisplaySequenceItem));
                                if($dataFlags["show_custom_key"]){
                                    $html .= '<' . $dataFlags["tag_custom_key"] . ' class="' . $dataFlags["class_custom_key"] . ' ' . $niceKeyClass . '">';
                                    $html .= $customDisplaySequenceItem;
                                    $html .= '</' . $dataFlags["tag_custom_key"] . '>';
                                    $html .= $dataFlags["sep_custom_key_value"];
                                }
                                $html .= '<' . $dataFlags["tag_custom_value"] . ' class="' . $dataFlags["class_custom_value"] . ' ' . $niceValueClass . '">';
                                $html .= implode($dataFlags["sep_custom_value"], $currentPostCustom[$customDisplaySequenceItem]);
                                $html .= '</' . $dataFlags["tag_custom_value"] . '>' . PHP_EOL;
                            }
                        }
                    }
                }
            }
            if($dataFlags["tag_wrap"]){
                $html .= '</' . $dataFlags["tag_wrap"] . '>' . PHP_EOL;
            }
        }
    }
    return $html;
}

add_shortcode('posts-to-page', 'post_to_page_shortcode_handler');

?>