<?php

class VkApi
{
	private $_params = [];

	public static function configure($params)
	{
		$api = new self();
		$api->_params = $params;

		return $api;
	}

	public function getLastUnreadMessages($interval)
	{
		return $this->_request('messages.get', ['time_offset' => $interval]);
	}

	public function sendMessage($params)
	{
		$this->_request('messages.send', $params);
	}


	private function _request($method, $params)
	{
		$url = 'https://api.vk.com/method/' . $method . '?' . http_build_query(
				array_merge($params, ['access_token' => $this->_params['token'], $this->_params['lang']]));

		$options = array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER => array('Content-type: application/json')
		);

		$ch = curl_init($url);
		curl_setopt_array($ch, $options);
		$result = curl_exec($ch);

		return $this->_response($result);
	}

	private function _response($result)
	{
		$result = json_decode($result, true);

		if (isset($result['error'])) {
			throw new Exception($result['error']['error_msg'], 1);
		}

		return $result['response'];
	}
}
