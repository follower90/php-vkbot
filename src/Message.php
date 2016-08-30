<?php

class Message
{
	protected $_id;
	protected $_timestamp;
	protected $_readState;
	protected $_userId;
	protected $_chatId;
	protected $_message;

	public function __construct($params)
	{
		$this->_id = $params['mid'];
		$this->_timestamp = $params['date'];
		$this->_readState = $params['read_state'];
		$this->_userId = isset($params['uid']) ? $params['uid'] : null;
		$this->_chatId = isset($params['chat_id']) ? $params['chat_id'] : null;
		$this->_message = $params['body'];
		$this->_out = $params['out'];
	}

	public function userId() { return $this->_userId; }
	public function chatId() { return $this->_chatId; }

	public function isPrivate()
	{
		return $this->_chatId == null;
	}

	public function isIncoming()
	{
		return $this->_out == 0;
	}

	public function getUserId()
	{
		return $this->_userId;
	}

	public function getChatId()
	{
		return $this->_chatId;
	}

	public function getText()
	{
		return $this->_message;
	}

	public function respondToMessage($text)
	{
		$params = [];
		$params['message'] = $text;

		if ($this->isPrivate()) {
			$params['user_id'] = $this->_userId;
		} else {
			$params['chat_id'] = $this->_chatId;
		}

		return $params;
	}
}
