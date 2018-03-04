<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

//ÄÚ´æ»º´æ
class MemoryCache{
	
	public $emcache;
	
	function __construct(){

	     
	}
	
	public function MemoryCache(){
		 if(S_CACHE_MEMORY_OPEN){
			 
				$memcacheip=empty(PHPAPP::$config['memcacheip'])? '127.0.0.1' : PHPAPP::$config['memcacheip'];
				$memcacheport=empty(PHPAPP::$config['memcacheport'])? '11211' : PHPAPP::$config['memcacheport'];
				
				if(S_CACHE_MEMORY_CONNECT){
				     $this->emcache=memcache_pconnect($memcacheip,$memcacheport);
				}else{
					 $this->emcache=memcache_connect($memcacheip,$memcacheport);
				}
				
		  }
	}


	public function AddCache($key,$value,$flag){ 
		   if(S_CACHE_MEMORY_OPEN){
				@memcache_add($this->emcache,$key,$value,$flag,S_CACHE_TIME); 
		   }
	}
	
	public function GetCache($key){ 
	       if(!S_CACHE_MEMORY_OPEN){
	            return false;
	       }else{
		        return @memcache_get($this->emcache,$key);
	       }
	}
	
	public function FlushCache(){
		   if(!S_CACHE_MEMORY_OPEN){
	            return false;
	       }else{
		        @memcache_flush($this->emcache);
	       }
	}
	 
}

 
?>