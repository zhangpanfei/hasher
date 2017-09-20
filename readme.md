# This is a rsa package


### example
```
use zpfei\hasher\Rsa;

$rsa = new Rsa(1024);
$keys = $rsa->createKeys();
$encode = Rsa::encode($keys['publicKey'],'hello word');

echo Rsa::decode($keys['privateKey'],$encode);
```