<?php

class Application_Form_Commentform extends Zend_Form
{

    public function init()
    {
         $this->setMethod('POST');
        $comment = new Zend_Form_Element_Text('comment');
        $comment->setAttribs(Array(
        'placeholder'=>'Example: add comment',
        'class'=>'form-control'
        ));
        
        $comment->setRequired();
        $comment->addValidator('StringLength', false, Array(4,));
    
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('class', 'btn btn-success');
        $reset = new Zend_Form_Element_Reset('Reset');
        $reset->setAttrib('class', 'btn btn-danger');
        //$this->addElement($picture,'picture');
        $this->addElements(array($comment,$submit,$reset));
        
        
        
    }


}

