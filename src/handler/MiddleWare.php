<?php
namespace Api\Handler;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Security\JWT\Builder;
use Phalcon\Security\JWT\Signer\Hmac;
use Phalcon\Security\JWT\Token\Parser;
use Phalcon\Security\JWT\Validator;

class MiddleWare{
    public function getCustomer($jwt){
        if($jwt){
            try{
                $parser = new Parser();
                $tokenObject = $parser->parse($jwt);
                $now = new \DateTimeImmutable();
                $expires = $now->getTimestamp();
                $validator = new Validator($tokenObject,100);
                $validator->validateExpiration($expires);


                $claims = $tokenObject->getClaims()->getPayload();
                $role=$claims['sub'];
                return $role;
              }
             catch(\Exception $e){
             echo $e->getMessage();
             die;
            }
        }
    }
    public function accessToken($name){
        $signer  = new Hmac();
        $builder = new Builder($signer);
        $now        = new \DateTimeImmutable();
        $issued     = $now->getTimestamp();
        $notBefore  = $now->modify('-1 minute')->getTimestamp();
        $expires    = $now->modify('+1 day')->getTimestamp();
        $passphrase = 'QcMpZ&b&mo3TPsPk668J6QH8JA$&U&m2';
        // Setup
        $builder
            ->setAudience('localhost:8080')  // aud
            ->setContentType('application/json')        // cty - header
            ->setExpirationTime($expires)               // exp 
            ->setId('abcd123456789')                    // JTI id 
            ->setIssuedAt($issued)                      // iat 
            ->setIssuer('https://phalcon.io')           // iss 
            ->setNotBefore($notBefore)                  // nbf
            ->setSubject("customer")
            ->setSubject($name)   // sub
            ->setPassphrase($passphrase)                // password 
        ;
        $tokenObject = $builder->getToken();
        $token=$tokenObject->getToken();
        return $token;
    }
}