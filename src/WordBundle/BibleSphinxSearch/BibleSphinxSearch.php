<?php
/**
 * Created by PhpStorm.
 * User: nekrasov
 * Date: 27.12.15
 * Time: 15:17
 */

namespace WordBundle\BibleSphinxSearch;


use Doctrine\DBAL\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BibleSphinxSearch
{
    const INDEX = 'bible_index';

    const RESULT_BY_IDS = 0;
    const RESULT_BY_ATTR = 1;
    const FUNCTION_BY_IDS = 'getResultByIds';
    const FUNCTION_BY_ATTR = 'getResultByAttr';

    const COUNT_LIMIT = 5;

    protected $word;
    protected $cl;
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        $this->cl = new \SphinxClient();
        $this->cl->SetServer( "localhost", 9312 );
        $this->cl->SetMatchMode( SPH_MATCH_EXTENDED );
        $this->cl->SetLimits(0, self::COUNT_LIMIT);
    }

    public function setWord($word)
    {
        $this->word = $word;
    }

    public function getWord()
    {
        return $this->word;
    }

    public function search()
    {
        $result = $this->cl->Query($this->getWord(), self::INDEX);

        $elements = [];

        if ( $result !== false ) {
            if ( ! empty($result["matches"]) ) {
                $elements = $result["matches"];
            }
        }

        return $elements;
    }

    public function getMySQlResult($mode = self::RESULT_BY_ATTR)
    {
        $searchResult = $this->search();
        $em = $this->container->get('doctrine')->getEntityManager();
        $connection = $em->getConnection();

        $function = ($mode == self::RESULT_BY_ATTR) ? self::FUNCTION_BY_ATTR : self::FUNCTION_BY_IDS;
        $result = $this->{$function}($connection, $searchResult);

        return $result;
    }

    protected function getResultByAttr(Connection $connection, array $result)
    {

        $statement = $connection->prepare("SELECT * FROM bible WHERE book LIKE :book and location LIKE :location");

        $array = [];

        foreach ($result as $k => $v) {
            $statement->bindValue('book', $v['attrs']['book']);
            $statement->bindValue('location', $v['attrs']['location']);

            $statement->execute();

            $mysqlResult = $statement->fetchAll();

            if (!empty($mysqlResult[0]['book'])) {
                $array[$k] = ['elements' =>$mysqlResult, 'book' =>$mysqlResult[0]['book'], 'location' => $mysqlResult[0]['location']];
            }

        }

        return $array;
    }

    protected function getResultByIds(Connection $connection, array $result)
    {
        $idsArray = [0];

        // get elements by Ids
        if (!empty($result)) {
            $idsArray = array_keys($result);
        }

        $ids = implode(',', $idsArray);

        $statement = $connection->prepare("SELECT * FROM bible WHERE id in ($ids)");
        $statement->execute();

        return $statement->fetchAll();
    }
}
