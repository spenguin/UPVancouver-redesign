<?php
/**
 * Show Settings page
 */
add_action( 'admin_menu', 'show_settings_page' );


function show_settings_page()
{
    add_options_page( 'Show Settings', 'Show Settings', 'manage_options', 'show-settings', 'render_show_settings_page' );
}

function render_show_settings_page()
{
    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'general_options'; // This needs to be sanitised
    ?>
    <div class="wrap">
        <h2>Show Settings</h2>
        <div class="nav-tab-wrapper">
            <a href="?page=show-settings&tab=general_options" class="nav-tab <?php echo $active_tab == 'general_options' ? 'nav-tab-active' : ''; ?>">General</a>
            <a href="?page=show-settings&tab=advanced_options" class="nav-tab <?php echo $active_tab == 'advanced_options' ? 'nav-tab-active' : ''; ?>">Advanced</a>
        </div>
        <form method="post" action="options-general.php?page=show-settings&tab=<?php echo $active_tab; ?>">

            <?php submit_button(); ?>
        </form>

    </div> 
    <?php
}

