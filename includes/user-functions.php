<?php
/**
 * User functions
 */

namespace UserSettings;

 
\UserSettings\initialize();
 
function initialize()
{
    add_action('init', '\UserSettings\add_custom_user_role');
}

function add_custom_user_role() {
    add_role(
        'attendee',
        'Attendee',
        []
    );
}
