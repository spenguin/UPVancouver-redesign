<?php

/**
 * Tools
 */

function pvd( $var ) {
    ob_start(); ?>
        <pre>
            <?php var_dump( $var ); ?>
        </pre>
    <?php
    $o = ob_get_clean();
    echo $o;
}

function create_dropdown($array, $name=NULL, $selected="")
{ 
    if( is_null($name)) return '';

    $o  = [];
    foreach($array as $key => $value)
    {
        $selectedStr = $selected == $key ? ' selected ' : '';
        $o[]    = '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
    }

    return '<select name="' . $name . '">' . join( "/n", $o ) . '</select>';

}