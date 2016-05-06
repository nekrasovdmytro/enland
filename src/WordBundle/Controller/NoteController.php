<?php

namespace WordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use WordBundle\Dictionary\DictionaryTools;
use WordBundle\Entity\Category;
use WordBundle\Entity\Fastnotice;
use WordBundle\Dictionary\EnglishDictionary;
use WordBundle\Notice\BaseNotice;
use WordBundle\SEO\WordSeo;

class NoteController extends Controller
{
    /**
     * @Route("/add-notice/")
     */
    public function addAction(Request $request)
    {

	header('Content-Type: text/html; charset=utf-8');
        $path = $this->get('kernel')->getRootDir() . '/../web/uploads';
        $isAdded = false;
        $fastnotice = new Fastnotice();

        $categoryRepos = $this->getDoctrine()->getRepository('WordBundle:Category');
        $categories = $categoryRepos->findAll();

        if ($request->isMethod('post')) {
            $name = 'default.png';

            foreach ($request->files as $uploadedFiles) {
                if (!empty($uploadedFiles)) {
                    $name = md5(time() . uniqid()) . '.' . $uploadedFiles->getClientOriginalExtension();
                    $uploadedFiles->move($path, $name);
                }
            }

            $noticeManager = $this->getDoctrine()->getEntityManager();

            $fastnotice = new Fastnotice();

            $fastnotice->setText($request->get('text'));
            $fastnotice->setHeader($request->get('header'));
            !empty($name) && $fastnotice->setImage($name);
            $fastnotice->setCategoryId($request->get('category_id'));

            $fastnotice->setUrl(time() .'-'. DictionaryTools::translitUrl($request->get('header')));

            $noticeManager->persist($fastnotice);

            $noticeManager->flush();

            $isAdded = true;

        }

        $wordSEO = new WordSeo();
        $wordSEO->setSeparator('');
        $wordSEO->setTitle('Добавить свою публикацию для изучения английского');

        $wordSEO->setDescription('Вы знаете английский? Если да, мы вам предлагаем помочь в изучению другим. Вы можете добавить свое видео,
        статьи, заметки и книги');

        $wordSEO->getKeywords("Добавить книгу, добавить видео на английском, добавить статью, поделится знаниями английского");

        return $this->render('WordBundle:Note:add.html.twig', [
            'isadded' => $isAdded,
            'fastnotice' => $fastnotice,
            'categories' => $categories,
            'seo' => $wordSEO
       ]);
    }

    /**
     * @Route("/n/{url}")
     */
    public function showAction(Request $request, $url)
    {
        $baseNotice = new BaseNotice($this->container);
        $fnRepo = $this->getDoctrine()->getRepository('WordBundle:Fastnotice');

        $offset = 0;
        $limit = 3;

        $dictionary = new EnglishDictionary($this->container);

        $words = $dictionary->getRandWords();

        $anotherFn = $fnRepo->findBy([], ['header' => 'ASC'], $limit, $offset);

        $fn = $fnRepo->findOneBy(['url' => $url]);

        $category = $fn->getCategoryId();

        $categoriesArray = $baseNotice->getCategories();

        $wordSEO = new WordSeo();
        $wordSEO->setSeparator('');
        $wordSEO->setTitle($fn->getHeader());

        $description = strip_tags($fn->getText());

        $wordSEO->setDescription(substr($description, 0, 250 ) . '...');


        return $this->render('WordBundle:Note:show.html.twig', [
            'article' => $fn,
            'another' => $anotherFn,
            'words' => $words,
            'categories' => $categoriesArray,
            'category' => $category,
            'seo' => $wordSEO
        ]);
    }

    /**
     * @Route("/notice")
     */
    public function listAction(Request $request)
    {
        $baseNotice = new BaseNotice($this->container);
        $dictionary = new EnglishDictionary($this->container);

        $limit = 10;
        $offset = 0;
        $pages = 0;

        $page = $request->get('p') ? $request->get('p') : 0;

        /*Category of notices*/
        $category = $request->get('category');

        $params = [];
        if ($category) {
            $params = ['categoryId' => $category];
        }

        $categoriesArray = $baseNotice->getCategories();
        /*\Category of notices*/

        /*Count of notices*/
        $count = $baseNotice->getCount($category ? $category : null);

        $count > $limit && $pages = floor($count / $limit);
        /*Count of notices*/

        /*Getting notices*/
        $noticesArray = $baseNotice->getNotices($params, $limit, $limit * $page);
        /*\Getting notices*/

        /*Words*/
        $words = $dictionary->getListWords(30, mt_rand(0,EnglishDictionary::MAX_WORDS - 30));
        /*\Words*/

        $url = '/notice'. ($category ? '?category = ' . $category : '');

        $wordSEO = new WordSeo();

        $wordSEO->setAdditionTitle("учи английский интересно, полезные заметки, книги, интересные видео, видео на английском с субтитрами");

        $wordSEO->setTitle(!$category ? "Английский для студента / англійська для студента" : $categoriesArray[$category] -> getName());

        $wordSEO->setDescription(($category ? $categoriesArray[$category] -> getName() : '') . "Изучение английского не должно быть утимительно и не интересно, если ты студент или школьник или просто решил выучить язык,
        ты можешь делать это интересно, смотри видео, читай заметки, учи английский по интересным для тебя темам.");


        $keywords = [];
        if ($category) {
            $keywords = [$categoriesArray[$category] -> getName()];
        }
        foreach ($noticesArray as $notices) {
            foreach ($notices as $n) {
                $keywords[] = $n->getHeader();
            }
        }
        $wordSEO->setKeywords($keywords);

        return $this->render('WordBundle:Note:list.html.twig', [
            'notices' => $noticesArray,
            'categories' => $categoriesArray,
            'category' => $category,
            'words' => $words,
            'page' => $page,
            'pages' => $pages,
            'url' => $url,
            'seo' => $wordSEO
        ]);
    }
}
