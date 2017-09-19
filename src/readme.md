#This is a rsa package


###example
```
$rsa = new Rsa(1024);
$keys = $rsa->createKeys();
$encode = Rsa::encode($keys['publicKey'],'hellp');

echo Rsa::decode($keys['privateKey'],$encode);
```