<?php
class AddtraveareaAction extends BaseAction{
  protected function beforeAction(){
     $this->controller->init_travearea_page();
     return true;
  }
  protected function do_action(){	
		$id=$_REQUEST['id'];
		$trave_id=$_REQUEST['trave_id'];
		$model=new Travearea;
		if(!empty($id)){
			 $this->controller->bc(array("跟团游"=>array('group/index'),"修改跟团游景区"));
			 $model=$model->get_table_datas($id,array());
		}else{
			$this->controller->bc(array("跟团游"=>array('group/index'),"增加跟团游景区"));
		}
		$model->trave_id=$trave_id;
		$this->display('add_trave_area',array('model'=>$model));
  } 
}
?>
