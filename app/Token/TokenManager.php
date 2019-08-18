<?php

namespace App\Token;

use App\Token;
use GuzzleHttp\Client;

class TokenManager
{
    public function checkToken(string $access_token):bool
    {
        $token = $this->getLocalToken($access_token);

        if (!$token){
            $token = $this->makeLocalToken($access_token);
            return $this->verifyTokenRemotelyAndSaveResult($token);
        }

        if ($token->revoked_at){
            return false;
        }
        if ($token->checkedWithinFiveMinutes()){
            return true;
        }

        return $this->verifyTokenRemotelyAndSaveResult($token);
    }

    public function verifyTokenRemotely(string $access_token):bool
    {
        $client = new Client();
        $response = $client->request('GET','https://www.lanree.com/api/admin/is',[
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $access_token,
            ],
            'http_errors' => false
        ]);
        return $response->getStatusCode() === 200;
    }

    protected function verifyTokenRemotelyAndSaveResult(Token $token):bool
    {
        $result = $this->verifyTokenRemotely($token->access_token);
        $this->saveRemoteVerificationResult($token, $result);
        return $result;
    }

    protected function saveRemoteVerificationResult(Token $token, bool $result):void
    {
        $currentTime = currentTime();
        if ($result){
            $token->checked_at = $currentTime;
            $token->save();
            return;
        }

        $token->checked_at = $currentTime;
        $token->revoked_at = $currentTime;
        $token->save();
    }

    protected function getLocalToken(string $access_token): ?Token
    {
        return Token::where('md5_access_token',md5($access_token))->first();
    }

    protected function makeLocalToken(string $access_token): ?Token
    {
        $token = new Token;
        $token->access_token = $access_token;
        $token->md5_access_token = md5($access_token);
        return $token;
    }

}
