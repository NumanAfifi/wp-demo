<?php

class TD_Customizer {
	protected $fields;
	protected $wp_customize;

	public function __construct($fields) {
		$this->fields = $fields;
		add_action( 'customize_register', array($this, 'register') );
	}

	function register($wp_customize) {
		$this->wp_customize = $wp_customize;

		foreach($this->fields as $id => $panel) {
			
			if(isset($panel['title'])) $this->add_panel($id, $panel);

			foreach($panel['sections'] as $id => $section) {

				if(isset($section['title']))
				$this->add_section($id, $section);
				$section_id = $id;

				foreach($section['settings'] as $id => $setting) {
					$this->add_setting($id, $setting);
					$setting['section'] = $section_id;
					$this->add_control($id, $setting);
				}
			}
		}
	}

	function add_panel($id, $panel) {
		$panel = $this->parse(['title'], $panel);
		$this->wp_customize->add_panel($id, $panel);
	}

	function add_section($id, $section) {
		$section = $this->parse(['title'], $section);
		$this->wp_customize->add_section($id, $section);
	}

	function add_setting($id, $setting) {
		$setting = $this->parse(['default', 'transfer'], $setting);
		$setting['type'] = 'option';
		$this->wp_customize->add_setting($id, $setting);
	}

	function add_control($id, $control) {
		$control = $this->parse(['type', 'priority', 'section', 'label'], $control);
		$control['settings'] = $id;
		
		switch ($control['type']) {
			case 'image':
				$this->wp_customize->add_control(
					new WP_Customize_Image_Control(
				        $this->wp_customize,
				        $id,
				        $control
				    )
				);
				break;
			
			default:
				$this->wp_customize->add_control($id, $control);
				break;
		}
	}

	// parse only relevant fields
	function parse($keys, $input) {
		$parsed = [];

		foreach($input as $k => $v) {
			if(in_array($k, $keys)) {
				$parsed[$k] = $v;
			}
		}

		return $parsed;
	}
}