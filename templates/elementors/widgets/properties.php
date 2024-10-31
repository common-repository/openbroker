<?php
class Properties extends \Elementor\Widget_Base
{
	public function get_name()
	{
		return 'openbroker-properties';
	}
	public function get_title()
	{
		return 'Openbroker Properties';
	}
	public function get_categories()
	{
		return ['openbroker'];
	}
	public function get_keywords()
	{
		return ['properties', 'openbroker'];
	}
	protected function register_controls()
	{
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__('Content', 'elementor-oembed-widget'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'transactionType',
			[
				'type' => \Elementor\Controls_Manager::SELECT,
				'label' => esc_html__('Transaction Type', 'textdomain'),
				'options' => [
					'for_rent' => esc_html__('Rent', 'textdomain'),
					'for_sale' => esc_html__('Sale', 'textdomain'),
				],
				'default' => '',
			]
		);
		$this->add_control(
			'propertyType',
			[
				'type' => \Elementor\Controls_Manager::SELECT,
				'label' => esc_html__('Property Type', 'textdomain'),
				'options' => [
					'all' => esc_html__('All', 'textdomain'),
					'house' => esc_html__('House', 'textdomain'),
					'apartment' => esc_html__('Apartment', 'textdomain'),
					'plot' => esc_html__('Plot', 'textdomain'),
					'commercial' => esc_html__('Commercial', 'textdomain'),

				],
				'default' => '',
			]
		);

		$this->add_control(
			'minBedrooms',
			[
				'type' => \Elementor\Controls_Manager::NUMBER,
				'label' => esc_html__('Bedrooms', 'textdomain'),
				'placeholder' => '',
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'default' => '',
			]
		);

		$this->add_control(
			'minBathrooms',
			[
				'type' => \Elementor\Controls_Manager::NUMBER,
				'label' => esc_html__('Bathrooms', 'textdomain'),
				'placeholder' => '',
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'default' => '',
			]
		);

		$this->add_control(
			'minPrice',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__('Price Min', 'textdomain'),
				'placeholder' => '',
				'size_units' => ['€'],
				'range' => [
					'€' => [
						'min' => 5000,
						'max' => 5000000,
						'step' => 1000,
					]
				],
				'default' => [
					'unit' => '€',
					'size' => '',
				],
			]
		);

		$this->add_control(
			'maxPrice',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__('Price Max', 'textdomain'),
				'placeholder' => '',
				'size_units' => ['€'],
				'range' => [
					'€' => [
						'min' => 1000,
						'max' => 500000,
						'step' => 1000,
					]
				],
				'default' => [
					'unit' => '€',
					'size' => '',
				],
			]
		);

		$this->add_control(
			'minBuiltArea',
			[
				'type' => \Elementor\Controls_Manager::NUMBER,
				'label' => esc_html__('Built Area', 'textdomain'),
				'placeholder' => 'Min (m2)',
				'min' => 0,
				'max' => 100000000,
				'step' => 1,
				'default' => '',
			]
		);
		$this->add_control(
			'minPlotSize',
			[
				'type' => \Elementor\Controls_Manager::NUMBER,
				'label' => esc_html__('Plot Size', 'textdomain'),
				'placeholder' => 'Min (m2)',
				'min' => 0,
				'max' => 100000000,
				'step' => 1,
				'default' => '',
			]
		);

		$this->add_control(
			'city',
			[
				'type' => \Elementor\Controls_Manager::TEXT,
				'label' => esc_html__('Location City/State (ID)', 'textdomain'),
				'placeholder' => esc_html__('All', 'textdomain'),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__('Style Section', 'textdomain'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->end_controls_section();
	}
	protected function render()
	{
		$settings = $this->get_settings_for_display();
		// echo "<pre>";print_r($settings);die();
		$args = '';
		if ($settings['transactionType'] != '') {
			$args .= " transactionType='" . $settings['transactionType'] . "'";
		}
		if ($settings['propertyType'] != '' && $settings['propertyType'] != 'all') {
			$args .= " propertyType='" . $settings['propertyType'] . "'";
		}
		if ($settings['minBedrooms'] != '') {
			$args .= " minBedrooms='" . $settings['minBedrooms'] . "'";
		}
		if ($settings['minBathrooms'] != '') {
			$args .= " minBathrooms='" . $settings['minBathrooms'] . "'";
		}
		if ($settings['minPrice']["size"] != '') {
			$args .= " minPrice='" . $settings['minPrice']["size"] . "'";
		}
		if ($settings['maxPrice']["size"] != '') {
			$args .= " maxPrice='" . $settings['maxPrice']["size"] . "'";
		}
		if ($settings['minBuiltArea'] != '') {
			$args .= " minBuiltArea='" . $settings['minBuiltArea'] . "'";
		}
		if ($settings['minPlotSize'] != '') {
			$args .= " minPlotSize='" . $settings['minPlotSize'] . "'";
		}
		if ($settings['city'] != '' && $settings['city'] != 'All') {
			$args .= " city='" . $settings['city'] . "'";
		}
		
		
		// echo $args;die();
		echo do_shortcode("[openbroker template='only_properties' perPage='15' row_items='3' $args ]");
	}
}
