    <footer class="footer">
        <div class="footer__wrapper max-wrapper">
            <div class="footer__content-wrapper">
                <div class="secondary-navigation">
                    <h3>Quick Links</h3>
                    <?php wp_nav_menu('Secondary Menu'); ?>
                </div>
                <div class="footer__connection">
                    <div class="footer__directions">
                        <div class="cta--wrapper"><a class="button button--action" href="/plan-your-visit">Plan Your Visit</a></div>
                    </div>                
                    <div class="footer__subscribe">
                        <p class="footer__subscribe--instructions">Subscribe for updates</p>
                        <?php dynamic_sidebar( 'footer_social_media' ); ?>
                    </div>  
                </div>
                <div class="footer__social-media">
                    <div class="a2a_kit a2a_kit_size_46 a2a_default_style a2a_follow">
                        <a class="a2a_button_facebook" href="https://www.facebook.com/AddToAny"></a>
                        <a class="a2a_button_instagram" href="https://www.instagram.com/kevin"></a>
                        <!-- <a class="a2a_button_mastodon" href="https://mastodon.social/@Gargron"></a>
                        <a class="a2a_button_threads" href="https://www.threads.net/@addtoany"></a>
                        <a class="a2a_button_tiktok"  href="https://www.tiktok.com/@khaby.lame"></a>
                        <a class="a2a_button_discord" href="https://discord.com/invite/roblox"></a>
                        <a class="a2a_button_pinterest" href="https://www.pinterest.com/pinterest"></a>
                        <a class="a2a_button_linkedin" href="https://www.linkedin.com/in/reidhoffman"></a> -->
                        <!-- <a class="a2a_button_vimeo" href="https://vimeo.com/staff"></a> -->
                        <a class="a2a_button_youtube" href="https://www.youtube.com/user/YouTube"></a>
                        <!-- <a class="a2a_button_tumblr" href="https://staff.tumblr.com/"></a>
                        <a class="a2a_button_github" href="https://github.com/torvalds"></a>
                        <a class="a2a_button_snapchat" href="https://www.snapchat.com/add/teamsnapchat"></a>
                        <a class="a2a_button_medium" href="https://medium.com/@ev"></a> -->
                        <a class="a2a_button_x" href="https://twitter.com/ev"></a>
                        <!-- <a class="a2a_button_bluesky" href="https://bsky.app/profile/jay.bsky.team"></a>
                        <a class="a2a_button_flickr" href="https://www.flickr.com/photos/flickr"></a>
                        <a class="a2a_button_google_maps" href="https://goo.gl/maps/xweTPfsMoFTXHrCF7"></a>
                        <a class="a2a_button_yelp" href="https://www.yelp.com/biz/greens-restaurant-san-francisco-5"></a>
                        <a class="a2a_button_foursquare" href="https://foursquare.com/v/greens-restaurant/4a1c397bf964a520257b1fe3"></a>
                        <a class="a2a_button_soundcloud" href="https://soundcloud.com/foofighters"></a>
                        <a class="a2a_button_spotify" href="https://open.spotify.com/artist/7jy3rLJdDQY21OgRLCZ9sD"></a>
                        <a class="a2a_button_apple_music" href="https://music.apple.com/us/artist/foo-fighters/6906197"></a> -->
                    </div>
                </div>                
            </div>

            <div class="footer__acknowledgement">
                <?php
                    echo get_post_by_title('Acknowledgement');
                ?>
            </div> 
            <div class="footer__fine-print--wrapper">
                <p class="copyright fine-print">&copy;<?php echo date('Y'); ?> United Players of Vancouver</p>
                <p class="registration fine-print">Registered Canadian Charity #0763615-22-27</p>                
            </div>
        </div>
    </footer>
    <?php wp_footer(); ?>
</body>
</html>