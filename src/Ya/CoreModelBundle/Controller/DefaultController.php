<?php

namespace Ya\CoreModelBundle\Controller;

use FOS\Rest\Util\Codes;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

use Ya\CoreModelBundle\Entity\Test;
use Ya\CoreModelBundle\Entity\User;
use Ya\CoreModelBundle\Form\Model\Pagination;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\Options;

use Ya\CoreModelBundle\Controller\Controller;

class DefaultController extends Controller
{
  /**
   * @Method("GET")
   * @Route("/{id}", name = "api_test_get")
   */
  public function getAction(Test $test)
  {
    return $this->view($test);
  }

  /**
   * Method to retrieve list of tests
   * 
   * @Method("GET")
   * @Route("", name = "api_test_list", options={"expose"=true})
   * @param ParamFetcher $paramFetcher Paramfetcher
   * 
   * @RequestParam(name="pagination[page]", requirements="\d+", default="1", description="Requested Page")
   * @RequestParam(name="pagination[limit]", requirements="\d+", default="10", description="Limit of the results")
   * 
   * @ApiDoc()
   */
  public function getTestsAction(Request $request)
  {
    $paginationForm = $this->createPaginationForm($pagination = new Pagination());
    $pag = $request->get('page');
    $limit = $request->get('limit');
    if (!$paginationForm->bind($request)->isValid()) {
      return $this->view($paginationForm);
    }
    
    $testRepository = $this->getDoctrine()->getManager()->getRepository('YaCoreModelBundle:Test');
    /* @var $queryBuilder \Doctrine\ORM\QueryBuilder */
    $queryBuilder = $testRepository->createQueryBuilder('t');
    $pager = $this->createORMPager($pagination, $queryBuilder);

    $this->addBasicRelations($pager); // will add self + navigation links
    $this->addRelation($pager, 'pagination', array('route' => 'api_test_form_pagination'), array(
      'provider' => array('fsc_hateoas.factory.form_view', 'create'),
      'providerArguments' => array($paginationForm, 'GET', 'api_test_list'),
    ));
    
    return $this->view($pager);
  }

  /**
   * @Method("POST")
   * @Route("", name = "api_test_create")
   */
  public function createAction(Request $request)
  {
    $form = $this->createTestForm($test = new Test(), true);

    if (!$form->bind($request)->isValid()) {
      return $this->view($form);
    }

    $em = $this->getDoctrine()->getManager();
    $em->persist($test);
    $em->flush();

    return $this->redirectView($this->generateSelfUrl($test), Codes::HTTP_CREATED);
  }

  /**
   * @Method("PUT")
   * @Route("/{id}", name = "api_test_edit")
   */
  public function editAction(Test $test, Request $request)
  {
    $form = $this->createTestForm($test);

    if (!$form->bind($request)->isValid()) {
      return $this->view($form);
    }

    $this->getDoctrine()->getManager()->flush();

    return $this->redirectView($this->generateSelfUrl($test), Codes::HTTP_ACCEPTED);
  }

  /**
   * @Method("GET")
   * @Route("/forms/pagination", name = "api_test_form_pagination")
   */
  public function paginationFormAction()
  {
    $form = $this->createPaginationForm($pagination = new Pagination());
    $formView = $this->createFormView($form, 'GET', 'api_test_list'); // will add method/action attributes

    $this->addBasicRelations($formView); // will add self link

    return $this->view($formView);
  }

  /**
   * @Method("GET")
   * @Route("/forms/create", name = "api_test_form_create")
   */
  public function createFormAction()
  {
    $form = $this->createTestForm($test = new Test(), true);
    $formView = $this->createFormView($form, 'POST', 'api_test_create'); // will add method/action attributes

    $this->addBasicRelations($formView); // will add self link

    return $this->view($formView);
  }

  /**
   * @Method("GET")
   * @Route("/{id}/forms/edit", name = "api_test_form_edit")
   */
  public function editFormAction(Test $test)
  {
    $form = $this->createTestForm($test);
    $formView = $this->createFormView($form, 'PUT', 'api_test_edit', array('id' => $test->getId())); // will add method/action attributes

    $this->addBasicRelations($formView); // will add self link

    return $this->view($formView);
  }

  protected function createTestForm(Test $test, $create = false)
  {
    $options = $create ? array('is_create' => true) : array();

    return $this->createFormNamed('test', 'ya_test', $test, $options);
  }

  protected function createPaginationForm(Pagination $pagination)
  {
    return $this->createFormNamed('pagination', 'ya_pagination', $pagination);
  }
}
