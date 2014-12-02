<?php
/*
               -+=#*^  BAD  SYNTAX  ^*@#=+-
                   LEETWOLF + FLIPMODE!
              INTERSPIRE EMAIL MARKETER 6.0.0
*/


abstract class Interspire_Validator_Abstract
{
	public 
		$value        = null,
		$errorMessage = null;
	
	abstract public function isValid();
}