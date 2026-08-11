<?php get_header(); ?>

   
   
   <div class="tp-page-area pt-100 pb-100">
      <div class="container container-1324">
         <div class="postbox-wrapper mr-50 mb-40">                  

            <!-- have post is wordpress function -->
            <?php if ( have_posts() ) : ?>
               <?php while ( have_posts() ) : the_post(); ?>                                
                  <?php the_content(); ?>
               <?php endwhile; wp_reset_postdata();  ?>
            <!-- If no posts match the criteria -->
            <?php else : ?>
               <p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
            <?php endif; ?>
               
         </div>
      </div>
   </div>
   


   

<?php get_footer(); ?>























