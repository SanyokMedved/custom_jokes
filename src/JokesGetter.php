<?php
namespace Drupal\custom_jokes;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class JokesGetter
 * @package Drupal\custom_jokes
 */
class JokesGetter {

  private $http_client;

  public function __construct(ClientInterface $http_client ) {
    $this->http_client = $http_client;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('http_client')
    );
  }

  /**
   * Get random joke from joke service.
   * @return mixed
   */
  public function getRandomJoke() {
    $client = $this->http_client;
    $request = $client->get( 'https://api.chucknorris.io/jokes/random');
    $response = json_decode($request->getBody()->getContents());

    return $response->value;
  }

}
