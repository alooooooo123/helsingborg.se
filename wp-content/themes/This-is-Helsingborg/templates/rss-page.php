<?php
/*
Template Name: RSS
*/

    /**
     * Get the posts metadata
     * @var Array
     */
    $hbgMeta = get_post_meta($post->ID, '_helsingborg_meta', true);
    $seoMeta = get_post_meta($post->ID, '_aioseop_description', true);

    /**
     * Get child pages based on the rss_select_id in metadata
     */
    $args = array(
        'post_type'     => 'page',
        'post_status'   => 'publish',
        'post_parent'   => $hbgMeta['rss_select_id']
    );

    $pages = get_children($args);
    $numberOfPages = count($pages);
    $lastPage = $numberOfPages - 1;

    header('Content-Type: application/rss+xml; charset=utf-8;');
?>
<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>Title</title>
        <link>http://www.helsingborg.se/</link>
        <description><![CDATA[<?php echo $seoMeta; ?>]]></description>
        <language>sv-se</language>
        <lastBuildDate><?php echo \Helsingborg\Helper\Rss::helsingborgRssDate($pages[$lastPage]->post_modified_gmt); ?></lastBuildDate>
        <pubDate><?php echo \Helsingborg\Helper\Rss::helsingborgRssDate($pages[$lastPage]->post_modified_gmt); ?></pubDate>
        <docs>http://www.rssboard.org/rss-specification</docs>
        <image>
            <url><?php echo get_template_directory_uri(); ?>/assets/img/images/hbg-logo-rss.jpg</url>
            <title><![CDATA[Helsingborg Stad]]></title>
            <link>http://www.helsingborg.se</link>
        </image>

        <atom:link href="http://<?php echo $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI]; ?>" rel="self" type="application/rss+xml" />

        <?php foreach($pages as $post) : ?>
        <item>
            <link><?php echo get_the_permalink($post->ID); ?></link>
            <guid isPermaLink="true"><?php echo get_the_permalink($post->ID); ?></guid>
            <title><![CDATA[<?php echo get_the_title($post->ID); ?>]]></title>
            <pubDate><?php echo \Helsingborg\Helper\Rss::helsingborgRssDate($post->post_modified_gmt); ?></pubDate>
            <description><![CDATA[<?php echo $post->post_content; ?>]]></description>
        </item>
        <?php endforeach; ?>
    </channel>
</rss>