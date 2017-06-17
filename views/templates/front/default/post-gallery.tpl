<div class="post_format_items post_gallery {if isset($class) && $class}{$class}{/if}">
{if isset($gallery_lists) && $gallery_lists}
{foreach from=$gallery_lists item=galleryimg}
	<div class="post_gallery_img item">
		<img class="xipblog_img img-responsive" src="{$galleryimg.$imagesize}" alt="">
	</div>
{/foreach}
{/if}
</div>