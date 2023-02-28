<?php

namespace App\Controller;

use App\Dto\CalculatorDto;
use App\Form\CalculatorType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(Request $request): Response
    {
        $dto = new CalculatorDto();

        $form = $this->createForm(CalculatorType::class, $dto);

        $form->handleRequest($request);

        $resultPrice = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $percent = $this->getTaxPercent($dto->tax);

            $resultPrice = $dto->price + ($dto->price * ($percent / 100));
        }

        return $this->render('index/index.html.twig', [
            'form'         => $form,
            'result_price' => $resultPrice
        ]);
    }

    /**
     * @param $number
     * @return int
     * @throws \Exception
     */
    private function getTaxPercent($number): int
    {
        return match (substr($number, 0, 2)) {
            'DE' => 19,
            'IT' => 10,
            'GR' => 24,
            default => throw new \Exception('Invalid tax number'),
        };
    }
}
