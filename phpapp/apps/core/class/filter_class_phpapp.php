<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


 // �ַ�����
class CharFilter{
	
    public $strings; 	
	
	function __construct($strings=''){
		$this->strings=$strings;
			 
	}
	 
	//����ַ�������
	function CheckLength($number){
		
	   if(iconv_strlen($this->strings,S_CHARSET) < $number){
		  return true;
	   }else{
		  return false;   
	   }
	}

    function CheckShort ($number){
		
	   if(iconv_strlen($this->strings,S_CHARSET) > $number){
		  return true;
	   }else{
		  return false;   
	   }
	}
	
	//����ַ����Ƿ�ո񡢻س���ʮ�����ơ��˽��Ƶ�
	function CheckSpace(){	
		return preg_match('/[\s]/',$this->strings);  //preg_match ƥ�䷵��Ϊ 1 �� 0
		
	}
	
	//����Ƿ���ĸ
	function IsABC(){	
		return preg_match('/^[a-z]+$/i',$this->strings); 
	}
	
	//�ָ����ַ�������
	function CheckNumber(){
		$this->strings = preg_replace('/[\d]+/','',$this->strings);
		if($this->strings){
		   return false;
		}else{
		   return true;	
		}
	}
	
	//�ָ����ַ��������֡�Ӣ����ĸ
	function CheckSplit(){
		
		$this->strings = preg_replace('/[\w]+/u','',$this->strings);
	
		if($this->strings){
		    return false;
		}else{
		    return true;
		}
	}
	
	//����ַ����Ƿ�Ϊ����
	function CheckLegalString(){
		
		  if(S_CHARSET=='gbk'){
			     $preg='/(8[1-9].+)|(8[A-F].+)|(9[0-9].+)|(9[A-F].+)|(A0.+)|(A[A-F].+)|(B[0-9].+)|(B[A-F].+)|(C[0-9].+)|(C[A-F].+)|(D[0-9].+)|(D[A-F].+)|(E[0-9].+)|(E[A-F].+)|(F[0-9].+)|(F[A-E].+)/'; 
				
				 $this->strings  =str_split($this->strings,'2');
			
				 $allstring  ='';
				 foreach($this->strings as $stringv){
						$allstring.= $this->stringord($stringv).',';
				 }
				 $this->strings  =explode(',',substr($allstring,0,-1));

				 $nostring  ='';
				 foreach($this->strings as $stringlist){
						$nostring .=preg_replace($preg,'',$stringlist);
				 }
		
				 if($nostring){
		 				 return false;
				 }else{
		 				 return true;	
				 }
	
			  
		  }else{
		 
		 
                 if (preg_match("/^[\x{4e00}-\x{9fa5}]+$/u",$this->strings)) {
                      return true;	
                 }else{
                      return false;
                 } 
		  }
	}


	function  stringord($string){  

           $sfusing='';   
           for($i=0;$i<strlen($string);$i++){ 
                $sfusing.=dechex(ord($string[$i]));   
                $sfusing=strtoupper($sfusing);  
	       }
           return  $sfusing;   
    } 
	
	
	function CheckString($instring='',$zh='0'){
	
	   $this->strings=$instring;
		
	       if(!$this->CheckSpace()){
		      
		         if($this->CheckSplit()){
					
		               return true;
				  
			     }else{
				      
					   if($zh){
						     if($this->CheckLegalString()){
				                   return true;
				             }else{
				                   return false;
				             }
					   }else{
						     return false;	   
					   }
			     }
		   
		   
		   }else{
			    return false; 
		   }


  }
  
  function CheckSpecialString($instring=''){
	   $this->strings=$instring;
		
	       if(!$this->CheckSpace()){
				 
		         if(!preg_replace('/([\w]+)|(\!+)|(\@+)|(\#+)|(\$+)|(\%+)|(\^+)|(\&+)|(\*+)|(\-+)|(\_+)|(\?+)/','',$this->strings)){
					
		               return true;
				  
			     }else{
				    
					   return false;	   
			     }
		   
		   
		   }else{
			    return false; 
		   }
	  
	  
  }
  

  //���Email
  function CheckStringEmail($email){
	   
		$this->strings=$email;

		if(filter_var($this->strings,FILTER_VALIDATE_EMAIL)){
	
				if(!preg_replace('/[\w]+|\@|\./','',$this->strings)){

	                 if(preg_match('/([\w]+)(\@)([\w]+)(\.)([\w]+)/',$this->strings)){
					     return true;
				     }else{
						 return false;
		             }
						 
				}else{
				     return false;
				}
	
		 }else{
			  return false;
		 }
		 
					 
  }
  
  
  //���Link
  function CheckLink(){
	    
		$this->strings='http://'.str_replace('http://','',$this->strings);
		
		if(preg_match('/([\w]+)\.([\w]+)/',$this->strings)){
		
			  if(filter_var($this->strings,FILTER_VALIDATE_URL,FILTER_FLAG_HOST_REQUIRED)){
					return true;
			  }else{
					return false;
			  }
			  
		}else{
		
			  return false;
		}
	  
  }
	

	
	
}

?>