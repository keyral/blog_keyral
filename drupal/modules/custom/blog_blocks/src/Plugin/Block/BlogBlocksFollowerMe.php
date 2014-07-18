<?php

/**
 * @file
 * Contains \Drupal\block_example\Plugin\Block\ExampleConfigurableTextBlock.
 */

namespace Drupal\blog_blocks\Plugin\Block;

use Drupal\block\BlockBase;
use Drupal\block\Annotation\Block;
use Drupal\Core\Annotation\Translation;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a 'Example: configurable text string' block.
 *
 * @Block(
 *   id = "blocks_follower_me",
 *   subject = @Translation("Title of block follower Me (blocks_follower_me)"),
 *   admin_label = @Translation("Title of block follower Me (blocks_follower_me)")
 * )
 */
class BlogBlocksFollowerMe extends BlockBase
{

    /**
     * {@inheritdoc}
     */
    public function settings()
    {
        return array(
            'cache' => DRUPAL_NO_CACHE,
        );
    }

    /**
     * Overrides \Drupal\block\BlockBase::defaultConfiguration().
     */
    public function defaultConfiguration()
    {
        return array(
            'blocks_followed_me_twitter' => t('Url de twitter'),
            'blocks_followed_me_github' => t('Url du github'),
            'blocks_followed_me_google' => t('Url de google plus'),
        );
    }

    /**
     * Overrides \Drupal\block\BlockBase::blockForm().
     */
    public function blockForm($form, &$form_state)
    {
        $form['configuration'] = array(
            '#type' => 'fieldset',
            '#title' => t('Configuration'),
            '#weight' => 1,
            '#collapsible' => TRUE,
            '#collapsed' => TRUE,
        );


        $form['configuration']['blocks_followed_me_github'] = array(
            '#type' => 'textfield',
            '#title' => t('Url to followed github'),
            '#size' => 150,
            '#description' => t('url to github.'),
            '#default_value' => $this->configuration['blocks_followed_me_github'],
        );
        $form['configuration']['blocks_followed_me_twitter'] = array(
            '#type' => 'textfield',
            '#title' => t('Url to followed twitter'),
            '#size' => 150,
            '#description' => t('url to twitter.'),
            '#default_value' => $this->configuration['blocks_followed_me_twitter'],
        );
        $form['configuration']['blocks_followed_me_google'] = array(
            '#type' => 'textfield',
            '#title' => t('Url to followed google'),
            '#size' => 150,
            '#description' => t('url to google.'),
            '#default_value' => $this->configuration['blocks_followed_me_google'],
        );
        return $form;
    }

    /**
     * Overrides \Drupal\block\BlockBase::blockSubmit().
     */
    public function blockSubmit($form, &$form_state)
    {
        $this->configuration['blocks_followed_me_twitter'] = $form_state['values']['configuration']['blocks_followed_me_twitter'];
        $this->configuration['blocks_followed_me_github'] = $form_state['values']['configuration']['blocks_followed_me_github'];
        $this->configuration['blocks_followed_me_google'] = $form_state['values']['configuration']['blocks_followed_me_google'];
    }

    /**
     * Implements \Drupal\block\BlockBase::blockBuild().
     */
    public function build()
    {
        return array(
            '#theme' => 'follower_me',
            '#google' => $this->configuration['blocks_followed_me_google'],
            '#github' => $this->configuration['blocks_followed_me_github'],
            '#twitter' => $this->configuration['blocks_followed_me_twitter'],
            '#attached' => array(
                'css' => array(drupal_get_path('module', 'blog_blocks') . '/css/block_follower_me.css'),
            ),
        );
    }
}
