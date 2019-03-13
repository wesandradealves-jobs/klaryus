<?php /* Template Name: Fornecedores */
    get_header(); 
?>
<?php get_template_part('template-parts/banner'); ?>
<section class="fornecedores content">
    <div class="container">
        <h2 class="title">
            <?php echo get_the_title(); ?>
            <?php if(get_the_excerpt()) : ?>
                <small><?php echo get_the_excerpt(); ?></small>
            <?php endif; ?>     
        </h2>
        <div class="container-inner">
            <div id="map"><!-- --></div>
        </div>
    </div>
</section>
<?php get_footer(); ?>