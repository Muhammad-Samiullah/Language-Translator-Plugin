<?php
if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) { die(); };
		 global $wpdb;
		 $wp_track_table = $wpdb->prefix . 'language_translator_paragraphs';
		 $wpdb->query( "DROP TABLE IF EXISTS {$wp_track_table}" );
		 $wp_track_table = $wpdb->prefix . 'language_translator_paragraph_translations';
		 $wpdb->query( "DROP TABLE IF EXISTS {$wp_track_table}" );
?>