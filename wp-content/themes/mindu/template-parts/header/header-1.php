<?php 

global $mindu; // Same as your opt_name

$header_right_switcher = $mindu['header-right-switcher'] ?? '';
$header_col = ($header_right_switcher == true) ? 'col-xxl-8 col-xl-7 d-none d-xl-block' : 'col-xxl-10 col-xl-10 d-none d-xl-block'; // Adjust column width based on switcher
$header_menu_pos = ($header_right_switcher == true) ? 'justify-content-center' : 'justify-content-end'; // Adjust menu position based on switcher

$header_button_text = $mindu['header-button-text'] ?? '';
$header_button_url = $mindu['header-button-url'] ?? '';

?> 

<!-- Header start -->  
<header class="tp-header-height">    
   <div id="header-sticky" class="tp-header-area tp-header-lg-spacing">
         <div class="container">
            <div class="row align-items-center">
               <!-- Logo -->
               <div class="col-xxl-2 col-xl-2 col-6">
                  <div class="tp-header-logo">
                     <!-- Calls a PHP function to display the header logo dynamically -->
                      <?php header_logo(); ?>
                  </div>
               </div>

               <!-- Menu -->
               <div class="col-xxl-10 col-xl-10 col-6">
                  <div class="tp-header-left d-none d-xl-block text-end">
                     <div class="tp-main-menu tp-main-menu-2 tp-menu-dropdown">
                        <nav class="tp-mobile-menu-active">
                           <!-- Calls a PHP function to display the main menu dynamically -->
                           <?php header_main_menu(); ?>
                        </nav>
                     </div>
                  </div>


                  <!-- Toogle Bar -->
                  <div class="tp-header-option tp-header-2-option d-flex align-items-center justify-content-end">
                     <div class="tp-header-toogle-wrapper d-xl-none ml-10">
                        <button class="tp-header-toogle"><i class="far fa-bars"></i></button>
                     </div>
                  </div>


               </div>

               

            </div>
         </div>
   </div>
  
</header>

<!-- header-area-end -->