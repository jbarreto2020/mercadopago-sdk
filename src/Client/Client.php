<?php

declare(strict_types=1);

/*
 * This file is part of gpupo/mercadopago-sdk
 * Created by Gilmar Pupo <contact@gpupo.com>
 * For the information of copyright and license you should read the file
 * LICENSE which is distributed with this source code.
 * Para a informação dos direitos autorais e de licença você deve ler o arquivo
 * LICENSE que é distribuído com este código-fonte.
 * Para obtener la información de los derechos de autor y la licencia debe leer
 * el archivo LICENSE que se distribuye con el código fuente.
 * For more information, see <https://opensource.gpupo.com/>.
 *
 */

namespace Gpupo\MercadopagoSdk\Client;

use Gpupo\CommonSdk\Client\ClientAbstract;
use Gpupo\CommonSdk\Client\ClientInterface;
use Gpupo\CommonSchema\ArrayCollection\Application\API\OAuth\Client\AccessToken;

final class Client extends ClientAbstract implements ClientInterface
{
    /**
     * @codeCoverageIgnore
     */
    public function getDefaultOptions()
    {
        $domain = 'api.mercadopago.com';

        return [
            'client_id' => false,
            'client_secret' => false,
            'access_token' => false,
            'user_id' => false,
            'refresh_token' => false,
            'users_url' => sprintf('https://%s/users', $domain),
            'base_url' => sprintf('https://%s', $domain),
            'oauth_url' => sprintf('https://%s/oauth', $domain),
            'verbose' => true,
            'cacheTTL' => 3600,
            'offset' => 0,
            'limit' => 30,
        ];
    }

    public function requestToken()
    {
        $pars = [
          'grant_type' => 'client_credentials',
          'client_id' => $this->getOptions()->get('client_id'),
          'client_secret' => $this->getOptions()->get('client_secret'),
        ];

        $this->setMode('form');
        $request = $this->post($this->getOauthUrl('/token'), $pars);
        $accessToken = $request->getData(AccessToken::class);

        return $accessToken;
    }

    protected function renderAuthorization()
    {
        $list = [];

        return $list;
    }

    protected function getOauthUrl($path)
    {
        return $this->getOptions()->get('oauth_url').$path;
    }
}