{* <pre>{$xipblogpost|print_r}</pre> *}
{if isset($xipblogpost) && !empty($xipblogpost)}
<section class="kr_blog_post_area">
	<div class="kr_blog_post_inner {if $xprt.blog_style == 'default'}blog_style_default{elseif $xprt.blog_style == 'column'}blog_style_column row{/if}">
		{foreach from=$xipblogpost item=xpblgpst}
			<article id="blog_post" class="blog_post blog_post_{$xpblgpst.post_format} {if $xprt.blog_style == 'column'}col-sm-{$xprt.blog_no_of_col}{/if} clearfix">
				<div class="blog_post_content">
					<div class="blog_post_content_top">
						<div class="post_thumbnail">

							{if $xpblgpst.post_format == 'video'}
								{assign var="postvideos" value=','|explode:$xpblgpst.video}
								{include file="./post-video.tpl" videos=$postvideos width='870' height="450" class="{if $postvideos|@count > 1 }carousel{/if}"}
							{elseif $xpblgpst.post_format == 'audio'}
								{assign var="postaudio" value=','|explode:$xpblgpst.audio}
								{include file="./post-audio.tpl" audios=$postaudio width='870' height="450" class="{if $postaudio|@count > 1 }carousel{/if}"}
							{elseif $xpblgpst.post_format == 'gallery'}
								{include file="./post-gallery.tpl" gallery=$xpblgpst.gallery_lists imagesize="medium" class="{if $xpblgpst.gallery_lists|@count > 1 }carousel{/if}"}
							{else}
								<img class="img-responsive" src="{$xpblgpst.post_img_large}" alt="{$xpblgpst.post_title}">

								<div class="blog_mask">
									<div class="blog_mask_content">

										<a class="thumbnail_lightbox" href="{$xpblgpst.post_img_large}">
											<i class="icon_plus"></i>
										</a>

										{* <a class="post_link" href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}">
											<i class="icon-link"></i>
										</a> *}
										
									</div>
								</div>
							{/if}
							
							
						</div>

					</div>
					<div class="post_content">
						<h3 class="post_title"><a href="{$xpblgpst.link}">{$xpblgpst.post_title}</a></h3>
						
						<div class="post_meta clearfix">
							<p class="meta_author">
								{* <i class="icon-user"></i> *}
								{l s='Posted by ' mod='xipblog'}
								<span>{$xpblgpst.post_author_arr.firstname} {$xpblgpst.post_author_arr.lastname}</span>
							</p>

							<p class="meta_date">
								{$xpblgpst.post_date|date_format:"%b %dTH, %Y"}
							</p>
							
							<p class="meta_category">
								{* <i class="icon-tag"></i> *}
									<a href="{$xpblgpst.category_default_arr.link}">{$xpblgpst.category_default_arr.name}</a>
							</p>

							{* <div class="meta_comment">
								<i class="icon-eye"></i>
								<span>{l s='Views' mod='xipblog'} ({$xpblgpst.comment_count})</span>
							</div> *}
						</div>

						<div class="post_description">
							{if isset($xpblgpst.post_excerpt) && !empty($xpblgpst.post_excerpt)}
								<p>{$xpblgpst.post_excerpt|truncate:500:'...'|escape:'html':'UTF-8'}</p>
							{else}
								<p>{$xpblgpst.post_content|truncate:400:'...'|escape:'html':'UTF-8'}</p>
							{/if}
							
						</div>
						
						<div class="read_more">
							<a class="more" href="{$xpblgpst.link}">{l s='Continue' mod='xipblog'} <i class="arrow_right"></i></a>
						</div>

					</div>
				</div>
			</article>
		{/foreach}
	</div>
</section>
{/if}

{include file="$tpl_dir./pagination.tpl"}




{* 
{if isset($xipblogpost) && !empty($xipblogpost)}
	{foreach from=$xipblogpost item=xpblgpst}
			{$xpblgpst.id_xipposts}
		    {$xpblgpst.link}
		    {$xpblgpst.post_author}

		    <pre>{$xpblgpst.post_author_arr}</pre>

		    {$xpblgpst.post_author_arr.firstname}
		    {$xpblgpst.post_author_arr.lastname}
		    {$xpblgpst.post_date}
		    {$xpblgpst.comment_status}
		    {$xpblgpst.post_password}
		    {$xpblgpst.post_modified}
		    {$xpblgpst.post_parent}
		    {$xpblgpst.category_default}

		    <pre>{$xpblgpst.category_default_arr}</pre>

		    {$xpblgpst.category_default_arr.id}
		    {$xpblgpst.category_default_arr.name}
		    {$xpblgpst.category_default_arr.link_rewrite}
		    {$xpblgpst.category_default_arr.title}
		    {$xpblgpst.category_default_arr.link}
		    {$xpblgpst.post_type}
		    {$xpblgpst.post_format}
		    {$xpblgpst.post_img}
		    {$xpblgpst.post_img_small}
		    {$xpblgpst.post_img_medium}
		    {$xpblgpst.post_img_large}
		    {$xpblgpst.video}
		    {$xpblgpst.audio}
		    {$xpblgpst.gallery} 
		    {$xpblgpst.related_products}
		    {$xpblgpst.comment_count}
		    {$xpblgpst.position}
		    {$xpblgpst.active}
		    {$xpblgpst.id_lang}
		    {$xpblgpst.post_title}
		    {$xpblgpst.meta_title}
		    {$xpblgpst.meta_description}
		    {$xpblgpst.meta_keyword}
		    {$xpblgpst.post_content}
		    {$xpblgpst.post_excerpt}
		    {$xpblgpst.link_rewrite}
		    {$xpblgpst.id_shop}
	{/foreach}
{/if}
 *}


