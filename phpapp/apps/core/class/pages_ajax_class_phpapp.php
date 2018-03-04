<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

//分页
class AjaxPages extends PHPAPP{

    public $default; 
   
    public $page;  //分页
	
	public $pages; //总分页

	public $total;
	
	public $selectid;
	
	public $jsname;
	
	public $select;
	
	public $order;
	
	public $iforder;
    
	//显示数,页数，DIV识别ID,JS函数名,SQL
	function __construct($default=10,$page=1,$selectid=0,$order=0,$iforder=0,$jsname='',$select){

		$this->default=intval($default); //默认分页数
		$this->page=empty($page)?1:intval($page);
		$this->jsname=$jsname;
		$this->selectid=intval($selectid);
		$this->select=$select;
		$this->sqlorder=intval($order);
		$this->iforder=intval($iforder);
		
	}
	
	function ShowResult(){
		 
	     if($this->page <1) $this->page=1;
	
         if ($result = $this->MysqlQuery($this->select)) {

	          if($this->total = mysql_num_rows($result)){ //统计总记录
	
	             $this->pages=@ceil($this->total/$this->default); //算出分页数
	
	             if($this->page>$this->pages)$this->page=$this->pages;
	
	             $start=$this->default*$this->page-$this->default;
	                  
					  if($this->GetCache($result)){
						  
						   return $this->GetCache($result);
						   
					  }else{
			 
			 
							mysql_data_seek($result,$start);
	  
							$sarray= array();
							$count=0;
							while ($count < $this->default){
								 $sarrayinfo = mysql_fetch_array($result,MYSQL_ASSOC);
								 if($sarrayinfo){
									 $sarray[]=$sarrayinfo;
								 }
								 $count++;
							}
							 
							$this->AddCache($result,$sarray,0);
					  
                            return $sarray;	
					  
					  }
				

              }
	
	
         }

    }
	
    //分页页码
    function ShowPages(){
		
	   $language_page1='首页';
	   $language_page2='上一页';
	   $language_page3='下一页';
	   $language_page4='后页';
	   
	   if($this->pages>1){
		
 	         $showpages='<span>'.$this->page.'/'.$this->pages.'</span>';
	
	         //首页
	         if($this->page!=1){
		        $uppage=$this->page-1;
		        $showpages.="<a href=\"javascript:;\" onclick=\"$this->jsname('$this->selectid','1','$this->sqlorder','$this->iforder');\">$language_page1</a>";
	            $showpages.="<a href=\"javascript:;\" onclick=\"$this->jsname('$this->selectid','$uppage','$this->sqlorder','$this->iforder');\">$language_page2</a>";
             }
			 
	         //开始页
	         $forstart=$this->page-2;
	         if($forstart>0){
		         $forstart=$forstart;
	         }else{
		         $forstart=1;
	         }
	
	        //结束页
	        if($this->page+3 >$this->pages){
		        $forend=$this->page+($this->pages-$this->page+1);
	        }else{
		         if($this->page==1){
		              $forend=$this->page+4;
		         }else{
			          $forend=$this->page+3;
		         }
	        }
	
	        for($i=$forstart;$i<$forend;$i++){
		
		        if($this->page==$i){
			         $showpages.='<strong>'.$i.'</strong>';
		        }else{
			         $showpages.="<a href=\"javascript:;\" onclick=\"$this->jsname('$this->selectid','$i','$this->sqlorder','$this->iforder');\">$i</a>";
		        }
		

	        }
	
	       //最后一页
	       if($this->page!=$this->pages){
		       $nextpages=$this->page+1;
	           $showpages.="<a href=\"javascript:;\" onclick=\"$this->jsname('$this->selectid','$nextpages','$this->sqlorder','$this->iforder');\">$language_page3</a>";
	           $showpages.="<a href=\"javascript:;\" onclick=\"$this->jsname('$this->selectid','$this->pages','$this->sqlorder','$this->iforder');\">$language_page4</a>";
	       }
	
	       return $showpages;
       }
	
	}
	
	
	function GetTotal(){ 
	
	      return $this->total;
	}

}


 

?>