<?php

namespace pocketmine\utils;

use pocketmine\scheduler\WebhookTask;
use pocketmine\Server;

class WebhookSender{
	private $webhookURL, $botName, $avatar;

	public function __construct(string $webhookURL, string $botName, ?string $avatar = null){
		$this->webhookURL = $webhookURL;
		$this->botName = $botName;
		$this->avatar = $avatar;
	}

	public function sendWebhookMessage(string $message) : void{
		Server::getInstance()->getAsyncPool()->submitTask(new WebhookTask(
			$this->webhookURL,
			$message,
			$this->botName,
			$this->avatar
		));
	}
}