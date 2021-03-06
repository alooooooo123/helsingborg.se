<?php
    global $has_welcome_text;

    $the_content = get_extended($post->post_content);
    $main = $the_content['main'];
    $extended = $the_content['extended'];
?>
<article>
    <header>
        <?php get_template_part('templates/partials/accessability', 'menu'); ?>

        <?php if (is_front_page() && get_option('helsingborg_title_school_image_imageurl')) : ?>
            <img src="<?php echo get_option('helsingborg_title_school_image_imageurl'); ?>" alt="<?php echo get_option('helsingborg_title_school_image_alt'); ?>" style="max-width: 500px;">
        <?php endif; ?>

        <?php if (!$has_welcome_text) : ?><h1 class="article-title" <?php if (is_front_page() && get_option('helsingborg_title_school_frontpage_hide') == 'on') : ?>style="display:none;"<?php endif; ?>><?php the_title(); ?></h1><?php endif; ?>
    </header>

    <main>
        <?php if (!empty($extended) && strlen($main) > 0) : ?>
        <section class="article-ingress">
            <?php echo apply_filters('the_content', $main); ?>
        </section>
        <?php endif; ?>

        <section class="article-body">
            <?php
                if (!empty($extended)) {
                    echo apply_filters('the_content', $extended);
                } else {
                    echo apply_filters('the_content', $main);
                }
            ?>
        </section>
    </main>
</article>
