<?php

namespace pocketmine\scheduler;

class WebhookTask extends AsyncTask{
	private $webhookUrl;
	private $message;
	private $botName;
	private $avatar;

	public function __construct(string $webhookUrl, string $message, string $botName, $avatar){
		$this->webhookUrl = $webhookUrl;
		$this->message = $message;
		$this->botName = $botName;
		$this->avatar = $avatar;
	}

	public function onRun() : void{
		$data = [
			'content' => $this->message,
			'username' => $this->botName,
			'avatar_url' => $this->avatar,
		];

		$this->sendRequest($this->webhookUrl, $data);
	}

	private function sendRequest($webhookUrl, $data){
		$ch = curl_init($webhookUrl);

		$payload = json_encode($data);

		curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		$response = curl_exec($ch);

		if(curl_errno($ch)){
			$this->setResult('Error, webhook request failed: ' . curl_error($ch));
		}else{
			$this->setResult($response);
		}

		curl_close($ch);
	}
}
