<?php 

$request = new HttpRequest();
$request->setUrl('https://developers.coinmarketcal.com/v1/events');
$request->setMethod(HTTP_METH_GET);
 $request->setQueryData(array(
      'max' => '10',
      'coins' => 'bitcoin'
));

 $request->setHeaders(array(
      'Accept' => 'application/json',
      'Accept-Encoding' => 'deflate, gzip',
      'x-api-key' => '5qBQz7wd2I4W7q7c9CGeD4y914grW9tH7fIP8lnA'
));

 try {
      $response = $request->send();
      echo $response->getBody();
} catch (HttpException $ex) {
      echo $ex;
} 
?>