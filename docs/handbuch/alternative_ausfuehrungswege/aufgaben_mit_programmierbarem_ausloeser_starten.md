# Aufgaben mit programmierbarem Auslöser starten

Wenn die bestehenden Auslöser nicht Ihre Anforderungen erfüllen, können Sie in der [Premium-Edition](../../editionen.md) 
des Moduls programmierbare Auslöser verwenden.

Aktivieren Sie dazu an den betreffenden Aufgaben diesen Auslöser und vergeben Sie einen passenden Ereignisnamen (z.B. "order_changed").

An der dazu passenden Codestelle im Shop integrieren Sie den programmierbaren Auslöser nach diesem Beispiel. Nutzen Sie 
dafür die Möglichkeiten der modularen Erweiterungen:

```
$eventDispatcher = \OxidEsales\EshopCommunity\Internal\Container\ContainerFactory::getInstance()
  ->getContainer()->get( EventDispatcherInterface::class );
$event           = oxNew(
    \D3\Ordermanager\Application\Model\Events\CustomEvent::class,
    'order_changed',
    $order
);
$eventDispatcher->dispatch( $event );
```

Mit Ausführung dieses Codes werden alle Aufgaben mit dem passend eingestellten Auslöser gefunden und auf die übergebene
Bestellung angewandt.
