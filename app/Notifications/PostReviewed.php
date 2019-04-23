<?php
/**
 * LaraClassified - Classified Ads Web Application
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: http://www.bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Post;
use Illuminate\Support\Str;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class PostReviewed extends Notification implements ShouldQueue
{
	use Queueable;
	
	protected $post;
	
	public function __construct(Post $post)
	{
		$this->post = $post;
	}
	
	public function via($notifiable)
	{
		if (!empty($this->post->email)) {
			return ['mail'];
		} else {
			if (config('settings.sms.driver') == 'twilio') {
				return [TwilioChannel::class];
			}
			
			return ['nexmo'];
		}
	}
	
	public function toMail($notifiable)
	{
		$attr = ['slug' => slugify($this->post->title), 'id' => $this->post->id];
		$preview = !isVerifiedPost($this->post) ? '?preview=1' : '';
		$postUrl = lurl($this->post->uri, $attr) . $preview;
		
		return (new MailMessage)
			->subject(trans('mail.post_reviewed_title', ['title' => Str::limit($this->post->title, 50)]))
			->greeting(trans('mail.post_reviewed_content_1'))
			->line(trans('mail.post_reviewed_content_2', [
				'postUrl' => $postUrl,
				'title'   => $this->post->title,
			]))
			->line(trans('mail.post_reviewed_content_3', ['appName' => config('app.name')]));
	}
	
	public function toNexmo($notifiable)
	{
		return (new NexmoMessage())->content($this->smsMessage())->unicode();
	}
	
	public function toTwilio($notifiable)
	{
		return (new TwilioSmsMessage())->content($this->smsMessage());
	}
	
	protected function smsMessage()
	{
		return trans('sms.post_reviewed_content', ['appName' => config('app.name'), 'title' => $this->post->title]);
	}
}
