<?php 

   global $mindu; // Same as your opt_name

   // Header Info variables
   $header_top_switcher = $mindu['header-top-switcher'] ?? '';
   $header_phone = $mindu['header-phone'] ?? '';
   $header_mail = $mindu['header-mail'] ?? '';
   $header_time = $mindu['header-time'] ?? '';

   // button variables
   $header_button_text = $mindu['header-button-text'] ?? '';
   $header_button_url = $mindu['header-button-url'] ?? '';
?> 



<!-- Header-4 start -->  
<header class="tp-header-height">

   <!-- header-area-start -->
   <div id="header-sticky" class="tp-header-area tp-header-3-border tp-header-2-spacing" data-bg-color="#faf8f1">
      <div class="container">
         <div class="row align-items-center">
            <div class="col-xl-8 col-5">
               <div class="tp-header-2-left d-flex align-items-center">
                  <div class="tp-header-logo mr-100">
                     <!-- Calls a PHP function to display the header logo dynamically -->
                     <?php header_logo(); ?>
                  </div>

                  <div class="tp-main-menu tp-main-menu-2 tp-menu-dropdown d-none d-xl-block">
                     <nav class="tp-mobile-menu-active">
                        <!-- Calls a PHP function to display the main menu dynamically -->
                        <?php header_main_menu(); ?>
                     </nav>
                  </div>
               </div>
            </div>
            <div class="col-xl-4 col-7">
               <div class="tp-header-option tp-header-2-option d-flex align-items-center justify-content-end">

                  <!-- Phone Info -->
                  <?php if (!empty($header_phone)) : ?>
                     <a class="tp-header-phone fw-700 tp-ff-heading d-none d-md-inline-block" href="tel:<?php echo esc_attr($header_phone); ?>">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                           <path d="M2.44992 7.45336L4.79696 5.10633C5.27573 4.62756 5.44139 3.92014 5.24775 3.27135C5.09634 2.76401 4.92575 2.15412 4.81235 1.63259C4.70747 1.15024 4.28421 0.75 3.79059 0.75H2.44992C1.46267 0.75 0.651923 1.55341 0.760216 2.53471C1.58346 9.99407 7.50638 15.917 14.9657 16.7403C15.9471 16.8485 16.7504 16.0378 16.7504 15.0505V13.7099C16.7504 13.2163 16.3486 12.8113 15.8629 12.723C15.3271 12.6255 14.7603 12.4659 14.2861 12.3147C13.6048 12.0974 12.8474 12.2502 12.3418 12.7558L10.0471 15.0505" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                           <path d="M13.6391 7.86287L15.8614 7.8611M9.63916 3.86284V1.63889M14.0389 3.46133L12.4667 5.03355" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <?php echo esc_html($header_phone); ?>
                     </a>
                  <?php endif; ?>
                  
                  <!-- Common Button -->
                  <?php if (!empty($header_button_text)) : ?>
                     <a href="<?php echo esc_url($header_button_url); ?>" class="tp-btn ml-25 d-none d-sm-block"><?php echo esc_html($header_button_text); ?>
                        <span class="ml-8">
                           <svg width="11" height="10" viewBox="0 0 11 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" clip-rule="evenodd" d="M5.70151 0.20932C5.83044 0.0752924 6.00528 0 6.18758 0C6.36989 0 6.54472 0.0752924 6.67365 0.20932L10.7987 4.49886C10.9276 4.63293 11 4.81474 11 5.00432C11 5.19389 10.9276 5.3757 10.7987 5.50977L6.67365 9.79931C6.54399 9.92954 6.37032 10.0016 6.19006 9.99997C6.00979 9.99834 5.83736 9.92316 5.70989 9.7906C5.58242 9.65805 5.51011 9.47874 5.50855 9.29129C5.50698 9.10384 5.57628 8.92325 5.70151 8.78841L8.65299 5.71924H0.687509C0.50517 5.71924 0.3303 5.64392 0.201367 5.50984C0.0724338 5.37577 0 5.19393 0 5.00432C0 4.81471 0.0724338 4.63286 0.201367 4.49879C0.3303 4.36471 0.50517 4.28939 0.687509 4.28939H8.65299L5.70151 1.22022C5.57263 1.08615 5.50022 0.904344 5.50022 0.714771C5.50022 0.525199 5.57263 0.343388 5.70151 0.20932Z" fill="white" />
                           </svg>
                        </span>
                     </a>
                  <?php endif; ?>
                  
                  <div class="tp-header-toogle-wrapper d-xl-none ml-10">
                     <button class="tp-header-toogle"><i class="far fa-bars"></i></button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- header-area-end -->

</header>