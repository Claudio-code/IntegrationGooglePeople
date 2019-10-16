# Integração com Google People
_____________________________


## Mostrar como integrar e interagir com a lib do google people.

Para usar as apis do google você precisa entrar no console do google e criar uma conta de dev  <br>
```
nesse link: https://console.developers.google.com/apis/dashboard. 
```
 Apos criar as credenciais você pode setar nas constantes da classe o client-id e o client-secrets
 E no escopo ja vai estar definido todas as credencias para permitir o acesso. 
Agora basta instanciar a classe e gerar a url da tela de consentimento.
<br>

### Exemplo: 

```
    $people = new GooglePeoPleIntegration();
    $people->generateUrlConsentScreen(); 
```

Esse link apos o usuario aceitar vai gerar um token
Apos o token ser gerado chame esse metodo. 
```
$people->salveToken($token);
```
### Agora vem a parte divertida, basta chamar o metodo de criar o contato.
```
 $people->createContact("name_lead", 'lead@email.com', '419998252839');
```
