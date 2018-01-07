<?php

class autoTldr_ControllerPublicPostListener {
	public static function callback($class, array &$extend){
		$baseClass = 'XenForo_ControllerPublic_Post';
		$toExtend = 'autoTldr_ControllerPublicPost';
		if($class==$baseClass && !in_array($toExtend, $extend)){
			$extend[]=$toExtend;
		}
	}
}
