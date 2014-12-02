<?php
/*
               -+=#*^  BAD  SYNTAX  ^*@#=+-
                   LEETWOLF + FLIPMODE!
              INTERSPIRE EMAIL MARKETER 6.0.0
*/


class Interspire_Validator_Required extends Interspire_Validator_Abstract
{
	public function isValid()
	{
		return (bool) $this->value;
	}
}