<?php
/**
 * Plugin Name: Zytho - donnees structurees
 * Description: Nettoie les donnees structurees des fiches produits (2026-10-23). Retour arriere : supprimer ce fichier.
 *
 * - Retire le BreadcrumbList de WooCommerce (Yoast SEO fournit deja le sien).
 * - Decode les entites HTML doublement encodees dans le nom du Product et dans le fil d'Ariane de Yoast.
 * - Ecrit le JSON-LD de WooCommerce sans l'echappement HTML de wc_esc_json (qui transformait & en &amp; dans le script).
 *
 * @package Zytho
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Decode un texte jusqu'a ce qu'il ne contienne plus d'entites HTML.
 *
 * @param string $text Texte.
 * @return string
 */
function zytho_sd_decode( $text ) {
	$text = (string) $text;
	for ( $i = 0; $i < 3; $i++ ) {
		$decoded = html_entity_decode( $text, ENT_QUOTES | ENT_HTML5, 'UTF-8' );
		if ( $decoded === $text ) {
			break;
		}
		$text = $decoded;
	}
	return $text;
}

/**
 * Retire le fil d'Ariane de WooCommerce des donnees structurees (doublon de celui de Yoast).
 *
 * @return void
 */
function zytho_sd_remove_wc_breadcrumb() {
	if ( function_exists( 'WC' ) && WC() && isset( WC()->structured_data ) && is_object( WC()->structured_data ) ) {
		remove_action( 'woocommerce_breadcrumb', array( WC()->structured_data, 'generate_breadcrumblist_data' ), 10 );
	}
}
add_action( 'init', 'zytho_sd_remove_wc_breadcrumb', 20 );

/**
 * Remplace la sortie JSON-LD de WooCommerce : meme donnees, mais sans wc_esc_json (qui ajoute &amp; dans un script).
 *
 * @return void
 */
function zytho_sd_output() {
	if ( ! function_exists( 'WC' ) || ! WC() || ! isset( WC()->structured_data ) || ! is_object( WC()->structured_data ) ) {
		return;
	}
	$types   = array();
	$types[] = ( is_shop() || is_product_category() || is_product() ) ? 'product' : '';
	$types[] = ( is_shop() && is_front_page() ) ? 'website' : '';
	$types[] = is_product() ? 'review' : '';
	$types[] = 'breadcrumblist';
	$types[] = 'order';
	$types   = array_filter( apply_filters( 'woocommerce_structured_data_type_for_page', $types ) );
	$data    = WC()->structured_data->get_structured_data( $types );
	if ( $data ) {
		echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_HEX_TAG | JSON_UNESCAPED_SLASHES ) . '</script>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

/**
 * Remplace le hook de sortie de WooCommerce par le notre.
 *
 * @return void
 */
function zytho_sd_swap_output() {
	if ( function_exists( 'WC' ) && WC() && isset( WC()->structured_data ) && is_object( WC()->structured_data ) ) {
		remove_action( 'wp_footer', array( WC()->structured_data, 'output_structured_data' ), 10 );
		add_action( 'wp_footer', 'zytho_sd_output', 10 );
	}
}
add_action( 'init', 'zytho_sd_swap_output', 20 );

/**
 * Nom du Product sans double encodage.
 *
 * @param array $markup Donnees du Product.
 * @return array
 */
function zytho_sd_product( $markup ) {
	if ( is_array( $markup ) && isset( $markup['name'] ) ) {
		$markup['name'] = zytho_sd_decode( $markup['name'] );
	}
	return $markup;
}
add_filter( 'woocommerce_structured_data_product', 'zytho_sd_product', 20 );

/**
 * Noms du fil d'Ariane Yoast sans entites HTML.
 *
 * @param array $data Donnees du BreadcrumbList.
 * @return array
 */
function zytho_sd_yoast_breadcrumb( $data ) {
	if ( is_array( $data ) && isset( $data['itemListElement'] ) && is_array( $data['itemListElement'] ) ) {
		foreach ( $data['itemListElement'] as $k => $item ) {
			if ( is_array( $item ) && isset( $item['name'] ) ) {
				$data['itemListElement'][ $k ]['name'] = zytho_sd_decode( $item['name'] );
			}
		}
	}
	return $data;
}
add_filter( 'wpseo_schema_breadcrumb', 'zytho_sd_yoast_breadcrumb', 20 );
