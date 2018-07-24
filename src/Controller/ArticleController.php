<?php

namespace App\Controller;

use App\Entity\Article;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;

class ArticleController extends Controller
{
    private $em;
    private $sr;
    
    public function __construct(EntityManagerInterface $em, SerializerInterface $sr) 
    {
        $this->em = $em;
        $this->sr = $sr;
    }
    
    /**
     * @Route("/article", name="article")
     */
    public function index()
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }
    
    /**
     * @Route("/article/add", name="article_add")
     **/
     public function addAction(Request $request)
     {
         $data = $request->getContent();
         
         if($data == null) {
             $response = new Response(json_encode(['success' => false, 'error' => 'Input data not found']), Response::HTTP_NO_CONTENT);
         } else {
            $article = $this->sr->deserialize($data, Article::class, 'json');
            if($article != null) {
                $this->em->persist($article);
                $this->em->flush();
                
                $response = new Response(json_encode(['success' => true, 'error' => '']), Response::HTTP_CREATED);
            }
         }
         
         return $response;
     }
    
    /**
     * @Route("/article/all", name="aticle_show_all")
     **/
     public function showAllAction()
     {
         $response = new Response(
                                    $this->sr->serialize($this->em->getRepository(Article::class)->findAll(), 'json'),
                                    Response::HTTP_OK
                                );
         $response->headers->set('Content-Type', 'application/json');
         
         return $response;
     }
}
