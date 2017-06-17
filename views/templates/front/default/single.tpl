<div class="kr_blog_post_area single">
	<div class="kr_blog_post_inner">
		<article id="blog_post" class="blog_post blog_post_{$xipblogpost.post_format}">
			<div class="blog_post_content">
				<div class="blog_post_content_top">
					<div class="post_thumbnail">
						{if $xipblogpost.post_format == 'video'}
							{assign var="postvideos" value=','|explode:$xipblogpost.video}
							{include file="./post-video.tpl" videos=$postvideos width='870' height="482" class="{if $postvideos|@count > 1 }carousel{/if}"}
						{elseif $xipblogpost.post_format == 'audio'}
							{assign var="postaudio" value=','|explode:$xipblogpost.audio}
							{include file="./post-audio.tpl" audios=$postaudio width='870' height="482" class="{if $postaudio|@count > 1 }carousel{/if}"}
						{elseif $xipblogpost.post_format == 'gallery'}
							{include file="./post-gallery.tpl" gallery=$xipblogpost.gallery_lists imagesize="medium" class="{if $xipblogpost.gallery_lists|@count > 1 }carousel{/if}"}
						{else}
							<img class="img-responsive" src="{$xipblogpost.post_img_large}" alt="{$xipblogpost.post_title}">
						{/if}
					</div>
				</div>
				<div class="post_content">
					<h3 class="post_title">{$xipblogpost.post_title}</h3>
					<div class="post_meta clearfix">
						<p class="meta_author">
							{l s='Posted by ' mod='xipblog'}
							<span>{$xipblogpost.post_author_arr.firstname} {$xipblogpost.post_author_arr.lastname}</span>
						</p>
						<p class="meta_date">
							{$xipblogpost.post_date|date_format:"%b %dTH, %Y"}
						</p>
						<p class="meta_category">
								<a href="{$xipblogpost.category_default_arr.link}">{$xipblogpost.category_default_arr.name}</a>
						</p>
					</div>
					<div class="post_description">
						<p>{$xipblogpost.post_content}</p>
					</div>
				</div>
			</div>
		</article>
	</div>
</div>
{if ($xipblogpost.comment_status == 'open') || ($xipblogpost.comment_status == 'close')}
			{include file="./comment-list.tpl"}
{/if}
{if (isset($disable_blog_com) && $disable_blog_com == 1) && ($xipblogpost.comment_status == 'open')}
			{include file="./comment.tpl"}
{/if}