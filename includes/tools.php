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