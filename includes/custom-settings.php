<?php
/**
 * Custom Settings for United Players of Vancouver
 */

add_action( 'admin_menu', 'custom_settings_submenu' );

function custom_settings_submenu()
{
 
    add_submenu_page(
        'options-general.php', // parent page slug
        'United Players Custom Settings',
        'United Players Custom Settings',
        'manage_options',
        'custom_settings',
        'custom_settings_callback'
    );
}

function custom_settings_callback()
{
    $optionGroups = [
        'Shows',
        'Performances',
        'Seasons'
    ];
    ?>
    <div class="tab">
        <?php 
            foreach( $optionGroups as $g )
            { ?>
                <button class="tablinks" onclick="openGroup(event, '<?php echo $g; ?>')"><?php echo $g; ?></button>
            <?php }
        ?>
    </div>

    <?php
        foreach( $optionGroups as $g )
        { ?>
            <div id="<?php echo $g; ?>" class="tabcontent">
                <?php require_once CORE_SETTINGS . 'settings' . $g . '.php'; ?>
            </div>
        <?php }
    ?>


    <style>
        /* Style the tab */
        .tab {
        overflow: hidden;
        border: 1px solid #ccc;
        background-color: #f1f1f1;
        }

        /* Style the buttons that are used to open the tab content */
        .tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
        background-color: #ddd;
        }

        /* Create an active/current tablink class */
        .tab button.active {
        background-color: #ccc;
        }

        /* Style the tab content */
        .tabcontent {
            display: none;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-top: none;
        }
        .tabcontent.active {
            display: block;
        }
        input[type=number] {
            width: 3rem;
        }

    </style>

    <script>
        function openGroup(evt, cityName) {
            // Declare all variables
            var i, tabcontent, tablinks;

            // Get all elements with class="tabcontent" and hide them
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].classList.remove('active');
                // tabcontent[i].style.display = "none";
            }

            // Get all elements with class="tablinks" and remove the class "active"
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].classList.remove('active');
                // tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            // Show the current tab, and add an "active" class to the button that opened the tab
            document.getElementById(cityName).classList.add('active');
            evt.currentTarget.classList.add('active');
        } 
    </script>

    <?php
}