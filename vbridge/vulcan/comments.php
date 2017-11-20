<?php	 	 // Do not delete these lines
// thanks to Jeremy at http://clarktech.no-ip.com for the tips
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die (__('Please do not load this page directly. Thanks!','vulcan'));
if (function_exists('post_password_required')) 
	{
	if ( post_password_required() ) 
		{
		echo '<p class="nocomments">'.__('This post is password protected. Enter the password to view comments.','vulcan').'</p>';
		return;
		}
	} else 
	{
	if (!empty($post->post_password)) 
		{ // if there's a password
			if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) 
			{  // and it doesn't match the cookie  ?>
				<p class="nocomments"><?php	 	 echo __('This post is password protected. Enter the password to view comments.','vulcan');?></p>
				<?php	 	 return;
			}
		}
	}
if (function_exists('wp_list_comments')):
//WP 2.7 Comment Loop
if ( have_comments() ) : ?>
	<?php	 	 if ( ! empty($comments_by_type['comment']) ) :
	$count = count($comments_by_type['comment']);
	($count !== 1) ? $txt = __("Comments for this entry",'vulcan') : $txt = __("Comment for this entry",'vulcan'); ?>
  	<h3 class="comment-entry"><?php	 	 echo $count . " " . $txt; ?></h3>
  	<div id="comment">
  		<?php	 	 wp_list_comments('type=comment&callback=mytheme_comment'); ?>
  	</div>
	<?php	 	 endif; ?>

	<div class="navigation">
		<div class="alignleft"><?php	 	 previous_comments_link() ?></div>
		<div class="alignright"><?php	 	 next_comments_link() ?></div>
		<div class="cleared"></div>
	</div>

	<?php	 	 if ( ! empty($comments_by_type['pings']) ) :
	$countp = count($comments_by_type['pings']);
	($countp !== 1) ? $txtp = __("Trackbacks / Pingbacks for this entry",'vulcan') : $txtp = __("Trackback or Pingback for this entry",'vulcan'); ?>
	<h3 id="titlecomment"><?php	 	 echo $countp . " " . $txtp; ?></h3>
	<div id="comment">
	<?php	 	 wp_list_comments('type=pings&callback=mytheme_ping'); ?>
	</div>
	<?php	 	 endif; ?>


<?php	 	 else : // this is displayed if there are no comments so far ?>
	<?php	 	 if ('open' == $post->comment_status) :
		// If comments are open, but there are no comments.
	else : ?><p class="nocomments"><?php	 	 echo __('Comments are closed.','vulcan');?></p>
	<?php	 	 endif;
endif;
endif;
?>
<?php	 	 if ('open' == $post->comment_status) : ?>
<div class="clr"></div>
<div class="related-comment-title"><h3><?php	 	 echo __('Leave a comment','vulcan');?></h3></div><br />
<div id="comment-form">
<div id="commentFormArea">                           
<?php	 	 if (function_exists('cancel_comment_reply_link')) { 
//2.7 comment loop code ?>
<div id="cancel-comment-reply">
	<small><?php	 	 cancel_comment_reply_link();?></small>
</div>
<?php	 	 } ?>
 
<?php	 	 if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php	 	 echo __('You must be ','vulcan');?><a href="<?php	 	 echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php	 	 the_permalink(); ?>"><?php	 	 echo __('logged in','vulcan');?></a><?php	 	 echo __(' to post a comment','vulcan');?>.</p>
<?php	 	 else : ?>
<form action="<?php	 	 echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="cForm">
<fieldset>
<?php	 	 if ( $user_ID ) : ?>
<p>Logged in as <a href="<?php	 	 echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php	 	 echo $user_identity; ?></a>. <a href="<?php	 	 echo wp_logout_url(get_permalink());?>" title="Log out of this account">Logout &raquo;</a></p>
<?php	 	 else : ?>
      <input type="text" size="25" name="author" id="author" value="<?php	 	 echo esc_attr($comment_author); ?>"  tabindex="1" <?php	 	 if ($req) echo "aria-required='true'"; ?> class="input-comment" />
      <label for="posName" class="label-comment"><?php	 	 echo __('Name ','vulcan');?><?php	 	 if ($req) echo "<span>".__('(required)','vulcan')."</span>"; ?></label><br /><br />
			<input type="text" name="email" id="email" value="<?php	 	 echo esc_attr($comment_author_email); ?>" tabindex="2" <?php	 	 if ($req) echo "aria-required='true'"; ?> class="input-comment" />
			<label for="email" class="label-comment"><?php	 	 echo __('Mail ','vulcan');?><?php	 	 if ($req) echo "<span>".__('(required)')."</span>"; ?></label><br /><br />
      <input type="text" name="url" id="url" value="<?php	 	 echo esc_attr($comment_author_url); ?>"  tabindex="3" class="input-comment" />
      <label for="url"  class="label-comment"><?php	 	 echo __('Website','vulcan');?></label><br /><br />
  <?php	 	 endif; ?>
			<textarea name="comment" id="comment" cols="80" rows="10" tabindex="4" class="textarea-comment" ></textarea><br /><br />
			<!--<p><small><strong>XHTML:</strong> You can use these tags: <?php	 	 echo allowed_tags(); ?></small></p>-->
      <input name="submit" type="submit" id="submit" tabindex="5" value=""  class="input-submit-comment"  />
    <input type="hidden" name="comment_post_ID" value="<?php	 	 echo $id; ?>" />
    <?php	 	 if (function_exists('cancel_comment_reply_link')) { 
    //2.7 comment loop code ?>
     <?php	 	 comment_id_fields(); ?>
    <?php	 	 } ?>
  <?php	 	 do_action('comment_form', $post->ID); ?>
  </fieldset>
</form>
</div>
</div>
<?php	 	 endif; // If registration required and not logged in ?>
 
<?php	 	 endif; // if you delete this the sky will fall on your head ?>

