<?php

/**
 * @file
 * Contains \Drupal\block_example\Plugin\Block\ExampleConfigurableTextBlock.
 */

namespace Drupal\blog_blocks\Plugin\Block;

use Drupal\block\Annotation\Block;
use Drupal\block\BlockBase;
use Drupal\Core\Annotation\Translation;

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
	 * Overrides \Drupal\block\BlockBase::defaultConfiguration().
	 */
	public function defaultConfiguration()
	{
		return array(
			'blocks_followed_me_twitter' => t('mon premier petit test', array('%time' => date('c'))),
		);
	}

	/**
	 * Overrides \Drupal\block\BlockBase::blockForm().
	 */
	public function blockForm($form, &$form_state)
	{
		$form['blocks_followed_me_twitter'] = array(
			'#type' => 'textfield',
			'#title' => t('Url to followed twitter'),
			'#size' => 200,
			'#description' => t('Information to twitter'),
			'#default_value' => $this->configuration['blocks_followed_me_twitter'],
		);
		$form['blocks_followed_me_github'] = array(
			'#type' => 'textfield',
			'#title' => t('Url to followed github'),
			'#size' => 200,
			'#description' => t('url to github.'),
			'#default_value' => $this->configuration['blocks_followed_me_github'],
		);
		return $form;
	}

	/**
	 * Overrides \Drupal\block\BlockBase::blockSubmit().
	 */
	public function blockSubmit($form, &$form_state)
	{
		$this->configuration['blocks_followed_me_twitter'] = $form_state['values']['blocks_followed_me_twitter'];
		$this->configuration['blocks_followed_me_github'] = $form_state['values']['blocks_followed_me_github'];
	}

	/**
	 * Implements \Drupal\block\BlockBase::blockBuild().
	 */
	public function build()
	{
		var_dump($this);
		die('lol');
		$information = array(
			'#type' => 'markup',
			'#markup' => $this->configuration['blocks_followed_me_twitter'],
		);
	}

}
