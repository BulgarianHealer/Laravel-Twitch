<?php

namespace bulgarianhealer\Twitch\Concerns\Api;

use bulgarianhealer\Twitch\Concerns\Operations\AbstractOperationsTrait;
use bulgarianhealer\Twitch\Enums\GrantType;
use bulgarianhealer\Twitch\Result;

trait OAuthTrait
{
    use AbstractOperationsTrait;

    /**
     * Get OAuth authorize url.
     *
     * @see  https://dev.twitch.tv/docs/authentication/getting-tokens-oauth/
     *
     * @param string $responseType code / token
     * @param array $scopes
     * @param string|null $state
     * @param bool $forceVerify
     * @return string
     */
    public function getOAuthAuthorizeUrl(string $responseType = 'code', array $scopes = [], string $state = null, bool $forceVerify = false): string
    {
        $query = [
            'response_type' => $responseType,
            'client_id' => $this->getClientId(),
            'scope' => $this->buildScopes($scopes),
            'redirect_uri' => $this->getRedirectUri(),
        ];

        if ($state !== null) {
            $query['state'] = $state;
        }

        if ($forceVerify === true) {
            $query['force_verify'] = 'true';
        }

        return self::OAUTH_BASE_URI . 'authorize?' . http_build_query($query);
    }

    /**
     * Get an access token based on the OAuth code flow.
     *
     * @see  https://dev.twitch.tv/docs/authentication/getting-tokens-oauth/#oauth-authorization-code-flow
     *
     * @param string|null $code
     * @param string $grantType
     * @param array $scopes
     * @return \bulgarianhealer\Twitch\Result
     */
    public function getOAuthToken(?string $code = null, string $grantType = GrantType::AUTHORIZATION_CODE, array $scopes = []): Result
    {
        $parameters = [
            'grant_type' => $grantType,
            'client_id' => $this->getClientId(),
            'client_secret' => $this->getClientSecret(),
        ];

        if ($grantType === GrantType::AUTHORIZATION_CODE) {
            $parameters['redirect_uri'] = $this->getRedirectUri();
        }

        if ($code !== null) {
            $parameters['code'] = $code;
        }

        if ( ! empty($scopes)) {
            $parameters['scope'] = $this->buildScopes($scopes);
        }

        return $this->post(self::OAUTH_BASE_URI . 'token', $parameters);
    }

    /**
     * Build OAuth scopes to string.
     *
     * @param array $scopes
     * @return string
     */
    protected function buildScopes(array $scopes): string
    {
        return implode(' ', $scopes);
    }
}
