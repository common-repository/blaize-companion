<?php
/**
 * The tabs customize control extends the WP_Customize_Control class. This class allows
 * developers to create tabs and hide the sections' settings easily.
 *
 * @package    Blaize Companion
 * @since      1.1.45
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return;
}

/**
 * Radio image customize control.
 *
 * @since  1.1.45
 * @access public
 */
class Blaize_Companion_Customize_Control_Tabs extends WP_Customize_Control {

	/**
	 * Blaize_Companion_Customize_Control_Tabs constructor.
	 *
	 * @param WP_Customize_Manager $manager wp_customize manager.
	 * @param string               $id      control id.
	 * @param array                $args    public parameters for control.
	 */
	public function __construct( WP_Customize_Manager $manager, $id, array $args = array() ) {
		parent::__construct( $manager, $id, $args );

		add_action( 'customize_preview_init', array( $this, 'partials_helper_script_enqueue' ) );

		if ( ! empty( $this->tabs ) ) {
			foreach ( $this->tabs as $value => $args ) {
				$this->controls[ $value ] = $args['controls'];
			}
		}
	}

	/**
	 * Controls array from tabs.
	 *
	 * @var array
	 */
	public $controls = array();

	/**
	 * The type of customize control being rendered.
	 *
	 * @var   string
	 */
	public $type = 'interface-tabs';

	/**
	 * The type refresh being used.
	 *
	 * @var   string
	 */
	public $transport = 'postMessage';

	/**
	 * The priority of the control.
	 *
	 * @var   string
	 */
	public $priority = -10;

	/**
	 * The tabs with keys of the controls that are under each tab.
	 *
	 * @var array
	 */
	public $tabs;

	/**
	 * Displays the control content.
	 *
	 * @access public
	 * @return void
	 */
	public function render_content() {
		/* If no tabs are provided, bail. */
		if ( empty( $this->tabs ) || ! $this->more_than_one_valid_tab() ) {
			return;
		}

		$output = '';
		$i      = 0;

		$output .= '<div class="blaize-tabs-control" id="input_' . esc_attr( $this->id ) . '">';
		foreach ( $this->tabs as $value => $args ) {
			if ( ! empty( $args['controls'] ) && ( $this->tab_has_controls( $args['controls'] ) ) ) {
				$controls_attribute = json_encode( $args['controls'] );

				$output .= '<div class="blaize-customizer-tab">';

				$output .= '<input type="radio"';
				$output .= 'value="' . esc_attr( $value ) . '" ';
				$output .= 'name="' . esc_attr( "_customize-radio-{$this->id}" ) . '" ';
				$output .= 'id="' . esc_attr( "{$this->id}-{$value}" ) . '" ';
				$output .= 'data-controls="' . esc_attr( $controls_attribute ) . '" ';
				if ( $i === 0 ) {
					$output .= 'checked="true" ';
				}
				$i ++;
				$output .= '/><!-- /input -->';

				$label_classes = '';
				foreach ( $args['controls'] as $control_id ) {
					$label_classes .= esc_attr( $control_id . ' ' );
				}

				$output .= '<label class = "' . $label_classes . '" ';
				$output .= 'for="' . esc_attr( "{$this->id}-{$value}" ) . '">';
				if ( ! empty( $args['nicename'] ) ) {
					$output .= '<span class="screen-reader-text">' . esc_html( $args['nicename'] ) . '</span>';
				}
				if ( ! empty( $args['icon'] ) ) {
					$output .= '<i class="fa fa-' . esc_attr( $args['icon'] ) . '"></i>';
				}
				if ( ! empty( $args['nicename'] ) ) {
					$output .= $args['nicename'];
				}
				$output .= '</label>';
				$output .= '</div><!-- /.blaize-customizer-tab -->';
			}
		}
		$output .= '</div><!-- /.blaize-tabs-control -->';

		echo $output;
	}
	/**
	 * Loads the scripts and hooks our custom styles in.
	 *
	 * @access public
	 * @return void
	 */
	public function enqueue() {

		if ( empty( $this->tabs ) || ! $this->more_than_one_valid_tab() ) {
			return;
		}

		wp_enqueue_script( 'blaize-companion-tabs-control-script', BLAIZE_COMPANION_DIR . 'customizer/customizer-tabs/js/script.js', array( 'jquery' ), '15258', true );
		wp_enqueue_style( 'blaize-companion-tabs-control-style', BLAIZE_COMPANION_DIR . 'customizer/customizer-tabs/css/style.css', null, '15258' );

	}

	/**
	 * Enqueue the partials handler script that works synchronously with the blaize-tabs-control-script
	 */
	public function partials_helper_script_enqueue() {
		wp_enqueue_script( 'blaize-companion-tabs-addon-script', BLAIZE_COMPANION_DIR . 'customizer/customizer-tabs/js/addons.js', array( 'jquery' ), '15258', true );
	}

	/**
	 * Verify if the tab has valid controls.
	 *
	 * Meant to foolproof the control if a tab has no valid controls.
	 * Returns false if there are no valid controls inside the tab.
	 *
	 * @param controls array $controls_array the array of controls.
	 *
	 * @return bool
	 */
	protected final function tab_has_controls( $controls_array ) {
		$i = 0;
		foreach ( $controls_array as $control ) {
			$setting = $this->manager->get_setting( $control );
			if ( ! empty( $setting ) ) {
				$i++;
			}
		}
		if ( $i === 0 ) {
			return false;
		}
		return true;
	}

	/**
	 * Verify if there's more than one valid tab.
	 *
	 * @return bool
	 */
	protected final function more_than_one_valid_tab() {
		$i = 0;
		foreach ( $this->tabs as $tab ) {
			if ( $this->tab_has_controls( $tab['controls'] ) ) {
				$i++;
			}
		}
		if ( $i > 1 ) {
			return true;
		}
		return false;
	}
}

