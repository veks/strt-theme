<?php
/**
 * Общие функции для темы STRT.
 *
 * Этот файл содержит функции, которые используются для настройки и добавления функциональности
 * темы WordPress, не связанной с WooCommerce.
 *
 * @package Strt\Theme
 */

if ( ! function_exists( 'strt_custom_logo' ) ) {
	function strt_custom_logo( $args = [] ): void {
		$defaults = [
			'classes'     => 'navbar-brand navbar-brand-item',
			'img_classes' => 'img-fluid',
			'size'        => 'full',
			'show_title'  => true,
		];
		$args     = wp_parse_args( $args, $defaults );

		if ( has_custom_logo() ) {
			$custom_logo_id = get_theme_mod( 'custom_logo' );
			$logo_img       = wp_get_attachment_image(
				$custom_logo_id,
				$args['size'],
				false,
				[
					'class'   => $args['img_classes'],
					'loading' => 'lazy',
					'alt'     => get_bloginfo( 'name' ),
				]
			);

			echo $logo_img;
		} else {
			echo get_bloginfo( '', 'display' );
		}
	}
}
