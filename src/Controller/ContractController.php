<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Form\ContractType;
use App\Repository\ContractRepository;
use App\Service\YouSignService;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contract')]
class ContractController extends AbstractController
{
    #[Route('/', name: 'app_contract_index', methods: ['GET'])]
    public function index(ContractRepository $contractRepository): Response
    {
        return $this->render('contract/index.html.twig', [
            'contracts' => $contractRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_contract_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ContractRepository $contractRepository): Response
    {
        $contract = new Contract();
        $form = $this->createForm(ContractType::class, $contract);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contractRepository->save($contract, true);

            return $this->redirectToRoute('app_contract_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contract/new.html.twig', [
            'contract' => $contract,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contract_show', methods: ['GET'])]
    public function show(Contract $contract): Response
    {
        return $this->render('contract/show.html.twig', [
            'contract' => $contract,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contract_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contract $contract, ContractRepository $contractRepository): Response
    {
        $form = $this->createForm(ContractType::class, $contract);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contractRepository->save($contract, true);

            return $this->redirectToRoute('app_contract_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contract/edit.html.twig', [
            'contract' => $contract,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contract_delete', methods: ['POST'])]
    public function delete(Request $request, Contract $contract, ContractRepository $contractRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contract->getId(), $request->request->get('_token'))) {
            $contractRepository->remove($contract, true);
        }

        return $this->redirectToRoute('app_contract_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/pdf', name: 'app_contract_pdf', methods: ['GET'])]
    public function pdf(Request $request, Contract $contract, ContractRepository $contractRepository)
    {
        $dompdf = new Dompdf();
        $html = $this->renderView('contract/pdf.html.twig', ['contract' => $contract]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $pdf = $dompdf->output();
        $filename = 'contract_' . $contract->getId() . '.pdf';
        $filepath = $this->getParameter('kernel.project_dir'). '/public/'. $filename;

        $contract->setUnsignedPdfName($filename);
        $contractRepository->save($contract, true);

        file_put_contents($filepath, $pdf);

        return $this->redirectToRoute('app_contract_show', ['id' => $contract->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/signature', name: 'app_contract_signature', methods: ['GET'])]
    public function signature(Contract $contract, ContractRepository $contractRepository, YouSignService $youSignService)
    {
        // 1 - Creation de la demande de signature
        $youSignSignatureRequest = $youSignService->signatureRequest();
        $contract->setSignatureId($youSignSignatureRequest['id']);
        $contractRepository->save($contract, true);

        // 2 - Upload du document
        $documentRequest = $youSignService->uploadDocument($contract->getSignatureId(), $contract->getUnsignedPdfName());
        $contract->setDocumentId($documentRequest['id']);
        $contractRepository->save($contract, true);

        // 3 - Ajout des signataires
        $signerId = $youSignService->addSigner(
            $contract->getSignatureId(),
            $contract->getDocumentId(),
            $contract->getEmail(),
            $contract->getFirstName(),
            $contract->getLastname()
        );
        $contract->setSignerId($signerId['id']);
        $contractRepository->save($contract, true);

        // 4 - Envoie de la demande de signature
        $youSignService->activateSignatureRequest($contract->getSignatureId());

        return $this->redirectToRoute('app_contract_show', ['id' => $contract->getId()], Response::HTTP_SEE_OTHER);
    }
}
