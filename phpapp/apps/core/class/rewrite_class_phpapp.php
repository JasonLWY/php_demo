<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

//Rewrite
class RewriteFormat extends PHPAPP{
	
	
	function __construct(){
		
	}
	
	public function MakeRewrite($rewritedir='/'){
            

			 $rewritearray=$this->GetMysqlArray('*'," ".$this->GetTable('rewrite')." WHERE status_phpapp=0 ORDER BY displayorder_phpapp ASC");
			 
			 $apacherewrite=$nginxrewrite=$iisrewrite=$iis7rewrite=array();
			 
			 if($rewritearray){
			        
				   foreach($rewritearray as $value){
					   
						 if($value['original_phpapp'] && $value['format_phpapp']){
							   
							   $original=$this->MakeOriginalRewrite($value['original_phpapp']);
			
							   $format=$this->MakeFormatRewrite($value['format_phpapp']);
							   
							   //Apache
							   $apacherewrite[]='RewriteRule ^'.$format.'$ '.str_replace('.php?','\.php\?',$original).' [L]';
							   
							   //Nginx
							   $nginxrewrite[]='rewrite ^'.$rewritedir.$format.'$ '.$rewritedir.$original.' last;';
							   
							   //IIS
							   $iisrewrite[]='RewriteRule ^'.$rewritedir.$format.'$ '.$rewritedir.str_replace('.php?','\.php\?',$original).' [L]';
							   

$original=$this->MakeOriginalRewriteIIS7($value['original_phpapp']);
//IIS7
$iis7rewrite[]='<rule name="'.$value['name_phpapp'].'">
		<match url="^'.$rewritedir.'*'.$format.'\?*(.*)$" />
		<action type="Rewrite" url="'.$rewritedir.str_replace('.php?','.php\?',$original).'" />
</rule>';                       


						 }
				   }
				   
				   
					 
				   return array('apache'=>$apacherewrite,'nginx'=>$nginxrewrite,'iis'=>$iisrewrite,'iis7'=>$iis7rewrite);
				   
			 }else{
				 
				   return false;
				 
			 }
			
		
	}
	
	public function MakeOriginalRewrite($original){
		
		        $original=str_replace('{and}','&',$original);

			    $original=str_replace('{all}','{R}$',$original);
				
				$original=str_replace('{abc}','{R}$',$original);
				
				$original=str_replace('{number}','{R}$',$original);
				

                $num=preg_match_all('/\$/',$original,$rewritearray);
			    
				if($num){
				      
					  for($i=1;$i<=$num;$i++){
						  
						    $original=preg_replace('/\$/',$i,$original,1);
						  
					  }
	
				}
				
				$original=str_replace('{R}','$',$original);

				return $original;
		
	}
	
	
	public function MakeFormatRewrite($format){
		
	           $format=str_replace('.','\.',$format);
						 
			   $format=str_replace('{all}','(.*)',$format);
	  
			   $format=str_replace('{abc}','(\w+)',$format);
	  
			   $format=str_replace('{number}','([0-9]+)',$format);
			   
			   return $format;
						 
	}
	
	
	public function MakeOriginalRewriteIIS7($original){
		
		        $original=str_replace('{and}','&amp;',$original);

			    $original=str_replace('{all}','{R:$}',$original);
				
				$original=str_replace('{abc}','{R:$}',$original);
				
				$original=str_replace('{number}','{R:$}',$original);
				

                $num=preg_match_all('/\$/',$original,$rewritearray);
			    
				if($num){
				      
					  for($i=1;$i<=$num;$i++){
						  
						    $original=preg_replace('/\$/',$i,$original,1);
						  
					  }
	
				}

				return $original;
		
	}

	 
}

 
?>