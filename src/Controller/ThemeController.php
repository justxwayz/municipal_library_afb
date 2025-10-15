<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ThemeController extends AbstractController
{
    #[Route('/theme/{mode}', name: 'theme_switch')]
    public function switchTheme(Request $request, string $mode): Response
    {
        if (!in_array($mode, ['light', 'dark'])) {
            $mode = 'light';
        }

        $response = $this->redirect($request->headers->get('referer', '/'));
        $response->headers->setCookie(
            Cookie::create('theme')
                ->withValue($mode)
                ->withExpires(new \DateTime('+1 year'))
                ->withPath('/')
                ->withHttpOnly(false)
        );

        return $response;
    }
}
