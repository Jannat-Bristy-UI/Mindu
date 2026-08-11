<?php get_header(); ?>

   

   <main>
      <!-- tp-postbox-area-start -->
      <div class="tp-postbox-area pt-140 pb-100">
         <div class="container container-1324">
            <div class="row">
               <div class="col-lg-8">
                  <div class="tp-blog-details-wrap mr-50 mb-40">
                     <!-- Blog List Start -->
                     <?php if ( have_posts() ) : ?>
                           <?php while ( have_posts() ) : the_post(); ?>                                
                              <?php echo get_template_part( 'template-parts/blog/content' ); ?>
                           <?php endwhile; wp_reset_postdata(); ?>
                     <!-- If no posts match the criteria -->
                     <?php else : ?>
                           <p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
                     <?php endif; ?>
                     <!-- Blog List End -->

                  </div>
               </div>

               <div class="col-lg-4">
                  <div class="tp-sidebar-wrapper">
                     <?php dynamic_sidebar( 'blog-sidebar' ); ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- tp-postbox-area-end -->


   </main>










<?php get_footer(); ?>























