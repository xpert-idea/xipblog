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
    	<input type="submit" class="btn btn-default pull-left xipblog_submit_btn" value="Submit Button">
    </form>
</div>
{xipblog_js name="single_comment_form"}
<script type="text/javascript">
// disabled
$('.xipblog_submit_btn').on("click",function(e) {
	e.preventDefault();
	if(!$(this).hasClass("disabled")){
		var data = new Object();
		$('[id^="xipblog_"]').each(function()
		{
			id = $(this).prop("id").replace("xipblog_", "");
			data[id] = $(this).val();
		});
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
			url: xprt_base_dir + 'modules/xipblog/ajax.php',
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
	}
});
</script>
{/xipblog_js}