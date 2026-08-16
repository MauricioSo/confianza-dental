<?php

get_header();
?>
<section class="section">
    <div class="container">
        <?php if (have_posts()) : ?>
            <div class="archive-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <article class="card">
                        <div class="card-body">
                            <span class="card-kicker"><?php echo esc_html(get_post_type_object(get_post_type())->labels->singular_name ?? 'Contenido'); ?></span>
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p><?php echo esc_html(get_the_excerpt()); ?></p>
                            <a class="text-link" href="<?php the_permalink(); ?>"><?php echo esc_html(zendent_get_option('index_detail_link_label')); ?></a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <div class="empty-state"><p><?php echo esc_html(zendent_get_option('empty_state_text')); ?></p></div>
        <?php endif; ?>
    </div>
</section>
<?php
get_footer();
