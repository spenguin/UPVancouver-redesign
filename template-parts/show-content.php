<?php
/**
 * Show Content layout
 */

$directing_credits  = get_post_meta($post->ID, 'directing_credits', true);
$writing_credits    = get_post_meta($post->ID, 'writing_credits', true);
$end_date           = get_post_meta($post->ID, 'end_date', true); //var_dump($end_date);
$tickets_available  = $end_date >= date('Y-m-d'); 
$comp_notice        = get_post_by_title('Notice regarding comps', "content");

?>
<div class="credits">
    <div class="credits__writing"><?php echo $writing_credits; ?></div>
    <div class="credits__directing"><?php echo $directing_credits; ?></div>
</div>
<?php if( $tickets_available ) { ?>
    <a href="#tickets" class="button button--action">Buy Tickets</a>
<?php } else { ?>
    <p>This show is no longer available. Thank you for joining us!</p>
<?php } ?>

<?php
    // Get the page components based on the show title
    $content    = organise_show_content($post->post_title);
    ?>
    <div class="show-page">
        <div class="show-page__main">
            <?php echo isset($content['main']) ? apply_filters('the_content', $content['main'] ) : ''; ?>
            <div class="show-page__main-images">
                <?php echo show_production_photos($post->ID); ?>
            </div>
        </div>
       
        <div class="show-page__sidebar">
            <div class="show-page__sidebar--cast">
                <h3>Cast</h3>
                <?php echo isset($content['main']) ? apply_filters('the_content', $content['cast'] ) : ''; ?>
            </div>
            <div class="show-page__sidebar--production">
                <h3>Production</h3>
                <?php echo isset($content['main']) ? apply_filters('the_content', $content['production'] ) : ''; ?>
            </div>
        </div>

        <?php if( $tickets_available ) { ?>
            <div id="tickets" class="show-ticketing">
                <h4>Ticket Ordering</h4>
                <?php echo $comp_notice; ?>
                <?php get_template_part('template-parts/select-tickets-for-performance'); ?>
            </div>
        <?php }  ?>           
    </div>




