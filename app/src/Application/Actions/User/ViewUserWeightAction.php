<?php


namespace App\Application\Actions\User;


use Psr\Http\Message\ResponseInterface as Response;

class ViewUserWeightAction extends UserAction
{
    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        return $this->respondWithData('Weight page');
    }
}