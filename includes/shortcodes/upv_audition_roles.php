<?php
/**
 * Render Audition parts
 */

function upv_audition_roles( $atts = [], $content = null, $tag = '' )
{
    $content = html_entity_decode($content);
    $o = <<<EOD
        <section class="audition-roles">
        $content
        </section>
    EOD;

    return $o;
} 