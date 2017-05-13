<?php get_header(); ?>
<!-- Column 1 / Content -->
<?php if (have_posts()) : the_post(); update_post_caches($posts); ?>
<h2><?php the_title(); ?></h2>
<div>
    <?php the_content(); ?>
    <!-- Contact Form -->
    <?php comments_template(); ?>
</div>
<?php else : ?>
<div>
    没有找到你想要的页面！
</div>
<?php endif; ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>