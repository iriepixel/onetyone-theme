</div><!-- end content_wrapper started in header or full_width_row from prop list -->

<?php 

$footer_background          =   get_option('wp_estate_footer_background','');
$repeat_footer_back_status  =   get_option('wp_estate_repeat_footer_back','');
$footer_style               =   '';
$footer_back_class          =   '';
$wide_footer        =   get_option('wp_estate_wide_footer','');

if ($footer_background!=''){
    $footer_style='style=" background-image: url('.$footer_background.') "';
}

if( $repeat_footer_back_status=='repeat' ){
    $footer_back_class = ' footer_back_repeat ';
}else if( $repeat_footer_back_status=='repeat x' ){
    $footer_back_class = ' footer_back_repeat_x ';
}else if( $repeat_footer_back_status=='repeat y' ){
    $footer_back_class = ' footer_back_repeat_y ';
}else if( $repeat_footer_back_status=='no repeat' ){
    $footer_back_class = ' footer_back_repeat_no ';
}
 

if( !is_search() && !is_category() && !is_tax() &&  !is_tag() &&  !is_archive() && wpestate_check_if_admin_page($post->ID) ){
    // do nothing for now  
  
} else if(!is_search() && !is_category() && !is_tax() &&  !is_tag() &&  !is_archive() && basename(get_page_template($post->ID)) == 'property_list_half.php'){
    // do nothing for now   
  
} else if( ( is_category() || is_tax() ) &&  get_option('wp_estate_property_list_type','')==2){
    // do nothing for now
  
} else if(  is_page_template('advanced_search_results.php') &&  get_option('wp_estate_property_list_type_adv','')==2){
    // do nothing for now
 
}else{  
?>

<footer id="colophon" <?php echo $footer_style; ?> class=" <?php echo $footer_back_class;?> ">    
    <?php 
        $wide_footer_class='';
        if($wide_footer=='yes'){
            $wide_footer_class=" wide_footer ";
        }
    ?>
    
    <?php  if(is_page(2081) || is_page(254)) {?>
        <div id="google-map"></div>
    <?php } ?>
    
    <div id="footer-widget-area" class="row <?php echo $wide_footer_class;?>">
        <div class="col-md-12">
            <?php echo do_shortcode( '[mc4wp_form id="2201"]' ); ?>
        </div>
        <div id="first" class="widget-area col-md-3">
            <div class="xoxo">
                <div class="footer-logo">
                    <img class="footer-logo__image" src="/wp-content/themes/onetyone/images/logo-footer.svg" alt="footer logo" >
                </div>
            </div>
        </div>
        <?php  get_sidebar('footer');?>
    </div><!-- #footer-widget-area -->

    <div class="sub_footer">  
        <div class="sub_footer_content <?php echo $wide_footer_class;?>">
            <span class="copyright">
                <?php      
                if (function_exists('icl_translate') ){
                    print $property_copy_text      =   icl_translate('wpestate','wp_estate_property_copyright_text', stripslashes ( esc_html( get_option('wp_estate_copyright_message') ) ) );
                }else{
                    print stripslashes ( esc_html (get_option('wp_estate_copyright_message', '') ) );
                }
                echo " | Crafted by <a href='https://iriepixel.com' target='_blank'>IRIE PIXEL</a>"?>
            </span>
        </div>  
    </div>
</footer><!-- #colophon -->

<?php } // end property_list_half?>
<?php get_template_part('templates/footer_buttons');?>
<?php wp_get_schedules(); ?>
<?php wp_footer();  ?>

<?php
    $ga = esc_html(get_option('wp_estate_google_analytics_code', ''));
    if ($ga != '') {  ?>

        <script>
            //<![CDATA[
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', '<?php echo $ga; ?>', '<?php     echo $_SERVER['SERVER_NAME']; ?>');
          ga('send', 'pageview');
        //]]>
        </script>
<?php
    }
?>

</div> <!-- end class container -->

<?php get_template_part('templates/social_share');?>

</div> <!-- end website wrapper -->

</body>
</html>