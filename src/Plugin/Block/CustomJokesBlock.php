<?php

namespace Drupal\custom_jokes\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\custom_jokes\JokesGetter;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Custom Jokes Block' Block.
 *
 * @Block(
 *   id = "custom_jokes_block",
 *   admin_label = @Translation("Custom Jokes Block"),
 *   category = @Translation("Custom Jokes Block"),
 * )
 */
class CustomJokesBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var JokesGetter jokes_getter
   */
  private $jokes_getter;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, JokesGetter $jokes_getter) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->jokes_getter = $jokes_getter;
  }

  /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param array $configuration
     * @param string $plugin_id
     * @param mixed $plugin_definition
     *
     * @return static
     */
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
      return new static(
        $configuration,
        $plugin_id,
        $plugin_definition,
        $container->get('jokes_getter')
      );
    }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $joke = $this->jokes_getter->getRandomJoke();
    $link = '<a class="use-ajax" href="/custom_jokes_update">New Joke</a>';
    return [
      '#markup' => $link . '<div id="joke_placeholder">'. $joke . '</div>',
      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }

}
