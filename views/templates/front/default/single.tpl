{extends file='page.tpl'}

{block name='page_header_container'}{/block}


{block name="page_content_container"}
	<section id="content" class="page-content">
		<div class="kr_blog_post_area single">
			<div class="kr_blog_post_inner">
				<article id="blog_post" class="blog_post blog_post_{$xipblogpost.post_format}">
					<div class="blog_post_content">
						<div class="blog_post_content_top">
							<div class="post_thumbnail">
								{if $xipblogpost.post_format == 'video'}
									{assign var="postvideos" value=','|explode:$xipblogpost.video}
									{if $postvideos|@count > 1 }
										{assign var="class" value='carousel'}
									{else}
										{assign var="class" value=''}
									{/if}
									{include file="module:xipblog/views/templates/front/default/post-video.tpl" postvideos=$postvideos width='870' height="482" class=$class}
								{elseif $xipblogpost.post_format == 'audio'}
									{assign var="postaudio" value=','|explode:$xipblogpost.audio}
									{if $postaudio|@count > 1 }
										{assign var="class" value='carousel'}
									{else}
										{assign var="class" value=''}
									{/if}
									{include file="module:xipblog/views/templates/front/default/post-audio.tpl" postaudio=$postaudio width='870' height="482" class=$class}
								{elseif $xipblogpost.post_format == 'gallery'}
									{if $xipblogpost.gallery_lists|@count > 1 }
										{assign var="class" value='carousel'}
									{else}
										{assign var="class" value=''}
									{/if}
									{include file="module:xipblog/views/templates/front/default/post-gallery.tpl" gallery_lists=$xipblogpost.gallery_lists imagesize="medium" class=$class}
								{else}
									<img class="xipblog_img img-responsive" src="{$xipblogpost.post_img_large}" alt="{$xipblogpost.post_title}">
								{/if}
							</div>
						</div>

						<div class="blog_post_content_bottom">
							<h3 class="post_title">{$xipblogpost.post_title}</h3>
							<div class="post_meta clearfix">
								<div class="meta_author">
									{* <i class="icon-user"></i> *}
									<span>{l s='By' mod='xipblog'} {$xipblogpost.post_author_arr.firstname} {$xipblogpost.post_author_arr.lastname}</span>
								</div>
								<div class="post_meta_date">
									{* <i class="icon-calendar"></i> *}
									{$xipblogpost.post_date|date_format:"%b %dTH, %Y"}
								</div>
								<div class="meta_category">
									{* <i class="icon-tag"></i> *}
									<span>{l s='In' mod='xipblog'}</span>
									<span>{$xipblogpost.category_default_arr.name}</span>
								</div>
								<div class="meta_comment">
									{* <i class="icon-eye"></i> *}
									<span>{l s='Views' mod='xipblog'} ({$xipblogpost.comment_count})</span>
								</div>
							</div>
							<div class="post_content">
								{$xipblogpost.post_content nofilter}
							</div>
						</div>

					</div>
				</article>
			</div>
		</div>
		{include file="module:xipblog/views/templates/front/default/custom-nav.tpl"}
	</section>
{if ($xipblogpost.comment_status == 'open') || ($xipblogpost.comment_status == 'close')}
	{include file="module:xipblog/views/templates/front/default/comment-list.tpl"}
{/if}
{if (isset($disable_blog_com) && $disable_blog_com == 1) && ($xipblogpost.comment_status == 'open')}
	{include file="module:xipblog/views/templates/front/default/comment.tpl"}
{/if}
{/block}
{block name="left_column"}
	{assign var="layout_column" value=$layout|replace:'layouts/':''|replace:'.tpl':''|strval}
	{if ($layout_column == 'layout-left-column')}
		<div id="left-column" class="sidebar col-xs-12 col-sm-12 col-md-3 pull-md-9">
			{if ($xipblog_column_use == 'own_ps')}
				{hook h="displayxipblogleft"}
			{else}
				{hook h="displayLeftColumn"}
			{/if}
		</div>
	{/if}
{/block}
{block name="right_column"}
	{assign var="layout_column" value=$layout|replace:'layouts/':''|replace:'.tpl':''|strval}
	{if ($layout_column == 'layout-right-column')}
		<div id="right-column" class="sidebar col-xs-12 col-sm-4 col-md-3">
			{if ($xipblog_column_use == 'own_ps')}
				{hook h="displayxipblogright"}
			{else}
				{hook h="displayRightColumn"}
			{/if}
		</div>
	{/if}
{/block}