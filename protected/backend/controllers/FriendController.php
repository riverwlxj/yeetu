<?php
class FriendController extends AController
{
	
	public function filters() {
		return array(
		  'accessControl', // perform access control for CRUD operations
		);
	}
	
	
	public function actions()
	{
		$path = 'application.backend.controllers.friend.';
		return array(
			'index'=> $path.'IndexAction',
			'add'=> $path.'AddAction',
			'delete'=> $path.'DeleteAction',
		);
	}

	public function f($msg_code){ 
		if($msg_code == CV::SUCCESS_ADMIN_OPERATE){
			$this->sf("操作成功");
		}
		if($msg_code == CV::FAILED_ADMIN_OPERATE){
			$this->ff("操作失败");
		}
		if($msg_code == CV::ERROR_ADMIN_DATABASE){
			$this->ff("操作数据库错误");
		}
	}
}
