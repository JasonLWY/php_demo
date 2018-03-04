<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

//自动执行
class AUTO extends PHPAPP{

    private $run; 
	
	function __construct(){

	}
	
	public function SetAutoRun($run=array()){
			
		 		//生成自动代码
				$runcode=serialize($run);	

				return $this->Insert('autorun',array('appid'=>$run['app'],'runcode'=>$runcode,'runtime'=>$run['runtime']),array());
	
	}
	
    public function Run(){
		
		     @set_time_limit(0);
             @ignore_user_abort(TRUE);
			
		     $runarray=$this->GetMysqlArray('*'," ".$this->GetTable('autorun')." WHERE ".$this->NowTime()." > runtime ");
			 
			 if($runarray){
				 
				     foreach($runarray as $item){
						      
							 $appclass=$this->GetMysqlOne('*'," ".$this->GetTable('apps')." WHERE id_phpapp='$item[appid]'");
							  
							 $appclassfile=SYS.'/apps/'.$appclass['dir_phpapp'].'/class/autorun_class_phpapp.php';
							 
							 if(file_exists($appclassfile)){
			                            
										require_once($appclassfile);

										$value=unserialize($item['runcode']);
										
										$function=$value['function'];
                                        
										$classname=$appclass['class_phpapp'].'AutoControls';
										
										$control = new $classname($value);
										
										$control->$function();

										$this->Delete('autorun'," WHERE aid='$item[aid]'");
						                  
							 }
						   

					 }
			 }
		
	}

}
	

 
?>