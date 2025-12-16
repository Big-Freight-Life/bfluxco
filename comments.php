<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains
 * both the current comments and the comment form.
 *
 * @package BFLUXCO
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if (have_comments()) : ?>

        <h2 class="comments-title">
            <?php
            $comment_count = get_comments_number();
            if ('1' === $comment_count) {
                printf(
                    esc_html__('One comment on &ldquo;%1$s&rdquo;', 'bfluxco'),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            } else {
                printf(
                    esc_html(_n('%1$s comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', $comment_count, 'bfluxco')),
                    number_format_i18n($comment_count),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            }
            ?>
        </h2><!-- .comments-title -->

        <?php the_comments_navigation(); ?>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 50,
            ));
            ?>
        </ol><!-- .comment-list -->

        <?php the_comments_navigation(); ?>

        <?php if (!comments_open()) : ?>
            <p class="no-comments"><?php esc_html_e('Comments are closed.', 'bfluxco'); ?></p>
        <?php endif; ?>

    <?php endif; // Check for have_comments(). ?>

    <?php
    comment_form(array(
        'title_reply'        => __('Leave a Comment', 'bfluxco'),
        'title_reply_to'     => __('Leave a Reply to %s', 'bfluxco'),
        'cancel_reply_link'  => __('Cancel Reply', 'bfluxco'),
        'label_submit'       => __('Post Comment', 'bfluxco'),
        'class_submit'       => 'btn btn-primary',
        'comment_field'      => '<p class="comment-form-comment"><label for="comment">' . _x('Comment', 'noun', 'bfluxco') . ' <span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="6" required></textarea></p>',
    ));
    ?>

</div><!-- #comments -->
