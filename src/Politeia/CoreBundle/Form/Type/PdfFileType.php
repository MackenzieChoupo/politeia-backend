<?php

namespace Politeia\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PdfFileType  extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
    }

    public function buildView(FormView $view,FormInterface $form, array $options)
    {
        $view->vars['widget_type'] = 'pdf_file_widget';
        $view->vars['required'] = false; 
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {        
        $resolver->setDefaults(array(              
        ));        
    }
 
    public function getName()
    {
        return 'pdf_file';
    }
}
