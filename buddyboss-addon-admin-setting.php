<?php
/**
 * Add admin addon settings page in Dashboard->BuddyBoss->Settings
 *
 * @since 1.0.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MYPLUGIN_Admin_Setting_Media' ) ) {
	/**
	 * Main Search Settings class.
	 *
	 * @since 1.0.0
	 */
	class MYPLUGIN_Admin_Setting_Media extends BP_Admin_Setting_tab {

		public function initialize() {

		$this->tab_label = __( 'Add-on', 'buddyboss' );
		$this->tab_name  = 'bp-addon';
		$this->tab_order = 99;
	}

		public function is_active() {
			return true;
		}

		public function register_fields() {
			$sections = MYPLUGIN_get_settings_sections();

			foreach ( (array) $sections as $section_id => $section ) {

				// Only add section and fields if section has fields
				$fields = MYPLUGIN_get_settings_fields_for_section( $section_id );

				if ( empty( $fields ) ) {
					continue;
				}

				$section_title    = ! empty( $section['title'] ) ? $section['title'] : '';
				$section_callback = ! empty( $section['callback'] ) ? $section['callback'] : false;

				// Add the section
				$this->add_section( $section_id, $section_title, $section_callback );

				// Loop through fields for this section
				foreach ( (array) $fields as $field_id => $field ) {

					$field['args'] = isset( $field['args'] ) ? $field['args'] : array();

					if ( ! empty( $field['callback'] ) && ! empty( $field['title'] ) ) {
						$sanitize_callback = isset( $field['sanitize_callback'] ) ? $field['sanitize_callback'] : [];
						$this->add_field( $field_id, $field['title'], $field['callback'], $sanitize_callback, $field['args'] );
					}
				}
			}
		}

	}

	return new MYPLUGIN_Admin_Setting_Media;
}