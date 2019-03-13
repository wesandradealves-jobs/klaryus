<?php get_header(); ?>
<?php get_template_part('template-parts/banner'); ?>
<section class="blog">
    <div class="container">
        <div class="content">
            <p class="search-results">
                <?php 
                    $search = new WP_Query("s=$s&showposts=0"); 
                    if($search ->found_posts == 0){
                        echo 'Nenhum resultado encontrado.';
                    } else {
                        echo '<b>"'.$search ->found_posts.'"</b> resultados encontrados.';
                    }
                ?>
            </p>
            <div class="blog-grid">
            <?php if ( have_posts () ) : 
                while (have_posts()) : the_post(); ?>
                    <div class="grid-element" onclick="document.location='<?php echo get_the_permalink(); ?>';return false;">
                        <div class="grid-inner" style="background-image:url(<?php echo wp_get_attachment_url(get_post_thumbnail_id($post->ID), full); ?>)">
                            <div class="grid-content">
                            <h4 class="title"><?php echo get_the_category()[0]->name; ?></h4>
                            <p class="text"><?php echo (get_the_excerpt()) ? get_the_excerpt() : substr(get_the_content(), 0, 140).'...'; ?></p>
                            <a href="<?php echo get_the_permalink(); ?>" class="btn btn-2">Saiba Mais</a>
                            </div>
                        </div>
                        <div class="grid-label">
                            <p class="label"><?php echo get_the_category()[0]->name; ?></p>
                        </div>
                        <h3 class="title"><?php echo get_the_title(); ?></h3>
                    </div>
                <?php endwhile;
            endif; ?>            
            </div>
            <div class="pagination">
                <?php 
                    $args = array(
                        'prev_text'          => __('« Página Anterior'),
                        'next_text'          => __('Próxima Página »'),
                    );                
                    echo paginate_links($args);        
                ?>
            </div>
        </div>
        <?php if(get_sidebar()) : ?>
                <?php get_sidebar(); ?>
        <?php endif; ?>
    </div>
</section> 
<?php get_footer(); ?>