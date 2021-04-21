<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header();

$category = get_queried_object();

// $term_id = $category->term_id ?  $category->term_id : 24;
$term_id = $category->term_id;
$parent_id = $category->parent == 0 ? $category->term_id : $category->parent;
$term = get_term($term_id);
$product_cat = 'product_cat_'.$term_id;
if(!$term_id){
    $term_id = 41;// id page shop
    $product_cat = $term_id;
}
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet" />

<main class="our-storages">
    <section class="hero">
        <div class="hero__container">
            <div class="hero__image-wrapper">
                <?php if($gallery = get_field('gallery', $product_cat)){ ?>
                    <div class="storage__place-wrapper">
                        <div class="storage__main-image swiper-container">
                            <div class="swiper-wrapper">
                                <?php foreach ($gallery as $image) {
                                    ?>
                                    <div class="swiper-slide">
                                        <?php if($image['type'] === 'image'){ ?>
                                            <a href="<?php echo $image['url'] ?>" data-lightbox="image-1" data-title="<?php echo $image['title'] ?>">
                                                <img src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>" title="<?php echo $image['title'] ?>" draggable="true">
                                            </a>
                                        <?php }else if($image['type'] === 'video'){ ?>
                                            <video  controls="controls" loop="loop" autoplay muted>
                                                <source src="<?php echo $image['url'] ?>">
                                                </video>
                                            <?php }
                                            ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <div class="hero__text-wrapper">
                    <h1 class="hero__title page-title"><?php the_field('category_title', $product_cat); ?></h1>
                    <div class="landing-hero__descr">

                        <?php if ($seo_text = get_field('category_description', $product_cat)) {
                            echo $seo_text;
                        }
                        ?>
                    </div>
                    <div class="info_about_plant">
                        <div class="info_about_plant-header">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.99975 5.99976C9.31333 2.68618 14.6857 2.68618 17.9993 5.99976C21.3128 9.31334 21.3128 14.6857 17.9993 17.9993L12.5709 23.4276C12.2553 23.7432 11.7437 23.7432 11.4281 23.4276L5.99975 17.9993C2.68618 14.6857 2.68618 9.31334 5.99975 5.99976Z" fill="#1B1B1B"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.75711 7.18652H14.2263V9.42843H9.75711V7.18652ZM9.75711 14.5893H14.2263V16.8312H9.75711V14.5893ZM9.41813 9.76731H7.17896V14.242H9.41813V9.76731ZM14.5595 9.76731H16.7987V14.242H14.5595V9.76731Z" fill="white"/>
                            </svg>
                            Info om anläggningen
                        </div>
                        <div class="info_about_plant-body">
                            <div class="info_about_plant-wrapper">
                                <?php if ($info_about_the_plant = get_field('info_about_the_plant', $product_cat)) {
                                    echo $info_about_the_plant;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php echo get_template_part('inc/features'); ?>


        <section class="choose-unit">
            <div class="choose-unit__container">

                <div class="storage__choose-wrapper">
                    <h2 class="choose-unit__title page-title">Välj ditt förråd:</h2>
                    <p class="choose-unit__description description">
                        <?php 
                        if ($text = get_field('text', $product_cat)) {
                            echo $text;
                        }
                        ?>
                    </p>
                    <div class="storage__choose-body">
                        <div class="choose-unit__range">
                            <p class="choose-unit__range-info">Välj yta att förvara i m²</p>
                            <?php 
                            $pa_square = get_terms(array(
                                'orderby'     => 'name',
                                'order'       => 'ASC',
                                'taxonomy'    => 'pa_square',
                                'fields' => 'names',
                                'hide_empty' => false
                            ));
                            sort($pa_square, SORT_NUMERIC); 
                            ?>
                            <div id="slider" data-min_square="<?php echo $pa_square[0]; ?>" data-max_square="<?php echo $pa_square[count($pa_square)-1]; ?>"></div>
                        </div>
                        <div class="storage__choose-btn">
                            <a href="#" class="landing-call__btn btn">
                                <svg width="25" height="31" viewBox="0 0 25 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M20.974 3.90883C16.2512 -1.04383 8.59404 -1.04383 3.87125 3.90883C-0.851536 8.86149 -0.851534 16.8914 3.87126 21.844L11.6082 29.9575C12.058 30.4292 12.7873 30.4292 13.237 29.9575L20.974 21.844C25.6968 16.8914 25.6968 8.86149 20.974 3.90883ZM15.5952 5.68294H9.22532V9.03383H15.5952V5.68294ZM15.5952 16.7479H9.22532V20.0988H15.5952V16.7479ZM5.55121 9.54046H8.74267V16.2286H5.55121V9.54046ZM19.261 9.54036H16.0695V16.2285H19.261V9.54036Z" fill="white"/>
                                </svg>
                            titta på kartan</a>
                        </div>
                        <div class="storage__choose-category" id="storage__choose-category">
                            <?php 
                            $categories=get_categories(
                                [
                                    "parent" => $parent_id,
                                    "hide_empty" => 0,
                                    "orderby" => "name",
                                    "taxonomy" => "product_cat"
                                ]
                            );
                            ?>
                            <select name="event-dropdown" class="js-select-category" onchange='document.location.href=this.options[this.selectedIndex].value;'>
                                <option value="<?php echo get_category_link($parent_id); ?>" <?php if( $term_id === NULL){ echo "selected";} ?> >ALLA LAGER</option>
                                <?php 
                                foreach ($categories as $category) {
                                    $selected = $category->term_id === $term_id ? "selected" : "";
                                    $option = '<option value="/hyra-forrad/'.$category->slug.'" '. $selected .'>';
                                    $option .= $category->cat_name;
                                    $option .= '</option>';
                                    echo $option;
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                </div>

                <?php  
                $args = array(
                    'post_type'      => 'product',
                    'posts_per_page' => 10,
                    // 'meta_key' => 'pa_square',
                    'meta_query' => array(
                        array(
                            'key' => '_stock_status',
                            'value' => 'instock'
                        ),
                        array(
                            'key' => 'pa_square',
                            'type'    => 'numeric',
                        )
                    ),
                    'order' => 'ASC',
                    'orderby' => 'pa_square',
                );
                $loop = new WP_Query( $args );
                ?>
                <div class="storage__card-list">
                 <div class="swiper-wrapper">
                    <?php
                    while ( $loop->have_posts() ) : $loop->the_post(); global $product;
                        wc_get_template_part( 'content', 'product' );
                    endwhile; wp_reset_query();
                    ?>
                </div>
                <div class="storage__swiper-pagination"></div>
            </div>


        </div>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $.each($('.variations_form'), function(index, val) {
                    var form = $(this),
                        product_variations = $(this).data('product_variations');
                    $.each(product_variations, function(index, product_variation) {
                        if(product_variation.is_in_stock){
                            form.find('option[value="'+product_variation.attributes.attribute_pa_number+'"]').attr('selected', 'selected').attr('value','"'+product_variation.variation_id+'"');
                            form.find('input[name="add-to-cart"]').attr('value', product_variation.variation_id);
                            var product_id = form.find('input[name="product_id"]').val();
                            $.each($('.hero__form option[data-id]'), function () {
                                var hero__form = $(this);
                                if(hero__form.attr('data-id') === product_id){
                                    hero__form.attr('data-id', product_variation.variation_id);
                                }
                            });
                            return false;
                        }
                    });
                });
            });
        </script>
    </section>

    <section>
        <div class="storage__map" id="map"></div>
    </section>
    <?php echo get_template_part('inc/map_modal'); ?>

    <section class="category_footer_section">
        <div class="category_footer_container">
            <?php if($footer_description = get_field('footer_description', $product_cat)){ ?>
                <div class="category_footer_container-desc">
                    <?php echo $footer_description; ?>
                </div>
            <?php } ?>
            <?php if($footer_image = get_field('footer_image', $product_cat)){ ?>
                <div class="category_footer_container-img">
                    <img src="<?php echo $footer_image['url']; ?>" alt="<?php echo $footer_image['alt']; ?>" title="<?php echo $footer_image['title']; ?>">
                </div>
            <?php } ?>
        </div>
    </section>
    <?php 
// echo get_template_part('inc/call-request'); 
    ?>
</main>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<?php 
get_footer();