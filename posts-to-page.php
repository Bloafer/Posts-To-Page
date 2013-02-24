<?php
/*
Plugin Name: Posts to Page
Plugin URI: http://studio.bloafer.com/wordpress-plugins/posts-to-page/
Description: Posts to page, shortcode [posts-to-page]. Usage [posts-to-page cat_ID=1]
Version: 1.4
Author: Kerry James
Author URI: http://studio.bloafer.com/
*/

function post_to_page_shortcode_handler( $args, $content = null ){
    if(is_feed()){
        return '';
    }
    /* Set Defaults */
    $boolFlags = array(
        "show_title"        => true,
        "show_date"         => true,
        "show_author"       => true,
        "show_content"      => true,
        "link_title"        => true,
        "split_more"        => true
    );
    $dataFlags = array(
        "type"              => "post",
        "split_point"       => "<!--more-->",
        "limit"             => false,
        "cat_id"            => 1,
        "display_sequence"  => "title,date,author,content",
        "class_title"       => "post-to-page-title",
        "class_date"        => "post-to-page-date",
        "class_author"      => "post-to-page-author",
        "class_content"     => "post-to-page-content",
        "tag_title"         => "h2",
        "tag_date"          => "span",
        "tag_author"        => "span",
        "tag_content"       => "div",
    );

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
            $dataFlags[$argumentFlag] = $args[$argumentFlag];
        }
    }

    /* Start processing */
    $post_args['cat']           = is_numeric($dataFlags["cat_id"])?$dataFlags["cat_id"]:1;
    $post_args['post_type']     = $postType;

    if($dataFlags["limit"]){
        $post_args["numberposts"] = $dataFlags["limit"];
    }

    $html = "";
    $displayposts = get_posts($post_args);

    foreach($displayposts as $post){
        foreach($displaySequence as $displaySequenceItem){
            if($displaySequenceItem=="title"){
                if($boolFlags["show_title"]){
                    $html .= '<' . $dataFlags["tag_title"] . ' class="' . $dataFlags["class_title"] . '">';
                    if($boolFlags["link_title"]){ $html .= '<a href="' . get_permalink($post->ID) . '">'; }
                    $html .= $post->post_title;
                    if($boolFlags["link_title"]){ $html .= '</a>'; }
                    $html .= '</' . $dataFlags["tag_title"] . '>';
                }
            }
            if($displaySequenceItem=="date"){
                if($boolFlags["show_date"]){
                    $html .= '<' . $dataFlags["tag_date"] . ' class="' . $dataFlags["class_date"] . '">' . apply_filters('get_the_date', $post->post_date) . '</' . $dataFlags["tag_date"] . '>';
                }
            }
            if($displaySequenceItem=="author"){
                if($boolFlags["show_author"]){
                    $html .= '<' . $dataFlags["tag_author"] . ' class="' . $dataFlags["class_author"] . '">' . get_the_author_meta( "user_nicename", $post->post_author ) . '</' . $dataFlags["tag_author"] . '>';
                }
            }
            if($displaySequenceItem=="content"){
                if($boolFlags["show_content"]){
                    $html .= '<' . $dataFlags["tag_content"] . ' class="' . $dataFlags["class_content"] . '">';
                    $originalContent = $post->post_content;
                    if($boolFlags["split_more"]){
                        if(strstr($originalContent, $dataFlags["split_point"])){
                            $parts = explode($dataFlags["split_point"], $originalContent);
                            $html .= apply_filters('the_content', $parts[0]);
                        }else{
                            $html .= apply_filters('the_content', $originalContent);
                        }
                    }else{
                        $html .= apply_filters('the_content', $originalContent);
                    }
                    $html .= '</' . $dataFlags["tag_content"] . '>';
                }
            }
        }
    }
    return $html;
}

add_shortcode('posts-to-page', 'post_to_page_shortcode_handler');

?>