<?php

namespace ICS\DashboardBundle\Controller;

use ICS\DashboardBundle\Entity\PostitWidget;
use ICS\DashboardBundle\Entity\Widget;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class DashboardController extends AbstractController
{
    /**
     * @Route("/add", name="dashboard-add")
     */
    public function add(Request $request, Environment $twig)
    {
        $class = $request->get('type');
        $dashboard = $request->get('dashboard');

        $widget = new $class($twig);

        $widget->setUserId($this->getUser()->getId());
        $widget->setDashboardName($dashboard);

        $em = $this->getDoctrine()->getManager();
        $em->persist($widget);
        $em->flush();

        if (is_a($widget, Widget::class)) {
            $response['html'] = $widget->getUi();
            $response['widget']['id'] = $widget->getId();
            $response['widget']['w'] = $widget->getWidth();
            $response['widget']['h'] = $widget->getHeight();
            $response['widget']['x'] = $widget->getX();
            $response['widget']['y'] = $widget->getY();

            $response['widget']['noresize'] = !$widget->getResize();

            $response['widget']['content'] = $widget->getUi();
            $response['js'] = $widget->getJs();

            dump($response);

            return new JsonResponse($response);
        } else {
            return new AccessDeniedHttpException('Unknow class '.$class);
        }
    }

    /**
     * @Route("/edit", name="dashboard-edit")
     */
    public function edit(Request $request)
    {
        $id = $request->get('id');
        $width = $request->get('w');
        $height = $request->get('h');
        $x = $request->get('x');
        $y = $request->get('y');

        $widget = $this->getDoctrine()->getRepository(Widget::class)->find($id);

        if (null != $widget) {
            $widget->setWidth($width);
            $widget->setHeight($height);
            $widget->setX($x);
            $widget->setY($y);
            $em = $this->getDoctrine()->getManager();
            $em->persist($widget);
            $em->flush();
        } else {
            return new NotFoundHttpException("Ce widget n'existe pas !");
        }

        return new Response('Ok');
    }

    /**
     * @Route("/remove", name="dashboard-remove")
     */
    public function remove(Request $request)
    {
        $id = $request->get('id');
        $widget = $this->getDoctrine()->getRepository(Widget::class)->find($id);
        if (null != $widget) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($widget);
            $em->flush();
        } else {
            return new NotFoundHttpException("Ce widget n'existe pas !");
        }

        return new Response('Ok');
    }

    /**
     * @Route("/config/{id}", name="dashboard-config")
     */
    public function config(Request $request, int $id = null)
    {
        $config = $this->getParameter('dashboard');

        $route = $request->get('route');
        $dashboardName = $request->get('dashboard');

        $widget = $this->getDoctrine()->getRepository(Widget::class)->find($id);

        $formType = $widget->getConfigForm();

        $form = $this->createForm($formType, $widget, [
            'action' => $this->generateUrl('dashboard-config', ['id' => $id]),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $widget = $form->getData();
            $route = $request->request->get('redirectRoute');
            $em = $this->getDoctrine()->getManager();
            $em->persist($widget);
            $em->flush();

            if ('' != $route) {
                return $this->redirectToRoute($route);
            }
        }

        return $this->render('@Dashboard/widgetForm.html.twig', [
            'form' => $form->createView(),
            'redirectRoute' => $route,
        ]);
    }

    /**
     * @Route("/postit/save", name="dashboard-postit-save")
     */
    public function postitsave(Request $request, int $id = null)
    {
        $texte = $request->get('texte');
        $id = $request->get('wid');

        $widget = $this->getDoctrine()->getRepository(PostitWidget::class)->find($id);
        $widget->setText($texte);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($widget);
        $em->flush();


        return new Response('Ok');
    }
}
