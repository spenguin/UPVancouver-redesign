    <footer class="footer">
        <div class="footer__wrapper max-wrapper">
            <?php if( get_the_title() != 'Maintenance' ): ?>
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
                        <div class="footer__social-media--wrapper">
                            <a href="https://www.facebook.com/groups/United.Players.Vancouver" target="_blank"><i class="fa-brands fa-facebook"></i></a>
                            <a href="https://www.instagram.com/united_players_of_vancouver/" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                        </div>
                    </div>                
                </div>
            <?php endif; ?>

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