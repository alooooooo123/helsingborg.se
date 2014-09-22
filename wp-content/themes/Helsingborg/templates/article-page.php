<?php
/*
Template Name: Artikelsida
*/
get_header();
?>

<div class="article-page-layout row">
    <!-- main-page-layout -->
        <div class="main-area large-9 columns">

        <div class="main-content row">
            <!-- SIDEBAR LEFT -->
            <div class="sidebar sidebar-left large-4 medium-4 columns">
                <div class="search-container row">
                    <div class="search-inputs large-12 columns">
                        <input type="text" placeholder="Vad letar du efter?" name="search"/>
                        <input type="submit" value="Sök">
                    </div>
                </div><!-- /.search-container -->

                <div class="row">

                    <!-- large-up menu-->
                  <?php dynamic_sidebar("left-sidebar"); ?>
                  <?php Helsingborg_sidebar_menu(); ?>
                    <!-- END large up menu-->

                </div><!-- /.row -->
            </div><!-- /.sidebar-left -->

            <div class="large-8 medium-8 columns">

                <!-- Slider -->
                <?php $hasSlides = (is_active_sidebar('slider-area') == TRUE) ? '' : 'no-image'; ?>
                <div class="row <?php echo $hasSlides; ?>">
                  <div class="large-12 columns slider-container">
                      <!-- START ORBIT -->
                      <div class="orbit-container">
                        <ul class="example-orbit" data-orbit data-options="navigation_arrows:false;slide_number:false;timer:false;">
                          <?php dynamic_sidebar("slider-area"); ?>
                        </ul>
                      </div>
                      <!-- END ORBIT -->
                  </div><!-- /.slider-container -->
                </div><!-- /.row -->

                <div class="listen-to">
                    <a href="#" class="icon"><span>Lyssna på innehållet</span></a>
                </div>

                <?php /* Start loop */ ?>
                    <?php while (have_posts()) : the_post(); ?>
                      <article class="article">
                        <header>
                          <h1 class="article-title"><?php the_title(); ?></h1>
                        </header>
                        <div class="article-body">
                          <?php the_content(); ?>
                        </div>
                        <footer>
                          <ul class="socialmedia-list">
                              <li class="fbook"><a href="#">Facebook</a></li>
                              <li class="twitter"><a href="#">Twitter</a></li>
                          </ul>
                        </footer>
                      </article>
                    <?php endwhile; // End the loop ?>

            <!-- List "puffar" + "blockpuffar" se : http://www.helsingborg.se/Medborgare/Uppleva-och-gora/ + http://www.helsingborg.se/Medborgare/Trafik-och-stadsplanering/ -->

            <?php
            // Only print out if content area has any widgets available
            if ( (is_active_sidebar('content-area') == TRUE) ) : ?>
              <?php dynamic_sidebar("content-area"); ?>
            <?php endif; ?>

            <!-- END LIST + BLOCK puffs :-) -->
        </div><!-- /.columns -->
    </div><!-- /.main-content -->

        <div class="lower-content row">
            <div class="sidebar large-4 columns">
                <div class="row">
                    <!-- TODO -->
                </div><!-- /.row -->
            </div><!-- /.sidebar -->

        </div><!-- /.lower-content -->
    </div>  <!-- /.main-area -->

    <div class="sidebar sidebar-right large-3 columns">
        <div class="row">

          <?php /* Add the page's widgets */ ?>
          <?php dynamic_sidebar("right-sidebar"); ?>

    </div><!-- /.rows -->
</div><!-- /.sidebar -->

</div><!-- /.article-page-layout -->
</div><!-- /.main-site-container -->


<?php get_footer(); ?>
