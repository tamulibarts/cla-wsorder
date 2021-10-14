<?php
/**
 * Page Template: Media Attachment
 *
 * @link       https://github.tamu.edu/liberalarts-web/cla-wsorder/blob/master/attachment.php
 * @since      1.0.0
 * @package    cla-wsorder
 */

// Redirect attempts to view the attachment page back to the post page.
wp_safe_redirect( get_permalink( $post->post_parent ) );
