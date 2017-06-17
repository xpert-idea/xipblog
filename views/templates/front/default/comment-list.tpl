<div class="comments_area" id="comments">
    <h2 class="comments_title">
        {l s='All comments' mod='xipblog'}
    </h2>

    <ol class="comment_list">
		
		{foreach from=$xipblog_commets item=xipblog_commet}
			
		
        <li class="comment" id="comment_{$xipblog_commet.id_xip_comments}">

            <article class="comment_body">
				<div class="comment_author vcard">
				    <img alt="" class="avatar avatar-70 photo" height="70" src="http://2.gravatar.com/avatar/597a1e6b0dfdf57f53ef8fb80fa190d7?s=70&d=mm&r=g" width="70">
				</div>
				
				<div class="comment_content">
					
					<div class="comment_meta">
					    <div class="comment_meta_author">
					    	<b class="fn">{$xipblog_commet.name}</b>
					    </div>
					    <div class="comment_meta_date">
					    	<time datetime="2016-03-07T04:33:23+00:00">
					    	    {$xipblog_commet.created|date_format:"%e %B, %Y"}
					    	</time>
					    </div>
					    <div class="reply">
					        <a aria-label="Reply to raihan@sntbd.com" class="comment-reply-link" href="#" onclick='return addComment.moveForm( "div-comment-3", "3", "respond", "38" )' rel="nofollow">
					            Reply
					        </a>
					    </div>
					</div>


					<div class="comment_content_bottom">
						<p>
							{$xipblog_commet.content}
						</p>
					</div>
				    
				</div>
				<!-- .comment-content -->
            </article>

            <!-- .comment-body -->
            
            <!-- .children -->
        </li>
        <!-- #comment-## -->
	
		{/foreach}

        {* <li class="comment">
            <article class="comment_body">
				

				<div class="comment_author vcard">
				    <img alt="" class="avatar avatar-70 photo" height="70" src="http://2.gravatar.com/avatar/597a1e6b0dfdf57f53ef8fb80fa190d7?s=70&d=mm&r=g" width="70">
				</div>
				
				<div class="comment_content">
					
					<div class="comment_meta">
					    <div class="comment_meta_author">
					    	<b class="fn">johny lee</b>
					    </div>
					    <div class="comment_meta_date">
					    	<time datetime="2016-03-07T04:33:23+00:00">
					    	    March 7, 2016 at 4:33 am
					    	</time>
					    </div>
					    <div class="reply">
					        <a aria-label="Reply to raihan@sntbd.com" class="comment-reply-link" href="#" onclick='return addComment.moveForm( "div-comment-3", "3", "respond", "38" )' rel="nofollow">
					            Reply
					        </a>
					    </div>
					</div>


					<div class="comment_content_bottom">
						<p>
							Lorem ipsum dolor sit amet, consectetur adipisicing elit, do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim adminim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip  commodo consequat. Duis aute irure dolor in reprehenderit. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiumod tempor incididunt.
						</p>
					</div>
				    
				</div>
				<!-- .comment-content -->
            </article>

            <ol class="children">
                <li class="comment">

                    <article class="comment_body">
        				
        				<div class="comment_author vcard">
        				    <img alt="" class="avatar avatar-70 photo" height="70" src="http://2.gravatar.com/avatar/597a1e6b0dfdf57f53ef8fb80fa190d7?s=70&d=mm&r=g" width="70">
        				</div>
        				
        				<div class="comment_content">
        					
        					<div class="comment_meta">
        					    <div class="comment_meta_author">
        					    	<b class="fn">johny lee</b>
        					    </div>
        					    <div class="comment_meta_date">
        					    	<time datetime="2016-03-07T04:33:23+00:00">
        					    	    March 7, 2016 at 4:33 am
        					    	</time>
        					    </div>
        					    <div class="reply">
        					        <a aria-label="Reply to raihan@sntbd.com" class="comment-reply-link" href="#" onclick='return addComment.moveForm( "div-comment-3", "3", "respond", "38" )' rel="nofollow">
        					            Reply
        					        </a>
        					    </div>
        					</div>


        					<div class="comment_content_bottom">
        						<p>
        							Lorem ipsum dolor sit amet, consectetur adipisicing elit, do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim adminim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip  commodo consequat. Duis aute irure dolor in reprehenderit. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiumod tempor incididunt.
        						</p>
        					</div>
        				    
        				</div>
        				<!-- .comment-content -->
                    </article>

                    <!-- .comment-body -->
                </li>
                <!-- #comment-## -->
            </ol>
        </li> *}

        <!-- #comment-## -->
    </ol>

    <!-- .comment-list -->
</div>


{* <pre>
{$xipblog_commets|print_r}
</pre> *}