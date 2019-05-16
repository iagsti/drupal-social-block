<?php

namespace Drupal\social_block\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a social media block.
 *
 * @Block(
 *   id = "social_block",
 *   admin_label = @Translation("Social Block"),
 * )
 */

class SocialBlock extends BlockBase {
    /**
     * {@inheritdoc}
     */
    public function build()
    {
        $social = $this->getSocial();
        $markup = $this->getSocialContent($social);

        return [
            '#theme' => 'social_block',
            "#attached" => [
                'library' => [
                    'social_block/social_block'
                ]
            ],
            '#markup' => $markup,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function blockAccess(AccountInterface $account)
    {
        return AccessResult::allowedIfHasPermission($account, 'access content');
    }

    /**
    * {@inheritdoc}
    */
    public function blockForm($form, FormStateInterface $form_state) 
    {
        $config = $this->getConfiguration();

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function blockSubmit($form, FormStateInterface $form_state) 
    {
        $this->configuration['social_block_settings'] = $form_state->getValue('social_block_settings');
    }

    protected function getSocial()
    {
        $social['show_social_icon'] = theme_get_setting('show_social_icon');
        $social['facebook_url'] = theme_get_setting('facebook_url');
        $social['google_plus_url'] = theme_get_setting('google_plus_url');
        $social['twitter_url'] = theme_get_setting('twitter_url');
        $social['linkedin_url'] = theme_get_setting('linkedin_url');
        $social['pinterest_url'] = theme_get_setting('pinterest_url');
        $social['rss_url'] = theme_get_setting('rss_url');
        $social['youtube_url'] = theme_get_setting('youtube_url');

        return $social;

    }

    protected function getSocialContent($social)
    {   
        $html = "";

        if($social['show_social_icon']) {
            $html .= '<div class="social-block-media">';
            
            if(isset($social['facebook_url'])) {
                $html .= sprintf('<a href="%s" class="facebook" target="_blank"><i class="fab fa-facebook-f"></i></a>', $social['facebook_url']);
            }

            if(isset($social['google_plus_url'])) {
                $html .= sprintf('<a href="%s" class="google-plus" target="_blank"><i class="fab fa-google-plus-g"></i></a>', $social['google_plus_url']);
            }

            if($social['twitter_url']) {
                $html .= sprintf('<a href="%s" class="twitter" target="_blank"><i class="fab fa-twitter"></i></a>', $social['twitter_url']);
            }

            if($social['linkedin_url']) {
                $html .= sprintf('<a href="%s" class="linkedin" target="_blank"><i class="fab fa-linkedin-in"></i></a>', $social['linkedin_url']);
            }

            if($social['pinterest_url']) {
                $html .= sprintf('<a href="%s" class="pnterest" target="_blank"><i class="fab fa-pinterest"></i></a>', $social['pinterest_url']);
            }

            if($social['rss_url']) {
                $html .= sprintf('<a href="%s" class="facebook" target="_blank"><i class="fab fa-rss"></i></a>', $social['rss_url']);
            }

            if($social['youtube_url'])
            {
                $html .= sprintf('<a href="%s" class="youtube" target="_blank"><i class="fab fa-youtube"></i></a>', $social['youtube_url']);
            }

            $html .= '</div>';

            return $html;

        }

    }

  }