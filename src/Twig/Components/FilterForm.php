<?php

namespace App\Twig\Components;

use App\Form\FilterFormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('filter_form')]
class FilterForm
{
    private FormView $formView;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $form = $formFactory->create(FilterFormType::class);
        $form->handleRequest(Request::createFromGlobals());
        $this->formView = $form->createView();
    }

    public function getFilterForm()
    {
        return $this->formView;
    }
}
