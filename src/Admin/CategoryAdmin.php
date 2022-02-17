<?php

namespace App\Admin;

use App\Services\CategoryParseService;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class CategoryAdmin extends AbstractAdmin
{
    /**
     * @var CategoryParseService
     */
    private CategoryParseService $parseService;

    /**
     * @param CategoryParseService $parseService
     */
    public function __construct(CategoryParseService $parseService)
    {
        $this->parseService = $parseService;
    }

    /**
     * @param FormMapper $form
     * @return void
     */
    protected function configureFormFields(FormMapper $form): void
    {
        $categoryChoices = $this->parseService->categoryChoices();
        $mainCategory = ['none' => null];
        $categoryChoices = $mainCategory + $categoryChoices;
        $form->add('name', TextType::class, [
            'attr' => ['class' => 'category-name']
        ]);
        $form->add('parent', ChoiceType::class, [
            'choices' => $categoryChoices,
            'choice_label' =>
                function ($choice, $key, $value) {

                    return $this->parseService->setVisualCategoryTree($choice, $key, $value);
                },
            'choice_attr' => function ($choice, $key, $value) {

                return ['location' => $key, 'parentId'=>$value];
            },
            'attr' => ['class' => 'parent-category'],
        ]);
        $form->add('location', HiddenType::class, [
            'attr' => ['class' => 'parent-category-key']
        ]);
    }

    /**
     * @param DatagridMapper $datagrid
     * @return void
     */
    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('name');
    }

    /**
     * @param ListMapper $list
     * @return void
     */
    protected function configureListFields(ListMapper $list): void
    {
        $list->addIdentifier('name')->addIdentifier('id');
    }

    /**
     * @param ShowMapper $show
     * @return void
     */
    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('id');
    }
}