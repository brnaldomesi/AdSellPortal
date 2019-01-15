<?php
try {
	
	\File::deleteDirectory(app_path('Mail/'));
	\File::deleteDirectory(base_path('resources/assets/'));
	\File::deleteDirectory(base_path('resources/views/emails/'));
	
	if (\Jackiedo\DotenvEditor\Facades\DotenvEditor::keyExists('QUEUE_DRIVER')) {
		\Jackiedo\DotenvEditor\Facades\DotenvEditor::deleteKey('QUEUE_DRIVER');
	}
	if (\Jackiedo\DotenvEditor\Facades\DotenvEditor::keyExists('SESSION_LIFETIME')) {
		\Jackiedo\DotenvEditor\Facades\DotenvEditor::deleteKey('SESSION_LIFETIME');
	}
	\Jackiedo\DotenvEditor\Facades\DotenvEditor::setKey('QUEUE_CONNECTION', 'sync');
	\Jackiedo\DotenvEditor\Facades\DotenvEditor::setKey('SESSION_LIFETIME', 10080);
	\Jackiedo\DotenvEditor\Facades\DotenvEditor::save();
	
} catch (\Exception $e) {}
