      </main>
    </div>
    <footer class="footer">
        <div class="container">
          <h4 class="logo">
            <a class="logo-anchor" href="<?php echo site_url(); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) )." - ".get_bloginfo('description'); ?>">
                <?php if(get_theme_mod('logo')) : ?>
                    <img src="<?php echo get_theme_mod('logo'); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) )." - ".get_bloginfo('description'); ?>">
                <?php else : ?>
                    <?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>
                <?php endif; ?>
            </a> 
          </h4>
          <nav class="navigation footer-navigation">
            <ul>
              <?php wp_nav_menu( array( 'container' => false, 'menu' => 'Menu Footer', 'items_wrap' => '%3$s' ) ); ?>        
            </ul>
          </nav>
          <?php get_template_part('template-parts/social-networks'); ?> 
        </div>
        <div class="copyright">
        <img width="28px" style="display: block; margin: 0 auto; margin-bottom: 10px; margin-top: 10px;" src="<?php echo get_template_directory_uri() ?>/assets/img/logo_tabor_white.png" alt="Tabor" /> 
        
          <p class="text">
          <span>© 2019 Todos os Direitos Reservados </span>
          </p>
          <ul class="copyright-navigation">
            <?php wp_nav_menu( array( 'container' => false, 'menu' => 'Footer', 'items_wrap' => '%3$s' ) ); ?>               
          </ul>
          <?php get_template_part('template-parts/social-networks'); ?>
          <br/>
          <span style="color:#fff; font-size:10px">Desenvolvido com ❤ pela Kyngler.co</span>
        </div>
      </footer>
    <?php wp_footer(); ?>
    <?php get_template_part('template-parts/product-popup'); ?>
    <?php 
        if(str_replace("-","_", $post->post_name) == 'fale_conosco') :
          echo "
            <script>
                $(document).ready(function () {
                    function spinner(pos){
                      $('.spinner').css('display', pos);
                    }
                    $( '.contact-form' ).submit(function( event ) {
                        var dataparam = $('.contact-form').serialize();

                        $.ajax({
                            type: 'POST',
                            async: true,
                            url: '".site_url('/phpmailer/send.php')."',
                            data: dataparam,
                            datatype: 'json',
                            cache: true,
                            global: false,
                            beforeSend: function() { 
                                spinner('flex');
                                console.log('Enviando..');
                            },
                            success: function(data) {
                                console.log(data);
                            },
                            complete: function() { 
                                spinner('none');
                                console.log('Enviado..');
                                // $('.contact-form').prepend('<p>Enviado com Sucesso</p>');
                                $('.contact-form')[0].reset();
                                // setTimeout(function(){ 
                                //     $('.contact-form').children('p').fadeOut();
                                // }, 3000);
                            }
                        }); 
                        event.preventDefault();
                    }); 
                });         
            </script>
          ";     
        endif;
    ?>        
    <div class="spinner">
      <div class="lds-ripple"><div></div><div></div></div>
    </div>
    <script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyC5QMfSnVnSCcmkFag0ygrXzj2QJ9usEG4'></script>
    <?php 
      $coordinates = get_field('fornecedores');
      $map_coordinates = array();
      $map_titles = array();

      
      echo "
      <script type='text/javascript'>
          var locations = [ ";
            foreach ($coordinates as $key => $value) {
              echo "['".$value['title']."',".$value['coordinates'].", 4],";
            }  
        echo "
          ];

          var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            disableDefaultUI: true,
            center: new google.maps.LatLng(".$value['coordinates']."),
            mapTypeId: google.maps.MapTypeId.ROADMAP
          });

          var infowindow = new google.maps.InfoWindow();

          var marker, i;

          for (i = 0; i < locations.length; i++) {  
            marker = new google.maps.Marker({
              position: new google.maps.LatLng(locations[i][1], locations[i][2]),
              map: map
            });

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
              return function() {
                infowindow.setContent(locations[i][0]);
                infowindow.open(map, marker);
              }
            })(marker, i));
          }
        </script>
        <noscript>Seu Navegador pode não aceitar javascript.</noscript>    
      ";
    ?>
  </body>
</html>