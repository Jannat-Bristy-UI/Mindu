<?php

class Mindu_Hero extends \Elementor\Widget_Base {

    // Content Traits
    use Hero_Content_Trait;

    // Style Traits
    use Typo_Style_Controls;
    use Button_Style_Trait;

    // ====== Widget Info ======
    public function get_name(): string {
        return 'mindu-hero';
    }

    public function get_title(): string {
        return esc_html__( 'Theme Hero', 'elementor-addon' );
    }

    public function get_icon(): string {
        return 'eicon-accordion';
    }

    public function get_categories(): array {
        return [ 'mindu-category' ];
    }

    public function get_keywords(): array {
        return [ 'hero' ];
    }

    // ====== Register Controls ======
    protected function register_controls(): void {

        // Content Tab
        $this->register_controls_section();

        // Style Tab
        $this->register_style_section();
    }

    // ====== Content Controls ======
    protected function register_controls_section() {

        $this->register_hero_controls();
    }

    // ====== Style Controls ======
    protected function register_style_section() {

        // Typography
        $this->typo_style_controls( 'sub_title', 'Sub-Title', '.el-sub-title' );
        $this->typo_style_controls( 'title', 'Title', '.el-title' );

        // FIXED selector
        $this->typo_style_controls( 'content', 'Content', '.el-content' );

        // Buttons
        $this->button_style_controls('button','Button Style','.el-tp-btn');	
        $this->button_style_controls( 'explore', 'Explore Button Style', '.hero-explore-btn' );
    }

    // ====== Render ======
    protected function render(): void {

        $settings = $this->get_settings_for_display();

       
        ?>

        <div class="tp-hero-spacing z-1 tp-hero-overly p-relative bg-position tp-hero-area" style="background-image: url(<?php echo esc_url( $settings['hero_image']['url'] ); ?>);">
            <div class="container">
                <div class="row align-items-end">
                    <div class="col-xl-7">
                        <div class="tp-hero-content mb-40">
                            <div class="el-hero-content">

                                <!-- Sub-Title -->
                                <?php if ( ! empty( $settings['hero_sub_title'] ) ) : ?>
                                    <div class="tp-hero-ratings-wrap d-inline-flex mb-15">
                                        <span class="tp-hero-ratings-text el-sub-title mr-10 d-flex align-items-center">
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 0L9.163 4.60778L14 5.35121L10.5 8.93586L11.326 14L7 11.6078L2.674 14L3.5 8.93586L0 5.35121L4.837 4.60778L7 0Z" fill="currentColor" />
                                            </svg>
                                            <?php echo mc_kses( $settings['hero_sub_title'] ); ?>
                                        </span>
                                        <div class="tp-hero-ratings pl-10">
                                        <span>
                                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M4.89999 0L6.41408 3.22545L9.79997 3.74585L7.34998 6.2551L7.92818 9.8L4.89999 8.12545L1.87179 9.8L2.44999 6.2551L0 3.74585L3.38589 3.22545L4.89999 0Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <span>
                                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M4.89999 0L6.41408 3.22545L9.79997 3.74585L7.34998 6.2551L7.92818 9.8L4.89999 8.12545L1.87179 9.8L2.44999 6.2551L0 3.74585L3.38589 3.22545L4.89999 0Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <span>
                                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M4.89999 0L6.41408 3.22545L9.79997 3.74585L7.34998 6.2551L7.92818 9.8L4.89999 8.12545L1.87179 9.8L2.44999 6.2551L0 3.74585L3.38589 3.22545L4.89999 0Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <span>
                                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M4.89999 0L6.41408 3.22545L9.79997 3.74585L7.34998 6.2551L7.92818 9.8L4.89999 8.12545L1.87179 9.8L2.44999 6.2551L0 3.74585L3.38589 3.22545L4.89999 0Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <span>
                                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M4.89999 0L6.41408 3.22545L9.79997 3.74585L7.34998 6.2551L7.92818 9.8L4.89999 8.12545L1.87179 9.8L2.44999 6.2551L0 3.74585L3.38589 3.22545L4.89999 0Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Title -->
                                <?php if ( ! empty( $settings['hero_title'] ) ) : ?>
                                    <h2 class="tp-hero-title el-title mb-25">
                                        <?php echo mc_kses( $settings['hero_title'] ); ?>
                                    </h2>
                                <?php endif; ?>

                                <!-- Content -->
                                <?php if ( ! empty( $settings['hero_content'] ) ) : ?>
                                    <p class="tp-hero-dec el-content mb-30">
                                        <?php echo mc_kses( $settings['hero_content'] ); ?>
                                    </p>
                                <?php endif; ?>
                            </div>







                            
                            <?php
                            if ( ! empty( $settings['button_text'] ) ) {

                                $this->add_link_attributes( 'button_arg', $settings['button_url'] );

                                $this->add_render_attribute(
                                    'button_arg',
                                    'class',
                                    'tp-btn tp-btn-square'
                                );
                            }
                            ?>

                            <?php if ( ! empty( $settings['button_text'] ) ) : ?>

                                <a <?php echo $this->get_render_attribute_string( 'button_arg' ); ?>>

                                    <?php echo esc_html( $settings['button_text'] ); ?>

                                    <span class="ml-8">

                                        <?php
                                        if ( 'icon' === $settings['icon_style'] ) {

                                            if ( ! empty( $settings['icon']['value'] ) ) {

                                                \Elementor\Icons_Manager::render_icon(
                                                    $settings['icon'],
                                                    [
                                                        'aria-hidden' => 'true',
                                                        'class' => 'tp-btn-icon'
                                                    ]
                                                );
                                            }

                                        } elseif ( 'svg' === $settings['icon_style'] ) {

                                            echo mc_kses( $settings['svg'] );
                                        }
                                        ?>

                                    </span>

                                </a>

                            <?php endif; ?>










  
                        </div>
                    </div>

                  <!-- Video -->
					<?php if(!empty($settings['video_url'])) : ?>
						<div class="col-xl-5">
							<div class="d-flex justify-content-xl-end mb-40">
								<div class="tp-hero-video wow fadeInUp" data-wow-duration=".9s" data-wow-delay=".6s">
									<video loop muted autoplay playsinline>
										<source src="<?php echo mc_kses($settings['video_url']); ?>" type="video/mp4">
									</video>
									<a href="<?php echo mc_kses($settings['video_text_link']); ?>" class="tp-hero-video-btn d-flex align-items-center justify-content-between">
										<?php echo mc_kses($settings['video_text']); ?>
										<span>
											<svg width="17" height="15" viewBox="0 0 17 15" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M15.3245 7.25217L0.75 7.25097M9.69313 0.75C9.69313 0.75 15.7499 5.63242 15.75 7.25052C15.7502 8.86869 9.69424 13.75 9.69424 13.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
											</svg>
										</span>
									</a>
								</div>
							</div>
						</div>
					<?php endif; ?>
                </div>
            </div>
        </div>

        <?php
    } // end render()

} // end class


/** @var \Elementor\Widgets_Manager $widgets_manager */
$widgets_manager->register( new Mindu_Hero() );