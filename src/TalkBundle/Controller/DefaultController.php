<?php

namespace TalkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use TalkBundle\Entity\Record;
use TalkBundle\Espeak\EspeakManager;
use TalkBundle\Espeak\EspeakMp3;
use TalkBundle\Espeak\EspeakTextFile;
use TalkBundle\Repository\RecordRepository;

class DefaultController extends Controller
{
    /**
     * @Route("/talk/espeak/add")
     * @Method("POST")
     */
    public function addESpeakAction(Request $request)
    {
        $data = json_decode($request->getContent());

        try {

            if (empty($data->text)) {
                throw new \Exception("Text is not set");
            }

            $em = $this->getDoctrine()
                ->getEntityManager();

            /**
             * @var \TalkBundle\Repository\RecordRepository $recordRepository
             */
            $recordRepository = $em->getRepository("TalkBundle:Record");

            $response = $record = $recordRepository->findOneByText($data->text);

            if (empty($record)) {
                $record = new Record();
                $record->setText($data->text);

                /**
                 * @var \TalkBundle\Espeak\EspeakManager $espeak
                 */
                $espeak = $this->get('espeak.manager');
                $espeak->setText($data->text);

                try {
                    if ($espeak->generateMp3()) {
                        $record->setFile($espeak->getESpeakMp3()->getFilename());
                    } else {
                        throw new \Exception("Application can't generate mp3 file");
                    }

                    $em->persist($record);
                    $em->flush();

                    // record is set at DB
                    $response = new JsonResponse($record);
                } catch (\Exception $e) {
                    $response = new JsonResponse(['message' => $e->getMessage()],
                        JsonResponse::HTTP_BAD_REQUEST);
                }
            } else {
                // record is found at DB
                $response = new JsonResponse($record);
            }
        } catch (\Exception $e) {
            $response = new JsonResponse(['message' => $e->getMessage()],
                JsonResponse::HTTP_BAD_REQUEST);
        }

        return $response;
    }

    /**
     * @Route("/talk/festival/add")
     * @Method("POST")
     */
    public function addFestivalAction(Request $request)
    {
        $data = json_decode($request->getContent());

        try {

            if (empty($data->text)) {
                throw new \Exception("Text is not set");
            }

            $em = $this->getDoctrine()
                ->getEntityManager();

            /**
             * @var \TalkBundle\Repository\RecordRepository $recordRepository
             */
            $recordRepository = $em->getRepository("TalkBundle:Record");

            $response = $record = $recordRepository->findOneByText($data->text);

            if (empty($record)) {
                $record = new Record();
                $record->setText($data->text);

                /**
                 * @var \TalkBundle\Festival\FestivalManager $festival
                 */
                $festival = $this->get('festival.manager');
                $festival->setText($data->text);

                try {
                    if ($festival->generate()) {
                        $record->setFile($festival->getOutput());
                    } else {
                        throw new \Exception("Application can't generate mp3 file");
                    }

                    $em->persist($record);
                    $em->flush();

                    // record is set at DB
                    $response = new JsonResponse($record);
                } catch (\Exception $e) {
                    $response = new JsonResponse(['message' => $e->getMessage()],
                        JsonResponse::HTTP_BAD_REQUEST);
                }
            } else {
                // record is found at DB
                $response = new JsonResponse($record);
            }
        } catch (\Exception $e) {
            $response = new JsonResponse(['message' => $e->getMessage()],
                JsonResponse::HTTP_BAD_REQUEST);
        }

        return $response;
    }
}
