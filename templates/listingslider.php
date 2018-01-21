<?php
global $post_attachments;
global $post;
$post_thumbnail_id  =   get_post_thumbnail_id( $post->ID );
$preview            =   wp_get_attachment_image_src($post_thumbnail_id, 'full');
$currency           =   esc_html( get_option('wp_estate_currency_label_main', '') );
$where_currency     =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
$price              =   intval   ( get_post_meta($post->ID, 'property_price', true) );
$price_label        =   esc_html ( get_post_meta($post->ID, 'property_label', true) );  
$property_city      =   get_the_term_list($post->ID, 'property_city', '', ', ', '') ;
$property_area      =   get_the_term_list($post->ID, 'property_area', '', ', ', '');

              

?>

<div class="listing_main_image" id="listing_main_image_photo" style="background-image: url('<?php echo $preview[0];?>')">
    
    <a href="<?php echo $preview[0];?>" rel="data-fancybox-thumb" class="property-photo-button fancybox-thumb prettygalery">VIEW PHOTOS</a>
    <!-- <div id="tooltip-pic"> <?php esc_html_e('click to see all images','wpestate');?></div> -->
    
     <div class="listing_main_image_text_wrapper"></div> 
    
    <div class="hidden_photos">
        <?php
       
        print ' <a href="'. $preview[0].'"  rel="data-fancybox-thumb"  title="'.get_post($post_thumbnail_id)->post_excerpt.'" class="fancybox-thumb prettygalery listing_main_image" > 
                    <img  src="'. $preview[0].'" data-original="'. $preview[0].'"  class="img-responsive" alt="gallery" />
                </a>';
            
        $arguments      = array(
                            'numberposts'   =>  -1,
                            'post_type'     =>  'attachment',
                            'post_mime_type'=>  'image',
                            'post_parent'   =>  $post->ID,
                            'post_status'   =>  null,
                            'exclude'       =>  $post_thumbnail_id,
                            'orderby'         => 'menu_order',
                            'order'           => 'ASC'
                      
                        );
 
        $post_attachments   = get_posts($arguments);
        foreach ($post_attachments as $attachment) {
            $full_prty          = wp_get_attachment_image_src($attachment->ID, 'full');
         
            print ' <a href="'.$full_prty[0].'" rel="data-fancybox-thumb" title="'.$attachment->post_excerpt.'" class="fancybox-thumb prettygalery listing_main_image" > 
                        <img  src="'. $full_prty[0].'" data-original="'.$full_prty[0].'" alt="'.$attachment->post_excerpt.'" class="img-responsive " />
                    </a>';

        }
        ?>
    </div>
    
</div><!--