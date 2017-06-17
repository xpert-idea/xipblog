<div class="post_format_items {if isset($class) && $class}{$class}{/if}">
{if isset($postaudio) && $postaudio}
{foreach from=$postaudio item=audiourl}
	<div class="item post_audio ">
	<div class="embed-responsive embed-responsive-16by9">
		<iframe class="embed-responsive-item" src="{if isset($audiourl) && $audiourl}{$audiourl}{/if}" width="{if isset($width) && $width}{$width}{/if}" height="{if isset($height) && $height}{$height}{/if}" frameborder="0"></iframe>
	</div>
	</div>
{/foreach}
{/if}
</div>