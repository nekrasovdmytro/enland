<?php

/**
 * Created by PhpStorm.
 * User: nekrasov
 * Date: 06.01.16
 * Time: 16:50
 */
namespace WordBundle\Notice;

use Symfony\Component\DependencyInjection\ContainerInterface;

class BaseNotice
{
    protected $container;

    const VIDEO_CATEGORY = 4;
    const SUPER_CATEGORY = 5;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getCount($category = null)
    {
        $qb = $this->getDoctrine()->getEntityManager()->createQueryBuilder();

        $statement = $qb->select($qb->expr()->count('n'))
            ->from('WordBundle:Fastnotice', 'n');

        if (!is_null($category)) {
            $statement->where('n.categoryId = :categoryId')
                ->setParameter('categoryId', $category);
        }
        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }

    public function getNotices(array $params, $limit, $offset)
    {
        $fnRepo = $this->getDoctrine()->getRepository('WordBundle:Fastnotice');
        $notices = $fnRepo->findBy($params,['id' => 'desc'], $limit, $offset);

        $countNotInCol = ceil(count($notices) / 5);

        $noticesArray = [];
        $i = 0;
        $k = 0;
        foreach($notices as $n) {

            $noticesArray[$k][] = $n;

            if ($i != 0 && $countNotInCol != 0 && $i % $countNotInCol == 0) {
                $k++;
            }

            $i++;
        }

        return $noticesArray;
    }

    public function getRandNotices($limit)
    {
        $count = $this->getCount();

        $offset = mt_rand(0, $count - $limit);

        $fnRepo = $this->getDoctrine()->getRepository('WordBundle:Fastnotice');
        $notices = $fnRepo->findBy([],['id' => 'desc'], $limit, $offset);

        return $notices;
    }
    public function getCategories()
    {
        $catRepo = $this->getDoctrine()->getRepository('WordBundle:Category');
        $categories = $catRepo->findBy([],['name' => 'ASC']);

        $categoriesArray = [];

        foreach($categories as $c) {
            $categoriesArray[$c->getId()] = $c;
        }

        return $categoriesArray;
    }

    protected function getDoctrine()
    {
        return $this->container->get('doctrine');
    }
}