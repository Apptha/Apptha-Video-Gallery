<?php
/**
 * Wordpress Video Gallery Video Category Widget.
 *  
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */

/**
 * This class is used to display category list
 * 
 * @author user
 */
class Widget_ContusVideoCategory_init extends WP_Widget {      
    /**
     * This function is used to initialize Category widget
     */
    function __construct() {
        /** Store category widget class name, description in an array */
        $widgetOpts = array ( 'classname' => 'Widget_ContusVideoCategory_init ', 'description' => 'Contus Video Categories' );
        $this->WP_Widget ( 'Widget_ContusVideoCategory_init', 'Contus Video Category', $widgetOpts );
    }
    
    /**
     * This function is used to create backend widget option
     * 
     * @param unknown $instance
     */
    function form($instance) {
        /** These are our own options */
        $instanceCat = wp_parse_args ( ( array ) $instance, array ( 'title' => 'Video Categories', 'show' => '3' ) );
        /** Set Categories widget title */
        $title  = esc_attr ( $instanceCat ['title'] );
        /** Set default category limit */
        $show   = isset ( $instanceCat ['show'] ) ? absint ( $instanceCat ['show'] ) : 3;
        /** Display category widget title
         * Add input fields to get category limit to display in front end */
        ?>
        <p><label for='<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>'>Title: 
                <input id='<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>' 
                class='widefat' name='<?php echo esc_html( $this->get_field_name( 'title' ) ); ?>' type='text' 
                value='<?php echo esc_html( $title ); ?>' /> 
            </label> </p>
        <p><label for='<?php echo esc_html( $this->get_field_id( 'show' ) ); ?>'>Show: 
                <input id='<?php echo esc_html( $this->get_field_id( 'show' ) ); ?>' 
                class='widefat' name='<?php echo esc_html( $this->get_field_name( 'show' ) ); ?>' type='text' 
                value='<?php echo esc_html( $show ); ?>' /> 
            </label> </p>
    <?php
    }
    
    /**
     * Function to update widget
     * 
     * @param unknown $new_instance
     * @param unknown $old_instance
     * @return number
     */
    function update($new_instance, $old_instance) {
        $instanceCat           = $old_instance;
        $instanceCat ['title'] = $new_instance ['title'];
        $instanceCat ['show']  = ( int ) $new_instance ['show'];
        return $instanceCat;
    }
    
    /**
     * Fucntion to display the catgoery list as a link
     * 
     * @param unknown $args
     * @param unknown $instance
     */
    function widget($args, $instanceCat) {
        /** Set default limit as 3 */
        $show   = 3;
        /** Get catgoery widget title */
        $title  = empty ( $instanceCat ['title'] ) ? ' ' : apply_filters ( 'widget_title', $instanceCat ['title'] );
        /** Catgoery Widget code starts here */ 
        global $wpdb;
        /** These are our own options
         * Get "number of playlist" from backend option */ 
        if ($instanceCat ['show'] && absint ( $instanceCat ['show'] )) {
            $show = $instanceCat ['show'];
        }
        /** Get playlist from db  */        
        $features         = getPlaylist (' playlist_order ASC ' , $show) ; 
        /** Count selected playlist */       
        $countCategories  = getPlaylistCount ();
        /** Call function to get more page id  */
        $moreName         = morePageID();
        /** Get more categories link from helper */
        $more_videos_link = get_morepage_permalink ( $moreName, 'categories' );
        /** Before widget functions category */
        echo $args['before_widget'];
        /** Set category widget output */
        $div  = '';
        $div .= '<div id="videos-category"  class="widget widget_categories sidebar-wrap "> <h3 class="widget-title"><a href="' . $more_videos_link . '">' . $title . '</a></h3>
                    <ul class="ulwidget clearfix">';      
        /** Check if playlist is exist */
        if (! empty ( $features )) {
            /** If found, loop through them */ 
            foreach ( $features as $feature ) {
                /** Get playlist name */
                $fetched            = $feature->playlist_name;
                /** Get playlist seo name */
                $playlist_slugname  = $feature->playlist_slugname;
                /** Get playlist id */
                $playlist_id        = $feature->pid;
                /** Get playlist page url */
                $playlist_url       = get_playlist_permalink ( $moreName, $playlist_id, $playlist_slugname );
                /** Display playlist name */
                $div                .= '<li>';
                $div                .= '<a class="videoHname "  href="' . $playlist_url . '">' . $fetched . '</a>';
                $div                .= '</li>';
            }
        } else {
            /** If no data, then display no categories message */
            $div  .= '<li>' . __ ( 'No Categories', APPTHA_VGALLERY ) . '</li>';
        }
        /** End category list */ 
        if (($show < $countCategories)) {
            $div  .= '<li><div class="right video-more"><a href="' . $more_videos_link . '">' . __ ( 'More Categories', APPTHA_VGALLERY ) . ' &#187;</a></div></li>';
        }
        $div    .= '</ul></div>';
        /** Display category widget */
        echo $div;
        /** Display widget closing tag */
        /** After widget functions category */
        echo $args['after_widget'];
    }
}
/** Call function to register category widget */
add_action ( 'widgets_init', create_function ( '', 'return register_widget("Widget_ContusVideoCategory_init" );' ) ); 
?>