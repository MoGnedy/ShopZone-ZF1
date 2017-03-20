<?php

class Application_Form_Sliderform extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
 $this->setMethod('POST');
         $picture = new Zend_Form_Element_File('picture');
        $picture->setLabel('Product picture: ')
                ->setDestination('imgs')
                ->setValueDisabled(true)
                ->addValidator('Count', false, 1)
                ->addValidator('Size', false, 2048000)
                ->addValidator('Extension', false, 'jpg,png,gif');
        $picture->setAttribs(Array(
        'placeholder'=>'Example: 1000',
        'class'=>'form-control'
        ));

        $description = new Zend_Form_Element_Text('description');
        $description->setLabel('Product description: ');
        $description->setAttribs(Array(
        'placeholder'=>'Example: ......',
        'class'=>'form-control'
        ));
        $description->setRequired();
        $description->addValidator('StringLength', false, Array(4,));
    

   $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('class', 'btn btn-success');
        $reset = new Zend_Form_Element_Reset('Reset');
        $reset->setAttrib('class', 'btn btn-danger');
        //$this->addElement($picture,'picture');
        $this->addElements(array($description,$picture,$submit,$reset));
}

}