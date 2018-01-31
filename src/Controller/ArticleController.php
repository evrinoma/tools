<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 1/30/18
 * Time: 6:42 PM
 */

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController
{
    /**
     * @Route("/news/{slug}")
     */
    public function show($slug)
    {
        $tmp = 100;
        return new Response(sprintf(
            'Future page to show the article: "%s"',
            $slug
        ));
    }
}