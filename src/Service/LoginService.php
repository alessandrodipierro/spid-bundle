<?php

namespace Links\Bundle\SpidBundle\Service;

use Exception;
use Italia\Spid\Sp;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class LoginService
{
    private readonly Sp $spid;

    public function __construct(Sp $spid)
    {
        $this->spid = $spid;
    }

    public function GetMetadata()
    {
        return $this->spid->getSPMetadata();
    }

    public function ChooseIdP(): array
    {
        return [];
    }

    public function Login($idp)
    {
        if (!$idp) {
            throw new BadRequestHttpException('Missing the idp parameter');
        }
        /**
         * FIXME: waiting for upstream to fix the issue in the library
         */
        if (!@$this->spid->login($idp, 0, 1)) {
            return new Response('Already logged in');
        }
    }

    public function getAcs()
    {
        if ($this->spid->isAuthenticated()) {
            return ['attributes' => $this->spid->getAttributes()];
        }
    }

    /**
     * @throws Exception
     */
    public function singleLogout()
    {
        throw new Exception('Uninmplemented');
    }
}
