<?php
/*
               -+=#*^  BAD  SYNTAX  ^*@#=+-
                   LEETWOLF + FLIPMODE!
              INTERSPIRE EMAIL MARKETER 6.0.0
*/


class Interspire_Validator_Uri extends Interspire_Validator_Abstract
{
	public function isValid()
	{
		return preg_match('/http:\/\/(www\.)(.+)\.(.+)/', $this->value);
	}
}