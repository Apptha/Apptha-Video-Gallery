<?php
/**
 * Wordpress Video Gallery Video Search Widget.
 * 
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */

/**
 * This class is used to display the serach widget
 * 
 * @author user
 */
class Widget_ContusVideoSearch_init extends WP_Widget {    
    /**
     * Search widget init function
     */
    function __construct() {
        /** Array to store search widget class name, description */
        $widget_ops = array ( 'classname' => 'Widget_ContusVideoSearch_init ', 'description' => 'Search Videos Widget' );
        $this->WP_Widget ( 'Widget_ContusVideoSearch', 'Contus Video Search', $widget_ops );
    }
    
    /**
     * This function is used to create search widget  
     * 
     * @param   object   $instance
     */
    function form($instance) {
        /** Set title for search widget */
        $instance = wp_parse_args ( ( array ) $instance, array ('title' => 'Video Search' ) );
        $title    = esc_attr ( $instance ['title'] );        
        /** Create search widget option in admin */
        ?>
        <p>
          <label for='<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>'>Title: 
              <input class='widefat' id='<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>' type='text'  
              name='<?php echo esc_html( $this->get_field_name( 'title' ) ); ?>' 
              value='<?php echo esc_html( $title ); ?>' />
          </label>
        </p>
    <?php
    }
    
    /**
     * This function is used to update widget
     * 
     * @param unknown $new_instance
     * @param unknown $old_instance
     * @return unknown
     */
    function update($new_instance, $old_instance) {
        $instance           = $old_instance;
        $instance ['title'] = $new_instance ['title'];
        return $instance;
    }
    
    /**
     * This function is used to create search box for site
     * 
     * @param unknown $args
     * @param unknown $instance
     */
    function widget($args, $instance) {   
        $title      = empty ( $instance ['title'] ) ? ' ' : apply_filters ( 'widget_title', $instance ['title'] );     
        /** Call helper function to get more page id from db */
        $moreName   = morePageID();
        /** Search Widget starts and set title */
        /** Before widget functions search */
        echo $args['before_widget'];
        $searchVal  = __ ( 'Video Search &hellip;', APPTHA_VGALLERY );        
        /** Search form to search videos */
        $div = '<div id="videos-search"  class="widget_search sidebar-wrap search-form-container "><h3 class="widget-title">' . $title . '</h3>
            <form role="search" method="get" id="search-form" class="search-form searchform clearfix" action="' . home_url ( '/' ) . '" >
              <label class="screen-reader-text" >' . __ ( 'Search for:' ) . '</label>
              <input type="hidden" value="' . $moreName . '" name="page_id" id="page_id"  />
              <input type="text" class="s field search-field" placeholder="' . $searchVal . '" value="" name="video_search" id="s video_search"  />
              <input type="submit" class="search-submit submit" id="videosearchsubmit" value="' . __ ( 'Search', APPTHA_VGALLERY ) . '" />
          </form> </div>';
        /** Display search videos widget  */
        echo $div;
        /** Search videos widget ends */
        /** After widget functions search */
        echo $args['after_widget'];
    }
}
/** Register search widget */
add_action ( 'widgets_init', create_function ( '', 'return register_widget("Widget_ContusVideoSearch_init" );' ) ); 
?>