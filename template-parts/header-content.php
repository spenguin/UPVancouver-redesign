<?php
/**
 * Header template part
 */
$options    = get_option('performance_options');

?>

    <div class="header-bar">
        <a href="/seasons-tickets"><?php echo $options['performance_field_season_ticket_string']; ?></a>
    </div>
    <div class="primary-navigation">
        <div class="primary-navigation-wrapper max-wrapper">
            <div class="primary-navigation__left">
                <a href="/donate" class="button button-primary-nav button--little">Donate</a>
                <a href="/about" class="button button-primary-nav button--little">About</a>
            </div>
            <div class="primary-navigation__right">
                <a href="/" class="nav nav--icon nav__home"><i class="fa-solid fa-house"></i></a>
                <a href="/cart" class="nav nav--icon nav__shopping"><i class="fas fa-shopping-cart"></i></a>
                <a class="nav nav__hamburger">Open</a>
            </div>
        </div>
    </div>
    <div class="hero upvimage">
        <?php if( is_home() || is_front_page() ) { ?>
            <div class="anniversary-flash">
                <img src="wp-content\themes\upvancouver\assets\upv-65th-logo.svg" alt="UPV 65th Anniversary" />
            </div>
        <?php } ?>
        <div class="feature-image">
            <?php echo get_the_post_thumbnail(); ?>
        </div>
    </div>
