<?php

class Api
{
	private $_params = [];
	private static $_instance = null;

	public static function configure($params)
	{
		$api = new self();
		$api->_params = $params;

		self::$_instance = $api;
		return self::$_instance;
	}

	public static function getInstance()
	{
		return self::$_instance;
	}

	public function getLastUnreadMessages($interval)
	{
		$data = $this->_request('messages.get', ['time_offset' => $interval]);
		array_shift($data);
		return $data;
	}

	public function getUserInfo($id)
	{
		return $this->_request('users.get', ['user_ids' => $id]);
	}

	public function getChatInfo($id)
	{
		return $this->_request('messages.getChat', ['chat_id' => $id]);
	}

	public function sendMessage($params)
	{
		$this->_request('messages.send', $params);
	}

	public function getUserName($id)
	{
		$user = $this->getUserInfo($id);
		return $user[0]['first_name'] . ' ' . $user[0]['last_name'];
	}

	public function getChatName($id)
	{
		$chat = $this->getChatInfo($id);
		return $chat['title'];
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
