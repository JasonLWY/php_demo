<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.8.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

//分页
class Pages extends PHPAPP{

   public $default; 
   
    public $page;  //分页
	
	public $pages; //总分页

	public $total;
	
	public $url;
	
	public $select;
	
	public $html;
	
	function __construct($default=20,$page=0,$url='',$select){
        global $isrewrite,$controls;
		
		$this->default=intval($default); //默认分页数
		
		$this->page=empty($page)?1:intval($page);
		
		if(PHPAPP::$config['setpagemode']==2){
			  $this->pages=intval(PHPAPP::$config['setpagenumber']); 
		}elseif(PHPAPP::$config['setpagemode']==1){
			  $this->pages=intval(PHPAPP::$config['setpagenumber']); 
			  $this->page=intval($page);
			  
			  if($this->page>$this->pages){
					$this->page=$this->pages;
			  }elseif($this->page <1){
					$this->page=0;
			  }
		}
		
		$controls=empty($controls)? '' :$controls;
		
		if(S_REWRITE_URL && @empty($isrewrite)){
			
			 if($controls=='SpaceControls' || $controls=='MainControls'){
				   $url=str_replace('.html','',$url);
				   $this->html='.html';
				   $url = preg_replace("/(\?|&|\=)/",'-',preg_replace("/\.php/",'',$url));
				   $this->url=$url.'-page-';
			 }else{
				   $this->url=$url.'&page=';
			 }
		}else{
		     $this->url=$url.'&page=';
			 $this->html='';
		}
		
		$this->select=$select;
		
	}
	
	function ShowResult(){
		
         if(PHPAPP::$config['setpagemode']==1){
			  
			  if($this->GetCache($this->select)){
				  
					 return $this->GetCache($this->select);
				   
			  }else{
					
					$pages=$this->page*$this->default;
					
					$limit=' LIMIT '.$pages.' , '.$this->default; 
					
					$result = $this->MysqlQuery($this->select.$limit);
  
					$mysqlarray= array();
  
					while ($fetch_array = mysql_fetch_array($result,MYSQL_ASSOC)) {
						   $mysqlarray[] = $fetch_array;
					}
  
					$this->AddCache($result,$mysqlarray,0);
					
					return $mysqlarray;	
			  }
			 
		 }else{
			 
			   if($this->GetCache($this->select)){
								
					return $this->GetCache($this->select);
								 
			   }else{
				    
					$limit='';
				    if(PHPAPP::$config['setpagemode']==2){
						   $pages=$this->pages*$this->default;
						   $limit=' LIMIT 0 ,'.$pages; 
					}
	
			        $result = $this->MysqlQuery($this->select.$limit);
	  
					if($this->total = mysql_num_rows($result)){ //统计总记录
		  
						  $this->pages=@ceil($this->total/$this->default); //算出分页数
		
						  if($this->page>$this->pages)$this->page=$this->pages;
		
						  $start=$this->default*$this->page-$this->default;

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
						   
						  $this->AddCache($this->select,$sarray,0);
						  
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
		
 	         //$showpages='<span>'.$this->page.'/'.$this->pages.'</span>';
			 $showpages='';
	
	         //首页
	         if($this->page!=1){
		        $uppage=$this->page-1;
		        $showpages.='<a href="'.$this->url.'1'.$this->html.'">'.$language_page1.'</a>';
	            $showpages.='<a href="'.$this->url.$uppage.$this->html.'">'.$language_page2.'</a>';
             }
	
	         //开始页
	         $forstart=$this->page-5;
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
		            $forend=$this->page+6;
		         }else{
			        $forend=$this->page+5;
		         }
	        }
	
	        for($i=$forstart;$i<$forend;$i++){
		
		        if($this->page==$i){
			         $showpages.='<strong>'.$i.'</strong>';
		        }else{
			         $showpages.='<a href="'.$this->url.$i.$this->html.'">'.$i.'</a>';
		        }
		

	        }
	
	       //最后一页
	       if($this->page!=$this->pages){
		       $nextpages=$this->page+1;
	           $showpages.='<a href="'.$this->url.$nextpages.$this->html.'">'.$language_page3.'</a>';
	           $showpages.='<a href="'.$this->url.$this->pages.$this->html.'">'.$language_page4.'</a>';
	       }
	
	       return $showpages;
       }
	
	}
	
	function GetShowNum(){
	       return  $this->total;
	}

	

}


 

?>