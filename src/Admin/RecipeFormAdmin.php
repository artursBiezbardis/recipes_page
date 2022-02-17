<?php

namespace App\Admin;

use App\Entity\Category;
use App\Entity\Recipe;
use App\Services\CategoryParseService;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class RecipeFormAdmin extends AbstractAdmin
{
    private CategoryParseService $parseService;

    /**
     * @param CategoryParseService $parseService
     */
    public function __construct(CategoryParseService $parseService)
    {
        $this->parseService = $parseService;
    }


    protected function configureFormFields(FormMapper $form): void
    {
        $categoryChoices = $this->parseService->categoryChoices();

        $form
            ->add('name', TextType::class)
            ->add('short_description', TextareaType::class)
            ->add('category', ChoiceType::class, [
                'choices' => $categoryChoices,
                'choice_label' =>
                    function ($choice, $key, $value) {

                        return $this->parseService->setVisualCategoryTree($choice, $key, $value);
                    },
                'choice_attr' => function ($choice, $key, $value) {

                    return ['location' => $key, 'parentId' => $value];
                },
                'attr' => ['class' => 'parent-category'],
            ]);
    }

    public function toString(object $object): string
    {
        return $object instanceof Recipe
            ? $object->getName()
            : 'Recipe Form';
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('name')
            ->add('category.location');
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('name')
            ->add('category', null, [
                'field_type' => EntityType::class,
                'field_options' => [
                    'class' => Category::class,
                    'choice_label' => 'location',
                ],
            ]);
    }

    /*protected function configureQuery(\Sonata\AdminBundle\Datagrid\ProxyQueryInterface $query): ProxyQueryInterface
    {
        $rootAlias = current($query->getRootAliases());

        $query->addOrderBy($rootAlias . 'category', 'ASC');
        //$query->addOrderBy($rootAlias.'.createdAt', 'ASC');

        return $query;
    }*/

}