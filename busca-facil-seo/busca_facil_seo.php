<?php
/*
Plugin Name: Busca Facil SEO
Description: Um plugin personalizado de SEO para WordPress.
Version: 0.1
Author: Matrix_s0beit
*/

// Função para adicionar meta tags de SEO
function busca_facil_seo() {
    // Verifica se é uma página única (post ou página)
    if (is_single() || is_page()) {
        global $post;

        // Obtém o título da página/post
        $title = get_the_title($post->ID);
        
        // Obtém a descrição do SEO (se definida) ou usa o excerto como fallback
        $meta_description = get_post_meta($post->ID, '_seo_description', true);
        if (empty($meta_description)) {
            $excerpt = get_the_excerpt();
            $meta_description = wp_trim_words($excerpt, 20, '...');
        }
		
        // Escapa e exibe as meta tags no cabeçalho
	echo '<meta charset="UTF-8">';
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '<meta name="title" content="' . esc_html($title) . '">' . "\n";
        echo '<meta name="description" content="' . esc_attr($meta_description) . '" />' . "\n";
		
	//Permitir que uma página seja indexada pelos motores de busca
	echo '<meta name="robots" content="index, follow">';
        
        // Meta keywords
        $meta_keywords = get_post_meta($post->ID, '_seo_keywords', true);
        if ($meta_keywords) {
            echo '<meta name="keywords" content="' . esc_attr($meta_keywords) . '" />' . "\n";
        }
        
        // Open Graph para redes sociais (opcional)
        echo '<meta property="og:title" content="' . esc_attr($title) . '" />' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($meta_description) . '" />' . "\n";
        echo '<meta property="og:type" content="article" />' . "\n";
        echo '<meta property="og:url" content="' . get_permalink($post->ID) . '" />' . "\n";

	// Adiciona imagem do post no Open Graph (se disponível)
        if (has_post_thumbnail($post->ID)) {
            $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
            echo '<meta property="og:image" content="' . esc_url($thumbnail[0]) . '">' . "\n";
        }

	// Adiciona Twitter Cards (opcional)
        echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
        echo '<meta name="twitter:title" content="' . esc_attr($title) . '">' . "\n";
        echo '<meta name="twitter:description" content="' . esc_attr($meta_description) . '">' . "\n";
        if (has_post_thumbnail($post->ID)) {
            echo '<meta name="twitter:image" content="' . esc_url($thumbnail[0]) . '">' . "\n";
        }
    }
}

// Adiciona a função ao hook wp_head, que insere conteúdo no cabeçalho do site
add_action('wp_head', 'busca_facil_seo');
