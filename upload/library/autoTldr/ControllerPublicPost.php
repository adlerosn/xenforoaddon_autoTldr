<?php

class autoTldr_ControllerPublicPost extends XFCP_autoTldr_ControllerPublicPost{
	public static function getTldrFromBBCode($string){
		$parser = XenForo_BbCode_Parser::create(XenForo_BbCode_Formatter_Base::create('XenForo_BbCode_Formatter_Text'));
		return self::getTldr($parser->render($string));
	}
	public static function getTldr($text){
		$textSummarizer = new autoTldr_Summarizer();
		$textSummarized = $textSummarizer->get_summary($text);
		$statSummarized = $textSummarizer->how_we_did();
		$summarized = array(
			'source' =>$text,
			'text'   =>$textSummarized,
			'stats'  =>$statSummarized,
			'ratio'  =>$statSummarized['ratio'],
			'smaller'=>intval($statSummarized['ratio']),
		);
		return $summarized;
	}
	
	public function actionTldr(){
		$postId = $this->_input->filterSingle('post_id', XenForo_Input::UINT);

		$ftpHelper = $this->getHelper('ForumThreadPost');
		list($post, $thread, $forum) = $ftpHelper->assertPostValidAndViewable($postId,  array(
			'join' => XenForo_Model_Post::FETCH_USER
		));
		$visitor = XenForo_Visitor::getInstance();
		$errorPhraseKey = 'no_permission_to_post';
		if (!$this->_getPostModel()->canViewPost($post, $thread, $forum, $errorPhraseKey,
			$visitor->getNodePermissions($forum['node_id']), $visitor->toArray()))
		{
			throw $this->getErrorOrNoPermissionResponseException($errorPhraseKey);
		}
				
		$viewParams = array(
			'forum' => $forum,
			'thread' => $thread,
			'post' => $post,
			'message' => $post['message'],
			'nodeBreadCrumbs' => $ftpHelper->getNodeBreadCrumbs($forum),
		);

		return $this->responseView('autoTldr_ViewPublicPostTldr', 'post_tldr', $viewParams);
	}
}
