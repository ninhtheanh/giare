<?php
/*
               -+=#*^  BAD  SYNTAX  ^*@#=+-
                   LEETWOLF + FLIPMODE!
              INTERSPIRE EMAIL MARKETER 6.0.0
*/

// +--------------------------------------------------------------------------+
// | Image_Graph aka GraPHPite                                                |
// +--------------------------------------------------------------------------+
// | Copyright (C) 2003, 2004 Jesper Veggerby Hansen                          |
// | Email         pear.nosey@veggerby.dk                                |
// | Web           http://graphpite.sourceforge.net                           |
// | PEAR          http://pear.php.net/pepr/pepr-proposal-show.php?id=145     |
// +--------------------------------------------------------------------------+
// | This library is free software; you can redistribute it and/or            |
// | modify it under the terms of the GNU Lesser General Public               |
// | License as published by the Free Software Foundation; either             |
// | version 2.1 of the License, or (at your option) any later version.       |
// |                                                                          |
// | This library is distributed in the hope that it will be useful,          |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of           |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU        |
// | Lesser General Public License for more details.                          |
// |                                                                          |
// | You should have received a copy of the GNU Lesser General Public         |
// | License along with this library; if not, write to the Free Software      |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA |
// +--------------------------------------------------------------------------+

/**
 * Image_Graph aka GraPHPite - PEAR PHP OO Graph Rendering Utility.
 * @package datapreprocessor
 * @copyright Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
 * @author Jesper Veggerby Hansen <pear.nosey@veggerby.dk>
 * @version $Id: Array.php,v 1.1 2008/01/24 01:06:06 tye Exp $
 */ 

/**
 * Include file Graph/DataPreprocessor.php
 */
require_once(IMAGE_GRAPH_PATH . "/Graph/DataPreprocessor.php");

/**
 * Format data as looked up in an array.
 * ArrayData is useful when a numercal value is to be translated to something thats
 * cannot directly be calculated from this value, this could for example be a dataset
 * meant to plot population of various countries. Since x-values are numerical and
 * they should really be country names, but there is no linear correlation between the
 * number and the name, we use an array to "map" the numbers to the name, i.e. 
 * $array[0] = 'Denmark'; $array[1] = 'Sweden'; ..., where the indexes are the numerical
 * values from the dataset.
 * This is NOT usefull when the x-values are a large domain, i.e. to map unix timestamps
 * to date-strings for an x-axis. This is because the x-axis will selecte arbitrary values
 * for labels, which would in principle require the ArrayData to hold values for every
 * unix timestamp. However ArrayData can still be used to solve such a situation, since 
 * one can use another value for X-data in the dataset and then map this (smaller domain)
 * value to a date. That is we for example instead of using the unix-timestamp we use value 0 
 * to represent the 1st date, 1 to represent the next date, etc.
 */
class Image_Graph_DataPreprocessor_Array extends Image_Graph_DataPreprocessor 
{

    /**
     * The data label array
     * @var array
     * @access private
     */
    var $_dataArray;

    /**
     * Image_Graph_ArrayData [Constructor].
     * @param array $array The array to use as a lookup table
     */
    function &Image_Graph_DataPreprocessor_Array($array)
    {
        parent::Image_Graph_DataPreprocessor();
        $this->_dataArray = $array;
    }

    /**
     * Process the value
     * @param var $value The value to process/format
     * @return string The processed value
     * @access private
     */
    function _process($value)
    {
        if ((is_array($this->_dataArray)) and (isset ($this->_dataArray[$value]))) {
            return $this->_dataArray[$value];
        } else {
            return $value;
        }
    }

}
?>