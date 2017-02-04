<?php get_header(); ?>

		<div class="container">
			<div id="content" class="clearfix row">
				<div id="main" class="col-md-8 clearfix" role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
							<header>
								<h1 class="h3"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>

								<p class="meta"><?php _e("Posted on", "jwdmc"); ?> <time datetime="<?php echo the_time('Y-m-j'); ?>" itemprop="datePublished" pubdate><?php the_time('F j, Y'); ?></time> <?php _e("by", "jwdmc"); ?> <?php the_author_posts_link(); ?></p>
							</header>

							<section>
								<?php the_excerpt(); ?>
							</section>

							<footer>
								<?php the_tags('<p class="tags"><span class="tags-title">' . __("Tags","jwdmc") . ':</span> ', ' ', '</p>'); ?>
							</footer>
						</article>

					<?php endwhile; ?>

					<div class="row">
						<div class="col-sm-12 text-center">
							<?php if (function_exists('page_navi')) : ?>
								<?php page_navi(); ?>
							<?php else : ?>
								<nav class="wp-prev-next">
									<ul class="pager">
										<li class="previous"><?php next_posts_link(_e('&laquo; Older Entries', "wpbootstrap")) ?></li>
										<li class="next"><?php previous_posts_link(_e('Newer Entries &raquo;', "wpbootstrap")) ?></li>
									</ul>
								</nav>
							<?php endif; ?>
						</div>
					</div>

					<?php else : ?>

						<h2><?php _e('No Videos Yet', 'jwdmc'); ?></h2>
						<p><?php _e('Sorry, there are no videos of this type.', 'jwdmc'); ?></p>

					<?php endif; ?>

				</div>

				<?php get_sidebar(); ?>
			</div>
		</div>

<?php get_footer(); ?>
