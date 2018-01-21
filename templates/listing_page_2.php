
<?php
global $current_user;
global $feature_list_array;
global $propid ;
global $post_attachments;
global $options;
global $where_currency;
global $property_description_text;     
global $property_details_text;
global $property_features_text;
global $property_adr_text;  
global $property_price_text;   
global $property_pictures_text;    
global $propid;
global $gmap_lat;  
global $gmap_long;
global $unit;
global $currency;
global $use_floor_plans;
get_template_part('templates/listingslider'); 
get_template_part('templates/property_header2');
?>


<div class="row content-fixed-listing">
    <?php //get_template_part('templates/breadcrumbs'); ?>
    <div class=" <?php 
    if ( $options['content_class']=='col-md-12' || $options['content_class']=='none'){
        print 'col-md-8';
    }else{
        if(isset($options['content_class'])){
            print  $options['content_class']; 
        }
    }?> ">
    
        <?php get_template_part('templates/ajax_container'); ?>
        <?php
        while (have_posts()) : the_post();
            $image_id       =   get_post_thumbnail_id();
            $image_url      =   wp_get_attachment_image_src($image_id, 'wpestate_property_full_map');
            $full_img       =   wp_get_attachment_image_src($image_id, 'full');
            $image_url      =   $image_url[0];
            $full_img       =   $full_img [0];     
        ?>
        
        
        <div class="single-content listing-content">
    
            
     
        
      
        <!-- property images   -->   
        <div class="panel-wrapper imagebody_wrapper">
           
            <div class="panel-body imagebody imagebody_new">
                <?php  
                get_template_part('templates/property_pictures');
                ?>
            </div>
            
            
            <div class="panel-body video-body">
                <?php
                $video_id           = esc_html( get_post_meta($post->ID, 'embed_video_id', true) );
                $video_type         = esc_html( get_post_meta($post->ID, 'embed_video_type', true) );

                if($video_id!=''){
                    if($video_type=='vimeo'){
                        echo wpestate_custom_vimdeo_video($video_id);
                    }else{
                        echo wpestate_custom_youtube_video($video_id);
                    }    
                }
                ?>
            </div>
     
        </div>

        <!-- Features and Amenities -->
        <div class="panel-wrapper panel-wrapper--features u-border-top">
            <?php 

            if ( count( $feature_list_array )!=0 && !count( $feature_list_array )!=1 ){ //  if are features and ammenties
                if($property_features_text ==''){
                    print '<a class="panel-title--property" id="listing_ammenities" data-toggle="collapse" data-parent="#accordion_prop_addr" href="#collapseFour"><span class="panel-title-arrow"></span>'.esc_html__( 'Amenities and Features', 'wpestate').'</a>';
                }else{
                    print '<a class="panel-title--property" id="listing_ammenities" data-toggle="collapse" data-parent="#accordion_prop_addr" href="#collapseFour"><span class="panel-title-arrow"></span>'. $property_features_text.'</a>';
                }
                ?>
                <div id="collapseFour" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <?php print estate_listing_features($post->ID); ?>
                    </div>
                </div>
            <?php
            } // end if are features and ammenties
            ?>
        </div>

        <div class="panel-wrapper u-border-top">
            <div class="col-md-6 listing_detail">
                <!-- property address   -->
                <div class="panel-title--property" id="listing_details">
                    <?php if($property_adr_text!=''){
                        echo $property_adr_text;
                    } else{
                        esc_html_e('Property Address','wpestate');
                    }
                    ?>
                </div>    
                <div id="" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <?php print estate_listing_address($post->ID); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6 listing_detail">
                <!-- property details   -->  
                <?php                                       
                    if($property_details_text=='') {
                        print'<div class="panel-title--property">'.esc_html__( 'Property Details', 'wpestate').'  </div>';
                    }else{
                        print'<div class="panel-title--property">'.$property_details_text.'  </div>';
                    }
                ?>
                <div id="" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <?php print estate_listing_details($post->ID);?>
                    </div>
                </div>
            </div>  
        </div>

        <!-- Policies   -->  
        <div class="panel-wrapper panel-wrapper--policies u-border-top">
            <a class="panel-title--property" id="listing_policies" data-toggle="collapse" data-parent="#accordion_prop_addr" href="#collapseFive"><span class="panel-title-arrow"></span>Booking terms</a>
            <div id="collapseFive" class="panel-collapse collapse in">
                <div class="panel-body">
                    <div class="property-policies">
                        <?php the_field('property_policies'); ?>
                    </div>
                </div>
            </div>
        </div>

       
        <?php 
            $posts = get_field('apartment_types');

            if( $posts ): ?>

                    <div class="panel-wrapper u-border-top">
                        <h4 class="panel-title--property">APARTMENT TYPES</h4>
                        <div class="panel-apartments-type">
                        
                        <?php foreach( $posts as $p ): // variable must NOT be called $post (IMPORTANT) ?>
                            
                            <?php  
                                $link = esc_url (get_permalink($p->ID));
                                $title = get_the_title($p->ID);
                                $property_city = get_the_term_list($p->ID, 'property_city', '', ', ', '') ;
                                $property_area = get_the_term_list($p->ID, 'property_area', '', ', ', '');
                                $guests = intval( get_post_meta($p->ID, 'guest_no', true) );
                            ?>
                            <div class="listing_wrapper col-md-6 shortcode-col  ssx property_flex ">
                                <a href="<?php echo $link;?>" class="">
                                    <div class="property_listing">
                                        <div class="title-container">
                                            <div class="category_name">
                                                <div class="price_unit_wrapper">
                                                    <div class="price_unit">
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
         
        <?php
        endwhile; // end of the loop
        $show_compare=1;
        ?>
        </div><!-- end single content -->
    </div><!-- end 8col container-->
    <div class="clearfix visible-xs"></div>
</div>   



<div class="full_width_row">
    
            <?php     get_template_part ('/templates/listing_reviews'); ?>
    
    <div class="google_map_on_list_wrapper">    
         
           
        <div id="gmapzoomplus"></div>
        <div id="gmapzoomminus"></div>
        <div id="gmapstreet"></div>
    
        <div id="google_map_on_list" 
            data-cur_lat="<?php   echo $gmap_lat;?>" 
            data-cur_long="<?php echo $gmap_long ?>" 
            data-post_id="<?php echo $post->ID; ?>">
        </div>
    </div>    
    
 
            <?php   get_template_part ('/templates/similar_listings');?>
    

</div>

<?php get_footer(); ?>