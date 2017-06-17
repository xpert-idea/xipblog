<?php

// start tab general
$this->fields_form[]['form'] = array(
	'tinymce' => true,
    'legend' => array(
        'title' => $this->l('General Setting'),
    ),
    'input' => array(
        array(
            'type' => 'text',
            'label' => $this->l('Meta Title'),
            'desc' => $this->l('Inser Blog Meta Title'),
            'name' => 'meta_title',
            'default_val' => 'Blog Title',
        ),
        array(
            'type' => 'tags',
            'label' => $this->l('Meta Keyword'),
            'desc' => $this->l('Inser Blog Meta Keyword'),
            'name' => 'meta_keyword',
            'default_val' => 'Blog,xipblog',
        ),
        array(
        	'type' => 'textarea',
        	'label' => $this->l('Meta Description'),
        	'name' => 'meta_description',
            'desc' => $this->l('Please Input Meta Description'),
        	'default_val' => 'Meta Description',
        ),
        array(
            'type' => 'select',
            'label' => $this->l('Select Blog Template'),
            'name' => 'theme_name',
            'default_val' => 'default',
            'options' => array(
                'query' => xipblog::GetAllThemes(),
                'id' => 'id',
                'name' => 'name'
            ),
        ),
        array(
            'type' => 'text',
            'label' => $this->l('Blog Posts Per Page'),
            'desc' => $this->l('Please Enter How many Blog Post Display Per Page'),
            'name' => 'post_per_page',
            'class' => 'fixed-width-sm',
            'default_val' => '20',
        ),
        array(
            'type' => 'select',
            'label' => $this->l('Select Left/Right Column'),
            'name' => 'column_use',
            'default_val' => 'default_ps',
            'desc' => 'Which Column Do you want to use. displayleftcolumn,displayrightcolumn or displayxipblogleft,displayxipblogright column hook.',
            'options' => array(
                'query' => array(
                		array(
                			'id' => 'default_ps',
                			'name' => 'Default Prestashop Column',
                		),
                		array(
                			'id' => 'own_ps',
                			'name' => 'Xipblog Own Column',
                		),
                	),
                'id' => 'id',
                'name' => 'name'
            ),
        ),
        array(
			'type' => 'switch',
			'label' => $this->l('Auto Comment Approved'),
			'name' => 'comment_approved',
            'default_val' => '1',
			'values' => array(
                array(
                    'id' => 'active',
                    'value' => 1,
                    'label' => $this->l('Enabled')
                ),
                array(
                    'id' => 'active',
                    'value' => 0,
                    'label' => $this->l('Disabled')
                )
            ),
        ),
        array(
			'type' => 'switch',
			'label' => $this->l('Enable Blog Comments'),
			'name' => 'disable_blog_com',
            'default_val' => '1',
			'values' => array(
                array(
                    'id' => 'active',
                    'value' => 1,
                    'label' => $this->l('Enabled')
                ),
                array(
                    'id' => 'active',
                    'value' => 0,
                    'label' => $this->l('Disabled')
                )
            ),
        ),
    ),
    'submit' => array(
        'title' => $this->l('Save'),
        'class' => 'btn btn-default pull-right'
    )
);

$this->fields_form[]['form'] = array(
	'tinymce' => true,
    'legend' => array(
        'title' => $this->l('URL Setting'),
    ),
    'input' => array(
        array(
            'type' => 'text',
            'label' => $this->l('Main Blog Url'),
            'desc' => $this->l('Inser Main Blog Url'),
            'name' => 'main_blog_url',
            'prefix' => 'http://domain.com/',
            'suffix' => '.html',
            'default_val' => 'xipblog',
            'class' => 'fixed-width-sm',
        ),
        array(
            'type' => 'text',
            'label' => $this->l('Category Blog Url'),
            'desc' => $this->l('Inser Category Blog Url'),
            'name' => 'category_blog_url',
            'prefix' => 'http://domain.com/blog/',
            'suffix' => '/1_rewrite.html',
            'default_val' => 'category',
            'class' => 'fixed-width-sm',
        ),
        array(
            'type' => 'text',
            'label' => $this->l('Single Blog Url'),
            'desc' => $this->l('Inser Single Blog Url'),
            'name' => 'single_blog_url',
            'prefix' => 'http://domain.com/blog/',
            'suffix' => '/1_rewrite.html',
            'default_val' => 'post',
            'class' => 'fixed-width-sm',
        ),
        array(
            'type' => 'text',
            'label' => $this->l('Tag Blog Url'),
            'desc' => $this->l('Inser Tag Blog Url'),
            'name' => 'tag_blog_url',
            'prefix' => 'http://domain.com/blog/',
            'suffix' => '/1_rewrite.html',
            'default_val' => 'tag',
            'class' => 'fixed-width-sm',
        ),
        array(
			'type' => 'radio',
			'label' => $this->l('Url Format'),
			'name' => 'url_format',
            'default_val' => 'preid_seo_url',
			'values' => array(
				array(
					'id' => 'default_seo_url',
					'value' => 'default_seo_url',
					'label' => $this->l('Default SEO Friendly: http://domain.com/module/xipblog/single/?id_post=1'),
				),
				array(
					'id' => 'preid_seo_url',
					'value' => 'preid_seo_url',
					'label' => $this->l('URL Format: http://domain.com/blog/post/1_rewrite/'),
				),
				array(
					'id' => 'postid_seo_url',
					'value' => 'postid_seo_url',
					'label' => $this->l('URL Format: http://domain.com/blog/post/rewrite_1/'),
				),
				array(
					'id' => 'wthotid_seo_url',
					'value' => 'wthotid_seo_url',
					'label' => $this->l('URL Format: http://domain.com/blog/post/rewrite/'),
				),
			),
        ),
        array(
			'type' => 'radio',
			'label' => $this->l('Enable Use .html'),
			'name' => 'postfix_url_format',
            'default_val' => 'enable_html',
			'values' => array(
				array(
					'id' => 'enable_html',
					'value' => 'enable_html',
					'label' => $this->l('Enable .html URL format.'),
				),
				array(
					'id' => 'disable_html',
					'value' => 'disable_html',
					'label' => $this->l('Disable .html URL format.'),
				),
			),
        ),
    ),
    'submit' => array(
        'title' => $this->l('Save'),
        'class' => 'btn btn-default pull-right',
    )
);


// Blog style
$this->fields_form[]['form'] = array(
	'tinymce' => true,
  	'legend' => array(
  	'title' => $this->l('Blog style'),
    ),
    'input' => array(
        array(
            'type' => 'select',
            'label' => $this->l('Blog style'),
            'name' => 'blog_style',
            'default_val' => 'default',
            'data_by_demo' => array(
            	'demo_1' => 'default',
            	'demo_2' => 'default',
            	'demo_3' => 'column',
            ),
            'desc' => $this->l('Choose blog style Default/Grid'),
            'options' => array(
            	'id' => 'id',
            	'name' => 'name',
            	'query' => array(
            		array(
            			'id' => 'default',
            			'name' => 'Default'
            			),
            		array(
            			'id' => 'column',
            			'name' => 'Column'
            			),
            		)
            	)
        ),
        array(
            'type' => 'select',
            'label' => $this->l('Blog no of column'),
            'name' => 'blog_no_of_col',
            'default_val' => '2',
            'data_by_demo' => array(
            	'demo_1' => '4',
            	'demo_2' => '4',
            	'demo_3' => '6',
            ),
            'desc' => $this->l('Choose blog gird style no of column'),
            'options' => array(
            	'id' => 'id',
            	'name' => 'name',
            	'query' => array(
            		array(
            			'id' => '2',
            			'name' => 'Two column'
            			),
            		array(
            			'id' => '3',
            			'name' => 'Three column'
            			),
            		array(
            			'id' => '4',
            			'name' => 'Four column'
            			),
            		)
            	)
        ),
    ),
    'submit' => array(
        'title' => $this->l('Save'),
        'class' => 'btn btn-default pull-right'
    )
);

// Blog style
$this->fields_form[]['form'] = array(
	'tinymce' => true,
  	'legend' => array(
  	'title' => $this->l('Display Home Style'),
    ),
    'input' => array(
        array(
			'type' => 'text',
			'label' => $this->l('Title'),
			'name' => 'xipbdp_title',
            'default_val' => 'News',
			'lang' => true,
		),
        array(
			'type' => 'text',
			'label' => $this->l('Sub Title'),
			'name' => 'xipbdp_subtext',
            'default_val' => 'All Recent Posts From XipBlog',
			'lang' => true,
		),
		array(
			'type' => 'text',
			'label' => $this->l('How Many Post You Want To Display'),
			'name' => 'xipbdp_postcount',
            'default_val' => 4,
		),
		array(
	        'type' => 'select',
	        'label' => $this->l('Select number of column to display'),
	        'name' => 'xipbdp_numcolumn',
            'default_val' => 3,
	        'options' => array(
	            'query' => array(
	            		array(
	            			'id' => '1',
	            			'name' => '1 column',
	            		),
	            		array(
	            			'id' => '2',
	            			'name' => '2 column',
	            		),
	            		array(
	            			'id' => '3',
	            			'name' => '3 column',
	            		),
	            		array(
	            			'id' => '4',
	            			'name' => '4 column',
	            		),
	            	),
	            'id' => 'id',
	            'name' => 'name'
	        )
	    ),
	    array(
            'type' => 'select',
            'label' => $this->l('Select Design Layout'),
            'name' => 'xipbdp_designlayout',
            'default_val' => 'general',
            'options' => array(
                'query' => array(
                		array(
                			'id' => 'general',
                			'name' => 'General',
                		),
                		array(
                			'id' => 'classic',
                			'name' => 'Classic',
                		),
                		array(
                			'id' => 'creative',
                			'name' => 'Creative',
                		),
                	),
                'id' => 'id',
                'name' => 'name'
            )
        ),
    ),
    'submit' => array(
        'title' => $this->l('Save'),
        'class' => 'btn btn-default pull-right'
    )
);
