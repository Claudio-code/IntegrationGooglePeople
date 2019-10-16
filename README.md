# Integração com Google People



## Mostrar como integrar e interagir com a lib de integração do google people 

<P> Para usar as apis do google você precisa entrar no console do google e criar uma conta de dev </p>
<p>nesse link: https://console.developers.google.com/apis/dashboard </p>
<p> Apos criar as credenciais você pode setar nas constantes da classe o client-id e o client-secrets</p>
<p> E no escopo ja vai estar definido todas as credencias para permitir o acesso. </p>
<strong>---------------------------------------------------------------------------------------------------------</strong>
<br>
<p>Agora basta instanciar a classe e gerar a url da tela de consentimento.</p>
<h6>Exemplo:</h6> 
<p>
    $people = new GooglePeoPleIntegration(); <br>
    $people->generateUrlConsentScreen(); 
</p>
<small>---------------------------------------------------------------------------------------------------------</small>
<p> Esse link apos o usuario aceitar vai gerar um token  </p>
<p>Apos o token ser gerado chame esse metodo. </p>
<p>$people->salveToken($token);</p>

<small>---------------------------------------------------------------------------------------------------------</small>

<h6>Agora vem a parte divertida, basta chamar o metodo de criar o contato.</h6>
<p>Exemplo:  $people->createContact("name_lead", 'lead@email.com', '419998252839');</p>
