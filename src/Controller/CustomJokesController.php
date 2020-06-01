<?php

namespace Drupal\custom_jokes\Controller;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\custom_jokes\JokesGetter;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CustomJokesController
 *
 * @package Drupal\custom_jokes\Controller
 */
class CustomJokesController extends ControllerBase{

  /**
   * @var \Drupal\custom_jokes\JokesGetter jokes_getter
   */
  private $jokes_getter;

  public function __construct(JokesGetter $jokes_getter) {
    $this->jokes_getter = $jokes_getter;
  }

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *
   * @return static
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('jokes_getter')
    );
  }
  /**
   * @return \Drupal\Core\Ajax\AjaxResponse
   */
  public function jokeUpdate() {

    $joke = $this->jokes_getter->getRandomJoke();
    $joke = '<div id="joke_placeholder">' . $joke . '</div>';
    $response = new AjaxResponse();
    $response->addCommand(new ReplaceCommand('#joke_placeholder', $joke));

    return $response;

  }

}
