<?php
global $post;
global $property_action_terms_icon;
global $property_action;
global $property_category_terms_icon;
global $property_category;
global $guests;
global $bedrooms;
global $bathrooms;
global $favorite_text;
global $favorite_class;
global $options;
$currency           =   esc_html( get_option('wp_estate_currency_label_main', '') );
$where_currency     =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
$price              =   intval   ( get_post_meta($post->ID, 'property_price', true) );
$price_label        =   esc_html ( get_post_meta($post->ID, 'property_label', true) );  
$property_city      =   get_the_term_list($post->ID, 'property_city', '', ', ', '') ;
$property_area      =   get_the_term_list($post->ID, 'property_area', '', ', ', '');
?>-->
<div class="property-top">
    
    <h1 class="property-top__title">
        <div class="property-top__ratings property_ratings">
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
        <?php the_title(); ?>
    </h1>

    <div class="property-top__location">
        <?php print  $property_city.', '.$property_area; ?>        
    </div>    

    <div class="property-top__price">
        <?php if( get_field('text_field') ): ?>
            <div class="price_discount_property">
                <?php the_field('price_before_discount'); ?>
            </div>
        <?php endif; ?>
        <?php  
            
            $price_per_guest_from_one       =   floatval( get_post_meta($post->ID, 'price_per_guest_from_one', true) ); 

            $price          = floatval( get_post_meta($post->ID, 'property_price', true) );
            wpestate_show_price($post->ID,$currency,$where_currency,0); 
            if($price!=0){
                if( $price_per_guest_from_one == 1){
                    echo ' '.esc_html__( 'per guest','wpestate'); 
                }else{
                    echo ' <div class="property-top__price--small">'.esc_html__( 'per night from','wpestate').'</div>'; 
                }
            }
          
        ?>
    </div>

    <div class="category_wrapper ">
        <div class="category_details_wrapper">
            <?php  if( $property_category!='') {
                echo $property_category;?> <span class="property_header_separator">|</span> 
            <?php } ?> 
            <?php print '<span class="no_link_details">'.$guests.' '. esc_html__( 'Guests','wpestate').'</span>';?> <span class="property_header_separator">|</span>
            <?php 
            if(strpos($property_category, 'studio') === false){
                print '<span class="no_link_details">'.$bedrooms.' '.esc_html__( 'Bedrooms','wpestate').'</span><span class="property_header_separator">|</span>';
            }
            ?>
            <?php print '<span class="no_link_details">'.$bathrooms.' '.esc_html__( 'Baths','wpestate').'</span>';?>
        </div>
    </div>
</div>

<div class="property_header property_header2">
        <div class="property_categs ">
            
            <div class="property_header_wrapper 
                <?php 
                if ( $options['content_class']=='col-md-12' || $options['content_class']=='none'){
                    print 'col-md-8';
                }else{
                   print  $options['content_class']; 
                }?> 
            ">
              
                
                <div id="listing_description">
                <?php
                    $content = get_the_content();
                    $content = apply_filters('the_content', $content);
                    $content = str_replace(']]>', ']]&gt;', $content);
                    $property_description_text =  get_option('wp_estate_property_description_text');
                    if (function_exists('icl_translate') ){
                        $property_description_text     =   icl_translate('wpestate','wp_estate_property_description_text', esc_html( get_option('wp_estate_property_description_text') ) );
                    }
                    
                    if($content!=''){   
                        print '<h4 class="panel-title-description">'.$property_description_text.'</h4>';
                        print '<div class="panel-body">'.$content.'</div>';       
                    }
                ?>
                </div>
                
            
        </div>
    <?php  
        $post_id=$post->ID; 
        $guest_no_prop ='';
        if(isset($_GET['guest_no_prop'])){
            $guest_no_prop = intval($_GET['guest_no_prop']);
        }
        $guest_list= wpestate_get_guest_dropdown('noany');
    ?>
    
    <div class="booking_form_request  
        <?php
        if($options['sidebar_class']=='' || $options['sidebar_class']=='none' ){
            print ' col-md-4 '; 
        }else{
            print $options['sidebar_class'];
        }
        ?>
         " id="booking_form_request">
        <div id="booking_form_request_mess"></div>
            <h3 ><?php esc_html_e('Request to Book','wpestate');?></h3>
                <div>
                    <div class="has_calendar calendar_icon">
                        <input type="text" id="start_date" placeholder="<?php esc_html_e('Check in','wpestate'); ?>"  class="form-control calendar_icon" size="40" name="start_date" 
                                value="<?php if( isset($_GET['check_in_prop']) ){
                                   echo sanitize_text_field ( $_GET['check_in_prop'] );
                                }
                                ?>">
                    </div>

                    <div class=" has_calendar calendar_icon">
                        <input type="text" id="end_date" disabled placeholder="<?php esc_html_e('Check Out','wpestate'); ?>" class="form-control calendar_icon" size="40" name="end_date" 
                                value="<?php if( isset($_GET['check_out_prop']) ){
                                   echo sanitize_text_field ( $_GET['check_out_prop'] );
                                }
                                ?>">
                    </div>

                    <div class=" has_calendar guest_icon ">
                        <?php 
                        $max_guest = get_post_meta($post_id,'guest_no',true);
                        print '
                        <div class="dropdown form-control">
                            <div data-toggle="dropdown" id="booking_guest_no_wrapper" class="filter_menu_trigger" data-value="';
                                if(isset($_GET['guest_no_prop']) && $_GET['guest_no_prop']!=''){
                                    echo esc_html( $_GET['guest_no_prop'] );
                                }else{
                                  echo 'all';
                                }
                            print '">';
                            
                            if(isset($_GET['guest_no_prop']) && $_GET['guest_no_prop']!=''){
                                echo esc_html( $_GET['guest_no_prop'] ).' '.esc_html__( 'guests','wpestate');
                            }else{
                                esc_html_e('Guests','wpestate');
                            }
                     
                            
                            print '<span class="caret caret_filter"></span>
                            </div>           
                            <input type="hidden" name="booking_guest_no"  value="">
                            <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="booking_guest_no_wrapper">
                                '.$guest_list.'
                            </ul>        
                        </div>';
                        ?> 
                    </div>
                

                    <p class="full_form " id="add_costs_here"></p>            

                    <input type="hidden" id="listing_edit" name="listing_edit" value="<?php echo $post_id;?>" />

                    <div class="submit_booking_front_wrapper">
                        <?php   
                        $overload_guest                 =   floatval   ( get_post_meta($post_id, 'overload_guest', true) );
                        $price_per_guest_from_one       =   floatval   ( get_post_meta($post_id, 'price_per_guest_from_one', true) );
                        ?>
                        
                         <?php  $instant_booking                 =   floatval   ( get_post_meta($post_id, 'instant_booking', true) ); 
                        if($instant_booking ==1){ ?>
                            <div id="submit_booking_front_instant_wrap"><input type="submit" id="submit_booking_front_instant" data-maxguest="<?php echo $max_guest; ?>" data-overload="<?php echo $overload_guest;?>" data-guestfromone="<?php echo $price_per_guest_from_one; ?>"  class="wpb_btn-info wpb_btn-small wpestate_vc_button  vc_button" value=" <?php esc_html_e('Instant Booking','wpestate');?>" /></div>
                        <?php }else{?>   
                            <input type="submit" id="submit_booking_front" data-maxguest="<?php echo $max_guest; ?>" data-overload="<?php echo $overload_guest;?>" data-guestfromone="<?php echo $price_per_guest_from_one; ?>"  class="wpb_btn-info wpb_btn-small wpestate_vc_button  vc_button" value="<?php esc_html_e('Request to Book','wpestate');?>" />
                        <?php }?>
                            
                        <?php wp_nonce_field( 'booking_ajax_nonce', 'security-register-booking_front' );?>
                    </div>
                </div>

                <div class="third-form-wrapper">
                    <div class="col-md-6 reservation_buttons">
                        <div id="add_favorites" class=" <?php print $favorite_class;?>" data-postid="<?php the_ID();?>">
                            <?php echo $favorite_text;?>
                        </div>                 
                    </div>

                    <div class="col-md-6 reservation_buttons">
                        <div id="enquiry_form_trigger" class="col-md-6"  data-postid="<?php the_ID();?>">
                            <?php esc_html_e('Enquire','wpestate');?>
                        </div>  
                    </div>
                </div>

                <div class="enquiry-form">
                    <div class="u-border-top">
                        <?php echo do_shortcode( '[contact-form-7 id="2470" title="Enquiry"]' );   ?>
                    </div>
                </div>
                
                <?php 
                if (has_post_thumbnail()){
                    $pinterest = wp_get_attachment_image_src(get_post_thumbnail_id(),'wpestate_property_full_map');
                }
                ?>

                <div class="prop_social">
                    <span class="prop_social_share"><?php esc_html_e('Share','wpestate');?></span>
                    <a href="http://www.facebook.com/sharer.php?u=<?php echo esc_url(get_permalink()); ?>&amp;t=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share_facebook"><i class="fa fa-facebook fa-2"></i></a>
                    <a href="http://twitter.com/home?status=<?php echo urlencode(get_the_title() .' '.esc_url( get_permalink()) ); ?>" class="share_tweet" target="_blank"><i class="fa fa-twitter fa-2"></i></a>
                    <a href="https://plus.google.com/share?url=<?php echo esc_url(get_permalink()); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank" class="share_google"><i class="fa fa-google-plus fa-2"></i></a> 
                    <?php if (isset($pinterest[0])){ ?>
                        <a href="http://pinterest.com/pin/create/button/?url=<?php echo esc_url(get_permalink()); ?>&amp;media=<?php echo $pinterest[0];?>&amp;description=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share_pinterest"> <i class="fa fa-pinterest fa-2"></i> </a>      
                    <?php } ?>           
                </div>             

        </div>
    
    
    
    
     </div>
</div>