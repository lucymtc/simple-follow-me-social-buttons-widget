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
	 * Set the default widget options and create widget.
	 * 
	 * @since 1.0
	 */
		
	function __construct() {
		
			$this->defaults = array(
				'style'    => 'default',
				'title'    => __('Social', 'sfmsb_domain'),
				'size'     => 'L',
				'position' => 'under',
				'text'     => __('Follow me on:', 'sfmsb_domain')		
			);
			
			
			foreach ( SFMSB::instance()->available_buttons as $key => $item ) {
					
				$this->defaults['enable_' . $key] = 0;
				$this->defaults['url_' . $key] 	  = '';
			}
			
		
			$widget_ops = array(
				'classname' => 'sfmsb_widget',
				'description' => 'Display follow me social buttons'
			);
			
			
			$this->styles 		     = SFMSB::instance()->buttons_styles;
			$this->sizes  		     = SFMSB::instance()->buttons_sizes;
			$this->available_buttons = SFMSB::instance()->available_buttons;
			
			
			parent::__construct( 'sfmsb_settings', __( 'Simple follow me social buttons', 'sfmsb_domain' ), $widget_ops );
			
	}
	
	/**
	 * Form 
	 * Output the widget form
	 * 
	 * @param $instance
	 * @since 1.0
	 */
		
		
	function form( $instance ) {
		
			$instance = wp_parse_args( (array) $instance, $this->defaults );
			
			?>
			
			<!-- *** TITLE text ***-->
			
			<p> 
				<label class="description" for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 'sfmsb_domain'); ?></label>
				
				<input class="widefat" 
					   name="<?php echo $this->get_field_name( 'title' ); ?>" 
					   type="text" 
					   value="<?php echo esc_attr( $instance['title'] ); ?>" /> 
			</p>
			
			<!-- *** TEXT extra ***-->
			
			<p> 
				<label class="description" for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e('Text', 'sfmsb_domain'); ?></label>
				
				<input class="widefat" 
					   name="<?php echo $this->get_field_name( 'text' ); ?>" 
					   type="text" 
					   value="<?php echo esc_attr( $instance['text'] ); ?>" /> 
			</p>
			
			<!-- *** ENABLE checkbox & URL text ***-->
			
			<? foreach ( $this->available_buttons as $key => $item ) { ?>
			
				<p>
					
					<input id="<?php echo $this->get_field_name( 'enable_' . $key ) ?>" 
											   name="<?php echo $this->get_field_name( 'enable_' . $key ) ?>" 
											   type="checkbox" 
											   value="1" <?php checked(1, $instance[ 'enable_' . $key ] ) ?> />
					
					<label class="description" for="<?php echo $this->get_field_id( 'url_' . $key ); ?>"><?php _e( $item . ' URL', 'sfmsb_domain'); ?></label>
					
					<input id="<?php echo $this->get_field_id( 'url_' . $key ) ?>"
						   class="widefat"	 
						   name="<?php echo $this->get_field_name( 'url_' . $key );  ?>" 
				    	   type="text" 
				    	   class=""
						   value="<?php echo esc_url( $instance['url_' . $key] ); ?>"/>
				</p>
			
			<? } // foreach available buttons ?>
			
			
			<!-- *** STYLE select ***-->
				<p>
					<label class="main description" for="<?php echo $this->get_field_id( 'style' ); ?>"><?php _e('Style', 'sfmsb_domain'); ?></label>	
							<select id="<?php echo $this->get_field_id( 'style' ); ?>" name="<?php echo $this->get_field_name( 'style' ); ?>">
								
								<?php  foreach( $this->styles as $key => $item ){ ?>
									
										<option value="<?php echo $key ?>" <?php selected($instance[ 'style' ], $key) ?>>
											<?php _e($item, 'sfmsb_domain') ?>
										</option>
										
								<?php } ?>
								
							</select>
				</p>
				
				<!-- *** SIZES radios ***-->
				<p>
					<label class="main description" for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e('Size', 'sfmsb_domain'); ?></label>	
							&nbsp;&nbsp;&nbsp;
							
							<? foreach ( $this->sizes as $key => $item ){ ?>
								
								<input id="<?php echo $this->get_field_id( 'size' ); ?>" 
								   name="<?php echo $this->get_field_name( 'size' ); ?>" 
								   type="radio" 
								   value="<?php echo $key ?>" <?php checked($key, $instance['size']) ?> />
								   
								   <label class="description"><?php _e($key, 'sfmsb_domain'); ?></label>
									&nbsp;
								
							<? } ?>	
							
				</p>
				
				<!-- *** POSITIONS radios ***-->
				<p>
					<label class="main description" for="<?php echo $this->get_field_id( 'position' ); ?>"><?php _e('Position', 'sfmsb_domain'); ?></label>	
							<br/>
							
								
								<input id="<?php echo $this->get_field_id( 'position' ); ?>" 
								   name="<?php echo $this->get_field_name( 'position' ); ?>" 
								   type="radio" 
								   value="under" <?php checked('under', $instance['position']) ?> />
								   
								   <label class="description"><?php _e('Icons under text', 'sfmsb_domain'); ?></label>
									&nbsp;
								
								<input id="<?php echo $this->get_field_id( 'position' ); ?>" 
								   name="<?php echo $this->get_field_name( 'position' ); ?>" 
								   type="radio" 
								   value="float" <?php checked('float', $instance['position']) ?> />
								   
								   <label class="description"><?php _e('Icons next to text', 'sfmsb_domain'); ?></label>
									&nbsp;
				</p>
				
			
			<?
		
		}

	/**
	 * Update 
	 * Sets the new values of the instance
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
					
				$instance['url_' . $key] 	 = esc_url($new_instance['url_' . $key]);
				$instance['enable_' . $key]  = absint($new_instance['enable_' . $key]);
				
			} 
			
			$instance['size']     = esc_attr($new_instance['size']);
			$instance['style']    = esc_attr($new_instance['style']);
			$instance['position'] = esc_attr($new_instance['position']);
			
			return $instance;
	}
		
	/**
	 * widget
	 * Displays the widget
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
				
				if ( !empty( $instance['text'] ) ) { echo '<span class="sfmsb-text">' . $instance['text']  . '</span>'; };
					
					// ** do_action
					do_action('sfmsb_widget_before_links');
					
					foreach ( SFMSB::instance()->available_buttons as $key => $item ) {
							
						$size = SFMSB::instance()->buttons_sizes[$instance['size']] * 2;
						$image_suffix  = $size . '-' . SFMSB::instance()->buttons_sizes[$instance['size']] ;
						
						if( isset( $instance['enable_' . $key] ) &&  $instance['enable_' . $key] == 1 ) {
							
							echo '<a target="_blank" href="' . esc_url($instance['url_' . $key]) . '">';
							echo '<img src="' . SFMSB_PLUGIN_URL . 'assets/images/icon-' . $instance['style'] . '-'. $key .'-'. $image_suffix .'.png" alt="' . ucfirst($item) . '" />';
							echo '</a>';
						}	
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
		wp_enqueue_style('sfmsb-style', SFMSB_PLUGIN_URL . 'assets/css/style.css');
	}
	
	/**
	 * add_admin_style
	 * @since 1.0.0
	 */
	public static function add_admin_style() {
		wp_enqueue_style('sfmsb-admin-style', SFMSB_PLUGIN_URL . 'assets/css/admin.css');
	}
	
	
}// class
}// if
	