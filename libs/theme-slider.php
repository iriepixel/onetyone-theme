<?php

if( !function_exists('wpestate_theme_slider') ):

function  wpestate_theme_slider(){
    $theme_slider   =   get_option( 'wp_estate_theme_slider', true); 
    $slider_cycle   =   get_option( 'wp_estate_slider_cycle', true); 
    
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Select Properties ','wpestate').'</div>
        <div class="option_row_explain">'.__('Select properties for slider - *hold CTRL for multiple select ','wpestate').'</div>'; 
    $args = array(      'post_type'         =>  'estate_property',
                        'post_status'       =>  'publish',
                        'paged'             =>  0,
                        'posts_per_page'    =>  -1 
                 );

        $recent_posts = new WP_Query($args);
        print '<select name="theme_slider[]"  id="theme_slider"  multiple="multiple">';
        while ($recent_posts->have_posts()): $recent_posts->the_post();
             $theid=get_the_ID();
             print '<option value="'.$theid.'" ';
             if( is_array($theme_slider) && in_array($theid, $theme_slider) ){
                 print ' selected="selected" ';
             }
             print'>'.get_the_title().'</option>';
        endwhile;
        print '</select>';
        
    print '</div>';    
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Number of milisecons before auto cycling an item','wpestate').'</div>
        <div class="option_row_explain">'.__('Number of milisecons before auto cycling an item (5000=5sec).Put 0 if you don\'t want to autoslide. ','wpestate').'</div>    
            <input  type="text" id="slider_cycle" name="slider_cycle"  value="'.$slider_cycle.'"/> 
        </div>';
        
    print ' <div class="estate_option_row_submit">
        <input type="submit" name="submit"  class="new_admin_submit " value="'.__('Save Changes','wpestate').'" />
        </div>';
     
}

endif; // end wpestate_theme_slider






if( !function_exists('wpestate_present_theme_slider') ):
    function wpestate_present_theme_slider(){
        $attr=array(
            'class'	=>'img-responsive'
        );

        $theme_slider   =   get_option( 'wp_estate_theme_slider', ''); 

        if(empty($theme_slider)){
            return; // no listings in slider - just return
        }
        $currency       =   esc_html( get_option('wp_estate_currency_label_main', '') );
        $where_currency =   esc_html( get_option('wp_estate_where_currency_symbol', '') );

        $counter    =   0;
        $slides     =   '';
        $indicators =   '';
        $args = array(  
                    'post_type'        => 'estate_property',
                    'post_status'      => 'publish',
                    'post__in'         => $theme_slider,
                    'posts_per_page' => -1
                  );


        $recent_posts = new WP_Query($args);
        $slider_cycle   =   get_option( 'wp_estate_slider_cycle', true); 
        if($slider_cycle == 0){
            $slider_cycle = false;
        }
        
        $extended_search    =   get_option('wp_estate_show_adv_search_extended','');
        $extended_class     =   '';

        if ( $extended_search =='yes' ){
            $extended_class='theme_slider_extended';
        }

        $search_type        =   get_option('wp_estate_adv_search_type','');
        $theme_slider_class =   '';
        if($search_type != 'oldtype'){ 
            $theme_slider_class = 'theme_slider_wrapper_type2';
        }
        
        print '<div class="theme_slider_wrapper '.$theme_slider_class.' '.$extended_class.' carousel  slide" data-ride="carousel" data-interval="'.$slider_cycle.'" id="estate-carousel">';

        while ($recent_posts->have_posts()): $recent_posts->the_post();
            $theid=get_the_ID();
            $slide= get_the_post_thumbnail( $theid, 'wpestate_property_full_map',$attr );

            if($counter==0){
                $active=" active ";
            }else{
                $active=" ";
            }
            
            $measure_sys    =   get_option('wp_estate_measure_sys','');
            $beds           =   intval( get_post_meta($theid, 'property_bedrooms', true) );
            $baths          =   intval( get_post_meta($theid, 'property_bathrooms', true) );
            $size           =   number_format ( intval( get_post_meta($theid, 'property_size', true) ) );

            if($measure_sys=='ft'){
                $size.=' '.esc_html__( 'ft','wpestate').'<sup>2</sup>';
            }else{
                $size.=' '.esc_html__( 'm','wpestate').'<sup>2</sup>';
            }

    


            $slides.= '
            <div class="item '.$active.'">
               
                <div class="slider-content-wrapper">  
                    <div class="slider-content">
                        <div class="slider-title">
                            <h2><a href="'.esc_url ( get_permalink() ).'">'.get_the_title().'</a> </h2>
                        </div>
                    </div> 
                </div>  
                
                <div class="slider-content-cover"></div>  
                
                <a href="'.esc_url ( get_permalink() ).'"> '.$slide.'</a>

            </div>';

            $indicators.= '
            <li data-target="#estate-carousel" data-slide-to="'.($counter).'" class="'. $active.'">
            </li>';

            $counter++;
        endwhile;
        wp_reset_query();
        print ' 
            <div class="carousel-inner">
              '.$slides.'
            </div>

            <ol class="carousel-indicators">
                '.$indicators.'
            </ol>

                <a id="carousel-control-theme-next"  class="carousel-control-theme-next" href="#estate-carousel" data-slide="next"><i class="fa fa-angle-right"></i></a>
                <a id="carousel-control-theme-prev"  class="carousel-control-theme-prev" href="#estate-carousel" data-slide="prev"><i class="fa fa-angle-left"></i></a>
            </div>';
    } 
endif;

?>
