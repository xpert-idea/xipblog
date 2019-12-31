<div class="bottom-custom-nav-content clearfix">
  
  <div class="col-md-4">
    {if isset($link_post_previeus) && !empty($link_post_previeus)}<a class="button_previeus" href="{$link_post_previeus}">{l s="Previeus"}</a>{/if}
  </div>
  <div class="col-md-4 content_back">
    <a class="button_previeus" href="javascript:history.back(1);">{l s="Back"}</a>
  </div>
  <div class="col-md-4">
    {if isset($link_post_next) && !empty($link_post_next)}<a class="button_next" href="{$link_post_next}">{l s="Next"}</a>{/if}
  </div>
</div>