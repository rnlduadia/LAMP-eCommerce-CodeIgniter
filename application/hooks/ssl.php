<?php

function redirect_ssl() {
    $CI = & get_instance();
    if ($CI->session->userdata('is_login') == TRUE) {
        // redirecting to HTTPS.
        if ($_SERVER['SERVER_PORT'] != 443) {
            $CI->config->config['base_url'] = str_replace('http://', 'https://', $CI->config->config['base_url']);
            redirect($CI->uri->uri_string());
        }
    } else {
        // redirecting to HTTP.
        if ($_SERVER['SERVER_PORT'] == 443) {
            $CI->config->config['base_url'] = str_replace('https://', 'http://', $CI->config->config['base_url']);
            redirect($CI->uri->uri_string());
        }
    }
}
