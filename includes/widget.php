<?php
/**
 * Boostrap the plugin
 *
 * @since  2.0.0
 *
 * @package SimpleFollowMeSocial
 */

use Lucymtc\SimpleFollowMeSocial\Helper as Helper;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'SFMSB_Widget' )){

class SFMSB_Widget extends WP_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->defaults = array(
			'title'    => esc_html__('Social', 'sfmsb'),
			'size'     => '20',
			'position' => 'under',
			'text'     => esc_html__('Follow me on:', 'sfmsb'),
			'color'    => '',
			'hover_color' => '',
			'style'    => 'circle',
			'layout'   => 'horizontal',
		);

		$ops = array(
				'classname'   => 'sfmsb_widget',
				'description' => esc_html__( 'Adds "follow me" social buttons', 'sfmsb' )
		);

		parent::__construct( 'sfmsb_settings', esc_html__( 'Simple follow me social buttons', 'sfmsb' ), $ops );
		}

	/**
	 * Form
	 * @return void
	 */
	public function form( $instance ){

		$instance = wp_parse_args( (array) $instance, $this->defaults );
		$icons_set = Helper\get_icons_collections();
		?>
		<div class="sfmsb-form-wrapper">
		<?php
		// Category.
		foreach( $icons_set as $key => $category ){ ?>
			<a href="javascript:void(0);" class="sfmsb-category <?php echo esc_attr( $key ); ?>"><?php echo esc_html_e( $category->name, 'sfmsb' ) ?></a>
			<div class="icons-panel sfmsb-group-<?php echo esc_attr( $key ); ?>"></div>
		<?php } ?>

			<div class="sfmsb-selection" data-widget="<?php echo esc_attr( $this->id ) ?>" id="sfmsb-selection-<?php echo esc_attr( $this->id ) ?>"></div>
			<input type="text" name="sfmsb-selection" />
		</div><!--form-wrapper-->
		<?php
	}

	/**
	 * Update
	 * @return array
	 */
	public function update( $new_instance, $old_instance ){

	}

	/**
	 * Output widget
	 * @return void
	 */
	public function widget( $args, $instance ){

	}

}

/**
 * Register the Widget
 */
add_action( 'widgets_init', function() {
	register_widget( 'SFMSB_Widget' );
} );

}//if class exists
