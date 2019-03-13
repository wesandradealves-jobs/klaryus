<aside class="sidebar">
    <div>
        <h2 class="title">Busca</h2>
        <form role="search" method="get" id="searchform" class="search-bar" action="<?php echo site_url(); ?>">
            <input placeholder="digite uma palavra" type="text" value="" name="s" id="s" />
            <button class="fal fa-search"></button>
        </form>
    </div>
    <div>
        <h2 class="title">Categorias</h2>
        <?php 
            $tax = 'category';
            $terms = get_terms( $tax, $args = array(
            'hide_empty' => false, // do not hide empty terms
            ));    

            if($terms) :  ?>
            <ul class='category-list'>
                <?php foreach( $terms as $term ) : 
                    $term_link = get_term_link( $term );
                    $title = $term->name; 
                    $slug = $term->slug;                
                ?>
                    <?php if($slug != 'uncategorized') : ?>
                        <li><a href="<?php echo $term_link; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <?php
            endif;
        ?>
    </div>
</aside>