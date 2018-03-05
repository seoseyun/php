<?php
/**
  *@author 서세윤
  *@param int $thisPage = null
  *@param int $totalPage = null
  example
  $pagenation = new Pagination("5","10");
  $Pagination->setTarget("id",$_GET['id']);
  $pagenation->start();
  */
	class Pagination
	{
    private $page,$totalPage,$listCnt,$totalPageLength,$maxPage,$minPage,$linkClass,$linkUrl,$curClass;
    private $pageLength=5;
    private $target;


		function __construct($totalPage = null,$listCnt=null){

			if( is_null($totalPage) ){
				echo "Pagination클래스의 초기화첫번째Param으로 총페이지를 넘겨주세요.";
				return;
				exit;
			}else{
        $this->totalPage = $totalPage;
      }

      if( is_null($listCnt) ){
				echo "Pagination클래스의 초기화두번째Param으로 리스트갯수를 넘겨주세요.";
				return;
				exit;
			}else{
        $this->listCnt = $listCnt;
      }
      $this->setPage();
      $this->dividePage();
      if(empty($this->linkUrl))
        $this->linkUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
      $this->initPageRange();
		}

    function dividePage(){
      $this->totalPageLength = ceil($this->totalPage/$this->listCnt);
    }

    function initPageRange(){
      $this->minPage = (floor($this->page / $this->pageLength)*$this->pageLength)+1;
      if($this->page % $this->pageLength == 0) $this->minPage = $this->minPage-$this->pageLength;
      $this->maxPage = $this->minPage + ($this->pageLength - 1);

      if($this->page <= $this->pageLength){
          $this->minPage = 1;
          $this->maxPage = $this->pageLength;
      }
      if($this->totalPageLength < $this->maxPage)
        $this->maxPage = $this->totalPageLength;
    }

    function makePageList(){
      for($i = $this->minPage ; $i <= $this->maxPage; $i++){
        echo "<a href='{$this->linkUrl}{$this->makeUrlParam($i)}' class='{$this->makeClass($i)}'>".$i."</a>";
      }
    }

    function makeUrlParam($page){
      $str = "?page={$page}&";
      if(!empty($this->target))
        $str .= http_build_query($this->target);
      return $str;
    }

    function makeClass($page){
      $str = $this->linkClass." ";
      if($this->page == $page)
        $str .= $this->curClass;

      return $str;
    }

    function makePrevLink($property,$content){
      if($this->page != 1){

        $minPage = $this->minPage-1;
        if($minPage = 0) $minPage = 0;
        echo "<a href='{$this->linkUrl}{$this->makeUrlParam($minPage)}' {$property}>{$content}</a>";
      }
    }

    function makeNextLink($property,$content){
      if($this->maxPage != $this->totalPageLength)
      echo "<a href='{$this->linkUrl}{$this->makeUrlParam($this->maxPage+1)}' {$property}>{$content}</a>";
    }

    function getMinRownum(){
      return $this->page * $this->listCnt - $this->listCnt + 1;
    }

    function getMaxRownum(){
      return $this->page * $this->listCnt;
    }

    function setPage(){
      $this->page = empty($_GET['page']) || $_GET['page'] < 1 ? "1" : $_GET['page'];
    }

    function setPageLength($page = 5){
      $this->pageLength = $page;
    }

    function setLinkClass($className = null,$curClass = null){
      $this->linkClass = $className;
      $this->curClass = $curClass;
    }

    function setLinkUrl($url = null){
        $this->linkUrl = $url;
    }

    function setTarget($key , $value){
      $this->target[$key] = $value;
    }

		function start(){
      $this->makePageList();
		}
	}
