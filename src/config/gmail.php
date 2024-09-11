<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Gmail Configuration
	|--------------------------------------------------------------------------
	|
	|
	|
	|  Scopes Available:
	|
	|   * all - Read, send, delete, and manage your email
	|   * compose - Manage drafts and send emails
	|   * insert - Insert mail into your mailbox
	|   * labels - Manage mailbox labels
	|   * metadata - View your email message metadata such as labels and headers, but not the email body
	|   * modify - View and modify but not delete your email
	|   * readonly - View your email messages and settings
	|   * send - Send email on your behalf
	|   * settings_basic - Manage your basic mail settings
	|   * settings_sharing - Manage your sensitive mail settings, including who can manage your mail
	|
	|   Leaving the scopes empty fill use readonly
	|
	*/

	'project_id' => env('GOOGLE_GMAIL_PROJECT_ID'),
	'client_id' => env('GOOGLE_GMAIL_CLIENT_ID'),
	'client_secret' => env('GOOGLE_GMAIL_CLIENT_SECRET'),
	'redirect_url' => env('GOOGLE_GMAIL_REDIRECT_URI_DEFAULT', '/'),

	'state' => null,

	'scopes' => [
		'readonly',
		'modify',
	],

	/*
	|--------------------------------------------------------------------------
	| Additional Scopes [URL Style]
	|--------------------------------------------------------------------------
	|
	|   'additional_scopes' => [
	|        'https://www.googleapis.com/auth/drive',
	|        'https://www.googleapis.com/auth/documents'
	|   ],
	|
	|
	*/

	'additional_scopes' => [

	],

	'access_type' => 'offline',

	'approval_prompt' => 'force',

	'prompt' => '',
];
