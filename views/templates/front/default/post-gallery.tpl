


<div class="post_format_items post_gallery {if isset($class) && $class}{$class}{/if}">
{foreach from=$gallery item=galleryimg}
	<div class="post_gallery_img item">
		<img class="img-responsive" src="{$galleryimg.$imagesize}" alt="">
	</div>
{/foreach}
</div>