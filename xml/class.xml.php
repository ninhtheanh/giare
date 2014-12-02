<?php
class XML{

	var $xml;
	var $root;
	var $list;
	var $deal;

	public function __construct(){
		$this->xml=new DOMDocument("1.0","utf-8");
		header("Content-Type: text/xml;charset=utf-8",true);
		$this->root=$this->xml->createElement("Deals");
		$this->xml->appendChild($this->root);
		$this->list=$this->xml->createElement("Lists");
		$this->root->appendChild($this->list);
	}

	public function createXml(){
		echo $this->xml->saveXML();
	}

	public function createChild(){
		$this->deal=$this->xml->createElement("Deal");
		$this->list->appendChild($this->deal);
	}

	function createTextNode($child,$content)
	{
		$url=$this->xml->createElement($child);
		$this->deal->appendChild($url);
		$textUrl=$this->xml->createTextNode($content);
		return $url->appendChild($textUrl);
	}

	function createBody($data){
		$this->createChild();
		foreach($data as $k=>$v)
		{
			$this->createTextNode($k,$v);
		}
	}

}