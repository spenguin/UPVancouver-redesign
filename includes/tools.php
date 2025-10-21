<?php

/**
 * Tools
 */

function pvd( $var ) 
{
    ob_start(); ?>
        <pre>
            <?php var_dump( $var ); ?>
        </pre>
    <?php
    $o = ob_get_clean();
    echo $o;
}

function create_dropdown($array, $name=NULL, $selected="", $instructions='', $required=FALSE )
{ 
    if( is_null($name)) return '';

    $o  = empty($instructions) ? [] : ['<option>' . $instructions . '</option>'];
    
    foreach($array as $key => $value)
    {
        $selectedStr = $selected == $key ? ' selected ' : '';
        $o[]    = '<option value="' . $key . '"' . $selectedStr . '>' . $value . '</option>';
    }

    // return '<select name="' . $name . '"' . ( $required ? 'required' : '' ) . '>' . join( "/n", $o ) . '</select>';
    return '<select required="required" name="' . $name . '">' . join( "\n", $o ) . '</select>';

}