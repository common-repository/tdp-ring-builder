<?php
/*
Template Name: Vue App Template
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header();

?>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php echo do_shortcode( '[Ring_Builder]' )?>
    </main>
</div>
<?php
get_footer();?>