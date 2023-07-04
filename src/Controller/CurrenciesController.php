<?php

namespace App\Controller;

use App\Form\CurrenciesConversionType;
use App\Service\ApiNbpService;
use App\Service\CurrencyConverterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CurrenciesController extends AbstractController
{
    #[Route('/currencies', name: 'app_currencies')]
    public function index(ApiNbpService $apiNbpService, Request $request): Response
    {
        $apiNbpService->processData();

        $form = $this->createForm(CurrenciesConversionType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $amount = $data['eur'];
            return $this->redirectToRoute('result', ['amount' => $amount]);
        }

        return $this->render('currencies/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/result', name: 'result')]
    public function result(Request $request, CurrencyConverterService $currencyConverterService): Response
    {
        $amount = $request->query->get('amount');
        $result = $currencyConverterService->calculate($amount);

        return $this->render('currencies/result.html.twig', [
            'result' => $result
        ]);
    }
}
