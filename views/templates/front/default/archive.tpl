{extends file='page.tpl'}

{block name='page_header_container'}{/block}

{block name="page_content_container"}
	<section id="content" class="page-content">
	{if isset($xipblogpost) && !empty($xipblogpost)}
	<div class="kr_blog_post_area">
		<div class="kr_blog_post_inner blog_style_{$xipblogsettings.blog_style} column_{$xipblogsettings.blog_no_of_col}">
			{foreach from=$xipblogpost item=xpblgpst}
				<article id="blog_post" class="blog_post blog_post_{$xpblgpst.post_format} clearfix">
					<div class="blog_post_content">
						<div class="blog_post_content_top">
							<div class="post_thumbnail">
							{block name="xipblog_post_thumbnail"}
								{if $xpblgpst.post_format == 'video'}
									{assign var="postvideos" value=','|explode:$xpblgpst.video}
									{if $postvideos|@count > 1 }
										{assign var="class" value='carousel'}
									{else}
										{assign var="class" value=''}
									{/if}
									{include file="module:xipblog/views/templates/front/default/post-video.tpl" postvideos=$postvideos width='870' height="482" class=$class}
								{elseif $xpblgpst.post_format == 'audio'}
									{assign var="postaudio" value=','|explode:$xpblgpst.audio}
									{if $postaudio|@count > 1 }
										{assign var="class" value='carousel'}
									{else}
										{assign var="class" value=''}
									{/if}
									{include file="module:xipblog/views/templates/front/default/post-audio.tpl" postaudio=$postaudio class=$class}
								{elseif $xpblgpst.post_format == 'gallery'}
									{if $xpblgpst.gallery_lists|@count > 1 }
										{assign var="class" value='carousel'}
									{else}
										{assign var="class" value=''}
									{/if}
									{include file="module:xipblog/views/templates/front/default/post-gallery.tpl" gallery_lists=$xpblgpst.gallery_lists imagesize="large" class=$class}
								{else}
									<img class="img-responsive" src="{$xpblgpst.post_img_large}" alt="{$xpblgpst.post_title}">
									<div class="blog_mask">
										<div class="blog_mask_content">
											<a class="thumbnail_lightbox" href="{$xpblgpst.post_img_large}">
												<i class="icon_plus"></i>
											</a>										
										</div>
									</div>
								{/if}
							{/block}
							</div>
						</div>

						<div class="blog_post_content_bottom">
							<h3 class="post_title"><a href="{$xpblgpst.link}">{$xpblgpst.post_title}</a></h3>
							
							<div class="post_meta clearfix">
								
									
								
								<div class="meta_author">
									{* <i class="icon-user"></i> *}
									<span>{l s='By' mod='xipblog'} {$xpblgpst.post_author_arr.firstname} {$xpblgpst.post_author_arr.lastname}</span>
								</div>

								<div class="post_meta_date">
									{* <i class="icon-calendar"></i> *}
									{$xpblgpst.post_date|date_format:"%b %dTH, %Y"}
								</div>

								<div class="meta_category">
									{* <i class="icon-tag"></i> *}
										<span>{l s='In' mod='xipblog'}</span>
										<a href="{$xpblgpst.category_default_arr.link}">{$xpblgpst.category_default_arr.name}</a>
								</div>
								<div class="meta_comment">
									{* <i class="icon-eye"></i> *}
									<span>{l s='Views' mod='xipblog'} ({$xpblgpst.comment_count})</span>
								</div>
							</div>

							<div class="post_content">
								{if isset($xpblgpst.post_excerpt) && !empty($xpblgpst.post_excerpt)}
									{$xpblgpst.post_excerpt|truncate:500:'...'|escape:'html':'UTF-8'}
								{else}
									{$xpblgpst.post_content|truncate:400:'...'|escape:'html':'UTF-8'}
								{/if}
							</div>
							<div class="content_more">
								<a class="read_more" href="{$xpblgpst.link}">{l s='Continue' mod='xipblog'}</a>
							</div>
						</div>

					</div>
				</article>
			{/foreach}
		</div>
	</div>
	{/if}
	</section>
	{include file="module:xipblog/views/templates/front/default/pagination.tpl"}
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