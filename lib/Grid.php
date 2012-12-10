<?php
/***********************************************************
  ..

  Reference:
  http://agiletoolkit.org/doc/ref

 **ATK4*****************************************************
 This file is part of Agile Toolkit 4 
 http://agiletoolkit.org

 (c) 2008-2011 Agile Technologies Ireland Limited
 Distributed under Affero General Public License v3

 If you are using this file in YOUR web software, you
 must make your make source code for YOUR web software
 public.

 See LICENSE.txt for more information

 You can obtain non-public copy of Agile Toolkit 4 at
 http://agiletoolkit.org/commercial

 *****************************************************ATK4**/
class Grid extends Grid_Advanced 
{
  public $mysno=1;
    function format_diff($field)
    {
        $this->current_row[$field] = $this->current_row['capacity'] - $this->current_row['alloted'];
    }
    function format_mul($field)
    {
        $this->current_row[$field] = $this->current_row['quantity'] * floatval($this->current_row['rate']);
    }
   function format_instock($field)
    {
        $this->current_row[$field] = $this->current_row['TotalInward'] - floatval($this->current_row['TotalIssued']);
    }

    function format_hindi($field){
      $this->setTDParam($field,'class','hindi');
    }

    function format_attendance($field){
      if($this->current_row[$field] == 'inward') 
          $color='green';
      else
          $color='red';

      $this->current_row_html[$field]= '<div style="color:'.$color.'">'.$this->current_row[$field].'</div>';
    }

    function format_picture($field){
      $this->current_row_html[$field] = '<img src="upload/'.$this->current_row[$field].'" width="30%" height="30%"/>';
    }

    function format_sno($field){
      $this->current_row[$field] = $this->mysno + $_GET[$this->name.'_paginator_skip'];
      $this->mysno++;
    }
}
