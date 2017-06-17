<div class="post_format_items {if isset($class) && $class}{$class}{/if}">
	{if (isset($videos) && !empty($videos))}
		{foreach from=$videos item=videourl}
			<div class="item post_video">
				<div class="embed-responsive embed-responsive-16by9">
					<iframe class="embed-responsive-item" src="{if isset($videourl) && $videourl}{$videourl}{/if}" width="{if isset($width) && $width}{$width}{/if}" height="{if isset($height) && $height}{$height}{/if}"></iframe>
				</div>
			</div>
		{/foreach}
	{/if}
</div>