<?php
namespace Api\peopleIntegration;
require_once('../../vendor/autoload.php');

use RapidWeb\GoogleOAuth2Handler\GoogleOAuth2Handler;
use RapidWeb\GooglePeopleAPI\GooglePeople;
use RapidWeb\GooglePeopleAPI\Contact;  

use mysqli_sql_exception;
use Exception;
use mysqli;
use stdClass;

class GooglePeoPleIntegration {
    private const DATABASE = 'testes_php';
    private const HOST = 'localhost';
    private const PASSWORD = 'estudarmais';
    private const USER = 'root';

    private const CLIENT_ID = '10588927021-16tpm9r2l1mlvh0jlqvr8ar3i1126rla.apps.googleusercontent.com';
    private const CLIENT_SECRETS = 'Rvn4VogM4nbbh6gyEKhoTA1S';
    private const SCOPES =  ['https://www.googleapis.com/auth/userinfo.profile', 'https://www.googleapis.com/auth/contacts', 'https://www.googleapis.com/auth/contacts.readonly'];


    public function generateUrlConsentScreen() {
        $googleOAuth2Handler = new GoogleOAuth2Handler(self::CLIENT_ID, self::CLIENT_SECRETS, self::SCOPES);
        return $googleOAuth2Handler->authUrl;
    }

    private function getConnection() {
        return new mysqli(self::HOST, self::USER, self::PASSWORD, self::DATABASE);
    }

    private function getCodeReturnRefreshToken(string $code) {
        $googleOAuth2Handler = new GoogleOAuth2Handler(self::CLIENT_ID, self::CLIENT_SECRETS, self::SCOPES);
        $refresh_token = $googleOAuth2Handler->getRefreshToken($code);
        if (!isset($refresh_token)) {
            return json_encode(array(
                'code' => http_response_code(404),
                'msg' => "O codigo já foi validado e por isso não pode ser usado"
            ));
        }
        return $refresh_token;
    }
    public function createContact(string $lead_name, string $lead_email, string $lead_phone) {
        $refresh_token = $this->getToken();
        $googleOAuth2Handler = new GoogleOAuth2Handler(self::CLIENT_ID, self::CLIENT_SECRETS, self::SCOPES, $refresh_token['user_value']);
        $google_people = new GooglePeople($googleOAuth2Handler);
        $contact = new Contact($google_people);
        $contact->names[0] = new stdClass;
        // seta os parametros
        $contact->names[0]->givenName = $lead_name;
        $contact->emailAddresses[0]->value = $lead_email;
        $contact->phoneNumbers[0]->value = $lead_phone;
        $contact->save();
        return json_encode($contact);
    }


    private function getToken() {
        $banco = '';
        $response = '';
        try {
            $banco = $this->getConnection();
            $result = $banco->query('SELECT * FROM keyValue where id_user = "lead@email.com"');
            $response = $result->fetch_assoc();
            $result->close();
        } catch (\mysqli_sql_exception $eMysql) {
            return json_encode(array(
                'code' => http_response_code(404),
                'msg' => $eMysql->getMessage(),
                'file' => $eMysql->getFile()
            ));
        } catch (\Exception $e) {
            return json_encode(array(
                'code' => http_response_code(500),
                'msg' => $e->getMessage(),
                'file' => $e->getFile()
            ));
        } finally {
            $banco->close();
        }
        return $response;
    }

    public function salveToken(string $code) {
        $banco = '';
        $stmt = '';
        try {
            $id_user = 'lead@email.com';
            $key = 'token_google';
            $refresh_token = $this->getCodeReturnRefreshToken($code);
            $banco = $this->getConnection();
            $stmt = $banco->prepare('REPLACE INTO keyValue(id_user, user_key, user_value) VALUES(?, ?, ?)');
            $stmt->bind_param('sss', $id_user, $key,  $refresh_token);
            $stmt->execute();
        } catch (\mysqli_sql_exception $eMysql) {
            return json_encode(array(
                'code' => http_response_code(404),
                'msg' => $eMysql->getMessage(),
                'file' => $eMysql->getFile()
            ));
        } catch (\Exception $e) {
            return json_encode(array(
                'code' => http_response_code(500),
                'msg' => $e->getMessage(),
                'file' => $e->getFile()
            ));
        } finally {
            $stmt->close();
            $banco->close();
        }
    }

    
}
