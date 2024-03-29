<?php
global $curent_fav;
global $currency;
global $where_currency;
global $show_compare;
global $show_compare_only;
global $show_remove_fav;
global $options;
global $isdashabord;
global $align;
global $align_class;
global $is_shortcode;
global $is_widget;
global $row_number_col;
global $full_page;
global $listing_type;
global $property_unit_slider;
global $book_from;
global $book_to;
global $guest_no;

$pinterest          =   '';
$previe             =   '';
$compare            =   '';
$extra              =   '';
$property_size      =   '';
$property_bathrooms =   '';
$property_rooms     =   '';
$measure_sys        =   '';

$col_class  =   'col-md-6';
$col_org    =   4;
 $title=get_the_title($post->ID);

if(isset($is_shortcode) && $is_shortcode==1 ){
    $col_class='col-md-'.$row_number_col.' shortcode-col';
}

if(isset($is_widget) && $is_widget==1 ){
    $col_class='col-md-12';
    $col_org    =   12;
}

if(isset($full_page) && $full_page==1 ){
    $col_class='col-md-4 ';
    $col_org    =   3;
    if(isset($is_shortcode) && $is_shortcode==1 && $row_number_col==''){
        $col_class='col-md-'.$row_number_col.' shortcode-col';
    }
}

$link           =  esc_url ( get_permalink());

if ( isset($_GET['check_in']) && isset($_GET['check_out']) ){
    $check_out= sanitize_text_field ( $_GET['check_out'] );
    $check_in= sanitize_text_field ( $_GET['check_in'] );
 
    $link   =   add_query_arg( 'check_in_prop', $check_in, $link);
    $link   =   add_query_arg( 'check_out_prop', $check_out, $link);
    
   
    if(isset($_GET['guest_no'])){
        $guest_no=intval($_GET['guest_no']);
        $link=add_query_arg( 'guest_no_prop', $guest_no, $link);
    }
}else{
    if ($book_from!='' && $book_to!=''){
        $book_from  = sanitize_text_field ($book_from);
        $book_to    = sanitize_text_field ( $book_to );
        $link   =   add_query_arg( 'check_in_prop', $book_from, $link);
        $link   =   add_query_arg( 'check_out_prop', $book_to, $link);
    
        if($guest_no!=''){
            $link=add_query_arg( 'guest_no_prop', intval($guest_no), $link);
        }
        
    }
}





$preview        =   array();
$preview[0]     =   '';
$favorite_class =   'icon-fav-off';
$fav_mes        =   esc_html__( 'add to favorites','wpestate');
if($curent_fav){
    if ( in_array ($post->ID,$curent_fav) ){
    $favorite_class =   'icon-fav-on';   
    $fav_mes        =   esc_html__( 'remove from favorites','wpestate');
    } 
}

$listing_type_class='property_unit_v2';
if($listing_type==1){
    $listing_type_class='';
} 
$property_status= stripslashes ( get_post_meta($post->ID, 'property_status', true));


?>  



<div class="listing_wrapper <?php echo $col_class.' '.$listing_type_class; ?> ssx property_flex " data-org="<?php echo $col_org;?>" data-listid="<?php echo $post->ID;?>" > 
    <div class="property_listing " data-link="<?php echo $link;?>">
        <?php
  
            $pinterest = wp_get_attachment_image_src(get_post_thumbnail_id(), 'wpestate_property_full_map');
            $preview   = wp_get_attachment_image_src(get_post_thumbnail_id(), 'wpestate_property_listings');
            $compare   = wp_get_attachment_image_src(get_post_thumbnail_id(), 'wpestate_slider_thumb');
            $extra= array(
                'data-original' =>  $preview[0],
                'class'         =>  'b-lazy img-responsive',    
            );
            
            //$thumb_prop         =  '<img data-src="'.$preview[0].'"  src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" class="b-lazy img-responsive wp-post-image lazy-hidden" alt="no thumb" />';   
            $thumb_prop         =  '<img src="'.$preview[0].'"   class="b-lazy img-responsive wp-post-image lazy-hidden" alt="no thumb" />';   
          
            if($preview[0] == ''){
                $thumb_prop_default =  get_stylesheet_directory_uri().'/img/defaultimage_prop.jpg';
               // $thumb_prop         =  '<img data-src="'.$thumb_prop_default.'"  src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" class="b-lazy img-responsive wp-post-image" lazy-hidden alt="no thumb" />';   
                $thumb_prop         =  '<img src="'.$thumb_prop_default.'" class="b-lazy img-responsive wp-post-image  lazy-hidden" alt="no thumb" />';   
            }
            
            $featured               =   intval  ( get_post_meta($post->ID, 'prop_featured', true) );
            $property_rooms         =   get_post_meta($post->ID, 'property_bedrooms', true);
            if($property_rooms!=''){
                $property_rooms=intval($property_rooms);
            }
            
            $property_bathrooms     =   get_post_meta($post->ID, 'property_bathrooms', true) ;
            if($property_bathrooms!=''){
                $property_bathrooms=floatval($property_bathrooms);
            }
            
            $property_size          =   get_post_meta($post->ID, 'property_size', true) ;
            if($property_size){
                $property_size=number_format(intval($property_size));
            }
            
            
            $agent_id           =   wpsestate_get_author($post->ID);
            $agent_id           =   get_user_meta($agent_id, 'user_agent_id', true);
            $thumb_id_agent     =   get_post_thumbnail_id($agent_id);
            $preview_agent      =   wp_get_attachment_image_src($thumb_id_agent, 'wpestate_user_thumb');
            $preview_agent_img  =   $preview_agent[0];
            
            if($preview_agent_img==''){
            $preview_agent_img    =   get_template_directory_uri().'/img/default_user_small.png';
            }
            
            $agent_link         =   esc_url(get_permalink($agent_id));
            $measure_sys        =   esc_html ( get_option('wp_estate_measure_sys','') ); 
            
            $price              =   intval( get_post_meta($post->ID, 'property_price', true) );
            $guests             =   intval( get_post_meta($post->ID, 'guest_no', true) );
            $property_city      =   get_the_term_list($post->ID, 'property_city', '', ', ', '') ;
            $property_area      =   get_the_term_list($post->ID, 'property_area', '', ', ', '');
            $property_action    =   get_the_term_list($post->ID, 'property_action_category', '', ', ', '');   
            $property_categ     =   get_the_term_list($post->ID, 'property_category', '', ', ', '');   
            ?>
        
          
            <div class="listing-unit-img-wrapper">
                <?php
              
                if(  $property_unit_slider=='yes'){
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
                
           
                }else{ ?>
                    <div class="cross"></div>
                    <a href="<?php echo $link; ?>"><?php echo $thumb_prop; ?></a> 
                <?php }?>
            </div>
          
                 
            <?php        
            if($featured==1){
                print '<div class="featured_div">'.esc_html__( 'featured','wpestate').'</div>';
            }
            
            if($property_status!='normal' && $property_status!=''){
                $property_status = apply_filters( 'wpml_translate_single_string', $property_status, 'wpestate', 'property_status_'.$property_status );
                $property_status_class=  str_replace(' ', '-', $property_status);
                print '<div class=" property_status status_'.$property_status_class.'">'.$property_status.'</div>';
            }
            ?>
          
            <div class="title-container">
                <div class="property_ratings">
                    <?php 
                    $args = array(
                        'number' => '15',
                        'post_id' => $post->ID, // use post_id, not post_ID
                    );
                    $comments   =   get_comments($args);
                    $coments_no =   0;
                    $stars_total=   0;

                    foreach($comments as $comment) :
                        $coments_no++;
                        $rating= get_comment_meta( $comment->comment_ID , 'review_stars', true );
                        $stars_total+=$rating;
                    endforeach;

                    if($stars_total!= 0 && $coments_no!=0){
                        $list_rating= ceil($stars_total/$coments_no);
                        $counter=0; 
                        while($counter<5){
                            $counter++;
                            if( $counter<=$list_rating ){
                                print '<i class="fa fa-star"></i>';
                            }else{
                                print '<i class="fa fa-star-o"></i>'; 
                            }

                        }
                    }  
                    ?>         
                </div>
                <div class="category_name">
                    <div class="price_unit_wrapper">
                        <div class="price_discount_unit">
                            <?php the_field('price_before_discount'); ?>
                        </div>
                        <div class="price_unit">
                            <?php  
                                wpestate_show_price($post->ID,$currency,$where_currency,0);
                                if($is_widget==1){
                                    echo '<span class="pernight">'.esc_html__( 'per night','wpestate').'</span>';
                                }
                            ?>
                        </div> 
                    </div>
                    <a href="<?php echo $link;?>" class="listing_title_unit">
                        <?php 
                            echo mb_substr ( html_entity_decode ($title), 0, 40, "UTF8") ; 
                            if(strlen($title)>40){
                                echo '...';   
                            }
                        ?>
                    </a>
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
            </div>
            
        
        <?php 
 
        if ( isset($show_remove_fav) && $show_remove_fav==1 ) {
            print '<span class="icon-fav icon-fav-on-remove" data-postid="'.$post->ID.'"> '.$fav_mes.'</span>';
        }
        ?>

        </div>          
    </div>