<?php get_header(); ?>

		<div class="container">
			<div id="content" class="clearfix row">
				<div id="main" class="col-md-8 clearfix" role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">

					<?php while ( have_posts() ) : the_post(); ?>

						<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
							<header>
								<?php the_post_thumbnail( 'jwdmc-featured', array( 'class' => 'aligncenter' ) ); ?>

								<h1 class="single-title" itemprop="headline"><?php the_title(); ?></h1>

								<p class="meta"><?php _e("Posted on", "jwdmc"); ?> <time datetime="<?php echo the_time('Y-m-j'); ?>" itemprop="datePublished" pubdate><?php the_time('F j, Y'); ?></time> <?php _e("by", "jwdmc"); ?> <span class="author-link" itemscope="itemscope" itemtype="http://schema.org/Person" itemprop="author"><?php the_author_posts_link(); ?></span></p>
							</header>

							<section class="post_content clearfix" itemprop="articleBody">
								<?php the_content(); ?>
								<?php wp_link_pages(); ?>
							</section>

							<footer>
								<?php the_tags('<p class="tags"><span class="tags-title">' . __("Tags","jwdmc") . ':</span> ', ' ', '</p>'); ?>
							</footer>
						</article>

						<?php if ( comments_open() || get_comments_number() ) :
							comments_template('',true);
						endif; ?>


					<?php endwhile; ?>

				</div>

				<?php get_sidebar(); ?>
			</div>
		</div>

<?php get_footer(); ?>
