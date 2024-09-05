<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package UPVancouver
 */
$page_class = get_page_class_by_title(get_the_title());

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link href="https://fonts.googleapis.com/css?family=Roboto|Oswald" rel="stylesheet">

	<?php wp_head(); ?>
</head>

<body <?php body_class($page_class); ?>>
	<header>
		<?php get_template_part( 'template-parts/header-content' ); ?>
        <?php //get_template_part( 'template-parts/header-bar' ); ?>
        <?php //get_template_part( 'template-parts/hero-image' ); ?>
        <?php //get_template_part( 'template-parts/navigation' ); ?>
    </header>
    <div class="container">