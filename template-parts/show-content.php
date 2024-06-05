<?php
/**
 * Show Content layout
 */

$directing_credits  = get_post_meta($post->ID, 'directing_credits', true);
$writing_credits    = get_post_meta($post->ID, 'writing_credits', true);
$end_date           = get_post_meta($post->ID, 'end_date', true); //var_dump($end_date);

?>
<div class="credits">
    <div class="credits__writing"><?php echo $writing_credits; ?></div>
    <div class="credits__directing"><?php echo $directing_credits; ?></div>
</div>
<?php if( $end_date >= date('Y-m-d') ) { ?>
    <a href="#tickets" class="button button--action">Buy Tickets</a>
<?php } else { ?>
    <p>This show is no longer available. Thank you for joining us!</p>
<?php } ?>
<?php the_content(); ?>
<div id="tickets" class="show-ticketing">
    <h4>Ticket Ordering</h4>
    <?php get_template_part('template-parts/select-tickets-for-performance'); ?>
</div>