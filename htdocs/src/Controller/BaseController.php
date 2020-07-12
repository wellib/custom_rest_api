<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class BaseController
{

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array
     */
    public function getRequest(Request $request): ?array
    {
        if ($request->getContentType() !== 'json' || !$request->getContent()) {
            throw new BadRequestHttpException('Bad Request');
        }

        $data = json_decode($request->getContent(), true);
        if (!is_array($data)) {
            throw new BadRequestHttpException('Bad Json Format');
        }

        return $data;
    }

}
