<?php declare(strict_types=1);

namespace App\Controller\Site;


use App\Form\Type\TransferMoneyRequestType;
use Polidog\TransferMoneyManagement\UseCase\TransferMoney\TransferMoney;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/transfer-money")
 * @Template()
 */
class TransferMoneyController
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var TransferMoney
     */
    private $useCase;

    /**
     * TransferMoneyController constructor.
     * @param FormFactoryInterface $formFactory
     * @param TransferMoney $useCase
     */
    public function __construct(FormFactoryInterface $formFactory, TransferMoney $useCase)
    {
        $this->formFactory = $formFactory;
        $this->useCase = $useCase;
    }

    /**
     * @Route("/form", methods={"GET"})
     * @Template()
     */
    public function form()
    {
        $form = $this->formFactory->create(TransferMoneyRequestType::class);
        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/run", methods={"POST"})
     * @Template()
     *
     * @param Request $request
     * @return array
     */
    public function run(Request $request)
    {
        $form = $this->formFactory->create(TransferMoneyRequestType::class);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $output = $this->useCase->handle($form->getData());
            return [
                'source' => $output->getSource(),
                'destination' => $output->getDestination(),
                'money' => $output->getMoney()
            ];
        }
    }
}