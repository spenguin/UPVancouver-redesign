<?php
/**
 * User functions
 */

class userFns
{
    static function getUserByEmail( $email, $userName )
    {
        $user   = get_user_by( 'email', $email );
        if( !$user )
        {
            // Create new user
            $user_data = [
                'user_pass'     => wp_generate_password(),
                'user_login'    => $email,
                'user_email'    => $email,
                'role'          => 'attendee',
                'display_name'  => $userName
            ];
            wp_insert_user($user_data);
            $user = get_user_by( 'email', $email ); 
        }
        return $user;
    }
}