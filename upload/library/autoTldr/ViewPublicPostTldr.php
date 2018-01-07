<?php

class autoTldr_ViewPublicPostTldr extends XenForo_ViewPublic_Base
{
	public function renderHtml()
	{
		$bbCodeParser = XenForo_BbCode_Parser::create(XenForo_BbCode_Formatter_Base::create('Base', array('view' => $this)));
		$this->_params['messageParsed'] = strval(new XenForo_BbCode_TextWrapper($this->_params['message'], $bbCodeParser));
		$bbCodeParser = XenForo_BbCode_Parser::create(XenForo_BbCode_Formatter_Base::create('Text', array('view' => $this)));
		$this->_params['messageBrute'] = strval(new XenForo_BbCode_TextWrapper($this->_params['message'], $bbCodeParser));
		$this->_params['summarized'] = autoTldr_ControllerPublicPost::getTldr($this->_params['messageBrute']);
	}
}
