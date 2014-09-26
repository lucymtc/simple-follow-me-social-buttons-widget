<?php
/** 
 * @package    SFMSB
 * @author     Lucy Tomás
 * @since 	   1.0
 */
 
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'Sfmsb_Widget' )){
 
class Sfmsb_Widget extends WP_Widget {


	/**
	 * Constructor. 
	 * 
	 * @since 1.0
	 */
		
	function __construct() {
		
			$this->defaults = array(
				'title'    => __('Social', 'sfmsb_domain'),
				'size'     => '20',
				'position' => 'under',
				'text'     => __('Follow me on:', 'sfmsb_domain'),
				'color'    => '',
				'style'    => 'circle'
			);
			
			
			foreach ( SFMSB::instance()->available_buttons as $key => $item ) {
					
				$this->defaults['enable_' . $key] = 0;
				$this->defaults['url_' . $key] 	  = '';
			}
			
		
			$widget_ops = array(
				'classname'   => 'sfmsb_widget',
				'description' => __( 'Adds "follow me" social buttons', 'sfmsb_domain' )
			);
			
			$this->available_buttons = SFMSB::instance()->available_buttons;
			
			
			parent::__construct( 'sfmsb_settings', __( 'Simple follow me social buttons', 'sfmsb_domain' ), $widget_ops );
			 
			 
			//** this is not in add_admin_scripts because it would break after widget save, need to be in the construct.
			wp_register_script( 'sfmsb-admin-widget-script', SFMSB_PLUGIN_URL . 'assets/js/widget.js', array('jquery', 'wp-color-picker'), SFMSB_PLUGIN_VERSION );
		 	add_action( 'admin_print_scripts-widgets.php', array('Sfmsb_Widget', 'admin_widget_scripts') );
	}
	
	/**
	 * Form 
	 * 
	 * @param $instance
	 * @since 1.0
	 */
		
		
	function form( $instance ) {
		
			$instance = wp_parse_args( (array) $instance, $this->defaults );
			
			?>
			
			<!-- *** TITLE text ***-->
			
			<p> 
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 'sfmsb_domain'); ?></label>
				
				<input class="widefat" 
					   name="<?php echo $this->get_field_name( 'title' ); ?>" 
					   type="text" 
					   value="<?php echo esc_attr( $instance['title'] ); ?>" /> 
			</p>
			
			<!-- *** TEXT extra ***-->
			
			<p> 
				<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e('Text', 'sfmsb_domain'); ?></label>
				
				<input class="widefat" 
					   name="<?php echo $this->get_field_name( 'text' ); ?>" 
					   type="text" 
					   value="<?php echo esc_attr( $instance['text'] ); ?>" /> 
			</p>
			
			<!-- *** ENABLE checkbox & URL text ***-->
			<?php 
				
				//** patch to add a black bg to buttons if color of icons is white
				$class = '';

				if( $instance['color'] == '#ffffff' || 
					$instance['color'] == '#fff' || 
					$instance['color'] == 'white' ) {
					
					$class = " dark";
				}
				
			?>
			<div class="sfmsb-icons-container<?php echo $class ?>">
			
			<?php
			
				foreach ( $this->available_buttons as $key => $item ) { 
			
					( $instance['color'] == '') ? $color = '#' . $item['color'] : $color = $instance['color'];
					
					
					if( $key == 'email' ) {

							$label = __( 'Your Email address or other contact URL', 'sfmsb_domain');	
							
							$instance['url_' . $key] = str_replace('mailto:', '', $instance['url_' . $key]);
							
							if( filter_var( $instance['url_' . $key], FILTER_VALIDATE_EMAIL ) ){
									
								$value = esc_attr( $instance['url_' . $key] );	
							} else {
							
								$value = esc_url( $instance['url_' . $key] );
							} // if
							
							
						} else {
								
							$label = __( $item['name'] . ' URL', 'sfmsb_domain');
							$value = esc_url( $instance['url_' . $key] );
						}
			?>
			
					<a href="javascript:void(0);" <?php echo ( $value == '' ) ? 'class="sfmsb-disable"' : 'class="sfmsb-enable"'; ?>>
						<span class="sfmsb-icon-<?php echo $key .' '. $instance['style'] ?>" style="color: <?php echo $color ?>"></span>
					</a>
					
					<div class="sfmsb-input-block sfmsb-<?php echo $key ?>">
						
						<label for="<?php echo $this->get_field_id( 'url_' . $key ); ?>"><?php echo $label; ?></label>
					
						<input id="<?php echo $this->get_field_id( 'url_' . $key ) ?>"
							   class="widefat"	 
							   name="<?php echo $this->get_field_name( 'url_' . $key );  ?>" 
					    	   type="text" 
					    	   class=""
							   value="<?php echo $value ?>"/>
					</div>
			
			<?php } // foreach ?>
				<div class="clearfix"></div>
				
				<div class="sfmsb-initial-message">
						<?php _e('Click on any icon to input the url and enable it. Leave the input blank to disable the icon.', 'sfmsb_domain');?>
				</div>
					
			</div>
			
			<!-- *** STYLE select ***-->
				<p>
					<label for="<?php echo $this->get_field_id( 'style' ); ?>"><b><?php _e('Style', 'sfmsb_domain'); ?></b></label>	
							<select id="<?php echo $this->get_field_id( 'style' ); ?>" name="<?php echo $this->get_field_name( 'style' ); ?>">
								<option value="circle" <?php selected($instance[ 'style' ], 'circle') ?>><?php _e('Rounded', 'sfmsb_domain') ?></option>
								<option value="square" <?php selected($instance[ 'style' ], 'square') ?>><?php _e('Squared', 'sfmsb_domain') ?></option>
							</select>
				</p>
				 
       			 <p>
           			 <label for="<?php echo $this->get_field_id( 'color' ); ?>"><b><?php _e( 'Color', 'sfmsb_domain' ); ?></b></label>
            		 <input class="sfmsb-color-picker" type="text" id="<?php echo $this->get_field_id( 'color' ); ?>" name="<?php echo $this->get_field_name( 'color' ); ?>" value="<?php echo esc_attr( $instance['color'] ); ?>" />                            
        		</p>
				
				<!-- *** SIZES radios ***-->
				<p>
					<label for="<?php echo $this->get_field_id( 'size' ); ?>"><b><?php _e('Size', 'sfmsb_domain'); ?></b></label>&nbsp;&nbsp;&nbsp;
							
					<input class="s"
					   	   name="<?php echo $this->get_field_name( 'size' ); ?>" 
					   	   type="text" 
					   	   value="<?php echo esc_attr( $instance['size'] ); ?>" /> px
							
				</p>
				
				<!-- *** POSITIONS radios ***-->
				<p>
					<label for="<?php echo $this->get_field_id( 'position' ); ?>"><b><?php _e('Position', 'sfmsb_domain'); ?></b></label>	
					<br/>
							
								
					<input id="<?php echo $this->get_field_id( 'position' ); ?>" 
					       name="<?php echo $this->get_field_name( 'position' ); ?>" 
						   type="radio" 
						   value="under" <?php checked('under', $instance['position']) ?> />
								   
					<label><?php _e('Icons under text', 'sfmsb_domain'); ?></label>&nbsp;
						
						<input id="<?php echo $this->get_field_id( 'position' ); ?>" 
							   name="<?php echo $this->get_field_name( 'position' ); ?>" 
							   type="radio" 
							   value="float" <?php checked('float', $instance['position']) ?> />
								   
					<label><?php _e('Icons next to text', 'sfmsb_domain'); ?></label>
						
				</p>
				
				<script>
					
					jQuery('#widgets-right').on('click','.icon_buttons input',function(){
     					openPanel(jQuery(this),jQuery(this).index());
					});
				</script>
			
			<?
		
		}

	/**
	 * Update 
	 * 
	 * @param  $new_instance new values
	 * @param  $old_instance old values
	 * @return $instance values to save or false if hasn't been saved
	 * @since  1.0
	 */
		
	function update($new_instance, $old_instance) {
			
			$instance = $old_instance;
			
			$instance['title'] = $new_instance['title'];
			$instance['text']  = $new_instance['text'];
			
			foreach( $this->available_buttons as $key => $item ){
					
				if( $key == 'email' ) {
						
					$new_instance['url_' . $key] = str_replace('mailto:', '', $new_instance['url_' . $key]);
					
					if( filter_var( $new_instance['url_' . $key], FILTER_VALIDATE_EMAIL ) ){
						
						$value = esc_attr( $new_instance['url_' . $key] );
					} else {
						
						$value = esc_url( $new_instance['url_' . $key] );
					} // if

				} else {
					
					$value = esc_url( $new_instance['url_' . $key] );
				}
					
				$instance['url_' . $key] 	 = $value;
				$instance['enable_' . $key]  = absint($new_instance['enable_' . $key]);
				
			} 
			
			$instance['size']     = absint(esc_attr($new_instance['size']));
			$instance['position'] = esc_attr($new_instance['position']);
			$instance['style']    = esc_attr($new_instance['style']);
			$instance['color'] 	  = esc_attr($new_instance['color']);
			
			return $instance;
	}
		
	/**
	 * widget
	 *
	 * @param array $args Arguments
	 * @param array $instance Settings for the widget
	 */	
		
	 function widget($args, $instance) {
			
			extract( $args );
		
			$instance = wp_parse_args( (array) $instance, $this->defaults );
			
			echo $before_widget;
			
			$title = apply_filters( 'widget_title', $instance['title']);
			
				// ** do_action
				do_action('sfmsb_widget_pre_buttons');
		
				echo '<div class="sfmsb-follow-social-buttons sfmsb-' . $instance['position'] . ' sfmsb-' . $instance['style'] . ' ' . $instance['size'] . '">';
				
				if ( !empty( $title ) ) { echo $before_title . $title  . $after_title; };
				
				switch( TRUE ) {
						
					case $instance['size'] <= 25	:
						$text_size = 14;
					break;	
						
					case $instance['size'] > 25 && $instance['size'] < 35 :
						$text_size = $instance['size'] / 2 + 3;
					break;	
					
					case $instance['size'] >= 35 :
						$text_size = $instance['size'] / 2;
					break;	
				}
				
				if ( !empty( $instance['text'] ) ) {
					 echo '<span class="sfmsb-text" style="font-size:'. $text_size .'px;">' . $instance['text']  . '</span>'; 
				}
					
					// ** do_action
					do_action('sfmsb_widget_before_links');
					
					foreach ( SFMSB::instance()->available_buttons as $key => $item ) {
						
						if( isset( $instance['url_' . $key] ) &&  
							$instance['url_' . $key] != '' 
						  ) {
							
							// color (default or custom)
							( $instance['color'] == '') ? $color = '#' . $item['color'] : $color = $instance['color'];
							
							//url (default or email)
							if( $key == 'email' && 
								filter_var( $instance['url_' . $key], FILTER_VALIDATE_EMAIL ) 
							) {
								$href = 'mailto:' . esc_attr($instance['url_' . $key]);
							} else {
								$href = esc_url($instance['url_' . $key]);
							}
							
							echo '<a target="_blank" href="' . $href . '">';
								echo '<span class="sfmsb-icon-'. $key .' '. $instance['style'] .'" style="color:' . $color . ';font-size:'. $instance['size'] .'px;"></span>';
							echo '</a>';
						
						}// if enabled	
						
					} // foreach
					
					// ** do_action
					do_action('sfmsb_widget_after_links');
				
				echo '<div class="clearfix"></div></div>';
				
				// ** do_action
				do_action('sfmsb_widget_pos_buttons');
				
			echo $after_widget;
		}	
		
		
		
	/**
	 * register_widgets
	 * @since 1.0.0
	 */
	public static function register_widgets() {

		register_widget( 'Sfmsb_Widget' );
	}
	
	
	/**
	 * add_style
	 * @since 1.0.0
	 */
	public static function add_style() {

		wp_enqueue_style('sfmsb-style', SFMSB_PLUGIN_URL . 'assets/css/style.css', array(), SFMSB_PLUGIN_VERSION);
		wp_enqueue_style('sfmsb-icons', SFMSB_PLUGIN_URL . 'assets/css/icons.css', array(), SFMSB_PLUGIN_VERSION);

	}
	
	/**
	 * add_admin_scripts
	 * @since 1.0.0
	 */
	public static function add_admin_scripts() {
		 	
		 wp_enqueue_style( 'wp-color-picker' );        
	     wp_enqueue_style('sfmsb-admin-style', SFMSB_PLUGIN_URL . 'assets/css/admin.css', array(), SFMSB_PLUGIN_VERSION);
		 wp_enqueue_style('sfmsb-icons', SFMSB_PLUGIN_URL . 'assets/css/icons.css', array(), SFMSB_PLUGIN_VERSION);
			 
		  wp_enqueue_script( 'wp-color-picker' );
		
	}
	
	/**
	 * admin_widget_scripts
	 * @since 2.0
	 */
	
	public static function admin_widget_scripts(){

		wp_enqueue_script('sfmsb-admin-widget-script');
	}
	
	
}// class
}// if