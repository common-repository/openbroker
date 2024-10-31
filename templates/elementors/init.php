<?php 
function register_openbroker_widgets( $widgets_manager ) {


	require_once( __DIR__ . '/widgets/properties.php' );

	$widgets_manager->register( new \Properties() );

}
add_action( 'elementor/widgets/register', 'register_openbroker_widgets' );
function add_openbroker_widget_categories( $elements_manager ) {

	$elements_manager->add_category(
		'openbroker',
		[
			'title' => esc_html__( 'Open Broker', 'textdomain' ),
			'icon' => 'fa fa-plug',
		]
	);


}
add_action( 'elementor/elements/categories_registered', 'add_openbroker_widget_categories' );

