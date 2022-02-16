<?php

namespace App\Services;

use App\Repository\CategoryRepository;

class CategoryParseService
{
    /**
     * @var CategoryRepository
     */
    private CategoryRepository $repository;

    /**
     * @param CategoryRepository $repository
     */
    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return array
     */
    public function parseAndSortCategories(): array
    {
        $allCategories = $this->repository->findAll();
        $listCategories = [];

        foreach ($allCategories as $key => $category) {

            if (!$category->getParent() && !array_key_exists((string)$category->getId(), $listCategories)) {
                $categoryId = (string)$category->getId();
                $listCategories[$categoryId] = $category;
                $listCategories[$categoryId]
                    ->setLocation( $listCategories[$categoryId]->getName() . '/');
                unset($allCategories[$key]);
                $setSubCategories = self::parseAndSortSubCategories($allCategories, $listCategories);
                $allCategories = $setSubCategories['allCategories'];
                $listCategories = $setSubCategories['listCategories'];
            }

        }

        return $listCategories;
    }

    /**
     * @param $allCategories
     * @param $listCategories
     * @return array
     */
    protected function parseAndSortSubCategories($allCategories, $listCategories): array
    {
        $setSubCategories = ['allCategories' => $allCategories, 'listCategories' => $listCategories];

        foreach ($allCategories as $key => $category) {

            if (
                $category->getParent()
                && array_key_exists($category->getParent()->getId(), $listCategories)
                && !array_key_exists((string)$category->getId(), $listCategories)
            ) {
                $categoryId = (string)$category->getId();
                $listCategories[$categoryId] = $category;
                $listCategories[$categoryId]
                    ->setLocation(($listCategories[($listCategories[$categoryId])
                            ->getParent()
                            ->getId()]->getLocation()) . $listCategories[$categoryId]
                            ->getName() . '/');
                unset($allCategories[$key]);
                $setSubCategories = self::parseAndSortSubCategories($allCategories, $listCategories);
                $allCategories = $setSubCategories['allCategories'];
                $listCategories = $setSubCategories['listCategories'];
            }
        }

        return $setSubCategories;
    }

    /**
     * @return array
     */
    public function categoryChoices(): array
    {
        $categories = self::parseAndSortCategories();
        $choices = [];

        foreach ($categories as $category) {

            $choices[$category->getLocation()] = $category;
        }
        ksort($choices);

        return $choices;
    }

    /**
     * @param $choice
     * @param $key
     * @param $value
     * @return string
     */
    public function setVisualCategoryTree($choice, $key, $value): string
    {
        $treeArray = explode('/', $key);
        $arrayLength = count($treeArray);
        $label = '';
        if ($value !== "0") {
            foreach ($treeArray as $categoryName) {
                if ($categoryName !== $treeArray[$arrayLength - 1] && $categoryName !== $treeArray[$arrayLength - 2]) {
                    $label .= '-';
                } elseif ($categoryName === $treeArray[$arrayLength - 2]) {
                    $label .= '' . $categoryName;
                }
            }
        } else {
            $label = 'none';
        }

        return strtoupper($label);
    }
}