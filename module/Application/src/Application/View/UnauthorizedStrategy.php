<?php

namespace Application\View;

use BjyAuthorize\View\UnauthorizedStrategy as BjyUnauthorizedStrategy;
use Zend\Http\Response as HttpResponse;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use BjyAuthorize\Guard\Controller;

class UnauthorizedStrategy extends BjyUnauthorizedStrategy
{

    public function onDispatchError(MvcEvent $event)
    {
        // Do nothing if the result is a response object
        $result = $event->getResult();
        $response = $event->getResponse();
        $request = $event->getRequest();

        if ($result instanceof Response || ($response && !$response instanceof HttpResponse)) {
            return;
        }

        // Common view variables
        $viewVariables = array(
            'error' => $event->getParam('error'),
            'identity' => $event->getParam('identity'),
        );

        switch ($event->getError()) {
            case Controller::ERROR:
                $viewVariables['controller'] = $event->getParam('controller');
                $viewVariables['action'] = $event->getParam('action');
                break;
            case Route::ERROR:
                $viewVariables['route'] = $event->getParam('route');
                break;
            case Application::ERROR_EXCEPTION:
                if (!($event->getParam('exception') instanceof UnAuthorizedException)) {
                    return;
                }

                $viewVariables['reason'] = $event->getParam('exception')->getMessage();
                $viewVariables['error'] = 'error-unauthorized';
                break;
            default:
                /*
                 * do nothing if there is no error in the event or the error
                 * does not match one of our predefined errors (we don't want
                 * our 403 template to handle other types of errors)
                 */

                return;
        }

        $response = $response ? : new HttpResponse();
        $response->setStatusCode(403);

        $acceptHeader = $request->getHeader('Accept')->getFieldValue();
        switch ($acceptHeader) {
            case 'application/json':
                $model = new JsonModel($viewVariables);
                $event->setViewModel($model);
                break;
            default:
                $model = new ViewModel($viewVariables);
                break;
        }
        $model->setTemplate($this->getTemplate());
        $event->getViewModel()->addChild($model);
        $event->setResponse($response);
    }

}