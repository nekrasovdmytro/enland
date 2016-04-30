<?php
/**
 * Created by PhpStorm.
 * User: nekrasov
 * Date: 26.12.15
 * Time: 11:59
 */

namespace WordBundle\BookReader;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class BookReader
{
    protected $file;
    protected $container;

    const PATH = 'data/';

    public function __construct($file, ContainerInterface $container)
    {
        $this->container = $container;

        $dr = $this->container->getParameter('document_root');

        $this->file =  $dr . '/' . self::PATH . $file;
    }

    public function getContent()
    {
        $content = '';

        try {
            if (!file_exists($this->file)) {
                throw new FileNotFoundException($this->file);
            }

            $content = file_get_contents($this->file);

        } catch (FileNotFoundException $e) {
            $logger = $this->container->get('logger');
            $logger->error($e->getMessage());
        }

        return $content;
    }

    public function makeArray($delimiter = "\n")
    {
        $content = $this->getContent();


        $array = explode($delimiter, $content);

        return $array;
    }

    public function saveToDb($count)
    {
        $array = $this->makeArray();

        $em = $this->container->get('doctrine')->getEntityManager();

        $connection = $em->getConnection();
        $countv = $connection->prepare("SELECT count(*) as countv FROM bible");
        $countv->execute();

        $resultCountV = $countv->fetchAll();

        $start = isset($resultCountV[0]['countv']) ? $resultCountV[0]['countv'] : 0;

        //inserting book to DB
        $statement = $connection->prepare("INSERT INTO bible (text, book, location) VALUES (:text, :book, :location)");

        $bookHeader = '';
        $locationText = '';
        for ($i = $start; $i < $count + $start; $i++) {
            try {
                if (!isset($array[$i])) {
                    throw new Exception ("Book array is empty");
                }

                $str = $array[$i];

                $book = substr($str, 0, 4);

                if ($book == 'Book') {
                    $bookHeader = $str;
                } else {
                    $location = trim(substr($str, 0, 8));

                    if (!empty($location)) {
                        $locationText = $location;
                    }

                    $text = trim(str_replace($location, '', $str));

                    $statement->bindValue('text', $text);
                    $statement->bindValue('book', $bookHeader);
                    $statement->bindValue('location', $locationText);

                    $statement->execute();
                }
            } catch (\Exception $e) {
                echo $e->getMessage();
                exit();
            }
        }
    }
}