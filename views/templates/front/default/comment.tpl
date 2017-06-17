
<div class="comment_respond clearfix m_bottom_50" id="respond">
    <h3 class="comment_reply_title" id="reply-title">
        Leave a Reply
        <small>
            <a href="/wp_showcase/wp-supershot/?p=38#respond" id="cancel-comment-reply-link" rel="nofollow" style="display:none;">
                Cancel reply
            </a>
        </small>
    </h3>
    <form class="comment_form" action="" method="post" id="xipblogs_commentfrom" role="form" data-toggle="validator">
    	<div class="form-group xipblogs_message"></div>
    	<div class="form-group xipblog_name_parent">
    	  <label for="xipblog_name">Your Name:</label>
    	  <input type="text"  id="xipblog_name" name="xipblog_name" class="form-control xipblog_name" required>
    	</div>
    	<div class="form-group xipblog_email_parent">
    	  <label for="xipblog_email">Your Email:</label>
    	  <input type="email"  id="xipblog_email" name="xipblog_email" class="form-control xipblog_email" required>
    	</div>
    	<div class="form-group xipblog_website_parent">
    	  <label for="xipblog_website">Website Url:</label>
    	  <input type="url"  id="xipblog_website" name="xipblog_website" class="form-control xipblog_website">
    	</div>
    	<div class="form-group xipblog_subject_parent">
    	  <label for="xipblog_subject">Subject:</label>
    	  <input type="text"  id="xipblog_subject" name="xipblog_subject" class="form-control xipblog_subject" required>
    	</div>
    	<div class="form-group xipblog_content_parent">
    	  <label for="xipblog_content">Comment:</label>
    	  <textarea rows="15" cols="" id="xipblog_content" name="xipblog_content" class="form-control xipblog_content" required></textarea>
    	</div>
    	<input type="hidden" class="xipblog_id_parent" id="xipblog_id_parent" name="xipblog_id_parent" value="0">
    	<input type="hidden" class="xipblog_id_post" id="xipblog_id_post" name="xipblog_id_post" value="{$xipblogpost.id_xipposts}">
    	<input type="submit" class="btn btn-info pull-left xipblog_submit_btn" value="Submit Button">
    </form>


    {* <form action="http://localhost/wp_showcase/wp-supershot/wp-comments-post.php" class="comment-form" id="commentform" method="post" novalidate="">
        <p class="comment-notes">
            <span id="email-notes">
                Your email address will not be published.
            </span>
            Required fields are marked
            <span class="required">
                *
            </span>
        </p>
        <p class="comment-form-comment">
            <label for="comment">
                Comment
            </label>
            <textarea aria-required="true" cols="45" id="comment" name="comment" required="required" rows="8">
            </textarea>
        </p>
        <p class="comment-form-author">
            <label for="author">
                Name
                <span class="required">
                    *
                </span>
            </label>
            <input aria-required="true" id="author" name="author" required="required" size="30" type="text" value=""/>
        </p>
        <p class="comment-form-email">
            <label for="email">
                Email
                <span class="required">
                    *
                </span>
            </label>
            <input aria-describedby="email-notes" aria-required="true" id="email" name="email" required="required" size="30" type="email" value=""/>
        </p>
        <p class="comment-form-url">
            <label for="url">
                Website
            </label>
            <input id="url" name="url" size="30" type="url" value=""/>
        </p>
        <p class="form-submit">
            <input class="submit" id="submit" name="submit" type="submit" value="Post Comment">
                <input id="comment_post_ID" name="comment_post_ID" type="hidden" value="38">
                    <input id="comment_parent" name="comment_parent" type="hidden" value="0">
                    </input>
                </input>
            </input>
        </p>
    </form> *}

</div>
<!-- #respond -->




<script type="text/javascript">
$('.xipblog_submit_btn').on("click",function(e) {
	e.preventDefault();
	var data = new Object();
	$('[id^="xipblog_"]').each(function()
	{
		id = $(this).prop("id").replace("xipblog_", "");
		data[id] = $(this).val();
	});
	// data['id_post'] = {$xipblogpost.id_xipposts};
	function logErrprMessage(element, index, array) {
	  $('.xipblogs_message').append('<span class="xipblogs_error">'+element+'</span>');
	}
	function xipremove() {
	  $('.xipblogs_error').remove();
	  $('.xipblogs_success').remove();
	}
	function logSuccessMessage(element, index, array) {
	  $('.xipblogs_message').append('<span class="xipblogs_success">'+element+'</span>');
	}
	$.ajax({
		url: baseDir + 'modules/xipblog/ajax.php',
		data: data,
		type:'post',
		dataType: 'json',
		beforeSend: function(){
			xipremove();
			$(".xipblog_submit_btn").val("Please wait..");
			$(".xipblog_submit_btn").addClass("disabled");
		},
		complete: function(){
			$(".xipblog_submit_btn").val("Submit Button");
			$(".xipblog_submit_btn").removeClass("disabled");	
		},
		success: function(data){
			xipremove();
			if(typeof data.success != 'undefined'){
				data.success.forEach(logSuccessMessage);
			}
			if(typeof data.error != 'undefined'){
				data.error.forEach(logErrprMessage);
			}
			
		},
		error: function(data){
			xipremove();
			$('.xipblogs_message').append('<span class="error">Something Wrong ! Please Try Again. </span>');
		},
	});	
});
</script>