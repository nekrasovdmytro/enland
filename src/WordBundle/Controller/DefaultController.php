<?php

namespace WordBundle\Controller;

use Doctrine\DBAL\Exception\DatabaseObjectExistsException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WordBundle\SEO\WordSeo;
use WordBundle\BibleSphinxSearch\BibleSphinxSearch;
use WordBundle\BibleSphinxSearch\BibleTranslator;
use WordBundle\BookReader\BookReader;
use WordBundle\Decoration\GenerateColor;
use WordBundle\Dictionary\EnglishDictionary;
use WordBundle\Entity\Translate;
use WordBundle\Notice\BaseNotice;
use WordBundle\RealSpeech\GTalk;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $noticeBase = new BaseNotice($this->container);
        $dictionary = new EnglishDictionary($this->container);

        $limit = 30;
        $offset = mt_rand(0, EnglishDictionary::MAX_WORDS - $limit);

        $words = $dictionary->getListWords($limit, $offset);

        $alphabet = $dictionary->getAlphabet();

        $notices = $noticeBase->getNotices(['categoryId' => BaseNotice::SUPER_CATEGORY], 4, 0);
        $videos = $noticeBase->getNotices(['categoryId' => BaseNotice::VIDEO_CATEGORY], 2, 0);
        $categories = $noticeBase->getCategories();

        return $this->render('WordBundle:Default:index.html.twig', [
            'words' => $words,
            'alphabet' => $alphabet,
            'lang' => $dictionary->getLang(),
            'notices' => $notices,
            'categories' => $categories,
            'videos' => $videos
        ]);
    }

    /**
     * @Route("/dictionary/{lang}/{a}")
     */
    public function dictionaryAction(Request $request, $lang, $a)
    {
        $p = $request->get('p');
        $p = !empty($p) ? $p : 0;
        $count = 50;

        $dictionary = new EnglishDictionary($this->container);

        $words = $dictionary->getListByAlp($a, $count, $p * $count, $lang);

        $alphabet = $dictionary->getAlphabet();

        $wordSEO = new WordSeo();

        $pageText = $p ? " (page #$p) " : '';
        $wordSEO->setAdditionTitle(" английские слова с транскрипцией / англійські слова з транскрипцією$pageText");
        $wordSEO->setSeparator(' |');
        $wordSEO->setTitle($a);

        $wordSEO->setDescription("Английские слова которые начинаются на $a с русским переводом, транскрипцией, синонимами, схожими словами по звучанию и написанию. Изучайте слован на $a !");


        $keywords = [$a];
        foreach ($words as $w) {
            $keywords[] = $w['translate'];
            $keywords[] = $w['word'];
        }
        $wordSEO->setKeywords($keywords);

        return $this->render('WordBundle:Dictionary:dictionary.html.twig', [
            'words' => $words,
            'alphabet' => $alphabet,
            'lang' => $dictionary->getLang(),
            'letter' => $a,
            'p' => $p,
            'up' => $count > count($words),
            'seo' => $wordSEO
        ]);
    }

    /**
     * @Route("/word/{word}")
     */
    public function showWordAction(Request $request, $word)
    {
        $lang = 'ru-en';
        $dictionary = new EnglishDictionary($this->container);
        $noticeBase = new BaseNotice($this->container);

        $word = $dictionary->prepareWord($word);

        $words = $dictionary->getWordInfo($word);

        $current = $dictionary->getWordFromList($words, $word);

        $bss = new BibleSphinxSearch($this->container);
        $bss->setWord($word);

        $elements = $bss->getMySQlResult();

        $translateRepository = $this->getDoctrine()->getRepository('WordBundle:Translate');
        $userTexts = $translateRepository->findBy(['codeWords' => $word]);

        $notices = $noticeBase->getRandNotices(4);
        $categories = $noticeBase->getCategories();

        $wordSEO = new WordSeo();


        $wordSEO->setAdditionTitle("произношение, транскрипция, похожие на $word, предложения с $word");
        $wordSEO->setTitle($word);

        $textWithWord = '';
        if (count($elements)) {
            $current_element = current($elements);
            $textWithWord = isset($current_element['elements'][0]['text']) ? ' : '.$current_element['elements'][0]['text'] : '';
        }

        $wordSEO->setDescription("Употребление $word в английском языке,
            граматика, синонимы и схожие по звучанию к $word, как заучит $word, выражение с $word $textWithWord");


        $keywords = [];

        foreach ($words as $w) {
            $keywords[] = $w['translate'];
            $keywords[] = $w['word'];
        }

        $wordSEO->setKeywords($keywords);

        return $this->render('WordBundle:Dictionary:word.html.twig', [
            'words' => $words,
            'word' => $word,
            'current' => $current,
            'text' => $elements,
            'usertextes' => $userTexts,
            'key' => mb_strtolower(substr($word, 0, 1)),
            'lang' => $lang,
            'notices' => $notices,
            'categories' => $categories,
            'seo' => $wordSEO
            //'color' => empty($current['image']) ? implode(',', GenerateColor::generate()) : ''
        ]);
    }

    /**
     * @Route("/voc/tech-ukrainian/{a}")
     */
    public function vocAction($a)
    {
        $wordSEO = new WordSeo();

        $dictionary = new EnglishDictionary($this->container);

        $alphabet = $dictionary->getAlphabet();

        $connection = $this->getDoctrine()->getConnection();
        $stmt = $connection->prepare("SELECT * FROM tech_voc WHERE word LIKE :a");
        $stmt->bindValue("a", $a.'%');
        $stmt->execute();

        $words = $stmt->fetchAll();

        $wordSEO->setAdditionTitle("укр. - англ. технічні терміни");
        $wordSEO->setTitle("Технічний словник англійської мови (letter $a)");

        $wordSEO->setDescription("Англ. - укр., технічний словник, буква $a, корисно для программістів, інженерів і всіх тех. спеціальностей");


        $keywords = [];

        $i = 0;
        foreach($words as $w) {
           $keywords[] = $w['word'];
           $keywords[] = $w['translate'];
            $i++;

            if ($i > 30) {
                break;
            }
        }

        $wordSEO->setKeywords($keywords);

        return $this->render('WordBundle:Dictionary:voc.html.twig', [
            'alphabet' => $alphabet,
            'seo' => $wordSEO,
            'words' => $words,
            'a' => $a
        ]);
    }

    /**
     * @Route("/get-speech/{word}")
     */
    public function getAjaxSpeechAction(Request $request, $word)
    {
        if (!$request->isXmlHttpRequest()) {
            $gTalk = new GTalk();

            $speech = $gTalk->getSpeech($word);


        }

        echo $speech;
        exit;
    }

    /**
     * @Route("/get-rus-bible-translation/")
     */
    public function getAjaxTranslationAction(Request $request)
    {
        $book = $request->get('book');
        $book = intval(preg_replace('/[^0-9]+/', '', $book));

        $locVerse = $request->get('location');

        list($location, $verse) = explode(':', $locVerse);

        if ($request->isXmlHttpRequest()) {
            $bibleRu = new BibleTranslator();
            $response = $bibleRu->getTranslation($book, $location, $verse);

            return Response::create($response, !empty($response) ? Response::HTTP_OK: Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @Route("/set-user-text/")
     */
    public function setUserText(Request $request)
    {
        $response = [];
        $translate = new Translate();

        if ($request->isXmlHttpRequest()) {
            $text = $request->get('text');
            $translation = $request->get('translation');
            $word = $request->get('word');

            $translate->setCodeWords($word);
            $translate->setTranslate($translation);
            $translate->setWords($text);

            $em = $this->getDoctrine()->getEntityManager();

            try {
                $em->persist($translate);
                if (! $em->flush()) {
                    throw new \Exception("Exists record in translate");
                }
            } catch (\Exception $e) {

            }

            $response = $translate->toArray();
        }

        return JsonResponse::create($response, $translate->getId() ? JsonResponse::HTTP_OK : JsonResponse::HTTP_FORBIDDEN);
    }

    /**
     * @Route("/learn-words/")
     */
    public function learnWords(Request $request)
    {

        $dictionary = new EnglishDictionary($this->container);
        $words = $dictionary->getRandListWords(20); //get rand words

        return $this->render('WordBundle:Default:learn-words.html.twig', [
            'words' => $words
        ]);
    }
}
