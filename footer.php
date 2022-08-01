<footer class="site-footer">
  <div class="site-footer__inner container container--narrow">
    <div class="group">
      <div class="site-footer__col-one">
        <h1 class="school-logo-text school-logo-text--alt-color">
          <a href="<?php echo site_url(); ?>"><strong>Fictional</strong> University</a>
        </h1>
        <p><a class="site-footer__link" href="#">+1 (250) 228 9621</a></p>
        <p><a class="site-footer__link" href="#">Farhad Nazmi <?php echo date('Y') ?> &copy; </a></p>
      </div>
      <div class="site-footer__col-two-three-group">
        <div class="site-footer__col-two">
          <h3 class="headline headline--small">Explore</h3>
          <nav class="nav-list">
            <!-- footer menu one -->
            <?php
                 wp_nav_menu(
                     array(
                     'theme_location' => 'footer-menu'
                     )
                 );
            ?>
            <!-- end of footer menu one -->
          </nav>
        </div>

        <div class="site-footer__col-three">
          <h3 class="headline headline--small">Learn</h3>
          <nav class="nav-list">
            <!--footer menu two -->
            <?php
            wp_nav_menu(
              array(
                'theme_location' => 'footer-menu-two'
              )
            );
            ?>
            <!-- end of footer menu two -->
          </nav>
        </div>
      </div>

      <div class="site-footer__col-four">
        <h3 class="headline headline--small">Follow Us</h3>
        <nav>
          <ul class="min-list social-icons-list group">
            <li>
              <a href="#" class="social-color-facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            </li>
            <li>
              <a href="#" class="social-color-twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
            </li>
            <li>
              <a href="#" class="social-color-youtube"><i class="fa fa-youtube" aria-hidden="true"></i></a>
            </li>
            <li>
              <a href="#" class="social-color-linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
            </li>
            <li>
              <a href="#" class="social-color-instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</footer>
//overlay

<?php wp_footer(); ?>
</body>

</html>