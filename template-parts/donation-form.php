<?php
/**
 * Donation form
 */
$donation = getDonationProduct();
if( !array_key_exists($donation, $_SESSION['cart']) ):
    ?>
    <div class="donation-form">
        <p>United Players appreciates support from donors.</p>
        <form action="/cart" method="post">
            <label>&dollar;&nbsp;<input type="text" name="donation" /></label>
            <input type="submit" value="Donate" class="button button--action">
            <?php if(!is_page('Donate')): ?>
                <span><a href="/donate">Learn more about donating to United Players</a></span>
            <?php endif; ?>
        </form>
    </div>
<?php
    endif; ?>