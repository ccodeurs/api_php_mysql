
<?php 
use Firebase\JWT\Key;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;

class JwtHandler {

    private $secret;
    private $expiry;
    private $iat;


    public function __construct() {

        $this->secret = SECRETE_JWT;
        $this->iat = time();
        $this->expiry =time() + (60*60*24);; //valido 1 dia
    }
/*-----------------------------------------------------------
    GENERAR TOKEN
-----------------------------------------------------------*/
    public function generateToken($data) {


        $payload = [
            'iat' =>  $this->iat,
            'exp' =>  $this->expiry,
            'data' => $data
        ];

        return JWT::encode($payload, $this->secret, 'HS256');
    }//END


/*-----------------------------------------------------------
    GENERAR TOKEN
-----------------------------------------------------------*/
    public function verifyToken($token) {

        return JWT::decode($token, new Key($this->secret, 'HS256'));
            
    } // END
}
