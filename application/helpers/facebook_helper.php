<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('facebook_send_item'))
{
    function facebook_send_item($params = array())
    {
        //super user
        $ci =& get_instance();

        if (count($params) <= 0 )
        {
            log_message('error', 'facebook_send_item için yeterli veri girilmemiş..!');
            return FALSE;
        }

        //helperler
        $ci->load->helper('file');

        //önce tokenı alıyoruz..
        $token = ayar_getir('facebook_access_token');

        if ($token)
        {
            //param'a token'ı ekleyelim
            $params['access_token'] = $token;

            //facebook clasını load ettik
            include APPPATH.'../facebook/facebook.php';

            $fb_config = $ci->config->item('facebook');

            //ayarlar
            $config = array(
                'appId' => $fb_config['app_id'],
                'secret' => $fb_config['app_secret'],
                'allowSignedRequest' => false // optional but should be set to false for non-canvas apps
            );

            //class
            $facebook = new Facebook($config);

            $ci->load->library('Curl');
            $status = $ci->curl->getir('https://graph.facebook.com/'. $fb_config['page_id'] .'/feed', $params );

            if ($status)
            {
                log_message('error', 'facebook_send_item durum mesajı: '. $status);
                return TRUE;
            }
            else
            {
                log_message('error', 'facebook_send_item durum mesajı: '. $status);
                return $status;
            }

        }
        else
        {
            log_message('error', 'facebook_send_item access token hatası: '. $token);
            return FALSE;
        }

    }
}