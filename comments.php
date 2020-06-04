<?php
/**
 * The template file for displaying the comments and comment form for the
 * Credence theme.
 *
 * @package Credence
 * @since 1.0.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
*/
if ( post_password_required() ) :
	return;
endif;

if ( $comments ) :
	?>

	<div class="comments" id="comments">

		<?php
		$comments_number = absint( get_comments_number() );
		?>

		<div class="comments-header section-inner small max-percentage">

			<h2 class="comment-reply-title">
			<?php
			if ( ! have_comments() ) :
				_e( 'Leave a comment', 'credence' );
			elseif ( '1' === $comments_number ) :
				/* translators: %s: post title */
				printf( _x( 'One reply on &ldquo;%s&rdquo;', 'comments title', 'credence' ), esc_html( get_the_title() ) );
			else :
				echo sprintf(
					/* translators: 1: number of comments, 2: post title */
					_nx(
						'%1$s reply on &ldquo;%2$s&rdquo;',
						'%1$s replies on &ldquo;%2$s&rdquo;',
						$comments_number,
						'comments title',
						'credence'
					),
					number_format_i18n( $comments_number ),
					esc_html( get_the_title() )
				);
			endif;

			?>
			</h2><!-- .comments-title -->

		</div><!-- .comments-header -->

		<div class="comments-inner thin max-percentage">

			<?php
			wp_list_comments(
				array(
					'walker'      => new Cred_Walker_Comment(),
					'avatar_size' => 120,
					'style'       => 'div'
				)
			);

			$comment_pagination = paginate_comments_links(
				array(
					'echo'      => false,
					'end_size'  => 0,
					'mid_size'  => 0,
					'next_text' => __( 'Newer Comments', 'credence' ) . ' <span aria-hidden="true">&rarr;</span>',
					'prev_text' => '<span aria-hidden="true">&larr;</span> ' . __( 'Older Comments', 'credence' )
				)
			);

			if ( $comment_pagination ) :
				$pagination_classes = '';

				// If we're only showing the "Next" link, add a class indicating so.
				if ( false === strpos( $comment_pagination, 'prev page-numbers' ) ) :
					$pagination_classes = ' only-next';
				endif;
				?>

				<nav class="comments-pagination pagination<?php echo $pagination_classes; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output ?>" aria-label="<?php esc_attr_e( 'Comments', 'credence' ); ?>">
					<?php echo wp_kses_post( $comment_pagination ); ?>
				</nav>

				<?php
			endif;
			?>

		</div><!-- .comments-inner -->

	</div><!-- comments -->

	<?php
endif;

if ( comments_open() || pings_open() ) :

	comment_form(
		array(
			'class_form'         => 'thin max-percentage',
			'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
			'title_reply_after'  => '</h2>',
		)
	);

elseif ( is_single() ) :

	?>

	<div class="comment-respond" id="respond">

		<p class="comments-closed"><?php _e( 'Comments are closed.', 'credence' ); ?></p>

	</div><!-- #respond -->

	<?php
endif;
