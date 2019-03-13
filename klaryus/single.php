<?php get_header(); ?>
<?php if ( have_posts () ) : while (have_posts()) : the_post(); ?>
    <?php get_template_part('template-parts/banner'); ?>
    <section class="content">
        <div class="container">
            <h2 class="title">
                <?php echo get_the_title(); ?>
                <?php if(get_the_excerpt()) : ?>
                <span class="excerpt">
                    <?php echo get_the_excerpt(); ?>
                  <small class="date"><?php echo get_the_date(); ?></small>
                </span>
                <?php endif; ?>
            </h2>
            <div class="container-inner">
                <?php the_content(); ?>
            </div>
        </div>
    </section>    
<?php endwhile;
endif; ?>
<?php get_footer(); ?>