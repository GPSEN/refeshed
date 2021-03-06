<?php

/**
 * Template Name: News Page Template
 *
 * The business page template displays your posts with a "business"-style
 * content slider at the top.
 *
 * @package WooFramework
 * @subpackage Template
 */

global $woo_options, $wp_query;

get_header();

$page_template = woo_get_page_template();

require_once (__DIR__ . '/lib/GPSEN_posts.php');

if ( class_exists('GPSEN_posts') ) {
    $gpsen_posts = new GPSEN_posts();
}

?>
     <!-- #content Starts -->
<?php woo_content_before(); ?>

<?php if ( ( isset( $woo_options['woo_slider_biz'] ) && 'true' == $woo_options['woo_slider_biz'] ) && ( isset( $woo_options['woo_slider_biz_full'] ) && 'true' == $woo_options['woo_slider_biz_full'] ) ) { $saved = $wp_query; woo_slider_biz(); $wp_query = $saved; } ?>

     <div id="content" class="col-full business">
          <div id="main-sidebar-container" class="newsPage">

               <!-- #main Starts -->
               <?php woo_main_before(); ?>

               <?php if ( ( isset( $woo_options['woo_slider_biz'] ) && 'true' == $woo_options['woo_slider_biz'] ) && ( isset( $woo_options['woo_slider_biz_full'] ) && 'false' == $woo_options['woo_slider_biz_full'] ) ) { $saved = $wp_query; woo_slider_biz(); $wp_query = $saved; } ?>

               <section id="main">
                    <h2 class="greenHeaders">News</h2>

                    <?php
                    // TO SHOW THE PAGE CONTENTS
                    while ( have_posts() ) : the_post(); ?> <!--Because the_content() works only inside a WP Loop -->
	                    <?php
	                    $content = get_the_content();
	                    if(!empty($content)) { ?>
                            <div class="entry-content-page">
                                <div class="greySections">
                                    <div class="whiteCard">
					                    <?php the_content(); ?> <!-- Page Content -->
                                    </div>
                                </div>
                            </div><!-- .entry-content-page -->
                            <div class="clearBoth"></div>
	                    <?php } ?>
                    <?php
                    endwhile; //resetting the page loop
                    wp_reset_query(); //resetting the page query
                    ?>

                    <?php

                    woo_loop_before();

                    $post_type = 'post';
                    $category = 'news';
                    $number = '-1';
                    $order = 'DESC';
                    $menu_order = 'menu_order';

                    $gpsen_posts->gpsen_build_news_posts( $post_type, $category, $number, $order, $menu_order );


                    // News Archives
                    echo '<h2 class="blueHeaders" id="newsLetterH2">GPSEN Newsletter Archives</h2>';
                    echo '    <div id="newsAccordion">';

                    $custom_terms = get_terms( 'gpsen_news_archives_categories' );
//                    echo '<pre>';
//                        var_dump($custom_terms);
//                    echo '</pre>';
                    $reordered_terms = array_reverse( $custom_terms );

                    if ( !empty($reordered_terms) ) {

                        foreach ( $reordered_terms as $term ) {
	                        wp_reset_query();

	                        $tax = [
                                [
	                                'taxonomy' => 'gpsen_news_archives_categories',
	                                'field' => 'slug',
	                                'terms' => $term->slug,
                                ]
	                        ];

	                        $gpsen_posts->gpsen_build_news_archives( $tax, $term );

                        }

                    }
                    echo '</div><!--end news accordion-->';
                    woo_loop_after();
                    ?>
               </section><!-- /#main -->

               <?php woo_main_after(); ?>
               <?php get_sidebar(); ?>

          </div><!-- /#main-sidebar-container -->
          <?php get_sidebar( 'alt' ); ?>
     </div><!-- /#content -->

<?php woo_content_after(); ?>
<?php get_footer(); ?>