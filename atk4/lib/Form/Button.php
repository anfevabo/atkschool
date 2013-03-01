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
/**
 * Displays flexible button
 *
 * @author      Romans <romans@adevel.com>
 * @copyright   See file COPYING
 * @version     $Id$
 */
class Form_Button extends Button {
    public $label;

    public $onclick='';

    protected $style = array();

    function setLabel($_label){
        $this->label=$_label;
        parent::setLabel($_label);
        return $this;
    }
    function setNoSave(){
        // Field value will not be saved into defined source (such as database)
        $this->no_save=true;
        return $this;
    }
}
