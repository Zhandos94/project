<?php
/**
 * User: BADI
 * DateTime: 14.09.2016 18:30
 */
return [
	'params' => [
		'comment_url' => 'http://test-front.kz/comments/',
		'news_group' => 1,
		'comment_group' => 2,
		'article_group' => 3,
		'error_codes' => [
			'ok' => 'ok',
			'cn_e001' => 'could not load the data model of the form',
			'cn_e002' => 'data form did not pass validation',
			'cn_e003' => 'not transferred or not true (parent_id, group_id) or there is no entry in the table ref_comments_group_id',
			'cn_e004' => 'don\'t save model',
			'cn_e005' => 'not hash',
			'cn_e006' => 'is not a valid word - obscene',
			'cn_e007' => 'catch Exception',
		],
	],
];
