<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('POST');
        $name=new Zend_Form_Element_Text('email');
        $name->setLabel('Name')
              ->setAttribs(array('class'=>'form-control','placeholder'=>'example.Ahmed'))
              ->setRequired();
        //$name->addValidator('StringLength',false,Array(4,20));
        // $name->addFilter('StringTrim');

        $password=new Zend_Form_Element_Password('pass');
        $password->setLabel('PassWord')
                ->setAttribs(array('class'=>'form-control'))
                ->setRequired();
        // $password->addValidator('StringLength',false,Array(4,20));
        // $password->addFilter('StringTrim');

        $submit=new Zend_Form_Element_Submit('Login');
        $submit->setAttribs(array('class'=>'btn btn-success'));

        $this->addElement($name);
        $this->addElement($password);
        $this->addElement($submit);
}
}
