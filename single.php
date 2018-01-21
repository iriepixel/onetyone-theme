<?php
// Sigle - Blog post
// Wp Estate Pack
get_header();
$options=wpestate_page_details($post->ID); 
global $more;
global $where_currency;
global $currency;
global $property_unit_slider;
$more = 0;

if ( 'wpestate_message' == get_post_type() || 'wpestate_invoice' == get_post_type() || 'wpestate_booking' == get_post_type() ){
    exit();
}
?>

<div id="post" <?php post_class('row content-fixed');?>>
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class=" <?php print $options['content_class'];?> ">
        <?php get_template_part('templates/ajax_container'); ?>      
        <div class="single-content single-blog">
            <?php      
             
            while ( have_posts() ) : the_post();
            if (esc_html( get_post_meta($post->ID, 'post_show_title', true) ) != 'no') { ?> 
               
                <h1 class="entry-title single-title" ><?php the_title(); ?></h1>
                
                <div class="meta-element-head"> 
                    <?php print ''.esc_html__( 'Published on','wpestate').' '.the_date('', '', '', FALSE).' '.esc_html__( 'by', 'wpestate').' '.get_the_author();  ?>
                </div>
        
            <?php 
            } 
            get_template_part('templates/postslider');
            if (has_post_thumbnail()){
                $pinterest = wp_get_attachment_image_src(get_post_thumbnail_id(),'wpestate_property_full_map');
            }
      
            the_content('Continue Reading');                     
            $args = array(
                'before'           => '<p>' . esc_html__( 'Pages:','wpestate'),
                'after'            => '</p>',
                'link_before'      => '',
                'link_after'       => '',
                'next_or_number'   => 'number',
                'nextpagelink'     => esc_html__( 'Next page','wpestate'),
                'previouspagelink' => esc_html__( 'Previous page','wpestate'),
                'pagelink'         => '%',
                'echo'             => 1
            ); 
            wp_link_pages( $args ); 
            ?>  
            
            <div class="meta-info"> 
                <div class="meta-element">
                    <?php print '<strong>'.esc_html__( 'Category','wpestate').': </strong>';the_category(', ')?>
                </div>
             
            
                <div class="prop_social_single">
                    <a href="http://www.facebook.com/sharer.php?u=<?php echo esc_url(get_permalink()); ?>&amp;t=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share_facebook"><i class="fa fa-facebook fa-2"></i></a>
                    <a href="http://twitter.com/home?status=<?php echo urlencode(get_the_title() .' '. esc_url(get_permalink())); ?>" class="share_tweet" target="_blank"><i class="fa fa-twitter fa-2"></i></a>
                    <a href="https://plus.google.com/share?url=<?php echo esc_url(get_permalink()); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank" class="share_google"><i class="fa fa-google-plus fa-2"></i></a> 
                    <?php if (isset($pinterest[0])){ ?>
                        <a href="http://pinterest.com/pin/create/button/?url=<?php echo esc_url(get_permalink()); ?>&amp;media=<?php echo $pinterest[0];?>&amp;description=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share_pinterest"> <i class="fa fa-pinterest fa-2"></i> </a>      
                    <?php } ?>
                </div>
            </div> 
        </div>

         <?php 
            $posts = get_field('apartment_types');

            if( $posts ): ?>

                    <div class="panel-wrapper u-border-top">
                        <h4 class="panel-title--property">FEATURED APARTMENTS</h4>
                        <div class="panel-apartments-type">
                        
                        <?php foreach( $posts as $p ): // variable must NOT be called $post (IMPORTANT) ?>
                            
                            <?php  
                                $link = esc_url (get_permalink($p->ID));
                                $preview = wp_get_attachment_image_src(get_post_thumbnail_id($p), 'wpestate_property_listings');
                                $thumb_prop = '<img src="'.$preview[0].'" class="b-lazy img-responsive wp-post-image lazy-hidden" alt="no thumb" />';
                                $title = get_the_title($p->ID);
                                $property_city = get_the_term_list($p->ID, 'property_city', '', ', ', '') ;
                                $property_area = get_the_term_list($p->ID, 'property_area', '', ', ', '');
                                $guests = intval( get_post_meta($p->ID, 'guest_no', true) );
                            ?>
                            <div class="listing_wrapper col-md-6 shortcode-col  ssx property_flex ">
                                <a href="<?php echo $link;?>" class="">
                                    <div class="property_listing">
                                        <div class="listing-unit-img-wrapper">
                                            <!-- <div class="cross"></div>
                                            <a href="<?php echo $link; ?>"><?php echo $thumb_prop; ?></a>  -->
                                            <?php
                                                //slider
                                                $arguments      = array(
                                                    'numberposts'       => -1,
                                                    'post_type'         => 'attachment',
                                                    'post_mime_type'    => 'image',
                                                    'post_parent'       => $post->ID,
                                                    'post_status'       => null,
                                                    'exclude'           => get_post_thumbnail_id(),
                                                    'orderby'           => 'menu_order',
                                                    'order'             => 'ASC'
                                                );
                                                $post_attachments   = get_posts($arguments);

                                                $slides='';

                                                $no_slides = 0;
                                                foreach ($post_attachments as $attachment) { 
                                                    $no_slides++;
                                                    $preview    =   wp_get_attachment_image_src($attachment->ID, 'wpestate_property_listings');
                                                    $slides     .= '<div class="item lazy-load-item">
                                                                        <a href="'.$link.'"><img  data-lazy-load-src="'.$preview[0].'" alt="'.$title.'" class="img-responsive" /></a>
                                                                    </div>';

                                                }// end foreach
                                                $unique_prop_id=uniqid();
                                                print '
                                                <div id="property_unit_carousel_'.$unique_prop_id.'" class="carousel property_unit_carousel slide  " data-ride="carousel" data-interval="false">
                                                    <div class="carousel-inner">         
                                                        <div class="item active">    
                                                            <a href="'.$link.'">'.$thumb_prop.'</a>     
                                                        </div>
                                                        '.$slides.'
                                                    </div>


                                               

                                                <a href="'.$link.'"> </a>';

                                                if( $no_slides>0){
                                                    print '<a class="left  carousel-control" href="#property_unit_carousel_'.$unique_prop_id.'" data-slide="prev">
                                                        <i class="fa fa-angle-left"></i>
                                                    </a>

                                                    <a class="right  carousel-control" href="#property_unit_carousel_'.$unique_prop_id.'" data-slide="next">
                                                        <i class="fa fa-angle-right"></i>
                                                    </a>';
                                                }
                                                print'</div>';
                                            ?>

                                        </div>
                                        <div class="title-container">
                                            <div class="category_name">
                                                <div class="price_unit_wrapper">
                                                    <div class="price_unit">
                                                        £
                                                        <?php  
                                                            wpestate_show_price($p->ID,$currency,$where_currency,0);
                                                        ?>
                                                    </div> 
                                                </div>
                                                <div class="listing_title_unit">
                                                    <?php 
                                                        echo mb_substr ( html_entity_decode ($title), 0, 40, "UTF8") ; 
                                                        if(strlen($title)>40){
                                                            echo '...';   
                                                        }
                                                    ?>
                                                </div>
                                                <div class="category_tagline">
                                                    <img src="<?php echo get_stylesheet_directory_uri() ;?>/images/icons/guest.svg"  alt="guests">
                                                    <?php echo $guests . ' Guests max' ?>
                                                </div>
                                                <div class="category_tagline category_tagline--location">
                                                    <img src="<?php echo get_stylesheet_directory_uri() ;?>/images/icons/location.svg"  alt="location">
                                                   
                                                    <?php  
                                                    if ($property_area != '') {
                                                        echo $property_area.', ';
                                                    } 
                                                    echo $property_city;?>
                                                </div>
                                            </div>
                                        </div><!-- ================ -->
                                    </div>
                                </a>
                            </div>

                        <?php endforeach; ?>
                    </div>
                </div><!-- ============== -->
            <?php endif; ?>   
     
            
        <!-- #related posts start-->    
        <?php  get_template_part('templates/related_posts');?>    
        <!-- #end related posts -->   
        
        <!-- #comments start-->
        <?php comments_template('', true);?> 	
        <!-- end comments -->   
        
        <?php endwhile; // end of the loop. ?>
    </div>
       
<?php  include(locate_template('sidebar.php')); ?>
</div>   

<?php get_footer(); ?>