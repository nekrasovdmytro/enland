<?php
/**
 * Created by PhpStorm.
 * User: nekrasov
 * Date: 24.12.15
 * Time: 14:10
 */

namespace WordBundle\Dictionary;

use Symfony\Component\DependencyInjection\ContainerInterface;
use WordBundle\Decoration\GenerateColor;

abstract class AbstractDictionary
{
    protected $container;

    const LANG = 'ru-en';

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getListWords($count = 30, $offset = 0)
    {
        $params = ['lang' => static::LANG];

        $result = $this->getListQuery($params, $count, $offset)
            ->getQuery()
            ->getArrayResult();

        return $result;
    }

    public function getListByAlp($alp, $count = 30, $offset = 0, $lang = null)
    {
        $lang = is_null($lang) ? static::LANG : $lang;

        $params = ['lang' => $lang, 'alp' => $alp . '%', 'notlike' => '% %', 'notlike2' => '%.%'];

        $result = $this->getListQuery($params, $count, $offset)
            ->where("w.lang = :lang and w.translate LIKE :alp and w.translate NOT LIKE :notlike and w.translate NOT LIKE :notlike2 and length(w.translate) > 1")
            ->getQuery()
            ->getArrayResult();

        return $result;
    }

    protected function getListQuery($params, $count = 30, $offset = 0)
    {
        $query =  $this->getWordRepository()->createQueryBuilder('w')
            ->select(['w.id', 'w.word', 'w.translate', 'w.image', 'w.transcription'])
            ->where("w.lang = :lang ")
            ->orderBy('w.translate', 'ASC')
            ->setParameters($params);

        // set limits
        if ($count !== null) {
            $query->setMaxResults($count)
                ->setFirstResult($offset);
        }

        return $query;
    }

    public function getRandWords($limit = 30)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $connection = $em->getConnection();

        $statement = $connection->prepare("
            SELECT *
            FROM words
            WHERE lang = :lang AND image <> '' and word NOT LIKE '% %'
            ORDER BY RAND() LIMIT :limit
        ");
        $statement->bindValue('limit', $limit, \PDO::PARAM_INT);
        $statement->bindValue('lang', static::LANG);
        $statement->execute();

        $results = $statement->fetchAll();

        return $results;
    }

    public function getWordInfo($word)
    {
        $params = ['word' => '%' . $word . '%'];

        $result = $this->getListQuery($params, null)
            ->select(['w.id', 'w.word', 'w.translate', 'w.image', 'w.transcription', 'w.data', 'w.lang'])
            ->where("w.word LIKE :word or w.translate LIKE :word")
            ->getQuery()
            ->getArrayResult();


        //filtering not matched words
        if (count($result) > 1) {
            $result = array_filter($result, function ($a) use ($word) {
                return preg_match("/\b(\s*{$word}\w*\s*)\b/", $a['translate']);
            });
        }

        $result = array_values($result);

        //set color for same words
        $color = [0,0,0];

        for ($i = 0; $i < count($result); $i++) {

            try {
                $result[$i]['data'] = unserialize($result[$i]['data']);
            }catch (\Exception $e) {
                $logger = $this->container->get('logger');
                $logger->error($e->getMessage());
            }

            if ($i > 0 && $this->compareWords($result[$i - 1]['translate'], $result[$i]['translate'])) {
                $result[$i]['color'] = implode(',', $color);
                $result[$i - 1]['color'] = implode(',', $color);
            } else {
                $color = GenerateColor::generate(GenerateColor::LIGHT_TONE);
            }

        }

        return $result;
    }

    public function getRandListWords($count)
    {
        $maxwords = static::MAX_WORDS;

        $randIds = [];

        for ($i = 0; $i <= $count; $i++) {
            $randIds[] = mt_rand(0, $maxwords);
        }

        $params = ['lang' => static::LANG, 'ids' => $randIds];

        $result = $this->getListQuery($params, $count, 0)
            ->where("w.lang = :lang AND w.id IN (:ids) AND w.image <> ''")
            ->setParameters($params)
            ->getQuery()
            ->getArrayResult();

        if (count($result) == 0) {
            $result = $this->getRandListWords($count);
        }

        return $result;
    }

    public function getWordFromList(array $array, $word)
    {
        $array = array_values(array_filter($array, function($a) use($word) {
            return $a['translate'] == $word || $a['word'] == $word;
        }));

        return !empty($array) ? $array[0] : [];
    }

    protected function compareWords($word1, $word2)
    {
        $word1 = trim(mb_strtolower($word1));
        $word2 = trim(mb_strtolower($word2));

        return $word1 == $word2;
    }

    public function prepareWord($word)
    {
        return str_replace(['_'], [' '], $word);
    }

    protected function getWordRepository()
    {
        return $this->container->get('doctrine')->getRepository('WordBundle:Words');
    }

    abstract function getAlphabet();

    public function getLang()
    {
        return static::LANG;
    }
}